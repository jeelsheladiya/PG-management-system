@extends('admin.master')
@section('title', 'Analytics & Reports')

@push('styles')
    <style>
        .report-card {
            border: none;
            border-radius: 15px;
            transition: all 0.3s ease;
        }

        .report-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .icon-box {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 15px;
        }

        .bg-gradient-primary {
            background: linear-gradient(45deg, #4e73df, #224abe);
        }

        .bg-gradient-success {
            background: linear-gradient(45deg, #1cc88a, #13855c);
        }

        .bg-gradient-info {
            background: linear-gradient(45deg, #36b9cc, #258391);
        }

        .bg-gradient-warning {
            background: linear-gradient(45deg, #f6c23e, #dda20a);
        }

        .bg-gradient-danger {
            background: linear-gradient(45deg, #e74a3b, #be2617);
        }

        canvas {
            max-height: 250px;
        }
    </style>
@endpush

@section('body')

    <div class="container-fluid p-0">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-0">Analytics Dashboard</h2>
                <p class="text-muted small">Real-time insights for My Home PG</p>
            </div>
            <a href="{{ route('admin.reports.pdf') }}" class="btn btn-primary">
                <i class="fas fa-file-pdf me-2"></i> Download PDF Report
            </a>
        </div>

        {{-- Main Stats --}}
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card report-card shadow-sm h-100 p-3">
                    <div class="icon-box bg-light-primary text-primary border"><i class="fas fa-indian-rupee-sign"></i>
                    </div>
                    <h6 class="text-muted mb-1">Total Revenue</h6>
                    <h3 class="fw-bold">₹{{ number_format($totalPayments) }}</h3>
                    <p class="text-success small mb-0"><i class="fas fa-arrow-up"></i> This Month:
                        ₹{{ number_format($thisMonthRevenue) }}</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card report-card shadow-sm h-100 p-3">
                    <div class="icon-box bg-light-success text-success border"><i class="fas fa-bed"></i></div>
                    <h6 class="text-muted mb-1">Occupancy</h6>
                    <h3 class="fw-bold">{{ $occupancyPercent }}%</h3>
                    <div class="progress mt-2" style="height: 6px;">
                        <div class="progress-bar bg-success" style="width: <?= $occupancyPercent ?>%"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card report-card shadow-sm h-100 p-3">
                    <div class="icon-box bg-light-danger text-danger border"><i class="fas fa-clock"></i></div>
                    <h6 class="text-muted mb-1">Pending Dues</h6>
                    <h3 class="fw-bold text-danger">₹{{ number_format($pendingPayments) }}</h3>
                    <p class="text-muted small mb-0">Needs follow-up</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card report-card shadow-sm h-100 p-3">
                    <div class="icon-box bg-light-warning text-warning border"><i class="fas fa-exclamation-circle"></i>
                    </div>
                    <h6 class="text-muted mb-1">Complaints</h6>
                    <h3 class="fw-bold text-warning">{{ $openComplaints }}</h3>
                    <p class="text-muted small mb-0">Awaiting resolution</p>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            {{-- Charts Section --}}
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 p-4">
                    <h5 class="fw-bold mb-4">Financial & Occupancy Mix</h5>
                    <div class="row">
                        <div class="col-md-6 text-center">
                            <p class="small text-muted mb-1">Bed Distribution</p>
                            <canvas id="bedChart"></canvas>
                        </div>
                        <div class="col-md-6 text-center">
                            <p class="small text-muted mb-1">Payment Status (Amounts)</p>
                            <canvas id="paymentChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Operations Summary --}}
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 p-4 h-100">
                    <h5 class="fw-bold mb-4">Operational Status</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span><i class="fas fa-users me-2 text-primary"></i>Total Members</span>
                            <span class="badge bg-primary rounded-pill">{{ $totalMembers }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span><i class="fas fa-user-tie me-2 text-info"></i>Total Staff</span>
                            <span class="badge bg-info rounded-pill">{{ $totalStaff }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span><i class="fas fa-tasks me-2 text-warning"></i>Pending Work</span>
                            <span class="badge bg-warning text-dark rounded-pill">{{ $pendingWorks }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span><i class="fas fa-door-open me-2 text-secondary"></i>Vacant Beds</span>
                            <span class="badge bg-secondary rounded-pill">{{ $vacantBeds }}</span>
                        </li>
                    </ul>
                    <!-- <div class="mt-4 p-3 bg-light rounded text-center">
                        <p class="mb-0 small text-muted">System Health</p>
                        <h5 class="text-success fw-bold">Active & Secure</h5>
                    </div> -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Bed Chart - Doughnut Style
        new Chart(document.getElementById('bedChart'), {
            type: 'doughnut',
            data: {
                labels: ['Occupied', 'Vacant'],
                datasets: [{
                    data: <?= json_encode([$occupiedBeds, $vacantBeds]) ?>,
                    backgroundColor: ['#1cc88a', '#e1e1e1'],
                    hoverOffset: 4
                }]
            },
            options: { plugins: { legend: { position: 'bottom' } } }
        });

        // Payment Chart - Bar Style
        new Chart(document.getElementById('paymentChart'), {
            type: 'pie',
            data: {
                labels: ['Received (₹)', 'Pending (₹)'],
                datasets: [{
                    data: <?= json_encode([$totalPayments, $pendingPayments]) ?>,
                    backgroundColor: ['#4e73df', '#e74a3b']
                }]
            },
            options: { plugins: { legend: { position: 'bottom' } } }
        });
    </script>

@endsection