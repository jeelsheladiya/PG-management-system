@extends('admin.master')

@section('title') Member Room History @endsection

@section('body')

<h3>Room History — {{ $member->Name }}</h3>
<p><strong>Phone:</strong> {{ $member->Phone }}</p>
<p><strong>Course:</strong> {{ $member->Course }}</p>

<hr>

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Room</th>
            <th>Allocated On</th>
            <th>Release Date</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($member->allocations as $a)
        <tr>
            <td>Room {{ $a->room->RoomNumber ?? '—' }}</td>
            <td>{{ $a->AllocationDate }}</td>
            <td>{{ $a->ReleaseDate ?? 'Present' }}</td>
            <td>
                <span class="badge {{ $a->Status == 'Active' ? 'bg-success' : 'bg-secondary' }}">
                    {{ $a->Status }}
                </span>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center">No room history found</td>
        </tr>
        @endforelse
    </tbody>
</table>

<a href="/admin/members" class="btn btn-secondary">Back</a>

@endsection
