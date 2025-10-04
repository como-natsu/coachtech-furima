<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HelloTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

        public function testHello()
    {
        // 1. 会員登録ページを開く
        $response = $this->get('/register');
        $response->assertStatus(200);
        // 2. 名前を入力せずに他の必要項目を入力する
        // 3. 登録ボタンを押す
        $response = $this->post('/register', [
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'password',
        ]);
        $response->assertSessionHasErrors('name', 'お名前を入力してください');

    }
}
