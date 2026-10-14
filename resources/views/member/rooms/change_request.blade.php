@extends('member.master')
@section('body')
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">Request Room Change</div>
        <div class="card-body">
            <form action="{{ route('member.room.change.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Current Room:</label>
                    <input type="text" class="form-control" value="{{ $allocation->room->RoomNumber }}" readonly>
                </div>

                <div class="mb-3">
                    <label>Select New Room (Same Capacity):</label>
                    <select name="NewRoomID" class="form-select" required>
                        <option value="">-- Select Available Room --</option>
                        @foreach($availableRooms as $room)
                            <option value="{{ $room->RoomID }}">Room No: {{ $room->RoomNumber }} (Floor: {{ $room->Floor }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Reason for Change:</label>
                    <textarea name="Reason" class="form-control" required></textarea>
                </div>

                <button type="submit" class="btn btn-success">Submit Request</button>
            </form>
        </div>
    </div>
@endsection