<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBorrowingRequest;
use App\Models\Borrowing;

class IssueBookController extends Controller
{
    // issue book index page
    public function index()
    {
        $borrowings = Borrowing::with(['book', 'user'])->get();
        return view('issueBook.index', compact('borrowings'));
    }

    /**
     * Store a newly created borrowing resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeBorrowing(StoreBorrowingRequest $request)
    {
        Borrowing::create($request->validated());
        return back()->with(["success" => "Book issued"]);
    }
}
