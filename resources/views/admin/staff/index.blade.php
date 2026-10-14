@extends('admin.master')

@section('title') Staff @endsection

@section('body')

<div class="container-fluid mb-3">
    <div class="row align-items-center">

        <!-- Left : Title -->
        <div class="col-md-3 text-start">
            <h2 class="mb-0">Staff</h2>
        </div>

        <!-- Center : Search + Role Filter -->
        <div class="col-md-6 text-center">
            <form method="GET" action="/admin/staff"
                  class="d-flex justify-content-center gap-2">

                <!-- Search -->
                <input type="text"
                       name="search"
                       class="form-control w-auto"
                       placeholder="Name / Phone / Email"
                       value="{{ request('search') }}">

                <!-- Role Filter -->
                <select name="role" class="form-select w-auto">
                    <option value="">All Roles</option>
                    <option value="Electrician" {{ request('role')=='Electrician'?'selected':'' }}>Electrician</option>
                    <option value="Cleaner" {{ request('role')=='Cleaner'?'selected':'' }}>Cleaner</option>
                    <option value="Chef" {{ request('role')=='Chef'?'selected':'' }}>Chef</option>
                    <option value="Plumber" {{ request('role')=='Plumber'?'selected':'' }}>Plumber</option>
                    <option value="Carpenter" {{ request('role')=='Carpenter'?'selected':'' }}>Carpenter</option>
                </select>

                <button class="btn btn-primary">Filter</button>

                <a href="/admin/staff" class="btn btn-secondary">
                    Reset
                </a>
            </form>
        </div>

        <!-- Right : Add -->
        <div class="col-md-3 text-end">
            <a href="/admin/staff/create" class="btn btn-success">
                + Add Staff
            </a>
        </div>

    </div>
</div>


<table class="table table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Role</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Hire Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($staff as $s)
        <tr>
            <td>{{ $s->StaffID }}</td>
            <td>{{ $s->Name }}</td>
            <td>
                <span class="badge bg-info text-dark">
                    {{ $s->Role }}
                </span>
            </td>
            <td>{{ $s->Phone ?? '—' }}</td>
            <td>{{ $s->Email }}</td>
            <td>{{ $s->HireDate ?? '—' }}</td>
            <td class="text-nowrap">

                <a href="/admin/staff/{{ $s->StaffID }}"
                   class="btn btn-sm btn-primary">
                    <i class="bi bi-eye"></i> View
                </a>

                <a href="/admin/staff/{{ $s->StaffID }}/edit"
                   class="btn btn-sm btn-warning">
                    <i class="bi bi-pencil"></i> Edit
                </a>

                <form action="/admin/staff/{{ $s->StaffID }}/delete"
                      method="POST"
                      style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger"
                            onclick="return confirm('Delete this staff member?')">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </form>

            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="d-flex justify-content-center mt-3">
    {{ $staff->links() }}
</div>

@endsection
