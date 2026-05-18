<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', function () {
    return 'Hello Laravel!';
});

Route::get('/hello-controller', [\App\Http\Controllers\HelloController::class, 'index']);
Route::get('/test', [TestController::class, 'test'])
    ->name('test');




