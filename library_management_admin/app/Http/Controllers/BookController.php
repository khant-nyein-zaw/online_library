<?php

namespace App\Http\Controllers;

use App\Exports\ExportBooks;
use App\Models\Book;
use App\Models\Image;
use App\Models\Shelf;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBookRequest;
use App\Imports\ImportBooks;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::with(['category', 'image'])
            ->orderBy('created_at', 'desc')
            ->paginate(5);
        return view('books.index', compact('books'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookRequest $request)
    {
        $book = Book::create($request->only(['title', 'author', 'publisher', 'date_published']));
        Category::create([
            'name' => $request->category,
            'categoryable_id' => $book->id,
            'categoryable_type' => Book::class
        ]);
        $this->storeImage($request, $book->id);
        return back();
    }

    /**
     * store new book image
     */
    public function storeImage($request, $bookId)
    {
        $newFileName = uniqid() . "_" . $request->file('image')->getClientOriginalName();

        if (Image::where('imageable_id', $bookId)->exists()) {
            // delete current file from storage
            $filename = Image::where('imageable_id', $bookId)->pluck('filename')->first();
            Storage::delete('public/' . $filename);
            // update new image
            $request->file('image')->storeAs('public', $newFileName);
            Image::where('imageable_id', $bookId)->update([
                'filename' => $newFileName
            ]);
        } else {
            $request->file('image')->storeAs('public', $newFileName);
            Image::create([
                'filename' => $newFileName,
                'imageable_id' => $bookId,
                'imageable_type' => Book::class
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::with(['category', 'image'])->firstWhere('id', $id);
        return view('books.show', compact('book'));
    }

    // public function filterWithShelf($shelf_no)
    // {
    //     $books = Book::select('books.*', 'shelves.shelf_no')
    //         ->rightJoin('shelves', 'books.id', 'shelves.book_id')
    //         ->where('shelves.shelf_no', $shelf_no)
    //         ->get();
    //     return response()->json([
    //         'books' => $books
    //     ], 200);
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreBookRequest $request, $id)
    {
        Book::find($id)->update($request->only(['title', 'author', 'publisher', 'date_published']));

        if (Category::where('categoryable_id', $id)->exists()) {
            Category::where('categoryable_id', $id)->update([
                'name' => $request->category,
            ]);
        } else {
            Category::create([
                'name' => $request->category,
                'categoryable_id' => $id,
                'categoryable_type' => Book::class
            ]);
        }

        if ($request->hasFile('image')) {
            $this->storeImage($request, $id);
        }

        return redirect()->route('books.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Book::find($id)->delete();
        Category::where('categoryable_id', $id)->delete();

        if (Image::where('imageable_id', $id)->exists()) {
            $image = Image::firstWhere('imageable_id', $id);
            Storage::delete('public/' . $image->filename);
            $image->delete();
        }

        Shelf::where('book_id', $id)->delete();
        return redirect()->route('books.index');
    }

    /**
     * Store books' data with importing from excel
     */
    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:xls,xlsx,csv'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        Excel::import(new ImportBooks, $request->file('file'));
        return back()->with(['success' => 'Stored books successfully']);
    }

    /**
     * export excel data
     */
    public function exportBooks()
    {
        return Excel::download(new ExportBooks, 'books.csv', \Maatwebsite\Excel\Excel::CSV);
    }
}
