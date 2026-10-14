
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Confirm Member Details</h5>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('rooms.confirmMember', $room->RoomID) }}">
                @csrf

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="Name" class="form-control"
                               value="{{ $member->Name ?? '' }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="Email" class="form-control"
                               value="{{ $member->Email ?? '' }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Adhaar Number</label>
                        <input type="text" name="AdhaarNumber" class="form-control"
                               value="{{ $member->AdhaarNumber ?? '' }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Phone</label>
                        <input type="text" name="Phone" class="form-control"
                               value="{{ $member->Phone ?? '' }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Parents Mobile</label>
                        <input type="text" name="ParentsMobile" class="form-control"
                               value="{{ $member->ParentsMobile ?? '' }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Course</label>
                        <input type="text" name="Course" class="form-control"
                               value="{{ $member->Course ?? '' }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Date of Birth</label>
                        <input type="date" name="DOB" class="form-control"
                               value="{{ $member->DOB ?? '' }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Gender</label>
                        <select name="Gender" class="form-select" required>
                            <option value="">Select</option>
                            <option value="M" {{ ($member->Gender ?? '') == 'M' ? 'selected' : '' }}>Male</option>
                            <option value="F" {{ ($member->Gender ?? '') == 'F' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Pincode</label>
                        <input type="text" name="Pincode" class="form-control"
                               value="{{ $member->Pincode ?? '' }}" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Address</label>
                        <textarea name="Address" class="form-control" rows="2" required>{{ $member->Address ?? '' }}</textarea>
                    </div>

                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-success px-4">
                        Confirm & Proceed to Payment
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

