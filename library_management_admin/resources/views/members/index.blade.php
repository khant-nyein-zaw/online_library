@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Member List</h5>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            @if ($user->image)
                                                <div class="avatar avatar-l pull-up">
                                                    <img src="{{ asset('storage/' . $user->image->filename) }}" alt="Avatar"
                                                        class="rounded-circle" />
                                                </div>
                                            @endif
                                            <strong>{{ $user->name }}</strong>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td class="text-capitalize">{{ $user->role->role_name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
