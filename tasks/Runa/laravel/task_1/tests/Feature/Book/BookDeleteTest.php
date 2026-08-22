<?php

namespace Tests\Feature\Book;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_delete_a_book(): void
    {
        $book = Book::factory()->create();

        $response = $this->deleteJson("/api/books/{$book->book_id}");

        $response->assertStatus(401)
            ->assertJsonPath('errors.code', 'UNAUTHORIZED');

        $this->assertDatabaseHas('books', ['book_id' => $book->book_id]);
    }

    public function test_reader_cannot_delete_a_book(): void
    {
        $this->actingAsReader();
        $book = Book::factory()->create();

        $response = $this->deleteJson("/api/books/{$book->book_id}");

        $response->assertStatus(403)
            ->assertJsonPath('errors.code', 'FORBIDDEN');

        $this->assertDatabaseHas('books', ['book_id' => $book->book_id]);
    }

    public function test_admin_can_delete_a_book(): void
    {
        $this->actingAsAdmin();
        $book = Book::factory()->create();

        $response = $this->deleteJson("/api/books/{$book->book_id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('books', ['book_id' => $book->book_id]);
    }

    public function test_admin_delete_unknown_book_returns_not_found(): void
    {
        $this->actingAsAdmin();

        $response = $this->deleteJson('/api/books/999999');

        $response->assertStatus(404)
            ->assertJsonPath('errors.code', 'NOT_FOUND');
    }
}
