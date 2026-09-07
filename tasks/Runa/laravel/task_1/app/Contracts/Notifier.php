<?php

namespace App\Contracts;

use App\Models\Book;

interface Notifier
{
    public function notifyLowStock(Book $book): void;
}
