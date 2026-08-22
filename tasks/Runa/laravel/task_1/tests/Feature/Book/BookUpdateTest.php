<?php

namespace Tests\Feature\Book;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_update_a_book(): void
    {
        $book = Book::factory()->create(['title' => 'Old Title']);

        $response = $this->putJson("/api/books/{$book->book_id}", [
            'title' => 'New Title',
            'author' => 'Someone',
            'price' => 2000,
            'stock_qty' => 5,
        ]);

        $response->assertStatus(401)
            ->assertJsonPath('errors.code', 'UNAUTHORIZED');

        $this->assertDatabaseHas('books', [
            'book_id' => $book->book_id,
            'title' => 'Old Title',
        ]);
    }

    public function test_reader_can_put_a_book(): void
    {
        $this->actingAsReader();
        $book = Book::factory()->create([
            'title' => 'Old Title',
            'author' => 'Old Author',
            'price' => 1000,
            'stock_qty' => 1,
        ]);

        $response = $this->putJson("/api/books/{$book->book_id}", [
            'title' => 'New Title',
            'author' => 'New Author',
            'price' => 2500,
            'stock_qty' => 10,
            'published_year' => 2020,
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.title', 'New Title')
            ->assertJsonPath('data.author', 'New Author')
            ->assertJsonPath('data.price', 2500);

        $this->assertDatabaseHas('books', [
            'book_id' => $book->book_id,
            'title' => 'New Title',
            'author' => 'New Author',
            'price' => 2500,
            'stock_qty' => 10,
        ]);
    }

    public function test_reader_can_patch_a_book(): void
    {
        $this->actingAsReader();
        $book = Book::factory()->create([
            'title' => 'Patch Me',
            'author' => 'Keep Author',
            'price' => 1500,
        ]);

        $response = $this->patchJson("/api/books/{$book->book_id}", [
            'title' => 'Patched Title',
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.title', 'Patched Title')
            ->assertJsonPath('data.author', 'Keep Author');

        $this->assertDatabaseHas('books', [
            'book_id' => $book->book_id,
            'title' => 'Patched Title',
            'author' => 'Keep Author',
        ]);
    }

    public function test_update_unknown_book_returns_not_found(): void
    {
        $this->actingAsReader();

        $response = $this->putJson('/api/books/999999', [
            'title' => 'Missing',
            'author' => 'Nobody',
            'price' => 1000,
            'stock_qty' => 0,
        ]);

        $response->assertStatus(404)
            ->assertJsonPath('errors.code', 'NOT_FOUND');
    }
}
