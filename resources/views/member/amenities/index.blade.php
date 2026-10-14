@extends('member.master')

@section('title', 'Amenities')
@section('page-title', 'Amenities')

@section('body')
<div class="container mt-4">

    @if($amenities->count() == 0)
        <div class="alert alert-info">
            No amenities available right now.
        </div>
    @endif

    <div class="row">
        @foreach($amenities as $amenity)
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-body text-center">

                    <h5 class="fw-bold">
                        {{ $amenity->AmenityName }}
                    </h5>

                    <p class="text-muted small">
                        {{ $amenity->Description ?? '—' }}
                    </p>

                    <span class="badge 
                        {{ $amenity->Status == 'Active' ? 'bg-success' : 'bg-secondary' }}">
                        {{ $amenity->Status }}
                    </span>

                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>
@endsection
