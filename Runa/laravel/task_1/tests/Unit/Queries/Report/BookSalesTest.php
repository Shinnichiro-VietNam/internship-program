<?php

namespace Tests\Unit\Queries\Report;

use App\Models\Book;
use App\Models\OrderItem;
use App\Queries\Report\BookSales;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookSalesTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_aggregates_quantity_and_revenue_for_one_book(): void
    {
        $book = Book::factory()->create(['title' => 'Aggregated Book']);
        OrderItem::factory()->create([
            'book_id' => $book->book_id,
            'quantity' => 2,
            'unit_price' => 1000,
        ]);
        OrderItem::factory()->create([
            'book_id' => $book->book_id,
            'quantity' => 3,
            'unit_price' => 2000,
        ]);

        $rows = (new BookSales)->handle();

        $this->assertCount(1, $rows);
        $this->assertSame($book->book_id, (int) $rows->first()->book_id);
        $this->assertSame('Aggregated Book', $rows->first()->title);
        $this->assertSame(5, (int) $rows->first()->total_quantity_sold);
        $this->assertSame(8000, (int) $rows->first()->total_revenue_jpy);
    }
}
