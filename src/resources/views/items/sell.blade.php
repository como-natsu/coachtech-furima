@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
<div class="sell">
    <form class="sell-form" action="/sell" method="post" enctype="multipart/form-data">
        @csrf
        <div class="sell-heading">
            <h1>商品の出品</h1>
        </div>

        <div class="form-group">
            <div class="form-group-title">
                <span class="form-label">商品画像</span>
            </div>
            <div class="image-upload-wrapper">
                <label for="image-input" class="custom-file-label">画像を選択する</label>
                <input type="file" id="image-input" name="image" class="custom-file-input" />
                <p class="form-error">
                    @error('image')
                    {{ $message }}
                    @enderror
                </p>
            </div>
        </div>

        <div class="form-group-wrapper">
            <div class="form-group-content-title">
                <h2>商品の詳細</h2>
            </div>

            <div class="form-group">
                <div class="form-group-title">
                    <span class="form-label">カテゴリー</span>
                </div>
                <div class="categories-wrapper">
                    @php
                    $selectedCategoryIds = old('category_id', []);
                    @endphp
                    @foreach($categories as $category)
                    <label class="category-button">
                        <input type="checkbox" class="category-checkbox" name="category_id[]"
                            value="{{ $category->id }}">
                        <span class="category-label">{{ $category->name }}</span>
                    </label>
                    @endforeach
                    <p class="form-error">
                        @error('category_id')
                        {{ $message }}
                        @enderror
                    </p>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="form-group-title">
                <span class="form-label">商品の状態</span>
            </div>
            <div class="form-group-content">
                <div class="form-input">
                    <select name="condition_id">
                        <option value="">選択してください</option>
                        @foreach($conditions as $condition)
                        <option value="{{ $condition->id }}"
                            {{ old('condition_id') == $condition->id ? 'selected' : '' }}>
                            {{ $condition->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <p class="form-error">
                    @error('condition_id')
                    {{ $message }}
                    @enderror
                </p>
            </div>
        </div>




        <div class="form-group-wrapper">
            <div class="form-group-content-title">
                <h2>商品名と説明</h2>
            </div>

            <div class="form-group">
                <div class="form-group-title">
                    <span class="form-label">商品名</span>
                </div>
                <div class="form-group-content">
                    <div class="form-input">
                        <input type="text" name="name" value="{{ old('name') }}">
                    </div>
                    <p class="form-error">
                        @error('name')
                        {{ $message }}
                        @enderror
                    </p>
                </div>
            </div>

            <div class="form-group">
                <div class="form-group-title">
                    <span class="form-label">ブランド名</span>
                </div>
                <div class="form-group-content">
                    <div class="form-input">
                        <input type="text" name="brand_name" value="{{ old('brand_name') }}">
                    </div>
                    <p class="form-error">
                        @error('brand_name')
                        {{ $message }}
                        @enderror
                    </p>
                </div>
            </div>



            <div class="form-group">
                <div class="form-group-title">
                    <span class="form-label">商品の説明</span>
                </div>
                <div class="form-group-content">
                    <textarea class="form__textarea" name="description" id="" cols="30"
                        rows="10">{{ old('description') }}</textarea>
                    <p class="form-error">
                        @error('description')
                        {{ $message }}
                        @enderror
                    </p>
                </div>
            </div>

            <div class="form-group">
                <div class="form-group-title">
                    <span class="form-label">販売価格</span>
                </div>
                <div class="form-group-content">
                    <div class="form-input">
                        <input type="number" name="price" value="{{ old('price') }}" />
                    </div>
                    <p class="form-error">
                        @error('price')
                        {{ $message }}
                        @enderror
                    </p>
                </div>
            </div>

            <div class="form-button">
                <button class="form-submit-button" type="submit">出品する</button>
            </div>
        </div>
    </form>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', () => {
    const fileInput = document.getElementById('image-input');
    const label = document.querySelector('.custom-file-label');

    fileInput.addEventListener('change', (e) => {
        const fileName = e.target.files[0]?.name || '画像を選択';
        label.textContent = fileName;
    });
});
</script>