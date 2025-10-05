<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;
use App\Models\Condition;

class ProductSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_by_name()
    {
        $condition = Condition::create(['id' => 1, 'name' => '良好']);

        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        Product::create([
            'name' => '腕時計A',
            'brand_name' => 'ブランドA',
            'price' => 1000,
            'description' => '説明A',
            'image' => 'test.jpg',
            'sold' => 0,
            'user_id' => $user->id,
            'condition_id' => $condition->id,
        ]);

        Product::create([
            'name' => '腕時計B',
            'brand_name' => 'ブランドB',
            'price' => 2000,
            'description' => '説明B',
            'image' => 'test.jpg',
            'sold' => 0,
            'user_id' => $user->id,
            'condition_id' => $condition->id,
        ]);

        // 検索
        $response = $this->get('/?search=腕時計A');

        $response->assertStatus(200);
        $response->assertSee('腕時計A');
        $response->assertDontSee('腕時計B');
    }

    public function test_search_keyword_persist_in_mylist()
    {
        $condition = Condition::create(['id' => 1, 'name' => '良好']);

        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

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

        $user->likes()->attach($product->id);

        $this->actingAs($user);
        $response = $this->get('/?tab=mylist&search=腕時計A');

        $response->assertStatus(200);
        $response->assertSee('腕時計A');
    }
}