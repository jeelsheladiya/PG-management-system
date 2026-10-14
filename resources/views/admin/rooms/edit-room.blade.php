@extends('admin.master')

@section('title') Edit Room @endsection

@section('body')

<h2>Edit Room</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="/admin/rooms/{{ $room->RoomID }}/update">
    @csrf

    @method('PUT')
    <div class="mb-3">
        <label>Room Number</label>
        <input type="text" name="RoomNumber" 
               value="{{ $room->RoomNumber }}" 
               class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Capacity</label>
        <input type="number" name="Capacity" 
               value="{{ $room->Capacity }}" 
               class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Floor</label>
        <input type="number" name="Floor" 
               value="{{ $room->Floor }}" 
               class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Status</label>
        <select name="Status" class="form-control" required>
            <option value="Active"
                {{ $room->Status == 'Active' ? 'selected' : '' }}>
                Active
            </option>
            
            <option value="Maintenance"
            {{ $room->Status == 'Maintenance' ? 'selected' : '' }}>
            Maintenance
        </option>

            <option value="Inactive"
                {{ $room->Status == 'Inactive' ? 'selected' : '' }}>
                Inactive
            </option>
        </select>
    </div>
    
    <button class="btn btn-primary">Update Room</button>
    <a href="/admin/rooms" class="btn btn-secondary">Back</a>
</form>

@endsection
