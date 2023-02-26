<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\IssuedBook;
use App\Models\User;
use Illuminate\Http\Request;

class IssuedBookController extends Controller
{
    public function index()
    {
        $issuedBooks = IssuedBook::with(['book', 'user'])->get();
        $users = User::whereRelation('role', 'main_role', 'member')->get();
        $books = Book::all();
        return view('admin.issuedBooks.index', compact('issuedBooks', 'users', 'books'));
    }
}
