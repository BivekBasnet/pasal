@extends('layouts.app')

@section('title', 'Day Purchase')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm rounded-4 mx-auto" style="max-width: 700px;">
        <div class="card-body p-4">
            <h4 class="mb-4 text-primary text-center fw-semibold">Purchases by Date</h4>
            <form method="GET" action="{{ route('transictions.day') }}" class="mb-4 d-flex justify-content-center align-items-center gap-2">
                <input type="date" name="date" class="form-control" style="max-width: 200px;" value="{{ request('date', $today ?? date('Y-m-d')) }}">
                <button type="submit" class="btn btn-primary">Show</button>
            </form>
            <div class="mb-3 d-flex justify-content-end align-items-center gap-2">
                <label for="total-due" class="fw-semibold mb-0">Total Due:</label>
                <input type="text" id="total-due" class="form-control" style="max-width: 180px;" value="{{ number_format($purchases->sum('sellamount') - $purchases->sum('paymentamount'), 2) }}" readonly>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle text-nowrap">
                    <thead class="table-primary">
                        <tr>
                            <th>Date</th>
                            <th>Details</th>
                            <th>Sell Amount</th>
                            <th>Payment Amount</th>
                            <th>Customer</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purchases as $p)
                            <tr>
                                <td>{{ $p->date }}</td>
                                <td>{{ $p->details }}</td>
                                <td>{{ number_format($p->sellamount, 2) }}</td>
                                <td>{{ number_format($p->paymentamount, 2) }}</td>
                                <td>{{ $p->customer->name ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
