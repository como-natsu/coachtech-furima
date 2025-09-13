@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile_edit.css') }}">
@endsection

@section('content')
<div class="profile-edit">
    <div class="profile-heading">
        <h1>プロフィール設定</h1>
    </div>

    @if(session('message'))
    <div class="alert-success">{{ session('message') }}</div>
    @endif

    <div class="profile">
        <form class="profile-form" action="{{ url('/mypage/profile') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <div class="form-group-content">
                    <div class="profile-image-container">
                        @if($user->profile_image)
                        <img src="{{ asset('storage/'.$user->profile_image) }}" alt="プロフィール画像"
                            class="profile-image">
                        @else
                        <div class="default-profile-icon"></div>
                        @endif
                        <label for="profile_image" class="file-label">画像を選択する</label>
                        <input type="file" id="profile_image" name="profile_image" accept="image/*" class="file-input">
                    </div>
                    <div class="form-error">
                        @error('profile_image')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="form-group-title">
                    <span class="form-label-item">ユーザー名</span>
                </div>
                <div class="form-group-content">
                    <div class="form-input-text">
                        <input type="text" name="name" value="{{ old('name', $user->name) }}">
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
                    <span class="form-label-item">郵便番号</span>
                </div>
                <div class="form-group-content">
                    <div class="form-input-text">
                        <input type="text" name="postcode" value="{{ old('postcode', $user->postcode) }}">
                    </div>
                    <div class="form-error">
                        @error('postcode')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="form-group-title">
                    <span class="form-label-item">住所</span>
                </div>
                <div class="form-group-content">
                    <div class="form-input-text">
                        <input type="text" name="address" value="{{ old('address', $user->address) }}">
                    </div>
                    <div class="form-error">
                        @error('address')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="form-group-title">
                    <span class="form-label-item">建物名</span>
                </div>
                <div class="form-group-content">
                    <div class="form-input-text">
                        <input type="text" id="building" name="building" value="{{ old('building', $user->building) }}">
                    </div>
                </div>
            </div>

            <div class="form-button">
                <button type="submit" class="form-button-submit">更新する</button>
            </div>

        </form>
    </div>
</div>
@endsection