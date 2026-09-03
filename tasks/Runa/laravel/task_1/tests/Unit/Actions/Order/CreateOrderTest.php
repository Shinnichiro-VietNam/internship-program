<?php

namespace Tests\Unit\Actions\Order;

use App\Actions\Order\CreateOrder;
use App\Models\Book;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class CreateOrderTest extends TestCase
{
    use RefreshDatabase;

    private CreateOrder $createOrder;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createOrder = new CreateOrder;
    }

    public function test_it_creates_order_and_decrements_stock_with_snapshotted_price(): void
    {
        $customer = Customer::factory()->create();
        $book = Book::factory()->create(['price' => 2500, 'stock_qty' => 10]);

        $order = $this->createOrder->handle([
            'customer_id' => $customer->customer_id,
            'items' => [
                ['book_id' => $book->book_id, 'quantity' => 3],
            ],
        ]);

        $this->assertDatabaseHas('orders', [
            'order_id' => $order->order_id,
            'customer_id' => $customer->customer_id,
            'status' => 'pending',
        ]);
        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->order_id,
            'book_id' => $book->book_id,
            'quantity' => 3,
            'unit_price' => 2500,
        ]);

        $book->refresh();
        $this->assertSame(7, $book->stock_qty);
    }

    public function test_it_throws_when_stock_is_insufficient(): void
    {
        $customer = Customer::factory()->create();
        $book = Book::factory()->create(['stock_qty' => 1]);

        $this->expectException(ValidationException::class);

        try {
            $this->createOrder->handle([
                'customer_id' => $customer->customer_id,
                'items' => [
                    ['book_id' => $book->book_id, 'quantity' => 5],
                ],
            ]);
        } finally {
            $this->assertDatabaseCount('orders', 0);
            $book->refresh();
            $this->assertSame(1, $book->stock_qty);
        }
    }
}
