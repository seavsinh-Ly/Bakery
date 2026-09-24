<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart | Bakery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(180deg,#fffaf3 0%,#f8f1e7 100%); color: #242321; font-family: Arial, sans-serif; }
        .page { padding: 60px 0; }
        .badge-title { background: #f9d9a8; color: #8a5a25; border-radius: 999px; padding: 8px 14px; font-size: .8rem; letter-spacing: .05rem; text-transform: uppercase; }
        .panel { border: 0; border-radius: 18px; background: #fff; box-shadow: 0 8px 24px rgba(116,80,38,.08); }
        .cart-image { width: 72px; height: 72px; object-fit: cover; border-radius: 12px; background: #fff8ef; }
        .form-control { border-radius: 12px; border: 1px solid #e7d9c5; padding: 10px 12px; background: #fffdfb; }
        .form-control:focus { border-color: #d9a96a; box-shadow: 0 0 0 .2rem rgba(217,169,106,.15); }
        .submit-btn { background: #a86a2f; border: 0; color: #fff; border-radius: 999px; padding: 12px 26px; font-weight: 600; }
        .submit-btn:hover { background: #8b4f24; color: #fff; }
        .price { color: #a86a2f; font-weight: 700; }
        .muted { color: #827a70; }
        .product-card { border: 1px solid #eadfce; border-radius: 16px; background: #fff; overflow: hidden; height: 100%; }
        .product-card-image { height: 150px; width: 100%; object-fit: cover; background: #fff8ef; }
    </style>
</head>
<body>
    <main class="container page">
        <div class="text-center mb-4">
            <span class="badge-title">Freshly baked order</span>
            <h1 class="display-6 fw-bold mt-3">Your cart</h1>
            <p class="muted">Review your treats before placing your order.</p>
        </div>
        @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if($errors->any()) <div class="alert alert-danger">{{ $errors->first() }}</div> @endif
        <div class="panel p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <div class="muted small text-uppercase">Bakery collection</div>
                    <h2 class="h4 mb-0 mt-1">Add pastries to your cart</h2>
                </div>
                <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-secondary rounded-pill">Back to shop</a>
            </div>
            <div class="row g-3">
                @forelse($products as $product)
                    @php
                        $image = $product->images->first();
                        $imageUrl = $image
                            ? (filter_var($image->image_path, FILTER_VALIDATE_URL) ? $image->image_path : asset('storage/' . ltrim($image->image_path, '/')))
                            : 'https://images.unsplash.com/photo-1559620192-032c4bc4674e?auto=format&fit=crop&w=500&q=80';
                    @endphp
                    <div class="col-sm-6 col-lg-4">
                        <div class="product-card">
                            <img src="{{ $imageUrl }}" class="product-card-image" alt="{{ $product->name }}" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1559620192-032c4bc4674e?auto=format&fit=crop&w=500&q=80';">
                            <div class="p-3">
                                <div class="muted small">{{ $product->category?->name ?? 'Bakery product' }}</div>
                                <div class="d-flex justify-content-between gap-2 mt-1">
                                    <strong>{{ $product->name }}</strong>
                                    <span class="price">${{ number_format($product->price, 2) }}</span>
                                </div>
                                <small class="muted d-block mb-3">{{ $product->stock }} available</small>
                                <form action="{{ route('cart.store') }}" method="POST" class="d-flex gap-2">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control" aria-label="Quantity for {{ $product->name }}">
                                    <button type="submit" class="submit-btn flex-grow-1">Add to cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12"><div class="alert alert-light border mb-0">No pastries are currently available.</div></div>
                @endforelse
            </div>
        </div>
        @if($cartItems->isEmpty())
            <div class="panel p-5 text-center">
                <h2 class="h4">Your cart is waiting for something delicious.</h2>
                <a href="{{ route('customer.dashboard') }}" class="btn submit-btn mt-3">Continue shopping</a>
            </div>
        @else
            <div class="panel p-4">
                <div class="table-responsive"><table class="table align-middle mb-0">
                    <thead><tr><th>Product details</th><th>Quantity</th><th>Unit price</th><th>Item total</th><th></th></tr></thead>
                    <tbody>
                        @foreach($cartItems as $cartItem)
                            @php
                                $image = $cartItem->product->images->first();
                                $imageUrl = $image
                                    ? (filter_var($image->image_path, FILTER_VALIDATE_URL) ? $image->image_path : asset('storage/' . ltrim($image->image_path, '/')))
                                    : 'https://images.unsplash.com/photo-1559620192-032c4bc4674e?auto=format&fit=crop&w=300&q=80';
                            @endphp
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ $imageUrl }}" class="cart-image" alt="{{ $cartItem->product->name }}" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1559620192-032c4bc4674e?auto=format&fit=crop&w=300&q=80';">
                                        <div>
                                            <div class="fw-semibold">{{ $cartItem->product->name }}</div>
                                            <small class="muted">{{ $cartItem->product->category?->name ?? 'Bakery product' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td><form action="{{ route('cart.update', $cartItem) }}" method="POST" class="d-flex gap-2">@csrf @method('PATCH')<input type="number" name="quantity" value="{{ $cartItem->quantity }}" min="1" class="form-control" style="max-width: 88px;"><button type="submit" class="btn btn-sm btn-outline-dark rounded-pill">Update</button></form></td>
                                <td>${{ number_format($cartItem->product->price, 2) }}</td>
                                <td class="price">${{ number_format($cartItem->product->price * $cartItem->quantity, 2) }}</td>
                                <td><form action="{{ route('cart.destroy', $cartItem) }}" method="POST">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger rounded-pill">Remove</button></form></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table></div>
            </div>
            <div class="panel p-4 mt-4">
                <div class="row g-4 align-items-start">
                    <div class="col-md-5">
                        <div class="muted small text-uppercase">Cart summary</div>
                        <div class="mt-2">{{ $cartItems->sum('quantity') }} product(s)</div>
                        <div class="muted small mt-3 text-uppercase">Total amount</div>
                        <div class="display-6 price">${{ number_format($total, 2) }}</div>
                        <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-secondary rounded-pill mt-3">Continue shopping</a>
                    </div>
                    <div class="col-md-7"><h2 class="h5 mb-3">Delivery details</h2><form action="{{ route('orders.store') }}" method="POST">@csrf<input type="text" name="shipping_address" class="form-control mb-2" placeholder="Shipping address" required><textarea name="notes" class="form-control mb-3" rows="3" placeholder="Delivery notes"></textarea><button type="submit" class="submit-btn">Place order</button></form></div>
                </div>
            </div>
        @endif
    </main>
</body>
</html>
