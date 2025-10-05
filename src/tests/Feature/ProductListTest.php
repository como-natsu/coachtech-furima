<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;
use App\Models\Condition;

class ProductListTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_products()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $condition = Condition::create([
            'id' => 1,
            'name' => '良好',
        ]);

        Product::create([
            'name' => '商品A',
            'brand_name' => 'ブランドA',
            'price' => 1000,
            'description' => '説明A',
            'image' => 'test.jpg',
            'sold' => 0,
            'user_id' => $user->id,
            'condition_id' => $condition->id,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('商品A');
    }

    public function test_sold_label()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test2@example.com',
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
            'sold' => 1,
            'user_id' => $user->id,
            'condition_id' => $condition->id,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Sold');
    }


    public function test_hide_own_products()
    {
        $user1 = User::create([
            'name' => 'ユーザー1',
            'email' => 'user1@example.com',
            'password' => bcrypt('password'),
        ]);

        $user2 = User::create([
            'name' => 'ユーザー2',
            'email' => 'user2@example.com',
            'password' => bcrypt('password'),
        ]);

        $condition = Condition::create([
            'id' => 1,
            'name' => '良好',
        ]);


        Product::create([
            'name' => '自分の商品',
            'brand_name' => 'ブランドX',
            'price' => 3000,
            'description' => '説明X',
            'image' => 'test.jpg',
            'sold' => 0,
            'user_id' => $user1->id,
            'condition_id' => $condition->id,
        ]);


        Product::create([
            'name' => '他人の商品',
            'brand_name' => 'ブランドY',
            'price' => 4000,
            'description' => '説明Y',
            'image' => 'test.jpg',
            'sold' => 0,
            'user_id' => $user2->id,
            'condition_id' => $condition->id,
        ]);


        $this->actingAs($user1);
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertDontSee('自分の商品');
        $response->assertSee('他人の商品');
    }
}