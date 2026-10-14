<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Independent Payment Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light py-5">
    <div class="container">
        <div class="card shadow border-0 col-md-8 mx-auto">
            <div class="card-header bg-dark text-white">Confirm Payment</div>
            <div class="card-body">
                <h5>Room: {{ $allocation->room->RoomNumber }}</h5>
                <hr>
                <p>Total Rent: <b>₹{{ number_format($totalRentValue, 2) }}</b></p>
                <p>Paying Now: <b class="text-success">₹{{ number_format($amountToPayNow, 2) }}</b></p>

                <form action="{{ route('custom.payment.store', $allocation->AllocationID) }}" method="POST">
                    @csrf
                    <input type="hidden" name="payable_amount" value="{{ $totalRentValue }}">
                    <input type="hidden" name="amount" value="{{ $amountToPayNow }}">
                    <input type="hidden" name="book_date" value="{{ $book_date }}">
                    <input type="hidden" name="leave_date" value="{{ $leave_date }}">

                    <label class="fw-bold">Payment Mode:</label>
                    <select name="payment_mode" class="form-select mb-3" required>
                        <!-- <option value="Cash">Cash</option> -->
                        <option value="UPI">UPI</option>
                        <option value="Card">Card</option>
                    </select>

                    <button type="submit" class="btn btn-primary w-100">Final Confirm & Save</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>