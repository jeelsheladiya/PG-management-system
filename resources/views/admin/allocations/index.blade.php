@extends('admin.master')

@section('title') Room Allotments @endsection

@section('body')


    <!-- @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show auto-close" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif -->

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show auto-close" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif


    <div class="container-fluid mb-3">
        <div class="row align-items-center">

            <!-- Left : Title -->
            <div class="col-md-3 text-start">
                <h2 class="mb-0">Room Allotments</h2>
            </div>

            <!-- Center : Search + Sort -->
            <div class="col-md-6 text-center">
                <form method="GET" action="/admin/allocations" class="d-flex justify-content-center gap-2">

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
                    <select name="status" class="form-select w-auto">
                        <option value="">All Status</option>
                        <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>


                    <button class="btn btn-primary">Filter</button>

                    <a href="/admin/allocations" class="btn btn-secondary">
                        Reset
                    </a>
                </form>
            </div>

            <!-- Right : Add -->
            <div class="col-md-3 text-end">
                <a href="/admin/allocations/create" class="btn btn-success">
                    + New Allotment
                </a>
            </div>

        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Member</th>
                    <th>Room</th>
                    <th>Allocated On</th>
                    <th>Release Date</th>
                    <th>Status</th>
                    <td>Active</td>
                </tr>
            </thead>
            <tbody>
                @forelse($allocations as $a)
                    <tr>
                        <td>{{ $a->AllocationID }}</td>
                        <td>{{ $a->member->Name }}</td>
                        <td>{{ $a->room->RoomNumber }}</td>
                        <td>{{ $a->AllocationDate }}</td>
                        <td>
                            @if($a->ReleaseDate)
                                {{ $a->ReleaseDate }}
                            @else
                                —
                            @endif
                        </td>
                        <td>
                            @if($a->Status == 'Active')
                                <span class="badge bg-success">Active</span>

                         
                            @elseif($a->Status == 'Inactive')
                                <span class="badge bg-danger">Inactive</span>

                            @else
                                <span class="badge bg-dark">{{ $a->Status }}</span>
                            @endif
                        </td>

                        <td>
                            @if($a->Status == 'Active')
                                <form action="/admin/allocations/{{ $a->AllocationID }}/release" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('POST')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Release this room?')">
                                        Release
                                    </button>
                                </form>

                            @else
                                <span class="text-muted">Released</span>
                            @endif
                        </td>
                    </tr>


                @empty
                    <tr>
                        <td colspan="7" class="text-center">
                            No rooms found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center mt-3">
        {{ $allocations->links() }}
    </div>
@endsection