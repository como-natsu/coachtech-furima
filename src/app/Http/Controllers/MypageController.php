<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileRequest;


class MypageController extends Controller
{
    public function index(Request $request)
{
    $user = Auth::user();

    $tab = $request->query('tab', 'sell');

    if ($tab === 'sell') {
        // 出品した商品
        $products = $user->products()->get();
    } else {
        // 購入した商品
        $products = $user->purchases()->get();
    }

    return view('mypage.mypage', compact('user', 'products', 'tab'));
}

    public function edit()
    {
        $user = Auth::user();

        $isFirstLogin = empty($user->username);

        return view('mypage.profile_edit',compact('user', 'isFirstLogin'));
    }

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();

        $data = $request->only(['name', 'postcode', 'address','building']);

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $data['profile_image'] = $path;
        }

        $user->update($data);

        return redirect('/mypage')->with('message', 'プロフィールを更新しました');
    }



}