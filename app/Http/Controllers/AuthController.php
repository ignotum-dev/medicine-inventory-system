<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Services\AuthorizationLogger;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password'=> 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.']
            ]);
        }

        if (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.']
            ]);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        AuthorizationLogger::log('User logged in', auth()->user(), ['ip' => $request->ip()], $token);

        return response()->json([
            'token' => $token
        ]);
    }

    public function logout(Request $request, User $user) {
        // Retrieve the token associated with the user
        $tokens = $request->user()->tokens;

        // Assuming you want to log the first token's ID, or any specific token
        $token = $tokens->first() ? $tokens->first()->id : null;

        // Delete the user's tokens
        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });

        AuthorizationLogger::log('User logged out', auth()->user(), ['ip' => $request->ip()], $token);

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}
