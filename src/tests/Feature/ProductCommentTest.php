<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;
use App\Models\Condition;
use App\Models\Comment;

class ProductCommentTest extends TestCase
{
    use RefreshDatabase;

    // ログイン済みユーザーはコメントを送信できる
    public function test_login_user_can_send_comment()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
        ]);

        $owner = User::create([
            'name' => '商品オーナー',
            'email' => 'owner@example.com',
            'password' => bcrypt('password'),
        ]);

        $condition = Condition::create([
            'id' => 1,
            'name' => '良好',
        ]);

        $product = Product::create([
            'name' => '商品A',
            'brand_name' => 'ブランドA',
            'price' => 1000,
            'description' => '説明A',
            'image' => 'test.jpg',
            'sold' => 0,
            'user_id' => $owner->id,
            'condition_id' => $condition->id,
        ]);

        $response = $this->actingAs($user)->post("/item/{$product->id}/comment", [
            'content' => 'とても良い商品です！',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('comments', [
            'product_id' => $product->id,
            'user_id' => $user->id,
            'content' => 'とても良い商品です！',
        ]);
    }

    // ログイン前のユーザーはコメント送信できない
    public function test_guest_cannot_send_comment()
    {
        $owner = User::create([
            'name' => '商品オーナー',
            'email' => 'owner2@example.com',
            'password' => bcrypt('password'),
        ]);

        $condition = Condition::create([
            'id' => 1,
            'name' => '良好',
        ]);

        $product = Product::create([
            'name' => '商品B',
            'brand_name' => 'ブランドB',
            'price' => 2000,
            'description' => '説明B',
            'image' => 'test.jpg',
            'sold' => 0,
            'user_id' => $owner->id,
            'condition_id' => $condition->id,
        ]);

        $response = $this->post("/item/{$product->id}/comment", [
            'content' => 'ゲストのコメント',
        ]);

        $response->assertRedirect('/login'); // ゲストはログインページへリダイレクト
        $this->assertDatabaseMissing('comments', [
            'product_id' => $product->id,
            'content' => 'ゲストのコメント',
        ]);
    }

    // コメントが空の場合、バリデーションエラー
    public function test_comment_required()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'user2@example.com',
            'password' => bcrypt('password'),
        ]);

        $owner = User::create([
            'name' => '商品オーナー',
            'email' => 'owner3@example.com',
            'password' => bcrypt('password'),
        ]);

        $condition = Condition::create([
            'id' => 1,
            'name' => '良好',
        ]);

        $product = Product::create([
            'name' => '商品C',
            'brand_name' => 'ブランドC',
            'price' => 3000,
            'description' => '説明C',
            'image' => 'test.jpg',
            'sold' => 0,
            'user_id' => $owner->id,
            'condition_id' => $condition->id,
        ]);

        $response = $this->actingAs($user)
            ->from("/item/{$product->id}")
            ->post("/item/{$product->id}/comment", [
                'content' => '',
            ]);

        $response->assertRedirect("/item/{$product->id}");
        $response->assertSessionHasErrors('content');
    }

    // コメントが255文字以上の場合、バリデーションエラー
    public function test_comment_max_length_validation()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'user3@example.com',
            'password' => bcrypt('password'),
        ]);

        $owner = User::create([
            'name' => '商品オーナー',
            'email' => 'owner4@example.com',
            'password' => bcrypt('password'),
        ]);

        $condition = Condition::create([
            'id' => 1,
            'name' => '良好',
        ]);

        $product = Product::create([
            'name' => '商品D',
            'brand_name' => 'ブランドD',
            'price' => 4000,
            'description' => '説明D',
            'image' => 'test.jpg',
            'sold' => 0,
            'user_id' => $owner->id,
            'condition_id' => $condition->id,
        ]);

        $longComment = str_repeat('a', 256);

        $response = $this->actingAs($user)
            ->from("/item/{$product->id}")
            ->post("/item/{$product->id}/comment", [
                'content' => $longComment,
            ]);

        $response->assertRedirect("/item/{$product->id}");
        $response->assertSessionHasErrors('content');
    }
}