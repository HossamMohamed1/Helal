<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!auth()->attempt($data)) {
            return response()->json([
                'status' => false,
                'message' => 'Email & Password does not match with our record.',
            ], 400);
        }

        $user = User::where('email', $request->email)->first();

        return response()->json([
            'message' => 'User Logged In Successfully',
            'token' => $user->createToken("API TOKEN")->plainTextToken,
            'user' => $user,
        ], 200);
    }

    public function user()
    {
        $user = User::find(auth()->id());
        $user->load([
            'roles',
            'permissions',
        ]);
        return response()->json([
            'user' => $user,
        ]);
    }

    public function logout()
    {
        $user = User::find(auth()->id());
        $user->tokens()->where('id', auth()->user()->currentAccessToken()->id)->delete();
        return response()->json([
            'message' => 'User Logged Out Successfully',

        ], 200);
    }
}