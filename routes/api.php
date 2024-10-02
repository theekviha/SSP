<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/register', [\App\Http\Controllers\StockController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\StockController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [StockController::class,'logout']);