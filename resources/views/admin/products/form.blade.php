<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->exists ? 'Edit Product' : 'Create Product' }} | Bakery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(180deg, #fffaf3 0%, #f8f1e7 100%); font-family: Arial, sans-serif; }
        .page { padding: 70px 0; }
        .badge-title { background: #f9d9a8; color: #8a5a25; border-radius: 999px; padding: 8px 14px; font-size: .8rem; letter-spacing: .05rem; text-transform: uppercase; }
        .form-card { border: 0; border-radius: 18px; background: #fff; box-shadow: 0 8px 24px rgba(116,80,38,.08); padding: 32px; }
        .form-control, .form-select { border-radius: 12px; border: 1px solid #e7d9c5; padding: 12px 14px; background: #fffdfb; }
        .form-control:focus, .form-select:focus { border-color: #d9a96a; box-shadow: 0 0 0 .2rem rgba(217,169,106,.15); }
        label { font-weight: 600; color: #5e3d26; margin-bottom: 8px; }
        .submit-btn { background: #a86a2f; border: 0; color: #fff; border-radius: 999px; padding: 12px 28px; font-weight: 600; }
        .submit-btn:hover { background: #8b4f24; color: #fff; }
        .tag-box { background: linear-gradient(180deg,#fffdf9 0%,#fff7ef 100%); border: 1px solid #efd7b8; border-radius: 16px; padding: 18px; }
        .image-option { background: #fff; border: 1px solid #e7d9c5; border-radius: 12px; padding: 12px 14px; }
    </style>
</head>
<body>
    <main class="container page">
        <div class="text-center mb-4">
            <span class="badge-title">Freshly baked catalog</span>
            <h1 class="display-6 fw-bold text-dark mt-3">{{ $product->exists ? 'Edit Product' : 'Create Product' }}</h1>
            <p class="text-muted">Add a delicious product to your bakery collection.</p>
        </div>
        <div class="row justify-content-center"><div class="col-lg-9"><div class="form-card">
            @if($errors->any())
                <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
            @endif
            <form method="POST" action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}" enctype="multipart/form-data">
                @csrf
                @if($product->exists) @method('PUT') @endif
                <div class="row g-3">
                    <div class="col-md-6"><label for="name">Product name</label><input id="name" type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required></div>
                    <div class="col-md-6"><label for="category_id">Category</label><select id="category_id" name="category_id" class="form-select" required><option value="">Select category</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>@endforeach</select></div>
                    <div class="col-12"><label for="description">Description</label><textarea id="description" name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea></div>
                    <div class="col-md-4"><label for="price">Price</label><input id="price" type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $product->price) }}" required></div>
                    <div class="col-md-4"><label for="stock">Stock</label><input id="stock" type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" required></div>
                    <div class="col-md-4"><label for="status">Status</label><select id="status" name="status" class="form-select" required><option value="draft" @selected(old('status', $product->status) === 'draft')>Draft</option><option value="active" @selected(old('status', $product->status) === 'active')>Active</option><option value="out_of_stock" @selected(old('status', $product->status) === 'out_of_stock')>Out of Stock</option></select></div>
                </div>
                <div class="tag-box mt-4">
                    <label>Product image source</label>
                    <div class="d-flex flex-wrap gap-3 mb-3">
                        <label class="image-option form-check mb-0">
                            <input class="form-check-input me-2" type="radio" name="image_source" value="upload" @checked(old('image_source', 'upload') === 'upload')>
                            Upload from device
                        </label>
                        <label class="image-option form-check mb-0">
                            <input class="form-check-input me-2" type="radio" name="image_source" value="url" @checked(old('image_source') === 'url')>
                            Use image link
                        </label>
                    </div>
                    <div id="image-upload-field" class="mb-3">
                        <label for="images">Select product image(s)</label>
                        <input id="images" type="file" name="images[]" class="form-control" multiple accept="image/*">
                        <small class="text-muted">Use JPG, PNG, or WebP images up to 2 MB each.</small>
                    </div>
                    <div id="image-url-field" class="mb-3 d-none">
                        <label for="image_url">Product image link</label>
                        <input id="image_url" type="url" name="image_url" class="form-control" value="{{ old('image_url') }}" placeholder="https://example.com/bakery-product.jpg">
                        <small class="text-muted">Use a direct, publicly accessible image URL.</small>
                    </div>
                    <div class="form-check"><input id="is_featured" type="checkbox" name="is_featured" class="form-check-input" value="1" @checked(old('is_featured', $product->is_featured))><label for="is_featured" class="form-check-label">Feature this product in the collection</label></div>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-4"><a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Back to Products</a><button type="submit" class="btn submit-btn">{{ $product->exists ? 'Update Product' : 'Create Product' }}</button></div>
            </form>
        </div></div></div>
    </main>
    <script>
        const imageSourceInputs = document.querySelectorAll('input[name="image_source"]');
        const uploadField = document.getElementById('image-upload-field');
        const urlField = document.getElementById('image-url-field');
        const imageFileInput = document.getElementById('images');
        const imageUrlInput = document.getElementById('image_url');

        function toggleImageSource() {
            const useUrl = document.querySelector('input[name="image_source"]:checked').value === 'url';
            uploadField.classList.toggle('d-none', useUrl);
            urlField.classList.toggle('d-none', !useUrl);
            imageFileInput.disabled = useUrl;
            imageUrlInput.disabled = !useUrl;
            if (useUrl) imageFileInput.value = '';
            if (!useUrl) imageUrlInput.value = '';
        }

        imageSourceInputs.forEach((input) => input.addEventListener('change', toggleImageSource));
        toggleImageSource();
    </script>
</body>
</html>
