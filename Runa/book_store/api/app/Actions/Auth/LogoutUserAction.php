<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

final class LogoutUserAction
{
    public function handle(): void
    {
        Auth::user()->currentAccessToken()->delete();
    }
}