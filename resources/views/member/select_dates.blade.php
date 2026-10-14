@extends('layouts.member_panel') {{-- Tamaru PG Member Master Page --}}

@section('title', 'Select Booking Dates')

@section('content')
    <div class="container mt-4">
        <div class="card shadow border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between">
                <h5 class="mb-0">Select Dates for Room: {{ $allocation->room->RoomNumber }}</h5>
                <span>Capacity: {{ $allocation->room->Capacity }} Beds</span>
            </div>

            <form method="POST" action="{{ route('rooms.payment.preview', $allocation->AllocationID) }}">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Book Date</label>
                            <input type="date" name="book_date" id="book_date" class="form-control"
                                value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Leave Date</label>
                            <input type="date" name="leave_date" id="leave_date" class="form-control" required>
                        </div>
                    </div>

                    <div class="alert alert-info py-2">
                        <small><i class="fas fa-info-circle"></i> Rent will be calculated based on total days between these
                            dates.</small>
                    </div>

                    <button class="btn btn-success w-100 py-2 fw-bold">
                        Continue to Payment Preview
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const bookDateInput = document.getElementById('book_date');
        const leaveDateInput = document.getElementById('leave_date');

        bookDateInput.addEventListener('change', function () {
            leaveDateInput.min = this.value;
        });
    </script>
@endsection