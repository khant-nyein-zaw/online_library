@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('shelves.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Import shelves from excel</label>
                            <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" />
                            @error('file')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary">Import</button>
                        <a href="{{ route('shelves.export') }}" class="btn btn-sm btn-info">Download Shelf List</a>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            @if (Session::has('success'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>{{ Session::get('success') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Add books to shelf</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('shelves.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Shelf No</label>
                            <div class="col-sm-10">
                                <input type="text" name="shelf_no"
                                    class="form-control @error('shelf_no') is-invalid @enderror"
                                    value="{{ old('shelf_no') }}" placeholder="Add shelf number" />
                            </div>
                            @error('shelf_no')
                                <small class="text-danger offset-sm-2">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Books</label>
                            <div class="col-sm-10">
                                <select multiple name="book_id[]"
                                    class="form-select @error('book_id.*') is-invalid @enderror">
                                    <option>Choose Books</option>
                                    @foreach ($books as $book)
                                        <option value="{{ $book->id }}">{{ $book->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('book_id.*')
                                <small class="text-danger offset-sm-2">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-sm btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
