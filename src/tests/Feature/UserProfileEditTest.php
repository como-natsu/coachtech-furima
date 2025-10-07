<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserProfileEditTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_profile_edit()
    {

        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'testuser@example.com',
            'password' => bcrypt('password'),
            'postcode' => '123-4567',
            'address' => '東京都渋谷区神南1-1-1',
            'building' => 'テストビル101',
            'profile_image' => 'profile_images/test.jpg',
        ]);


        $this->actingAs($user);


        $response = $this->get('/mypage/profile');

        $response->assertStatus(200);

        $response->assertSee('テストユーザー');
        $response->assertSee('123-4567');
        $response->assertSee('東京都渋谷区神南1-1-1');
        $response->assertSee('テストビル101');
        $response->assertSee('profile_images/test.jpg');
    }
}
