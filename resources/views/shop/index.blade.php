@extends('layouts.app')

@section('title', 'Add New Transictions')

@section('content')
<div class="container py-5">
    <div class="card shadow rounded-4 mx-auto" style="max-width: 600px;">
        <div class="card-body p-4">
            <h3 class="mb-4 text-center text-primary">Add New Transictions</h3>
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
            <form id="transictionForm" method="POST" action="{{ route('transictions.store') }}" autocomplete="on">

                @csrf

                <div class="mb-3">
                    <label for="customer_id" class="form-label">Customer</label>
                    <select name="customer_id" id="customer_id" class="form-select" required>
                        <option value="">-- Select Customer --</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->c_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="details" class="form-label">Details</label>
                    <input type="text" class="form-control" id="details" name="details" placeholder="Details" required>
                </div>

                <div class="mb-3">
                    <label for="sellamount" class="form-label">Sell Amount</label>
                    <input type="number" class="form-control" id="sellamount" name="sellamount" placeholder="Sell Amount" required>
                </div>

                <div class="mb-3">
                    <label for="paymentamount" class="form-label">Payment Amount</label>
                    <input type="number" class="form-control" id="paymentamount" name="paymentamount" placeholder="Payment Amount" required>
                </div>

                <div class="mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" class="form-control" id="date" name="date" value="{{ old('date', $today ?? date('Y-m-d')) }}" required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-lg" style="background-color: #6f42c1; color: #fff;" id="submitBtn">Save Transictions</button>
                </div>
            </form>

            <script>
            document.getElementById('transictionForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const form = e.target;
                const formData = new FormData(form);
                document.getElementById('submitBtn').disabled = true;
                axios.post("{{ route('transictions.store') }}", formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(response => {
                    form.reset();
                    document.getElementById('submitBtn').disabled = false;
                    // Show success alert and auto-dismiss after 3 seconds
                    const alert = document.createElement('div');
                    alert.className = 'alert alert-success';
                    alert.textContent = 'Transaction saved successfully!';
                    document.querySelector('.card-body').insertAdjacentElement('afterbegin', alert);
                    setTimeout(() => alert.remove(), 3000);
                })
                .catch(error => {
                    document.getElementById('submitBtn').disabled = false;
                    if (error.response && error.response.data && error.response.data.errors) {
                        let errors = error.response.data.errors;
                        let errorHtml = '<div class="alert alert-danger"><ul>';
                        Object.values(errors).forEach(errArr => {
                            errArr.forEach(err => {
                                errorHtml += `<li>${err}</li>`;
                            });
                        });
                        errorHtml += '</ul></div>';
                        document.querySelector('.card-body').insertAdjacentHTML('afterbegin', errorHtml);
                    }
                });
            });

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

@push('scripts')
<script>
    $(document).ready(function() {
        $('#customer_id').select2({
            placeholder: "-- Select Customer --",
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endpush

