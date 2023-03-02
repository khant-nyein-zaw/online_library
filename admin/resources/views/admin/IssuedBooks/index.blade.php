@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Issue Book</h5>
                </div>
                <div class="card-body">
                    @if (Session::has('updated'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ Session::get('updated') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (Session::has('recordExists'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>{{ Session::get('recordExists') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('issuedBooks.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">User</label>
                                <select name="user_id" class="form-select">
                                    <option value="">Choose User</option>
                                    @foreach ($users as $user)
                                        <option {{ old('user_id') == $user->id ? 'selected' : '' }}
                                            value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Book</label>
                                <select name="book_id" class="form-select">
                                    <option value="">Choose Book</option>
                                    @foreach ($books as $book)
                                        <option {{ old('book_id') == $book->id ? 'selected' : '' }}
                                            value="{{ $book->id }}">{{ $book->title }}</option>
                                    @endforeach
                                </select>
                                @error('book_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Duration</label>
                                <input type="number" class="form-control @error('duration') is-invalid @enderror"
                                    name="duration" value="{{ old('duration') }}" placeholder="duration in days" />
                                @error('duration')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex justify-content-start align-items-center gap-3">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        @if (Session::has('removed'))
            <div class="col-12">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span>{{ Session::get('removed') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
        @if (Session::has('denied'))
            <div class="col-12">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span>{{ Session::get('denied') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
        @if (count($issuedBooks))
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">Currently issued</h5>
                    <div class="table-responsive text-nowrap">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>Issued Book</th>
                                    <th>To</th>
                                    <th>Issued Date</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($issuedBooks as $index)
                                    <tr>
                                        <td>
                                            <a href="{{ route('books.show', $index->book_id) }}"
                                                class="d-flex align-items-center gap-2">
                                                @if ($index->book->image)
                                                    <div class="avatar avatar-l pull-up">
                                                        <img src="{{ asset('storage/' . $index->book->image->filename) }}"
                                                            alt="Avatar" class="rounded-circle" />
                                                    </div>
                                                @endif
                                                <strong>{{ $index->book->title }}</strong>
                                            </a>
                                        </td>
                                        <td class="text-primary fw-bold">{{ $index->user->name }}</td>
                                        <td>{{ date('M d Y', strtotime($index->issued_date)) }}</td>
                                        <td>{{ date('M d Y', strtotime($index->due_date)) }}</td>
                                        <td>
                                            @if ($index->status === \App\Enums\IssuedBookStatus::cases()['0'])
                                                <span class="badge bg-primary">{{ $index->status }}</span>
                                            @elseif ($index->status === \App\Enums\IssuedBookStatus::cases()['1'])
                                                <span class="badge bg-success">{{ $index->status }}</span>
                                            @elseif ($index->status === \App\Enums\IssuedBookStatus::cases()['2'])
                                                <span class="badge bg-danger">{{ $index->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group-sm">
                                                @if ($index->status === \App\Enums\IssuedBookStatus::cases()['2'])
                                                    <a href="{{ route('issuedBooks.notifyUser', $index->id) }}"
                                                        class="btn btn-sm btn-success">
                                                        Notify User
                                                    </a>
                                                @endif
                                                <form action="{{ route('issuedBooks.destroy', $index->id) }}"
                                                    method="post" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger" type="submit">Remove</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="px-3">
                            {{ $issuedBooks->links() }}
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="col-12">
                <div class="alert alert-info">
                    You have not yet issued any books!
                </div>
            </div>
        @endif
    </div>
@endsection
