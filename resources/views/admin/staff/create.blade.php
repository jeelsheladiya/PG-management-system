@extends('admin.master')

@section('title') Add Staff @endsection

@section('body')

<h3 class="mb-3">Add Staff Member</h3>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="/admin/staff">
@csrf

<div class="row">

    <div class="col-md-6 mb-3">
        <label class="form-label">Full Name</label>
        <input type="text" name="Name" class="form-control" required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="Email" class="form-control" required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Aadhaar Number</label>
        <input type="text" name="AadharNumber" class="form-control"
        maxlength="12" minlength="12" pattern="\d{12}" required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="Password" class="form-control" required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Phone</label>
        <input type="text" name="Phone" 
        maxlength="10" minlength="10" pattern="\d{10}" class="form-control">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Hire Date</label>
        <input type="date" name="HireDate" class="form-control">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Gender</label>
        <select name="Gender" class="form-select" required>
            <option value="">Select</option>
            <option value="M">Male</option>
            <option value="F">Female</option>
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Role</label>
        <select name="Role" class="form-select" required>
            <option value="">Select Role</option>
            <option value="Plumber">Plumber</option>
            <option value="Electrician">Electrician</option>
            <option value="Cleaner">Cleaner</option>
            <option value="Chef">Chef</option>
            <option value="Carpenter">Carpenter</option>
        </select>
    </div>

</div>

<button class="btn btn-primary">Save Staff</button>
<a href="/admin/staff" class="btn btn-secondary">Back</a>

</form>

@endsection
