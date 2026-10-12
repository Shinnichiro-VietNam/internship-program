<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_with_valid_body_creates_user_and_returns_token(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => 'New Reader',
            'email' => 'newreader@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('status', 201)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => ['token', 'token_type'],
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'newreader@example.com',
            'role' => 'reader',
        ]);
    }

    public function test_register_with_duplicate_email_returns_bad_request(): void
    {
        User::factory()->create(['email' => 'taken@example.com']);

        $response = $this->postJson('/api/register', [
            'name' => 'Another User',
            'email' => 'taken@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(400)
            ->assertJsonPath('errors.code', 'BAD_REQUEST')
            ->assertJsonFragment(['field' => 'email']);
    }

    public function test_register_with_short_password_returns_bad_request(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Short Pass',
            'email' => 'short@example.com',
            'password' => 'short',
        ]);

        $response->assertStatus(400)
            ->assertJsonPath('errors.code', 'BAD_REQUEST')
            ->assertJsonFragment(['field' => 'password']);
    }
}
