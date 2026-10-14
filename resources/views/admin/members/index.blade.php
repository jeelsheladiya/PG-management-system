@extends('admin.master')

@section('title') Members @endsection

@section('body')

    <div class="container-fluid mb-3">
        <div class="row align-items-center">

            <!-- Left : Title -->
            <div class="col-md-3 text-start">
                <h2 class="mb-0">Members</h2>
            </div>

            <!-- Center : Search + Sort -->
            <div class="col-md-6 text-center">
                <form method="GET" action="/admin/members" class="d-flex justify-content-center gap-2">

                    <!-- Search -->
                    <input type="text" name="search" class="form-control w-auto" placeholder="Name / Phone / Course"
                        value="{{ request('search') }}">

                    <!-- Sort -->
                    <select name="sort" class="form-select w-auto">
                        <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>
                            Newest First
                        </option>
                        <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>
                            Oldest First
                        </option>
                    </select>

                    <button class="btn btn-primary">Filter</button>

                    <a href="/admin/members" class="btn btn-secondary">
                        Reset
                    </a>
                </form>
            </div>

            <!-- Right : Add -->
            <div class="col-md-3 text-end">
                <a href="/admin/members/create" class="btn btn-success">
                    + Add Member
                </a>
            </div>

        </div>
    </div>


    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Course</th>
                <th>Room</th>
                <th>Join Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($members as $member)
                <tr>
                    <td>{{ $member->MemberID }}</td>
                    <td>{{ $member->Name }}</td>
                    <td>{{ $member->Phone }}</td>
                    <td>{{ $member->Course }}</td>
                    <td>
                        @if($member->currentRoom && $member->currentRoom->room)
                            {{ $member->currentRoom->room->RoomNumber }}
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>{{ $member->JoinDate }}</td>
                    <td class="text-nowrap">
                        <a href="/admin/members/{{ $member->MemberID }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-eye"></i>
                            View
                        </a>
                        <a href="/admin/members/{{ $member->MemberID }}/history" class="btn btn-sm btn-info">
                            <i class="bi bi-clock-history"></i>
                            History
                        </a>

                        <a href="/admin/members/{{ $member->MemberID }}/edit" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                            Edit
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center mt-3">
        {{ $members->links() }}
    </div>

@endsection