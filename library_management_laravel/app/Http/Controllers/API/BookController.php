<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Models\Book;
use App\Models\Category;
use App\Models\Image;
use App\Models\Shelf;
use Illuminate\Support\Facades\Storage;

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
            ->get();
        return response()->json([
            'books' => $books
        ]);
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
        // $this->storeImage($request, $book->id);
        return response()->json([
            'createdBook' => $book
        ]);
    }

    /**
     * store new book image
     */
    public function storeImage($request, $bookId)
    {
        $existingRecord = Image::where('imageable_id', $bookId)->first();
        $newFileName = uniqid() . "_" . $request->file('image')->getClientOriginalName();

        if (isset($existingRecord)) {
            Storage::delete('public/' . $existingRecord->filename);
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
        return response()->json([
            'book' => $book
        ]);
    }

    public function filterWithShelf($shelf_no)
    {
        $books = Book::select('books.*', 'shelves.shelf_no')
            ->rightJoin('shelves', 'books.id', 'shelves.book_id')
            ->where('shelves.shelf_no', $shelf_no)
            ->get();
        return response()->json([
            'books' => $books
        ], 200);
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
        $isUpdated = Book::find($id)->update($request->only(['title', 'author', 'publisher', 'date_published']));

        if ($request->has('category')) {
            Category::where('categoryable_id', $id)->update([
                'name' => $request->category,
            ]);
        }

        if ($request->hasFile('image')) {
            $this->storeImage($request, $id);
        }

        return response(['isUpdated' => $isUpdated], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $isDeleted = Book::find($id)->delete();
        Category::where('categoryable_id', $id)->delete();
        Image::where('imageable_id', $id)->delete();
        Shelf::where('book_id', $id)->delete();
        return response([
            'isDeleted' => $isDeleted
        ], 200);
    }
}
