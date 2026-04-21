<?php

use App\Http\Controllers\Product\ProductAdminController;
use App\Http\Controllers\Product\ProductWebController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/login', function () {
    return Inertia::render('Auth/Login');
})->name('login');

//публичные роуты
Route::get('/', [ProductWebController::class, 'index']);
Route::get('/product/{id}', [ProductWebController::class, 'show'])->where('id', '[0-9]+');

//защищенные роуты
Route::prefix('admin')->middleware('auth:sanctum')->group(function () {
    Route::get('/products', [ProductAdminController::class, 'index']);
    Route::get('/products/create', [ProductAdminController::class, 'create']);
    Route::get('/products/{id}/edit', [ProductAdminController::class, 'edit']);
});