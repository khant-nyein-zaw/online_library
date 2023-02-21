<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBorrowingRequest;
use App\Models\Borrowing;
use App\Models\BorrowRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($userId = null, $bookId = null)
    {
        $borrowings = Borrowing::with(['book', 'user'])->get();
        return view('borrowing.index', compact('borrowings', 'userId', 'bookId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBorrowingRequest $request)
    {
        Borrowing::updateOrCreate(
            [
                'user_id' => $request->user_id,
                'book_id' => $request->book_id
            ],
            [
                'date_borrowed' => Carbon::now('Asia/Yangon'),
                'due_date' => $request->due_date
            ]
        );
        BorrowRequest::where([
            ['user_id', $request->user_id],
            ['book_id', $request->book_id]
        ])->delete();
        return back()->with(["success" => "Book issued"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
