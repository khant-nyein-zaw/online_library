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
                    <h5 class="mb-0">Add a new category</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Category</label>
                            <div class="col-sm-10">
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                    placeholder="Add new category" />
                            </div>
                            @error('name')
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
        @if (count($categories))
            <div class="col-md-7">
                @if (Session::has('deleted'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>{{ Session::get('deleted') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Categories</h5>
                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Books</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->books_count }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                @if ($category->books_count)
                                                    <a href="{{ route('categories.show', $category->id) }}"
                                                        class="btn btn-sm btn-info rounded">
                                                        <i class='bx bx-detail'></i>
                                                    </a>
                                                @endif
                                                <form action="{{ route('categories.destroy', $category->id) }}"
                                                    method="post" class="d-inline">
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
            </div>
        @endif
    </div>
@endsection
