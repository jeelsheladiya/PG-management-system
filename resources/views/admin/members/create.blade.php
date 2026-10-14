@extends('admin.master')

@section('title') Add Member @endsection

@section('body')

<h3 class="mb-3">Add PG Member</h3>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="/admin/members">
@csrf

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="Name" class="form-control" required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="Email" class="form-control" required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Aadhaar Number</label>
        <input type="text" name="AdhaarNumber" class="form-control" required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="Password" class="form-control" required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Phone</label>
        <input type="text" name="Phone" class="form-control">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Parent Mobile</label>
        <input type="text" name="ParentsMobile" class="form-control">
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Course</label>
        <input type="text" name="Course" class="form-control" required>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">DOB</label>
        <input type="date" name="DOB" class="form-control" required>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Gender</label>
        <select name="Gender" class="form-select" required>
            <option value="">Select</option>
            <option value="M">Male</option>
            <option value="F">Female</option>
        </select>
    </div>

    <div class="col-md-8 mb-3">
        <label class="form-label">Address</label>
        <textarea name="Address" class="form-control" rows="2" required></textarea>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Pincode</label>
        <input type="text" name="Pincode" class="form-control" required>
    </div>
</div>

<button class="btn btn-primary">Save Member</button>
<a href="/admin/members" class="btn btn-secondary">Back</a>

</form>

@endsection
