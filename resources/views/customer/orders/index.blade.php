<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders | Bakery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(180deg,#fffaf3 0%,#f8f1e7 100%); color: #242321; font-family: Arial, sans-serif; }
        .page { padding: 60px 0; }
        .badge-title { background: #f9d9a8; color: #8a5a25; border-radius: 999px; padding: 8px 14px; font-size: .8rem; letter-spacing: .05rem; text-transform: uppercase; }
        .order-card { border: 0; border-radius: 18px; background: #fff; box-shadow: 0 8px 24px rgba(116,80,38,.08); transition: transform .2s, box-shadow .2s; }
        .order-card:hover { transform: translateY(-3px); box-shadow: 0 14px 30px rgba(116,80,38,.12); }
        .order-number { color: #5e3d26; font: 1.2rem Georgia, serif; }
        .muted { color: #827a70; }
        .status { background: #f9d9a8; color: #8a5a25; border-radius: 999px; padding: 6px 12px; font-size: .75rem; font-weight: 700; }
        .price { color: #a86a2f; font-weight: 700; font-size: 1.1rem; }
        .btn-bakery { background: #a86a2f; border: 0; color: #fff; border-radius: 999px; padding: 11px 22px; font-weight: 600; }
        .btn-bakery:hover { background: #8b4f24; color: #fff; }
    </style>
</head>
<body>
    <main class="container page">
        <div class="text-center mb-4">
            <span class="badge-title">Your bakery journey</span>
            <h1 class="display-6 fw-bold mt-3">My orders</h1>
            <p class="muted">Follow every freshly prepared order from our kitchen to you.</p>
        </div>
        <div class="d-flex justify-content-end mb-4">
            <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4">Back to storefront</a>
        </div>
        @if($orders->isEmpty())
            <div class="order-card p-5 text-center">
                <h2 class="h4">Your order history is waiting.</h2>
                <p class="muted">Discover something delicious from today’s collection.</p>
                <a href="{{ route('customer.dashboard') }}" class="btn btn-bakery mt-2">Explore the collection</a>
            </div>
        @else
            <div class="row g-3">
                @foreach($orders as $order)
                    <div class="col-12">
                        <a href="{{ route('orders.show', $order) }}" class="order-card p-4 d-flex flex-wrap justify-content-between align-items-center gap-3 text-decoration-none text-dark">
                            <div>
                                <div class="muted small text-uppercase mb-2">Order placed {{ $order->created_at->format('M d, Y') }}</div>
                                <div class="order-number">{{ $order->order_number }}</div>
                                <div class="muted small mt-1">{{ $order->items->count() }} {{ \Illuminate\Support\Str::plural('item', $order->items->count()) }}</div>
                            </div>
                            <div class="d-flex align-items-center gap-4">
                                <span class="status">{{ ucfirst($order->status) }}</span>
                                <span class="price">${{ number_format($order->total_amount, 2) }}</span>
                                <span class="fs-4 muted">→</span>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </main>
</body>
</html>
