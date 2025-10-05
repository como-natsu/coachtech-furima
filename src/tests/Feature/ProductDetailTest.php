<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;
use App\Models\Condition;
use App\Models\Category;
use App\Models\Comment;

class ProductDetailTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_detail_shows_all_info()
    {
        // ユーザー作成
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // 商品状態作成
        $condition = Condition::create([
            'id' => 1,
            'name' => '良好',
        ]);

        // カテゴリ作成
        $category1 = Category::create(['id' => 1, 'name' => '家電']);
        $category2 = Category::create(['id' => 2, 'name' => '時計']);

        // 商品作成
        $product = Product::create([
            'name' => '腕時計A',
            'brand_name' => 'ブランドA',
            'price' => 1000,
            'description' => '説明A',
            'image' => 'test.jpg',
            'sold' => 0,
            'user_id' => $user->id,
            'condition_id' => $condition->id,
        ]);

        // 商品にカテゴリを紐付け
        $product->categories()->attach([$category1->id, $category2->id]);

        // コメント作成
        $commentUser = User::create([
            'name' => 'コメントユーザー',
            'email' => 'comment@example.com',
            'password' => bcrypt('password'),
        ]);

        Comment::create([
            'user_id' => $commentUser->id,
            'product_id' => $product->id,
            'content' => 'とても良い商品です！',
        ]);

        // 商品詳細ページにアクセス
        $response = $this->get('/item/' . $product->id);
        $response->assertStatus(200);

        // 必要な情報が表示されているか確認
        $response->assertSee('腕時計A');             // 商品名
        $response->assertSee('ブランドA');           // ブランド名
        $response->assertSee('￥1,000');               // 価格
        $response->assertSee('説明A');               // 商品説明
        $response->assertSee('良好');               // 商品状態
        $response->assertSee('家電');               // カテゴリ1
        $response->assertSee('時計');               // カテゴリ2
        $response->assertSee('コメントユーザー');   // コメントユーザー名
        $response->assertSee('とても良い商品です！'); // コメント内容
    }

    public function test_multiple_categories_displayed()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test2@example.com',
            'password' => bcrypt('password'),
        ]);

        $condition = Condition::create(['id' => 1, 'name' => '良好']);
        $category1 = Category::create(['id' => 1, 'name' => '家電']);
        $category2 = Category::create(['id' => 2, 'name' => '時計']);

        $product = Product::create([
            'name' => '腕時計B',
            'brand_name' => 'ブランドB',
            'price' => 2000,
            'description' => '説明B',
            'image' => 'test.jpg',
            'sold' => 0,
            'user_id' => $user->id,
            'condition_id' => $condition->id,
        ]);

        $product->categories()->attach([$category1->id, $category2->id]);

        $response = $this->get('/item/' . $product->id);
        $response->assertStatus(200);

        // 複数カテゴリが表示されているか確認
        $response->assertSee('家電');
        $response->assertSee('時計');
    }
}