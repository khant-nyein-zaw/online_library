<?php

namespace App\Http\Controllers;

use App\Models\BorrowRequest;

class DashboardController extends Controller
{
    // dashboard index page
    public function index()
    {
        // $booksAvailable = Book::whereDoesntHave('borrowings')->paginate(3);
        // $users = User::withWhereHas("borrowings")->count();
        return view("admin.dashboard");
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
