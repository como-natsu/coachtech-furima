@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection


@section('content')
<div class="tab-menu">
    <a href="{{ url('/?tab=recommend') }}" class="{{ $tab === 'recommend' ? 'active' : '' }}">おすすめ</a>
    <a href="{{ url('/?tab=mylist') }}" class="{{ $tab === 'mylist' ? 'active' : '' }}">マイリスト</a>
</div>

<div class="products">
    @forelse($products as $product)
        <div class="product-card">
            <a href="{{ url('/item/'.$product->id) }}">
                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                <p>{{ $product->name }}</p>
                @if($product->sold)
                    <span class="sold-badge">Sold</span>
                @endif
            </a>
        </div>
    @empty
        <p>商品がありません。</p>
    @endforelse
</div>
