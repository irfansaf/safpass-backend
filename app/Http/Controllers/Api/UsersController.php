<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function show(Request $request, $id) {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $user
        ], 200);
    }

    public function update(Request $request, $id) {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $fieldsToUpdate = $request->only('username', 'first_name', 'last_name', 'email', 'password');

        if (isset($fieldsToUpdate['password'])) {
            $fieldsToUpdate['password'] = Hash::make($fieldsToUpdate['password']);
        }

        $user->fill($fieldsToUpdate);
        $user->save();

        return response()->json(['message' => 'User updated successfully']. 200);
    }
}
