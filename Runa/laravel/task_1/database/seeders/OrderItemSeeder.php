<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderItemSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('order_items')->insert([
            ['order_id' => 1, 'book_id' => 1, 'quantity' => 1, 'unit_price' => 3200.00],
            ['order_id' => 1, 'book_id' => 9, 'quantity' => 2, 'unit_price' => 2800.00],
            ['order_id' => 2, 'book_id' => 7, 'quantity' => 1, 'unit_price' => 4200.00],
            ['order_id' => 2, 'book_id' => 6, 'quantity' => 1, 'unit_price' => 3600.00],
            ['order_id' => 3, 'book_id' => 2, 'quantity' => 1, 'unit_price' => 3800.00],
            ['order_id' => 3, 'book_id' => 11, 'quantity' => 1, 'unit_price' => 3100.00],
            ['order_id' => 4, 'book_id' => 3, 'quantity' => 1, 'unit_price' => 5200.00],
            ['order_id' => 4, 'book_id' => 13, 'quantity' => 1, 'unit_price' => 4000.00],
            ['order_id' => 5, 'book_id' => 10, 'quantity' => 1, 'unit_price' => 3400.00],
            ['order_id' => 5, 'book_id' => 16, 'quantity' => 2, 'unit_price' => 2400.00],
            ['order_id' => 6, 'book_id' => 4, 'quantity' => 1, 'unit_price' => 4800.00],
            ['order_id' => 6, 'book_id' => 5, 'quantity' => 1, 'unit_price' => 6500.00],
            ['order_id' => 7, 'book_id' => 8, 'quantity' => 1, 'unit_price' => 4500.00],
            ['order_id' => 8, 'book_id' => 1, 'quantity' => 2, 'unit_price' => 3200.00],
            ['order_id' => 8, 'book_id' => 12, 'quantity' => 1, 'unit_price' => 3100.00],
            ['order_id' => 9, 'book_id' => 14, 'quantity' => 1, 'unit_price' => 5000.00],
            ['order_id' => 10, 'book_id' => 6, 'quantity' => 1, 'unit_price' => 3600.00],
            ['order_id' => 10, 'book_id' => 9, 'quantity' => 1, 'unit_price' => 2800.00],
            ['order_id' => 11, 'book_id' => 15, 'quantity' => 1, 'unit_price' => 5800.00],
            ['order_id' => 11, 'book_id' => 7, 'quantity' => 1, 'unit_price' => 4200.00],
            ['order_id' => 12, 'book_id' => 2, 'quantity' => 2, 'unit_price' => 3800.00],
            ['order_id' => 13, 'book_id' => 4, 'quantity' => 1, 'unit_price' => 4800.00],
            ['order_id' => 14, 'book_id' => 1, 'quantity' => 1, 'unit_price' => 3200.00],
            ['order_id' => 14, 'book_id' => 11, 'quantity' => 2, 'unit_price' => 2900.00],
            ['order_id' => 15, 'book_id' => 5, 'quantity' => 1, 'unit_price' => 6500.00],
            ['order_id' => 15, 'book_id' => 17, 'quantity' => 1, 'unit_price' => 3300.00],
            ['order_id' => 16, 'book_id' => 8, 'quantity' => 1, 'unit_price' => 4500.00],
            ['order_id' => 16, 'book_id' => 10, 'quantity' => 1, 'unit_price' => 3400.00],
            ['order_id' => 17, 'book_id' => 2, 'quantity' => 1, 'unit_price' => 3800.00],
            ['order_id' => 18, 'book_id' => 3, 'quantity' => 1, 'unit_price' => 5200.00],
            ['order_id' => 18, 'book_id' => 6, 'quantity' => 1, 'unit_price' => 3600.00],
            ['order_id' => 19, 'book_id' => 7, 'quantity' => 1, 'unit_price' => 4200.00],
            ['order_id' => 19, 'book_id' => 13, 'quantity' => 1, 'unit_price' => 4000.00],
            ['order_id' => 20, 'book_id' => 1, 'quantity' => 3, 'unit_price' => 3200.00],
            ['order_id' => 20, 'book_id' => 9, 'quantity' => 1, 'unit_price' => 2800.00],
            ['order_id' => 21, 'book_id' => 12, 'quantity' => 1, 'unit_price' => 3100.00],
            ['order_id' => 22, 'book_id' => 4, 'quantity' => 1, 'unit_price' => 4800.00],
            ['order_id' => 22, 'book_id' => 15, 'quantity' => 1, 'unit_price' => 5800.00],
            ['order_id' => 23, 'book_id' => 6, 'quantity' => 2, 'unit_price' => 3600.00],
            ['order_id' => 23, 'book_id' => 16, 'quantity' => 1, 'unit_price' => 2400.00],
        ]);
    }
}
