<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    public function store(CommentRequest $request, Product $item)
    {

        $item->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->content,
    ]);

        return redirect()->back();
    }

        public function count(Product $product)
    {
    return response()->json(['count' => $product->comments()->count()]);
    }
}
