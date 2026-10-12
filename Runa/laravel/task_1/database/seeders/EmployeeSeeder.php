<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('employees')->insert([
            ['full_name' => '田中 太郎', 'email' => 'taro.tanaka@example.co.jp', 'dept_id' => 1, 'salary' => 520000.00, 'hire_date' => '2019-04-01', 'is_active' => 1],
            ['full_name' => '佐藤 花子', 'email' => 'hanako.sato@example.co.jp', 'dept_id' => 1, 'salary' => 480000.00, 'hire_date' => '2021-07-15', 'is_active' => 1],
            ['full_name' => '鈴木 一郎', 'email' => 'ichiro.suzuki@example.co.jp', 'dept_id' => 1, 'salary' => 590000.00, 'hire_date' => '2018-02-20', 'is_active' => 1],
            ['full_name' => '高橋 美咲', 'email' => 'misaki.takahashi@example.co.jp', 'dept_id' => 2, 'salary' => 420000.00, 'hire_date' => '2022-01-10', 'is_active' => 1],
            ['full_name' => '伊藤 健太', 'email' => 'kenta.ito@example.co.jp', 'dept_id' => 2, 'salary' => 390000.00, 'hire_date' => '2023-06-01', 'is_active' => 1],
            ['full_name' => '渡辺 由美', 'email' => 'yumi.watanabe@example.co.jp', 'dept_id' => 2, 'salary' => 450000.00, 'hire_date' => '2020-11-20', 'is_active' => 1],
            ['full_name' => '山本 翔', 'email' => 'sho.yamamoto@example.co.jp', 'dept_id' => 3, 'salary' => 380000.00, 'hire_date' => '2024-02-01', 'is_active' => 1],
            ['full_name' => '中村 あかり', 'email' => 'akari.nakamura@example.co.jp', 'dept_id' => 3, 'salary' => 360000.00, 'hire_date' => '2023-09-12', 'is_active' => 1],
            ['full_name' => '小林 直樹', 'email' => 'naoki.kobayashi@example.co.jp', 'dept_id' => 4, 'salary' => 410000.00, 'hire_date' => '2017-05-08', 'is_active' => 1],
            ['full_name' => '加藤 恵', 'email' => 'megumi.kato@example.co.jp', 'dept_id' => 4, 'salary' => 400000.00, 'hire_date' => '2022-08-22', 'is_active' => 1],
            ['full_name' => '吉田 大輔', 'email' => 'daisuke.yoshida@example.co.jp', 'dept_id' => 5, 'salary' => 430000.00, 'hire_date' => '2021-03-30', 'is_active' => 1],
            ['full_name' => '松本 さくら', 'email' => 'sakura.matsumoto@example.co.jp', 'dept_id' => 5, 'salary' => 370000.00, 'hire_date' => '2024-04-15', 'is_active' => 1],
            ['full_name' => '井上 誠', 'email' => 'makoto.inoue@example.co.jp', 'dept_id' => 6, 'salary' => 350000.00, 'hire_date' => '2023-11-01', 'is_active' => 1],
            ['full_name' => '木村 優子', 'email' => 'yuko.kimura@example.co.jp', 'dept_id' => 6, 'salary' => 340000.00, 'hire_date' => '2022-12-05', 'is_active' => 1],
            ['full_name' => '林 拓也', 'email' => 'takuya.hayashi@example.co.jp', 'dept_id' => 1, 'salary' => 550000.00, 'hire_date' => '2016-10-01', 'is_active' => 0],
            ['full_name' => '斎藤 麻衣', 'email' => 'mai.saito@example.co.jp', 'dept_id' => 2, 'salary' => 320000.00, 'hire_date' => '2024-07-01', 'is_active' => 1],
        ]);
    }
}
