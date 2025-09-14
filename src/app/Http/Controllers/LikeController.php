<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

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