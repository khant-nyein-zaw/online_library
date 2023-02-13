<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\BorrowRequest;
use App\Models\Returning;
use App\Models\User;

class DashboardController extends Controller
{
    // dashboard index page
    public function index()
    {
        $toBorrows = BorrowRequest::with(['user','book'])->get();
        $borrowings = Borrowing::all()->count();
        $users = User::withWhereHas("borrowings")->count();
        $returnings = Returning::with(['borrowing','user','book'])->get();
        return view("dashboard", compact("toBorrows", "users", "borrowings", "returnings"));
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
