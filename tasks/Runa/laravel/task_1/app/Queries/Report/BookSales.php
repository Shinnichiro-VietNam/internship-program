<?php

namespace App\Queries\Report;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class BookSales
{
    public function handle(): Collection
    {
        return DB::table('books as b')
            ->join('order_items as oi', 'oi.book_id', '=', 'b.book_id')
            ->select(
                'b.book_id',
                'b.title',
                DB::raw('SUM(oi.quantity) as total_quantity_sold'),
                DB::raw('SUM(oi.quantity * oi.unit_price) as total_revenue_jpy')
            )
            ->groupBy('b.book_id', 'b.title')
            ->orderByDesc('total_revenue_jpy')
            ->get();
    }
}
