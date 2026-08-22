<?php

namespace Tests\Feature\Book;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookStoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_create_a_book(): void
    {
        $response = $this->postJson('/api/books', [
            'title' => 'Clean Code',
            'author' => 'Robert C. Martin',
            'price' => 3800,
        ]);

        $response->assertStatus(401)
            ->assertJsonPath('errors.code', 'UNAUTHORIZED');

        $this->assertDatabaseMissing('books', ['title' => 'Clean Code']);
    }

    public function test_authenticated_user_can_create_a_book(): void
    {
        $this->actingAsReader();

        $response = $this->postJson('/api/books', [
            'title' => 'Clean Code',
            'author' => 'Robert C. Martin',
            'price' => 3800,
        ]);

        $response->assertStatus(201)
            ->assertHeader('Location')
            ->assertJsonPath('status', 201)
            ->assertJsonPath('data.title', 'Clean Code')
            ->assertJsonPath('data.author', 'Robert C. Martin')
            ->assertJsonPath('data.price', 3800);

        $this->assertDatabaseHas('books', [
            'title' => 'Clean Code',
            'author' => 'Robert C. Martin',
        ]);
    }
}
