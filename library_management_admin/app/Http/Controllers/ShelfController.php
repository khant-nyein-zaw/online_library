<?php

namespace App\Http\Controllers;

use App\Exports\ShelvesExport;
use App\Http\Requests\StoreShelfRequest;
use App\Imports\ShelvesImport;
use App\Models\Book;
use App\Models\Shelf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ShelfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::all();
        return view('shelf.index', compact('books'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreShelfRequest $request)
    {
        foreach ($request->input('book_id') as $book_id) {
            Shelf::create([
                'shelf_no' => $request->shelf_no,
                'book_id' => $book_id
            ]);
        }
        return back()->with(['success' => 'Books have been added to the shelf']);
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

    /**
     * import excel data
     */
    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file'
        ]);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }
        Excel::import(new ShelvesImport, $request->file('file')->storeAs('files', 'shelves.xlsx'));
        return back();
    }

    /**
     * export excel data
     */
    public function exportShelves()
    {
        return Excel::download(new ShelvesExport, 'shelves.xlsx');
    }
}
