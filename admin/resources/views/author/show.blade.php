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
