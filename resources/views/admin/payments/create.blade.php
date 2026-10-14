@extends('admin.master')

@section('title') Add Payment @endsection

@section('body')

    <h2 class="mb-4">Add New Payment</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/admin/payments" method="POST">
        @csrf

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Allocation (Member + Room)</label>
                <select name="AllocationID" class="form-select" required>
                    <option value="">-- Select Allocation --</option>
                    @foreach($allocations as $a)
                        <option value="{{ $a->AllocationID }}">
                            {{ $a->member->Name }} — Room {{ $a->room->RoomNumber }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Period Start</label>
                <input type="date" name="PeriodStart" class="form-control" required>
            </div>

            <div class="col-md-3">
                <label class="form-label">Period End</label>
                <input type="date" name="PeriodEnd" class="form-control" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3">
                <label class="form-label">Rent Amount</label>
                <input type="number" step="0.01" name="RentAmount" class="form-control calc">
            </div>

            <div class="col-md-3">
                <label class="form-label">Deposit</label>
                <input type="number" step="0.01" name="DepositAmount" value="0" class="form-control calc">
            </div>

            <div class="col-md-3">
                <label class="form-label">Fine</label>
                <input type="number" step="0.01" name="FineAmount" value="0" class="form-control calc">
            </div>

            <div class="col-md-3">
                <label class="form-label">Total</label>
                <input type="number" step="0.01" id="TotalAmount" class="form-control" readonly>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Payment Mode</label>
                <select name="PaymentMode" class="form-select" required>
                    <option value="Cash">Cash</option>
                    <option value="UPI">UPI</option>
                    <option value="Card">Card</option>
                    <option value="Bank Transfer">Bank Transfer</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Payment Type</label>
                <select name="PaymentFor" class="form-select" required>
                    <option value="Rent">Rent</option>
                    <option value="Deposit">Deposit</option>
                    <option value="Both">Rent + Deposit</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="Status" class="form-select" required>
                    <option value="Paid">Paid</option>
                    <option value="Pending">Pending</option>
                </select>
            </div>
        </div>

        <button class="btn btn-success">Save Payment</button>
        <a href="/admin/payments" class="btn btn-secondary">Cancel</a>

    </form>
    <script>
        document.querySelector('[name="AllocationID"]').addEventListener('change', function () {
            fetch('/admin/get-room-pricing/' + this.value)
                .then(res => res.json())
                .then(data => {
                    if (data.monthly) {
                        document.querySelector('[name="RentAmount"]').value = data.monthly;
                        document.getElementById('TotalAmount').value = data.monthly;
                    }
                });
        });
    </script>

@endsection

@section('scripts')
    <script>
        const periodStart = document.querySelector('[name="PeriodStart"]');
        const periodEnd = document.querySelector('[name="PeriodEnd"]');
        const allocationSelect = document.querySelector('[name="AllocationID"]');
        const rentField = document.querySelector('[name="RentAmount"]');
        const depositField = document.querySelector('[name="DepositAmount"]');
        const fineField = document.querySelector('[name="FineAmount"]');
        const totalField = document.getElementById('TotalAmount');

        let dailyRent = 0;
        let monthlyRent = 0;

        // Fetch pricing when allocation changes
        allocationSelect.addEventListener('change', function () {
            if (!this.value) return;
            fetch('/admin/get-room-pricing/' + this.value)
                .then(res => res.json())
                .then(data => {
                    dailyRent = parseFloat(data.daily) || 0;
                    monthlyRent = parseFloat(data.monthly) || 0;
                    calculateEverything();
                });
        });

        function calculateEverything() {
            if (!periodStart.value || !periodEnd.value || !monthlyRent) return;

            let start = new Date(periodStart.value);
            let end = new Date(periodEnd.value);

            // Calculate days difference
            let diffTime = Math.abs(end - start);
            let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            diffDays = diffDays > 0 ? diffDays : 1;

            // --- Same Logic as Controller ---
            let months = Math.floor(diffDays / 30);
            let extraDays = diffDays % 30;

            let calculatedRent = (months * monthlyRent) + (extraDays * dailyRent);

            rentField.value = calculatedRent.toFixed(2);

            let deposit = parseFloat(depositField.value) || 0;
            let fine = parseFloat(fineField.value) || 0;

            totalField.value = (calculatedRent + deposit + fine).toFixed(2);
        }

        [periodStart, periodEnd, depositField, fineField].forEach(el => {
            el.addEventListener('change', calculateEverything);
            el.addEventListener('input', calculateEverything);
        });
    </script>
@endsection