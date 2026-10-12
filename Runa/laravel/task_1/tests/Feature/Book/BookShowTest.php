<?php

namespace Tests\Feature\Book;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_show_a_book(): void
    {
        $book = Book::factory()->create([
            'title' => 'Visible Book',
            'author' => 'Author Name',
        ]);

        $response = $this->getJson("/api/books/{$book->book_id}");

        $response->assertStatus(200)
            ->assertJsonPath('status', 200)
            ->assertJsonPath('data.title', 'Visible Book')
            ->assertJsonPath('data.author', 'Author Name');
    }

    public function test_show_unknown_book_returns_not_found(): void
    {
        $response = $this->getJson('/api/books/999999');

        $response->assertStatus(404)
            ->assertJsonPath('errors.code', 'NOT_FOUND');
    }
}
