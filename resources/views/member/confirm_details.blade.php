<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Confirm Member Details</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light py-5">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white fw-bold">
                        Confirm Member Details
                    </div>

                    <div class="card-body p-4">
                        <form method="POST"
                            action="{{ route('rooms.confirm.payment.preview', $allocation->AllocationID) }}"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" class="form-control" name="Name"
                                        value="{{ old('Name', $member->Name) }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="Email"
                                        value="{{ old('Email', $member->Email) }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Adhaar Number</label>
                                    <input type="text" class="form-control" name="AdhaarNumber"
                                        value="{{ old('AdhaarNumber', $member->AdhaarNumber) }}" maxlength="12"
                                        required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Profile Picture (Optional)</label>
                                    <input type="file" class="form-control" name="profile_pic" accept="image/*">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label text-danger fw-bold">Adhaar Card Copy * (Required)</label>
                                    <input type="file" class="form-control" name="adhaar_file" accept="image/*"
                                        required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Parents Mobile</label>
                                    <input type="text" class="form-control" name="ParentsMobile"
                                        value="{{ old('ParentsMobile', $member->ParentsMobile) }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-danger">Booking Start Date *</label>
                                    <input type="date" class="form-control" name="book_date"
                                        value="{{ old('book_date', now()->format('Y-m-d')) }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-danger">Leaving Date *</label>
                                    <input type="date" class="form-control" name="leave_date"
                                        value="{{ old('leave_date') }}" required>
                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-success px-4">Confirm & Proceed to Payment</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>