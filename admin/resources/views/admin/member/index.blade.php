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
                                    <th>Overdue Books</th>
                                    <th>Change Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr data-userid="{{ $user->id }}">
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
                                        <td>
                                            @if ($user->id !== auth()->user()->id)
                                                <select id="roleId" class="form-select">
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->id }}"
                                                            {{ $role->id === $user->role_id ? 'selected' : '' }}>
                                                            {{ $role->main_role }}</option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </td>
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

@push('script')
    <script>
        $(document).ready(function() {
            $('#roleId').on('change', function() {
                let roleId = $(this).val();
                let userId = $(this).parent().parent().data('userid');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "post",
                    url: `{{ route('members.changeRole') }}`,
                    data: {
                        roleId,
                        userId
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        }
                    }
                })
            })
        });
    </script>
@endpush
