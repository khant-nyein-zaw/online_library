<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('books')->get();
        return response()->json([
            'categories' => $categories
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $category = Category::find($id);
        $books = Book::with(['shelf', 'image'])->whereBelongsTo($category)->get();
        return response()->json([
            'category' => [
                'name' => $category->name,
                'books' => $books
            ]
        ], 200);
    }
}
