@extends('layouts.app')
@section('title')
    About Us
@endsection
@push('styles')
    <link rel="stylesheet" href="{{asset('css/about.css')}}">
@endpush

@section('content')

    <div class="container-fluid about_section mt-2">

        <div class="container-fluid card mb-3 mt-1 px-0" style="max-width: 100%;">
            <div class="card-header-about text-center border-0">
                <h1 class="fw-bold text-uppercase"><i class="fa-solid fa-house-chimney-user me-2"></i>My Home PG</h1>
                <p class="mb-0 fst-italic" style="font-size: 1.1rem;">Comfort • Care • Convenience</p>
            </div>

            <div class="card-body text-center sub-card">
                <h3 class="card-title">
                    <img src="{{ asset('photos/cropped_circle_image (3).png') }}" alt="">
                    Introduction
                    <!-- <img src="photos/cropped_circle_image (3).png" alt=""> -->
                </h3>

                <h5>
                    “The PG Management System is a software solution developed to manage all activities of a Paying Guest
                    accommodation. It helps the owner maintain records of Pg members, room availability, payments,
                    amenities, and services in a structured and user-friendly manner. The system reduces manual work and
                    improves the overall management process.”
                </h5>
            </div>

            <div class="card-body sub-card">
                <h3 class="card-title">
                    <img src="{{ asset('photos/vision.png') }}" alt="" srcset="">
                    Vision
                    <!-- <img src="photos/vision.png" alt="" srcset=""> -->
                </h3>
                <h5><i class="fa-solid fa-hand-point-right"></i>
                    We provide safe, comfortable, and affordable accommodation for students and working
                    professionals. <i class="fa-duotone fa-regular fa-handshake"></i></h5>
                <h5><i class="fa-solid fa-hand-point-right"></i>Our goal is to create a friendly and homely environment
                    where residents can focus on their studies or work without any worries.
                    <img src="photos/r3.png" alt="">
                </h5>
            </div>

            <div class="card-body sub-card" id="ameni">
                <h3 class="card-title">
                    <!-- <img src="photos/choice.jpg"> -->
                    Why To Choose Us
                    <img src="{{ asset('photos/choice.jpg') }}">
                </h3>

                <div class="container-fluid d-flex justify-content-center align-items-center mt-4">
                    <div class="row">
                        <div class="col-lg-4 col-sm-6 col-12 choice-card">
                            <div class="card text-bg-primary mb-3" style="max-width: 18rem;">
                                <div class="card-header">
                                    <i class="fa-solid fa-location-dot"></i>
                                    Pg Area
                                    <!-- <i class="fa-solid fa-location-dot"></i> -->
                                </div>
                                <div class="card-body">
                                    <p class="card-text">
                                        Our Pg is located in one of most demanding area of Ahmedabad.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12 choice-card">
                            <div class="card text-bg-primary mb-3" style="max-width: 18rem;">
                                <div class="card-header">
                                    <i class="fa-sharp fa-solid fa-person-walking"></i>
                                    Walking Distance
                                    <!-- <i class="fa-sharp fa-solid fa-person-walking"></i> -->
                                </div>
                                <div class="card-body">
                                    <p class="card-text">Our Pg located at placed where most of Colleges and offices Are
                                        walking distance Or 5/10 minutes bike ride only.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12 choice-card">
                            <div class="card text-bg-primary mb-3" style="max-width: 18rem;">
                                <div class="card-header">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                        width="24px" fill="#FFFFFF">
                                        <path
                                            d="M480-28 346-160H160v-186L28-480l132-134v-186h186l134-132 134 132h186v186l132 134-132 134v186H614L480-28Zm0-112 80-80v-148q-26-15-43-50.5T500-500q0-58 26-99t64-41q37 0 63.5 41t26.5 99q0 47-17 82.5T620-368v128h100v-140l100-100-100-100v-140H580L480-820 380-720H240v140L140-480l100 100v140h100v-160q-26-6-43-27.5T280-477v-163h40v151h30v-151h40v151h30v-151h40v163q0 28-17 49.5T400-400v180l80 80Zm0-340Z" />
                                    </svg>
                                    Hygienic Meal
                                </div>
                                <div class="card-body">
                                    <p class="card-text">We provide members to Hygienic food with butter milk daily.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12 choice-card">
                            <div class="card text-bg-primary mb-3" style="max-width: 18rem;">
                                <div class="card-header">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                        width="24px" fill="#FFFFFF">
                                        <path
                                            d="M160-80q-50 0-85-35t-35-85q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35Zm0-80q17 0 28.5-11.5T200-200q0-17-11.5-28.5T160-240q-17 0-28.5 11.5T120-200q0 17 11.5 28.5T160-160Zm160 80q14-18 22.5-37.5T356-160h84v-280q0-33-23.5-56.5T360-520H160v120q-21 0-41.5 4T80-384v-216h120v-136q0-77 53.5-130.5T384-920q56 0 102 30.5t68 81.5l273 648h93v80H640v-80h100L481-776q-12-29-38.5-46.5T384-840q-44 0-74 30t-30 74v136h80q66 0 113 47t47 113v360H320Zm-20-260Z" />
                                    </svg>
                                    Cleaning
                                    <!-- <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF">
                                            <path d="M160-80q-50 0-85-35t-35-85q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35Zm0-80q17 0 28.5-11.5T200-200q0-17-11.5-28.5T160-240q-17 0-28.5 11.5T120-200q0 17 11.5 28.5T160-160Zm160 80q14-18 22.5-37.5T356-160h84v-280q0-33-23.5-56.5T360-520H160v120q-21 0-41.5 4T80-384v-216h120v-136q0-77 53.5-130.5T384-920q56 0 102 30.5t68 81.5l273 648h93v80H640v-80h100L481-776q-12-29-38.5-46.5T384-840q-44 0-74 30t-30 74v136h80q66 0 113 47t47 113v360H320Zm-20-260Z" />
                                        </svg> -->
                                </div>
                                <div class="card-body">
                                    <p class="card-text">We make clean rooms, bathroom everyday.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12 choice-card">
                            <div class="card text-bg-primary mb-3" style="max-width: 18rem;">
                                <div class="card-header">
                                    <!-- <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/ingredients.png" alt="ingredients"/> -->
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                        width="24px" fill="#FFFFFF">
                                        <path
                                            d="m480-560-56-56 63-64H320v-80h167l-64-64 57-56 160 160-160 160ZM280-80q-33 0-56.5-23.5T200-160q0-33 23.5-56.5T280-240q33 0 56.5 23.5T360-160q0 33-23.5 56.5T280-80Zm400 0q-33 0-56.5-23.5T600-160q0-33 23.5-56.5T680-240q33 0 56.5 23.5T760-160q0 33-23.5 56.5T680-80ZM40-800v-80h131l170 360h280l156-280h91L692-482q-11 20-29.5 31T622-440H324l-44 80h480v80H280q-45 0-68.5-39t-1.5-79l54-98-144-304H40Z" />
                                    </svg>
                                    Grocery
                                    <!-- <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF">
                                            <path d="m480-560-56-56 63-64H320v-80h167l-64-64 57-56 160 160-160 160ZM280-80q-33 0-56.5-23.5T200-160q0-33 23.5-56.5T280-240q33 0 56.5 23.5T360-160q0 33-23.5 56.5T280-80Zm400 0q-33 0-56.5-23.5T600-160q0-33 23.5-56.5T680-240q33 0 56.5 23.5T760-160q0 33-23.5 56.5T680-80ZM40-800v-80h131l170 360h280l156-280h91L692-482q-11 20-29.5 31T622-440H324l-44 80h480v80H280q-45 0-68.5-39t-1.5-79l54-98-144-304H40Z" />
                                        </svg> -->
                                </div>
                                <div class="card-body">
                                    <p class="card-text">Our Pg surrouding with groceries shop you can buy anything anytime.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12 choice-card">
                            <div class="card text-bg-primary mb-3" style="max-width: 18rem;">
                                <div class="card-header">
                                    <i class="fa-sharp-duotone fa-solid fa-hospital"></i>
                                    Hospital
                                    <!-- <i class="fa-sharp-duotone fa-solid fa-hospital"></i> -->
                                </div>
                                <div class="card-body">
                                    <p class="card-text">Pg surrounded with private and government Hospital so which make
                                        easy your medical emergency.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <ul> -->
                <!-- <h5><i class="fa-solid fa-hand-point-right"></i>Fully furnished rooms with modern amenities</h5>
                    <h5><i class="fa-solid fa-hand-point-right"></i>Nutritious meals served daily</h5>
                    <h5><i class="fa-solid fa-hand-point-right"></i>High-speed Wi-Fi and study-friendly spaces</h5>
                    <h5><i class="fa-solid fa-hand-point-right"></i>24/7 security for your safety</h5>
                    <h5><i class="fa-solid fa-hand-point-right"></i>Hygienic and clean environment</h5>
                    <h5><i class="fa-solid fa-hand-point-right"></i>24/7 Hot water Geysers and Ectricity</h5> -->
                <!-- </ul> -->
            </div>

            <div class="card-body sub-card">
                <h3 class="card-title">
                    <img src="{{ asset('photos/expe.png') }}" alt="">
                    Experience
                    <!-- <img src="photos/expe.png" alt=""> -->
                </h3>
                <!-- <ul> -->
                <h5><i class="fa-solid fa-hand-point-right"></i>We are running PG since 10 year.</h5>
                <h5><i class="fa-solid fa-hand-point-right"></i>We have Experience about how to satisfy members and sortout
                    their problem.</h5>
                <h5><i class="fa-solid fa-hand-point-right"></i>We have well experience staff for cook, cleaning, electric
                    work etc.</h5>
                <h5><i class="fa-solid fa-hand-point-right"></i>Any complain about PG you can complain online OR physical to
                    PG owner.</h5>
                <h5><i class="fa-solid fa-hand-point-right"></i>We ansure you that We will sort out your problem in 24 hour.
                </h5>
                <!-- </ul> -->
            </div>
        </div>

    </div>
@endsection