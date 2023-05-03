<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseCode;

class PurchaseCodeController extends Controller
{
    public function validatePurchaseCode(Request $request) {
        $validated = $request->validate([
            'purchase_code' => 'required|string',
        ]);

        $purchase_code = PurchaseCode::where('purchase_code', $validated['purchase_code'])->first();

        if (!$purchase_code) {
            return response()->json(['error' => 'Invalid purchase code'], 400);
        }

        if ($purchase_code->activated) {
            return response()->json(['error' => 'Purchase code already activated'], 400);
        }

        $purchase_code->update([
            'activated' => true,
            'activation_date' => now(),
        ]);

        return response()->json(['message' => 'Purchase code successfully validated and activated'], 200);
    }
}
