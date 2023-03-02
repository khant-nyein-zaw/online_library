@extends('layouts.master')

@section('content')
    <div class="row">
        <h3 class="text-center py-3 border-bottom border-primary border-3">
            <span class="badge bg-label-primary">{{ $category->name }}</span>
        </h3>
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Edit category</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('categories.update', $category->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Category</label>
                            <div class="col-sm-10">
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $category->name) }}" placeholder="Add new category" />
                            </div>
                            @error('name')
                                <small class="text-danger offset-sm-2">{{ $message }}</small>
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
        @foreach ($books as $book)
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
                            {{ $book->author->name }}
                        </p>
                        <div class="d-flex justify-content-center align-items-center gap-2">
                            <span class="btn btn-primary">{{ $category->name }}</span>
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
