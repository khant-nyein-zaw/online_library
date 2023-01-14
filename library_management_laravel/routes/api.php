<?php

use App\Http\Controllers\API\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ShelfController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources([
    'books' => BookController::class,
    'shelves' => ShelfController::class,
]);

Route::get('/{shelf_no}', [BookController::class, 'filterWithShelf']);
