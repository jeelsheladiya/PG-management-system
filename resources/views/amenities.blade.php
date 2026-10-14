@extends('layouts.app')
@section('title')
    Amenities
@endsection
@push('styles')
    <link rel="stylesheet" href="{{asset('css/amenities.css')}}">
@endpush

    @section('content')

        <div class="container-fluid amenities_ mt-2">

            <div class="container-fluid myAmenities">

                <div class="main-ame-header">
                    <p>Amenities For Your Comfort</p>
                </div>

                <div class="d-flex justify-content-center">
                    <div class="row g-4" id="all-card">
                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="card h-100">
                                <div class="card-body w-100">
                                    <!-- <span> -->
                                    <h5 class="card-title">Refrigerator</h5>
                                    <!-- </span> -->
                                    <!-- <p class="card-text">Refrigerator</p> -->
                                    <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                                </div>
                                <img src="
                                {{asset('photos/Newref.png')}}" alt="...">
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="card h-100">
                                <div class="card-body w-100">
                                    <!-- <span> -->
                                    <h5 class="card-title">Water Purifier</h5>
                                    <!-- </span> -->
                                    <!-- <p class="card-text">Water Purifier</p> -->
                                    <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                                </div>
                                <img src="{{asset('photos/Newwater.png')}}" alt="...">
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="card h-100">
                                <div class="card-body w-100">
                                    <!-- <span> -->
                                    <h5 class="card-title">Gysers</h5>
                                    <!-- </span> -->
                                    <!-- <p class="card-text">NewGysers</p> -->
                                    <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                                </div>
                                <img src="{{asset('photos/NewGysers.png')}}" alt="...">
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="card h-100">
                                <div class="card-body w-100">
                                    <!-- <span> -->
                                    <h5 class="card-title">24/7 Electricity</h5>
                                    <!-- </span> -->
                                    <!-- <p class="card-text">NewGysers</p> -->
                                    <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                                </div>
                                <img src="{{asset('photos/NewElec.png')}}" alt="...">
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="card h-100">
                                <div class="card-body w-100">
                                    <!-- <span> -->
                                    <h5 class="card-title">Reading Room</h5>
                                    <!-- </span> -->
                                    <!-- <p class="card-text">NewGysers</p> -->
                                    <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                                </div>
                                <img src="{{asset('photos/Newread.png')}}" alt="...">
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="card h-100">
                                <div class="card-body w-100">
                                    <!-- <span> -->
                                    <h5 class="card-title">HighSpeed Wi-Fi</h5>
                                    <!-- </span> -->
                                    <!-- <p class="card-text">NewGysers</p> -->
                                    <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                                </div>
                                <img src="{{asset('photos/Newwifi.png')}}" alt="...">
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="card h-100">
                                <div class="card-body w-100">
                                    <!-- <span> -->
                                    <h5 class="card-title">Hygienic Meal</h5>
                                    <!-- </span> -->
                                    <!-- <p class="card-text">NewGysers</p> -->
                                    <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                                </div>
                                <img src="
                                {{asset('photos/Newmeal.png')}}" alt="...">
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="card h-100">
                                <div class="card-body w-100">
                                    <!-- <span> -->
                                    <h5 class="card-title">Washing Machine</h5>
                                    <!-- </span> -->
                                    <!-- <p class="card-text">NewGysers</p> -->
                                    <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                                </div>
                                <img src="{{asset('photos/Newwm.png')}}" alt="...">
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="card h-100">
                                <div class="card-body w-100">
                                    <!-- <span> -->
                                    <h5 class="card-title">Bed</h5>
                                    <!-- </span> -->
                                    <!-- <p class="card-text">NewGysers</p> -->
                                    <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                                </div>
                                <img src="{{asset('photos/Newbed.png')}}" alt="...">
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="card h-100 d-flex align-items-center">
                                <div class="card-body w-100">
                                    <!-- <span> -->
                                    <h5 class="card-title">Dining Table</h5>
                                    <!-- </span> -->
                                    <!-- <p class="card-text">Refrigerator</p> -->
                                    <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                                </div>
                                <img src="{{asset('photos/diningTable.png')}}" alt="...">
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="card h-100 d-flex align-items-center">
                                <div class="card-body w-100">
                                    <!-- <span> -->
                                    <h5 class="card-title">Pillow and Blanket</h5>
                                    <!-- </span> -->
                                    <!-- <p class="card-text">Refrigerator</p> -->
                                    <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                                    <!-- photos/bedsheet.png -->
                                </div>
                                <img src="{{ asset('photos/bedsheet.png') }}" alt="...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @include('weekly_food-menu')
        </div>

    @endsection