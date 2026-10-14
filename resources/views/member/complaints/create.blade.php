@extends('member.master')

@section('title', 'Raise Complaint')
@section('page-title', 'Raise Complaint')

@section('body')

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show auto-close">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="/member/complaints/store">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Select Issue Category</label>
                    <select name="Category" class="form-select" required>
                        <option value="">-- Select Category --</option>
                        <option value="Plumber">Plumber</option>
                        <option value="Electrician">Electrician</option>
                        <option value="Carpenter">Carpenter</option>
                        <option value="Chef">Chef</option>
                        <option value="Cleaner">Cleaner</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Describe Your Issue</label>
                    <textarea name="ComplainText" class="form-control" rows="4" required></textarea>
                </div>

                <button class="btn btn-success">Submit Complaint</button>
                <a href="/member/complaints" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>

@endsection