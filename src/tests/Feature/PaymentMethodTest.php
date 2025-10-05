<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Condition;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentMethodTest extends TestCase
{
    use RefreshDatabase;

    public function test_selected_payment_method()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'user3@example.com',
            'password' => bcrypt('password'),
            'postcode' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'ビル101',
        ]);

        $condition = Condition::create(['name' => '良好']);

        $product = Product::create([
            'name' => 'テスト商品',
            'price' => 1000,
            'description' => '説明A',
            'image'  => 'test.jpg',
            'sold' => 0,
            'user_id' => $user->id,
            'condition_id'=> $condition->id
        ]);


        $this->actingAs($user);


        $response = $this->get("/purchase/{$product->id}");

        $response->assertStatus(200);
        $response->assertSee('コンビニ支払い');
        $response->assertSee('カード支払い');


        $response = $this->post("/purchase/{$product->id}", [
            'payment_method' => 'card',
            'postcode' => $user->postcode,
            'address' => $user->address,
            'building' => $user->building,
        ]);


        $response->assertRedirect('/mypage');


        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'payment_method' => 'card',
        ]);
    }
}