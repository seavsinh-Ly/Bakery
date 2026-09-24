<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bakery | Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(180deg, #fffaf3 0%, #f8f1e7 100%) !important; color: #242321; font-family: Arial, sans-serif; }
        .topbar, .panel { background: #fff; border: 0; border-radius: 18px; box-shadow: 0 8px 24px rgba(116,80,38,.08); }
        .eyebrow { color: #8a5a25; font-size: .7rem; font-weight: 700; letter-spacing: .18em; text-transform: uppercase; }
        .btn-gold { background: #a86a2f; color: #fff; border-radius: 999px; border: 0; }
        .btn-gold:hover { background: #8b4f24; color: #fff; }
        .table thead th { color: #8a6a4d; font-size: .72rem; letter-spacing: .08em; text-transform: uppercase; }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="topbar p-4 mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div><div class="eyebrow mb-2">Inventory studio</div><h1 class="h3 mb-0">Products</h1></div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-dark rounded-pill">Dashboard</a>
                <a href="{{ route('admin.products.create') }}" class="btn btn-gold px-4">Add product</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="panel p-4">
                <div class="table-responsive"><table class="table align-middle mb-0">
                    <thead>
                        <tr><th>Name</th><th>Category</th><th>Price</th><th>Stock</th><th>Status</th><th>Actions</th></tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category?->name ?? 'Uncategorized' }}</td>
                                <td>${{ number_format($product->price, 2) }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>{{ ucfirst($product->status) }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-dark rounded-pill">Edit</a>
                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table></div>
        </div>
    </div>
</body>
</html>
