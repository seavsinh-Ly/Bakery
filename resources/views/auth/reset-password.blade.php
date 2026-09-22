<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose password | Bakery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { min-height: 100vh; background: linear-gradient(135deg, #fffaf3, #f4d7ad); font-family: Arial, sans-serif; }
        .auth-card { max-width: 460px; margin: 7rem auto; padding: 2.5rem; border-radius: 22px; background: #fff; box-shadow: 0 18px 45px rgba(116, 80, 38, .14); }
        .btn-bakery { background: #a86a2f; color: #fff; border-radius: 999px; padding: .75rem; font-weight: 600; }
        .btn-bakery:hover { background: #8b4f24; color: #fff; }
        .form-control { border-radius: 12px; padding: .75rem 1rem; }
        .alert { border-radius: 12px; }
    </style>
</head>
<body>
    <main class="container">
        <div class="auth-card">
            <h1 class="h3 fw-bold mb-3">Choose a new password</h1>
            @if($errors->any())
                <div class="alert alert-danger"><ul class="mb-0 ps-3">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
            @endif
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="mb-3">
                    <label class="form-label fw-semibold" for="email">Email address</label>
                    <input class="form-control" id="email" name="email" type="email" value="{{ old('email', $email) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold" for="password">New password</label>
                    <input class="form-control" id="password" name="password" type="password" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold" for="password_confirmation">Confirm new password</label>
                    <input class="form-control" id="password_confirmation" name="password_confirmation" type="password" required>
                </div>
                <button class="btn btn-bakery w-100" type="submit">Update password</button>
            </form>
        </div>
    </main>
</body>
</html>
