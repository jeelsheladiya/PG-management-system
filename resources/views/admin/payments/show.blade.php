@extends('admin.master')
@section('title')
Payment Details
@endsection

@section('body')
<div class="container mt-4">
    <h4 class="mb-3">Payment Details</h4>
    
    <div class="card shadow-sm">
        <div class="card-body">
            
            <p><strong>Member Name:</strong> {{ $payment->member->Name ?? 'N/A' }}</p>
            <p><strong>Month:</strong> {{ $payment->Month }}</p>
            <p><strong>Room Rent:</strong> ₹{{ $payment->RentAmount }}</p>
            <p><strong>Fine:</strong> ₹{{ $payment->FineAmount }}</p>
            <p><strong>Total Paid:</strong> ₹{{ $payment->TotalAmount }}</p>
            <p><strong>Payment Date:</strong> {{ $payment->PaymentDate }}</p>
            <p><strong>Payment Mode:</strong> {{ $payment->PaymentMode }}</p>
            <p><strong>Status:</strong> 
            <span class="badge bg-{{ $payment->Status == 'Paid' ? 'success' : 'warning' }}">
                {{ $payment->Status }}
            </span>
        </p>
        
        <a href="/admin/payments" class="btn btn-secondary mt-3">Back</a>
    </div>
</div>
</div>


@endsection