@extends('layouts.app')

@section('content')
<div class="profile-edit">
    <h1>プロフィール設定</h1>
    @if(session('message'))
    <div class="alert-success">{{ session('message') }}</div>
    @endif
    <div class="profile">
        <form action="{{ url('/mypage/profile') }}" method="POST" enctype="multipart/form-data" class="profile-form">
            @csrf

            <div class="profile-field-image">
                @if($user->profile_image)
                <img src="{{ asset('storage/' . $user->profile_image) }}" alt="プロフィール画像" class="profile-image">
                @else
                <div class="default-profile-icon"></div>
                @endif
                <label for="profile_image" class="file-label">画像を選択</label>
                <input type="file" id="profile_image" name="profile_image" accept="image/*" class="file-input">
                <div class="form__error">
                    @error('profile_image')
                        {{ $message }}
                    @enderror
                </div>
            </div>

            <div class="profile-field">
                <label for="name">ユーザー名</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}">
                <div class="form__error">
                    @error('name')
                        {{ $message }}
                    @enderror
                </div>
            </div>

            <div class="profile-field">
                <label for="postcode">郵便番号</label>
                <input type="text" id="postcode" name="postcode" value="{{ old('postcode', $user->postcode) }}">
                <div class="form__error">
                    @error('postcode')
                        {{ $message }}
                    @enderror
                </div>
            </div>

            <div class="profile-field">
                <label for="address">住所</label>
                <input type="text" id="address" name="address" value="{{ old('address', $user->address) }}">
                <div class="form__error">
                    @error('address')
                        {{ $message }}
                    @enderror
                </div>
            </div>

            <div class="profile-field">
                <label for="building">建物名</label>
                <input type="text" id="building" name="building" value="{{ old('building', $user->building) }}">
            </div>


            <div class="update-button">
                <button type="submit" class="profile-submit">更新する</button>
            </div>
        </form>
    </div>
</div>
@endsection
