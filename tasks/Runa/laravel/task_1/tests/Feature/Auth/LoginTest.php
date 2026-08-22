<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_with_correct_credentials_returns_token(): void
    {
        User::factory()->create([
            'email' => 'reader@example.com',
            'password' => 'password123',
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'reader@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('status', 200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => ['token', 'token_type'],
            ]);
    }

    public function test_login_with_wrong_password_returns_bad_request(): void
    {
        User::factory()->create([
            'email' => 'reader@example.com',
            'password' => 'password123',
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'reader@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(400)
            ->assertJsonPath('message', 'Invalid credentials.')
            ->assertJsonPath('errors.code', 'BAD_REQUEST');
    }
}
