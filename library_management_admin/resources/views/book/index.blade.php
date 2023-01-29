@extends('layouts.master')

@section('content')
    <!-- Book List -->
    @if (count($books))
        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Recently added books</h5>
                        <a href="{{ route('books.export') }}" class="btn btn-info">Download Book List</a>
                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
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
                                        <td>{{ $book->author }}</td>
                                        <td>
                                            <span class="badge bg-label-primary me-1">{{ $book->publisher }}</span>
                                        </td>
                                        <td>{{ date('M d Y', strtotime($book->date_published)) }}</td>
                                        @if ($book->category)
                                            <td>{{ $book->category->name }}</td>
                                        @else
                                            <td class="text-warning text-capitalize">Please add category to this book!</td>
                                        @endif
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
    @endif
    <!-- create new book form -->
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Add New Book</h5>
                    <div>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCenter">
                            Import Csv or Excel file
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalCenterTitle">Please include title, author,
                                            publisher, date_published, category_id and shelf_id headings</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('books.import') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col mb-3">
                                                    <label class="form-label">File</label>
                                                    <input type="file" name="file"
                                                        class="form-control @error('file') is-invalid @enderror">
                                                    @error('file')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary"
                                                data-bs-dismiss="modal">
                                                Close
                                            </button>
                                            <button type="submit" class="btn btn-primary">Import</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if (Session::has('success'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>{{ Session::get('success') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                                value="{{ old('title') }}" placeholder="eg. Game of Thrones" />
                            @error('title')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Author</label>
                            <input type="text" class="form-control @error('author') is-invalid @enderror" name="author"
                                value="{{ old('author') }}" placeholder="eg. J. K. Rowling" />
                            @error('author')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Publisher</label>
                            <input type="text" class="form-control @error('publisher') is-invalid @enderror"
                                name="publisher" value="{{ old('publisher') }}" placeholder="eg. Bloomsbury" />
                            @error('publisher')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Date of publication</label>
                            <input type="date" class="form-control @error('date_published') is-invalid @enderror"
                                name="date_published" value="{{ old('date_published') }}" />
                            @error('date_published')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Shelf Number</label>
                            <select name="shelf_id" class="form-select @error('shelf_id') is-invalid @enderror">
                                <option>Choose Shelf Number</option>
                                @foreach ($shelves as $shelf)
                                    <option value="{{ $shelf->id }}">{{ $shelf->shelf_no }}
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
                                    <option value="{{ $category->id }}">{{ $category->name }}
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
