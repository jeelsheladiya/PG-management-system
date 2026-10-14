@extends('admin.master')
@section('title') Amenities @endsection

@section('body')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Amenities</h2>
        <a href="/admin/amenities/create" class="btn btn-success">+ Add Amenity</a>
    </div>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($amenities as $a)
                <tr>
                    <td>{{ $a->AmenityID }}</td>
                    <td>{{ $a->AmenityName }}</td>
                    <td>{{ $a->Description ?? '—' }}</td>
                    <td>
                        <span class="badge {{ $a->Status == 'Available' ? 'bg-success' : 'bg-danger' }}">
                            {{ $a->Status }}
                        </span>
                    </td>
                    <td>
                        <a href="/admin/amenities/{{ $a->AmenityID }}/edit" class="btn btn-sm btn-primary">Edit</a>

                        <form action="/admin/amenities/{{ $a->AmenityID }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete amenity?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $amenities->links() }}
    </div>

@endsection