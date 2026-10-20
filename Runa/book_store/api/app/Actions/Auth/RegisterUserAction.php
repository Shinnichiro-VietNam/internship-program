<?php

namespace App\Actions\Auth;

use App\Models\User;

final class RegisterUserAction
{
    public function handle(array $data): array
    {
        $user = User::create($data);
        $token = $user->createToken('auth_token')->plainTextToken;
        return [
            'token' => $token,
            'token_type' => 'Bearer',
        ];
    }
}