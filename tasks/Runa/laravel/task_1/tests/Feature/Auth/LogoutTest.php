<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_logout_deletes_the_access_token(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token');

        $this->withToken($token->plainTextToken)
            ->postJson('/api/logout')
            ->assertStatus(204);

        $this->assertDatabaseMissing('personal_access_tokens', [
            'id' => $token->accessToken->id,
        ]);
    }
}
