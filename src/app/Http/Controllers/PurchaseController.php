<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;
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

        $postcode = $request->filled('postcode') ? $request->postcode : $user->postcode;
        $address  = $request->filled('address') ? $request->address : $user->address;
        $building = $request->filled('building') ? $request->building : $user->building;


        Order::create([
            'user_id'        => $user->id,
            'product_id'     => $product->id,
            'payment_method' => $request->payment_method,
            'postcode'       => $request->postcode,
            'address'        => $request->address,
            'building'       => $request->building,
]);

        if (!$product->sold) {
        $product->sold = true;
        $product->save();
    }

        return redirect('/')->with('message', '商品を購入しました');
    }
}