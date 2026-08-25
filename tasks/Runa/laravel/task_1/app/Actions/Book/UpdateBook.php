<?php

namespace App\Actions\Book;

use App\Models\Book;

final class UpdateBook
{
    public function handle(Book $book, array $data): Book
    {
        $book->update($data);

        return $book;
    }
}
