<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function register()
    {
        return view('auth.register');
    }


    public function store(RegisterRequest $request)
    {
        User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        ]);

        return redirect('/login');
    }


    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/');
        }

        return back()->withErrors([
        'email' => 'メールアドレスまたはパスワードが正しくありません。',
        ])->onlyInput('email');

    }
}
