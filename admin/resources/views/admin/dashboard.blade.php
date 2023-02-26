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
                            <h3 class="card-title mb-2">5</h3>
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
                            <h3 class="card-title text-nowrap mb-2">5</h3>
                        </div>
                    </div>
                </div>
            </div>
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

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
