@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-xl">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Lend Requests</h5>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Book</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $d)
                                <tr>
                                    <td>{{ $d->user->name }}</td>
                                    <td><a href="{{ route('books.show', $d->book->id) }}"
                                            class="d-flex align-items-center gap-2">
                                            @if ($d->book->image)
                                                <div class="avatar avatar-l pull-up">
                                                    <img src="{{ asset('storage/' . $d->book->image->filename) }}"
                                                        alt="Avatar" class="rounded-circle" />
                                                </div>
                                            @endif
                                            <strong>{{ $d->book->title }}</strong>
                                        </a></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <a href="#" class="btn btn-sm btn-info rounded">
                                                Accept
                                            </a>
                                            <a href="#" class="btn btn-sm btn-danger rounded">
                                                Deny
                                            </a>
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
@endsection
