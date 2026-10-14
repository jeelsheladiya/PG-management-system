@extends('member.master')

@section('title', 'My Complaints')
@section('page-title', 'My Complaints')

@section('body')

    <a href="/member/complaints/create" class="btn btn-primary mb-3">
        + Raise New Complaint
    </a>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show auto-close">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Complaint</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($complaints as $c)
                        <tr>
                            <td>{{ $c->ComplainID }}</td>
                            <td>{{ $c->ComplainText }}</td>
                            <td>{{ $c->DateRaised }}</td>
                            <td>
                                <span class="badge
                                            @if($c->Status == 'Pending') bg-warning
                                            @elseif($c->Status == 'Resolved') bg-success
                                            @else bg-info @endif">
                                    {{ $c->Status }}
                                </span>
                            </td>
                            <td>
                                <a href="/member/complaints/{{ $c->ComplainID }}" class="btn btn-sm btn-outline-primary">
                                    View
                                </a>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">No complaints yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $complaints->links() }}
            </div>
        </div>
    </div>

@endsection