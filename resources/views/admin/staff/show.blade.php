@extends('admin.master')

@section('title') Staff Details @endsection

@section('body')

<h2 class="mb-4">Staff Profile</h2>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-4 fw-bold">Full Name:</div>
            <div class="col-md-8">{{ $staff->Name }}</div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4 fw-bold">Email:</div>
            <div class="col-md-8">{{ $staff->Email }}</div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4 fw-bold">Phone:</div>
            <div class="col-md-8">{{ $staff->Phone ?? '—' }}</div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4 fw-bold">Gender:</div>
            <div class="col-md-8">
                {{ $staff->Gender == 'M' ? 'Male' : 'Female' }}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4 fw-bold">Role:</div>
            <div class="col-md-8">
                <span class="badge bg-info text-dark">{{ $staff->Role }}</span>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4 fw-bold">Aadhaar Number:</div>
            <div class="col-md-8">{{ $staff->AadharNumber }}</div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4 fw-bold">Hire Date:</div>
            <div class="col-md-8">{{ $staff->HireDate ?? '—' }}</div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="/admin/staff/{{ $staff->StaffID }}/edit" class="btn btn-warning">Edit</a>
    <a href="/admin/staff" class="btn btn-secondary">Back</a>
</div>

@endsection
