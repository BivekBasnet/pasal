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
                <!-- First Row: Date and Customer -->
                <div class="row g-2 mb-3">
                    <div class="col-md-4">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control form-control-sm" id="date" name="date" value="{{ old('date', $transiction->date) }}" required>
                    </div>
                    <div class="col-md-8">
                        <label for="customer_id" class="form-label">Customer</label>
                        <select name="customer_id" id="customer_id" class="form-select form-select-sm" required>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ $transiction->customer_id == $customer->id ? 'selected' : '' }}>{{ $customer->c_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Second Row: Details -->
                <div class="row mb-3">
                    <div class="col-12">
                        <label for="details" class="form-label">Details</label>
                        <input type="text" class="form-control form-control-sm" id="details" name="details" value="{{ old('details', $transiction->details) }}" required>
                    </div>
                </div>

                <!-- Third Row: Amounts and Update Button -->
                <div class="row g-2 align-items-end">
                    <div class="col-md-4">
                        <label for="sellamount" class="form-label">Sell Amount</label>
                        <input type="number" class="form-control form-control-sm" id="sellamount" name="sellamount" value="{{ old('sellamount', $transiction->sellamount) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="paymentamount" class="form-label">Payment Amount</label>
                        <input type="number" class="form-control form-control-sm" id="paymentamount" name="paymentamount" value="{{ old('paymentamount', $transiction->paymentamount) }}" required>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn w-100" style="background-color: #6f42c1; color: #fff; height: 31px; font-size: 0.875rem;">Update Transaction</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('css')
<style>
    /* Responsive styles */
    @media (max-width: 767.98px) {
        .card-body {
            padding: 1rem !important;
        }
        .row {
            margin-left: -0.5rem;
            margin-right: -0.5rem;
        }
        .col-md-4, .col-md-8 {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
        /* Keep the three columns layout on mobile */
        .align-items-end .col-md-4 {
            width: 33.33%;
            flex: 0 0 auto;
        }
        .form-control, .form-select, .btn {
            font-size: 0.875rem;
        }
        .form-label {
            font-size: 0.85rem;
            margin-bottom: 0.2rem;
        }
    }
</style>
@endpush

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
