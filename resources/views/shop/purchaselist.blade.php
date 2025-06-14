@extends('layouts.app')

@section('title', 'Transactions List')

@section('content')

<div class="container py-4">
    <div class="card shadow-sm rounded-4 mx-auto" style="max-width: 700px;">
        <div class="card-body p-4">
            <h4 class="mb-4 text-primary text-center fw-semibold">Transactions List</h4>
            <div class="table-responsive">
                <table class="table table-hover align-middle text-nowrap">
                    <thead class="table-primary">
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Customer</th>
                            <th scope="col">Details</th>
                            <th scope="col">Sell Amount</th>
                            <th scope="col">Payment Amount</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transictions as $t)
                            <tr>
                                <td>{{ $t->date }}</td>
                                <td>{{ $t->customer->c_name ?? '-' }}</td>
                                <td>{{ $t->details }}</td>
                                <td>{{ number_format($t->sellamount, 2) }}</td>
                                <td>{{ number_format($t->paymentamount, 2) }}</td>
                                <td>
                                    <a href="{{ route('transictions.edit', $t->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                </td>
                                <td>
                                    <form action="{{ route('transictions.delete', $t->id) }}" method="GET" style="display:inline;">
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this transaction?');">Delete</button>
                                    </form>
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
