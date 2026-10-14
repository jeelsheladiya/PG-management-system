@extends('admin.master')
@section('title') Edit Notice @endsection

@section('body')

    <h3>Edit Notice</h3>

    <form method="POST" action="/admin/notices/{{ $notice->NoticeID }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="Title" value="{{ $notice->Title }}" class="form-control" required maxlength="35">
        </div>

        <div class="mb-3">
            <label>Message</label>
            <textarea name="Message" class="form-control" required maxlength="100">{{ $notice->Message }}</textarea>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="/admin/notices" class="btn btn-secondary">Back</a>

    </form>

@endsection