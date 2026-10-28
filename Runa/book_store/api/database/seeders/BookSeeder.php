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
            ['title' => 'リーダブルコード', 'author' => 'イリイ・メイヤーズ', 'price' => 3200.00, 'stock_qty' => 30, 'published_year' => 2018],
            ['title' => '達人プログラマー', 'author' => 'アンディ・ハント', 'price' => 3800.00, 'stock_qty' => 22, 'published_year' => 2020],
            ['title' => 'オブジェクト指向におけるデザインパターン', 'author' => 'GoF', 'price' => 5200.00, 'stock_qty' => 14, 'published_year' => 1994],
            ['title' => 'リファクタリング', 'author' => 'Martin Fowler', 'price' => 4800.00, 'stock_qty' => 18, 'published_year' => 2019],
            ['title' => 'データベースシステム概論', 'author' => 'Silberschatz', 'price' => 6500.00, 'stock_qty' => 10, 'published_year' => 2021],
            ['title' => 'SQLパフォーマンスの教科書', 'author' => 'Markus Winand', 'price' => 3600.00, 'stock_qty' => 20, 'published_year' => 2015],
            ['title' => 'Clean Code', 'author' => 'Robert C. Martin', 'price' => 4200.00, 'stock_qty' => 25, 'published_year' => 2008],
            ['title' => '未刊行プロトタイプ資料', 'author' => '編集部', 'price' => 1000.00, 'stock_qty' => 0, 'published_year' => 2025],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}
