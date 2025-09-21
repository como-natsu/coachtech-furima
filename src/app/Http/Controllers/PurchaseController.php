<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Http\Requests\RegisterRequest;

class PurchaseController extends Controller
{
    public function purchase($item_id) {
        $user = Auth::user();
        $product = Product::findOrFail($item_id);

        $payment_methods = [
        'convenience_store' => 'コンビニ支払い',
        'card' => 'カード支払い',
];

        return view('purchase.purchase', compact('user', 'product','payment_methods'));
    }
}
