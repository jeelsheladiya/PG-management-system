@extends('layouts.member_panel') {{-- Layout badli nakhyu --}}

@section('content')
    <div class="container mt-4">
        <div class="card shadow border-0">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Payment Preview & Confirm</h5>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-7">
                        <table class="table table-borderless">
                            <tr>
                                <td class="text-muted">Room Number:</td>
                                <th class="fs-5">{{ $allocation->room->RoomNumber }}</th>
                            </tr>
                            <tr>
                                <td class="text-muted">Duration:</td>
                                <th>{{ date('d-M-Y', strtotime($book_date)) }} to
                                    {{ date('d-M-Y', strtotime($leave_date)) }}</th>
                            </tr>
                            <tr>
                                <td class="text-muted">Total Stay:</td>
                                <th><span class="badge bg-primary">{{ $days }} Days</span></th>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-5 text-md-end border-start">
                        <p class="mb-1 text-muted">Daily Rent: ₹{{ number_format($pricing->DailyRent, 2) }}</p>
                        <small class="text-muted">Calculation: {{ $days }} days × ₹{{ $pricing->DailyRent }}</small>
                        <h2 class="text-success mt-2">Total: ₹{{ number_format($rentAmount, 2) }}</h2>
                    </div>
                </div>

                <hr>

                <form action="{{ route('rooms.payment.pay', $allocation->AllocationID) }}" method="POST">
                    @csrf
                    <input type="hidden" name="book_date" value="{{ $book_date }}">
                    <input type="hidden" name="leave_date" value="{{ $leave_date }}">
                    <input type="hidden" name="total_amount" value="{{ $rentAmount }}">

                    <div class="mb-4">
                        <label class="form-label fw-bold">Select Payment Mode</label>
                        <div class="row g-2">
                            <div class="col-md-4">
                                <input type="radio" class="btn-check" name="payment_mode" id="upi" value="UPI" required>
                                <label class="btn btn-outline-primary w-100" for="upi">UPI / QR</label>
                            </div>
                            <!-- <div class="col-md-4">
                                <input type="radio" class="btn-check" name="payment_mode" id="cash" value="Cash">
                                <label class="btn btn-outline-primary w-100" for="cash">Cash</label>
                            </div> -->
                            <div class="col-md-4">
                                <input type="radio" class="btn-check" name="payment_mode" id="card" value="Card">
                                <label class="btn btn-outline-primary w-100" for="card">Card</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ url()->previous() }}" class="btn btn-light px-4">Back</a>
                        <button type="submit" class="btn btn-success btn-lg px-5 shadow">Confirm & Pay Now</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection