@extends('admin.master')

@section('title') Add Room @endsection

@section('body')

<h2>Add Room</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="/admin/rooms">
    @csrf

    <div class="mb-3">
        <label class="form-label">Room Number</label>
        <input type="text" name="RoomNumber" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Capacity</label>
        <input type="number" name="Capacity" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Floor Number</label>
        <input type="number" name="Floor" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">
        Add Room
    </button>

    <a href="/admin/rooms" class="btn btn-secondary">
        Back
    </a>
</form>

@endsection
