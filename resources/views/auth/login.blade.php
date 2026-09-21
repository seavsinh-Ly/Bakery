<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in | Bakery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { min-height: 100vh; background: linear-gradient(135deg, #fffaf3, #f4d7ad); font-family: Arial, sans-serif; }
        .auth-card { max-width: 460px; margin: 7rem auto; padding: 2.5rem; border: 0; border-radius: 22px; background: #fff; box-shadow: 0 18px 45px rgba(116, 80, 38, .14); }
        .brand { color: #8a5a25; letter-spacing: .08rem; text-transform: uppercase; font-size: .8rem; font-weight: 700; }
        .form-control { border-radius: 12px; padding: .75rem 1rem; }
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
                <h1 class="h2 fw-bold mt-2">Welcome back</h1>
                <p class="text-muted mb-0">Sign in to manage and explore the bakery.</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 ps-3">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold" for="email">Email address</label>
                    <input class="form-control" id="email" name="email" type="email" value="{{ old('email') }}" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold" for="password">Password</label>
                    <input class="form-control" id="password" name="password" type="password" required>
                </div>
                <div class="form-check mb-4">
                    <input class="form-check-input" id="remember" name="remember" type="checkbox" value="1">
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>
                <button class="btn btn-bakery w-100" type="submit">Sign in</button>
            </form>
            <p class="text-center text-muted mt-4 mb-0">New here? <a href="{{ route('register') }}">Create an account</a></p>
        </div>
    </main>
</body>
</html>
