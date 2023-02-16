<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use Carbon\Carbon;

class BorrowingController extends Controller
{
    /**
     * get all resources
     */
    public function index()
    {
        $borrowings = Borrowing::with(['book' => [ 'image', 'category', 'shelf' ], 'user'])->get();
        foreach ($borrowings as $borrowing) {
            $tday = Carbon::now();
            $dueDate = Carbon::parse($borrowing->due_date);
            $borrowing->period = $tday->diffInDays($dueDate);
            $borrowing->date_borrowed = Carbon::parse($borrowing->date_borrowed)->format('M d Y');
            $borrowing->due_date = Carbon::parse($borrowing->due_date)->format('M d Y');
        }
        return response()->json([
            'borrowings' => $borrowings
        ]);
    }
}
