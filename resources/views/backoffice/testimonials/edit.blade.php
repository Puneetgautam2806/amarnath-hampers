@extends('backoffice.master_layout')

@section('title', 'Edit Client Review / Testimonial')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 text-dark fw-bold">Edit Client Testimonial</h4>
            <span class="text-muted small">Update review details, client info, or rating</span>
        </div>
        <a href="{{ route('testimonials.index') }}" class="btn btn-outline-secondary px-4 py-2" style="border-radius: 10px; font-weight: 600;">
            <i class="bx bx-arrow-back me-1"></i> Back to Reviews
        </a>
    </div>

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

    <div class="card border-0" style="border-radius: 16px; box-shadow: 0 8px 26px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.05);">
        <div class="card-body p-4">
            <form action="{{ route('testimonials.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-dark fw-semibold">Client Full Name *</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $testimonial->name) }}" required style="border-radius: 8px;">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-dark fw-semibold">Client Designation / Location</label>
                                <input type="text" name="designation" class="form-control" value="{{ old('designation', $testimonial->designation) }}" placeholder="e.g. Wedding Client, Agra" style="border-radius: 8px;">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-dark fw-semibold">Review / Feedback Quote *</label>
                            <textarea name="review_text" class="form-control" rows="5" required style="border-radius: 8px;">{{ old('review_text', $testimonial->review_text) }}</textarea>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="p-3 bg-light rounded-3 mb-3 border">
                            <h6 class="fw-bold mb-3 text-dark">Rating & Display Options</h6>

                            <div class="mb-3">
                                <label class="form-label text-dark fw-semibold">Star Rating *</label>
                                <select name="rating" class="form-select" required style="border-radius: 8px;">
                                    <option value="5" {{ old('rating', $testimonial->rating) == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5 Stars - Excellent)</option>
                                    <option value="4" {{ old('rating', $testimonial->rating) == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ (4 Stars - Very Good)</option>
                                    <option value="3" {{ old('rating', $testimonial->rating) == 3 ? 'selected' : '' }}>⭐⭐⭐ (3 Stars - Good)</option>
                                    <option value="2" {{ old('rating', $testimonial->rating) == 2 ? 'selected' : '' }}>⭐⭐ (2 Stars - Fair)</option>
                                    <option value="1" {{ old('rating', $testimonial->rating) == 1 ? 'selected' : '' }}>⭐ (1 Star - Poor)</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-dark fw-semibold">Display Sort Order</label>
                                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $testimonial->sort_order) }}" style="border-radius: 8px;">
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-dark fw-semibold">Status *</label>
                                <select name="status" class="form-select" required style="border-radius: 8px;">
                                    <option value="1" {{ old('status', $testimonial->status) == 1 ? 'selected' : '' }}>Active (Visible on Homepage)</option>
                                    <option value="2" {{ old('status', $testimonial->status) == 2 ? 'selected' : '' }}>Hidden / Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="p-3 bg-light rounded-3 border">
                            <h6 class="fw-bold mb-2 text-dark">Client Avatar / Photo</h6>
                            
                            @if ($testimonial->photo)
                                <div class="mb-3 text-center">
                                    <span class="d-block small text-muted mb-1">Current Photo:</span>
                                    <img src="{{ asset($testimonial->photo) }}" alt="Current Photo" class="rounded-circle border" style="width: 80px; height: 80px; object-fit: cover;">
                                </div>
                            @endif

                            <input type="file" name="photo" class="form-control mb-2" accept="image/*" style="border-radius: 8px;" onchange="previewAvatar(this);">
                            
                            <div id="avatarPreviewContainer" class="mt-2 text-center d-none">
                                <span class="d-block small text-muted mb-1">New Photo Preview:</span>
                                <img id="avatarPreview" src="#" alt="Preview" class="rounded-circle border" style="width: 80px; height: 80px; object-fit: cover;">
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('testimonials.index') }}" class="btn btn-outline-secondary" style="border-radius: 8px;">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4" style="border-radius: 8px; font-weight: 600;">
                        <i class="bx bx-save me-1"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewAvatar(input) {
    var container = document.getElementById('avatarPreviewContainer');
    var preview = document.getElementById('avatarPreview');
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            container.classList.remove('d-none');
        }
        reader.readAsDataURL(input.files[0]);
    } else {
        container.classList.add('d-none');
    }
}
</script>
@endsection