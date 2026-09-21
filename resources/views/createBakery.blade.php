<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Bakery Item</title>

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

        .form-card {
            border: none;
            border-radius: 18px;
            background: #ffffff;
            box-shadow: 0 8px 24px rgba(116, 80, 38, 0.08);
            padding: 32px;
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

        .form-control,
        .form-select {
            border-radius: 12px;
            border: 1px solid #e7d9c5;
            padding: 12px 14px;
            background: #fffdfb;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #d9a96a;
            box-shadow: 0 0 0 0.2rem rgba(217, 169, 106, 0.15);
        }

        label {
            font-weight: 600;
            color: #5e3d26;
            margin-bottom: 8px;
        }

        .mini-note {
            display: block;
            margin-top: 6px;
            font-size: 0.8rem;
            color: #8a6a4d;
        }

        .tag-box {
            background: linear-gradient(180deg, #fffdf9 0%, #fff7ef 100%);
            border: 1px solid #efd7b8;
            border-radius: 16px;
            padding: 18px;
        }

        .submit-btn {
            background: #a86a2f;
            border: none;
            color: white;
            border-radius: 999px;
            padding: 12px 28px;
            font-weight: 600;
            transition: 0.2s ease;
        }

        .submit-btn:hover {
            background: #8b4f24;
        }
    </style>
</head>
<body>
    <div class="container menu-header">
        <div class="text-center mb-4">
            <span class="section-badge">Freshly baked</span>
            <h1 class="display-5 fw-bold text-dark mt-3">Create Bakery Item</h1>
            <p class="text-muted mt-3 mb-0">
                Add a new sweet treat, bread, or pastry to your menu.
            </p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="form-card">
                    <form action="{{ route('bakery.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                        </div>

                        <div class="mb-3">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                        </div>

                        <div class="mb-3">
                            <label>Image option</label>
                            <div class="d-flex gap-3 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="image_type" id="image_type_upload" value="upload" checked>
                                    <label class="form-check-label" for="image_type_upload">Upload image</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="image_type" id="image_type_url" value="url">
                                    <label class="form-check-label" for="image_type_url">Use image link</label>
                                </div>
                            </div>

                            <div id="image-upload-field">
                                <label for="image_file">Upload image</label>
                                <input type="file" class="form-control" id="image_file" name="image_file" accept="image/*">
                            </div>

                            <div id="image-url-field" class="d-none">
                                <label for="image_url">Image URL</label>
                                <input type="url" class="form-control" id="image_url" name="image_url" placeholder="https://example.com/image.jpg">
                            </div>
                        </div>

                        <div class="mb-4 tag-box">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="brand">Brand</label>
                                    <input type="text" class="form-control" id="brand" name="brand" placeholder="ChocoDelight, SweetTreats" required>
                                    <small class="mini-note">Add multiple brands separated by commas.</small>
                                </div>
                                <div class="col-md-6">
                                    <label for="flavor">Flavor</label>
                                    <input type="text" class="form-control" id="flavor" name="flavor" placeholder="Rich, Moist, Chocolatey">
                                    <small class="mini-note">Add flavor notes separated by commas.</small>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('bakery.menu') }}" class="btn btn-outline-secondary rounded-pill px-4">Back to Menu</a>
                            <button type="submit" class="btn submit-btn">Submit Item</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const uploadRadio = document.getElementById('image_type_upload');
        const urlRadio = document.getElementById('image_type_url');
        const uploadField = document.getElementById('image-upload-field');
        const urlField = document.getElementById('image-url-field');

        function toggleImageInput() {
            const useUrl = urlRadio.checked;
            uploadField.classList.toggle('d-none', useUrl);
            urlField.classList.toggle('d-none', !useUrl);

            if (useUrl) {
                document.getElementById('image_file').value = '';
            } else {
                document.getElementById('image_url').value = '';
            }
        }

        uploadRadio.addEventListener('change', toggleImageInput);
        urlRadio.addEventListener('change', toggleImageInput);
    </script>
</body>
</html>