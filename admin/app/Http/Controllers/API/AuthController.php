<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\User\RegisterRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'role_id' => 2,
            'password' => Hash::make($request->input('password'))
        ]);
        return response()->json([
            'user' => $user,
            'access_token' => $user->createToken(time())->plainTextToken
        ], 200);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (Auth::attempt($credentials)) {
            if ($request->user()->role_id !== 2) {
                return response()->json([], 403);
            }

            $user = User::firstWhere('email', $request->email);

            return response()->json([
                'user' => $user,
                'access_token' => $user->createToken(time())->plainTextToken
            ]);
        } else {
            return response()->json([
                'status' => 'Login failed',
                'message' => 'The credentials do not match our record!'
            ]);
        }
    }
}
