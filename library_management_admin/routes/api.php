<?php

use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// books
Route::get('/books', [BookController::class, 'index']);
Route::get('/books/{book}', [BookController::class, 'show']);
Route::get('/books/{sortBy}/all', [BookController::class, 'sort']);

// category
Route::get('/categories', [CategoryController::class, 'index']);
