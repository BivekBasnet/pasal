@extends('layouts.app')

@section('title', 'Home - Bijay Kirana Pasal')

@section('content')
<div class="container-fluid py-4">
    <div class="row g-4">
        <!-- Quick Stats Cards -->
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Dashboard</h2>
                <div class="text-muted">{{ date('l, F j, Y') }}</div>
            </div>
        </div>

        <!-- Today's Stats -->
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Today's Overview</h5>
                    <span class="badge bg-light text-primary">{{ $todaysTransactions }} Transactions</span>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-muted mb-1">Sales</h6>
                                        <h4 class="mb-0">Rs. {{ number_format($todaysSales, 2) }}</h4>
                                    </div>
                                    <div class="fs-1 text-primary">📈</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-muted mb-1">Payments</h6>
                                        <h4 class="mb-0">Rs. {{ number_format($todaysPayments, 2) }}</h4>
                                    </div>
                                    <div class="fs-1 text-success">💰</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-muted mb-1">Collection Rate</h6>
                                        <h4 class="mb-0">
                                            {{ $todaysSales > 0 ? number_format(($todaysPayments / $todaysSales) * 100, 1) : 0 }}%
                                        </h4>
                                    </div>
                                    <div class="fs-1 text-info">📊</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Stats -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">This Month's Performance</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="p-3 bg-light rounded">
                                <h6 class="text-muted">Total Sales</h6>
                                <h4 class="mb-0">Rs. {{ number_format($thisMonthSales, 2) }}</h4>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="p-3 bg-light rounded">
                                <h6 class="text-muted">Total Payments</h6>
                                <h4 class="mb-0">Rs. {{ number_format($thisMonthPayments, 2) }}</h4>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="p-3 bg-light rounded">
                                <h6 class="text-muted">Collection Rate</h6>
                                <div class="progress" style="height: 25px;">
                                    @php
                                        $monthlyRate = $thisMonthSales > 0 ? ($thisMonthPayments / $thisMonthSales) * 100 : 0;
                                    @endphp
                                    <div class="progress-bar {{ $monthlyRate >= 90 ? 'bg-success' : ($monthlyRate >= 70 ? 'bg-info' : 'bg-warning') }}"
                                         role="progressbar"
                                         style="width: {{ $monthlyRate }}%"
                                         aria-valuenow="{{ $monthlyRate }}"
                                         aria-valuemin="0"
                                         aria-valuemax="100">
                                        {{ number_format($monthlyRate, 1) }}%
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Overall Stats -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Overall Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="p-3 bg-light rounded text-center">
                                <i class="fs-1 text-primary">👥</i>
                                <h6 class="text-muted mt-2">Total Customers</h6>
                                <h4 class="mb-0">{{ number_format($totalCustomers) }}</h4>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 bg-light rounded text-center">
                                <i class="fs-1 text-success">🧾</i>
                                <h6 class="text-muted mt-2">Transactions</h6>
                                <h4 class="mb-0">{{ number_format($totalTransactions) }}</h4>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="p-3 bg-light rounded">
                                <h6 class="text-muted">Pending Amount</h6>
                                <h4 class="mb-0 {{ $pendingAmount > 0 ? 'text-danger' : 'text-success' }}">
                                    Rs. {{ number_format($pendingAmount, 2) }}
                                </h4>
                                <small class="text-muted">
                                    Overall Collection Rate:
                                    {{ $totalSales > 0 ? number_format(($totalPayments / $totalSales) * 100, 1) : 0 }}%
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Customers -->
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Top 5 Customers</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Total Purchases</th>
                                    <th>View Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topCustomers as $customer)
                                    <tr>
                                        <td>{{ $customer->customer->c_name }}</td>
                                        <td>Rs. {{ number_format($customer->total_purchases, 2) }}</td>
                                        <td>
                                            <a href="{{ route('customer.details', $customer->customer_id) }}"
                                               class="btn btn-sm btn-outline-primary">
                                                View Details
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    transition: transform 0.2s, box-shadow 0.2s;
}
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15) !important;
}
.bg-light {
    background-color: #f8f9fa !important;
}
.progress {
    border-radius: 0.5rem;
}
.progress-bar {
    transition: width 1s ease;
}
</style>
@endsection
