<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    //一度も売れたことがない本
    public function booksNeverSold()
    {
        $books = DB::table('books as b')
            ->leftJoin('order_items as oi', 'oi.book_id', '=', 'b.book_id')
            ->whereNull('oi.book_id')
            ->select('b.book_id', 'b.title')
            ->get();

        return response()->json(['data' => $books]);
    }

    //本ごとの売上集計
    public function bookSales()
    {
        $sales = DB::table('books as b')
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

        return response()->json(['data' => $sales]);
    }

    //都市ごとの顧客・注文数集計
    public function customersByCity(Request $request)
    {
        $query = DB::table('customers as c')
            ->leftJoin('orders as o', 'o.customer_id', '=', 'c.customer_id')
            ->select(
                'c.city',
                DB::raw('COUNT(DISTINCT c.customer_id) as customer_count'),
                DB::raw('COUNT(o.order_id) as order_count')
            )
            ->when($request->filled('city'), fn ($q) => $q->where('c.city', $request->query('city')))
            ->groupBy('c.city');

        return response()->json(['data' => $query->get()]);
    }
}
