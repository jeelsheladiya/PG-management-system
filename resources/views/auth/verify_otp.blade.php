@extends('layouts.validation')

@section('title', 'Verify OTP')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card p-4 shadow-sm" style="width: 400px; border-radius: 15px;">
        <div class="card-body text-center">
            <h4 class="mb-3">Email Verification</h4>
            <p class="text-muted">Please enter the 6-digit code sent to your email.</p>
            
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('otp.verify.process') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <input type="text" name="otp" class="form-control form-control-lg text-center" 
                           placeholder="000000" maxlength="6" style="letter-spacing: 10px; font-weight: bold;" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Verify & Register</button>
            </form>
            
            <div class="mt-3">
                <small><a href="{{ route('registration') }}">Back to Registration</a></small>
            </div>
        </div>
    </div>
</div>
@endsection