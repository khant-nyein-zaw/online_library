<?php

namespace App\Http\Controllers;

use App\Models\BorrowRequest;

class BorrowRequestController extends Controller
{
    public function index()
    {
        $data = BorrowRequest::with(['user', 'book'])->get();
        return view('borrow_request.index', compact('data'));
    }
}
