@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')

<div class="maypage-content">
    <div class="mypage-header">
        <div class="profile-image">
            @if($user->profile_image)
            <img src="{{ asset('storage/'.$user->profile_image) }}" alt="プロフィール画像">
            @else
            <div class="default-profile-icon"></div>
            @endif
        </div>

        <h2 class="profile-name">{{ $user->name }}</h2>

        <div class="profile-button">
            <a href="{{ url('/mypage/profile') }}" class="edit-button">プロフィールを編集</a>
        </div>
    </div>

    <div class="tab-menu">
        <a href="{{ url('/mypage?tab=sell') }}" class="{{ $tab === 'sell' ? 'active' : '' }}">出品した商品</a>
        <a href="{{ url('/mypage?tab=buy') }}" class="{{ $tab === 'buy' ? 'active' : '' }}">購入した商品</a>
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