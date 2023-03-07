@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if (count($users))
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Member List</h5>
                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Issued Books</th>
                                    <th>Overdue</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                @if ($user->image)
                                                    <div class="avatar avatar-l pull-up">
                                                        <img src="{{ asset('storage/' . $user->image->filename) }}"
                                                            alt="Avatar" class="rounded-circle" />
                                                    </div>
                                                @endif
                                                <strong>{{ $user->name }}</strong>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="#">{{ $user->email }}</a>
                                        </td>
                                        <td>{{ $user->issued_books_count }}</td>
                                        <td>{{ count($user->issuedBooks) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="alert alert-warning">
                    <strong>No member exists right now!</strong>
                </div>
            @endif
        </div>
    </div>
@endsection
