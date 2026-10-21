<?php

namespace App\Actions\Auth;

use App\Data\Auth\AuthTokenData;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Hash;

final class LoginUserAction
{
    public function handle(array $data): AuthTokenData
    {
        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            throw new AuthenticationException('Invalid credentials.');
        }

        return new AuthTokenData(
            token: $user->createToken('auth_token')->plainTextToken,
        );
    }
}