@extends('layouts.app')

@section('title', 'Add New Transictions')

@section('content')
<div class="h-100">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
            <!-- Add Transaction Form -->
            <div class="card shadow rounded-4 mx-auto mb-4">
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
                        <div class="row g-2 mb-3">
                            <div class="col-4">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control form-control-sm" id="date" name="date"
                                    value="{{ old('date', $today ?? date('Y-m-d')) }}" required>
                            </div>
                            <div class="col-8">
                                <label for="customer_id" class="form-label">Customer</label>
                                <select name="customer_id" id="customer_id" class="form-select form-select-sm" required >
                                    <option value="">-- Select Customer --</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->c_name }}</option>
                                    @endforeach

                                </select>
                            </div>

                        </div>

                        <!-- Details Row -->
                        <div class="mb-3">
                            <label for="details" class="form-label">Details</label>
                            <textarea class="form-control" id="details" name="details"
                                placeholder="Details" required></textarea>
                        </div>

                        <!-- Amount Row with Save Button -->
                        <div class="row g-2 mb-3 align-items-end">
                            <div class="col-md-4">
                                <label for="sellamount" class="form-label">Sell Amount</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">₨</span>
                                    <input type="number" class="form-control" id="sellamount"
                                        name="sellamount" placeholder="0.00" step="0.01" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="paymentamount" class="form-label">Payment Amount</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">₨</span>
                                    <input type="number" class="form-control" id="paymentamount"
                                        name="paymentamount" placeholder="0.00" step="0.01" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn w-100" style="background-color: #6f42c1; color: #fff;" id="submitBtn">Save Transictions</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Today's Transactions Table -->
            <div class="card shadow rounded-4">
                <div class="card-body p-4">
                    <h4 class="mb-4 text-primary">Today's Transactions</h4>
                    <div class="table-responsive">
                        <table class="table table-hover" id="todayTransactions">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Details</th>
                                    <th class="text-end">Sale Amount</th>
                                    <th class="text-end">Payment</th>
                                    <th class="text-center">Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($todayTransactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->customer->c_name }}</td>
                                    <td>{{ $transaction->details }}</td>
                                    <td class="text-end">₨ {{ number_format($transaction->sellamount, 2) }}</td>
                                    <td class="text-end">₨ {{ number_format($transaction->paymentamount, 2) }}</td>
                                    <td class="text-center">{{ $transaction->created_at->format('h:i A') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="table-info">
                                    <td colspan="2"><strong>Total</strong></td>
                                    <td class="text-end"><strong>₨ {{ number_format($todayTransactions->sum('sellamount'), 2) }}</strong></td>
                                    <td class="text-end"><strong>₨ {{ number_format($todayTransactions->sum('paymentamount'), 2) }}</strong></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('css')
<style>
/* Form controls styling */
.form-label {
    font-size: 0.9rem;
    margin-bottom: 0.3rem;
}

/* Select2 customization */
.select2-container .select2-selection--single {
    height: 31px;
    border: 1px solid #ced4da;
    border-radius: 0.375rem;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 31px;
    padding-left: 8px;
    font-size: 0.875rem;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 29px;
}

.select2-container--default .select2-results__option {
    font-size: 0.875rem;
    padding: 4px 8px;
}

/* Mobile optimizations */
@media (max-width: 767.98px) {
    .card-body {
        padding: 0.75rem !important;
    }
    .form-control, .form-select {
        font-size: 0.875rem;
    }
    .input-group-text {
        font-size: 0.875rem;
        padding: 0.25rem 0.5rem;
    }
    .table {
        font-size: 0.875rem;
    }
    .table td, .table th {
        padding: 0.5rem;
    }
    .row {
        margin-left: -0.5rem;
        margin-right: -0.5rem;
    }
    .col-6, .col-8, .col-4 {
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }
    .form-label {
        font-size: 0.85rem;
        margin-bottom: 0.2rem;
    }
    .btn-lg {
        padding: 0.5rem 1rem;
        font-size: 1rem;
    }
    .col-md-4 {
        width: 33.33%;
        flex: 0 0 auto;
    }
    #submitBtn {
        font-size: 0.875rem;
        padding: 0.25rem 0.5rem;
        height: 31px;
    }
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize Select2
    $('#customer_id').select2({
        theme: 'bootstrap-5',
        width: '100%',
        placeholder: "Select a customer",
        tags: true,
        createTag: function(params) {
            return {
                id: 'new:' + params.term,
                text: params.term,
                newTag: true
            }
        },
        templateResult: function(data) {
            var $result = $("<span></span>");
            if (data.newTag) {
                $result.append('<i class="fas fa-plus-circle me-2"></i>Create new customer: "' + data.text + '"');
            } else {
                $result.text(data.text);
            }
            return $result;
        }
    });

    // Find the Select2 'select2:select' event handler and replace it with this:

$('#customer_id').on('select2:select', function(e) {
    var data = e.params.data;
    if (data.newTag) {
        // Show confirmation dialog with phone number prompt
        const customerName = data.text;
        let phoneNumber = prompt('Enter 10-digit phone number for ' + customerName + ':');

        // Validate phone number
        if (phoneNumber) {
            // Remove any non-digit characters
            phoneNumber = phoneNumber.replace(/\D/g, '');

            if (phoneNumber.length !== 10) {
                alert('Please enter a valid 10-digit phone number');
                $('#customer_id').val('').trigger('change');
                return;
            }

            // Check if phone number exists
            axios.post('/check-phone', {
                phone: phoneNumber,
                _token: '{{ csrf_token() }}'
            })
            .then(function(response) {
                if (response.data.exists) {
                    alert('This phone number is already registered with another customer!');
                    $('#customer_id').val('').trigger('change');
                    return;
                }

                if (confirm('Do you want to create a new customer?\nName: ' + customerName + '\nPhone: ' + phoneNumber)) {
                    // Create new customer via AJAX
                    axios.post('/custom', {
                        c_name: customerName,
                        phone: phoneNumber,
                        _token: '{{ csrf_token() }}'
                    })
                    .then(function(response) {
                        if (response.data.success) {
                            var newCustomer = response.data.customer;
                            // Create the new option and add it to the select
                            var newOption = new Option(newCustomer.c_name, newCustomer.id, true, true);
                            $('#customer_id')
                                .append(newOption)
                                .val(newCustomer.id)
                                .trigger('change');
                            alert('Customer created successfully!');
                        }
                    })
                    .catch(function(error) {
                        alert('Failed to create new customer. Please try again.');
                        $('#customer_id').val('').trigger('change');
                    });
                } else {
                    $('#customer_id').val('').trigger('change');
                }
            })
            .catch(function(error) {
                alert('Failed to check phone number. Please try again.');
                $('#customer_id').val('').trigger('change');
            });
        } else {
            $('#customer_id').val('').trigger('change');
        }
    }
});

    // // Form submission handling
    // $('#transictionForm').on('submit', function(e) {
    //     e.preventDefault();
    //     const form = e.target;
    //     const submitBtn = document.getElementById('submitBtn');
    //     submitBtn.disabled = true;

    //     axios.post(form.action, new FormData(form))
    //         .then(response => {
    //             location.reload();
    //         })
    //         .catch(error => {
    //             submitBtn.disabled = false;
    //             if (error.response?.data?.errors) {
    //                 let errorHtml = '<div class="alert alert-danger"><ul class="mb-0">';
    //                 Object.values(error.response.data.errors).forEach(errors => {
    //                     errors.forEach(error => errorHtml += `<li>${error}</li>`);
    //                 });
    //                 errorHtml += '</ul></div>';
    //                 form.insertAdjacentHTML('afterbegin', errorHtml);
    //             }
    //         });
    // });

    // Auto-dismiss alerts after 3 seconds
    setTimeout(function() {
        document.querySelectorAll('.alert').forEach(function(alert) {
            if (alert.closest('form')?.id !== 'transictionForm') {
                alert.remove();
            }
        });
    }, 3000);
});
</script>
@endpush
@endsection

