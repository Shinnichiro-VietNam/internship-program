<?php

namespace App\Queries\Report;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class BooksNeverSold
{
    public function handle(): Collection
    {
        return DB::table('books as b')
            ->leftJoin('order_items as oi', 'oi.book_id', '=', 'b.book_id')
            ->whereNull('oi.book_id')
            ->select('b.book_id', 'b.title')
            ->get();
    }
}
