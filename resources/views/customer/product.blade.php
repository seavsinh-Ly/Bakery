<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} | Bakery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(180deg,#fffaf3 0%,#f8f1e7 100%); color: #242321; font-family: Arial, sans-serif; }
        .page { padding: 60px 0; }
        .badge-title { background: #f9d9a8; color: #8a5a25; border-radius: 999px; padding: 8px 14px; font-size: .8rem; letter-spacing: .05rem; text-transform: uppercase; }
        .detail-card { border: 0; border-radius: 18px; overflow: hidden; background: #fff; box-shadow: 0 8px 24px rgba(116,80,38,.08); }
        .detail-image { height: 100%; min-height: 480px; width: 100%; object-fit: cover; background: #fff8ef; }
        .detail-copy { padding: 42px; }
        .product-name { font: 2.7rem Georgia, serif; }
        .price { color: #a86a2f; font-size: 1.6rem; font-weight: 700; }
        .muted { color: #827a70; }
        .form-control { border-radius: 12px; border: 1px solid #e7d9c5; padding: 12px 14px; background: #fffdfb; }
        .form-control:focus { border-color: #d9a96a; box-shadow: 0 0 0 .2rem rgba(217,169,106,.15); }
        .submit-btn { background: #a86a2f; border: 0; color: #fff; border-radius: 999px; padding: 12px 26px; font-weight: 600; }
        .submit-btn:hover { background: #8b4f24; color: #fff; }
    </style>
</head>
<body>
    <main class="container page">
        <div class="text-center mb-4">
            <span class="badge-title">Bakery collection</span>
            <h1 class="display-6 fw-bold mt-3">Product details</h1>
        </div>
        @php
            $image = $product->images->first();
            $imageUrl = $image
                ? (filter_var($image->image_path, FILTER_VALIDATE_URL) ? $image->image_path : asset('storage/' . ltrim($image->image_path, '/')))
                : 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&w=900&q=80';
        @endphp
        <div class="detail-card">
            <div class="row g-0">
                <div class="col-lg-6">
                    <img src="{{ $imageUrl }}" class="detail-image" alt="{{ $product->name }}" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&w=900&q=80';">
                </div>
                <div class="col-lg-6">
                    <div class="detail-copy">
                        <div class="text-uppercase muted small mb-3">{{ $product->category?->name ?? 'Patisserie' }}</div>
                        <h2 class="product-name mb-3">{{ $product->name }}</h2>
                        <div class="price mb-4">${{ number_format($product->price, 2) }}</div>
                        <p class="muted mb-4">{{ $product->description ?: 'A freshly prepared bakery favourite made with care.' }}</p>
                        <div class="mb-4"><strong>Availability:</strong> {{ $product->stock > 0 ? $product->stock . ' available' : 'Currently unavailable' }}</div>
                        @if(auth()->user()->isCustomer() && $product->stock > 0)
                            <p class="muted mb-2">Would you like to add this treat to your cart?</p>
                            <form action="{{ route('cart.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <div class="d-flex gap-2">
                                    <input type="number" name="quantity" class="form-control" min="1" max="{{ min($product->stock, 10) }}" value="1" style="max-width: 120px;">
                                    <button type="submit" class="submit-btn">Yes, add to cart</button>
                                </div>
                            </form>
                        @elseif($product->stock === 0)
                            <button class="btn btn-secondary rounded-pill" disabled>Out of stock</button>
                        @else
                            <div class="alert alert-light border mb-0">Admins can view the storefront catalog but cannot place customer orders.</div>
                        @endif
                        <a href="{{ auth()->user()->isAdmin() ? route('bakery.menu') : route('customer.dashboard') }}" class="btn btn-outline-secondary rounded-pill mt-4 px-4">Back to collection</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
