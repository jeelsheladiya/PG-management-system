@extends('admin.master')

@section('title') Rooms @endsection

@section('body')


<div class="container-fluid mb-3">
    <div class="row align-items-center">

        <!-- Left -->
        <div class="col-md-3 text-start">
            <h2 class="mb-0">Rooms</h2>
        </div>

        <!-- Center : Filters + Search -->
        <div class="col-md-6 text-center">
            <form method="GET" action="/admin/rooms/"
                  class="d-flex justify-content-center gap-2">

                <!-- Status -->
                <select name="status" class="form-select w-auto">
                    <option value="">All Status</option>
                    @foreach(['Active','Inactive','Maintenance'] as $st)
                        <option value="{{ $st }}"
                            {{ request('status') == $st ? 'selected' : '' }}>
                            {{ $st }}
                        </option>
                    @endforeach
                </select>

                <!-- Floor -->
                <select name="floor" class="form-select w-auto">
                    <option value="">All Floors</option>
                    @foreach($floors as $floor)
                        <option value="{{ $floor }}"
                            {{ request('floor') == $floor ? 'selected' : '' }}>
                            Floor {{ $floor }}
                        </option>
                    @endforeach
                </select>

                <!-- Search -->
                <input type="text" name="search"
                       class="form-control w-auto"
                       placeholder="Room No"
                       value="{{ request('search') }}">

                <button class="btn btn-primary">Filter</button>

                <a href="/admin/rooms/" class="btn btn-secondary">
                    Reset
                </a>
            </form>
        </div>

        <!-- Right -->
        <div class="col-md-3 text-end">
            <a href="/admin/rooms/create" class="btn btn-success">
                + Add Room
            </a>
        </div>

    </div>
</div>



<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr class="text-center">
            <!-- <th>Room ID</th> -->
            <th>Room Number</th>
            <th>Floor</th>
            <th>Capacity</th>
            <th>Occupied</th>
            <th>Vacant</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @forelse($rooms as $room)
        <tr class="text-center">
            <!-- <td>{{ $room->RoomID }}</td> -->
            <td>{{ $room->RoomNumber }}</td>
            <td>{{ $room->Floor }}</td>
            <td>{{ $room->Capacity }}</td>
            <td>
                {{ $room->occupancy->CurrentOccupancy ?? 0 }}
            </td>
            
            <td>
                <!-- <span class="badge 
                    {{ ($room->occupancy->VacantBeds ?? $room->Capacity) > 0 
                        ? 'bg-success' 
                        : 'bg-danger' }}"> -->
                    {{ $room->occupancy->VacantBeds ?? $room->Capacity }}
                <!-- </span> -->
            </td>            
            <td>
                <span class="badge 
                    @if($room->Status == 'Active')
                         bg-success
                    @elseif($room->Status == 'Inactive')
                        bg-danger
                    @elseif($room->Status == 'Maintenance')
                        bg-secondary
                    @endif
                ">
                    {{ $room->Status }}
                </span>

            </td>
            <td>
                <a href="/admin/rooms/{{ $room->RoomID }}/edit" class="btn btn-sm btn-warning">
                    Edit
                </a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="text-center">
                No rooms found
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

@endsection