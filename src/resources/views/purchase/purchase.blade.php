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
                        <p class="item-info-price">￥{{ number_format($product->price)}} (税込)</p>
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
                        @error('payment_method')<p>{{ $message }}</p>@enderror
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
                    </div>
                </div>
            </div>


            <div class="purchase-summary">
                <p>商品金額：￥{{ number_format($product->price) }} (税込)</p>
                <p>選択した支払方法：<span id="selected-method">未選択</span></p>
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