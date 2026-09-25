<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bakery | Patisserie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --ink: #5A3424; --gold: #E7A178; --cream: #FFF0E6; --line: #EBCDB8; }
        body { background: linear-gradient(rgba(255,240,230,.84), rgba(255,240,230,.84)), url('https://cdn.phototourl.com/member/2026-09-25-e5885b14-548b-46a5-af02-4a07bad6c79e.jpg') center / cover fixed; color: var(--ink); font-family: Inter, Arial, sans-serif; }
        .navbar { background: rgba(255,255,255,.94); border-bottom: 1px solid var(--line); }
        .brand { color: var(--ink); font-family: Georgia, serif; font-size: 1.7rem; letter-spacing: .04em; }
        .brand small { display: block; color: var(--gold); font: 700 .62rem Inter, sans-serif; letter-spacing: .25em; text-transform: uppercase; }
        .welcome-caption { color: var(--gold); font-size: .72rem; font-weight: 700; letter-spacing: .08em; }
        .sslb-brand { display: inline-flex; flex-direction: column; align-items: center; color: #5A3424; font-size: .78rem; font-weight: 800; line-height: 1; letter-spacing: .14em; text-decoration: none; text-transform: uppercase; }
        .sslb-icon { color: #E7A178; font-size: 1.25rem; letter-spacing: 0; line-height: 1; }
        .sslb-caption { color: #5A3424; font-family: Georgia, serif; font-size: clamp(1rem, 2vw, 1.45rem); letter-spacing: .04em; line-height: 1.1; white-space: nowrap; }
        .navbar-inner { display: flex; align-items: center; gap: 1.25rem; }
        .navbar-center { position: absolute; top: 50%; left: 50%; display: flex; align-items: center; gap: 1.25rem; width: min(55rem, calc(100% - 20rem)); transform: translate(-50%, -50%); }
        .header-search { flex: 1 1 20rem; min-width: 8rem; max-width: 30rem; }
        .sslb-header { display: flex; flex: 0 0 auto; align-items: center; gap: .75rem; }
        .logout-form { position: absolute; top: 50%; right: 0; transform: translateY(-50%); }
        .navbar-actions { position: absolute; top: 50%; right: 7rem; margin-right: 0; transform: translateY(-50%); }
        .nav-action { display: inline-flex; min-width: 7rem; height: 2.25rem; align-items: center; justify-content: center; }
        .catalog-actions { display: flex; justify-content: center; gap: .5rem; margin-top: 1.25rem; }
        .mobile-nav-actions { display: none; }
        .catalog-header { position: relative; overflow: hidden; padding: 3.5rem 1rem 2rem; text-align: center; }
        .eyebrow { color: #9A5C37; font-size: .78rem; font-weight: 800; letter-spacing: .2em; text-shadow: 0 1px 0 rgba(255,255,255,.8); text-transform: uppercase; }
        .catalog-title { color: #4A281B; font-family: Georgia, serif; font-size: clamp(2.2rem, 5vw, 4rem); font-weight: 700; letter-spacing: .01em; text-shadow: 0 2px 0 rgba(255,255,255,.7), 0 4px 12px rgba(255,240,230,.7); }
        .catalog-header > p { max-width: 42rem; margin-right: auto; margin-left: auto; color: #5A3424; font-size: 1.05rem; font-weight: 600; text-shadow: 0 1px 0 rgba(255,255,255,.85), 0 2px 8px rgba(255,240,230,.7); }
        .search-box { background: var(--cream); border: 1px solid var(--line); }
        .search-box { border-radius: 999px; padding: .35rem; }
        .search-box input { border: 0; background: transparent; }
        .search-box input:focus { box-shadow: none; }
        .btn-gold { background: var(--ink); color: #fff; border-radius: 999px; padding: .7rem 1.4rem; }
        .btn-gold:hover { background: var(--gold); color: #fff; }
        .filter { color: #756d62; border: 1px solid var(--line); border-radius: 999px; padding: .55rem 1rem; text-decoration: none; background: #fff; }
        .filter:hover { color: var(--ink); border-color: var(--gold); }
        .filter.active { position: relative; color: #fff; background: var(--ink); border-color: var(--ink); box-shadow: 0 4px 10px rgba(90,52,36,.2); }
        .filter.active::after { position: absolute; right: 1rem; bottom: -.35rem; left: 1rem; height: 3px; border-radius: 999px; background: var(--gold); content: ''; }
        .product-card { background: #FFFCF8; border: 1px solid #EBCDB8; border-radius: 20px; overflow: hidden; box-shadow: 0 8px 20px rgba(90,52,36,.08); transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease; }
        .product-card { display: flex; height: 100%; flex-direction: column; }
        .product-card:hover { transform: translateY(-6px); border-color: #E7A178; box-shadow: 0 18px 35px rgba(90,52,36,.14); }
        .product-image { display: block; width: 100%; height: auto; }
        .product-image-wrap { height: 220px; background: linear-gradient(rgba(255,240,230,.25), rgba(255,240,230,.25)), url('https://cdn.phototourl.com/member/2026-09-25-e5885b14-548b-46a5-af02-4a07bad6c79e.jpg') center / cover; border-bottom: 1px solid #EBCDB8; }
        .product-image { width: 100%; height: 100%; object-fit: cover; }
        .product-card-content { display: flex; flex: 1; flex-direction: column; }
        .product-name { min-height: 2.4em; font-family: Georgia, serif; }
        .price { display: flex; width: 100%; height: 34px; box-sizing: border-box; align-items: center; justify-content: center; padding: 0 .7rem; border: 1px solid #E7A178; border-radius: 999px; background: #FFF0E6; color: #5A3424; font-weight: 700; text-align: center; white-space: nowrap; }
        .muted { color: #827a70; }
        .product-description { display: -webkit-box; overflow: hidden; white-space: pre-line; -webkit-box-orient: vertical; -webkit-line-clamp: 3; }
        .product-description.expanded { display: block; }
        .description-more { display: none; padding: 0; border: 0; background: transparent; color: var(--gold); font-size: .8rem; font-weight: 700; }
        .description-more.visible { display: inline; }
        .availability { display: flex; width: 100%; min-height: 34px; box-sizing: border-box; align-items: center; justify-content: center; padding: .45rem .75rem; border: 1px solid var(--line); border-radius: 8px; background: #FFF8F2; color: #827a70; font-size: .8rem; text-align: center; }
        .cart-action { width: 100%; margin-top: auto; padding-top: .75rem; }
        .product-pagination { display: flex; justify-content: center; align-items: center; gap: .35rem; margin: 1rem 0 0; }
        .product-pagination a, .product-pagination span { min-width: 36px; padding: .45rem .7rem; border: 1px solid #EBCDB8; border-radius: 999px; color: #5A3424; background: #FFFCF8; text-align: center; text-decoration: none; }
        .product-pagination a:hover, .product-pagination .active { color: #fff; background: #5A3424; border-color: #5A3424; }
        .product-pagination .disabled { color: #aaa; background: #f3eee7; }
        .site-footer { margin-top: 3rem; padding: 2.5rem 0; background: #5A3424; color: #fff; }
        .footer-title { color: #f4d7ad; font-family: Georgia, serif; font-size: 1.35rem; }
        .footer-copy { color: #d8d2ca; }
        .social-links { display: flex; flex-wrap: wrap; justify-content: center; gap: .75rem; }
        .social-link { color: #fff; border: 1px solid rgba(255,255,255,.25); border-radius: 999px; padding: .5rem 1rem; text-decoration: none; transition: background .2s ease, border-color .2s ease; }
        .social-link:hover { color: #fff; background: #5e3d26; border-color: #d9b88a; }
        @media (max-width: 991.98px) {
            .navbar-inner { flex-wrap: wrap; }
            .navbar-center { position: static; order: 2; flex-basis: 100%; flex-direction: column; width: 100%; transform: none; }
            .header-search { flex-basis: auto; width: 100%; max-width: none; }
            .sslb-header { margin: .5rem auto 0; }
            .mobile-nav-actions { order: 3; display: flex; justify-content: center; gap: .5rem; width: 100%; margin-top: .75rem; }
            .navbar-actions { position: static; order: 3; margin-left: auto; transform: none; }
            .logout-form { position: static; order: 4; display: flex; justify-content: flex-end; width: 100%; transform: none; }
            .catalog-actions { display: none; }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container position-relative py-2">
            <div class="navbar-inner">
                <a class="navbar-brand brand mb-0" href="{{ route('customer.dashboard') }}">Bakery<small>patisserie & co.</small></a>
                <div class="navbar-center">
                    <form action="{{ auth()->user()->isAdmin() ? route('bakery.menu') : route('customer.shop') }}" method="GET" class="search-box header-search d-flex align-items-center">
                        <span class="px-3 muted">⌕</span>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder=" find your dessert ...">
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                    </form>
                    <div class="sslb-header">
                        <span class="sslb-caption">Sweet Smile &amp; Love Bites</span>
                        <a class="sslb-brand" href="{{ route('customer.dashboard') }}" aria-label="SSLB - Sweet Smile and Love Bites">
                            <span class="sslb-icon" aria-hidden="true">🍰</span>
                            <span>SSLB</span>
                        </a>
                    </div>
                </div>

                @if(auth()->user()->isAdmin())
                    <div class="navbar-actions ms-auto d-flex gap-2 align-items-center">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-dark rounded-pill">Admin dashboard</a>
                    </div>
                @else
                    <div class="mobile-nav-actions">
                        <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-dark rounded-pill nav-action">My orders</a>
                        <a href="{{ route('cart.index') }}" class="btn btn-sm btn-gold nav-action">
                            Cart <span class="badge text-bg-light ms-1">{{ $cartCount ?? 0 }}</span>
                        </a>
                    </div>
                @endif
                <form action="{{ route('logout') }}" method="POST" class="logout-form">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-outline-dark rounded-pill">Sign out</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="container">
        <header class="catalog-header">
            <div class="eyebrow mb-3">~ Handcrafted  Made with Care ~</div>
            <h1 class="catalog-title mb-2">~ Freshly Baked Daily ~</h1>
            <p class="muted mb-4">Small-batch breads and pastries are enjoyable to share with others or to treat yourself to a daily moment of happiness.</p>
            @if(!auth()->user()->isAdmin())
                <div class="catalog-actions">
                    <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-dark rounded-pill nav-action">My orders</a>
                    <a href="{{ route('cart.index') }}" class="btn btn-sm btn-gold nav-action">
                        Cart <span class="badge text-bg-light ms-1">{{ $cartCount ?? 0 }}</span>
                    </a>
                </div>
            @endif
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

        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 gx-4 gy-2 pb-3">
            @forelse($products as $product)
                <div class="col">
                    <article class="product-card">
                        @php
                            $image = $product->images->first();
                            $imageUrl = $image
                                ? (filter_var($image->image_path, FILTER_VALIDATE_URL) ? $image->image_path : asset('storage/' . ltrim($image->image_path, '/')))
                                : 'https://images.unsplash.com/photo-1559620192-032c4bc4674e?auto=format&fit=crop&w=900&q=80';
                        @endphp
                        <div class="product-image-wrap">
                            <img src="{{ $imageUrl }}" class="w-100 product-image" alt="{{ $product->name }}" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1559620192-032c4bc4674e?auto=format&fit=crop&w=900&q=80';">
                        </div>
                        <div class="product-card-content p-4">
                            <div class="text-uppercase muted small mb-2">{{ $product->category?->name ?? 'Patisserie' }}</div>
                            <div>
                                <h2 class="h4 product-name mb-2">{{ $product->name }}</h2>
                            </div>
                            <div class="mb-2">
                                <span class="price">${{ number_format($product->price, 2) }}</span>
                            </div>
                            <div class="mb-2">
                                <p class="muted small product-description mb-1">{{ $product->description ?: 'A freshly prepared bakery favourite made with care.' }}</p>
                                <button type="button" class="description-more" aria-expanded="false">--more</button>
                            </div>
                            <div>
                                @if($product->stock > 0)
                                    <span class="availability">Available today · {{ $product->stock }} in stock</span>
                                @else
                                    <span class="availability">Currently unavailable</span>
                                @endif
                            </div>
                            @if(!auth()->user()->isAdmin())
                                <form action="{{ route('cart.store') }}" method="POST" class="cart-action">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit" class="btn btn-gold w-100" @disabled($product->stock < 1)>Add to cart</button>
                                </form>
                            @endif
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12"><div class="alert alert-light border">No products are available yet.</div></div>
            @endforelse
        </div>
        @if($products->hasPages())
            <nav class="product-pagination" aria-label="Product pages">
                @if($products->onFirstPage())
                    <span class="disabled">Backward</span>
                @else
                    <a href="{{ $products->appends(request()->query())->previousPageUrl() }}">Backward</a>
                @endif

                @for($page = 1; $page <= $products->lastPage(); $page++)
                    @if($page === $products->currentPage())
                        <span class="active" aria-current="page">{{ $page }}</span>
                    @else
                        <a href="{{ $products->appends(request()->query())->url($page) }}">{{ $page }}</a>
                    @endif
                @endfor

                @if($products->hasMorePages())
                    <a href="{{ $products->appends(request()->query())->nextPageUrl() }}">Forward</a>
                @else
                    <span class="disabled">Forward</span>
                @endif
            </nav>
        @endif
    </main>
    <footer class="site-footer">
        <div class="container text-center">
            <div class="footer-title mb-2">Contact us on social media</div>
            <p class="footer-copy mb-3">Follow our bakery for fresh treats, new arrivals, and daily updates.</p>
            <div class="social-links" aria-label="Social media links">
                <a class="social-link" href="https://www.facebook.com/" target="_blank" rel="noopener noreferrer">Facebook</a>
                <a class="social-link" href="https://www.tiktok.com/" target="_blank" rel="noopener noreferrer">TikTok</a>
                <a class="social-link" href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer">Instagram</a>
            </div>
            <div class="footer-copy small mt-4">&copy; {{ now()->year }} Bakery. All rights reserved.</div>
        </div>
    </footer>
    <script>
        document.querySelectorAll('.product-description').forEach((description) => {
            const moreButton = description.nextElementSibling;

            if (description.scrollHeight > description.clientHeight) {
                moreButton.classList.add('visible');
                moreButton.addEventListener('click', () => {
                    const expanded = description.classList.toggle('expanded');
                    moreButton.setAttribute('aria-expanded', expanded);
                    moreButton.textContent = expanded ? '--less' : '--more';
                });
            }
        });
    </script>
</body>
</html>
