<?php

namespace App\Http\Controllers;

use App\Models\Product;


class LikeController extends Controller
{
    public function toggleLike(Product $item)
    {
        $user = auth()->user();
        $user->likes()->toggle($item->id);

        $likeCount = $item->likes()->count();

        return response()->json([
            'liked' => $user->likes()->where('product_id', $item->id)->exists(),
            'count' => $likeCount,
        ]);

    }
}