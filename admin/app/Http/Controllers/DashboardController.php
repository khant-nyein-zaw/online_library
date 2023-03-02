<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\BorrowRequest;
use App\Models\LendRequest;

class DashboardController extends Controller
{
    // dashboard index page
    public function index()
    {
        $booksAvailable = Book::whereDoesntHave('issuedBook')->count();
        $users = User::withWhereHas("issuedBooks")->count();
        $members = User::whereRelation('role', 'main_role', 'member')->count();
        $lendRequests = LendRequest::with(['user', 'book'])->get();
        return view("admin.dashboard", compact('booksAvailable', 'users', 'members', 'lendRequests'));
    }

    // delete member's lend request
    public function destroyLendRequest($id)
    {
        LendRequest::find($id)->delete();
        return back()->with(['deleted' => 'Selected lend request was deleted']);
    }
}
