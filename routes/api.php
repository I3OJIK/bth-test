<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Category\CategoryApiController;
use App\Http\Controllers\Product\ProductApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//публичные роуты
Route::apiResource('products', ProductApiController::class)
    ->only(['index', 'show']);

Route::get('/categories', [CategoryApiController::class, 'index']);

//защищенные роуты
Route::apiResource('products', ProductApiController::class)
    ->middleware('auth:sanctum')
    ->except(['index', 'show']);



Route::post('/login', [AuthController::class, 'login']);