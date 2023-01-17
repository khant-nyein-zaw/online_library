@extends('layout.master')

@section('content')
    <div class="postion-relative">
        <div class="position-absolute bg-info rounded top-0"
            style="width: 80%; z-index: -1; padding-top: 10rem; padding-bottom: 10rem;"></div>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card bg-dark border-0 text-white">
                    <img class="card-img-top" src="{{ asset('storage/' . $book->image->filename) }}" />
                    <div class="card-img-overlay">
                        <h5 class="card-title text-white">{{ $book->title }}</h5>
                        <p class="card-text">
                            {{ $book->author }}
                        </p>
                        <div class="d-flex justify-content-center align-items-center gap-2">
                            <span class="btn btn-primary">{{ $book->category->name }}</span>
                            <form action="{{ route('books.destroy', $book->id) }}" method="post">
                                @method('DELETE')
                                @csrf
                                <input class="btn btn-outline-danger" type="submit" value="Delete Book" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
