<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'recommend'); // デフォルトはおすすめ
        $products = collect(); // 空で初期化

        if ($tab === 'mylist') {
            if (auth()->check()) {
                // ログインしている → マイリストを取得
                $products = auth()->user()->likes()
                    ->with('product.condition', 'product.user')
                    ->get()
                    ->pluck('product'); // LikeモデルからProductモデルを取り出す
            }
            // 未認証 → 空のまま
        } else {
            // おすすめ一覧（全商品）→ 自分の商品を除外
            $query = Product::with('condition', 'user');

            if (auth()->check()) {
                $query->where('user_id', '!=', auth()->id());
            }

            $products = $query->latest()->get();
        }

        return view('items.index', compact('products', 'tab'));
    }


}