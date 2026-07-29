<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('departments')->insert([
            ['dept_name' => '開発', 'location' => '東京'],
            ['dept_name' => '営業', 'location' => '東京'],
            ['dept_name' => 'サポート', 'location' => '大阪'],
            ['dept_name' => '人事', 'location' => '東京'],
            ['dept_name' => 'マーケティング', 'location' => '福岡'],
            ['dept_name' => '物流', 'location' => '名古屋'],
        ]);
    }
}
