<?php

namespace App\Http\Controllers\API;

use App\Models\Returning;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreReturningRequest;
use App\Models\Borrowing;
use Carbon\Carbon;

class ReturningController extends Controller
{
    // store new returning record
    public function store(StoreReturningRequest $request)
    {
        $borrowData = Borrowing::firstWhere('id', $request->borrowing_id);

        $fine = 0;
        $dueDate = Carbon::parse($borrowData->due_date);
        if (Carbon::now('Asia/Yangon')->greaterThan($dueDate)) {
            $period = Carbon::now('Asia/Yangon')->diffInDays($dueDate);
            // $1.5 fine for a day
            $fine += 1.5 * $period;
        }
        Returning::create([
            'borrowing_id' => $borrowData->id,
            'user_id' => $borrowData->user_id,
            'book_id' => $borrowData->book_id,
            'date_returned' => Carbon::now(),
            'due_date' => $borrowData->due_date,
            'fine' => $fine
        ]);

        return response()->json([
            'message' => 'Your book have been returned succesfully'
        ]);
    }
}
