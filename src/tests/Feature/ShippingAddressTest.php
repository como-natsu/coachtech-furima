<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Condition;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShippingAddressTest extends TestCase
{
    use RefreshDatabase;


    public function test_updated_address_on_purchase_page()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'postcode' => '111-1111',
            'address' => '東京都新宿区',
            'building' => '旧ビル101',
        ]);

        $condition = Condition::create(['name' => '良好']);

        $product = Product::create([
            'name' => 'テスト商品',
            'price' => 2000,
            'description' => 'テスト説明',
            'image' => 'test.jpg',
            'sold' => 0,
            'user_id' => $user->id,
            'condition_id' => $condition->id,
        ]);

        $this->actingAs($user);

        // ① 送付先住所変更画面で住所を更新（想定）
        $user->update([
            'postcode' => '999-9999',
            'address' => '北海道札幌市新住所',
            'building' => '新ビル999',
        ]);

        // ② 商品購入画面を開く
        $response = $this->get("/purchase/{$product->id}");

        // ③ 更新後の住所が反映されていることを確認
        $response->assertStatus(200);
        $response->assertSee('999-9999');
        $response->assertSee('北海道札幌市新住所');
        $response->assertSee('新ビル999');
    }



    public function test_updated_address_is_stored_with_order()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'user2@example.com',
            'password' => bcrypt('password'),
            'postcode' => '111-1111',
            'address' => '東京都新宿区',
            'building' => '旧ビル101',
        ]);

        $condition = Condition::create(['name' => '良好']);

        $product = Product::create([
            'name' => 'テスト商品2',
            'price' => 3000,
            'description' => 'テスト説明2',
            'image' => 'test2.jpg',
            'sold' => 0,
            'user_id' => $user->id,
            'condition_id' => $condition->id,
        ]);

        $this->actingAs($user);

        // ① 送付先住所を変更（住所変更画面の代わり）
        $user->update([
            'postcode' => '888-8888',
            'address' => '大阪府大阪市新住所',
            'building' => '新大阪ビル808',
        ]);

        // ② 商品を購入
        $response = $this->post("/purchase/{$product->id}", [
            'payment_method' => 'card',
            'postcode' => $user->postcode,
            'address' => $user->address,
            'building' => $user->building,
        ]);

        $response->assertRedirect('/');

        // ③ 注文に新住所が反映されていることを確認
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'postcode' => '888-8888',
            'address' => '大阪府大阪市新住所',
            'building' => '新大阪ビル808',
        ]);
    }
}