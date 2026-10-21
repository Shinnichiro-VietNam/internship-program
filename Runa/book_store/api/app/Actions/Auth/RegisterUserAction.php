<?php

namespace App\Actions\Auth;

use App\Models\User;
use App\Data\Auth\AuthTokenData;

final class RegisterUserAction
{
    public function handle(array $data): AuthTokenData
    {
        $user = User::create($data);
        return new AuthTokenData(
            token: $user->createToken('auth_token')->plainTextToken,
        );
    }
}