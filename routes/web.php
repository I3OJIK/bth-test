<?php

use App\Http\Controllers\Inertia\Admin\AdminProductController;
use App\Http\Controllers\Inertia\Web\WebProductController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/login', function () {
    return Inertia::render('Auth/Login');
})->name('login');

//публичные роуты
Route::get('/', [WebProductController::class, 'index']);
Route::get('/product/{id}', [WebProductController::class, 'show'])->where('id', '[0-9]+');

//защищенные роуты
Route::prefix('admin')->middleware('auth:sanctum')->group(function () {
    Route::get('/products', [AdminProductController::class, 'index']);
    Route::get('/products/create', [AdminProductController::class, 'create']);
    Route::get('/products/{product}/edit', [AdminProductController::class, 'edit']);
});