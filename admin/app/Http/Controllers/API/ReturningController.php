<?php

namespace App\Http\Controllers\API;

use App\Models\Returning;
use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReturningController extends Controller
{
    // store new returning record
    public function store(Request $request)
    {
        $data = Borrowing::firstWhere('id', $request->borrowing_id);

        $fine = 0;
        $dueDate = Carbon::parse($data->due_date);
        if (Carbon::now('Asia/Yangon')->greaterThan($dueDate)) {
            $period = Carbon::now('Asia/Yangon')->diffInDays($dueDate);
            // $1.5 fine for a day
            $fine += 1.5 * $period;
        }
        Returning::create([
            'borrowing_id' => $data->id,
            'user_id' => $data->user_id,
            'book_id' => $data->book_id,
            'date_returned' => Carbon::now(),
            'due_date' => $data->due_date,
            'fine' => $fine
        ]);

        return response()->json([
            'message' => 'Your book have been returned succesfully'
        ]);
    }
}
