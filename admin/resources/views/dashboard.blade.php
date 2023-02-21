@extends('layouts.master')

@section('content')
    <div class="row mb-3">
        <div class="col-lg-5">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <i class='bx bxs-book-content rounded text-success fs-2'></i>
                                </div>
                            </div>
                            <span class="fw-semibold d-block mb-1">Borrowed Books</span>
                            <h3 class="card-title mb-2">{{ $borrowings }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <i class='bx bx-user-circle rounded text-success fs-2'></i>
                                </div>
                            </div>
                            <span class="fw-semibold d-block mb-1">Issued Users</span>
                            <h3 class="card-title text-nowrap mb-2">{{ $users }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            @if (count($toBorrows))
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <h5 class="card-header">Borrow Requests</h5>
                            <div class="table-responsive text-nowrap">
                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th>Book</th>
                                            <th>User</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($toBorrows as $item)
                                            <tr>
                                                <td><a href="{{ route('books.show', $item->book_id) }}"
                                                        class="d-flex align-items-center gap-2">
                                                        @if ($item->book->image)
                                                            <div class="avatar avatar-l pull-up">
                                                                <img src="{{ asset('storage/' . $item->book->image->filename) }}"
                                                                    alt="Avatar" class="rounded-circle" />
                                                            </div>
                                                        @endif
                                                        <strong>{{ $item->book->title }}</strong>
                                                    </a></td>
                                                <td>{{ $item->user->name }}</td>
                                                <td></td>
                                                <td>
                                                    <div class="d-flex justify-content-center gap-2" role="group">
                                                        <a href="{{ route('borrowings.index', ['userId' => $item->user_id, 'bookId' => $item->book_id]) }}"
                                                            class="btn btn-sm btn-info">Issue</a>
                                                        <form action="{{ route('borrow_requests.destroy', $item->id) }}"
                                                            method="post" style="display: inline">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button class="btn btn-sm btn-danger" type="submit">
                                                                <i class='bx bx-trash'></i>
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
                </div>
            @endif
        </div>
        <div class="col-lg-7">
            @if (count($booksAvailable))
                <div class="card">
                    <div class="card-header">
                        <h4>Available Books</h4>
                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>Book Title</th>
                                    <th>Author</th>
                                    <th>Publisher</th>
                                    <th>Category</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($booksAvailable as $book)
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
                                        <td>{{ $book->category->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="px-3">
                            {{ $booksAvailable->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @if (count($returnings))
        <div class="row">
            <div class="col-lg-10 offsert-lg-1">
                <div class="card">
                    <h5 class="card-header">Overdue List</h5>
                    <div class="table-responsive text-nowrap">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>Borrow ID</th>
                                    <th>Book</th>
                                    <th>User</th>
                                    <th>Overdue</th>
                                    <th>Fine</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($returnings as $returning)
                                    <tr>
                                        <td>{{ $returning->borrowing_id }}</td>
                                        <td>
                                            <a href="{{ route('books.show', $returning->book_id) }}"
                                                class="d-flex align-items-center gap-2">
                                                @if ($returning->book->image)
                                                    <div class="avatar avatar-l pull-up">
                                                        <img src="{{ asset('storage/' . $returning->book->image->filename) }}"
                                                            alt="Avatar" class="rounded-circle" />
                                                    </div>
                                                @endif
                                                <strong>{{ $returning->book->title }}</strong>
                                            </a>
                                        </td>
                                        <td>{{ $returning->user->name }}</td>
                                        <td>{{ $returning->date_returned }}</td>
                                        <td>${{ $returning->fine }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="px-3">
                            {{ $returnings->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection
