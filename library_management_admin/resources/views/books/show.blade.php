@extends('layout.master')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card bg-dark border-0 text-white">
                @if ($book->image)
                    <img class="card-img-top" src="{{ asset('storage/' . $book->image->filename) }}" />
                @else
                    <img class="card-img-top"
                        src="{{ asset('storage/default-image-icon-missing-picture-page-vector-40546530.jpg') }}">
                @endif
                <div class="card-img-overlay">
                    <h5 class="card-title text-white">{{ $book->title }}</h5>
                    <p class="card-text">
                        {{ $book->author }}
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
                            <input class="btn btn-outline-danger" type="submit" value="Delete Book" />
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
                            <label class="form-label">Author</label>
                            <input type="text" class="form-control @error('author') is-invalid @enderror" name="author"
                                value="{{ old('author', $book->author) }}" placeholder="eg. J. K. Rowling" />
                            @error('author')
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
                            <label class="form-label">Category of Book</label>
                            <input type="text" class="form-control @error('category') is-invalid @enderror"
                                name="category" value="{{ old('category', $book->category ? $book->category->name : '') }}"
                                placeholder="eg. Fantasy Fiction" />
                            @error('category')
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
