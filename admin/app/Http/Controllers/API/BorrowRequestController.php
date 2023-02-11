<?php

namespace App\Http\Controllers\API;

use App\Models\BorrowRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreBorrowRequest;

class BorrowRequestController extends Controller
{
    // send a new borrow request to admin
    public function store(StoreBorrowRequest $request)
    {
        if (BorrowRequest::where([
            ['book_id', $request->book_id],
            ['user_id', $request->user_id]
        ])->exists()) {
            return response()->json([
                'message' => 'You have already requested to borrow this book!'
            ]);
        }
        $data = BorrowRequest::create($request->all());
        return response()->json([
            'data' => $data
        ]);
    }
}
