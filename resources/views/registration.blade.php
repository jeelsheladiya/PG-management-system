@extends('layouts.validation')

@section('title')
    Registration
@endsection

@push('styles')
    <link rel="stylesheet" href="{{asset('css/reg_style.css')}}">
@endpush

@section('content')
    <div class="container-fluid d-flex justify-content-center" id="reg-form-main-container">
        <div class="card text-center d-flex justify-content-center" id="reg-card">
            <div class="card-header">
                Fill Details To Connect With Us
            </div>
            <form action="{{ route('registration.process') }}" method="post">
                @csrf

                <div class="card-body">

                    <div class="container-fluid w-100 justify-content-center">
                        <span id="custom">
                            <div class="row custom-grid">
                                <div class="col-12 form_floating">
                                    <input type="text" class="form-control my-input" id="fname" name="fname"
                                        aria-describedby="emailHelp" value="{{ old('fname') }}" required>
                                    <label for="fname">Full Name..</label>
                                </div>
                            </div>

                            <div class="row custom-grid">
                                <div class="col form_floating">
                                    <input type="password" class="form-control my-input" id="pass" name="password"
                                        aria-describedby="emailHelp" required>
                                    <label for="pass">Password..</label>
                                    @error('password')
                                        <small class="text-warning fw-bold">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col form_floating">
                                    <input type="password" class="form-control my-input" name="password_confirmation"
                                        id="cpass" placeholder=" " required>
                                    <label for="password_confirmation">Confirm Password..</label>
                                    @error('password_confirmation')
                                        <small class="text-warning fw-bold">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row contact-details">
                                <div class="col-sm-6 mob-em">
                                    <input type="text" class="form-control" name="mobile" value="{{ old('mobile') }}"
                                        id="mob" placeholder="" required>
                                    <label for="mobile">Mobile..</label>
                                    @error('mobile')
                                        <small class="text-warning fw-bold">{{ $message }} Only</small>
                                    @enderror
                                </div>
                                <div class="col-sm-6 mob-em">
                                    <input type="email" class="form-control" name="mail" value="{{ old('mail') }}" id="mail"
                                        placeholder="" required>
                                    <label for="mail">Email..</label>
                                    @error('mail')
                                        <small class="text-warning fw-bold">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </span>

                        <div class="col-12 d-flex justify-content-center mt-2">
                            <button class="btn btn-primary" type="submit" id="sbt-btn" name="reg-submit">Sign Up</button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection