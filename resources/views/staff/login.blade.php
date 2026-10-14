<!DOCTYPE html>
<html>
<head>
    <title>Staff Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: linear-gradient(135deg, #667eea, #764ba2);">

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    
    <div class="card shadow-lg border-0" style="width: 400px;">
        <div class="card-body p-4">

            <h3 class="text-center mb-4">Staff Login</h3>

            @if(session('error'))
                <div class="alert alert-danger text-center">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="/staff/login">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="Email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="Password" class="form-control" required>
                </div>

                <div class="d-grid">
                    <button class="btn btn-primary">Login</button>
                </div>

            </form>

        </div>
    </div>

</div>

</body>
</html>
