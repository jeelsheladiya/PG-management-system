@extends('member.master')

@section('title', 'Dashboard')
@section('page-title', 'Member Dashboard')

@section('body')

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-center h-100">
                <div class="card-body">
                    <h6 class="text-muted">Your Room</h6>
                    <h3 class="fw-bold">
                        {{ $allocation && $allocation->room ? 'Room ' . $allocation->room->RoomNumber : 'Not Allotted' }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-center bg-warning h-100">
                <div class="card-body">
                    <h6 class="text-dark">Active Complaints</h6>
                    <h2 class="fw-bold">{{ $pendingComplaints }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div
                class="card shadow-sm border-0 text-center {{ $pendingPayments > 0 ? 'bg-danger text-white' : 'bg-success text-white' }} h-100">
                <div class="card-body">
                    <h6>{{ $pendingPayments > 0 ? 'Pending Payments' : 'Payment Status' }}</h6>
                    <h2 class="fw-bold">
                        {!! $pendingPayments > 0 ? '₹' . number_format($pendingPayments, 2) : '<i class="bi bi-check-circle-fill"></i> No Dues' !!}
                    </h2>
                </div>
            </div>
        </div>
    </div>

    @if($allocation)
        <div class="mt-4 text-center">
            {{-- LEAVE BUTTON - AJAX સાથે --}}
            <button type="button" class="btn btn-danger btn-lg px-4 shadow-sm"
                onclick="leaveRoom('{{ $allocation->AllocationID }}')">
                <i class="bi bi-box-arrow-right me-2"></i>Vacate Room
            </button>
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