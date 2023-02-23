@extends('layouts.master')

@section('content')
    @if (count($returnings))
        <div class="row">
            <div class="col-lg-10 offsert-lg-1">
                <div class="card">
                    <h5 class="card-header">Returning List</h5>
                    <div class="table-responsive text-nowrap">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>Borrow ID</th>
                                    <th>Book</th>
                                    <th>From</th>
                                    <th>Overdue</th>
                                    <th>Returned Date</th>
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
                                        <td class="text-primary fw-bold">{{ $returning->user->name }}</td>
                                        <td>{{ $returning->overdue }}</td>
                                        <td>{{ date('M d Y', strtotime($returning->date_returned)) }}</td>
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
    @else
        <div class="">
            There are no returning data right now.
        </div>
    @endif
@endsection
