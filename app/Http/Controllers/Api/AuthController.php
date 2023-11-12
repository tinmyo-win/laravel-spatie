<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;

class AuthController extends Controller
{
    public function login(Request $request) {
        $email = $request->email ?? null;
        $password = $request->password ?? null;

        $crenditials = [
            'email' => $email,
            'password' => $password,
        ];

        $user = User::where('email', $email)->first();
        if(!$user) {
            return response(['message' => 'User Not Found'], 404);
        }

        if(!Auth::attempt($crenditials)) {
            return response(['message' => 'Password Incorrect Please Try Again'], 400);
        }

        $token = $user->createToken('test_token');

        return response(['token' => $token->plainTextToken]);
    }
}
