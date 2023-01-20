@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-4">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <i class='bx bxs-file-export rounded text-success fs-2'></i>
                                </div>
                            </div>
                            <span class="fw-semibold d-block mb-1">Borrowed Books</span>
                            <h3 class="card-title mb-2">12</h3>
                            <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i>Something</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <i class='bx bx-time rounded text-success fs-2'></i>
                                </div>
                            </div>
                            <span class="fw-semibold d-block mb-1">Overdue Books</span>
                            <h3 class="card-title text-nowrap mb-2">3</h3>
                            <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i>Something</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <h5 class="card-header">Overdue Book List</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Member</th>
                                <th>Overdue</th>
                                <th>Fines</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>12</td>
                                <td>Linda</td>
                                <td>12 days</td>
                                <td>$14.00</td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-success">View More</button>
                                        <button type="button" class="btn btn-danger">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    {{-- <div class="px-3">
                        {{ $books->links() }}
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
