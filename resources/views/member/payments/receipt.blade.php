<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt #{{ $payment->PaymentID }} - My Home PG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .receipt-container {
            max-width: 800px;
            margin: 30px auto;
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .receipt-header {
            border-bottom: 3px solid #0d6efd;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .logo {
            max-height: 70px;
            margin-bottom: 10px;
        }

        .pg-name {
            color: #0d6efd;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .status-badge {
            position: absolute;
            top: 40px;
            right: 40px;
            transform: rotate(15deg);
            opacity: 0.2;
            font-size: 3rem;
            font-weight: bold;
            color: green;
            border: 5px solid green;
            padding: 5px 20px;
            pointer-events: none;
        }

        @media print {
            body { background: none; }
            .receipt-container { box-shadow: none; margin: 0; width: 100%; max-width: 100%; }
            .no-print { display: none; }
            .status-badge { opacity: 0.1; }
        }
    </style>
</head>

<body onload="window.print()">

    <div class="receipt-container">
        <div class="status-badge">PAID</div>

        <div class="receipt-header d-flex justify-content-between align-items-center">
            <div>
                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="logo" onerror="this.src='https://via.placeholder.com/150x50?text=MY+HOME+PG'">
                <h2 class="pg-name m-0">My Home PG</h2>
                <p class="text-muted m-0 small">Comfortable Living, Like Home.</p>
            </div>
            <div class="text-end">
                <h4 class="text-uppercase text-muted">Receipt</h4>
                <p class="mb-0"><strong>ID:</strong> #{{ $payment->PaymentID }}</p>
                <p class="mb-0"><strong>Date:</strong> {{ \Carbon\Carbon::parse($payment->PaymentDate)->format('d M, Y') }}</p>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-6">
                <h6 class="text-primary border-bottom pb-1">Member Details</h6>
                <p class="mb-1"><strong>Name:</strong> {{ session('member_name') }}</p>
                <p class="mb-1"><strong>Room No:</strong> {{ $payment->allocation->room->RoomNumber }}</p>
                <p class="mb-1"><strong>Payment Mode:</strong> {{ $payment->PaymentMode ?? 'Online' }}</p>
            </div>
            <div class="col-6 text-end">
                <h6 class="text-primary border-bottom pb-1">Stay Period</h6>
                <p class="mb-1">{{ \Carbon\Carbon::parse($payment->PeriodStart)->format('d/m/Y') }} to {{ \Carbon\Carbon::parse($payment->PeriodEnd)->format('d/m/Y') }}</p>
                <p class="mb-1 text-muted small">Total Days: {{ \Carbon\Carbon::parse($payment->PeriodStart)->diffInDays($payment->PeriodEnd) }} Days</p>
            </div>
        </div>

        <table class="table table-hover border">
            <thead class="table-primary">
                <tr>
                    <th>Description</th>
                    <th class="text-end" style="width: 150px;">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>Room Rent</strong><br>
                        <small class="text-muted">{{ $payment->PaymentFor }}</small>
                    </td>
                    <td class="text-end">₹{{ number_format($payment->RentAmount, 2) }}</td>
                </tr>
                @if($payment->FineAmount > 0)
                <tr>
                    <td>Fine / Extra Charges</td>
                    <td class="text-end">₹{{ number_format($payment->FineAmount, 2) }}</td>
                </tr>
                @endif
            </tbody>
            <tfoot>
                <tr class="table-light">
                    <td class="text-end fw-bold">Grand Total Paid:</td>
                    <td class="text-end fw-bold text-primary" style="font-size: 1.2rem;">₹{{ number_format($payment->TotalAmount, 2) }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="mt-5 pt-3 border-top">
            <div class="row">
                <div class="col-8">
                    <p class="small text-muted mb-0"><strong>Note:</strong></p>
                    <ul class="small text-muted">
                        <li>This is a computer-generated digital receipt.</li>
                        <li>Fees once paid are non-refundable.</li>
                    </ul>
                </div>
                <div class="col-4 text-center mt-3">
                    <div style="border-bottom: 1px solid #ccc; height: 40px;"></div>
                    <p class="small text-muted">Authorized Signatory</p>
                </div>
            </div>
        </div>

        <div class="text-center mt-4 no-print">
            <hr>
            <button onclick="window.print()" class="btn btn-primary me-2">Print Receipt</button>
            <a href="{{ route('member.my-room') }}" class="btn btn-outline-secondary">Back to Dashboard</a>
        </div>
    </div>

</body>

</html>