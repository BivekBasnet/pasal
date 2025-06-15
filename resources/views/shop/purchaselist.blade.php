@extends('layouts.app')

@section('title', 'Transactions List')

@section('content')
<style>
    /* Responsive table styles */
    .table-responsive {
        margin: 0;
        padding: 0;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        scroll-behavior: smooth;
    }

    .table {
        width: 100%;
        margin-bottom: 0;
    }

    /* Column widths for better space distribution */
    .table th:nth-child(1) { min-width: 100px; } /* Date */
    .table th:nth-child(2) { min-width: 120px; } /* Customer */
    .table th:nth-child(3) { min-width: 200px; } /* Details */
    .table th:nth-child(4) { min-width: 110px; } /* Sell Amount */
    .table th:nth-child(5) { min-width: 110px; } /* Payment Amount */
    .table th:nth-child(6) { min-width: 80px; } /* Edit */
    .table th:nth-child(7) { min-width: 80px; } /* Delete */

    /* Make text wrap on smaller screens */
    .table td, .table th {
        white-space: normal;
        padding: 12px 8px;
        font-size: 14px;
        vertical-align: middle;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    /* Ensure action buttons are fully visible */
    .btn {
        white-space: nowrap;
        margin: 2px;
        padding: 0.375rem 0.75rem;
        width: auto;
        display: inline-block;
    }

    /* Custom scrollbar for better UX */
    .table-responsive::-webkit-scrollbar {
        height: 6px;
    }

    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 3px;
    }

    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Hover effect on rows */
    .table-hover tbody tr:hover {
        background-color: rgba(0,123,255,0.05);
        transition: background-color 0.2s ease;
    }

    /* Adjust card width for full view */
    .transaction-card {
        max-width: 1200px !important;
        width: 95% !important;
        margin: 20px auto;
    }

    /* Make the card responsive */
    @media (max-width: 768px) {
        .transaction-card {
            margin: 10px;
            width: calc(100% - 20px) !important;
        }

        .card-body {
            padding: 12px !important;
        }

        /* Mobile table styles */
        .table {
            font-size: 12px;
        }

        .table td, .table th {
            font-size: 12px;
            padding: 8px 4px;
            height: auto;
            white-space: normal;
            min-height: 40px;
        }

        /* Column widths for mobile */
        .table th:nth-child(1), .table td:nth-child(1) { min-width: 90px; } /* Date */
        .table th:nth-child(2), .table td:nth-child(2) { min-width: 100px; } /* Customer */
        .table th:nth-child(3), .table td:nth-child(3) { min-width: 150px; } /* Details */
        .table th:nth-child(4), .table td:nth-child(4) { min-width: 100px; } /* Sell Amount */
        .table th:nth-child(5), .table td:nth-child(5) { min-width: 100px; } /* Payment Amount */
        .table th:nth-child(6), .table td:nth-child(6) { min-width: 70px; } /* Edit */
        .table th:nth-child(7), .table td:nth-child(7) { min-width: 70px; } /* Delete */

        /* Button adjustments */
        .btn-sm {
            padding: 0.2rem 0.4rem;
            font-size: 11px;
            margin: 1px;
        }

        /* Improve mobile scroll experience */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scroll-behavior: smooth;
            padding-bottom: 6px; /* Space for scrollbar */
        }
    }

    /* Additional styles for very small screens */
    @media (max-width: 480px) {
        .table td, .table th {
            font-size: 11px;
            padding: 6px 3px;
        }

        .btn-sm {
            padding: 0.15rem 0.3rem;
            font-size: 10px;
        }

        h4.mb-4 {
            font-size: 18px;
            margin-bottom: 12px !important;
        }
    }
</style>

<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-sm rounded-4 transaction-card">
        <div class="card-body p-4">
            <h4 class="mb-4 text-primary text-center fw-semibold">Transactions List</h4>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
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
