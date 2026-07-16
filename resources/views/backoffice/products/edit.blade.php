@extends('backoffice.master_layout')

@section('title', 'Edit Product')

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
            <h4 class="mb-0 text-dark fw-bold">Edit Product: {{ $product->name }}</h4>
            <span class="text-muted small">Update your gift hamper configurations, prices, and media settings</span>
        </div>
        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary px-4 py-2" style="border-radius: 10px; font-weight: 600;">
            <i class="bx bx-arrow-back me-1"></i> Back to Products
        </a>
    </div>

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
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
                            <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required style="border-radius: 8px; padding: 10px 14px;">
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-dark fw-semibold">Short Description</label>
                            <textarea name="short_description" class="form-control" rows="3" style="border-radius: 8px;">{{ old('short_description', $product->short_description) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-dark fw-semibold">Full Product Description</label>
                            <textarea name="description" class="form-control" rows="8" style="border-radius: 8px;">{{ old('description', $product->description) }}</textarea>
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
                            <div class="col-md-6 mb-4">
                                <label class="form-label text-dark fw-semibold">Selling Price ($) *</label>
                                <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $product->price) }}" required style="border-radius: 8px; padding: 10px 14px;">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label text-dark fw-semibold">Discounted / Original Price ($)</label>
                                <input type="number" step="0.01" name="compare_at_price" class="form-control" value="{{ old('compare_at_price', $product->compare_at_price) }}" style="border-radius: 8px; padding: 10px 14px;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label text-dark fw-semibold">Inventory / Stock Count *</label>
                                <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" required style="border-radius: 8px; padding: 10px 14px;">
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
                        <h5 class="mb-0 text-dark fw-bold">Product Thumbnail</h5>
                    </div>
                    <div class="card-body pt-6">
                        <!-- Premium Interactive Drag Area -->
                        <div class="text-center p-5 border border-dashed rounded-3" style="cursor: pointer; background: #fafbfc; border-color: #d9dee3; border-radius: 12px; position: relative;" id="imageUploadCard" onclick="document.getElementById('imageInput').click();">
                            <input type="file" name="image" id="imageInput" class="d-none" accept="image/*" onchange="handleImagePreview(this);">
                            
                            @if ($product->image)
                                <div id="uploadPlaceholder" class="d-none">
                                    <i class="bx bx-cloud-upload text-muted mb-2" style="font-size: 40px;"></i>
                                    <h6 class="mb-1 text-dark fw-semibold">Upload Photo</h6>
                                    <span class="text-muted small d-block">Supports JPEG, PNG, WEBP (Max 3MB)</span>
                                </div>
                                <div id="imagePreviewContainer">
                                    <img id="imagePreview" src="{{ asset($product->image) }}" alt="Preview" style="max-width: 100%; max-height: 220px; object-fit: cover; border-radius: 8px; border: 1px solid rgba(0,0,0,0.1);">
                                    <span class="text-primary small d-block mt-2 fw-semibold">Change Photo</span>
                                </div>
                            @else
                                <div id="uploadPlaceholder">
                                    <i class="bx bx-cloud-upload text-muted mb-2" style="font-size: 40px;"></i>
                                    <h6 class="mb-1 text-dark fw-semibold">Upload Photo</h6>
                                    <span class="text-muted small d-block">Supports JPEG, PNG, WEBP (Max 3MB)</span>
                                </div>
                                <div id="imagePreviewContainer" class="d-none">
                                    <img id="imagePreview" src="#" alt="Preview" style="max-width: 100%; max-height: 220px; object-fit: cover; border-radius: 8px; border: 1px solid rgba(0,0,0,0.1);">
                                    <span class="text-primary small d-block mt-2 fw-semibold">Change Photo</span>
                                </div>
                            @endif
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
                                <option value="" disabled>Select dynamic category</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $cat->id == $product->category_id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-dark fw-semibold">Status *</label>
                            <select name="status" class="form-select" required style="border-radius: 8px; padding: 10px 14px;">
                                <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Active / Visible</option>
                                <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Inactive / Hidden</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-dark fw-semibold">Featured Product *</label>
                            <select name="is_featured" class="form-select" required style="border-radius: 8px; padding: 10px 14px;">
                                <option value="0" {{ $product->is_featured == 0 ? 'selected' : '' }}>Standard Display</option>
                                <option value="1" {{ $product->is_featured == 1 ? 'selected' : '' }}>Featured (Highlight on Home Showcase)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Actions card -->
                <div class="card border-0" style="border-radius: 16px; box-shadow: 0 8px 26px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.05);">
                    <div class="card-body py-4">
                        <button type="submit" class="btn btn-primary w-100 py-3 mb-2 fw-bold" style="border-radius: 10px; font-size: 15px;">
                            <i class="bx bx-check me-1"></i> Save Changes
                        </button>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary w-100 py-3 fw-semibold" style="border-radius: 10px; font-size: 15px;">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function handleImagePreview(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('imagePreview').src = e.target.result;
                document.getElementById('uploadPlaceholder').classList.add('d-none');
                
                // Show container if it was hidden
                var previewCont = document.getElementById('imagePreviewContainer');
                previewCont.classList.remove('d-none');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
