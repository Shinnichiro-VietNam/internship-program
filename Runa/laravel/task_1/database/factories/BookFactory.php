<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Book>
 */
class BookFactory extends Factory
{
    protected $model = Book::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->unique()->sentence(3),
            'author' => fake()->name(),
            'price' => fake()->randomFloat(2, 500, 5000),
            'stock_qty' => fake()->numberBetween(0, 100),
            'published_year' => fake()->optional()->numberBetween(1980, (int) date('Y')),
        ];
    }
}
