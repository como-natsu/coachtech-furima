<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\ExhibitionRequest;

class ItemController extends Controller
{
    public function index(Request $request)
{
    $tab = $request->query('tab', 'recommend');

    $keyword = $request->input('search');

    $products = collect();

    if ($tab === 'mylist') {
        if (auth()->check()) {
            $products = auth()->user()->likes()
                ->with('product.condition', 'product.user', 'product.categories')
                ->get()
                ->pluck('product');
        }
    } else {
        $query = Product::with('condition', 'user', 'categories');

        if (auth()->check()) {
            $query->where('user_id', '!=', auth()->id());
        }

        if ($keyword) {
            $query->where(function($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%")
                    ->orWhereHas('categories', function($q2) use ($keyword) {
                $q2->where('name', 'like', "%{$keyword}%");
                    });
            });
        }

        $products = $query->latest()->get();
    }
    return view('items.index', compact('products', 'tab'));
}


    public function show($item_id)
    {
        $product = Product::with('user','condition')->findOrFail($item_id);

        return view('items.show',compact('product'));

    }


}