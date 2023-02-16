<?php

namespace App\Http\Controllers\API;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SearchBooksRequest;

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
            ->get();
        return response()->json(['books' => $books], 200);
    }

    // search books by user
    public function search(SearchBooksRequest $request)
    {
        $books = Book::when(request('sortBy'), function ($query) {
            $query->orderBy('created_at', request('sortBy'));
        })
            ->with(['category', 'image', 'shelf'])
            ->where('title', 'LIKE', '%' . $request->searchKey . '%')
            ->orWhere('author', 'LIKE', '%' . $request->searchKey . '%')
            ->get();
        return response()->json([
            'books' => $books
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
        $book = Book::with(['category', 'image', 'shelf'])->firstWhere('id', $id);
        return response()->json([
            'book' => $book
        ]);
    }
}
