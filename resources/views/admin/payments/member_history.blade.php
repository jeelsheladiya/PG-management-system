@extends('admin.master')

@section('title') Member Payment History @endsection

@section('body')

<h3 class="mb-3">{{ $member->Name }} - Payment History</h3>

<div class="row mb-3">
    <div class="col-md-4">
        <div class="card shadow-sm p-3">
            <strong>Phone:</strong> {{ $member->Phone }} <br>
            <strong>Course:</strong> {{ $member->Course }} <br>
            <strong>Current Room:</strong>
            {{ $member->activeAllocation->room->RoomNumber ?? 'Not Allotted' }}
        </div>
    </div>

    <div class="col-md-4">
        <div class="alert alert-success text-center">
            <h5>Total Paid</h5>
            <h4>₹{{ $totalPaid }}</h4>
        </div>
    </div>

    <div class="col-md-4">
        <div class="alert alert-danger text-center">
            <h5>Total Pending</h5>
            <h4>₹{{ $totalPending }}</h4>
        </div>
    </div>
</div>

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Month</th>
            <th>Room</th>
            <th>Rent</th>
            <th>Fine</th>
            <th>Total</th>
            <th>Date</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($payments as $p)
        <tr>
            <td>{{ $p->Month }}</td>
            <td>{{ $member->activeAllocation->room->RoomNumber ?? '—' }}</td>
            <td>₹{{ $p->RentAmount }}</td>
            <td>₹{{ $p->FineAmount }}</td>
            <td><strong>₹{{ $p->TotalAmount }}</strong></td>
            <td>{{ $p->PaymentDate }}</td>
            <td>
                <span class="badge {{ $p->Status == 'Paid' ? 'bg-success' : 'bg-warning' }}">
                    {{ $p->Status }}
                </span>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<a href="/admin/payments" class="btn btn-secondary mt-3">← Back to Payments</a>

@endsection
