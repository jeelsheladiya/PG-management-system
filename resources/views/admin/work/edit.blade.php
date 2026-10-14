@extends('admin.master')
@section('title') Edit Work @endsection
@section('body')

<h2>Edit Work</h2>

<form method="POST" action="/admin/work/{{ $work->WorkID }}/update">
@csrf
@method('PUT')

<div class="mb-3">
    <label>Staff</label>
    <select name="StaffID" class="form-control">
        @foreach($staff as $s)
            <option value="{{ $s->StaffID }}" {{ $work->StaffID == $s->StaffID ? 'selected' : '' }}>
                {{ $s->Name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Work Type</label>
    <input type="text" name="WorkType" value="{{ $work->WorkType }}" class="form-control">
</div>

<div class="mb-3">
    <label>Description</label>
    <textarea name="Description" class="form-control">{{ $work->Description }}</textarea>
</div>

<div class="mb-3">
    <label>Status</label>
    <select name="Status" class="form-control">
        <option {{ $work->Status=='Pending'?'selected':'' }}>Pending</option>
        <option {{ $work->Status=='In Progress'?'selected':'' }}>In Progress</option>
        <option {{ $work->Status=='Completed'?'selected':'' }}>Completed</option>
    </select>
</div>

<button class="btn btn-primary">Update Work</button>
<a href="/admin/work" class="btn btn-secondary">Back</a>

</form>

@endsection
