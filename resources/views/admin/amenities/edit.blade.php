@extends('admin.master')
@section('title') Edit Amenity @endsection

@section('body')

    <h3>Edit Amenity</h3>

    <form method="POST" action="/admin/amenities/{{ $amenity->AmenityID }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="AmenityName" value="{{ $amenity->AmenityName }}" class="form-control" required
                maxlength="35">
        </div>

        <div class="mb-3">
            <label>Description</label>
            <input type="text" name="Description" value="{{ $amenity->Description }}" class="form-control" maxlength="50">
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="Status" class="form-select" required>
                <option value="Available" {{ $amenity->Status == 'Available' ? 'selected' : '' }}>Available</option>
                <option value="Unavailable" {{ $amenity->Status == 'Unavailable' ? 'selected' : '' }}>Unavailable</option>
            </select>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="/admin/amenities" class="btn btn-secondary">Back</a>

    </form>

@endsection