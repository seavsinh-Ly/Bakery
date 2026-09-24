<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset customer password | Bakery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(180deg, #fffaf3 0%, #f8f1e7 100%); font-family: Arial, sans-serif; }
        .page { padding: 70px 0; }
        .panel { border: 0; border-radius: 18px; background: #fff; box-shadow: 0 8px 24px rgba(116,80,38,.08); }
        .form-control { border-radius: 12px; border: 1px solid #e7d9c5; padding: 12px 14px; }
        .submit-btn { background: #a86a2f; border: 0; color: #fff; border-radius: 999px; padding: 10px 20px; font-weight: 600; }
        .submit-btn:hover { background: #8b4f24; color: #fff; }
    </style>
</head>
<body>
    <main class="container page">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h2 fw-bold mb-1">Reset customer password</h1>
                <p class="text-muted mb-0">Select a customer, then choose a new password for that account.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary rounded-pill">Back to dashboard</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger"><ul class="mb-0 ps-3">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif

        <div class="panel p-4">
            @if($customers->isEmpty())
                <p class="text-muted mb-0">No customer accounts found.</p>
            @else
                <form method="POST" action="{{ route('admin.customers.password.update') }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="customer_id">Customer email</label>
                        <select class="form-select" id="customer_id" name="customer_id" required autofocus>
                            <option value="">Select a customer</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" @selected(old('customer_id') == $customer->id)>
                                    {{ $customer->email }} ({{ $customer->name }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="password">New password</label>
                        <input class="form-control" id="password" name="password" type="password" minlength="8" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold" for="password_confirmation">Confirm new password</label>
                        <input class="form-control" id="password_confirmation" name="password_confirmation" type="password" minlength="8" required>
                    </div>
                    <button class="btn submit-btn w-100" type="submit">Reset password</button>
                </form>
            @endif
        </div>
    </main>
</body>
</html>
