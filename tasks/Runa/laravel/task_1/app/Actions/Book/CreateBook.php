<?php

namespace App\Actions\Book;

use App\Models\Book;

final class CreateBook
{
    public function handle(array $data): Book
    {
        return Book::create($data);
    }
}
