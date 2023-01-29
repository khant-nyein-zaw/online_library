<?php

namespace App\Http\Controllers;

use App\Exports\ExportBooks;
use App\Models\Book;
use App\Models\Image;
use App\Models\Shelf;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\StoreBooksAsCsvRequest;
use App\Imports\ImportBooks;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
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
        $books = Book::with(['category', 'image', 'shelf'])
            ->orderBy('created_at', 'desc')
            ->paginate(5);
        $shelves = Shelf::all();
        $categories = Category::all();
        return view('book.index', compact('books', 'categories', 'shelves'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookRequest $request)
    {
        $book = Book::create($request->only(['title', 'author', 'publisher', 'date_published', 'category_id', 'shelf_id']));
        if ($request->hasFile('image')) {
            $this->storeImage($request, $book->id);
        }
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
        $book = Book::with(['category', 'image', 'shelf'])->firstWhere('id', $id);
        $categories = Category::all();
        $shelves = Shelf::all();
        return view('book.show', compact('book', 'shelves', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreBookRequest $request, $id)
    {
        Book::find($id)->update($request->only(['title', 'author', 'publisher', 'date_published', 'category_id', 'shelf_id']));

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
        return redirect()->route('books.index');
    }

    /**
     * Store books' data with importing from excel
     */
    public function import(StoreBooksAsCsvRequest $request)
    {
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
