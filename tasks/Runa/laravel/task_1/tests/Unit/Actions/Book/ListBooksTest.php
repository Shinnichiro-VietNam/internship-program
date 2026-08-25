<?php

namespace Tests\Unit\Actions\Book;

use App\Actions\Book\ListBooks;
use App\Models\Book;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListBooksTest extends TestCase
{
    use RefreshDatabase;

    private ListBooks $listBooks;

    protected function setUp(): void
    {
        parent::setUp();
        $this->listBooks = new ListBooks;
    }

    public function test_author_filter_matches_partially(): void
    {
        Book::factory()->create(['author' => 'Robert C. Martin']);
        Book::factory()->create(['author' => 'Uncle Bob']);

        $result = $this->listBooks->handle(['author' => 'Martin']);

        $this->assertCount(1, $result);
        $this->assertSame('Robert C. Martin', $result->first()->author);
    }

    public function test_price_range_excludes_out_of_range_books(): void
    {
        Book::factory()->create(['price' => 1000]);
        Book::factory()->create(['price' => 3000]);
        Book::factory()->create(['price' => 5000]);

        $result = $this->listBooks->handle([
            'min_price' => 2000,
            'max_price' => 4000,
        ]);

        $this->assertCount(1, $result);
        $this->assertSame(3000, (int) $result->first()->price);
    }

    public function test_without_page_returns_collection(): void
    {
        Book::factory()->count(2)->create();

        $result = $this->listBooks->handle([]);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(2, $result);
    }

    public function test_with_page_returns_length_aware_paginator(): void
    {
        Book::factory()->count(3)->create();

        $result = $this->listBooks->handle(['page' => 1, 'per_page' => 2]);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertCount(2, $result->items());
        $this->assertSame(3, $result->total());
    }

    public function test_per_page_is_capped_at_fifty(): void
    {
        Book::factory()->count(55)->create();

        $result = $this->listBooks->handle(['page' => 1, 'per_page' => 999]);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertSame(50, $result->perPage());
        $this->assertCount(50, $result->items());
    }
}
