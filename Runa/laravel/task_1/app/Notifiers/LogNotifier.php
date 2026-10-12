<?php

namespace App\Notifiers;

use App\Contracts\Notifier;
use App\Models\Book;
use Illuminate\Support\Facades\Log;

class LogNotifier implements Notifier
{
    public function notifyLowStock(Book $book): void
    {
        Log::warning('low_stock', [
            'book_id'   => $book->book_id,
            'stock_qty' => $book->stock_qty,
        ]);
    }
}
