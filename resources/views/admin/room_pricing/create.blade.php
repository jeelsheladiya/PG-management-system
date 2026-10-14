@extends('admin.master')

@section('title') Add Room Pricing @endsection

@section('body')

    <h2 class="mb-4">Add Room Pricing</h2>

    <form action="{{ route('admin.pricing.store') }}" method="POST">
        @csrf

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Room Capacity (Beds)</label>
                <select name="Capacity" class="form-control" required>
                    <option value="">-- Select Capacity --</option>
                    @foreach($capacities as $room)
                        <option value="{{ $room->Capacity }}">
                            {{ $room->Capacity }} {{ $room->Capacity == 1 ? 'Bed' : 'Beds' }}
                        </option>
                    @endforeach
                </select>   
            </div>

            <div class="col-md-6">
                <label class="form-label">Effective From</label>
                <input type="date" name="EffectiveFrom" class="form-control" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Monthly Rent</label>
                <input type="number" step="0.01" name="MonthlyRent" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Daily Rent</label>
                <input type="number" step="0.01" name="DailyRent" class="form-control" required>
            </div>
        </div>

        <button class="btn btn-success" type="submit">Save Pricing</button>

        <a href="/admin/pricing" class="btn btn-secondary">Cancel</a>

    </form>

@endsection