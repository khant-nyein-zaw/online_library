@extends('layouts.master')

@section('content')
    <!-- Alert -->
    @if (!count($categories) || !count($authors) || !count($shelves))
        <div class="alert alert-warning">
            <small>Please create authors or categories or shelves first to insert books!</small>
        </div>
    @endif
    <!-- create new book form -->
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Add new book to the library</h5>
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
                                        <h5 class="modal-title">
                                            Export books data
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('books.import') }}" method="POST" enctype="multipart/form-data">
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
                                                <small class="text-muted">
                                                    Please include title, isbn,
                                                    publisher, date_published, author_id, category_id and shelf_id
                                                    headings
                                                </small>
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
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
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
                            <label class="form-label">ISBN</label>
                            <input type="text" class="form-control @error('ISBN') is-invalid @enderror" name="ISBN"
                                value="{{ old('ISBN') }}" placeholder="eg. ISBN 978-3-16-148410-0" />
                            @error('ISBN')
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

                        @if (count($authors))
                            <div class="mb-3">
                                <label class="form-label">Author</label>
                                <select name="author_id" class="form-select @error('author_id') is-invalid @enderror">
                                    <option>Choose Author</option>
                                    @foreach ($authors as $author)
                                        <option {{ old('author_id') == $author->id ? 'selected' : '' }}
                                            value="{{ $author->id }}">{{ $author->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('author_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        @endif

                        @if (count($categories))
                            <div class="mb-3">
                                <label class="form-label">Category</label>
                                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                    <option>Choose Category</option>
                                    @foreach ($categories as $category)
                                        <option {{ old('category_id') == $category->id ? 'selected' : '' }}
                                            value="{{ $category->id }}">{{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        @endif

                        @if (count($shelves))
                            <div class="mb-3">
                                <label class="form-label">Shelf Number</label>
                                <select name="shelf_id" class="form-select @error('shelf_id') is-invalid @enderror">
                                    <option>Choose Shelf Number</option>
                                    @foreach ($shelves as $shelf)
                                        <option {{ old('shelf_id') == $shelf->id ? 'selected' : '' }}
                                            value="{{ $shelf->id }}">{{ $shelf->shelf_no }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('shelf_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        @endif

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
