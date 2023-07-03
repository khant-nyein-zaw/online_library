<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ShelfController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IssuedBookController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProfileController;

Route::redirect('/', 'login', 301);
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');

Route::middleware(['auth', 'admin'])->group(function () {

    // dashboard actions
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::delete('/lend-requests/{id}', [DashboardController::class, 'destroyLendRequest'])->name('dashboard.destroyLendRequest');

    // admin profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::patch('/profile/reset-password/{id}', [ProfileController::class, 'resetPassword'])->name('profile.resetPassword');
    Route::put('/profile/update/{id}', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/upload-photo/{id}', [ProfileController::class, 'uploadPhoto'])->name('profile.uploadPhoto');
    Route::delete('/profile/reset-photo/{id}', [ProfileController::class, 'resetPhoto'])->name('profile.resetPhoto');

    // users
    Route::get('/members', [MemberController::class, 'index'])->name('members.index');
    Route::post('/members/change-role', [MemberController::class, 'changeRole'])->name('members.changeRole');

    // books
    Route::resource('/books', BookController::class);
    Route::post('/import-books', [BookController::class, 'import'])->name('books.import');
    Route::get('/export-books', [BookController::class, 'exportBooks'])->name('books.export');

    // aurthors
    Route::resource('/authors', AuthorController::class);

    // categories
    Route::resource('/categories', CategoryController::class);

    // shelves
    Route::resource('/shelves', ShelfController::class);
    Route::get('/export-shelves', [ShelfController::class, 'exportShelves'])->name('shelves.export');

    // issued books
    Route::get('/issued-books', [IssuedBookController::class, 'index'])->name('issuedBooks.index');
    Route::post('/issued-books', [IssuedBookController::class, 'store'])->name('issuedBooks.store');
    Route::get('/notify-user/{id}', [IssuedBookController::class, 'notifyUser'])->name('issuedBooks.notifyUser');
    Route::delete('/issued-books/{id}', [IssuedBookController::class, 'destroy'])->name('issuedBooks.destroy');
});
