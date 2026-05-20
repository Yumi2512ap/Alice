<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\StockController;

// メインメニュー一覧表示
Route::get('/', [MenuController::class, 'index'])
    ->name('home');

// 在庫あり一覧表示（賞味期限切れ）
Route::get('/stock', [StockController::class, 'index'])
    ->name('stock.index');

// 在庫なし一覧表示
Route::get('/stock/out', [StockController::class, 'out'])
    ->name('stock.out');

// 新規登録表示
Route::get('/stock/new', [StockController::class, 'create'])
    ->name('stock.new');

// 新規登録処理
Route::post('/stock/new', [StockController::class, 'store'])
    ->name('stock.store');

// 在庫編集表示
Route::get('/stock/{id}/edit', [StockController::class, 'edit'])
    ->name('stock.edit');

// 在庫編集処理（更新）
Route::put('/stock/{id}', [StockController::class, 'update'])
    ->name('stock.update');

// 出庫表示
Route::get('/stock/{id}/out/create', [StockController::class, 'outCreate'])
    ->name('stock.out.create');

// 出庫処理
Route::post('/stock/{id}/out', [StockController::class, 'outStore'])
    ->name('stock.out.store');

// 在庫削除
Route::delete('/stock/{id}', [StockController::class, 'destroy'])
    ->name('stock.destroy');

