@extends('layouts.master')

@section('content')
    <!-- Book List -->
    @if (count($books))
        <div class="row mb-4">
            <div class="col-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="col-sm-6">
                            <form action="{{ route('books.index') }}" method="get">
                                <label class="form-label">Search Books</label>
                                <input type="search" name="search_query" class="form-control"
                                    placeholder="Search Books by Title or ISBN">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>{{ request('search_query') ? 'Search Results' : 'Recently added books' }}</h5>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('books.create') }}" class="btn btn-primary">Add new book</a>
                            <a href="{{ route('books.export') }}" class="btn btn-info">Download Book List</a>
                        </div>
                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Publisher</th>
                                    <th>Date of publication</th>
                                    <th>Category</th>
                                    <th>Shelf Number</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($books as $book)
                                    <tr>
                                        <td>{{ $book->id }}</td>
                                        <td>
                                            <a href="{{ route('books.show', $book->id) }}"
                                                class="d-flex align-items-center gap-2">
                                                @if ($book->image)
                                                    <div class="avatar avatar-l pull-up">
                                                        <img src="{{ asset('storage/' . $book->image->filename) }}"
                                                            alt="Avatar" class="rounded-circle" />
                                                    </div>
                                                @endif
                                                <strong>{{ $book->title }}</strong>
                                            </a>
                                        </td>
                                        <td>{{ $book->author->name }}</td>
                                        <td>
                                            <span class="badge bg-label-primary me-1">{{ $book->publisher }}</span>
                                        </td>
                                        <td>{{ date('M d Y', strtotime($book->date_published)) }}</td>
                                        <td>{{ $book->category->name }}</td>
                                        <td>{{ $book->shelf->shelf_no }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="px-3">
                            {{ $books->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif (!count($books) && request('search_query'))
        <div class="card mb-3">
            <div class="card-body">
                <div class="col-sm-6">
                    <form action="{{ route('books.index') }}" method="get">
                        <label class="form-label">Search Books</label>
                        <input type="search" name="search_query" class="form-control"
                            placeholder="Search Books by Title or ISBN">
                    </form>
                </div>
            </div>
        </div>
        <div class="alert alert-warning">
            <small>No matching results!</small>
        </div>
    @else
        <div class="alert alert-warning">
            <small>No book has been created!</small>
        </div>
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>{{ request('search_query') ? 'Search Results' : 'Recently added books' }}</h5>
                <div class="d-flex justify-content-center gap-2">
                    <a href="{{ route('books.create') }}" class="btn btn-primary">Add new book</a>
                    <a href="{{ route('books.export') }}" class="btn btn-info">Download Book List</a>
                </div>
            </div>
        </div>
    @endif
@endsection
