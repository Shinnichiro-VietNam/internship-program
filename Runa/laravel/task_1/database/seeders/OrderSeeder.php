<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('orders')->insert([
            ['customer_id' => 1, 'order_date' => '2024-01-10', 'status' => 'shipped'],
            ['customer_id' => 1, 'order_date' => '2024-03-22', 'status' => 'paid'],
            ['customer_id' => 2, 'order_date' => '2024-02-05', 'status' => 'shipped'],
            ['customer_id' => 2, 'order_date' => '2024-06-15', 'status' => 'paid'],
            ['customer_id' => 3, 'order_date' => '2024-04-01', 'status' => 'paid'],
            ['customer_id' => 4, 'order_date' => '2024-05-12', 'status' => 'shipped'],
            ['customer_id' => 4, 'order_date' => '2024-07-01', 'status' => 'cancelled'],
            ['customer_id' => 5, 'order_date' => '2024-06-20', 'status' => 'shipped'],
            ['customer_id' => 5, 'order_date' => '2024-08-10', 'status' => 'pending'],
            ['customer_id' => 6, 'order_date' => '2024-03-30', 'status' => 'paid'],
            ['customer_id' => 6, 'order_date' => '2024-09-05', 'status' => 'shipped'],
            ['customer_id' => 8, 'order_date' => '2024-07-18', 'status' => 'paid'],
            ['customer_id' => 9, 'order_date' => '2024-02-14', 'status' => 'shipped'],
            ['customer_id' => 9, 'order_date' => '2024-08-25', 'status' => 'paid'],
            ['customer_id' => 10, 'order_date' => '2024-04-20', 'status' => 'shipped'],
            ['customer_id' => 10, 'order_date' => '2024-09-12', 'status' => 'paid'],
            ['customer_id' => 11, 'order_date' => '2024-05-08', 'status' => 'cancelled'],
            ['customer_id' => 13, 'order_date' => '2023-11-15', 'status' => 'shipped'],
            ['customer_id' => 13, 'order_date' => '2024-01-08', 'status' => 'paid'],
            ['customer_id' => 13, 'order_date' => '2024-06-01', 'status' => 'shipped'],
            ['customer_id' => 14, 'order_date' => '2024-08-01', 'status' => 'pending'],
            ['customer_id' => 16, 'order_date' => '2024-07-22', 'status' => 'shipped'],
            ['customer_id' => 17, 'order_date' => '2024-09-20', 'status' => 'paid'],
        ]);
    }
}
