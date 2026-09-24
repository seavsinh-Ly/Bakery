<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $order->order_number }} | Bakery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(180deg,#fffaf3 0%,#f8f1e7 100%); color: #242321; font-family: Arial, sans-serif; }
        .page { padding: 60px 0; }
        .badge-title { background: #f9d9a8; color: #8a5a25; border-radius: 999px; padding: 8px 14px; font-size: .8rem; letter-spacing: .05rem; text-transform: uppercase; }
        .panel { border: 0; border-radius: 18px; background: #fff; box-shadow: 0 8px 24px rgba(116,80,38,.08); }
        .order-number { color: #5e3d26; font: 2rem Georgia, serif; }
        .muted { color: #827a70; }
        .status { display: inline-block; background: #f9d9a8; color: #8a5a25; border-radius: 999px; padding: 7px 14px; font-size: .8rem; font-weight: 700; }
        .price { color: #a86a2f; font-weight: 700; }
        .cart-image { width: 64px; height: 64px; object-fit: cover; border-radius: 12px; background: #fff8ef; }
        .timeline { border-left: 2px solid #efd7b8; padding-left: 18px; }
        .timeline-dot { width: 10px; height: 10px; background: #a86a2f; border-radius: 50%; display: inline-block; margin-left: -24px; margin-right: 12px; }
    </style>
</head>
<body>
    <main class="container page">
        <div class="text-center mb-4">
            <span class="badge-title">Order tracking</span>
            <h1 class="display-6 fw-bold mt-3">Thank you for your order</h1>
            <p class="muted">We’re preparing something delicious for you.</p>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div><div class="muted small text-uppercase">Order number</div><div class="order-number">{{ $order->order_number }}</div></div>
            <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Back to orders</a>
        </div>
        <div class="row g-4">
            <div class="col-lg-8">
                <section class="panel p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-4"><h2 class="h5 mb-0">Order status</h2><span class="status">{{ ucfirst($order->status) }}</span></div>
                    <div class="timeline">
                        <div class="mb-3"><span class="timeline-dot"></span><strong>Order received</strong><div class="muted small">Your order has been placed with the bakery.</div></div>
                        <div class="mb-3"><span class="timeline-dot"></span><strong>{{ ucfirst($order->status) }}</strong><div class="muted small">We’ll keep this status updated as your order progresses.</div></div>
                    </div>
                </section>
                <section class="panel p-4">
                    <h2 class="h5 mb-3">Order items</h2>
                    <div class="table-responsive"><table class="table align-middle mb-0"><thead><tr><th>Product</th><th>Qty</th><th>Price</th><th>Subtotal</th></tr></thead><tbody>
                        @foreach($order->items as $item)
                            @php
                                $image = $item->product->images->first();
                                $imageUrl = $image ? (filter_var($image->image_path, FILTER_VALIDATE_URL) ? $image->image_path : asset('storage/' . ltrim($image->image_path, '/'))) : 'https://images.unsplash.com/photo-1559620192-032c4bc4674e?auto=format&fit=crop&w=300&q=80';
                            @endphp
                            <tr><td><div class="d-flex align-items-center gap-3"><img src="{{ $imageUrl }}" class="cart-image" alt="{{ $item->product->name }}" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1559620192-032c4bc4674e?auto=format&fit=crop&w=300&q=80';"><span class="fw-semibold">{{ $item->product->name }}</span></div></td><td>{{ $item->quantity }}</td><td>${{ number_format($item->unit_price, 2) }}</td><td class="price">${{ number_format($item->subtotal, 2) }}</td></tr>
                        @endforeach
                    </tbody></table></div>
                </section>
            </div>
            <div class="col-lg-4">
                <section class="panel p-4 mb-4"><h2 class="h5 mb-3">Delivery details</h2><div class="muted small text-uppercase mb-1">Shipping address</div><p>{{ $order->shipping_address }}</p>@if($order->notes)<div class="muted small text-uppercase mb-1">Notes</div><p class="mb-0">{{ $order->notes }}</p>@endif</section>
                <section class="panel p-4"><div class="muted small text-uppercase">Order total</div><div class="display-6 price">${{ number_format($order->total_amount, 2) }}</div><div class="d-flex justify-content-between mt-3"><span class="muted">Payment</span><span>{{ ucfirst($order->payment_status) }}</span></div></section>
            </div>
        </div>
    </main>
</body>
</html>
