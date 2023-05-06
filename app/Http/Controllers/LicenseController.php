<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\License;

class LicenseController extends Controller
{
    public function generatePurchaseCode(Request $request)
    {
        $request->validate([
            'validity' => 'nullable|integer|min:1',
        ]);

        $validityInMonths = $request->input('validity');
        $expiresAt = $validityInMonths ? now()->addMonths($validityInMonths) : null;

        $purchaseCode = new License;
        $purchaseCode->purchase_code = $this->generateUniquePurchaseCode();
        $purchaseCode->expires_at = $expiresAt;
        $purchaseCode->save();

        return response()->json(['message' => 'Purchase code generated successfully', 'purchase_code' => $purchaseCode->purchase_code, 'expires_at' => $purchaseCode->expires_at], 201);
    }

    public function validateLicense(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|string',
            'purchase_code' => 'required|string',
        ]);

        $purchase_code = License::where('purchase_code', $request->purchase_code)->first();

        if (!$purchase_code) {
            return response()->json(['error' => 'Invalid purchase code'], 400);
        }

        if ($purchase_code->user_id) {
            return response()->json(['error', 'Purchase code is already linked to another account'], 400);
        }

        /**
         * check if $expires_at is an instance of Carbon, and if it's not,
         * we convert it to a Carbon instance using Carbon::parse() method.
         *
         * Finally, we call the isPast() function on the $expires_at variable to check if the purchase code has expired.
         */
        if ($purchase_code->expires_at) {
            $expires_at = $purchase_code->expires_at;
            if (!($expires_at instanceof Carbon)) {
                $expires_at = Carbon::parse($expires_at);
            }
            if ($expires_at->isPast()) {
                return response()->json(['error' => 'Purchase code has expired'], 400);
            }
        }

        if (!$purchase_code->activated) {
            $purchase_code->update([
                'activated' => true,
                'user_id' => $validated['user_id'],
            ]);

            $purchase_code->activation_date = now();

            // Calculate the new expiration date based on the validity period
            $validityInMonths = $purchase_code->expires_at ? now()->diffInMonths($purchase_code->expires_at) : null;
            $purchase_code->expires_at = $validityInMonths ? now()->addMonths($validityInMonths) : null;

            $purchase_code->save();
        }

        return response()->json(['message' => 'Purchase code successfully validated and activated'], 200);
    }

    private function generateUniquePurchaseCode($length = 16)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
