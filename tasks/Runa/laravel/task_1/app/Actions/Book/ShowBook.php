<?php

namespace App\Actions\Book;

use App\Models\Book;

final class ShowBook
{
    public function handle(Book $book): Book
    {
        return $book;
    }
}
