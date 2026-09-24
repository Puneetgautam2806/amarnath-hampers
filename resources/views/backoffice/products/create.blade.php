@extends('backoffice.master_layout')

@section('title', 'Add Product')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px;">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h4 class="mb-0 text-dark fw-bold">Create New Product</h4>
            <span class="text-muted small">Design a gorgeous gift hamper or standard catalog product</span>
        </div>
        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary px-4 py-2" style="border-radius: 10px; font-weight: 600;">
            <i class="bx bx-arrow-back me-1"></i> Back to Products
        </a>
    </div>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <!-- Left Side: Essential Product details -->
            <div class="col-lg-8">
                <div class="card mb-6 border-0" style="border-radius: 16px; box-shadow: 0 8px 26px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.05);">
                    <div class="card-header border-bottom py-4">
                        <h5 class="mb-0 text-dark fw-bold">Product Information</h5>
                    </div>
                    <div class="card-body pt-6">
                        <div class="mb-4">
                            <label class="form-label text-dark fw-semibold">Product/Hamper Name *</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Luxury Chocolate Feast Hamper" required style="border-radius: 8px; padding: 10px 14px;">
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-dark fw-semibold">Short Description</label>
                            <textarea name="short_description" class="form-control" rows="3" placeholder="Write a summary description to show on cards and listing grids..." style="border-radius: 8px;"></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-dark fw-semibold">Full Product Description</label>
                            <textarea name="description" class="form-control" rows="8" placeholder="Detailed product specifications, hamper content lists, chocolate varieties, shipping timeline, and dimensions..." style="border-radius: 8px;"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Pricing & Inventory Section -->
                <div class="card mb-6 border-0" style="border-radius: 16px; box-shadow: 0 8px 26px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.05);">
                    <div class="card-header border-bottom py-4">
                        <h5 class="mb-0 text-dark fw-bold">Pricing & Inventory</h5>
                    </div>
                    <div class="card-body pt-6">
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label class="form-label text-dark fw-semibold">Selling Price (₹) *</label>
                                <input type="number" step="0.01" name="price" class="form-control" placeholder="0.00" required style="border-radius: 8px; padding: 10px 14px;">
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="form-label text-dark fw-semibold">Discounted / Original Price (₹)</label>
                                <input type="number" step="0.01" name="compare_at_price" class="form-control" placeholder="e.g. Strike price" style="border-radius: 8px; padding: 10px 14px;">
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="form-label text-dark fw-semibold">Base Stock Count *</label>
                                <input type="number" name="stock" class="form-control" value="10" required style="border-radius: 8px; padding: 10px 14px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Category, Status, Graphic Upload -->
            <div class="col-lg-4">
                <!-- Image Upload Card -->
                <div class="card mb-6 border-0" style="border-radius: 16px; box-shadow: 0 8px 26px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.05);">
                    <div class="card-header border-bottom py-4">
                        <h5 class="mb-0 text-dark fw-bold">Product Thumbnail *</h5>
                    </div>
                    <div class="card-body pt-6">
                        <!-- Premium Interactive Drag Area -->
                        <div class="text-center p-5 border border-dashed rounded-3" style="cursor: pointer; background: #fafbfc; border-color: #d9dee3; border-radius: 12px; position: relative;" id="imageUploadCard" onclick="document.getElementById('imageInput').click();">
                            <input type="file" name="image" id="imageInput" class="d-none" accept="image/*" required onchange="handleImagePreview(this);">
                            <div id="uploadPlaceholder">
                                <i class="bx bx-cloud-upload text-muted mb-2" style="font-size: 40px;"></i>
                                <h6 class="mb-1 text-dark fw-semibold">Upload Photo</h6>
                                <span class="text-muted small d-block">Supports JPEG, PNG, WEBP (Max 3MB)</span>
                            </div>
                            <div id="imagePreviewContainer" class="d-none">
                                <img id="imagePreview" src="#" alt="Preview" style="max-width: 100%; max-height: 220px; object-fit: cover; border-radius: 8px; border: 1px solid rgba(0,0,0,0.1);">
                                <span class="text-primary small d-block mt-2 fw-semibold">Change Photo</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Categorization & Details Card -->
                <div class="card mb-6 border-0" style="border-radius: 16px; box-shadow: 0 8px 26px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.05);">
                    <div class="card-header border-bottom py-4">
                        <h5 class="mb-0 text-dark fw-bold">Status & Catalog</h5>
                    </div>
                    <div class="card-body pt-6">
                        <div class="mb-4">
                            <label class="form-label text-dark fw-semibold">Category Assignment *</label>
                            <select name="category_id" class="form-select" required style="border-radius: 8px; padding: 10px 14px;">
                                <option value="" disabled selected>Select dynamic category</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-dark fw-semibold">Status *</label>
                            <select name="status" class="form-select" required style="border-radius: 8px; padding: 10px 14px;">
                                <option value="1" selected>Active / Visible</option>
                                <option value="0">Inactive / Hidden</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-dark fw-semibold">Featured Product *</label>
                            <select name="is_featured" class="form-select" required style="border-radius: 8px; padding: 10px 14px;">
                                <option value="0" selected>Standard Display</option>
                                <option value="1">Featured (Highlight on Home Showcase)</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FULL-WIDTH SECTION: Product Variations Matrix -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-6 border-0" style="border-radius: 16px; box-shadow: 0 8px 26px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.05);">
                    <div class="card-header border-bottom py-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div>
                            <h5 class="mb-1 text-dark fw-bold"><i class="bx bx-palette text-primary me-2"></i> Product Variations (Custom Price & Photo Per Color/Size)</h5>
                            <span class="text-muted small">Set custom price, strike-through price, stock, and photos for each color and size variant.</span>
                        </div>
                        <button type="button" class="btn btn-primary px-4 py-2 fw-semibold" onclick="addVariantRow()" style="border-radius: 8px;">
                            <i class="bx bx-plus me-1"></i> Add Single Variant Row
                        </button>
                    </div>
                    <div class="card-body pt-5">
                        <!-- Quick Matrix Generator Bar -->
                        <div class="p-4 bg-light rounded-3 mb-5 border" style="border-radius: 12px;">
                            <h6 class="fw-bold mb-1 text-dark"><i class="bx bx-magic-wand text-warning me-1"></i> Quick Variant Matrix Generator</h6>
                            <p class="small text-muted mb-3">Type your colors and sizes below and click <strong>Generate</strong> to automatically create all color/size pricing and photo rows at once:</p>
                            <div class="row g-3 align-items-end">
                                <div class="col-md-5">
                                    <label class="form-label fw-semibold text-dark mb-1">Colors (comma separated)</label>
                                    <input type="text" id="genColors" class="form-control" placeholder="e.g. Royal Maroon, Antique Gold, Emerald Green" style="padding: 10px 14px; border-radius: 8px; font-size: 14px;">
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label fw-semibold text-dark mb-1">Sizes / Dimensions (comma separated)</label>
                                    <input type="text" id="genSizes" class="form-control" placeholder="e.g. Small (10x10), Medium (14x14), Large (18x18)" style="padding: 10px 14px; border-radius: 8px; font-size: 14px;">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-dark w-100 fw-bold" onclick="generateMatrixRows()" style="padding: 10px 14px; border-radius: 8px;">
                                        <i class="bx bx-grid me-1"></i> Generate
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Variant Rows Table with Wide, Spacious Inputs -->
                        <div class="table-responsive" style="border-radius: 10px; border: 1px solid #e9ecef;">
                            <table class="table table-hover align-middle mb-0" id="variantsTable" style="min-width: 950px;">
                                <thead class="bg-light text-dark">
                                    <tr>
                                        <th style="padding: 14px 16px; font-weight: 700; width: 22%;">Color Name</th>
                                        <th style="padding: 14px 16px; font-weight: 700; width: 22%;">Size / Dimensions</th>
                                        <th style="padding: 14px 16px; font-weight: 700; width: 16%;">Selling Price (₹) *</th>
                                        <th style="padding: 14px 16px; font-weight: 700; width: 16%;">Original Price (₹)</th>
                                        <th style="padding: 14px 16px; font-weight: 700; width: 11%;">Stock</th>
                                        <th style="padding: 14px 16px; font-weight: 700; width: 9%; text-align: center;">Photo</th>
                                        <th style="padding: 14px 16px; font-weight: 700; width: 4%; text-align: center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="variantRowsContainer">
                                    <!-- Dynamic Rows will be inserted here -->
                                </tbody>
                            </table>
                        </div>
                        <div id="noVariantsMsg" class="text-center py-5 text-muted small bg-white border border-top-0 rounded-bottom">
                            <i class="bx bx-info-circle me-1" style="font-size: 1.2rem; vertical-align: middle;"></i> No custom variations added yet. Base price and image will be used if left empty, or click <strong>Generate</strong> above to create color/size rows with custom prices & photos.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Action Bar -->
        <div class="row">
            <div class="col-12">
                <div class="card p-4 mb-6 border-0" style="border-radius: 16px; box-shadow: 0 8px 26px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.05); background: white;">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <span class="text-muted small">Please verify all prices, sizes, colors, and photos before saving.</span>
                        <div class="d-flex gap-2">
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary px-4 py-2 fw-semibold" style="border-radius: 8px;">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary px-5 py-2 fw-bold" style="border-radius: 8px; font-size: 15px;">
                                <i class="bx bx-check me-1"></i> Save & Publish Product
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    let variantIndex = 0;

    function handleImagePreview(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('imagePreview').src = e.target.result;
                document.getElementById('uploadPlaceholder').classList.add('d-none');
                document.getElementById('imagePreviewContainer').classList.remove('d-none');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewVariantPhoto(input, index) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var previewImg = document.getElementById('varPreview_' + index);
                if (previewImg) {
                    previewImg.src = e.target.result;
                    previewImg.classList.remove('d-none');
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function addVariantRow(color = '', size = '', price = '', comparePrice = '', stock = '') {
        document.getElementById('noVariantsMsg').classList.add('d-none');
        var defaultPrice = price !== '' ? price : (document.querySelector('input[name="price"]').value || '');
        var defaultCompare = comparePrice !== '' ? comparePrice : (document.querySelector('input[name="compare_at_price"]').value || '');
        var defaultStock = stock !== '' ? stock : (document.querySelector('input[name="stock"]').value || '10');

        var idx = variantIndex++;
        var tbody = document.getElementById('variantRowsContainer');
        var tr = document.createElement('tr');
        tr.id = 'variant_row_' + idx;
        tr.innerHTML = `
            <td style="padding: 12px 14px;">
                <input type="text" name="variants[${idx}][color]" class="form-control" value="${color}" placeholder="e.g. Royal Maroon" style="border-radius: 8px; padding: 8px 12px; font-size: 14px;">
            </td>
            <td style="padding: 12px 14px;">
                <input type="text" name="variants[${idx}][size]" class="form-control" value="${size}" placeholder="e.g. Small (10x10)" style="border-radius: 8px; padding: 8px 12px; font-size: 14px;">
            </td>
            <td style="padding: 12px 14px;">
                <input type="number" step="0.01" name="variants[${idx}][price]" class="form-control" value="${defaultPrice}" placeholder="₹ Selling Price" style="border-radius: 8px; padding: 8px 12px; font-size: 14px;">
            </td>
            <td style="padding: 12px 14px;">
                <input type="number" step="0.01" name="variants[${idx}][compare_at_price]" class="form-control" value="${defaultCompare}" placeholder="₹ Original Price" style="border-radius: 8px; padding: 8px 12px; font-size: 14px;">
            </td>
            <td style="padding: 12px 14px;">
                <input type="number" name="variants[${idx}][stock]" class="form-control" value="${defaultStock}" style="border-radius: 8px; padding: 8px 12px; font-size: 14px;">
            </td>
            <td style="padding: 12px 14px; text-align: center;">
                <div class="d-flex align-items-center justify-content-center gap-2">
                    <img id="varPreview_${idx}" src="#" class="rounded border d-none" style="width: 38px; height: 38px; object-fit: cover;">
                    <label class="btn btn-sm btn-outline-primary mb-0" style="cursor: pointer; padding: 6px 12px; border-radius: 6px; white-space: nowrap;">
                        <i class="bx bx-upload"></i> Photo
                        <input type="file" name="variants[${idx}][image]" accept="image/*" class="d-none" onchange="previewVariantPhoto(this, ${idx})">
                    </label>
                </div>
            </td>
            <td style="padding: 12px 14px; text-align: center;">
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeVariantRow(${idx})" style="border-radius: 6px; padding: 6px 10px;">
                    <i class="bx bx-trash"></i>
                </button>
            </td>
        `;
        tbody.appendChild(tr);
    }

    function removeVariantRow(idx) {
        var row = document.getElementById('variant_row_' + idx);
        if (row) {
            row.remove();
        }
        var tbody = document.getElementById('variantRowsContainer');
        if (tbody.children.length === 0) {
            document.getElementById('noVariantsMsg').classList.remove('d-none');
        }
    }

    function generateMatrixRows() {
        var colorsRaw = document.getElementById('genColors').value.trim();
        var sizesRaw = document.getElementById('genSizes').value.trim();

        var colors = colorsRaw ? colorsRaw.split(',').map(function(s){ return s.trim(); }).filter(Boolean) : [];
        var sizes = sizesRaw ? sizesRaw.split(',').map(function(s){ return s.trim(); }).filter(Boolean) : [];

        if (colors.length === 0 && sizes.length === 0) {
            alert('Please enter at least one color or size in the matrix generator fields.');
            return;
        }

        var basePrice = document.querySelector('input[name="price"]').value || '';
        var baseCompare = document.querySelector('input[name="compare_at_price"]').value || '';
        var baseStock = document.querySelector('input[name="stock"]').value || '10';

        if (colors.length > 0 && sizes.length > 0) {
            colors.forEach(function(c) {
                sizes.forEach(function(s) {
                    addVariantRow(c, s, basePrice, baseCompare, baseStock);
                });
            });
        } else if (colors.length > 0) {
            colors.forEach(function(c) {
                addVariantRow(c, '', basePrice, baseCompare, baseStock);
            });
        } else {
            sizes.forEach(function(s) {
                addVariantRow('', s, basePrice, baseCompare, baseStock);
            });
        }
    }
</script>
@endsection
