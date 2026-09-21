<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create account | Bakery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { min-height: 100vh; background: linear-gradient(135deg, #fffaf3, #f4d7ad); font-family: Arial, sans-serif; }
        .auth-card { max-width: 500px; margin: 4rem auto; padding: 2.5rem; border: 0; border-radius: 22px; background: #fff; box-shadow: 0 18px 45px rgba(116, 80, 38, .14); }
        .brand { color: #8a5a25; letter-spacing: .08rem; text-transform: uppercase; font-size: .8rem; font-weight: 700; }
        .form-control, .form-select { border-radius: 12px; padding: .75rem 1rem; }
        .btn-bakery { background: #a86a2f; color: #fff; border-radius: 999px; padding: .75rem; font-weight: 600; }
        .btn-bakery:hover { background: #8b4f24; color: #fff; }
        .alert { border-radius: 12px; }
    </style>
</head>
<body>
    <main class="container">
        <div class="auth-card">
            <div class="text-center mb-4">
                <div class="brand">Freshly baked</div>
                <h1 class="h2 fw-bold mt-2">Create your account</h1>
                <p class="text-muted mb-0">Register before entering the bakery.</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 ps-3">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold" for="name">Full name</label>
                    <input class="form-control" id="name" name="name" type="text" value="{{ old('name') }}" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold" for="email">Email address</label>
                    <input class="form-control" id="email" name="email" type="email" value="{{ old('email') }}" required>
                </div>
                <div class="alert alert-light border mb-4">
                    <small class="text-muted">Admin access is granted only after an invitation and approval process. New registrations are created as customers.</small>
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" for="password">Password</label>
                        <input class="form-control" id="password" name="password" type="password" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" for="password_confirmation">Confirm password</label>
                        <input class="form-control" id="password_confirmation" name="password_confirmation" type="password" required>
                    </div>
                </div>
                <button class="btn btn-bakery w-100" type="submit">Create account</button>
            </form>
            <p class="text-center text-muted mt-4 mb-0">Already registered? <a href="{{ route('login') }}">Sign in</a></p>
        </div>
    </main>
</body>
</html>
