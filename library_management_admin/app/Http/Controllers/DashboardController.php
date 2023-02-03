<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\BorrowRequest;
use App\Models\User;

class DashboardController extends Controller
{
    // dashboard index page
    public function index()
    {
        $toBorrows = BorrowRequest::all();
        $borrowings = Borrowing::all()->count();
        $users = User::withWhereHas("borrowings")->count();
        return view("dashboard", compact('toBorrows', 'users', 'borrowings'));
    }

    /**
     * Remove the specified resource from storage.
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
