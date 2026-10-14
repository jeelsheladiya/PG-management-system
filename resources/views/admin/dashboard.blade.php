@extends('admin.master')

@section('title') Dashboard @endsection

@section('body')

<h3 class="mb-1">Dashboard</h3>
<p class="text-muted">Welcome {{ $admin->Name ?? 'Admin' }}</p>

<hr>

<div class="row g-4">

    <!-- Total Rooms -->
    <div class="col-md-4">
        <div class="card shadow-sm border-0 text-bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <span>Total Rooms</span>
                    <i class="bi bi-building fs-3 opacity-75"></i>
                </div>
                <h2 class="fw-bold mt-2">{{ $totalRooms }}</h2>
            </div>
        </div>
    </div>

    <!-- Total Members -->
    <div class="col-md-4">
        <div class="card shadow-sm border-0 text-bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <span>Total Members</span>
                    <i class="bi bi-people fs-3 opacity-75"></i>
                </div>
                <h2 class="fw-bold mt-2">{{ $totalMembers }}</h2>
            </div>
        </div>
    </div>

    <!-- Total Capacity -->
    <div class="col-md-4">
        <div class="card shadow-sm border-0 text-bg-dark">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <span>Total Bed Capacity</span>
                    <i class="bi bi-grid-3x3-gap fs-3 opacity-75"></i>
                </div>
                <h2 class="fw-bold mt-2">{{ $totalCapacity }}</h2>
            </div>
        </div>
    </div>

    <!-- Occupied Beds -->
    <div class="col-md-6">
        <div class="card shadow-sm border-0 text-bg-danger">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <span>Occupied Beds</span>
                    <i class="bi bi-person-fill-check fs-3 opacity-75"></i>
                </div>
                <h2 class="fw-bold mt-2">{{ $occupiedBeds }}</h2>
            </div>
        </div>
    </div>

    <!-- Vacant Beds -->
    <div class="col-md-6">
        <div class="card shadow-sm border-0 text-bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <span>Vacant Beds</span>
                    <i class="bi bi-door-open fs-3 opacity-75"></i>
                </div>
                <h2 class="fw-bold mt-2">{{ $vacantBeds }}</h2>
            </div>
        </div>
    </div>

</div>

@endsection
