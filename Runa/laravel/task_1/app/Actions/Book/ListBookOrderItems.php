<?php

namespace App\Actions\Book;

use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;

final class ListBookOrderItems
{
    public function handle(Book $book): Collection
    {
        $book->load('orderItems.order');

        return $book->orderItems;
    }
}
