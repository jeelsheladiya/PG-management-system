@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{asset('css/rooms.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush

@section('content')
    <form method="GET" class="d-flex justify-content-end my-3 me-5">
        <select name="rent" class="form-select w-auto" onchange="this.form.submit()">
            <option value="">All Rents</option>
            <option value="7000" {{ request('rent') == 7000 ? 'selected' : '' }}>₹7000</option>
            <option value="7500" {{ request('rent') == 7500 ? 'selected' : '' }}>₹7500</option>
            <option value="8000" {{ request('rent') == 8000 ? 'selected' : '' }}>₹8000</option>
        </select>

        <select name="room_type" class="form-select w-auto ms-2" onchange="this.form.submit()">
            <option value="">Room Type</option>
            <option value="Two_Sharing" {{ request('room_type') == "Two_Sharing" ? 'selected' : '' }}>Two Sharing</option>
            <option value="Three_Sharing" {{ request('room_type') == "Three_Sharing" ? 'selected' : '' }}>Three Sharing
            </option>
            <option value="Four_Sharing" {{ request('room_type') == "Four_Sharing" ? 'selected' : '' }}>Four Sharing</option>
            <option value="Common_Hall" {{ request('room_type') == "Common_Hall" ? 'selected' : '' }}>Common Hall</option>
        </select>
    </form>

    <div class="container-fluid mt-5 mb-2 parent-room-container">
        <div
            class="container-fluid row row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 justify-content-center align-items-center">

            @forelse ($rooms as $room)
                <div class="col">
                    <div class="card room-cards h-100 shadow-sm border-0">
                        <img src="{{ asset($room->ImageURL) }}" class="card-img-top" alt="Room Image">

                        <div class="card-body">
                            <p class="text-muted mb-1 small">Room No: <strong>{{ $room->RoomNumber }}</strong></p>
                            <h5 class="card-title text-primary">
                                {{ $room->Capacity }} Sharing Room
                            </h5>

                            <p class="card-text text-muted">
                                {{ Str::limit($room->Description, 80) ?? 'Comfortable stay at Floor ' . $room->Floor }}
                            </p>

                            <div class="mt-4">
                                <p class="fw-bold text-success mb-0">₹{{ $room->pricingVisiter->MonthlyRent ?? 'N/A' }} / Month
                                </p>
                                <p class="fw-bold text-success small">₹{{ $room->pricingVisiter->DailyRent ?? 'N/A' }} / Day</p>
                            </div>
                        </div>

                        <div class="card-body pb-3">
                            <button class="btn btn-dark view-room-btn w-100" data-bs-toggle="modal" data-bs-target="#roomModal"
                                data-room-id="{{ $room->RoomID }}">
                                Book Now
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 d-flex justify-content-center align-items-center" style="min-height:75vh;">
                    <div class="text-center">
                        <i class="fa-regular fa-face-frown fa-4x mb-3 text-muted"></i>
                        <h4 class="fw-bold">No Rooms Found</h4>
                        <p class="text-muted">Try changing your filters.</p>
                        <a href="{{ route('rooms') }}" class="btn btn-primary mt-2">Reset Filters</a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <div class="modal fade" id="roomModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalTitle">Room Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="modalContent">
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status"></div>
                        <p class="mt-2">Loading...</p>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <h5 class="text-success mb-0" id="modalPrice"></h5>
                    <a href="#" class="btn btn-success px-4" id="modalBookBtn">Book Now</a>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{asset('js/room_details.js')}}"></script>
@endpush