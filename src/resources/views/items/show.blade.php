@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')
<div class="item-detail-wrapper">
    <div class="item-detail">
        <div class="item-image">
            <img class="item-image-content" src="{{ asset($product->image)}}" alt="{{ $product->name}}">
        </div>
        <div class="item-info">
            <h1 class="item-name">{{ $product->name}}</h1>
            @if($product->brand_name)
            <p class="item-brand">ブランド名 {{ $product->brand_name }}</p>
            @endif
            <p class="item-price">￥{{ number_format($product->price)}} (税込)</p>

            <div class="like-comment-container">
                @auth
                <form action="{{ url('/item/'.$product->id.'/like') }}" method="POST" class="like-form">
                    @csrf
                    <div class="icon-with-count">
                        <button type="submit" class="like-button">
                            <img class="like-button-image like-icon {{ auth()->user()->likes->contains($product->id) ? 'liked' : '' }}"
                                src="{{ asset('storage/icon/like.png') }}" alt="いいね">
                        </button>
                        <span class="like-count">{{ $product->likes->count() }}</span>
                    </div>
                </form>
                @else
                <div class="icon-with-count">
                    <a href="{{ url('/login') }}" class="like-button">
                        <img class="like-button-image" src="{{ asset('storage/icon/like.png') }}" alt="いいね">
                    </a>
                    <span class="like-count">{{ $product->likes->count() }}</span>
                </div>
                @endauth

                <div class="icon-with-count">
                    <img class="comment-icon-count-image" src="{{ asset('storage/icon/comment.png') }}" alt="コメントアイコン">
                    <span class="comments">{{ $product->comments->count() }}</span>
                </div>
            </div>

            <div class="purchase-wrapper">
                @if($product->sold)
                <span class="sold-badge">Sold</span>
                @else
                @auth
                <form action="{{ url('/purchase/'.$product->id) }}" method="GET">
                    <button type="submit" class="btn-purchase">購入手続きへ</button>
                </form>
                @else
                <a href="{{ url('/login') }}" class="btn-purchase-disabled">購入手続きへ</a>
                @endauth
                @endif
            </div>

            <div class="item-content">
                <h2 class="item-title">商品説明</h2>
                <p class="item-description">{{ $product->description }}</p>
            </div>

            <div class="item-content">
                <h2 class="item-title">商品状態</h2>
                <p class="item-categories">
                    カテゴリー
                    @foreach($product->categories as $category)
                    <span class="category-label">{{ $category->name }}</span>
                    @endforeach
                </p>
                <p class="item-condition">商品の状態 {{ $product->condition->name }}</p>
            </div>

            <div class="item-comments">
                <h2 class="item-title">コメント( {{ $product->comments->count() }} )</h2>
                <div class="comment-list">
                    @foreach($product->comments as $comment)
                    <div class="comment-content">
                        <div class="comment-header">
                            <div class="profile-image">
                                @if($comment->user->profile_image)
                                <img class="profile-image-img"
                                    src="{{ asset('storage/'.$comment->user->profile_image) }}" alt="プロフィール画像">
                                @else
                                <div class="default-profile-icon"></div>
                                @endif
                            </div>
                            <div class="comment-content-user">
                                <p class="comment-user">{{ $comment->user->name }}</p>
                            </div>
                        </div>
                        <div class="comment-content-text">
                            <p class="comment-text">{{ $comment->content }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <p class="item-comment">商品へのコメント</p>
                <form class="comment-form" action="{{ url('/item/'.$product->id.'/comment') }}" method="POST">
                    @csrf
                    <textarea class="comment-textarea" name="content"></textarea>
                    <div class="form-error">
                        @error('content')
                        {{ $message }}
                        @enderror
                    </div>
                    <button class="btn-submit" type="submit">コメントを送信する</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.like-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const productId = this.action.split('/').slice(-2, -1)[0];
            const token = this.querySelector('input[name="_token"]').value;
            const button = this.querySelector('.like-button');
            const img = button.querySelector('.like-icon');
            const countSpan = this.querySelector('.like-count');

            fetch(`/item/${productId}/like`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({})
                })
                .then(res => res.json())
                .then(data => {
                    img.classList.toggle('liked', data.liked);
                    countSpan.textContent = data.count;
                });
        });
    });
});
</script>
@endsection