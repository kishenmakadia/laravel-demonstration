<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login()
    {
        if (filter_var(request()->get('username'), FILTER_VALIDATE_EMAIL)) {
            $type = 'email';
        } else {
            $type = 'phone';
        }

        $credentials = [$type => request()->get('username'), 'password' => request()->get('password')];
        if (auth()->attempt($credentials)) {
            // we want user to logout from all other places
            // so deleting all the tokens
            auth()->user()->tokens()->delete();

            // Authentication passed...
            return response()->json([
                'message' => 'Login success.',
                'data' => [
                    'user' => auth()->user(),
                    // generating a new access token
                    'token' => auth()->user()->createToken('api')->plainTextToken
                ]
            ], 200);
        }

        throw ValidationException::withMessages([
            $type => ['The provided credentials are incorrect.'],
        ]);
    }

    public function register()
    {
        request()->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|numeric|digits:10|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create(request()->only('first_name', 'last_name', 'email', 'phone') + [
            'type' => 'user',
            'password' => Hash::make(request()->password),
        ]);

        return  response()->json(['message' => 'Registration successful'], 200);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return  response()->json(['message' => 'Logout successful.'], 200);
    }
}
