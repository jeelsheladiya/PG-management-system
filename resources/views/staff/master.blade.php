<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Staff Panel') | PGMS</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f4f6f9;
        }
        .sidebar {
            height: 100vh;
            background: #1e293b;
            color: white;
        }
        .sidebar a {
            color: #cbd5e1;
            text-decoration: none;
            display: block;
            padding: 12px 15px;
            border-radius: 6px;
        }
        .sidebar a:hover {
            background: #334155;
            color: white;
        }
        .sidebar .active {
            background: #0d6efd;
            color: white;
        }
        .topbar {
            background: white;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
        <div class="col-md-2 sidebar p-3">
            <h4 class="text-center mb-4">PGMS</h4>

            <a href="/staff/dashboard"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a href="/staff/complaints"><i class="bi bi-exclamation-circle"></i> Complaints</a>
            <a href="/staff/work"><i class="bi bi-list-check"></i> My Work</a>
            <a href="/staff/profile"><i class="bi bi-person"></i> Profile</a>

            <hr class="text-secondary">

            <form action="/staff/logout" method="get">
                @csrf
                <button class="btn btn-danger w-100">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>

        <!-- Main Content -->
        <div class="col-md-10 p-0">

            <!-- Topbar -->
            <div class="topbar p-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">@yield('page-title')</h5>

                <div>
                    👋 Welcome, <strong>{{ session('staff_name') }}</strong>
                </div>
            </div>

            <!-- Page Content -->
            <div class="p-4">
                @yield('body')
            </div>

        </div>

    </div>
</div>
<script>
    setTimeout(function () {
        let alerts = document.querySelectorAll('.auto-close');
        alerts.forEach(function(alert) {
            let bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 4000); // 4 seconds
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
