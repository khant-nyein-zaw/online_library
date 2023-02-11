@extends('layouts.master')

@section('content')
    <div class="row">
        <h3 class="text-center py-3 border-bottom border-primary border-3">
            <span class="badge bg-label-primary">{{ $category }}</span>
        </h3>
        @foreach ($books as $book)
            <div class="col-md-4">
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
                            <span class="btn btn-primary">{{ $category }}</span>
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
