@extends('member.master')

@section('title', 'My Room')
@section('page-title', 'My Room Details')

@section('body')

    @if(!$allocation)
        <div class="alert alert-warning shadow-sm">
            You have not been allotted a room yet.
        </div>
    @else

        <div class="row g-4">

            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="mb-3 text-primary">
                            <i class="bi bi-door-open"></i> Room Information
                        </h5>

                        <p><strong>Room Number:</strong> {{ $allocation->room->RoomNumber }}</p>
                        <p><strong>Floor:</strong> {{ $allocation->room->Floor }}</p>
                        <p><strong>Capacity:</strong> {{ $allocation->room->Capacity }}</p>

                        <p><strong>Status:</strong>
                            @if($allocation->Status == 'Active')
                                <span class="badge bg-success">Active</span>
                            @elseif($allocation->Status == 'LeaveRequested')
                                <span class="badge bg-warning text-dark">Leave Requested</span>
                            @elseif($allocation->Status == 'Left')
                                <span class="badge bg-secondary">Left</span>
                            @else
                                <span class="badge bg-info">{{ $allocation->Status }}</span>
                            @endif
                        </p>

                        <hr>
                        {{-- 🔴 ACTION BUTTONS --}}
                        @if($allocation)
                            <div class="mt-4 d-flex flex-column flex-md-row justify-content-center gap-3">

                                {{-- રૂમ ચેન્જ કરવાનું બટન --}}
                                <a href="{{ route('member.room.change.form') }}" class="btn btn-primary btn-lg px-4 shadow-sm">
                                    <i class="bi bi-arrow-left-right me-2"></i>Change Room
                                </a>

                                {{-- રૂમ ખાલી કરવાનું બટન (પહેલા હતું એ જ) --}}
                                <button type="button" class="btn btn-danger btn-lg px-4 shadow-sm"
                                    onclick="leaveRoom('{{ $allocation->AllocationID }}')">
                                    <i class="bi bi-box-arrow-right me-2"></i>Vacate Room
                                </button>

                            </div>
                        @endif


                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="mb-3 text-success">
                            <i class="bi bi-people"></i> Occupancy Details
                        </h5>

                        <p><strong>Current Occupancy:</strong>
                            {{ $occupancy->CurrentOccupancy ?? 'N/A' }}
                        </p>

                        <p><strong>Vacant Beds:</strong>
                            {{ ($occupancy->VacantBeds ?? 0) }}
                        </p>

                        <p><strong>Allocated On:</strong> {{ $allocation->AllocationDate }}</p>
                    </div>
                </div>
            </div>

        </div>

    @endif

    @if($allocation && $allocation->payment)
        <div class="card mt-4 shadow-sm">
            <div class="card-header bg-success text-white">
                💳 Payment Details
            </div>
            <div class="card-body">
                <p><strong>Stay Period:</strong>
                    {{ $allocation->AllocationDate }} →
                    {{ $allocation->ReleaseDate }}
                </p>

                <p><strong>Total Amount:</strong>
                    ₹ {{ $allocation->payment->TotalAmount }}
                </p>

                <p><strong>Payment Mode:</strong>
                    {{ $allocation->payment->PaymentMode }}
                </p>

                <p>
                    <span class="badge bg-success">Paid</span>
                </p>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    {{-- SweetAlert2 Library --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function leaveRoom(allocationId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Are you sure you want to vacate the room? This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, Vacate it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // લોડિંગ બતાવવા માટે
                    Swal.showLoading();

                    fetch("{{ url('/member/leave-room') }}/" + allocationId, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'pending_fees') {
                                Swal.fire({
                                    title: 'Fees Pending!',
                                    text: data.message,
                                    icon: 'error',
                                    showCancelButton: true,
                                    confirmButtonColor: '#198754',
                                    confirmButtonText: 'Pay Now',
                                    cancelButtonText: 'Later'
                                }).then((payResult) => {
                                    if (payResult.isConfirmed) {
                                        window.location.href = '/member/payments';
                                    }
                                });
                            } else if (data.status === 'success') {
                                Swal.fire({
                                    title: 'Success!',
                                    text: data.message,
                                    icon: 'success'
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Error!', data.message, 'error');
                            }
                        })
                        .catch(error => {
                            Swal.fire('Error!', 'Something went wrong. Check the server.', 'error');
                        });
                }
            })
        }
    </script>
@endpush