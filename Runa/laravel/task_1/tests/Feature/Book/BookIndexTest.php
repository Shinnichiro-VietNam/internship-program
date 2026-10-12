<?php

namespace Tests\Feature\Book;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_list_books(): void
    {
        Book::factory()->count(3)->create();

        $response = $this->getJson('/api/books');

        $response->assertStatus(200)
            ->assertJsonPath('status', 200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    ['id', 'title', 'author', 'price'],
                ],
            ]);
    }

    public function test_author_filter_matches_partially(): void
    {
        Book::factory()->create(['author' => 'Robert C. Martin']);
        Book::factory()->create(['author' => 'Martin Fowler']);
        Book::factory()->create(['author' => 'Uncle Bob']);

        $response = $this->getJson('/api/books?author=Martin');

        $response->assertStatus(200)
            ->assertJsonCount(2, 'data');

        $authors = collect($response->json('data'))->pluck('author')->all();
        $this->assertContains('Robert C. Martin', $authors);
        $this->assertContains('Martin Fowler', $authors);
        $this->assertNotContains('Uncle Bob', $authors);
    }

    public function test_price_filter_returns_only_books_in_range(): void
    {
        Book::factory()->create(['title' => 'Cheap', 'price' => 1000]);
        Book::factory()->create(['title' => 'Mid', 'price' => 3000]);
        Book::factory()->create(['title' => 'Expensive', 'price' => 5000]);

        $response = $this->getJson('/api/books?min_price=2000&max_price=4000');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.title', 'Mid');
    }

    public function test_pagination_returns_page_of_results(): void
    {
        Book::factory()->count(5)->create();

        $page1 = $this->getJson('/api/books?page=1&per_page=2');

        // ResponseData wraps the resource collection: pagination meta is not
        // preserved — `data` is a flat array of the current page's books.
        $page1->assertStatus(200)
            ->assertJsonPath('status', 200)
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    ['id', 'title', 'author', 'price', 'stock_qty', 'published_year'],
                ],
            ]);

        $page2 = $this->getJson('/api/books?page=2&per_page=2');
        $page2->assertStatus(200)->assertJsonCount(2, 'data');

        $page3 = $this->getJson('/api/books?page=3&per_page=2');
        $page3->assertStatus(200)->assertJsonCount(1, 'data');

        $this->assertNotEquals(
            collect($page1->json('data'))->pluck('id')->all(),
            collect($page2->json('data'))->pluck('id')->all()
        );
    }

    public function test_per_page_is_capped_at_fifty(): void
    {
        Book::factory()->count(55)->create();

        $response = $this->getJson('/api/books?page=1&per_page=999');

        $response->assertStatus(200)
            ->assertJsonCount(50, 'data');
    }
}
