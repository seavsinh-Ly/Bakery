<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $category->exists ? 'Edit Category' : 'Create Category' }} | Bakery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(180deg, #fffaf3 0%, #f8f1e7 100%); font-family: Arial, sans-serif; }
        .page { padding: 70px 0; }
        .badge-title { background: #f9d9a8; color: #8a5a25; border-radius: 999px; padding: 8px 14px; font-size: .8rem; letter-spacing: .05rem; text-transform: uppercase; }
        .form-card { border: 0; border-radius: 18px; background: #fff; box-shadow: 0 8px 24px rgba(116,80,38,.08); padding: 32px; }
        .form-control { border-radius: 12px; border: 1px solid #e7d9c5; padding: 12px 14px; background: #fffdfb; }
        .form-control:focus { border-color: #d9a96a; box-shadow: 0 0 0 .2rem rgba(217,169,106,.15); }
        label { font-weight: 600; color: #5e3d26; margin-bottom: 8px; }
        .submit-btn { background: #a86a2f; border: 0; color: #fff; border-radius: 999px; padding: 12px 28px; font-weight: 600; }
        .submit-btn:hover { background: #8b4f24; color: #fff; }
    </style>
</head>
<body>
    <main class="container page">
        <div class="text-center mb-4">
            <span class="badge-title">Catalog management</span>
            <h1 class="display-6 fw-bold text-dark mt-3">{{ $category->exists ? 'Edit Category' : 'Create Category' }}</h1>
            <p class="text-muted">Organize the treats in your bakery collection.</p>
        </div>
        <div class="row justify-content-center"><div class="col-lg-7"><div class="form-card">
            @if($errors->any())
                <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
            @endif
            <form method="POST" action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}">
                @csrf
                @if($category->exists) @method('PUT') @endif
                <div class="mb-3"><label for="name">Category name</label><input id="name" type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required></div>
                <div class="mb-4"><label for="description">Description</label><textarea id="description" name="description" class="form-control" rows="5">{{ old('description', $category->description) }}</textarea></div>
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Back to Categories</a>
                    <button type="submit" class="btn submit-btn">{{ $category->exists ? 'Update Category' : 'Create Category' }}</button>
                </div>
            </form>
        </div></div></div>
    </main>
</body>
</html>
