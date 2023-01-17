@extends('layout.master')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('shelves.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Import shelves from excel</label>
                            <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" />
                            @error('file')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary">Import</button>
                        <a href="{{ route('shelves.export') }}" class="btn btn-sm btn-info">Download Shelf List</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
