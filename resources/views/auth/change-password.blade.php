<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change password | Bakery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { min-height: 100vh; background: linear-gradient(135deg, #fffaf3, #f4d7ad); font-family: Arial, sans-serif; }
        .auth-card { max-width: 500px; margin: 6rem auto; padding: 2.5rem; border-radius: 22px; background: #fff; box-shadow: 0 18px 45px rgba(116, 80, 38, .14); }
        .btn-bakery { background: #a86a2f; color: #fff; border-radius: 999px; padding: .75rem; font-weight: 600; }
        .btn-bakery:hover { background: #8b4f24; color: #fff; }
        .form-control { border-radius: 12px; padding: .75rem 1rem; }
        .alert { border-radius: 12px; }
    </style>
</head>
<body>
    <main class="container">
        <div class="auth-card">
            <h1 class="h3 fw-bold mb-2">Change admin password</h1>
            <p class="text-muted mb-4">Confirm your current password, then choose a new one.</p>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 ps-3">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.password.update') }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label fw-semibold" for="current_password">Current password</label>
                    <input class="form-control" id="current_password" name="current_password" type="password" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold" for="password">New password</label>
                    <input class="form-control" id="password" name="password" type="password" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold" for="password_confirmation">Confirm new password</label>
                    <input class="form-control" id="password_confirmation" name="password_confirmation" type="password" required>
                </div>
                <button class="btn btn-bakery w-100" type="submit">Change password</button>
            </form>
            <p class="text-center mt-4 mb-0"><a href="{{ route('admin.dashboard') }}">Back to dashboard</a></p>
        </div>
    </main>
</body>
</html>
