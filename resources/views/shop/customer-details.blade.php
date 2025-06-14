@extends('layouts.app')

@section('title', 'Customer Details - ' . $customer->c_name)

@section('content')
<div class="container py-5">
    <div class="card shadow rounded-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="text-primary mb-0">{{ $customer->c_name }}'s Transactions</h3>
                <div class="text-end">
                    <h5>Contact: {{ $customer->c_number }}</h5>
                    <h5>Address: {{ $customer->c_address }}</h5>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h5 class="card-title">Total Sales</h5>
                            <h3 class="mb-0">₨ {{ number_format($totalSales, 2) }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h5 class="card-title">Total Payments</h5>
                            <h3 class="mb-0">₨ {{ number_format($totalPayments, 2) }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card {{ $balance > 0 ? 'bg-danger' : 'bg-info' }} text-white">
                        <div class="card-body">
                            <h5 class="card-title">Balance</h5>
                            <h3 class="mb-0">₨ {{ number_format(abs($balance), 2) }} {{ $balance > 0 ? '(Due)' : '(Advance)' }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Details</th>
                            <th>Sale Amount</th>
                            <th>Payment</th>
                            <th>Running Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $runningBalance = 0; @endphp
                        @foreach($transactions as $transaction)
                            @php
                                $runningBalance += $transaction->sellamount - $transaction->paymentamount;
                            @endphp
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($transaction->date)->format('Y-m-d') }}</td>
                                <td>{{ $transaction->details }}</td>
                                <td>₨ {{ number_format($transaction->sellamount, 2) }}</td>
                                <td>₨ {{ number_format($transaction->paymentamount, 2) }}</td>
                                <td class="{{ $runningBalance > 0 ? 'text-danger' : 'text-success' }}">
                                    ₨ {{ number_format(abs($runningBalance), 2) }}
                                    {{ $runningBalance > 0 ? '(Due)' : '(Advance)' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
