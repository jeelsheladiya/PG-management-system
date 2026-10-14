<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title') | PGMS Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f8fafc;
        }

        .navbar-brand {
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .nav-link {
            font-weight: 500;
        }

        .badge-notify {
            font-size: 10px;
            padding: 4px 6px;
        }

        .fade-out {
            opacity: 0;
            transition: opacity 0.8s ease-out;
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>

<body>

    @php
        $pendingLeaveRequests = \App\Models\RoomAllocation::where('Status', 'LeaveRequested')->count();
    @endphp

    <!-- 🔷 NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="/admin/dashboard">
                <i class="bi bi-building"></i> PG Management
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">

                    <li class="nav-item">
                        <a class="nav-link" href="/admin/dashboard">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/admin/rooms">
                            <i class="bi bi-door-open"></i> Rooms
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/admin/members">
                            <i class="bi bi-people"></i> Members
                        </a>
                    </li>

                    <!-- 💰 PRICING -->
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/pricing">
                            <i class="bi bi-currency-rupee"></i> Pricing
                        </a>
                    </li>

                    @php
                        $pendingLeaveRequests = \App\Models\RoomAllocation::where('Status', 'LeaveRequested')->count();
                        // 🆕 રૂમ ચેન્જની પેન્ડિંગ વિનંતીઓ ગણવા માટે
                        $pendingChangeRequests = \App\Models\RoomChangeRequest::where('Status', 'Pending')->count();
                    @endphp


                    <li class="nav-item">
                        <a class="nav-link" href="/admin/allocations">
                            <i class="bi bi-diagram-3"></i> Allotments
                        </a>
                    </li>

                    <li class="nav-item position-relative">
                        <a class="nav-link" href="/admin/room-changes">
                            <i class="bi bi-arrow-left-right"></i> Room Changes
                           
                        </a>
                    </li>
                    <!-- <li class="nav-item position-relative">
                        <a class="nav-link" href="/admin/leave-requests">
                            <i class="bi bi-box-arrow-right"></i> Leave Requests
                            @if($pendingLeaveRequests > 0)
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark badge-notify">
                                    {{ $pendingLeaveRequests }}
                                </span>
                            @endif
                        </a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/payments">
                            <i class="bi bi-credit-card"></i> Payments
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/admin/staff">
                            <i class="bi bi-person-badge"></i> Staff
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/admin/work">
                            <i class="bi bi-list-check"></i> Work
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/admin/complaints">
                            <i class="bi bi-exclamation-circle"></i> Complaints
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/admin/notices">
                            <i class="bi bi-megaphone"></i> Notices
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/admin/amenities">
                            <i class="bi bi-stars"></i> Amenities
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/admin/reports">
                            <i class="bi bi-bar-chart-line"></i> Reports
                        </a>
                    </li>

                    <li class="nav-item ms-lg-3">
                        <a class="nav-link text-warning" href="/admin/logout">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <!-- 🔷 CONTENT -->
    <div class="container mt-4">
        @include('components.alerts')
        @yield('body')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        setTimeout(function () {
            let alerts = document.querySelectorAll('.auto-close');
            alerts.forEach(function (alert) {
                alert.classList.add('fade-out');
                setTimeout(function () {
                    let bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 800);
            });
        }, 3000);
    </script>

</body>

</html>