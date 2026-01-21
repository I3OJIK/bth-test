<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//публичные роуты
Route::apiResource('products', ProductController::class)
    ->only(['index', 'show']);

Route::get('/categories', [CategoryController::class, 'index']);

//защищенные роуты
Route::apiResource('products', ProductController::class)
    ->middleware('auth:sanctum')
    ->except(['index', 'show']);



Route::post('/login', [AuthController::class, 'login']);