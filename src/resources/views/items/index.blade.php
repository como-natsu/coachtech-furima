@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection


@section('content')

@if(session('message'))
<div class="alert-success">{{ session('message') }}</div>
@endif

<div class="products-container">
    <div class="tab-menu">
        <a href="{{ url('/') }}" class="{{ $tab === 'recommend' ? 'active' : '' }}">おすすめ</a>
        <a href="{{ url('/?tab=mylist') }}" class="{{ $tab === 'mylist' ? 'active' : '' }}">マイリスト</a>
    </div>

    <div class="products">
        @forelse($products as $product)
        <div class="product-card">
            <a class="product-card-link" href="{{ url('/item/'.$product->id) }}">
                <img class="product-card-img" src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                <p class="product-card-name">{{ $product->name }}</p>
                @if($product->sold)
                <span class="sold-badge">Sold</span>
                @endif
            </a>
        </div>
        @empty
        <p>商品がありません。</p>
        @endforelse
    </div>
</div>
@endsection