<?php

namespace Tests\Feature\Order;

use App\Events\OrderPlaced;
use App\Models\Book;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class OrderStoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_place_an_order(): void
    {
        $customer = Customer::factory()->create();
        $book = Book::factory()->create(['stock_qty' => 10]);

        $response = $this->postJson('/api/orders', [
            'customer_id' => $customer->customer_id,
            'items' => [['book_id' => $book->book_id, 'quantity' => 1]],
        ]);

        $response->assertStatus(401)
            ->assertJsonPath('errors.code', 'UNAUTHORIZED');

        $this->assertDatabaseCount('orders', 0);
    }

    public function test_reader_cannot_place_an_order(): void
    {
        Event::fake([OrderPlaced::class]);
        $this->actingAsReader();

        $customer = Customer::factory()->create();
        $book = Book::factory()->create(['stock_qty' => 10]);

        $response = $this->postJson('/api/orders', [
            'customer_id' => $customer->customer_id,
            'items' => [['book_id' => $book->book_id, 'quantity' => 1]],
        ]);

        $response->assertStatus(403)
            ->assertJsonPath('errors.code', 'FORBIDDEN');

        $this->assertDatabaseCount('orders', 0);
        $book->refresh();
        $this->assertSame(10, $book->stock_qty);
    }

    public function test_admin_can_place_a_valid_order(): void
    {
        Event::fake([OrderPlaced::class]);
        $this->actingAsAdmin();

        $customer = Customer::factory()->create();
        $book = Book::factory()->create(['price' => 1500, 'stock_qty' => 10]);

        $response = $this->postJson('/api/orders', [
            'customer_id' => $customer->customer_id,
            'items' => [['book_id' => $book->book_id, 'quantity' => 2]],
        ]);

        $response->assertStatus(201)
            ->assertHeader('Location')
            ->assertJsonPath('status', 201);

        $this->assertDatabaseHas('orders', [
            'customer_id' => $customer->customer_id,
            'status' => 'pending',
        ]);
        $this->assertDatabaseHas('order_items', [
            'book_id' => $book->book_id,
            'quantity' => 2,
            'unit_price' => 1500,
        ]);

        $book->refresh();
        $this->assertSame(8, $book->stock_qty);

        Event::assertDispatched(OrderPlaced::class);
    }

    public function test_admin_cannot_oversell_stock(): void
    {
        Event::fake([OrderPlaced::class]);
        $this->actingAsAdmin();

        $customer = Customer::factory()->create();
        $book = Book::factory()->create(['stock_qty' => 2]);

        $response = $this->postJson('/api/orders', [
            'customer_id' => $customer->customer_id,
            'items' => [['book_id' => $book->book_id, 'quantity' => 5]],
        ]);

        $response->assertStatus(400)
            ->assertJsonPath('errors.code', 'BAD_REQUEST');

        $this->assertDatabaseCount('orders', 0);
        $book->refresh();
        $this->assertSame(2, $book->stock_qty);
    }

    public function test_admin_two_items_rolls_back_when_second_book_is_short(): void
    {
        Event::fake([OrderPlaced::class]);
        $this->actingAsAdmin();

        $customer = Customer::factory()->create();
        $bookA = Book::factory()->create(['stock_qty' => 10]);
        $bookB = Book::factory()->create(['stock_qty' => 1]);

        $response = $this->postJson('/api/orders', [
            'customer_id' => $customer->customer_id,
            'items' => [
                ['book_id' => $bookA->book_id, 'quantity' => 2],
                ['book_id' => $bookB->book_id, 'quantity' => 5],
            ],
        ]);

        $response->assertStatus(400);

        $this->assertDatabaseCount('orders', 0);
        $bookA->refresh();
        $bookB->refresh();
        $this->assertSame(10, $bookA->stock_qty);
        $this->assertSame(1, $bookB->stock_qty);
    }

    public function test_admin_missing_items_returns_bad_request(): void
    {
        Event::fake([OrderPlaced::class]);
        $this->actingAsAdmin();

        $customer = Customer::factory()->create();

        $response = $this->postJson('/api/orders', [
            'customer_id' => $customer->customer_id,
        ]);

        $response->assertStatus(400)
            ->assertJsonPath('errors.code', 'BAD_REQUEST')
            ->assertJsonFragment(['field' => 'items']);
    }

    public function test_admin_unknown_customer_returns_bad_request(): void
    {
        Event::fake([OrderPlaced::class]);
        $this->actingAsAdmin();

        $book = Book::factory()->create(['stock_qty' => 10]);

        $response = $this->postJson('/api/orders', [
            'customer_id' => 999999,
            'items' => [['book_id' => $book->book_id, 'quantity' => 1]],
        ]);

        $response->assertStatus(400)
            ->assertJsonFragment(['field' => 'customer_id']);
    }

    public function test_admin_duplicate_book_id_in_items_returns_bad_request(): void
    {
        Event::fake([OrderPlaced::class]);
        $this->actingAsAdmin();

        $customer = Customer::factory()->create();
        $book = Book::factory()->create(['stock_qty' => 10]);

        $response = $this->postJson('/api/orders', [
            'customer_id' => $customer->customer_id,
            'items' => [
                ['book_id' => $book->book_id, 'quantity' => 1],
                ['book_id' => $book->book_id, 'quantity' => 2],
            ],
        ]);

        $response->assertStatus(400);
        $this->assertDatabaseCount('orders', 0);
    }
}
