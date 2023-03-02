<?php

namespace App\Http\Controllers\API;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::with(['author', 'category', 'image', 'shelf'])
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json(['books' => $books], 200);
    }

    // search books by user
    public function search(Request $request)
    {
        $inputs = $request->validate([
            'searchKey' => 'required'
        ]);

        $key = $inputs['searchKey'];

        $books = Book::when(request('sortBy'), function ($query) {
            $query->orderBy('created_at', request('sortBy'));
        })
            ->with(['author', 'category', 'image', 'shelf'])
            ->where(function (Builder $query) use ($key) {
                $query->where('title', 'LIKE', '%' . $key . '%');
                $query->orWhere('ISBN', 'LIKE', '%' . $key . '%');

                $query->orWhereHas('author', function (Builder $query) use ($key) {
                    $query->where('name', 'LIKE', '%' . $key . '%');
                });

                $query->orWhereHas('category', function (Builder $query) use ($key) {
                    $query->where('name', 'LIKE', '%' . $key . '%');
                });
            })
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
        $book = Book::with(['author', 'category', 'image', 'shelf'])->firstWhere('id', $id);
        return response()->json([
            'book' => $book
        ]);
    }
}
