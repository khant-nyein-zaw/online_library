<?php

namespace App\Http\Controllers\API;

use App\Models\BorrowRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreBorrowRequest;

class BorrowRequestController extends Controller
{
    public function store(StoreBorrowRequest $request)
    {
        $data = BorrowRequest::create($request->all());
        return response()->json([
            'data' => $data
        ]);
    }
}
