@extends('layouts.app')

@section('title', 'Edit Customer')

@section('content')
<div class="container py-5">
    <div class="card shadow rounded-4 mx-auto" style="max-width: 600px;">
        <div class="card-body p-4">
            <h3 class="mb-4 text-center text-primary">Edit Customer</h3>
            <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="c_name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="c_name" name="c_name" value="{{ old('c_name', $customer->c_name) }}" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="number" class="form-control" id="phone" name="phone" value="{{ old('phone', $customer->phone) }}" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-lg" style="background-color: #6f42c1; color: #fff;">Update Customer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
