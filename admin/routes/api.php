<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\LendRequestController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\UserIssuedBookController;

Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    // books
    Route::get('/books', [BookController::class, 'index']);
    Route::get('/books/{book}', [BookController::class, 'show']);
    Route::post('/books/search', [BookController::class, 'search']);

    // category
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{category}', [CategoryController::class, 'show']);

    // lend requests
    Route::post('/lend-requests', [LendRequestController::class, 'store']);

    // issued-books
    Route::get('/user-issued-books', [UserIssuedBookController::class, 'index']);
    Route::patch('/user-issued-books/{issueId}', [UserIssuedBookController::class, 'changeStatus']);

    // notifications
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/mark-notification', [NotificationController::class, 'markNotification']);
});
