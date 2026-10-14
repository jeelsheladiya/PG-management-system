@extends('member.master')

@section('title', 'Select Dates')
@section('page-title', 'Booking Duration')

@section('body')

    @if ($errors->any())
        <div class="alert alert-danger mt-2">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container mt-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5>Select Booking Dates</h5>
                </div>

                <form method="POST" action="{{ route('rooms.payment.preview', $allocation->AllocationID) }}">
                    @csrf

                    <div class="card-body">

                        <div class="mb-3">
                            <label>Book Date</label>
                            <input type="date" name="book_date" id="book_date" class="form-control" value="{{ date('Y-m-d') }}"
                                required>
                        </div>

                        <div class="mb-3">
                            <label>Leave Date</label>
                            <input type="date" name="leave_date" id="leave_date" class="form-control" required>
                        </div>

                        <button class="btn btn-success w-100">
                            Continue to Payment
                        </button>

                    </div>
                </form>
            </div>
        </div>


    <script>
        // Jyaare Book Date badlay, tyaare Leave Date ni minimum limit pan badlay
        const bookDateInput = document.getElementById('book_date');
        const leaveDateInput = document.getElementById('leave_date');

        bookDateInput.addEventListener('change', function () {
            leaveDateInput.min = this.value; // Leave date, book date thi nani nahi thai shake
        });
    </script>
@endsection