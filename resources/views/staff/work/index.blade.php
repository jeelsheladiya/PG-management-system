
@extends('staff.master')

@section('title', 'My Work Tasks')

@section('page-title', 'My Work Tasks')

@section('body')

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card shadow-sm">
    <div class="card-body">

        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Work Type</th>
                    <th>Description</th>
                    <th>Assigned On</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($works as $w)
                <tr>
                    <td>{{ $w->WorkID }}</td>
                    <td>{{ $w->WorkType }}</td>
                    <td>{{ $w->Description }}</td>
                    <td>{{ \Carbon\Carbon::parse($w->AssignDate)->format('d M Y') }}</td>
                    <td>
                        <span class="badge {{ $w->Status == 'Completed' ? 'bg-success' : 'bg-warning' }}">
                            {{ $w->Status }}
                        </span>
                    </td>
                    <td>
                        @if($w->Status != 'Completed')
                        <form action="/staff/work/{{ $w->WorkID }}/complete" method="POST">
                            @csrf
                            <button class="btn btn-sm btn-success"
                                onclick="return confirm('Mark this work as completed?')">
                                Complete
                            </button>
                        </form>
                        @else
                        <span class="text-muted">Done</span>
                        @endif
                    </td>
                </tr>
                @empty
                        {{-- if data is null--}}
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="bi bi-info-circle fs-4 d-block mb-2"></i>
                                    You currently do not have any specified (assigned) work.
                                </div>
                            </td>
                        </tr>
                    @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $works->links() }}
        </div>

    </div>
</div>

@endsection
