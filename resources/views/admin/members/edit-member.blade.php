@extends('admin.master')

@section('title') Edit Member @endsection

@section('body')

    <h2>Edit Member Record</h2>

    <!-- @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif -->

    <form method="POST" action="/admin/members/{{ $PGMember->MemberID }}/update">
        @csrf

        @method('PUT')
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="Name" value="{{ $PGMember->Name }}" class="form-control" required>
                @error("Name")
                    <div class="text-danger">
                        *
                    </div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="Email" value="{{ $PGMember->Email }}" class="form-control" required>
                @error("email")
                    <div class="text-danger">
                        *
                    </div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Aadhaar Number</label>
                <input type="text" name="AdhaarNumber" value="{{ $PGMember->AdhaarNumber }}" class="form-control" required>
                @error("AdhaarNumber")
                    <div class="text-danger">
                        *
                    </div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Password <small class="text-muted">(leave blank to keep unchanged)</small></label>

                <input type="password" name="Password" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="Phone" value="{{ $PGMember->Phone }}" class="form-control" required>
                @error("Phone")
                    <div class="text-danger">
                        *
                    </div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Parent Mobile</label>
                <input type="text" name="ParentsMobile" value="{{ $PGMember->ParentsMobile }}" class="form-control"
                    required>
                    @error("ParentsMobile")
                    <div class="text-danger">
                        *
                    </div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Course</label>
                <input type="text" name="Course" value="{{ $PGMember->Course }}" class="form-control" required>
                @error("Course")
                    <div class="text-danger">
                        *
                    </div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">DOB</label>
                <input type="date" name="DOB" value="{{ $PGMember->DOB }}" class="form-control" required>
                @error("DOB")
                    <div class="text-danger">
                        *
                    </div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Gender</label>
                <select name="Gender" class="form-control" required>
                    <option value="M" {{ $PGMember->Gender == 'M' ? 'selected' : '' }}>
                        Male
                    </option>

                    <option value="F" {{ $PGMember->Gender == 'F' ? 'selected' : '' }}>
                        Female
                    </option>
                </select>
            </div>

            <div class="col-md-8 mb-3">
                <label class="form-label">Address</label>
                <textarea name="Address" class="form-control" required>{{ $PGMember->Address }}</textarea>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Pincode</label>
                <input type="number" name="Pincode" value="{{ $PGMember->Pincode }}" class="form-control" required>
                @error("Pincode")
                    <div class="text-danger">
                        *
                    </div>
                @enderror
            </div>
        </div>
        <button class="btn btn-primary">Update</button>
        <a href="/admin/members" class="btn btn-secondary">Back</a>
    </form>

@endsection