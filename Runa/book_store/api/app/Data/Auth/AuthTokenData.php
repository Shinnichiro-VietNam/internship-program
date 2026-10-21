<?php

namespace App\Data\Auth;

use Spatie\LaravelData\Data;

class AuthTokenData extends Data
{
    public function __construct(
        public string $token,
        public string $token_type = 'Bearer',
    ) {}
}