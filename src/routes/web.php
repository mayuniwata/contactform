<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;

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

/*
|--------------------------------------------------------------------------
| お問い合わせ系
|--------------------------------------------------------------------------
*/

// 入力画面
Route::get('/', [ContactController::class, 'index']);

// 確認画面
Route::post('/confirm', [ContactController::class, 'confirm']);

// サンクス
Route::post('/thanks', [ContactController::class, 'store']);

// 修正
Route::post('/back', [ContactController::class, 'back']);

/*
|--------------------------------------------------------------------------
| 管理画面
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    // 管理画面
    Route::get('/admin', [AdminController::class, 'index']);

    // 検索
    Route::get('/search', [AdminController::class, 'search']);

    // リセット
    Route::get('/reset', [AdminController::class, 'reset']);

    // 削除
    Route::post('/delete', [AdminController::class, 'destroy']);

    // エクスポート
    Route::get('/export', [AdminController::class, 'export']);
});