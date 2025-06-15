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

                <!-- Customer and Date Row -->
                <div class="row g-3 mb-3">
                    <div class="col-md-7">
                        <label for="customer_id" class="form-label">Customer</label>
                        <select name="customer_id" id="customer_id" class="form-select" required>
                            <option value="">-- Select Customer --</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->c_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date"
                               value="{{ old('date', $today ?? date('Y-m-d')) }}" required>
                    </div>
                </div>

                <!-- Details Row -->
                <div class="mb-3">
                    <label for="details" class="form-label">Details</label>
                    <input type="text" class="form-control" id="details" name="details"
                           placeholder="Details" required>
                </div>

                <!-- Amount Row -->
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="sellamount" class="form-label">Sell Amount</label>
                        <div class="input-group">
                            <span class="input-group-text">₨</span>
                            <input type="number" class="form-control" id="sellamount"
                                   name="sellamount" placeholder="0.00" step="0.01" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="paymentamount" class="form-label">Payment Amount</label>
                        <div class="input-group">
                            <span class="input-group-text">₨</span>
                            <input type="number" class="form-control" id="paymentamount"
                                   name="paymentamount" placeholder="0.00" step="0.01" required>
                        </div>
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-lg" style="background-color: #6f42c1; color: #fff;" id="submitBtn">Save Transictions</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Today's Transactions Table -->
    <div class="card shadow rounded-4 mx-auto mt-4">
        <div class="card-body p-4">
            <h4 class="mb-4 text-primary">Today's Transactions</h4>
            <div class="table-responsive">
                <table class="table table-hover" id="todayTransactions">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Details</th>
                            <th>Sale Amount</th>
                            <th>Payment</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($todayTransactions as $transaction)
                        <tr>
                            <td>{{ $transaction->customer->c_name }}</td>
                            <td>{{ $transaction->details }}</td>
                            <td>₨ {{ number_format($transaction->sellamount, 2) }}</td>
                            <td>₨ {{ number_format($transaction->paymentamount, 2) }}</td>
                            <td>{{ $transaction->created_at->format('h:i A') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="table-info">
                            <td colspan="2"><strong>Total</strong></td>
                            <td><strong>₨ {{ number_format($todayTransactions->sum('sellamount'), 2) }}</strong></td>
                            <td><strong>₨ {{ number_format($todayTransactions->sum('paymentamount'), 2) }}</strong></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

@push('css')
<style>
/* Responsive Adjustments */
@media (max-width: 767.98px) {
    .card-body {
        padding: 1.25rem !important;
    }
    .input-group > .form-control {
        min-width: 0;
    }
    .table {
        font-size: 0.875rem;
    }
    th, td {
        white-space: nowrap;
    }
}

/* Select2 Mobile Fixes */
.select2-container--default .select2-selection--single {
    height: 38px;
    border: 1px solid #ced4da;
    border-radius: 0.375rem;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 38px;
    padding-left: 12px;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 36px;
}
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        $('#customer_id').select2({
            placeholder: "-- Select Customer --",
            allowClear: true,
            width: '100%'
        });
    });

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
            // Add new row to table
            const transaction = response.data.transaction;
            if (!transaction || !transaction.customer) {
                console.error('Invalid transaction data received:', transaction);
                throw new Error('Invalid transaction data received');
            }

            const newRow = `
                <tr>
                    <td>${transaction.customer.c_name}</td>
                    <td>${transaction.details}</td>
                    <td>₨ ${parseFloat(transaction.sellamount).toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                    <td>₨ ${parseFloat(transaction.paymentamount).toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                    <td>${new Date(transaction.created_at).toLocaleTimeString('en-US', {hour: 'numeric', minute: 'numeric', hour12: true})}</td>
                </tr>`;

            $('#todayTransactions tbody').prepend(newRow);

            // Update totals
            const currentSaleTotal = parseFloat($('#todayTransactions tfoot td:eq(2)').text().replace('₨ ', '').replace(/,/g, ''));
            const currentPaymentTotal = parseFloat($('#todayTransactions tfoot td:eq(3)').text().replace('₨ ', '').replace(/,/g, ''));

            const newSaleTotal = currentSaleTotal + parseFloat(transaction.sellamount);
            const newPaymentTotal = currentPaymentTotal + parseFloat(transaction.paymentamount);

            $('#todayTransactions tfoot td:eq(2)').html(`<strong>₨ ${newSaleTotal.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</strong>`);
            $('#todayTransactions tfoot td:eq(3)').html(`<strong>₨ ${newPaymentTotal.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</strong>`);

            // Reset form and show success message
            form.reset();
            $('#customer_id').val('').trigger('change');
            document.getElementById('submitBtn').disabled = false;

            const alert = document.createElement('div');
            alert.className = 'alert alert-success';
            alert.textContent = 'Transaction saved successfully!';
            document.querySelector('.card-body').insertAdjacentElement('afterbegin', alert);
            setTimeout(() => alert.remove(), 3000);
        })
        .catch(error => {
            console.log(error);

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
@endpush

