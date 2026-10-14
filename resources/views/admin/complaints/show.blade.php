@extends('admin.master')

@section('title') Complaint Details @endsection

@section('body')

<h3>Complaint Details</h3>

<div class="card">
    <div class="card-body">
        <p><strong>Member:</strong> {{ $complaint->member->Name }}</p>
        <p><strong>Staff:</strong> {{ $complaint->staff->Name ?? 'Not Assigned' }}</p>
        <p><strong>Status:</strong> {{ $complaint->Status }}</p>
        <p><strong>Date Raised:</strong> {{ $complaint->DateRaised }}</p>
        <p><strong>Description:</strong></p>
        <div class="border p-2 bg-light">
            {{ $complaint->ComplainText }}
        </div>
    </div>
</div>

<a href="/admin/complaints" class="btn btn-secondary mt-3">Back</a>

@endsection
