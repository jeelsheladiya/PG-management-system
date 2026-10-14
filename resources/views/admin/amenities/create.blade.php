@extends('admin.master')
@section('title') Add Amenity @endsection

@section('body')

    <h3>Add Amenity</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/admin/amenities">
        @csrf

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="AmenityName" class="form-control" required maxlength="35">
        </div>

        <div class="mb-3">
            <label>Description</label>
            <input type="text" name="Description" class="form-control" maxlength="50">
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="Status" class="form-select" required>
                <option value="Available">Available</option>
                <option value="Unavailable">Unavailable</option>
            </select>
        </div>

        <button class="btn btn-primary">Save</button>
        <a href="/admin/amenities" class="btn btn-secondary">Back</a>

    </form>

@endsection