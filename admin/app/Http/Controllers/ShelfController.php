<?php

namespace App\Http\Controllers;

use App\Exports\ShelvesExport;
use App\Http\Requests\StoreShelfRequest;
use App\Models\Book;
use App\Models\Shelf;
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
        $shelves = Shelf::withCount('books')->get();
        return view('admin.shelf.index', compact('shelves'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreShelfRequest $request)
    {
        Shelf::create($request->all());
        return back()->with(['success' => 'New shelf was created']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shelf = Shelf::find($id);
        $books = Book::whereBelongsTo($shelf)->get();
        $shelf = Shelf::firstWhere("id", $id);
        return view('admin.shelf.show', compact('books', 'shelf'));
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
        Shelf::find($id)->update($request->all());
        return redirect()->route('shelves.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Shelf::find($id)->delete();
        return back()->with(['deleted' => 'Selected shlef was permanently deleted.']);
    }

    /**
     * export excel data
     */
    public function exportShelves()
    {
        return Excel::download(new ShelvesExport, 'shelves.csv', \Maatwebsite\Excel\Excel::CSV);
    }
}
