@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-5">
            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ Session::get('success') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Add a new shelf</h5>
                    <a href="{{ route('shelves.export') }}" class="btn btn-sm btn-info">Download Shelf List</a>
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
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-sm btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            @if (Session::has('deleted'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{ Session::get('deleted') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (count($shelves))
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Shelf List</h5>
                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Shelf Number</th>
                                    <th>Books</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($shelves as $shelf)
                                    <tr>
                                        <td>{{ $shelf->id }}</td>
                                        <td>{{ $shelf->shelf_no }}</td>
                                        <td>{{ $shelf->books_count }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                @if ($shelf->books_count)
                                                    <a href="{{ route('shelves.show', $shelf->id) }}"
                                                        class="btn btn-sm btn-info rounded">
                                                        <i class='bx bx-detail'></i>
                                                    </a>
                                                @endif
                                                <form action="{{ route('shelves.destroy', $shelf->id) }}" method="post"
                                                    class="d-inline">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button class="btn btn-sm btn-danger rounded" type="submit">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
