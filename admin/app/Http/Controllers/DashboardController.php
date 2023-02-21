<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\BorrowRequest;
use App\Models\Returning;
use App\Models\User;

class DashboardController extends Controller
{
    // dashboard index page
    public function index()
    {
        $toBorrows = BorrowRequest::with(['user', 'book'])->get();
        $booksAvailable = Book::whereDoesntHave('borrowings')->paginate(5);
        $borrowings = Borrowing::all()->count();
        $users = User::withWhereHas("borrowings")->count();
        $returnings = Returning::with(['borrowing', 'user', 'book'])->paginate(5);
        return view("dashboard", compact("toBorrows", "users", "borrowings", "returnings", "booksAvailable"));
    }

    /**
     * Remove the specified borrow request from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyRequest($id)
    {
        BorrowRequest::find($id)->delete();
        return back();
    }
}
