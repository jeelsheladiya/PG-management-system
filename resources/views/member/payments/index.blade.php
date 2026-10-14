@extends('member.master')
@section('title', 'Payment History')
@section('page-title', 'Payment History')
@push('styles')
    <style>
        .payment-card {
            border-radius: 15px;
            border: none;
            overflow: hidden;
        }

        .table thead {
            background-color: #f8f9fa;
            color: #6c757d;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table-hover tbody tr:hover {
            background-color: #fcfdfe;
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .amount-paid {
            color: #198754;
            font-weight: 700;
            font-size: 1rem;
        }

        .amount-pending {
            color: #dc3545;
            font-weight: 700;
            font-size: 0.95rem;
        }

        .receipt-btn {
            border-radius: 6px;
            transition: 0.2s;
            font-size: 0.85rem;
        }

        .receipt-btn:hover {
            background-color: #dc3545;
            color: white;
            transform: translateY(-1px);
        }

        .swal2-popup {
            border-radius: 15px !important;
        }
    </style>
@endpush

@section('body')
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="container-fluid py-4">
        <div class="card shadow-sm payment-card">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="bi bi-shield-check text-primary me-2"></i>Payment History
                </h5>
                <span class="badge bg-light text-muted border px-3">Total: {{ $payments->total() }}</span>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">Details & Mode</th>
                                <th>Stay Period</th>
                                <th>Total Rent</th>
                                <th>Paid Amount</th>
                                <!-- <th>Pending Due</th> -->
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($payments as $p)
                                @php
                                    $pendingAmount = $p->RentAmount - $p->TotalAmount;
                                @endphp
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark mb-0">{{ $p->PaymentFor }}</div>
                                        <div class="small text-muted d-flex align-items-center">
                                            <span>{{ \Carbon\Carbon::parse($p->PaymentDate)->format('d-m-Y') }}</span>
                                            <span class="mx-2 text-silver">|</span>
                                            <i class="bi bi-credit-card-2-front me-1"></i>{{ $p->PaymentMode }}
                                        </div>
                                    </td>

                                    <td>
                                        <div class="small text-dark">
                                            {{ \Carbon\Carbon::parse($p->PeriodStart)->format('d M') }} -
                                            {{ \Carbon\Carbon::parse($p->PeriodEnd)->format('d M, Y') }}
                                        </div>
                                    </td>

                                    <td class="text-muted small">₹{{ number_format($p->RentAmount, 2) }}</td>
                                    <td><span class="amount-paid">₹{{ number_format($p->TotalAmount, 2) }}</span></td>

                                    
                                    <td>
                                        {{-- To show pending amount and payment button based on pending amount --}}
                                        @if($p->live_pending > 0)
                                            <div class="d-flex flex-column">
                                                <span class="amount-pending mb-1">₹{{ number_format($p->live_pending, 2) }}</span>

                                                <form action="{{ route('pending.payment.store', $p->AllocationID) }}" method="POST"
                                                    class="pay-now-form">
                                                    @csrf
                                                    <input type="hidden" name="amount" value="{{ $p->live_pending }}">
                                                    <input type="hidden" name="payment_mode" value="Online">
                                                    <button type="button" class="btn btn-sm btn-success py-0 px-2 shadow-sm pay-btn"
                                                        style="font-size: 0.7rem;">
                                                        <i class="bi bi-credit-card"></i> Pay Now
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span
                                                class="badge bg-success-subtle text-success border border-success-subtle small px-2">
                                                <i class="bi bi-check2-all me-1"></i>Cleared
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        {{-- To show status based on pending amount --}}
                                        @if($p->live_pending <= 0)
                                            <span
                                                class="status-badge bg-success-subtle text-success border border-success-subtle">Fully
                                                Paid</span>
                                        @else
                                            <span
                                                class="status-badge bg-warning-subtle text-warning-emphasis border border-warning-subtle">Partial</span>
                                        @endif
                                    </td>

                                    {{-- Action Column --}}
                                    <td class="text-center pe-4">
                                        <a href="{{ route('member.payments.receipt', $p->PaymentID) }}" target="_blank"
                                            class="btn btn-sm btn-outline-danger px-3 receipt-btn shadow-xs">
                                            <i class="bi bi-file-earmark-pdf"></i> Receipt
                                        </a>
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($payments->hasPages())
                <div class="card-footer bg-white border-top py-3">
                    <div class="d-flex justify-content-center">
                        {{ $payments->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.querySelectorAll('.pay-btn').forEach(button => {
            button.addEventListener('click', function () {
                const form = this.closest('.pay-now-form');
                const amount = form.querySelector('input[name="amount"]').value;

                Swal.fire({
                    title: 'Proceed to Payment?',
                    text: "You are about to pay the pending amount of ₹" + parseFloat(amount).toLocaleString('en-IN'),
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#198754',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, Pay Now',
                    cancelButtonText: 'Cancel',
                    // borderRadius કાઢી નાખ્યું છે, તેની જગ્યાએ આ વાપરો:
                    customClass: {
                        popup: 'rounded-4' // જો Bootstrap વાપરતા હોવ તો, અથવા નીચે મુજબ CSS
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // ફોર્મ સબમિટ કરો
                        // form.submit();

                        // લોડિંગ બતાવો
                        Swal.fire({
                            title: 'Redirecting...',
                            text: 'Please wait while we redirect you to the payment gateway.',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                                form.submit(); // લોડર શરૂ થયા પછી સબમિટ કરો
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection