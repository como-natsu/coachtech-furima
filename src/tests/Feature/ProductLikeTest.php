<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;
use App\Models\Condition;

class ProductLikeTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_like_a_product()
    {
        $user = User::factory()->create();
        $condition = Condition::create(['id' => 1, 'name' => '良好']);
        $product = Product::create([
            'name' => '商品A',
            'brand_name' => 'ブランドA',
            'price' => 1000,
            'description' => '説明A',
            'image' => 'test.jpg',
            'sold' => 0,
            'user_id' => $user->id,
            'condition_id' => $condition->id,
        ]);

        $this->actingAs($user);

        $response = $this->post("/item/{$product->id}/like");
        $response->assertStatus(200);

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }

    public function test_like_icon_changes_when_liked()
    {
        $user = User::factory()->create();
        $condition = Condition::create(['id' => 1, 'name' => '良好']);
        $product = Product::create([
            'name' => '商品B',
            'brand_name' => 'ブランドB',
            'price' => 2000,
            'description' => '説明B',
            'image' => 'test.jpg',
            'sold' => 0,
            'user_id' => $user->id,
            'condition_id' => $condition->id,
        ]);

        $this->actingAs($user);

        $this->post("/item/{$product->id}/like");

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }

    public function test_user_can_unlike_a_product()
    {
        $user = User::factory()->create();
        $condition = Condition::create(['id' => 1, 'name' => '良好']);
        $product = Product::create([
            'name' => '商品C',
            'brand_name' => 'ブランドC',
            'price' => 3000,
            'description' => '説明C',
            'image' => 'test.jpg',
            'sold' => 0,
            'user_id' => $user->id,
            'condition_id' => $condition->id,
        ]);

        $this->actingAs($user);


        $this->post("/item/{$product->id}/like");
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $this->post("/item/{$product->id}/like");
        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }
}