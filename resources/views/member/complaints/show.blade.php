@extends('member.master')

@section('title', 'Complaint Details')
@section('page-title', 'Complaint Details')

@section('body')

    <div class="card shadow-sm mb-4">
        <div class="card-body">

            <div class="d-flex justify-content-between">
                <h5>Complaint #{{ $complaint->ComplainID }}</h5>
                <span class="badge 
                    @if($complaint->Status == 'Pending') bg-warning
                    @elseif($complaint->Status == 'Resolved') bg-success
                    @else bg-info @endif">
                    {{ $complaint->Status }}
                </span>
            </div>

            <hr>

            <p><strong>Date Raised:</strong> {{ $complaint->DateRaised }}</p>

            @if($complaint->DateResolved)
                <p><strong>Date Resolved:</strong> {{ $complaint->DateResolved }}</p>
            @endif

            <div class="mt-3">
                <label class="form-label fw-bold">Complaint Message</label>
                <div class="p-3 bg-light rounded border">
                    {{ $complaint->ComplainText }}
                </div>
            </div>

            @if($complaint->staff)
                <div class="mt-4">
                    <h6 class="text-muted">Assigned Staff</h6>
                    <div class="p-2 border rounded bg-white">
                        👨‍🔧 {{ $complaint->staff->Name }}
                        <br>
                        📞 {{ $complaint->staff->Phone }}
                    </div>
                </div>
            @endif

            <a href="/member/complaints" class="btn btn-secondary mt-4">Back to Complaints</a>

        </div>
    </div>

@endsection