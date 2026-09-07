<?php

namespace Tests\Unit\Jobs;

use App\Contracts\Notifier;
use App\Jobs\WarnLowStock;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class WarnLowStockTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_notifies_when_stock_is_below_threshold(): void
    {
        $book = Book::factory()->create(['stock_qty' => 2]);
        $notifier = Mockery::mock(Notifier::class);
        $notifier->shouldReceive('notifyLowStock')->once();

        $this->app->instance(Notifier::class, $notifier);

        (new WarnLowStock($book->book_id))->handle($this->app->make(Notifier::class));
    }

    public function test_it_does_not_notify_when_stock_is_above_threshold(): void
    {
        $book = Book::factory()->create(['stock_qty' => 10]);
        $notifier = Mockery::mock(Notifier::class);
        $notifier->shouldNotReceive('notifyLowStock');

        $this->app->instance(Notifier::class, $notifier);

        (new WarnLowStock($book->book_id))->handle($this->app->make(Notifier::class));
    }
}
