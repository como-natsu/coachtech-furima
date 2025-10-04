<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\PurchaseRequest;

class PurchaseController extends Controller
{
    public function show($item_id) {
        $user = Auth::user();
        $product = Product::findOrFail($item_id);

        $payment_methods = [
        'convenience_store' => 'コンビニ支払い',
        'card' => 'カード支払い',
        ];

        return view('purchase.purchase', compact('user', 'product','payment_methods'));
    }

    public function store(PurchaseRequest $request, $item_id) {

        $user = Auth::user();
        $product = Product::findOrFail($item_id);


        Order::create([
        'user_id'        => $user->id,
        'product_id'     => $product->id,
        'payment_method' => $request->payment_method,
        'postcode'       => $user->postcode,
        'address'        => $user->address,
        'building'       => $user->building,
    ]);

        if (!$product->sold) {
        $product->sold = true;
        $product->save();
    }

        return redirect('/mypage')->with('message', '商品を購入しました');
    }
}