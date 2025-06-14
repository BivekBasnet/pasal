@extends('layouts.app')

@section('title', 'Details')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm rounded-4 mx-auto" style="max-width: 700px;">
        <div class="card-body p-4">
            <h4 class="mb-4 text-primary text-center fw-semibold">Details Section</h4>
            <form method="POST" action="{{ route('details.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="detail_name" class="form-label">Detail Name</label>
                    <input type="text" class="form-control" id="detail_name" name="detail_name" placeholder="Enter detail name" required>
                </div>
                <div class="mb-3">
                    <label for="detail_value" class="form-label">Detail Value</label>
                    <input type="text" class="form-control" id="detail_value" name="detail_value" placeholder="Enter detail value" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Add Detail</button>
                </div>
            </form>
            <hr>
            <h5 class="mt-4">All Details</h5>
            <ul class="list-group">
                @foreach($details as $detail)
                    <li class="list-group-item">{{ $detail->detail_name }}: {{ $detail->detail_value }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
