<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('customers')->insert([
            ['full_name' => '山田 健一', 'email' => 'kenichi.yamada@mail.example.jp', 'city' => '東京', 'created_at' => '2023-08-12'],
            ['full_name' => '佐々木 凛', 'email' => 'rin.sasaki@mail.example.jp', 'city' => '東京', 'created_at' => '2024-01-05'],
            ['full_name' => '藤田 浩二', 'email' => null, 'city' => '大阪', 'created_at' => '2024-02-18'],
            ['full_name' => '岡田 真由', 'email' => 'mayu.okada@mail.example.jp', 'city' => '京都', 'created_at' => '2023-11-30'],
            ['full_name' => '後藤 陽子', 'email' => 'yoko.goto@mail.example.jp', 'city' => '東京', 'created_at' => '2024-03-02'],
            ['full_name' => '長谷川 亮', 'email' => 'ryo.hasegawa@mail.example.jp', 'city' => '横浜', 'created_at' => '2024-04-10'],
            ['full_name' => '石川 奈々', 'email' => null, 'city' => '福岡', 'created_at' => '2024-05-01'],
            ['full_name' => '前田 智子', 'email' => 'tomoko.maeda@mail.example.jp', 'city' => '札幌', 'created_at' => '2024-06-20'],
            ['full_name' => '村上 賢人', 'email' => 'kento.murakami@mail.example.jp', 'city' => '名古屋', 'created_at' => '2024-01-22'],
            ['full_name' => '近藤 美穂', 'email' => 'miho.kondo@mail.example.jp', 'city' => '東京', 'created_at' => '2024-07-08'],
            ['full_name' => '坂本 龍一', 'email' => null, 'city' => '神戸', 'created_at' => '2024-08-15'],
            ['full_name' => '原田 翔太', 'email' => 'shota.harada@mail.example.jp', 'city' => '広島', 'created_at' => '2024-02-28'],
            ['full_name' => '清水 愛', 'email' => 'ai.shimizu@mail.example.jp', 'city' => '東京', 'created_at' => '2023-12-01'],
            ['full_name' => '森 健', 'email' => 'ken.mori@mail.example.jp', 'city' => '大阪', 'created_at' => '2024-09-01'],
            ['full_name' => '池田 さゆり', 'email' => null, 'city' => '京都', 'created_at' => '2024-03-15'],
            ['full_name' => '橋本 大樹', 'email' => 'daiki.hashimoto@mail.example.jp', 'city' => '仙台', 'created_at' => '2024-05-20'],
            ['full_name' => '阿部 由紀', 'email' => 'yuki.abe@mail.example.jp', 'city' => '東京', 'created_at' => '2024-10-01'],
            ['full_name' => '福田 恵美', 'email' => 'emi.fukuda@mail.example.jp', 'city' => '福岡', 'created_at' => '2024-06-11'],
        ]);
    }
}
