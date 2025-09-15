@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')

@if(session('message'))
<div class="alert-success">{{ session('message') }}</div>
@endif

<div class=purchase>
    <div class="item-image">
        <img src="{{ asset($product->image)}}" alt="{{ $product->name}}">
    </div>
    <div class="item-info">
        <h1 class="item-name">{{ $product->name}}</h1>
        @if($product->brand_name)
        <p class="item-brand">ブランド名 {{ $product->brand_name }}</p>
        @endif
        <p class="item-price">￥{{ number_format($product->price)}} (税込)</p>
    </div>

    <form action="{{ url('/purchase/'.$product->id) }}" method="POST">
    @csrf
    <div class="purchase-detail">
        <div class="purchase-content">
            <span class="purchase-content-title">支払方法</span>
        </div>
        <div class="purchase-content-category">
            <div class="purchase-content-select">
                <select name="payment_method" id="payment_method">
                    <option value="">選択してください</option>
                    @foreach($payment_methods as $value => $label)
                    <option value="{{ $value }}" {{ old('payment_method') == $value ? 'selected' : '' }}>{{ $label }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form__error">
                @error('payment_methods')
                {{ $message }}
                @enderror
            </div>
        </div>

        <div class="purchase-content">
            <span class="purchase-content-title">配送先</span>
            <div class="purchase-content-address">
                <p>〒 {{ $user->postcode }}</p>
                <p> {{ $user->address }}</p>
                @if($user->building)
                <p> {{ $user->building }}</p>
                @endif
            </div>
            @error('')
                {{ $message }}
            @enderror

            <div class="purchase-content-link">
                <a href="{{ url('/purchase/address/'.$product->id) }}">変更する</a>
            </div>

        </div>
    </div>
</div>


@endsection