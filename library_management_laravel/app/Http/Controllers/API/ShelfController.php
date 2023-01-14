<?php

namespace App\Http\Controllers\API;

use App\Models\Shelf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreShelfRequest;

class ShelfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shelfList = Shelf::select('shelves.*', 'books.*', DB::raw("COUNT(shelves.shelf_no) as book_count"))
            ->join('books', 'shelves.book_id', 'books.id')
            ->groupBy('shelves.shelf_no')
            ->orderBy('shelves.shelf_no', 'desc')
            ->get();
        return response()->json([
            'shelfList' => $shelfList
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreShelfRequest $request)
    {
        $newShelf = Shelf::create($request->all());
        return response()->json([
            'message' => 'New Shelf has been added',
            'createdShelf' => $newShelf
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shelf = Shelf::select('shelves.*', 'books.*', DB::raw("COUNT(shelves.shelf_no) as book_count"))
            ->join('books', 'shelves.book_id', 'books.id')
            ->groupBy('shelves.shelf_no')
            ->orderBy('shelves.created_at', 'desc')
            ->firstWhere('shelves.id', $id);
        return response()->json([
            'shelf' => $shelf
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreShelfRequest $request, $id)
    {
        $shelf = Shelf::find($id)->update($request->all());
        return response()->json([
            'shelfUpdated' => $shelf
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($shelf_no)
    {
        $isDeleted = Shelf::where('shelf_no', $shelf_no)->delete();
        return response()->json([
            'isDeleted' => $isDeleted
        ]);
    }
}
