@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-xl-5">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Issue Book</h5>
                </div>
                <div class="card-body">
                    @if (Session::has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ Session::get('success') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if (Session::has('message'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>{{ Session::get('message') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <form action="{{ route('borrowings.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">User ID</label>
                            <input type="number" class="form-control @error('user_id') is-invalid @enderror" name="user_id"
                                value="{{ old('user_id', $userId) }}" placeholder="Enter User ID" />
                            @error('user_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Book ID</label>
                            <input type="number" class="form-control @error('book_id') is-invalid @enderror" name="book_id"
                                value="{{ old('book_id', $bookId) }}" placeholder="Enter Book ID" />
                            @error('book_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Due Date</label>
                            <input type="date" class="form-control @error('due_date') is-invalid @enderror"
                                name="due_date" value="{{ old('due_date') }}" />
                            @error('due_date')
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
        @if (count($borrowings))
            <div class="col-xl-7">
                <div class="card">
                    <h5 class="card-header">Issued Book List</h5>
                    <div class="table-responsive text-nowrap">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>Issued Book</th>
                                    <th>To</th>
                                    <th>Issued Date</th>
                                    <th>Due Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($borrowings as $borrowing)
                                    <tr>
                                        <td><a href="{{ route('books.show', $borrowing->book_id) }}"
                                                class="d-flex align-items-center gap-2">
                                                @if ($borrowing->book->image)
                                                    <div class="avatar avatar-l pull-up">
                                                        <img src="{{ asset('storage/' . $borrowing->book->image->filename) }}"
                                                            alt="Avatar" class="rounded-circle" />
                                                    </div>
                                                @endif
                                                <strong>{{ $borrowing->book->title }}</strong>
                                            </a></td>
                                        <td class="text-primary fw-bold">{{ $borrowing->user->name }}</td>
                                        <td>{{ date('M d Y', strtotime($borrowing->date_borrowed)) }}</td>
                                        <td>{{ date('M d Y', strtotime($borrowing->due_date)) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <div class="col-xl-7">
                <div class="alert alert-info">
                    All books are available to issue.
                </div>
            </div>
        @endif
    </div>
@endsection
