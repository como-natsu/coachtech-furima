<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileRequest;


class MypageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('mypage.mypage',compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('mypage.profile_edit',compact('user'));
    }

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();
        $user->update($request->validated());

        return redirect('/mypage')->with('message', 'プロフィールを更新しました');
    }



}
