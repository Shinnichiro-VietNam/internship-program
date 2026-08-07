<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ユーザー登録
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => $validated['password'],
            'role'     => 'reader',
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->httpCreated([
            'token'      => $token,
            'token_type' => 'Bearer',
        ]);
    }

    // ログイン
    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

        $user = User::where('email', $validated['email'])->first();

        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            return $this->httpBadRequest(
                ['code' => 'BAD_REQUEST'],
                'Invalid credentials.'
            );
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->httpOk([
            'token'      => $token,
            'token_type' => 'Bearer',
        ]);
    }

    // ログアウト
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->httpNoContent();
    }

    // 現在のユーザー情報
    public function me(Request $request)
    {
        $user = $request->user();

        return $this->httpOk([
            'id'    => $user->id,
            'name'  => $user->name,
            'email' => $user->email,
        ]);
    }
}
