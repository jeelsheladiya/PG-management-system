@extends('admin.master')
@section('title') Post Notice @endsection

@section('body')

    <h3>Post New Notice</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/admin/notices">
        @csrf

        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="Title" class="form-control" required maxlength="35">
        </div>

        <div class="mb-3">
            <label>Message</label>
            <textarea name="Message" class="form-control" required maxlength="100"></textarea>
        </div>

        <button class="btn btn-primary">Post Notice</button>
        <a href="/admin/notices" class="btn btn-secondary">Back</a>

    </form>

@endsection