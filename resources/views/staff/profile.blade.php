@extends('staff.master')

@section('title', 'My Profile')

@section('page-title', 'My Profile')

@section('body')

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show auto-close" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show auto-close" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show auto-close" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">

        <!-- Profile Info -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="mb-3">Staff Details</h5>

                    <p><strong>Name:</strong> {{ $staff->Name }}</p>
                    <p><strong>Email:</strong> {{ $staff->Email }}</p>
                    <p><strong>Phone:</strong> {{ $staff->Phone ?? 'N/A' }}</p>
                    <p><strong>Role:</strong> {{ $staff->Role }}</p>
                    <p><strong>Hire Date:</strong> {{ $staff->HireDate }}</p>
                </div>
            </div>
        </div>

        <!-- Change Password -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3">Change Password</h5>

                    <form method="POST" action="/staff/profile/password">
                        @csrf

                        <div class="mb-3">
                            <label>Current Password</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>New Password</label>
                            <input type="password" name="new_password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" class="form-control" required>
                        </div>

                        <button class="btn btn-primary w-100">Update Password</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

@endsection