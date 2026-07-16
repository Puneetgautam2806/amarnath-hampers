@extends('backoffice.master_layout')

@section('title', 'Edit Banner Slide')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-xl-9 col-lg-10">
            <form action="{{ route('homepage.updateSlider', $slider) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="card mb-6" style="border-radius: 16px; box-shadow: 0 8px 26px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.05);">
                    <div class="card-header d-flex justify-content-between align-items-center border-bottom py-4">
                        <div>
                            <h4 class="mb-0 text-dark" style="font-weight: 700;">Edit Banner Slide</h4>
                            <span class="text-muted small">Update slide graphics or banner text</span>
                        </div>
                        <a href="{{ route('homepage.index', ['tab' => 'sliders']) }}" class="btn btn-outline-secondary btn-sm" style="border-radius: 8px;">
                            <i class="bx bx-left-arrow-alt me-1"></i> Back to Sliders
                        </a>
                    </div>
                    <div class="card-body pt-6">
                        <div class="row align-items-center">
                            <!-- Background Graphic Preview & Selector -->
                            <div class="col-md-6 border-end">
                                <label class="form-label fw-bold text-secondary mb-2">Background Graphic (Click to Update)</label>
                                <div class="p-3 rounded text-center mb-3 d-flex flex-column align-items-center justify-content-center" style="background-color: #f8f9fa; border: 2px dashed #d9dee3; height: 230px;">
                                    <div class="image-preview-container-modal w-100 h-100 d-flex align-items-center justify-content-center" id="image-preview">
                                        @if($slider->image_path)
                                            <img src="{{ asset($slider->image_path) }}" alt="Slider Banner" style="max-width: 100%; max-height: 100%; object-fit: contain; border-radius: 8px;">
                                        @else
                                            <span class="text-muted small italic">No image selected.</span>
                                        @endif
                                    </div>
                                    <input class="form-control position-absolute opacity-0" type="file" name="image" id="image" accept="image/*" onchange="previewFile()" style="height: 200px; width: 330px; cursor: pointer; z-index: 10;">
                                </div>
                                <span class="text-muted small text-center d-block">Uploaded images scale, center-crop, and fit automatically.</span>
                            </div>

                            <!-- Main Title Details -->
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold" for="title">Slide Title (Required)</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-heading"></i></span>
                                        <input type="text" class="form-control py-2" id="title" name="title" value="{{ old('title', $slider->title) }}" placeholder="e.g. Elegant hampers" required>
                                    </div>
                                    <span class="text-muted small d-block mt-1">Main banner text. Use <code>&lt;br&gt;</code> to create line breaks.</span>
                                </div>

                                <!-- Collapse toggle button -->
                                <div>
                                    <button class="btn btn-outline-secondary w-100 fw-bold py-2" type="button" data-bs-toggle="collapse" data-bs-target="#editSliderAdvanced" aria-expanded="false" aria-controls="editSliderAdvanced" style="border-radius: 8px;">
                                        <i class="bx bx-slider-alt me-1"></i> Edit Optional details & Buttons
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Collapsible Advanced Sliders Section -->
                        <div class="collapse mt-5" id="editSliderAdvanced">
                            <div class="card card-body p-4 bg-light border" style="border-radius: 12px; border-style: dashed !important; border-width: 1px !important;">
                                
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label small fw-bold" for="subtitle">Subtitle / Category Badge</label>
                                        <input type="text" class="form-control form-control-sm" id="subtitle" name="subtitle" value="{{ old('subtitle', $slider->subtitle) }}" placeholder="e.g. Exclusive Hamper">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small fw-bold" for="orders">Display Sort Order</label>
                                        <input type="number" class="form-control form-control-sm" id="orders" name="orders" value="{{ old('orders', $slider->orders) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small fw-bold" for="status">Status</label>
                                        <select class="form-select form-select-sm" id="status" name="status">
                                            <option value="1" {{ old('status', $slider->status) == '1' ? 'selected' : '' }}>Active (Visible)</option>
                                            <option value="2" {{ old('status', $slider->status) == '2' ? 'selected' : '' }}>Inactive (Draft)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label small fw-bold" for="description">Description / Paragraph Text</label>
                                    <textarea class="form-control form-control-sm" id="description" name="description" rows="2" placeholder="Brief description to capture interest...">{{ old('description', $slider->description) }}</textarea>
                                </div>

                                <div class="row">
                                    <!-- Button 1 -->
                                    <div class="col-md-6 border-end">
                                        <h6 class="text-primary fw-bold mb-2 small"><i class="bx bx-link me-1"></i> Button 1 (Primary Action)</h6>
                                        <div class="mb-2">
                                            <input type="text" class="form-control form-control-sm" name="btn1_text" value="{{ old('btn1_text', $slider->btn1_text) }}" placeholder="Button Text (e.g. Shop Now)">
                                        </div>
                                        <div>
                                            <input type="text" class="form-control form-control-sm" name="btn1_link" value="{{ old('btn1_link', $slider->btn1_link) }}" placeholder="Button Link (e.g. /shop)">
                                        </div>
                                    </div>
                                    <!-- Button 2 -->
                                    <div class="col-md-6">
                                        <h6 class="text-success fw-bold mb-2 small"><i class="bx bx-link me-1"></i> Button 2 (Secondary Action)</h6>
                                        <div class="mb-2">
                                            <input type="text" class="form-control form-control-sm" name="btn2_text" value="{{ old('btn2_text', $slider->btn2_text) }}" placeholder="Button Text (e.g. Learn More)">
                                        </div>
                                        <div>
                                            <input type="text" class="form-control form-control-sm" name="btn2_link" value="{{ old('btn2_link', $slider->btn2_link) }}" placeholder="Button Link (e.g. /about)">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="card-footer border-top py-4 px-5 text-end" style="background: #f8f9fa; border-bottom-left-radius: 16px; border-bottom-right-radius: 16px;">
                        <a href="{{ route('homepage.index', ['tab' => 'sliders']) }}" class="btn btn-outline-secondary px-4 me-2" style="border-radius: 8px;">Cancel</a>
                        <button type="submit" class="btn btn-primary px-5 fw-bold" style="border-radius: 8px;"><i class="bx bx-check-circle me-1"></i> Update Banner Slide</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewFile() {
    const preview = document.getElementById('image-preview');
    const file = document.getElementById('image').files[0];
    const reader = new FileReader();

    reader.addEventListener("load", function () {
        preview.innerHTML = `<img src="${reader.result}" alt="Preview" style="max-width: 100%; max-height: 100%; object-fit: contain; border-radius: 8px;">`;
    }, false);

    if (file) {
        reader.readAsDataURL(file);
    }
}
</script>
@endsection
