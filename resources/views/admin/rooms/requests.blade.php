@extends('admin.master')

@section('title', 'Room Booking Requests')
@section('content')

    <div class="card">
        <div class="card-header">Pending Room Requests</div>
        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <table class="table table-bordered">
                <tr>
                    <th>Member</th>
                    <th>Room</th>
                    <th>Request Date</th>
                    <th>Action</th>
                </tr>

                @foreach($requests as $req)
                    <tr>
                        <td>{{ $req->member->Name }}</td>
                        <td>{{ $req->room->RoomNumber }}</td>
                        <td>{{ $req->created_at ?? '—' }}</td>
                        <td>
                            <form action="/admin/room-approve/{{ $req->AllocationID }}" method="POST" style="display:inline;">
                                @csrf
                                <button class="btn btn-success btn-sm">Approve</button>
                            </form>

                            <form action="/admin/room-reject/{{ $req->AllocationID }}" method="POST" style="display:inline;">
                                @csrf
                                <button class="btn btn-danger btn-sm">Reject</button>
                            </form>
                        </td>
                    </tr>
                @endforeach

            </table>

        </div>
    </div>

@endsection