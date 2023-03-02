<?php

namespace App\Http\Controllers\API;

use App\Enums\IssuedBookStatus;
use Carbon\Carbon;
use App\Models\IssuedBook;
use App\Http\Controllers\Controller;

class UserIssuedBookController extends Controller
{
    // get all issued books to authenticated users
    public function index()
    {
        $issuedBooks = IssuedBook::where('user_id', auth()->user()->id)
            ->with(['book' => ['image', 'category'], 'user'])
            ->get();

        // change date format and get period between due date and today
        foreach ($issuedBooks as $index) {
            $dueDate = Carbon::parse($index->due_date);
            $index->period = $dueDate->diffForHumans();
            $index->issued_date = Carbon::parse($index->issued_date)->format('M d Y');
            $index->due_date = Carbon::parse($index->due_date)->format('M d Y');
        }

        return response()->json([
            'issuedBooks' => $issuedBooks
        ]);
    }

    // change status to return
    public function changeStatus($id)
    {
        $issuedBook = IssuedBook::find($id);
        $tday = Carbon::now();
        $dueDate = Carbon::parse($issuedBook->due_date);

        if ($tday->greaterThan($dueDate)) {
            $interval = $tday->diffInDays($dueDate);
            $fine = $interval * 500; // 500 kyats per day for overdue penalty
            $updateData = [
                'fine' => $fine,
                'returned_date' => Carbon::now(),
                'status' => IssuedBookStatus::Overdue,
            ];
        } else {
            $updateData = [
                'returned_date' => Carbon::now(),
                'status' => IssuedBookStatus::Returned,
            ];
        }

        $issuedBook->update($updateData);

        return response()->json([
            'message' => 'Book has been retured'
        ]);
    }
}
