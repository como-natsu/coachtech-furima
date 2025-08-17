<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;
use App\Models\Condition;
use Illuminate\Support\Facades\Hash;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'testuser@example.com',
            'password' => Hash::make('password'),
        ]);


        $product = Product::create([
            'name' => '腕時計',
            'price' => '15000',
            'brand_name' => 'Rolax',
            'image' => 'storage/images/Armani+Mens+Clock.jpg',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'sold' => false,
            'user_id' => $user ->id,
            'condition_id' => 1,
        ]);

        $product = Product::create([
            'name' => 'HDD',
            'price' => '5000',
            'brand_name' => '西芝',
            'image' => 'storage/images/HDD+Hard+Disk.jpg',
            'description' => '高速で信頼性の高いハードディスク',
            'sold' => false,
            'user_id' => $user ->id,
            'condition_id' => 2,
        ]);

        $product = Product::create([
            'name' => '玉ねぎ3束',
            'price' => '300',
            'brand_name' => 'なし',
            'image' => 'storage/images/iLoveIMG+d.jpg',
            'description' => '新鮮な玉ねぎ3束のセット',
            'sold' => false,
            'user_id' => $user ->id,
            'condition_id' => 3,
        ]);

        $product = Product::create([
            'name' => '革靴',
            'price' => '4000',
            'brand_name' => '',
            'image' => 'storage/images/Leather+Shoes+Product+Photo.jpg',
            'description' => 'クラシックなデザインの革靴',
            'sold' => false,
            'user_id' => $user ->id,
            'condition_id' => 4,
        ]);

        $product = Product::create([
            'name' => 'ノートPC',
            'price' => '45000',
            'brand_name' => '',
            'image' => 'storage/images/Living+Room+Laptop.jpg',
            'description' => '高性能なノートパソコン',
            'sold' => false,
            'user_id' => $user ->id,
            'condition_id' => 1,
        ]);

        $product = Product::create([
            'name' => 'マイク',
            'price' => '8000',
            'brand_name' => 'なし',
            'image' => 'storage/images/Music+Mic+4632231.jpg',
            'description' => '高音質のレコーディング用マイク',
            'sold' => false,
            'user_id' => $user ->id,
            'condition_id' => 2,
        ]);

        $product = Product::create([
            'name' => 'ショルダーバッグ',
            'price' => '3500',
            'brand_name' => '',
            'image' => 'storage/images/Purse+fashion+pocket.jpg',
            'description' => 'おしゃれなショルダーバッグ',
            'sold' => false,
            'user_id' => $user ->id,
            'condition_id' => 3,
        ]);

        $product = Product::create([
            'name' => 'タンブラー',
            'price' => '500',
            'brand_name' => 'なし',
            'image' => 'storage/images/Tumbler+souvenir.jpg',
            'description' => '使いやすいタンブラー',
            'sold' => false,
            'user_id' => $user ->id,
            'condition_id' => 4,
        ]);

        $product = Product::create([
            'name' => 'コーヒーミル',
            'price' => '4000',
            'brand_name' => 'Starbacks',
            'image' => 'storage/images/Waitress+with+Coffee+Grinder.jpg',
            'description' => '手動のコーヒーミル',
            'sold' => false,
            'user_id' => $user ->id,
            'condition_id' => 1,
        ]);

        $product = Product::create([
            'name' => 'メイクセット',
            'price' => '2500',
            'brand_name' => '',
            'image' => 'storage/images/外出メイクアップセット.jpg',
            'description' => '便利なメイクアップセット',
            'sold' => false,
            'user_id' => $user ->id,
            'condition_id' => 2,
        ]);

    }
}
