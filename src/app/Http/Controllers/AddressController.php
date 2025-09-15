<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Http\Requests\AddressRequest;

class AddressController extends Controller
{
    public function edit($item_id)
    {
        $user = Auth::user();
        $product = Product::findOrFail($item_id);
        return view('purchase.address', compact('user', 'product'));
    }

    public function update(AddressRequest $request, $item_id)
    {
        $user =Auth::user();
        $user->update($request->validated());

        return redirect("/purchase/{$item_id}")
        ->with('message','住所を更新しました');

    }
}
