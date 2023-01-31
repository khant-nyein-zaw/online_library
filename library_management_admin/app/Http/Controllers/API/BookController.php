<?php

namespace App\Http\Controllers\API;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

    public function search(Request $request)
    {
        $books = Book::with(['category', 'image', 'shelf'])
            ->where('title', 'LIKE', '%' . $request->input('query') . '%')
            ->orWhere('author', 'LIKE', '%' . $request->input('query') . '%')
            ->orWhere('publisher', 'LIKE', '%' . $request->input('query') . '%')
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json([
            'books' => $books
        ]);
    }

    public function sort()
    {
        $books = Book::when(request('sortBy') === 'asc', function ($query) {
            $query->orderBy('created_at', 'asc');
        })
            ->when(request('sortBy') === 'desc', function ($query) {
                $query->orderBy('created_at', 'desc');
            })
            ->with(['category', 'image', 'shelf'])
            ->get();
        return response()->json([
            'books' => $books
        ], 200);
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
