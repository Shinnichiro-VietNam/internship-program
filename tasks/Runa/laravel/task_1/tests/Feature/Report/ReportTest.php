<?php

namespace Tests\Feature\Report;

use App\Models\Book;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_books_never_sold_lists_only_unsold_books(): void
    {
        $sold = Book::factory()->create(['title' => 'Sold Book']);
        $unsold = Book::factory()->create(['title' => 'Unsold Book']);
        OrderItem::factory()->create(['book_id' => $sold->book_id]);

        $response = $this->getJson('/api/reports/books-never-sold');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonFragment(['title' => 'Unsold Book'])
            ->assertJsonMissing(['title' => 'Sold Book']);
    }

    public function test_book_sales_aggregates_quantity_and_revenue(): void
    {
        $book = Book::factory()->create(['title' => 'Best Seller']);
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

        $response = $this->getJson('/api/reports/book-sales');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.title', 'Best Seller');

        $row = $response->json('data.0');
        $this->assertSame(5, (int) $row['total_quantity_sold']);
        $this->assertSame(8000, (int) $row['total_revenue_jpy']);
    }

    public function test_customers_by_city_without_filter_groups_all_cities(): void
    {
        $tokyoCustomer = Customer::factory()->create(['city' => '東京']);
        $osakaCustomer = Customer::factory()->create(['city' => '大阪']);
        Order::factory()->count(2)->create(['customer_id' => $tokyoCustomer->customer_id]);
        Order::factory()->create(['customer_id' => $osakaCustomer->customer_id]);

        $response = $this->getJson('/api/reports/customers-by-city');

        $response->assertStatus(200)
            ->assertJsonCount(2, 'data');

        $rows = collect($response->json('data'))->keyBy('city');
        $this->assertSame(1, (int) $rows['東京']['customer_count']);
        $this->assertSame(2, (int) $rows['東京']['order_count']);
        $this->assertSame(1, (int) $rows['大阪']['customer_count']);
        $this->assertSame(1, (int) $rows['大阪']['order_count']);
    }

    public function test_customers_by_city_with_city_filter(): void
    {
        Customer::factory()->create(['city' => '東京']);
        Customer::factory()->create(['city' => '大阪']);

        $response = $this->getJson('/api/reports/customers-by-city?city=' . urlencode('東京'));

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.city', '東京');
    }

    public function test_reports_are_public_for_guests(): void
    {
        Book::factory()->create();

        $this->getJson('/api/reports/books-never-sold')->assertStatus(200);
        $this->getJson('/api/reports/book-sales')->assertStatus(200);
        $this->getJson('/api/reports/customers-by-city')->assertStatus(200);
    }
}
