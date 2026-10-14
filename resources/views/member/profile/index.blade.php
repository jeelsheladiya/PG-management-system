@extends('member.master')

@section('title', 'My Profile')
@section('page-title', 'Profile')
@section('body')
    <div class="container mt-4">
        

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('member.profile.update') }}" enctype="multipart/form-data">
            @csrf

            <div class="card shadow border-0" style="border-radius: 15px;">
                <div class="card-body p-4">

                    <div class="text-center mb-4">
                        <div class="position-relative d-inline-block">
                            <img id="profilePreview"
                                src="{{ $member->ProfilePic ? asset('uploads/profile_pics/' . $member->ProfilePic) : asset('assets/img/default-avatar.png') }}"
                                class="rounded-circle border shadow-sm"
                                style="width: 120px; height: 120px; object-fit: cover;">

                            <label for="ProfilePic"
                                class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-2 shadow"
                                style="cursor: pointer; width: 35px; height: 35px; line-height: 20px;">
                                <i class="bi bi-camera-fill"></i>
                                <input type="file" name="ProfilePic" id="ProfilePic" class="d-none" accept="image/*"
                                    onchange="previewImage(this)">
                            </label>
                        </div>
                        <p class="small text-muted mt-2">Click camera icon to change photo</p>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Name</label>
                            <input class="form-control bg-light" value="{{ $member->Name }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <input class="form-control bg-light" value="{{ $member->Email }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Aadhaar Number</label>
                            <input class="form-control bg-light" value="{{ $member->AdhaarNumber }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Update Aadhaar Copy (PDF/JPG)</label>
                            <input type="file" name="AdhaarFile"
                                class="form-control @error('AdhaarFile') is-invalid @enderror">
                            @error('AdhaarFile') <div class="invalid-feedback">{{ $message }}</div> @enderror

                            {{-- secure link to view adhaar file --}}
                            @if($member->AdhaarFile)
                                <div class="mt-2">
                                    <a href="{{ route('member.view-adhaar', $member->AdhaarFile) }}" target="_blank"
                                        class="btn btn-primary">
                                        <i class="bi bi-file-earmark-lock"></i> View Adhaar Card
                                    </a>

                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Phone</label>
                            <input name="Phone" class="form-control @error('Phone') is-invalid @enderror"
                                value="{{ old('Phone', $member->Phone) }}">
                            @error('Phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Parents Mobile</label>
                            <input name="ParentsMobile" class="form-control @error('ParentsMobile') is-invalid @enderror"
                                value="{{ old('ParentsMobile', $member->ParentsMobile) }}">
                            @error('ParentsMobile') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Address</label>
                        <textarea name="Address" class="form-control @error('Address') is-invalid @enderror"
                            rows="2">{{ old('Address', $member->Address) }}</textarea>
                        @error('Address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Pincode</label>
                            <input name="Pincode" class="form-control @error('Pincode') is-invalid @enderror"
                                value="{{ old('Pincode', $member->Pincode) }}">
                            @error('Pincode') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <!-- <div class="col-md-6">
                            <label class="form-label fw-semibold">DOB</label>
                            <input type="date"class="form-control bg-light" value="{{ $member->DOB }}">
                        </div> -->
                        <!-- <div class="col-md-4">
                            <label class="form-label fw-semibold">Gender</label>
                            <input class="form-control bg-light" value="{{ $member->Gender }}">
                        </div> -->
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 shadow-sm fw-bold">
                        <i class="bi bi-save me-2"></i>Update Profile
                    </button>

                </div>
            </div>
        </form>
    </div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('profilePreview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection