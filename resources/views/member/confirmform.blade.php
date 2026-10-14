<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Summary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-light py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-lg">
                    <div class="card-header bg-dark text-white py-3">
                        <h5 class="mb-0"><i class="fas fa-receipt me-2"></i> Payment Summary & Confirmation</h5>
                    </div>
                    <div class="card-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
                            </div>
                        @endif

                        <div class="row mb-4">
                            <div class="col-sm-6">
                                <h6 class="text-muted text-uppercase small fw-bold">Room Information</h6>
                                <p class="h5">Room No: {{ $allocation->room->RoomNumber }}</p>
                                <p class="mb-0 text-muted">Stay: {{ date('d M Y', strtotime($book_date)) }} -
                                    {{ date('d M Y', strtotime($leave_date)) }}</p>
                                <span class="badge bg-info mt-2">{{ $months }} Months, {{ $extraDays }} Days</span>
                            </div>
                            <div class="col-sm-6 text-sm-end">
                                <h6 class="text-muted text-uppercase small fw-bold">Pricing Model</h6>
                                <p class="mb-1">Monthly: ₹{{ number_format($pricing->MonthlyRent, 0) }}</p>
                                <p class="mb-0">Daily: ₹{{ number_format($pricing->DailyRent, 0) }}</p>
                            </div>
                        </div>

                        <div class="bg-light p-3 rounded-3 mb-4 border">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Total Estimated Rent:</span>
                                <span class="fw-bold">₹{{ number_format($payable_amount, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between text-success mb-2">
                                <span>Amount to Pay Now:</span>
                                <span class="fw-bold">- ₹{{ number_format($amountToPayNow, 2) }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between text-danger">
                                <span class="fw-bold">Remaining Balance:</span>
                                <span class="h5 mb-0">₹{{ number_format($pendingAmount, 2) }}</span>
                            </div>
                        </div>

                        <form action="{{ route('rooms.payment.pay', $allocation->AllocationID) }}" method="POST">
                            @csrf
                            <input type="hidden" name="payable_amount" value="{{ $totalRentValue }}">
                            <input type="hidden" name="amount" value="{{ $amountToPayNow }}">
                            <input type="hidden" name="book_date" value="{{ $book_date }}">
                            <input type="hidden" name="leave_date" value="{{ $leave_date }}">

                            <div class="mb-4">
                                <label class="form-label fw-bold"><i class="fas fa-wallet me-2"></i>Select Payment
                                    Mode</label>
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <input type="radio" class="btn-check" name="payment_mode" id="upi" value="UPI"
                                            required>
                                        <label class="btn btn-outline-primary w-100 py-3" for="upi">UPI / QR
                                            Code</label>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <input type="radio" class="btn-check" name="payment_mode" id="card"
                                            value="Card">
                                        <label class="btn btn-outline-primary w-100 py-3" for="card">Card</label>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg shadow">
                                    Confirm & Pay ₹{{ number_format($amountToPayNow, 2) }}
                                </button>
                                <a href="{{ url()->previous() }}"
                                    class="btn btn-link text-muted text-decoration-none">Cancel & Go Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>