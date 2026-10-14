@extends('member.master')

@section('title', 'Notices')
@section('page-title', 'Notices')
@section('body')
    <div class="container mt-4">

        <h4 class="mb-3">Latest Notices</h4>

        @if($notices->count())
            @foreach($notices as $notice)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">
                            {{ $notice->Title }}
                        </h5>

                        <p class="card-text">
                            {{ $notice->Message }}
                        </p>
                        <small class="text-muted">
                            {{ $notice->DatePosted }}
                        </small>
                        <br>
                        <small class="text-muted">
                            Posted by {{ $notice->Admin->Name ?? 'Admin' }}
                        </small>
                    </div>
                </div>
            @endforeach
        @else
            <p class="text-muted">No notices available.</p>
        @endif

    </div>
@endsection