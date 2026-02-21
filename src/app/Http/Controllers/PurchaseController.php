<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Requests\PurchaseRequest;
use Stripe\StripeClient;
use Stripe\Stripe;

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

        // カード支払いの場合はStripe決済へ
        if ($request->payment_method === 'card') {
            return $this->processStripePayment($request, $product, $user);
        }

        // コンビニ支払いの場合は既存の処理
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

    private function processStripePayment($request, $product, $user)
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));

        // 日本語をURLエンコード
        $encoded_address = urlencode($request->address);
        $encoded_building = $request->building ? urlencode($request->building) : '';

        $checkout_session = $stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => ['name' => $product->name],
                    'unit_amount' => $product->price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => url("/purchase/{$product->id}/success?user_id={$user->id}&postcode={$request->postcode}&address={$encoded_address}&building={$encoded_building}"),
            'cancel_url' => url("/purchase/{$product->id}"),
        ]);

        return redirect($checkout_session->url);
    }

    public function success($item_id, Request $request)
    {
        $user = Auth::user();
        $product = Product::findOrFail($item_id);

        // URLデコード
        $address = urldecode($request->address);
        $building = $request->building ? urldecode($request->building) : null;

        // 注文を保存
        Order::create([
            'user_id'        => $request->user_id,
            'product_id'     => $product->id,
            'payment_method' => 'card',
            'postcode'       => $request->postcode,
            'address'        => $address,
            'building'       => $building,
        ]);

        if (!$product->sold) {
            $product->sold = true;
            $product->save();
        }

        return redirect('/')->with('message', '決済が完了しました');
    }
}