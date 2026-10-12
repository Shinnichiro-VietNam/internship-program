<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('books')->insert([
            ['title' => 'リーダブルコード', 'author' => 'イリイ・メイヤーズ', 'price' => 3200.00, 'stock_qty' => 30, 'published_year' => 2018],
            ['title' => '達人プログラマー', 'author' => 'アンディ・ハント', 'price' => 3800.00, 'stock_qty' => 22, 'published_year' => 2020],
            ['title' => 'オブジェクト指向におけるデザインパターン', 'author' => 'GoF', 'price' => 5200.00, 'stock_qty' => 14, 'published_year' => 1994],
            ['title' => 'リファクタリング', 'author' => 'Martin Fowler', 'price' => 4800.00, 'stock_qty' => 18, 'published_year' => 2019],
            ['title' => 'データベースシステム概論', 'author' => 'Silberschatz', 'price' => 6500.00, 'stock_qty' => 10, 'published_year' => 2021],
            ['title' => 'SQLパフォーマンスの教科書', 'author' => 'Markus Winand', 'price' => 3600.00, 'stock_qty' => 20, 'published_year' => 2015],
            ['title' => 'Clean Code', 'author' => 'Robert C. Martin', 'price' => 4200.00, 'stock_qty' => 25, 'published_year' => 2008],
            ['title' => 'The Pragmatic Programmer', 'author' => 'David Thomas', 'price' => 4500.00, 'stock_qty' => 16, 'published_year' => 2019],
            ['title' => 'SQL入門', 'author' => 'ミック', 'price' => 2800.00, 'stock_qty' => 35, 'published_year' => 2022],
            ['title' => 'PHP実践入門', 'author' => '山田 祥寛', 'price' => 3400.00, 'stock_qty' => 12, 'published_year' => 2023],
            ['title' => 'アルゴリズム図鑑', 'author' => '石田 保輝', 'price' => 2900.00, 'stock_qty' => 28, 'published_year' => 2020],
            ['title' => 'ネットワークの基礎', 'author' => '戸根 勤', 'price' => 3100.00, 'stock_qty' => 15, 'published_year' => 2017],
            ['title' => '達人に学ぶDB設計', 'author' => 'ミック', 'price' => 4000.00, 'stock_qty' => 11, 'published_year' => 2018],
            ['title' => 'Effective Java', 'author' => 'Joshua Bloch', 'price' => 5000.00, 'stock_qty' => 8, 'published_year' => 2018],
            ['title' => 'ドメイン駆動設計', 'author' => 'Eric Evans', 'price' => 5800.00, 'stock_qty' => 9, 'published_year' => 2011],
            ['title' => 'HTML/CSSの教科書', 'author' => 'アサガヤ', 'price' => 2400.00, 'stock_qty' => 40, 'published_year' => 2024],
            ['title' => 'Linuxコマンドライン入門', 'author' => 'William Shotts', 'price' => 3300.00, 'stock_qty' => 19, 'published_year' => 2016],
            ['title' => '新人エンジニアの教科書', 'author' => '株式会社テック', 'price' => 2200.00, 'stock_qty' => 50, 'published_year' => 2024],
            ['title' => '社内規程ハンドブック', 'author' => '総務部', 'price' => 1500.00, 'stock_qty' => 5, 'published_year' => 2023],
            ['title' => '未刊行プロトタイプ資料', 'author' => '編集部', 'price' => 1000.00, 'stock_qty' => 0, 'published_year' => 2025],
        ]);
    }
}
