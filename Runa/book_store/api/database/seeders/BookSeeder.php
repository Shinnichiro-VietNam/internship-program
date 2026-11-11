<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            ['title' => 'The Art of Readable Code', 'author' => 'Dustin Boswell', 'price' => 3200.00, 'stock_qty' => 30, 'published_year' => 2018],
            ['title' => 'The Pragmatic Programmer', 'author' => 'Andy Hunt', 'price' => 3800.00, 'stock_qty' => 22, 'published_year' => 2020],
            ['title' => 'Design Patterns', 'author' => 'GoF', 'price' => 5200.00, 'stock_qty' => 14, 'published_year' => 1994],
            ['title' => 'Refactoring', 'author' => 'Martin Fowler', 'price' => 4800.00, 'stock_qty' => 18, 'published_year' => 2019],
            ['title' => 'Database System Concepts', 'author' => 'Silberschatz', 'price' => 6500.00, 'stock_qty' => 10, 'published_year' => 2021],
            ['title' => 'SQL Performance Explained', 'author' => 'Markus Winand', 'price' => 3600.00, 'stock_qty' => 20, 'published_year' => 2015],
            ['title' => 'Clean Code', 'author' => 'Robert C. Martin', 'price' => 4200.00, 'stock_qty' => 25, 'published_year' => 2008],
            ['title' => 'Unpublished Prototype Notes', 'author' => 'Editorial', 'price' => 1000.00, 'stock_qty' => 0, 'published_year' => 2025],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}
