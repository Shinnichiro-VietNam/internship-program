<?php

namespace App\Queries\Book;

use App\Models\Book;

final class FindBookQuery
{
    public function handle(int $id): ?Book
    {
        return Book::find($id);
    }
}