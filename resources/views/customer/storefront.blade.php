<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bakery | Patisserie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --ink: #242321; --gold: #b38a4c; --cream: #f7f4ee; --line: #e8e2d7; }
        body { background: var(--cream); color: var(--ink); font-family: Inter, Arial, sans-serif; }
        .navbar { background: rgba(255,255,255,.94); border-bottom: 1px solid var(--line); }
        .brand { color: var(--ink); font-family: Georgia, serif; font-size: 1.7rem; letter-spacing: .04em; }
        .brand small { display: block; color: var(--gold); font: 700 .62rem Inter, sans-serif; letter-spacing: .25em; text-transform: uppercase; }
        .welcome-caption { color: var(--gold); font-size: .72rem; font-weight: 700; letter-spacing: .08em; }
        .catalog-header { padding: 3.5rem 0 2rem; }
        .eyebrow { color: var(--gold); font-size: .72rem; font-weight: 700; letter-spacing: .2em; text-transform: uppercase; }
        .catalog-title { font-family: Georgia, serif; font-size: clamp(2.2rem, 5vw, 4rem); }
        .search-box, .product-card { background: #fff; border: 1px solid var(--line); }
        .search-box { border-radius: 999px; padding: .35rem; }
        .search-box input { border: 0; background: transparent; }
        .search-box input:focus { box-shadow: none; }
        .btn-gold { background: var(--ink); color: #fff; border-radius: 999px; padding: .7rem 1.4rem; }
        .btn-gold:hover { background: var(--gold); color: #fff; }
        .filter { color: #756d62; border: 1px solid var(--line); border-radius: 999px; padding: .55rem 1rem; text-decoration: none; background: #fff; }
        .filter:hover { color: var(--ink); border-color: var(--gold); }
        .filter.active { color: #fff; background: var(--ink); border-color: var(--ink); }
        .product-card { border-radius: 16px; overflow: hidden; transition: transform .2s, box-shadow .2s; }
        .product-card:hover { transform: translateY(-4px); box-shadow: 0 16px 35px rgba(36,35,33,.1); }
        .product-image { height: 245px; object-fit: contain; background: #fff; }
        .product-image-wrap { background: #fff; position: relative; }
        .product-name { font-family: Georgia, serif; }
        .price { color: var(--gold); font-weight: 700; }
        .muted { color: #827a70; }
        .product-description { white-space: pre-line; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container py-2">
            <div class="d-flex align-items-center gap-3">
                <a class="navbar-brand brand mb-0" href="{{ route('customer.dashboard') }}">Bakery<small>patisserie & co.</small></a>
                @if(auth()->user()->isCustomer())
                    <span class="welcome-caption d-none d-md-inline">Welcome to Our Bakery, Dear {{ auth()->user()->name }}!</span>
                @endif
            </div>
            <div class="ms-auto d-flex gap-2 align-items-center">
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-dark rounded-pill">Admin dashboard</a>
                @else
                    <a href="{{ route('orders.index') }}" class="btn btn-sm btn-link text-dark text-decoration-none">My orders</a>
                    <a href="{{ route('cart.index') }}" class="btn btn-sm btn-gold">
                        Cart <span class="badge text-bg-light ms-1">{{ $cartCount ?? 0 }}</span>
                    </a>
                @endif
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-dark rounded-pill">Sign out</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="container">
        <header class="catalog-header">
            <div class="eyebrow mb-3">Handcrafted every morning</div>
            <h1 class="catalog-title mb-2">The daily collection.</h1>
            <p class="muted mb-4">Small-batch breads, patisserie and sweet moments made with care.</p>
            <form action="{{ auth()->user()->isAdmin() ? route('bakery.menu') : route('customer.shop') }}" method="GET" class="search-box d-flex align-items-center col-lg-7">
                <span class="px-3 muted">⌕</span>
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search the collection...">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <button type="submit" class="btn btn-gold">Search</button>
            </form>
        </header>

        <div class="d-flex flex-wrap gap-2 mb-4">
            @php
                $catalogRoute = auth()->user()->isAdmin() ? route('bakery.menu') : route('customer.shop');
            @endphp
            <a class="filter {{ empty($selectedCategory) ? 'active' : '' }}" href="{{ $catalogRoute }}">All products</a>
            @foreach($categories as $category)
                <a class="filter {{ ($selectedCategory ?? '') === $category->slug ? 'active' : '' }}" href="{{ $catalogRoute . '?category=' . urlencode($category->slug) }}">{{ $category->name }}</a>
            @endforeach
        </div>

        <div class="row g-4 pb-5">
            @forelse($products as $product)
                <div class="col-sm-6 col-lg-4">
                    <article class="product-card h-100">
                        @php
                            $image = $product->images->first();
                            $imageUrl = $image
                                ? (filter_var($image->image_path, FILTER_VALIDATE_URL) ? $image->image_path : asset('storage/' . ltrim($image->image_path, '/')))
                                : 'https://images.unsplash.com/photo-1559620192-032c4bc4674e?auto=format&fit=crop&w=900&q=80';
                        @endphp
                        <div class="product-image-wrap">
                            <img src="{{ $imageUrl }}" class="w-100 product-image" alt="{{ $product->name }}" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1559620192-032c4bc4674e?auto=format&fit=crop&w=900&q=80';">
                        </div>
                        <div class="p-4 d-flex flex-column h-100">
                            <div class="text-uppercase muted small mb-2">{{ $product->category?->name ?? 'Patisserie' }}</div>
                            <div class="d-flex justify-content-between gap-3">
                                <h2 class="h4 product-name mb-2">{{ $product->name }}</h2>
                                <span class="price">${{ number_format($product->price, 2) }}</span>
                            </div>
                            <p class="muted small product-description mb-4">{{ $product->description ?: 'A freshly prepared bakery favourite made with care.' }}</p>
                            <div class="mt-auto">
                                @if($product->stock > 0)
                                    <form action="{{ route('cart.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <button type="submit" class="btn btn-gold rounded-pill w-100">
                                            Add to cart · ${{ number_format($product->price, 2) }}
                                        </button>
                                    </form>
                                @else
                                    <button type="button" class="btn btn-secondary rounded-pill w-100" disabled>
                                        Out of stock
                                    </button>
                                @endif
                            </div>
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12"><div class="alert alert-light border">No products are available yet.</div></div>
            @endforelse
        </div>
    </main>
</body>
</html>
