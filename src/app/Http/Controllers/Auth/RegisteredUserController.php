<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;

class RegisteredUserController extends Controller
{
    // ユーザー登録の処理
    public function store(RegisterRequest $request)
    {
        // 1. 入力データを使ってユーザーを作る
        $user = User::create([
            'name' => $request->name,      // ユーザー名
            'email' => $request->email,    // メールアドレス
            'password' => Hash::make($request->password), // パスワードは暗号化
            'postcode' => '',
            'address' => '',
        ]);

        // 2. 作ったユーザーで自動ログイン
        Auth::login($user);

        // 3. 登録後はプロフィール編集画面に飛ばす
        return redirect('/mypage/profile');
    }
}
