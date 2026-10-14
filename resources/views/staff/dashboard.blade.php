
@extends('staff.master')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('body')

<div class="row g-4">

    <!-- Pending Work Card -->
    <div class="col-md-6">
        <div class="card shadow-sm border-0 bg-warning">
            <div class="card-body text-center">
                <i class="bi bi-list-check display-5"></i>
                <h5 class="mt-2">Pending Work Tasks</h5>
                <h2 class="fw-bold">{{ $pendingWorks }}</h2>
                <a href="/staff/work" class="btn btn-dark btn-sm mt-2">
                    View Tasks
                </a>
            </div>
        </div>
    </div>

    <!-- Assigned Complaints Card -->
    <div class="col-md-6">
        <div class="card shadow-sm border-0 bg-danger text-white">
            <div class="card-body text-center">
                <i class="bi bi-exclamation-circle display-5"></i>
                <h5 class="mt-2">Open Complaints</h5>
                <h2 class="fw-bold">{{ $assignedComplaints }}</h2>
                <a href="/staff/complaints" class="btn btn-light btn-sm mt-2">
                    View Complaints
                </a>
            </div>
        </div>
    </div>

</div>

<hr class="my-4">

<div class="card shadow-sm border-0">
    <div class="card-body">
        <h5>Quick Summary</h5>
        <p class="text-muted mb-0">
            Here you can manage your assigned work tasks and resolve member complaints.
            Keep your dashboard clear by completing tasks on time 👍
        </p>
    </div>
</div>

@endsection
