<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login | PGMS</title>

    <!-- Bootstrap CSS -->
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
        rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" 
        rel="stylesheet">

        <style>
            body {
                background-color: #f5f6fa; /* soft grey */
                min-height: 100vh;
            }
        </style>
        
</head>
<body class="d-flex align-items-center justify-content-center">

<div class="card shadow-lg border-0" style="width: 380px;">
    <div class="card-body p-4">

        <div class="text-center mb-4">
            <i class="bi bi-shield-lock fs-1 text-primary"></i>
            <h4 class="mt-2">Admin Login</h4>
            <p class="text-muted mb-0">PG Management System</p>
        </div>

        @if(session('error'))
            <div class="alert alert-danger text-center">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="/admin/login">
            @csrf

            <div class="mb-3">
                <label class="form-label">Username</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-person"></i>
                    </span>
                    <input 
                        type="text" 
                        name="username" 
                        class="form-control"
                        placeholder="Enter username"
                        required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input 
                        type="password" 
                        name="password" 
                        class="form-control"
                        placeholder="Enter password"
                        required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-box-arrow-in-right"></i> Login
            </button>
        </form>

    </div>
</div>

</body>
</html>
