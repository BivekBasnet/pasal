@extends('layouts.app')

@section('title', 'Customer Purchases')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-9">
            <!-- Customer Selection Card -->
            <div class="card shadow-sm rounded-3 mb-4">
                <div class="card-body p-4">
                    <h4 class="card-title text-primary text-center mb-4">Customer Purchase History</h4>

                    <!-- Debug Info (hidden by default) -->
                    {{-- <div id="debugInfo" class="alert alert-info mb-3 d-none">
                        <small class="d-block mb-1"><strong>Debug Mode:</strong> <span id="debugStatus"></span></small>
                        <small class="d-block"><strong>Last Request:</strong> <span id="lastRequest"></span></small>
                        <small class="d-block"><strong>Last Response:</strong> <span id="lastResponse"></span></small>
                    </div> --}}

                    <form id="customerSelectForm" class="mb-4">
                        <select name="customer_id" id="customer_id" class="form-select select2" required>
                            <option value="">-- Select a Customer --</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->c_name }} {{ $customer->phone ? "- {$customer->phone}" : '' }}</option>
                            @endforeach
                        </select>
                    </form>

                    <!-- Loading Spinner -->
                    <div id="loadingSpinner" class="text-center d-none">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>

                    <!-- Error Alert -->
                    <div id="errorAlert" class="alert alert-danger d-none" role="alert"></div>

                    <!-- Customer Info and Summary -->
                    <div id="customerSummary" class="d-none">
                        <div class="row g-4 mb-4">
                            <!-- Customer Details -->
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-body" id="customerInfo"></div>
                                </div>
                            </div>
                            <!-- Financial Summary -->
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-subtitle mb-2 text-muted">Financial Summary</h6>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Total Sales:</span>
                                            <span class="fw-bold" id="totalSales">-</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Total Payments:</span>
                                            <span class="fw-bold" id="totalPayments">-</span>
                                        </div>
                                        <div class="d-flex justify-content-between pt-2 border-top">
                                            <span>Balance:</span>
                                            <span class="fw-bold" id="balance">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Monthly Summary -->
                        <div class="card bg-light mb-4">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-3 text-muted">Monthly Summary</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm" id="monthlySummaryTable">
                                        <thead>
                                            <tr>
                                                <th>Month</th>
                                                <th class="text-end">Sales</th>
                                                <th class="text-end">Payments</th>
                                                <th class="text-center">Transactions</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Transactions Table -->
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-3 text-muted">Transaction History</h6>
                                <div class="table-responsive">
                                    <table class="table table-hover" id="transactionsTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Date</th>
                                                <th>Details</th>
                                                <th class="text-end">Sale Amount</th>
                                                <th class="text-end">Payment</th>
                                                <th class="text-end">Running Balance</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('css')
<style>
/* Select2 Customization */
.select2-container--default .select2-selection--single {
    height: 38px;
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 38px;
    padding-left: 12px;
    color: #212529;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 36px;
}
.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #0d6efd;
}
.table th {
    font-weight: 600;
}
.negative-amount {
    color: #dc3545;
}
.positive-amount {
    color: #198754;
}
#debugInfo {
    font-family: monospace;
    white-space: pre-wrap;
    max-height: 200px;
    overflow-y: auto;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Enable debug mode
    const DEBUG = true;

    // Initialize Select2
    $('.select2').select2({
        width: '100%',
        placeholder: "Select a customer",
        allowClear: true
    });

    // Format currency
    function formatCurrency(amount) {
        return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'NPR',
            minimumFractionDigits: 2
        }).format(amount || 0);
    }

    // Format date
    function formatDate(dateStr) {
        try {
            return new Date(dateStr).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });
        } catch (e) {
            console.error('Date formatting error:', e);
            return dateStr;
        }
    }

    // Debug functions
    function updateDebugInfo(requestInfo, responseInfo) {
        if (!DEBUG) return;

        $('#debugInfo').removeClass('d-none');
        $('#debugStatus').text('Enabled');
        $('#lastRequest').text(JSON.stringify(requestInfo, null, 2));
        $('#lastResponse').text(typeof responseInfo === 'string' ? responseInfo : JSON.stringify(responseInfo, null, 2));
    }

    // Show/hide elements
    function toggleElements(show, hide) {
        show.forEach(el => $(el).removeClass('d-none'));
        hide.forEach(el => $(el).addClass('d-none'));
    }

    // Load customer data
    function loadCustomerData(customerId) {
        if (!customerId) {
            toggleElements([], ['#customerSummary', '#loadingSpinner', '#errorAlert']);
            return;
        }

        toggleElements(['#loadingSpinner'], ['#customerSummary', '#errorAlert']);

        // Log request
        updateDebugInfo({ endpoint: `/customer/purchases/${customerId}`, method: 'GET' }, 'Sending request...');

        // Ensure CSRF token is set
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (token) {
            axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
        }

        axios.get(`/customer/purchases/${customerId}`)
            .then(response => {
                updateDebugInfo(
                    { endpoint: `/customer/purchases/${customerId}`, method: 'GET' },
                    response.data
                );

                const data = response.data;

                if (!data || !data.customer) {
                    throw new Error('Invalid response format');
                }

                // Update customer info
                $('#customerInfo').html(`
                    <h6 class="card-subtitle mb-2 text-muted">Customer Details</h6>
                    <p class="mb-1"><strong>${data.customer.name}</strong></p>
                    <p class="mb-0 text-muted">${data.customer.phone || 'No phone number'}</p>
                `);

                // Update financial summary
                $('#totalSales').text(formatCurrency(data.summary.total_sell));
                $('#totalPayments').text(formatCurrency(data.summary.total_payment));
                $('#balance').text(formatCurrency(data.summary.balance))
                    .toggleClass('negative-amount', data.summary.balance < 0)
                    .toggleClass('positive-amount', data.summary.balance > 0);

                // Update monthly summary
                const monthlyRows = Object.entries(data.monthly_summary || {})
                    .sort((a, b) => b[0].localeCompare(a[0]))
                    .map(([month, summary]) => `
                        <tr>
                            <td>${new Date(month + '-01').toLocaleDateString('en-US', {year: 'numeric', month: 'long'})}</td>
                            <td class="text-end">${formatCurrency(summary.sell_amount)}</td>
                            <td class="text-end">${formatCurrency(summary.payment_amount)}</td>
                            <td class="text-center">${summary.transaction_count}</td>
                        </tr>
                    `).join('');

                $('#monthlySummaryTable tbody').html(monthlyRows || '<tr><td colspan="4" class="text-center">No monthly data available</td></tr>');

                // Update transactions
                let runningBalance = 0;
                const transactionRows = (data.transactions || []).map(t => {
                    runningBalance += (t.sellamount - t.paymentamount);
                    return `
                        <tr>
                            <td>${formatDate(t.date)}</td>
                            <td>${t.details || ''}</td>
                            <td class="text-end">${formatCurrency(t.sellamount)}</td>
                            <td class="text-end">${formatCurrency(t.paymentamount)}</td>
                            <td class="text-end ${runningBalance < 0 ? 'negative-amount' : 'positive-amount'}">
                                ${formatCurrency(runningBalance)}
                            </td>
                        </tr>
                    `;
                }).join('');

                $('#transactionsTable tbody').html(transactionRows || '<tr><td colspan="5" class="text-center">No transactions found</td></tr>');

                toggleElements(['#customerSummary'], ['#loadingSpinner', '#errorAlert']);
            })
            .catch(error => {
                console.error('Error:', error);

                updateDebugInfo(
                    { endpoint: `/customer/purchases/${customerId}`, method: 'GET' },
                    {
                        error: error.message,
                        response: error.response?.data
                    }
                );

                const errorMessage = error.response?.data?.message
                    || error.message
                    || 'Failed to load customer data. Please try again.';

                $('#errorAlert')
                    .text(errorMessage)
                    .removeClass('d-none');

                toggleElements(['#errorAlert'], ['#loadingSpinner', '#customerSummary']);
            });
    }

    // Handle customer selection
    $('#customer_id').on('change', function() {
        const customerId = this.value;
        if (!DEBUG) {
            $('#debugInfo').addClass('d-none');
        }
        loadCustomerData(customerId);
    });

    // Load initial data if customer is selected
    const initialCustomerId = $('#customer_id').val();
    if (initialCustomerId) {
        loadCustomerData(initialCustomerId);
    }
});
</script>
@endpush
@endsection
