@extends('admin.master')

@section('title') Room Pricing @endsection

@section('body')

<div class="d-flex justify-content-between mb-3">
    <h2>Room Pricing</h2>
    <a href="/admin/room-pricing/create" class="btn btn-success">
        + Add Pricing
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>Capacity</th>
            <th>Monthly Rent</th>
            <th>Daily Rent</th>
            <th>Effective From</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pricings as $p)
            <tr>
                <td>{{ $p->Capacity }}</td>
                <td>₹{{ number_format($p->MonthlyRent) }}</td>
                <td>₹{{ number_format($p->DailyRent) }}</td>
                <td>{{ $p->EffectiveFrom }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection
