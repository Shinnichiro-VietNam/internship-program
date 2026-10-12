<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            DepartmentSeeder::class,
            EmployeeSeeder::class,
            CustomerSeeder::class,
            BookSeeder::class,
            OrderSeeder::class,
            OrderItemSeeder::class,
            UserSeeder::class,
        ]);
    }
}
