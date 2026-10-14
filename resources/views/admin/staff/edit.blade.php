@extends('admin.master')

@section('title') Edit Staff @endsection

@section('body')

<h2>Edit Staff Record</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="/admin/staff/{{ $staff->StaffID }}/update">
@csrf
@method('PUT')

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="Name" value="{{ $staff->Name }}" class="form-control" required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="Email" value="{{ $staff->Email }}" class="form-control" required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Aadhaar Number</label>
        <input type="text" name="AadharNumber"
               value="{{ $staff->AadharNumber }}"
               class="form-control"
               maxlength="12" minlength="12" pattern="\d{12}" required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">
            Password <small class="text-muted">(Leave blank to keep unchanged)</small>
        </label>
        <input type="password" name="Password" class="form-control">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Phone</label>
        <input type="text" name="Phone"
               value="{{ $staff->Phone }}"
               class="form-control"
               maxlength="10" minlength="10" pattern="\d{10}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Gender</label>
        <select name="Gender" class="form-select" required>
            <option value="M" {{ $staff->Gender == 'M' ? 'selected' : '' }}>Male</option>
            <option value="F" {{ $staff->Gender == 'F' ? 'selected' : '' }}>Female</option>
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Role</label>
        <input type="text" name="Role" value="{{ $staff->Role }}" class="form-control" required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Hire Date</label>
        <input type="date" name="HireDate" value="{{ $staff->HireDate }}" class="form-control">
    </div>
</div>

<button class="btn btn-primary">Update Staff</button>
<a href="/admin/staff" class="btn btn-secondary">Back</a>

</form>
@endsection
