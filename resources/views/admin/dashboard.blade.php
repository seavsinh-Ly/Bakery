<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bakery Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --ink: #242321; --gold: #b38a4c; --cream: #f7f4ee; --line: #e8e2d7; }
        body { background: var(--cream); color: var(--ink); font-family: Inter, Arial, sans-serif; }
        .sidebar { background: var(--ink); min-height: 100vh; color: #fff; }
        .brand { color: #fff; font: 1.7rem Georgia, serif; letter-spacing: .04em; }
        .brand small { display: block; color: #d4b77f; font: 700 .58rem Inter, sans-serif; letter-spacing: .2em; text-transform: uppercase; }
        .nav-link { color: #aaa6a0; border-radius: 8px; padding: .75rem 1rem; }
        .nav-link:hover, .nav-link.active { color: #fff; background: rgba(255,255,255,.1); }
        .gold { color: var(--gold); }
        .stat, .panel { background: #fff; border: 1px solid var(--line); border-radius: 14px; }
        .stat { padding: 1.3rem; }
        .stat-value { font: 2rem Georgia, serif; }
        .eyebrow { color: var(--gold); font-size: .7rem; font-weight: 700; letter-spacing: .18em; text-transform: uppercase; }
        .btn-gold { background: var(--ink); color: #fff; border-radius: 999px; }
        .btn-gold:hover { background: var(--gold); color: #fff; }
        @media (max-width: 767px) { .sidebar { min-height: auto; } }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <aside class="col-md-3 col-lg-2 sidebar p-3">
                <a class="brand text-decoration-none d-block mb-4" href="{{ route('admin.dashboard') }}">Bakery<small>admin studio</small></a>
                <div class="eyebrow mb-2">Workspace</div>
                <nav class="nav flex-column gap-1">
                    <a class="nav-link active" href="{{ route('admin.dashboard') }}">Dashboard</a>
                    <a class="nav-link" href="{{ route('admin.products.index') }}">Products</a>
                    <a class="nav-link" href="{{ route('admin.categories.index') }}">Categories</a>
                    <a class="nav-link" href="{{ route('admin.invitations.index') }}">Invitations</a>
                    <a class="nav-link" href="{{ route('bakery.menu') }}">Storefront</a>
                    <a class="nav-link" href="{{ route('admin.password.edit') }}">Reset Admin Password</a>
                    <a class="nav-link" href="{{ route('admin.customers.password.edit') }}">Reset customer password</a>
                </nav>
                <form action="{{ route('logout') }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" class="btn btn-outline-light rounded-pill w-100">Sign out</button>
                </form>
            </aside>
            <main class="col-md-9 col-lg-10 p-4 p-lg-5">
                <div class="d-flex flex-wrap justify-content-between align-items-end mb-4">
                    <div><div class="eyebrow mb-2">Good morning, {{ auth()->user()->name }}</div><h1 class="h2 mb-0">Dashboard overview</h1></div>
                    <span class="text-muted small">{{ now()->format('l, F j, Y') }}</span>
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-sm-6 col-xl-3"><div class="stat"><div class="text-muted small">Total revenue</div><div class="stat-value">${{ number_format($totalRevenue ?? 0, 2) }}</div></div></div>
                    <div class="col-sm-6 col-xl-3"><div class="stat"><div class="text-muted small">Orders</div><div class="stat-value">{{ $totalOrders }}</div></div></div>
                    <div class="col-sm-6 col-xl-3"><div class="stat"><div class="text-muted small">Products</div><div class="stat-value">{{ $totalProducts }}</div></div></div>
                    <div class="col-sm-6 col-xl-3"><div class="stat"><div class="text-muted small">Customers</div><div class="stat-value">{{ $customers }}</div></div></div>
                </div>
                <div class="d-flex gap-2 mb-4 flex-wrap">
                    <a href="{{ route('admin.products.create') }}" class="btn btn-gold px-4">Add product</a>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-dark rounded-pill px-4">New category</a>
                </div>
                <section class="panel p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3"><h2 class="h5 mb-0">Recent orders</h2><span class="eyebrow">{{ $pendingOrders }} pending</span></div>
                    @if($recentOrders->isEmpty())
                        <p class="text-muted mb-0">No orders yet.</p>
                    @else
                        <div class="table-responsive"><table class="table align-middle mb-0"><thead><tr><th>Order</th><th>Customer</th><th>Total</th><th>Status</th></tr></thead><tbody>
                            @foreach($recentOrders as $order)
                                <tr><td class="fw-semibold">{{ $order->order_number }}</td><td>{{ $order->user->name ?? 'Customer' }}</td><td>${{ number_format($order->total_amount, 2) }}</td><td><span class="badge rounded-pill text-bg-light">{{ ucfirst($order->status) }}</span></td></tr>
                            @endforeach
                        </tbody></table></div>
                    @endif
                </section>
            </main>
        </div>
    </div>
</body>
</html>
