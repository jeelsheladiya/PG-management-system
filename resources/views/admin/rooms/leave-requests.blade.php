@extends('admin.master')

@section('title', 'Leave Requests')

@section('body')

    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-3">Pending Leave Requests</h4>

            @if($requests->isEmpty())
                <div class="alert alert-info">No leave requests pending.</div>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th>Room</th>
                            <th>Requested On</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $req)
                            <tr>
                                <td>{{ $req->member->Name }}</td>
                                <td>{{ $req->room->RoomNumber }}</td>
                                <td>{{ $req->updated_at ?? 'N/A' }}</td>
                                <td>
                                    <form action="{{ route('admin.leave.approve', $req->AllocationID) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button class="btn btn-success btn-sm">Approve</button>
                                    </form>

                                    <form action="{{ route('admin.leave.reject', $req->AllocationID) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button class="btn btn-danger btn-sm">Reject</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

@endsection