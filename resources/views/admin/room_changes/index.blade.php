@extends('admin.master')
@section('title', 'Room Change Requests')
@section('body')

    <div class="container-fluid">
        <h2 class="mb-4">Room Change Requests</h2>

        <div class="table-responsive">
            <table class="table table-bordered table-hover shadow-sm bg-white">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Member Name</th>
                        <th>Current Room</th>
                        <th>Requested Room</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $r)
                        <tr>
                            <td>{{ $r->id }}</td>
                            <td>{{ $r->member->Name ?? 'N/A' }}</td>
                            <td><span class="badge bg-secondary">{{ $r->oldRoom->RoomNumber }}</span></td>
                            <td><span class="badge bg-primary">{{ $r->newRoom->RoomNumber }}</span></td>
                            <td>{{ $r->Reason }}</td>
                            <td>
                                <span
                                    class="badge @if($r->Status == 'Pending') bg-warning @elseif($r->Status == 'Approved') bg-success @else bg-danger @endif">
                                    {{ $r->Status }}
                                </span>
                            </td>
                            <td>
                                @if($r->Status == 'Pending')
                                    {{-- Approve Form --}}
                                    <form action="{{ route('admin.room-changes.approve', $r->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-success" onclick="return confirm('Approve this change?')">
                                            <i class="bi bi-check-circle"></i> Approve
                                        </button>
                                    </form>

                                    {{-- Reject Form --}}
                                    <form action="{{ route('admin.room-changes.reject', $r->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Reject this request?')">
                                            <i class="bi bi-x-circle"></i> Reject
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted small">Processed</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">No room change request received.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $requests->links() }}
        </div>
    </div>
@endsection