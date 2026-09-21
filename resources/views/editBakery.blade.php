<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Bakery Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(180deg, #fffaf3 0%, #f8f1e7 100%); font-family: Arial, sans-serif; }
        .edit-card { max-width: 720px; margin: 60px auto; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); background: #fff; padding: 28px; }
        .form-label { font-weight: 600; }
        .btn-save { background: #6b4320; color: #fff; }
        .btn-cancel { border-color: #e6d3b7; color: #6b4320; }
    </style>
</head>
<body>
    <div class="container">
        <div class="edit-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0">Edit Bakery Item</h3>
                <a href="{{ route('bakery.menu') }}" class="btn btn-outline-secondary btn-sm">Back to Menu</a>
            </div>

            <form action="{{ route('bakery.update', ['id' => $bakeryItem->id]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $bakeryItem->name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $bakeryItem->description) }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $bakeryItem->price) }}" step="0.01" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="brand" class="form-label">Brand</label>
                        <input type="text" class="form-control" id="brand" name="brand" value="{{ old('brand', $bakeryItem->brand) }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="flavor" class="form-label">Flavor(s) (comma-separated)</label>
                    <input type="text" class="form-control" id="flavor" name="flavor" value="{{ old('flavor', $bakeryItem->flavor) }}">
                </div>

                <div class="d-flex gap-2 justify-content-end">
                    <a href="{{ route('bakery.menu') }}" class="btn btn-outline-secondary btn-cancel">Cancel</a>
                    <button type="submit" class="btn btn-save">Save changes</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>