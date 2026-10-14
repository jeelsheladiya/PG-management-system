@extends('admin.master')

@section('title') Complaints @endsection

@section('body')

    <div class="container-fluid mb-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2>Complaints Management</h2>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Member</th>
                    <th>Category</th>
                    <th>Complaint</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Staff</th>
                    <th width="260">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($complaints as $c)
                    <tr>
                        <td>{{ $c->ComplainID }}</td>
                        <td>{{ $c->member->Name ?? 'N/A' }}</td>
                        <td><span class="badge bg-secondary">{{ $c->Category }}</span></td>
                        <td>{{ Str::limit($c->ComplainText, 30) }}</td>
                        <td>{{ $c->DateRaised }}</td>
                        <td>
                            <span class="badge 
                            @if($c->Status == 'Pending') bg-warning
                            @elseif($c->Status == 'In Progress') bg-info
                            @else bg-success @endif">
                                {{ $c->Status }}
                            </span>
                        </td>
                        <td>{{ $c->staff->Name ?? 'Not Assigned' }}</td>
                        <td>

                            {{-- Assign Staff --}}
                            @if($c->Status != 'Resolved')
                                <form action="/admin/complaints/{{ $c->ComplainID }}/assign" method="POST" style="display:inline;">
                                    @csrf
                                    <select name="StaffID" class="form-select form-select-sm d-inline w-auto" required>
                                        <option value="">Assign</option>

                                        {{-- only shows those staff records which role==complain Category --}}
                                        @php
                                            $filteredStaff = $staffList->where('Role', $c->Category);
                                        @endphp

                                        @if($filteredStaff->count() > 0)
                                            @foreach($filteredStaff as $s)
                                                <option value="{{ $s->StaffID }}" {{ $c->StaffID == $s->StaffID ? 'selected' : '' }}>
                                                    {{ $s->Name }}
                                                </option>
                                            @endforeach
                                        @else
                                            {{-- if staff is not available --}}
                                            <option disabled>No {{ $c->Category }} available</option>
                                        @endif
                                    </select>

                                    @if($filteredStaff->count() > 0)
                                        <button class="btn btn-sm btn-primary" title="Assign Staff">
                                            <i class="bi bi-check-lg"></i>
                                        </button>
                                    @endif
                                </form>
                            @endif

                            {{-- View --}}
                            <a href="/admin/complaints/{{ $c->ComplainID }}" class="btn btn-sm btn-secondary">
                                View
                            </a>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $complaints->links() }}
    </div>

@endsection