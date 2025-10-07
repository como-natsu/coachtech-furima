<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Condition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_can_be_created()
    {
        // --- ストレージを偽装 ---
        Storage::fake('public');

        // --- ユーザー作成 ---
        $user = User::create([
            'name' => '出品者ユーザー',
            'email' => 'seller@example.com',
            'password' => bcrypt('password'),
            'postcode' => '111-1111',
            'address' => '東京都新宿区テスト町1-1',
            'building' => 'テストビル101',
        ]);

        // --- カテゴリと商品の状態作成 ---
        $category = Category::create(['name' => '家電']);
        $condition = Condition::create(['name' => '新品']);

        // --- ログイン ---
        $this->actingAs($user);

        // --- 出品画面確認 ---
        $response = $this->get('/sell');
        $response->assertStatus(200);
        $response->assertSee('商品の出品');

        // --- 画像ファイルをアップロード ---
        $file = UploadedFile::fake()->image('product.jpg');

        // --- 出品データ送信 ---
        $response = $this->post('/sell', [
            'name' => 'テスト商品',
            'brand_name' => 'テストブランド',
            'category_id' => [$category->id],
            'condition_id' => $condition->id,
            'price' => 5000,
            'description' => 'これはテスト用の商品説明です。',
            'image' => $file,
        ]);

        // --- 保存後のリダイレクト確認 ---
        $response->assertRedirect('/mypage');

        // --- DBに正しく保存されたか確認 ---
        $this->assertDatabaseHas('products', [
            'name' => 'テスト商品',
            'brand_name' => 'テストブランド',
            'condition_id' => $condition->id,
            'price' => 5000,
            'description' => 'これはテスト用の商品説明です。',
            'user_id' => $user->id,
        ]);

        // --- カテゴリとの紐付け確認 ---
        $product = $user->products()->first();
        $this->assertTrue($product->categories->contains($category));
    }
}