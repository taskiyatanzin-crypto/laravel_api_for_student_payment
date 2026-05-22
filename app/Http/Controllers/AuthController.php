<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return response()->json([
            'message' => 'User not found'
        ], 401);
    }

    if (!Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => 'Invalid password'
        ], 401);
    }

    $token = $user->createToken('auth')->plainTextToken;

    return response()->json([
        'token' => $token,
        'user' => $user
    ]);
}
