<?php

namespace App\Actions\Book;

use App\Models\Book;

final class DeleteBook
{
    public function handle(Book $book): void
    {
        $book->delete();
    }
}
