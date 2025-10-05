<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;
use App\Models\Condition;
use App\Models\Order;

class ProductPurchaseTest extends TestCase
{
    use RefreshDatabase;


    public function test_user_can_purchase_product()
    {
        $user = User::create([
            'name' => '購入ユーザー',
            'email' => 'buyer@example.com',
            'password' => bcrypt('password'),
        ]);

        $owner = User::create([
            'name' => '出品者',
            'email' => 'owner@example.com',
            'password' => bcrypt('password'),
        ]);

        $condition = Condition::create([
            'name' => '良好',
        ]);

        $product = Product::create([
            'name' => 'テスト商品',
            'brand_name' => 'ブランドX',
            'price' => 2000,
            'description' => 'テスト説明',
            'image' => 'test.jpg',
            'sold' => 0,
            'user_id' => $owner->id,
            'condition_id' => $condition->id,
        ]);

        $response = $this->actingAs($user)->post("/purchase/{$product->id}", [
            'payment_method' => 'credit',
            'postcode' => '123-4567',
            'address' => '東京都港区1-1-1',
            'building' => 'テストビル',
        ]);

        $response->assertRedirect('/mypage');
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'sold' => 1,
        ]);
    }


    public function test_purchased_product_shows_as_sold()
    {
        $owner = User::create([
            'name' => '出品者',
            'email' => 'owner2@example.com',
            'password' => bcrypt('password'),
        ]);

        $condition = Condition::create([
            'name' => '良好',
        ]);

        $product = Product::create([
            'name' => 'テスト商品2',
            'brand_name' => 'ブランドY',
            'price' => 3000,
            'description' => '説明2',
            'image' => 'test.jpg',
            'sold' => 1,
            'user_id' => $owner->id,
            'condition_id' => $condition->id,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $this->assertStringContainsString('sold', $response->getContent());
    }


    public function test_purchased_product_appears_in_mypage_buy_tab()
    {
        $user = User::create([
            'name' => '購入者',
            'email' => 'buyer2@example.com',
            'password' => bcrypt('password'),
        ]);

        $owner = User::create([
            'name' => '出品者2',
            'email' => 'owner3@example.com',
            'password' => bcrypt('password'),
        ]);

        $condition = Condition::create([
            'name' => '良好',
        ]);

        $product = Product::create([
            'name' => 'テスト商品3',
            'brand_name' => 'ブランドZ',
            'price' => 4000,
            'description' => '説明3',
            'image' => 'test.jpg',
            'sold' => 1,
            'user_id' => $owner->id,
            'condition_id' => $condition->id,
        ]);

        Order::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'payment_method' => 'credit',
            'postcode' => '123-4567',
            'address' => '東京都港区2-2-2',
            'building' => '購入ビル',
        ]);

        $response = $this->actingAs($user)->get('/mypage?tab=buy');

        $response->assertStatus(200);
        $this->assertStringContainsString('テスト商品3', $response->getContent());
    }
}