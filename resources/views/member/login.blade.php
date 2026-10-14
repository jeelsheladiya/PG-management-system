@extends('layouts.validation')

@section('title', 'Member Login')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/login_style.css') }}">
@endpush

@section('content')
    <div class="container my-4">

        <div class="container-fluid d-flex justify-content-center align-items-center login_form mb-2">
            <div class="login-container">
                <h2>🏠 Member Login</h2>
                <h6>Login Your Account</h6>

                {{-- Session Error Messages --}}
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show auto-close">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                {{-- Action pehli file no: /member/login --}}
                <form action="/member/login" method="POST">
                    @csrf
                    <!-- Aa line thi URL no room_id controller ne malse -->
                    <input type="hidden" name="room_id" value="{{ request()->get('room_id') }}">
                    <div class="input_container">
                        <div class="inp">
                            {{-- Name pehli file nu: phone --}}
                            <input type="text" name="phone" required placeholder=" " value="{{ old('phone') }}">
                            <label>Phone Number</label>
                        </div>

                        <div class="inp">
                            {{-- Name pehli file nu: password --}}
                            <input type="password" name="password" required placeholder=" ">
                            <label>Password</label>
                        </div>
                    </div>

                    <div class="row ms-2 mt-2">
                        <div class="col-sm-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
                                <label class="form-check-label" for="rememberMe">
                                    Remember Me
                                </label>
                            </div>
                        </div>

                        <div class="col-sm-6 text-end">
                            <a href="#" class="right text-muted">Forgot password</a>
                        </div>
                    </div>

                    <div class="login-button mt-3">
                        <input type="submit" value="Login" class="btn btn-primary w-100">
                    </div>

                    <p class="signup-login text-center mt-3">
                        Don't have Account?
                        <a href="{{ route('registration') }}">Signup</a>
                    </p>
                </form>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        // Error ne 4 second pachi auto-hide karva mate
        setTimeout(() => {
            document.querySelectorAll('.auto-close').forEach(el => {
                if (bootstrap.Alert.getOrCreateInstance(el)) {
                    bootstrap.Alert.getOrCreateInstance(el).close();
                }
            });
        }, 4000);
    </script>
@endpush