<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ShelfController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'login', 301);
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    // users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    // books
    Route::resource('/books', BookController::class);
    Route::post('/import-books', [BookController::class, 'import'])->name('books.import');
    Route::get('/export-books', [BookController::class, 'exportBooks'])->name('books.export');
    // shelves
    Route::resource('/shelves', ShelfController::class);
    Route::post('/import', [ShelfController::class, 'import'])->name('shelves.import');
    Route::get('/export-shelves', [ShelfController::class, 'exportShelves'])->name('shelves.export');
});
