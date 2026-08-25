<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    protected function actingAsReader(): User
    {
        $user = User::factory()->create(['role' => 'reader']);
        Sanctum::actingAs($user);

        return $user;
    }

    protected function actingAsAdmin(): User
    {
        $user = User::factory()->admin()->create();
        Sanctum::actingAs($user);

        return $user;
    }
}
