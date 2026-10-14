@extends('staff.master')

@section('title', 'Assigned Complaints')

@section('page-title', 'Assigned Complaints')

@section('body')

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">

            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Member</th>
                        <th>Complaint</th>
                        <th>Date Raised</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($complaints as $c)
                        <tr>
                            <td>{{ $c->ComplainID }}</td>
                            <td>{{ $c->member->Name ?? 'N/A' }}</td>
                            <td>{{ $c->ComplainText }}</td>
                            <td>{{ \Carbon\Carbon::parse($c->DateRaised)->format('d M Y') }}</td>
                            <td>
                                <span class="badge {{ $c->Status == 'Resolved' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $c->Status ?? 'Pending' }}
                                </span>
                            </td>
                            <td>
                                @if($c->Status != 'Resolved')
                                    <form action="/staff/complaints/{{ $c->ComplainID }}/resolve" method="POST">
                                        @csrf
                                        <button class="btn btn-sm btn-success"
                                            onclick="return confirm('Mark this complaint as resolved?')">
                                            Resolve
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted">Done</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        {{-- if data is null--}}
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="bi bi-info-circle fs-4 d-block mb-2"></i>
                                    You currently do not have any specified (assigned) complaints.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-center">
                {{ $complaints->links() }}
            </div>

        </div>
    </div>

@endsection