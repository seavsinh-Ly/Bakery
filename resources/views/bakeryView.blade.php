<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bakery Menu</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(180deg, #fffaf3 0%, #f8f1e7 100%);
            font-family: Arial, sans-serif;
        }

        .menu-header {
            padding-top: 80px;
            padding-bottom: 40px;
        }

        .bakery-card {
            border: none;
            border-radius: 18px;
            background: #ffffff;
            box-shadow: 0 8px 24px rgba(116, 80, 38, 0.08);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .bakery-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 28px rgba(116, 80, 38, 0.15);
        }

        .price-badge {
            background: #f4d7ad;
            color: #6b4320;
            font-weight: 700;
            padding: 8px 12px;
            border-radius: 999px;
        }

        .section-badge {
            background: #f9d9a8;
            color: #8a5a25;
            border-radius: 999px;
            padding: 8px 14px;
            font-size: 0.8rem;
            letter-spacing: 0.05rem;
            text-transform: uppercase;
        }

        .delete-btn {
            background: #d1495b;
            color: white;
            border: none;
            border-radius: 999px;
            padding: 8px 16px;
            font-weight: 600;
            transition: 0.2s ease;
        }

        .delete-btn:hover {
            background: #b93c4d;
            color: white;
        }

        .card-actions {
            margin-top: 16px;
        }
    </style>
</head>
<body>
    <div class="container menu-header">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <span class="text-muted">Signed in as <strong>{{ auth()->user()->name }}</strong> ({{ ucfirst(auth()->user()->role) }})</span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-secondary rounded-pill">Log out</button>
            </form>
        </div>
        <div class="text-center mb-5">
            <span class="section-badge">Freshly baked</span>
            <h1 class="display-5 fw-bold text-dark mt-3">Bakery Menu</h1>
            <p class="text-muted mt-3 mb-0">
                Warm breads, sweet pastries, and handcrafted treats made daily.
            </p>
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('bakery.create') }}" class="btn mb-4 section-badge text-dark">
                    Create New Bakery Item
                </a>
            @endif
        </div>
        <div class="row g-4">
            @foreach($bakeryMenus as $bakeryMenu)
                <div class="col-md-6 col-lg-4">
                    <div class="card bakery-card h-100">
                        <img src="{{ $bakeryMenu['image'] }}" class="card-img-top" alt="{{ $bakeryMenu['name'] }}" style="height: 220px; object-fit: cover;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h2 class="h4 fw-bold">{{ $bakeryMenu['name'] }}</h2>
                                <span class="price-badge">${{ number_format($bakeryMenu['price'], 2) }}</span>
                            </div>
                            @php
                                $brands = $bakeryMenu['brand'] ?? [];
                                if (!is_array($brands)) {
                                    $brands = [$brands];
                                }
                            @endphp
                            <div class="mb-2">
                                <strong>Brands:</strong>
                                <ol class="mb-0 ps-4">
                                    @foreach($brands as $brand)
                                        <li>{{ $brand }}</li>
                                    @endforeach
                                </ol>
                            </div>
                            <p class="text-muted mb-0"><span class="fw-bold">Description:</span> {{ $bakeryMenu['description'] }}</p>
                            <div class="mt-3">
                                <span class="fw-bold">Flavors:</span>
                                @php
                                    $flavors = $bakeryMenu['flavor'] ?? [];
                                    if (!is_array($flavors)) {
                                        $flavors = [$flavors];
                                    }
                                @endphp
                                @foreach($flavors as $flavor)
                                    <span class="badge bg-light text-dark me-2">{{ $flavor }}</span>
                                @endforeach
                            </div>
                            <div class="mt-3">
                                @if(!empty($bakeryMenu['id']))
                                    <div class="card-actions d-flex gap-2">

                                        {{-- Delete Button --}}
                                        <form action="{{ route('bakery.delete', ['id' => $bakeryMenu['id']]) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this bakery item?');">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn delete-btn">
                                                Delete Item
                                            </button>
                                        </form>

                                        {{-- Edit Button --}}
                                        <button type="button"
                                                class="btn btn-outline-secondary rounded-pill px-4"
                                                onclick="window.location.href='{{ route('bakery.edit', ['id' => $bakeryMenu['id']]) }}'">
                                            Edit Item
                                        </button>

                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Bootstrap JS (optional for this design) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>