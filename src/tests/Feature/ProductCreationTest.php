<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Condition;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_can_be_created_without_image()
    {
        // --- ユーザー作成 ---
        $user = User::create([
            'name' => '出品者ユーザー',
            'email' => 'seller@example.com',
            'password' => bcrypt('password'),
            'postcode' => '111-1111',
            'address' => '東京都新宿区テスト町1-1',
            'building' => 'テストビル101',
        ]);

        // --- カテゴリと商品の状態を作成 ---
        $category = Category::create(['name' => '家電']);
        $condition = Condition::create(['name' => '新品']);

        // --- ログイン ---
        $this->actingAs($user);

        // --- 出品画面にアクセスできるか確認 ---
        $response = $this->get('/sell');
        $response->assertStatus(200);
        $response->assertSee('商品の出品'); // ページタイトルなどに合わせて変更

        // --- 画像なしで商品を出品 ---
        $response = $this->post('/sell', [
            'name' => 'テスト商品',
            'brand_name' => 'テストブランド',
            'category_id' => [$category->id],
            'condition_id' => $condition->id,
            'price' => 5000,
            'description' => 'これはテスト用の商品説明です。',
            // 'image' は送らない
        ]);


        $response->assertRedirect('/');

        // --- DBに正しく保存されているか確認 ---
        $this->assertDatabaseHas('products', [
            'name' => 'テスト商品',
            'brand_name' => 'テストブランド',
            'condition_id' => $condition->id,
            'price' => 5000,
            'description' => 'これはテスト用の商品説明です。',
            'user_id' => $user->id,
        ]);

        // --- カテゴリの紐付けも確認 ---
        $product = $user->products()->where('name', 'テスト商品')->first();
        $this->assertTrue($product->categories->contains($category));
    }
}