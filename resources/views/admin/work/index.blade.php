@extends('admin.master')

@section('title') Work Allocation @endsection

@section('body')

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show auto-close">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="container-fluid mb-3">
        <div class="row align-items-center">

            <!-- Left : Title -->
            <div class="col-md-3 text-start">
                <h2 class="mb-0">Work Allocation</h2>
            </div>

            <!-- Center : Search + Sort -->
            <div class="col-md-6 text-center">
                <form method="GET" action="/admin/work" class="d-flex justify-content-center gap-2">

                    <!-- Search -->
                    <input type="text" name="search" class="form-control w-auto" placeholder="Staff Name / Work Type"
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

                    <!-- Status Filter -->
                    <select name="status" class="form-select w-auto">
                        <option value="">All Status</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In Progress
                        </option>
                        <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                    </select>

                    <button class="btn btn-primary">Filter</button>

                    <a href="/admin/work" class="btn btn-secondary">Reset</a>
                </form>
            </div>

            <!-- Right : Add -->
            <div class="col-md-3 text-end">
                <a href="/admin/work/create" class="btn btn-success">
                    + New Work
                </a>
            </div>

        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Staff</th>
                    <th>Work Type</th>
                    <th>Description</th>
                    <th>Assigned On</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($works as $w)
                    <tr>
                        <td>{{ $w->WorkID }}</td>
                        <td>{{ $w->staff->Name }}</td>
                        <td>{{ $w->WorkType }}</td>
                        <td>{{ $w->Description }}</td>
                        <td>{{ $w->AssignDate }}</td>
                        <td>
                            <span class="badge
                                            @if($w->Status == 'Completed') bg-success
                                            @elseif($w->Status == 'In Progress') bg-warning text-dark
                                            @else bg-secondary
                                            @endif">
                                {{ $w->Status }}
                            </span>
                        </td>
                        <td>
                            <a href="/admin/work/{{ $w->WorkID }}/edit" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                                Edit
                            </a>

                            @if($w->Status != 'Completed')
                                <form action="/admin/work/{{ $w->WorkID }}/complete" method="POST" style="display:inline;">
                                    @csrf
                                    <button class="btn btn-sm btn-success" onclick="return confirm('Mark work as completed?')">
                                        Complete
                                    </button>
                                </form>
                            @else
                                <span class="text-muted">Done</span>
                            @endif

                            <form action="/admin/work/{{ $w->WorkID }}/delete" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this Work Record?')">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $works->links() }}
    </div>

@endsection