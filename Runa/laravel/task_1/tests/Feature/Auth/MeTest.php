<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MeTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_user_endpoint(): void
    {
        $response = $this->getJson('/api/user');

        $response->assertStatus(401)
            ->assertJsonPath('errors.code', 'UNAUTHORIZED');
    }

    public function test_authenticated_user_can_access_user_endpoint(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'me@example.com',
        ]);
        $this->actingAs($user, 'sanctum');

        $response = $this->getJson('/api/user');

        $response->assertStatus(200)
            ->assertJsonPath('data.email', 'me@example.com')
            ->assertJsonPath('data.name', 'Test User');
    }
}
