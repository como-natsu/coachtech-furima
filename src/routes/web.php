<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\PurchaseController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ItemController::class,'index']);
Route::get('/item/{item_id}', [ItemController::class, 'show']);

Route::post('/register', [RegisteredUserController::class, 'store']);


Route::middleware(['auth'])->group(function(){
    Route::get('/mypage',[MypageController::class,'index']);
    Route::get('/mypage/profile', [MypageController::class, 'edit']);
    Route::patch('/mypage/profile', [MypageController::class, 'update']);
    Route::post('/item/{item}/like', [LikeController::class, 'toggleLike']);
    Route::post('/item/{item}/comment', [CommentController::class, 'store']);
    Route::get('/item/{item}/comment/count', [CommentController::class, 'count']);
    Route::get('/purchase/address/{item_id}', [AddressController::class, 'edit']);
    Route::patch('/purchase/address/{item_id}', [AddressController::class, 'update']);
    Route::get('/purchase/{item_id}', [PurchaseController::class, 'purchase']);
});