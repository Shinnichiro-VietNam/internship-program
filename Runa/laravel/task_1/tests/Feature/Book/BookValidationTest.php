<?php

namespace Tests\Feature\Book;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_book_requires_title(): void
    {
        $this->actingAsReader();

        $response = $this->postJson('/api/books', [
            'author' => 'Someone',
            'price' => 1000,
        ]);

        $response->assertStatus(400)
            ->assertJsonPath('errors.code', 'BAD_REQUEST')
            ->assertJsonFragment(['field' => 'title']);

        $this->assertDatabaseCount('books', 0);
    }

    public function test_create_book_rejects_zero_price(): void
    {
        $this->actingAsReader();

        $response = $this->postJson('/api/books', [
            'title' => 'Free Book',
            'author' => 'Someone',
            'price' => 0,
        ]);

        $response->assertStatus(400)
            ->assertJsonPath('errors.code', 'BAD_REQUEST')
            ->assertJsonFragment(['field' => 'price']);

        $this->assertDatabaseMissing('books', ['title' => 'Free Book']);
    }

    public function test_create_book_rejects_negative_stock_qty(): void
    {
        $this->actingAsReader();

        $response = $this->postJson('/api/books', [
            'title' => 'Bad Stock',
            'author' => 'Someone',
            'price' => 1000,
            'stock_qty' => -1,
        ]);

        $response->assertStatus(400)
            ->assertJsonPath('errors.code', 'BAD_REQUEST')
            ->assertJsonFragment(['field' => 'stock_qty']);

        $this->assertDatabaseMissing('books', ['title' => 'Bad Stock']);
    }
}
