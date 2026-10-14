@extends('member.master')

@section('title', 'Available Rooms')
@section('page-title', 'Available Rooms')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .room-cards { transition: transform 0.3s; border-radius: 15px; overflow: hidden; }
        .room-cards:hover { transform: translateY(-5px); }
        .card-img-top { height: 200px; object-fit: cover; }
        .badge-floating { position: absolute; top: 10px; right: 10px; z-index: 1; }
    </style>
@endpush

@section('body')

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
    @endif

    {{-- Filter Bar --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-primary mb-0">Find Your Perfect Stay</h4>
        <form method="GET" class="d-flex gap-2">
            <select name="capacity" class="form-select shadow-sm" onchange="this.form.submit()">
                <option value="">All Sharing</option>
                <option value="2" {{ request('capacity') == 2 ? 'selected' : '' }}>2 Sharing</option>
                <option value="3" {{ request('capacity') == 3 ? 'selected' : '' }}>3 Sharing</option>
                <option value="4" {{ request('capacity') == 4 ? 'selected' : '' }}>4 Sharing</option>
            </select>
        </form>
    </div>

    <div class="row g-4">
        @forelse ($rooms as $room)
            <div class="col-md-4 col-lg-3">
                <div class="card room-cards h-100 shadow-sm border-0 position-relative">
                    
                    {{-- Badges for Status --}}
                    <div class="badge-floating">
                        @if($room->occupancy->VacantBeds == 0)
                            <span class="badge bg-danger">Full</span>
                        @else
                            <span class="badge bg-success">{{ $room->occupancy->VacantBeds }} Beds Left</span>
                        @endif
                    </div>

                    {{-- Room Image --}}
                    <img src="{{ asset($room->ImageURL ?? 'images/default-room.jpg') }}" class="card-img-top" alt="Room Image">

                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted small">Floor: <strong>{{ $room->Floor }}</strong></span>
                            <span class="text-primary fw-bold small">#{{ $room->RoomNumber }}</span>
                        </div>
                        
                        <h5 class="card-title fw-bold">{{ $room->Capacity }} Sharing Room</h5>
                        <p class="card-text text-muted small">
                            {{ Str::limit($room->Description, 60) ?? 'Luxurious stay with all basic amenities provided.' }}
                        </p>

                        {{-- Display Occupancy Status --}}
                        <div class="py-2">
                            <div class="progress" style="height: 10px;">
                                @php 
                                    $occupied = $room->Capacity - $room->occupancy->VacantBeds;
                                    $percent = ($occupied / $room->Capacity) * 100;
                                    $widthPercent = round($percent);
                                @endphp
                                <div class="progress-bar bg-info" role="progressbar" style="width: <?= $widthPercent ?>%"></div>
                            </div>
                            <small class="text-muted">{{ $occupied }}/{{ $room->Capacity }} Beds Occupied</small>
                        </div>
                    </div>

                    <div class="card-footer bg-white border-0 pb-3">
                        @if($hasActiveRoom)
                            <button class="btn btn-secondary w-100 disabled" title="You already have a booked room">
                                <i class="fa fa-lock me-1"></i> Already Booked
                            </button>
                        @elseif($room->occupancy->VacantBeds == 0)
                            <button class="btn btn-danger w-100 disabled">Room Full</button>
                        @else
                            <a href="/member/rooms/book/{{ $room->RoomID }}" class="btn btn-primary w-100 shadow-sm">
                                <i class="fa fa-door-open me-1"></i> Book Now
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="fa-regular fa-face-frown fa-4x mb-3 text-muted"></i>
                <h4 class="fw-bold text-muted">No rooms available at the moment</h4>
            </div>
        @endforelse
    </div>

@endsection