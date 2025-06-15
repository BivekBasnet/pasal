@extends('layouts.app')

@section('title', 'Edit Customer')

@section('content')
<div class="container py-5">
    <div class="card shadow rounded-4 mx-auto" style="max-width: 600px;">
        <div class="card-body p-4">
            <h3 class="mb-4 text-center text-primary">Edit Customer</h3>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                @csrf
                @method('PUT')
                @method('PUT')
                <div class="mb-3">
                    <label for="c_name" class="form-label">Name</label>
                    <input type="text" class="form-control @error('c_name') is-invalid @enderror"
                           id="c_name" name="c_name" value="{{ old('c_name', $customer->c_name) }}" required>
                    @error('c_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="number" class="form-control @error('phone') is-invalid @enderror"
                           id="phone" name="phone" value="{{ old('phone', $customer->phone) }}" required>
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-lg" style="background-color: #6f42c1; color: #fff;">Update Customer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
