<?php

namespace App\Data\Auth;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Attributes\MapName;

#[MapName(SnakeCaseMapper::class)]
class AuthTokenData extends Data
{
    public function __construct(
        public string $token,
        public string $tokenType = 'Bearer',
    ) {}
}