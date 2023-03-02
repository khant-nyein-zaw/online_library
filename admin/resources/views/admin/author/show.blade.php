@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-12 mb-3">
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-md-4">
                        @if ($author->image)
                            <img src="{{ asset('storage/' . $author->image->filename) }}" class="img-fluid rounded-start">
                        @endif
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h3 class="card-title text-primary">{{ $author->name }}</h3>
                            <p class="card-text">
                                {{ $author->bio }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <h3 class="text-center py-3 border-bottom border-primary border-3">
                <span class="ms-1 badge bg-label-primary">Book Count ( {{ $author->books_count }} )</span>
            </h3>
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Add a new author</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('authors.update', $author->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $author->name) }}" placeholder="Add name" />
                            </div>
                            @error('name')
                                <small class="text-danger offset-sm-2">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Bio</label>
                            <div class="col-sm-10">
                                <textarea name="bio" class="form-control @error('bio') is-invalid @enderror" cols="30" rows="10"
                                    placeholder="Add bio">{{ old('bio', $author->bio) }}</textarea>
                            </div>
                            @error('bio')
                                <small class="text-danger offset-sm-2">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Image</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control @error('image') is-invalid @enderror"
                                    name="image" />
                            </div>
                            @error('image')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @foreach ($author->books as $book)
            <div class="col-md-4">
                <div class="card bg-dark border-0 text-white">
                    @if ($book->image)
                        <img class="card-img-top" src="{{ asset('storage/' . $book->image->filename) }}" />
                    @else
                        <img class="card-img-top" src="{{ asset('storage/DEFAULT.jpg') }}">
                    @endif
                    <div class="card-img-overlay">
                        <h5 class="card-title text-white">{{ $book->title }}</h5>
                        <p class="card-text">
                            {{ $author->name }}
                        </p>
                        <div class="d-flex justify-content-center align-items-center gap-2">
                            <span class="btn btn-primary">{{ $book->category->name }}</span>
                            <form action="{{ route('books.destroy', $book->id) }}" method="post">
                                @method('DELETE')
                                @csrf
                                <input class="btn btn-danger" type="submit" value="Delete Book" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
