<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ShelfController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::resource('/books', BookController::class);
    Route::resource('/shelves', ShelfController::class);
    Route::post('/import', [ShelfController::class, 'import'])->name('shelves.import');
    Route::get('/export-shelves', [ShelfController::class, 'exportShelves'])->name('shelves.export');
});
