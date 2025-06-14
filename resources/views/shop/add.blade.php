@extends('layouts.app')

@section('title', 'Add New Customer')

@section('content')
<div class="container py-5">
    <div class="card shadow rounded-4 mx-auto" style="max-width: 600px;">
        <div class="card-body p-4">
            <h3 class="mb-4 text-center text-primary">Add New customer</h3>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('customers.store') }}" method="POST" id="customerForm">
                @csrf

                <div class="mb-3">
                    <label for="c_name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="c_name" name="c_name" placeholder="Enter customer Name" required>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="number" class="form-control" id="phone" name="phone" placeholder="Enter customer Phone" required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-lg" style="background-color: #6f42c1; color: #fff;">Save customer</button>
                </div>
            </form>

            <script>
            // Auto-dismiss all alerts after 3 seconds
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(function() {
                    document.querySelectorAll('.alert').forEach(function(alert) {
                        alert.remove();
                    });
                }, 3000);
            });
            </script>
        </div>
    </div>
</div>
@endsection
