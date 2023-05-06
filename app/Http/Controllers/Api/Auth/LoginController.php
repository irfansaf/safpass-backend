<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function login(Request $request) {
        Log::info('Request data: ', $request->all());

        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        $fieldType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $credentials = [
            $fieldType => $request->login,
            'password' => $request->password
        ];

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid email/username or password'], 401);
        }

        $user = $request->user();
        $token = $user->createToken('Personal Access Token');

        return response()->json([
            'user_id' => $user->id,
            'access_token' => $token->plainTextToken,
            'token_type' => 'Bearer',
        ]);
    }
}
