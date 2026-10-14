
@extends('admin.master')

@section('title')
Edit Payment
@endsection

@section('body')
<div class="container mt-4">
    <h4 class="mb-3">Edit Payment</h4>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.payments.update', $payment->PaymentID) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Member</label>
                    <select name="MemberID" class="form-control" required>
                        @foreach($members as $member)
                            <option value="{{ $member->MemberID }}"
                                {{ $payment->MemberID == $member->MemberID ? 'selected' : '' }}>
                                {{ $member->Name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Month</label>
                    <input type="text" name="Month" class="form-control" value="{{ $payment->Month }}" required>
                </div>

                <div class="mb-3">
                    <label>Rent Amount</label>
                    <input type="number" step="0.01" name="RentAmount" class="form-control" value="{{ $payment->RentAmount }}" required>
                </div>

                <div class="mb-3">
                    <label>Fine Amount</label>
                    <input type="number" step="0.01" name="FineAmount" class="form-control" value="{{ $payment->FineAmount }}">
                </div>

                <div class="mb-3">
                    <label>Payment Mode</label>
                    <select name="PaymentMode" class="form-control">
                        <option {{ $payment->PaymentMode=='Cash'?'selected':'' }}>Cash</option>
                        <option {{ $payment->PaymentMode=='UPI'?'selected':'' }}>UPI</option>
                        <option {{ $payment->PaymentMode=='Bank Transfer'?'selected':'' }}>Bank Transfer</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select name="Status" class="form-control">
                        <option value="Paid" {{ $payment->Status=='Paid'?'selected':'' }}>Paid</option>
                        <option value="Pending" {{ $payment->Status=='Pending'?'selected':'' }}>Pending</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Update Payment</button>
                <a href="/admin/payments" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
