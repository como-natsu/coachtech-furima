@extends('layouts.auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')

<div class="register-form-content">
    <div class="register-form-heading">
        <h2>会員登録</h2>
    </div>
    <form class="form" action="/register" method="post">
        @csrf
        <div class="form-group">
            <div class="form-group-title">
                <span class="form-label-item">ユーザー名</span>
            </div>
            <div class="form-group-content">
                <div class="form-input-text">
                    <input type="text" name="name" maxlength="20" value="{{ old('name') }}" />
                </div>
                <div class="form-error">
                    @error('name')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="form-group-title">
                <span class="form-label-item">メールアドレス</span>
            </div>
            <div class="form-group-content">
                <div class="form-input-text">
                    <input type="text" name="email" value="{{ old('email') }}" />
                </div>
                <div class="form-error">
                    @error('email')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="form-group-title">
                <span class="form-label-item">パスワード</span>
            </div>
            <div class="form-group-content">
                <div class="form-input-text">
                    <input type="password" name="password" />
                </div>
                <div class="form-error">
                    @error('password')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="form-group-title">
                <span class="form-label-item">確認用パスワード</span>
            </div>
            <div class="form-group-content">
                <div class="form-input-text">
                    <input type="password" name="password_confirmation" />
                </div>
            </div>
        </div>
        <div class="form-button">
            <button class="form-button-submit" type="submit">登録</button>
        </div>
    </form>
    <div class="login-link">
        <a class="login-button-submit" href="/login">ログインはこちら</a>
    </div>
</div>
@endsection