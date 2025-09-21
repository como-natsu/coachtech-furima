@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
<div class="sell">
    <form class="form" action="/sell" method="post" enctype="multipart/form-data">
        @csrf
        <div class="sell-heading">
            <h1>商品の出品</h1>
        </div>

        <div class="form-group">
            <div class="form-group-title">
                <span class="form-label">商品画像</span>
            </div>
            <div class="form-group-content">
                <div class="form-input">
                    <input type="file" name="image" />
                </div>
                <p class="form__error-message">
                    @error('image')
                    {{ $message }}
                    @enderror
                </p>
            </div>
        </div>
        <div class="form-group">
            <div class="form-group-title">
                <span class="form-label">商品の状態</span>
            </div>
            <div class="form-group-content">
                <select name="condition_id">
                    <option value="">選択してください</option>
                    @foreach($conditions as $condition)
                    <option value="{{ $condition->id }}" {{ old('condition_id') == $condition->id ? 'selected' : '' }}>
                        {{ $condition->name }}
                    </option>
                    @endforeach
                </select>
                <p class="form__error-message">
                    @error('condition_id')
                    {{ $message }}
                    @enderror
                </p>
            </div>
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
                    <input type="checkbox" name="category_id[]" value="{{ $category->id }}"
                        {{ in_array($category->id, $selectedCategoryIds) ? 'checked' : '' }}>
                    {{ $category->name }}
                </label>
                @endforeach
                <p class="form__error-message">
                    @error('category_id')
                    {{ $message }}
                    @enderror
                </p>
            </div>
        </div>



        <div class="form-group-wrapper">
            <div class=form-group-content>
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
                    <p class="form__error-message">
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
                    <p class="form__error-message">
                        @error('brand_name')
                        {{ $message }}
                        @enderror
                    </p>
                </div>
            </div>



            <div class="form-group">
                <div class="form-group-title">
                    <span class="form-label">商品説明</span>
                </div>
                <div class="form-group-content">
                    <textarea class="form__textarea" name="description" id="" cols="30"
                        rows="10">{{ old('description') }}</textarea>
                    <p class="form__error-message">
                        @error('description')
                        {{ $message }}
                        @enderror
                    </p>
                </div>
            </div>

            <div class="form-group">
                <div class="form-group-title">
                    <span class="form-label">値段</span>
                </div>
                <div class="form-group-content">
                    <div class="form-input">
                        <input type="text" name="price" value="{{ old('price') }}" />
                    </div>
                    <p class="form__error-message">
                        @error('price')
                        {{ $message }}
                        @enderror
                    </p>
                </div>
            </div>

            <div class="form-button">
                <button class="form-button-submit" type="submit">出品する</button>
            </div>
        </div>
    </form>
</div>
@endsection