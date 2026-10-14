@extends('layouts.app')

@section('title')
    MY HOME PG
@endsection
@section('content')
    <section class="">

        <div id="carouselExampleCaptions" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 4"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{asset('photos/1st.jpg')}}" class="d-block w-100 img" alt="...">
                    <div class="carousel-caption d-none d-sm-block">
                        <h5 style="color:white; font-weight:bold;" class="carousel-intro typed-text"></h5>
                        <div class="hero-box">
                            <h1>Fully Furnished PG in Ahmedabad</h1>
                            <p>Safe • Affordable • Convenience</p>

                            <div class="hero-buttons">
                                <a href="{{route('rooms')}}" class="btn btn-warning">View Rooms</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="https://t3.ftcdn.net/jpg/09/14/86/02/360_F_914860213_VnHqUj18TS00T1WJQFFD2WK0qlcD66YE.jpg" class="d-block w-100 img" alt="...">
                    <div class="carousel-caption d-none d-sm-block">
                        <!-- <span class="typed-text"></span> -->
                        <h5 style="font-weight:bold;" class="carousel-intro typed-text"></h5>
                        <div class="hero-box">
                            <h1>Fully Furnished PG in Ahmedabad</h1>
                            <p>Safe • Affordable • Convenience</p>

                            <div class="hero-buttons">
                                <a href="{{route('rooms')}}" class="btn btn-warning">View Rooms</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="carousel-item">
                    <img src="https://wallpapers.com/images/featured/ahmedabad-ho7g03dxouzh0ulo.jpg"
                        class="d-block w-100 img" alt="...">
                    <div class="carousel-caption d-none d-sm-block">
                        <!-- <span class="typed-text"></span> -->
                        <h5 style="font-weight:bold;" class="carousel-intro typed-text"></h5>
                        <div class="hero-box">
                            <h1>Fully Furnished PG in Ahmedabad</h1>
                            <p>Safe • Affordable • Convenience</p>

                            <div class="hero-buttons">
                                <a href="{{route('rooms')}}" class="btn btn-warning">View Rooms</a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div class="carousel-item">
                    <img src="{{asset('')}}"
                        class="d-block w-100 img" alt="...">
                    <div class="carousel-caption d-none d-sm-block">
                        <!-- <span class="typed-text"></span> -->
                        <h5 style="font-weight:bold;" class="carousel-intro typed-text"></h5>
                        <div class="hero-box">
                            <h1>Fully Furnished PG in Ahmedabad</h1>
                            <p>Safe • Affordable • Convenience</p>

                            <div class="hero-buttons">
                                <a href="{{route('rooms')}}" class="btn btn-warning">View Rooms</a>
                            </div>
                        </div>
                    </div>
                </div> --}}

                <div class="carousel-item">
                    <img src="{{asset('photos/3rd.jpg')}}" class="d-block w-100 img" alt="..">
                    <div class="carousel-caption d-none d-sm-block">
                        <h5 style="color:#ffffff; font-weight:bold;" class="carousel-intro typed-text"></h5>
                        <div class="hero-box">
                            <h1>Fully Furnished PG in Ahmedabad</h1>
                            <p>Safe • Affordable • Convenience</p>

                            <div class="hero-buttons">
                                <a href="{{route('rooms')}}" class="btn btn-warning">View Rooms</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>


        <section  class="pg-location-section">
            <div class="container">
            <div class="row justify-content-between align-items-center main-sec mb-0 p-4" id="intro-img">
                <div class="col-lg-6">
                    <h2>Comfortable PG Living in Ahmedabad</h2>

                    <p>
                        MY HOME PG offers a safe, comfortable, and fully furnished living space
                        for students and working professionals.
                    </p>

                    <ul class="why-us">
                        <li><i class="bi bi-house-check"></i> Fully Furnished Rooms</li>
                        <li><i class="fa-solid fa-bowl-food"></i> Home Cooked Food</li>
                        <li><i class="bi bi-geo-alt"></i> Prime Location</li>
                        <li><i class="bi bi-shield-check"></i> 24×7 Security</li>
                    </ul>
                    <a href="{{route('rooms')}}" class="btn btn-warning">View Available Rooms</a>
                </div>
                <div class="col-lg-5">
                    <img src="https://img.theweek.in/content/dam/week/news/biz-tech/images/2018/7/27/pg-accomodation.jpg"
                        class="img-fluid h-100 w-100 dummy-img">
                </div>
            </div>
            </div>
        </section>

        <section class="pg-location-section">
            <div class="container">
                <div class="row align-items-center">

                    <!-- LEFT CONTENT -->
                    <div class="col-lg-6 location-info">
                        <h2>PG Location</h2>

                        <ul class="location-points">
                            <li>
                                <i class="bi bi-geo-alt-fill"></i>
                                My Home PG is located in one of the most demandable areas of Ahmedabad
                            </li>
                            <li>
                                <i class="bi bi-building"></i>
                                Near IT offices, engineering colleges, schools and institutes
                            </li>
                            <li>
                                <i class="bi bi-shop"></i>
                                Daily need shops and services available nearby
                            </li>
                            <li>
                                <i class="bi bi-currency-rupee"></i>
                                Affordable rent compared to other PG accommodations
                            </li>
                        </ul>
                    </div>

                    <!-- RIGHT MAP -->
                    <div class="col-lg-6 map-box">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d917.8367202382243!2d72.53264437521476!3d23.047740995338277!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e84a538c7ede3%3A0xb31c13f9dbf13b9d!2sRaju%20Complex%2C%20Gurukul%20Rd%2C%20Memnagar%2C%20Ahmedabad%2C%20Gujarat%20380052!5e0!3m2!1sen!2sin!4v1764840814655!5m2!1sen!2sin"
                            width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>

                </div>
            </div>
        </section>
@endsection