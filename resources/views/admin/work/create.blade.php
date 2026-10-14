@extends('admin.master')
@section('title') Assign Work @endsection
@section('body')

<h2>Assign Work</h2>

<form method="POST" action="/admin/work">
@csrf

<div class="mb-3">
    <label>Staff</label>
    <select name="StaffID" class="form-control" required>
        @foreach($staff as $s)
            <option value="{{ $s->StaffID }}">{{ $s->Name }} ({{ $s->Role }})</option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Work Type</label>
    <input type="text" name="WorkType" class="form-control" required>
</div>

<div class="mb-3">
    <label>Description</label>
    <textarea name="Description" class="form-control" required></textarea>
</div>

<div class="mb-3">
    <label>Status</label>
    <select name="Status" class="form-control">
        <option value="Pending">Pending</option>
        <option value="In Progress">In Progress</option>
        <option value="Completed">Completed</option>
    </select>
</div>

<button class="btn btn-primary">Assign Work</button>
<a href="/admin/work" class="btn btn-secondary">Back</a>

</form>

@endsection
