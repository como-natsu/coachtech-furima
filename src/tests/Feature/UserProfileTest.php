<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Condition;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    public function user_profile_displays_correct_information()
    {
        //  1. テスト用ユーザー作成
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'profile_image' => 'test_profile.jpg',
            'postcode' => '111-1111',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101',
        ]);

        // 2. 商品状態を登録
        $condition = Condition::create(['name' => '良好']);

        // 3. 出品商品を2つ作成
        $productA = Product::create([
            'name' => '出品商品A',
            'brand_name' => 'ブランドA',
            'price' => 1000,
            'description' => '説明A',
            'image' => 'imageA.jpg',
            'sold' => 0,
            'user_id' => $user->id,
            'condition_id' => $condition->id,
        ]);

        $productB = Product::create([
            'name' => '出品商品B',
            'brand_name' => 'ブランドB',
            'price' => 2000,
            'description' => '説明B',
            'image' => 'imageB.jpg',
            'sold' => 0,
            'user_id' => $user->id,
            'condition_id' => $condition->id,
        ]);

        // 4. 別ユーザーを購入者として作成
        $buyer = User::create([
            'name' => '購入者',
            'email' => 'buyer@example.com',
            'password' => bcrypt('password'),
            'profile_image' => 'buyer_profile.jpg',
            'postcode' => '999-9999',
            'address' => '北海道札幌市新住所',
            'building' => '新ビル999',
        ]);

        // 5. 購入データを作成
        Order::create([
            'user_id' => $buyer->id,
            'product_id' => $productA->id,
            'payment_method' => 'card',
            'postcode' => $buyer->postcode,
            'address' => $buyer->address,
            'building' => $buyer->building,
        ]);

        // 6. 出品者としてマイページを確認
        $this->actingAs($user);
        $response = $this->get('/mypage');
        $response->assertStatus(200);
        $response->assertSee('テストユーザー');
        $response->assertSee('出品商品A');
        $response->assertSee('出品商品B');
        $response->assertSee('test_profile.jpg');

        //7. 購入者としてマイページを確認
        $this->actingAs($buyer);
        $response = $this->get('/mypage?tab=buy');
        $response->assertStatus(200);
        $response->assertSee('購入者');
        $response->assertSee('出品商品A'); // 購入済み商品が表示されているか
    }
}