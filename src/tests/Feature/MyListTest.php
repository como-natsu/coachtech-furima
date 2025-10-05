<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;
use App\Models\Condition;

class MyListTest extends TestCase
{
    use RefreshDatabase;

    public function test_liked_products()
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

        $product1 = Product::create([
            'name' => '商品A',
            'brand_name' => 'ブランドA',
            'price' => 1000,
            'description' => '説明A',
            'image' => 'test.jpg',
            'sold' => 0,
            'user_id' => $user->id,
            'condition_id' => $condition->id,
        ]);

        $product2 = Product::create([
            'name' => '商品B',
            'brand_name' => 'ブランドB',
            'price' => 2000,
            'description' => '説明B',
            'image' => 'test.jpg',
            'sold' => 0,
            'user_id' => $user->id,
            'condition_id' => $condition->id,
        ]);


        $user->likes()->attach($product1->id);

        $response = $this->actingAs($user)->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertSee('商品A');
        $response->assertDontSee('商品B');
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
            'name' => '商品C',
            'brand_name' => 'ブランドC',
            'price' => 3000,
            'description' => '説明C',
            'image' => 'test.jpg',
            'sold' => 1,
            'user_id' => $user->id,
            'condition_id' => $condition->id,
        ]);

        $user->likes()->attach($product->id);

        $response = $this->actingAs($user)->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertSee('Sold');
    }


    public function test_no_products_when_guest()
    {
        $response = $this->get('/?tab=mylist');
        $response->assertStatus(200);
        $response->assertSee('商品がありません。');
    }
}