<?php

namespace App\Jobs;

use App\Contracts\Notifier;
use App\Models\Book;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class WarnLowStock implements ShouldQueue
{
    use Queueable;

    public const THRESHOLD = 5;

    public function __construct(public int $bookId) {}

    public function handle(Notifier $notifier): void
    {
        $book = Book::find($this->bookId);

        if ($book === null || $book->stock_qty >= self::THRESHOLD) {
            return;
        }

        $notifier->notifyLowStock($book);
    }
}
