@extends('admin.master')
@section('body')
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5>Payment Confirmation</h5>
        </div>
        <div class="card-body">
            <h6>Member: {{ $allocation->member->Name }}</h6>
            <h6>Room: {{ $allocation->room->RoomNumber }}</h6>
            <hr>
            <p>Period: <b>{{ $book_date }}</b> to <b>{{ $leave_date }}</b> ({{ $totalDays }} Days)</p>
            <h4 class="text-success">Calculated Rent: ₹{{ number_format($rentAmount, 2) }}</h4>

            <form method="POST" action="{{ route('admin.payments.store_final') }}">
                @csrf
                <input type="hidden" name="AllocationID" value="{{ $allocation->AllocationID }}">
                <input type="hidden" name="PeriodStart" value="{{ $book_date }}">
                <input type="hidden" name="PeriodEnd" value="{{ $leave_date }}">
                <input type="hidden" name="RentAmount" value="{{ $rentAmount }}">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Payment Mode</label>
                        <select name="PaymentMode" class="form-select" required>
                            <option value="Cash">Cash</option>
                            <option value="UPI">UPI</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Deposit (if any)</label>
                        <input type="number" name="DepositAmount" value="0" class="form-control">
                    </div>
                </div>

                <button class="btn btn-success w-100">Confirm Payment & Activate Room</button>
            </form>
        </div>
    </div>
@endsection