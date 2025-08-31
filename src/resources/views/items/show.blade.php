@extends('layouts.app')

@section('content')
<div class="item-detail">
    <div class="item-image">
        <img src="{{ asset($product->image)}}" alt="{{ $product->name}}">
    </div>
    <div class="item-info">
        <h1 class="item-name">{{ $product->name}}</h1>
        @if($product->brand_name)
        <p class="item-brand">ブランド名 {{ $product->brand_name }}</p>
        @endif
        <p class="item-price">￥{{ number_format($product->price)}}</p>
        <div class="item-stats">
            <span class="likes">いいね: {{ $product->likes->count() }}</span>
            <span class="comments">コメント: {{ $product->comments->count() }}</span>
        </div>

        @if($product->sold)
        <span class="sold-badge">Sold</span>
        @else
        @auth
        <form action="{{ url('/purchase/'.$product->id) }}" method="GET">
            <button type="submit" class="btn-purchase">購入はこちら</button>
        </form>
        @else
        <a href="{{ url('/login') }}" class="btn-purchase disabled">購入はこちら</a>
        @endauth
        @endif

        <div class="item-content">
            <h2 class="item-title">商品説明</h2>
            <p class="item-description">{{ $product->description }}</p>
        </div>
        <div class="item-content">
            <h2 class="item-title">商品状態</h2>
            <p class="item-categories">
                カテゴリー
                @foreach($product->categories as $category)
                {{ $category->name }}@if(!$loop->last), @endif
                @endforeach
            </p>
            <p class="item-condition">商品の状態 {{ $product->condition->name }}</p>
        </div>
    </div>

    <div class="item-comments">
        <h2 class="item-title">コメント</h2>
        @foreach($product->comments as $comment)
        <div class="comment">
            <p class="comment-user">{{ $comment->user->name }}:</p>
            <p class="comment-text">{{ $comment->comment }}</p>
        </div>
        @endforeach
        <p class=item-comment>商品へのコメント</p>
        <form action="{{ url('/item/'.$product->id.'/comment') }}" method="POST">
            @csrf
            <textarea name="content" placeholder="コメントを入力してください" rows="3" style="width:100%;"></textarea>
            <button type="submit" style="margin-top:5px;">コメントを送信</button>
        </form>
    </div>
</div>





@endsection