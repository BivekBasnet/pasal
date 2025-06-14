@extends('layouts.app')

@section('title', 'Customer Purchases')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm rounded-4 mx-auto" style="max-width: 700px;">
        <div class="card-body p-4">
            <h4 class="mb-4 text-primary text-center fw-semibold">Select Customer</h4>
            <form id="customerSelectForm">
                <select name="customer_id" id="customer_id" class="form-select mb-4" required>
                    <option value="">-- Select Customer --</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->c_name }}</option>
                    @endforeach
                </select>
            </form>
            <div id="customerInfo" class="mb-3"></div>
            <div class="mb-3">
                <label for="balance" class="form-label">Balance (Sell Amount - Payment Amount)</label>
                <input type="text" id="balance" class="form-control" value="" readonly>
            </div>
            <div id="purchaseList"></div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('customer_id').addEventListener('change', function() {
    const customerId = this.value;
    if (!customerId) {
        document.getElementById('customerInfo').innerHTML = '';
        document.getElementById('purchaseList').innerHTML = '';
        document.getElementById('balance').value = '';
        return;
    }
    document.getElementById('purchaseList').innerHTML = '<div class="alert alert-warning mt-3">Loading...</div>';
    axios.get(`/customer/purchases/${customerId}`)
        .then(response => {
            let purchases = response.data.purchases || [];
            let customer = response.data.customer || null;
            if (customer) {
                document.getElementById('customerInfo').innerHTML =
                    `<div class="alert alert-secondary">
                        <strong>Customer:</strong> ${customer.c_name} <br>
                        <strong>Phone:</strong> ${customer.phone ?? '-'}
                    </div>`;
            } else {
                document.getElementById('customerInfo').innerHTML = '';
            }
            // Calculate balance
            let totalSell = purchases.reduce((sum, p) => sum + parseFloat(p.sellamount), 0);
            let totalPayment = purchases.reduce((sum, p) => sum + parseFloat(p.paymentamount), 0);
            let balance = (totalSell - totalPayment).toFixed(2);
            document.getElementById('balance').value = balance;
            if (purchases.length === 0) {
                document.getElementById('purchaseList').innerHTML = '<div class="alert alert-info mt-3">No purchases found for this customer.</div>';
                return;
            }
            let html = `<table class="table table-bordered mt-3"><thead><tr><th>Date</th><th>Details</th><th>Sell Amount</th><th>Payment Amount</th></tr></thead><tbody>`;
            purchases.forEach(p => {
                html += `<tr><td>${p.date}</td><td>${p.details}</td><td>${parseFloat(p.sellamount).toFixed(2)}</td><td>${parseFloat(p.paymentamount).toFixed(2)}</td></tr>`;
            });
            html += '</tbody></table>';
            document.getElementById('purchaseList').innerHTML = html;
        })
        .catch((error) => {
            document.getElementById('customerInfo').innerHTML = '';
            document.getElementById('purchaseList').innerHTML = '<div class="alert alert-danger mt-3">Failed to load purchases.</div>';
            document.getElementById('balance').value = '';
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
@endsection
