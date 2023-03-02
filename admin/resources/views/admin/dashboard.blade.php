@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-4 col-md-12 col-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <i class='bx bxs-book-content rounded text-success fs-2'></i>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Available Books</span>
                    <h3 class="card-title mb-2">{{ $booksAvailable }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12 col-6 mb-4">
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
        <div class="col-lg-4 col-md-12 col-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <i class='bx bxs-user-badge rounded text-success fs-2'></i>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Members</span>
                    <h3 class="card-title mb-2">{{ $members }}</h3>
                </div>
            </div>
        </div>
    </div>
    @if (count($lendRequests))
        <div class="row">
            <div class="col-sm-10">
                <div class="card">
                    <h4 class="card-header">
                        Lend Requests
                    </h4>
                    <ul class="list-group">
                        @foreach ($lendRequests as $index)
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="text-primary fw-light mb-0">{{ $index->user->name }} has requested to lend
                                        {{ $index->book->title }} for
                                        {{ $index->duration }} days.</p>
                                    <div class="btn-group-sm">
                                        <a href="{{ route('issuedBooks.index') }}" class="btn btn-primary">Issue</a>
                                        <form action="{{ route('dashboard.destroyLendRequest', $index) }}" method="POST"
                                            class="d-inline">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif
@endsection
