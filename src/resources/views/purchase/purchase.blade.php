@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')

@if(session('message'))
<div class="alert-success">{{ session('message') }}</div>
@endif

<div class=purchase>
    <form action="{{ url('/purchase/'.$product->id) }}" method="POST">
        @csrf
        <div class="purchase-detail">
            <div class="purchase-left">
                <div class="item-info-wrapper">
                    <div class="item-image">
                        <img src="{{ asset($product->image)}}" alt="{{ $product->name}}">
                    </div>
                    <div class="item-info">
                        <h1 class="item-info-name">{{ $product->name}}</h1>
                        <p class="item-info-price">￥{{ number_format($product->price)}}</p>
                    </div>
                </div>

                <div class="purchase-info">
                    <div class="purchase-content">
                        <span class="purchase-content-title">支払方法</span>
                        <select name="payment_method" id="payment_method">
                            <option value="">選択してください</option>
                            @foreach($payment_methods as $value => $label)
                            <option value="{{ $value }}" {{ old('payment_method') == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                            @endforeach
                        </select>
                        <div class="form-error">
                            @error('payment_method')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>


                    <div class="purchase-content">
                        <div class="purchase-content-header">
                            <span class="purchase-content-title">配送先</span>
                            <a class="purchase-content-link"
                                href="{{ url('/purchase/address/'.$product->id) }}">変更する</a>
                        </div>
                        <p>〒 {{ $user->postcode }}</p>
                        <p>{{ $user->address }}</p>
                        @if($user->building)
                        <p>{{ $user->building }}</p>
                        @endif

                        <input type="hidden" name="postcode" value="{{ $user->postcode }}">
                        <input type="hidden" name="address" value="{{ $user->address }}">
                        <input type="hidden" name="building" value="{{ $user->building }}">

                        <div class="form-error">
                            @error('postcode')
                            {{ $message }}
                            @enderror
                        </div>
                        <div class="form-error">
                            @error('address')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
            </div>


            <div class="purchase-summary">
                <p>商品代金  ￥{{ number_format($product->price) }} </p>
                <p>支払方法  <span id="selected-method">未選択</span></p>
                <button class="purchase-summary-button" type="submit">購入する</button>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('payment_method');
    const display = document.getElementById('selected-method');

    select.addEventListener('change', function() {
        const selectedText = select.options[select.selectedIndex].text;
        display.textContent = this.value ? selectedText : '未選択';
    });
});
</script>

@endsection