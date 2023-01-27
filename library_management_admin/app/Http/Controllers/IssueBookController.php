<?php

namespace App\Http\Controllers;

use App\Models\BorrowRequest;

class IssueBookController extends Controller
{
    public function index()
    {
        $borrrowRequests = BorrowRequest::all();
        return view('IssueBook.Index', compact('borrowRequests'));
    }
}
