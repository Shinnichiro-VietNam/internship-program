<?php

namespace Tests\Feature\Book;

use App\Models\Book;
use App\Models\OrderItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookOrderItemsTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_list_order_items_for_a_book(): void
    {
        $book = Book::factory()->create();
        OrderItem::factory()->create([
            'book_id' => $book->book_id,
            'quantity' => 2,
            'unit_price' => 1500,
        ]);
        OrderItem::factory()->create([
            'book_id' => $book->book_id,
            'quantity' => 1,
            'unit_price' => 1500,
        ]);

        $response = $this->getJson("/api/books/{$book->book_id}/order-items");

        $response->assertStatus(200)
            ->assertJsonPath('status', 200)
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    ['book_id', 'quantity', 'unit_price'],
                ],
            ])
            ->assertJsonPath('data.0.book_id', $book->book_id);
    }

    public function test_book_with_no_order_items_returns_empty_list(): void
    {
        $book = Book::factory()->create();

        $response = $this->getJson("/api/books/{$book->book_id}/order-items");

        $response->assertStatus(200)
            ->assertJsonCount(0, 'data');
    }

    public function test_order_items_for_unknown_book_returns_not_found(): void
    {
        $response = $this->getJson('/api/books/999999/order-items');

        $response->assertStatus(404)
            ->assertJsonPath('errors.code', 'NOT_FOUND');
    }
}
