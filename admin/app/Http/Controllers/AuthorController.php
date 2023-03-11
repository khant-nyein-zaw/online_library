<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Author;
use App\Http\Requests\StoreAuthorRequest;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authors = Author::with('image')->withCount('books')->get();
        return view('admin.author.index', compact('authors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAuthorRequest $request)
    {
        $author = Author::create($request->all());

        if ($request->hasFile('image')) {
            $this->storeImage($request, $author->id);
        }

        return back()->with(['success' => "$author->name is stored successfully"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $author = Author::with(['books.image', 'image'])->withCount('books')->firstWhere('id', $id);
        return view('admin.author.show', compact('author'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreAuthorRequest $request, $id)
    {
        Author::find($id)->update($request->all());

        if ($request->hasFile('image')) {
            $this->storeImage($request, $id);
        }

        return redirect()->route('authors.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Author::find($id)->delete();
        return back()->with(['deleted' => 'Author was removed from library']);
    }

    /**
     * store new book image
     */
    private function storeImage($request, $authorId)
    {
        $newFileName = uniqid() . "_" . $request->file('image')->getClientOriginalName();

        $imageExists = Image::where('imageable_id', $authorId)->exists() ? (Image::firstWhere('imageable_id', $authorId)->imageable_type === Author::class ? true : false) : false;

        if ($imageExists) {
            // delete current file from storage
            $filename = Image::where('imageable_id', $authorId)->pluck('filename')->first();
            Storage::delete('public/' . $filename);
            // update new image
            $request->file('image')->storeAs('public', $newFileName);
            Image::where('imageable_id', $authorId)->update([
                'filename' => $newFileName
            ]);
        } else {
            $request->file('image')->storeAs('public', $newFileName);
            Image::create([
                'filename' => $newFileName,
                'imageable_id' => $authorId,
                'imageable_type' => Author::class
            ]);
        }
    }
}
