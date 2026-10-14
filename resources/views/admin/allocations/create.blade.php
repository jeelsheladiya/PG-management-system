@extends('admin.master')

@section('title') New Allotment @endsection

@section('body')

    <h2>New Room Allotment</h2>

    <form method="POST" action="/admin/allocations">
        @csrf

        <div class="mb-3">
            <label class="form-label">Select Member</label>
            <select name="MemberID" class="form-control" required>
                <option value="">-- Choose Member --</option>
                @foreach($members as $m)
                    <option value="{{ $m->MemberID }}">{{ $m->Name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Select Room</label>
            <select name="RoomID" class="form-control" required>
                <option value="">-- Choose Room --</option>
                @foreach($rooms as $r)
                    <option value="{{ $r->RoomID }}">Room {{ $r->RoomNumber }} (Cap: {{ $r->Capacity }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Allocation Date</label>
            <input type="date" name="AllocationDate" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Release Date (Expected)</label>
            <input type="date" name="ReleaseDate" class="form-control" required>
        </div>

        <button class="btn btn-success">Allot Room</button>
        <a href="/admin/allocations" class="btn btn-secondary">Back</a>
    </form>

@endsection