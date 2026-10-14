@extends('layouts.app')

@section('title', 'Contact Us')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/contact_style.css') }}">
@endpush

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mx-5 mt-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="container-fluid mt-4 px-md-5 mb-5" id="contactus_body">
        <div class="card contact-main-card">
            <div class="card-header text-white text-center py-3">
                <h2 class="h4 mb-0">Get In Touch With Us</h2>
                <p class="small mb-0 opacity-75">Reach out online or visit our physical location</p>
            </div>

            <div class="card-body p-0">
                <div class="row g-0">
                    <div class="col-lg-5 p-4 bg-light-custom">
                        <div class="contact-info-grid mb-4">
                            <div class="info-box">
                                <i class="fa-solid fa-envelope text-teal"></i>
                                <div>
                                    <h6>Email</h6>
                                    <p>myhome_pg@gmail.org</p>
                                </div>
                            </div>
                            <div class="info-box">
                                <i class="fa-solid fa-phone-volume text-teal"></i>
                                <div>
                                    <h6>Contact No</h6>
                                    <p>079-845769666</p>
                                </div>
                            </div>
                        </div>

                        <div class="map-container mb-4">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3671.455963579042!2d72.53120157588326!3d23.043759315535316!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e849929555555%3A0xc3f982787e911f48!2sRaju%20Complex!5e0!3m2!1sen!2sin!4v1700000000000"
                                width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        </div>

                        <div class="address-box">
                            <i class="fa-solid fa-map-pin text-danger mb-2"></i>
                            <h6>OFFICE ADDRESS</h6>
                            <p class="mb-0">Raju Complex, Opp.: Janta Ice-cream,<br>Gurukul Road, Memnagar, Ahmedabad -
                                380052</p>
                        </div>
                    </div>

                    <div class="col-lg-7 p-4 p-md-5 form-section">
                        <div class="form-header mb-4">
                            <h3>Drop Your Information</h3>
                            <div class="accent-line"></div>
                        </div>

                        <form action="{{ route('contactus_process') }}" method="post" class="custom-form">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="form-group">
                                        <input type="text" name="name" id="name" class="form-control" placeholder=" "
                                            required>
                                        <label for="name">First Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="form-group">
                                        <input type="text" name="sname" id="sname" class="form-control" placeholder=" "
                                            required>
                                        <label for="sname">Surname</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="form-group">
                                        <input type="tel" name="mobile" id="mobile" class="form-control" placeholder=" "
                                            required>
                                        <label for="mobile">Mobile Number</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="form-group">
                                        <input type="email" name="email" id="email" class="form-control" placeholder=" "
                                            required>
                                        <label for="email">Email Address</label>
                                    </div>
                                </div>
                                <div class="col-12 mb-4">
                                    <div class="form-group">
                                        <textarea name="txtarea" id="txtarea" class="form-control" rows="5" placeholder=" "
                                            required></textarea>
                                        <label for="txtarea">Enter your Inquiry...</label>
                                    </div>
                                </div>
                                <div class="col-12 text-center">
                                    <button type="submit" name="sbt_con" class="btn btn-submit">
                                        <span>Send Message</span>
                                        <i class="fa-solid fa-paper-plane ms-2"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection