@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card bg-dark border-0 text-white">
                @if ($book->image)
                    <img class="card-img-top" src="{{ asset('storage/' . $book->image->filename) }}" />
                @else
                    <img class="card-img-top" src="{{ asset('storage/DEFAULT.jpg') }}">
                @endif
                <div class="card-img-overlay">
                    <h5 class="card-title text-white">{{ $book->title }}</h5>
                    <p class="card-text">
                        {{ $book->author->name }}
                    </p>
                    <div class="d-flex justify-content-center align-items-center gap-2">
                        @if ($book->category)
                            <span class="btn btn-primary">{{ $book->category->name }}</span>
                        @else
                            <span class="btn btn-warning">Please add category to the book!</span>
                        @endif
                        <form action="{{ route('books.destroy', $book->id) }}" method="post">
                            @method('DELETE')
                            @csrf
                            <input class="btn btn-danger" type="submit" value="Delete Book" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Update Book Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                                value="{{ old('title', $book->title) }}" placeholder="eg. Game of Thrones" />
                            @error('title')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ISBN</label>
                            <input type="text" class="form-control @error('ISBN') is-invalid @enderror" name="ISBN"
                                value="{{ old('ISBN', $book->ISBN) }}" placeholder="eg. ISBN 978-3-16-148410-0" />
                            @error('ISBN')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Publisher</label>
                            <input type="text" class="form-control @error('publisher') is-invalid @enderror"
                                name="publisher" value="{{ old('publisher', $book->publisher) }}"
                                placeholder="eg. Bloomsbury" />
                            @error('publisher')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Date of publication</label>
                            <input type="date" class="form-control @error('date_published') is-invalid @enderror"
                                name="date_published" value="{{ old('date_published', $book->date_published) }}" />
                            @error('date_published')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Author</label>
                            <select name="author_id" class="form-select @error('author_id') is-invalid @enderror">
                                <option>Choose Author</option>
                                @foreach ($authors as $author)
                                    <option {{ old('author_id', $author->id) == $book->author_id ? 'selected' : '' }}
                                        value="{{ $author->id }}">{{ $author->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('author_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Shelf Number</label>
                            <select name="shelf_id" class="form-select @error('shelf_id') is-invalid @enderror">
                                <option>Choose Shelf Number</option>
                                @foreach ($shelves as $shelf)
                                    <option value="{{ $shelf->id }}"
                                        {{ old('shelf_id', $shelf->id) == $book->shelf_id ? 'selected' : '' }}>
                                        {{ $shelf->shelf_no }}
                                    </option>
                                @endforeach
                            </select>
                            @error('shelf_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                <option>Choose Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $category->id) == $book->category_id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                name="image" />
                            @error('image')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-start align-items-center gap-3">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
