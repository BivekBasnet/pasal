@extends('layouts.app')

@section('title', 'Edit Transaction')

@section('content')
<div class="container py-5">
    <div class="card shadow rounded-4 mx-auto" style="max-width: 600px;">
        <div class="card-body p-4">
            <h3 class="mb-4 text-center text-primary">Edit Transaction</h3>
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
            <form action="{{ route('transictions.update', $transiction->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="customer_id" class="form-label">Customer</label>
                    <select name="customer_id" id="customer_id" class="form-select" required>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ $transiction->customer_id == $customer->id ? 'selected' : '' }}>{{ $customer->c_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="details" class="form-label">Details</label>
                    <input type="text" class="form-control" id="details" name="details" value="{{ old('details', $transiction->details) }}" required>
                </div>
                <div class="mb-3">
                    <label for="sellamount" class="form-label">Sell Amount</label>
                    <input type="number" class="form-control" id="sellamount" name="sellamount" value="{{ old('sellamount', $transiction->sellamount) }}" required>
                </div>
                <div class="mb-3">
                    <label for="paymentamount" class="form-label">Payment Amount</label>
                    <input type="number" class="form-control" id="paymentamount" name="paymentamount" value="{{ old('paymentamount', $transiction->paymentamount) }}" required>
                </div>
                <div class="mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" class="form-control" id="date" name="date" value="{{ old('date', $transiction->date) }}" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-lg" style="background-color: #6f42c1; color: #fff;">Update Transaction</button>
                </div>
            </form>
        </div>
    </div>
</div>
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
@endsection
