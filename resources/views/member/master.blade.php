<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Member Panel') | PGMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f1f5f9;
        }

        /* Sidebar */
        .sidebar {
            min-height: 100vh;
            background: #0f172a;
            color: #cbd5e1;
        }

        .sidebar a {
            color: #cbd5e1;
            text-decoration: none;
            padding: 12px 15px;
            display: block;
            border-radius: 6px;
            font-size: 15px;
        }

        .sidebar a:hover {
            background: #1e293b;
            color: #fff;
        }

        .sidebar .active {
            background: #0d6efd;
            color: white;
        }

        .topbar {
            background: white;
            border-bottom: 1px solid #ddd;
        }

        .card {
            border-radius: 12px;
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row">

            <!-- Sidebar (Desktop) -->
            <nav class="col-md-2 d-none d-md-block sidebar p-3">
                <h4 class="text-center mb-4 text-white">PGMS</h4>

                <a href="/member/dashboard" class="{{ request()->is('member/dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>

                <a href="/member/rooms" class="{{ request()->is('member/rooms*') ? 'active' : '' }}">
                    <i class="bi bi-building"></i> View Rooms
                </a>

                <a href="/member/my-room" class="{{ request()->is('member/my-room') ? 'active' : '' }}">
                    <i class="bi bi-door-open"></i> My Room
                </a>

                <a href="/member/amenities" class="{{ request()->is('member/amenities*') ? 'active' : '' }}">
                    <i class="bi bi-stars"></i> Amenities
                </a>

                <a href="/member/payments" class="{{ request()->is('member/payments*') ? 'active' : '' }}">
                    <i class="bi bi-credit-card"></i> Payments
                </a>

                <a href="/member/complaints" class="{{ request()->is('member/complaints*') ? 'active' : '' }}">
                    <i class="bi bi-exclamation-triangle"></i> Complaints
                </a>

                <a href="/member/notices" class="{{ request()->is('member/notices*') ? 'active' : '' }}">
                    <i class="bi bi-megaphone"></i> Notices
                </a>

                <a href="/member/profile" class="{{ request()->is('member/profile') ? 'active' : '' }}">
                    <i class="bi bi-person-circle"></i> Profile
                </a>

                <hr class="text-secondary">

                <a href="/member/logout" class="text-danger">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </nav>


            <!-- Main Area -->
            <main class="col-md-10 ms-sm-auto px-md-4 p-0">

                <!-- Topbar -->
                <div class="topbar p-3 d-flex justify-content-between align-items-center">

                    <!-- Mobile Menu Button -->
                    <button class="btn btn-outline-primary d-md-none" data-bs-toggle="offcanvas"
                        data-bs-target="#mobileMenu">
                        <i class="bi bi-list"></i>
                    </button>

                    <h5 class="mb-0">@yield('page-title')</h5>

                    <div>
                        👋 Hi, <strong>{{ session('member_name') }}</strong>
                    </div>
                </div>

                <!-- Page Content -->
                <div class="p-4">
                    @yield('body')
                </div>

            </main>
        </div>
    </div>

    <!-- 📱 Mobile Sidebar -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">PGMS Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <a href="/member/dashboard" class="d-block mb-2">Dashboard</a>
            <a href="/member/complaints" class="d-block mb-2">My Complaints</a>
            <a href="/member/payments" class="d-block mb-2">Payments</a>
            <a href="/member/notices" class="d-block mb-2">Notices</a>
            <a href="/member/profile" class="d-block mb-2">Profile</a>
            <hr>
            <a href="/member/logout" class="text-danger d-block">Logout</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @stack('scripts') 
</body>

</html>