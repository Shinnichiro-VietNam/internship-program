<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OrderItem>
 */
class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'book_id' => Book::factory(),
            'quantity' => fake()->numberBetween(1, 5),
            'unit_price' => fake()->randomFloat(2, 500, 5000),
        ];
    }
}
