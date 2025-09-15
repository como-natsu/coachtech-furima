@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endsection

@section('content')
<div class="address">
    <div class="address-heading">
        <h1>住所の変更</h1>
    </div>

    @if(session('message'))
    <div class="alert-success">{{ session('message') }}</div>
    @endif

    <div class="profile">
        <form class="profile-form" action="{{ url('/purchase/'.$product->id) }}" method="POST">
            @csrf

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