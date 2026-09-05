@extends('backoffice.master_layout')

@section('title', 'Edit Blog Article')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 text-dark fw-bold">Edit Blog Article</h4>
            <span class="text-muted small">Update content, image, or publishing status</span>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="btn btn-outline-info px-3 py-2" style="border-radius: 10px; font-weight: 600;">
                <i class="bx bx-show me-1"></i> View Live
            </a>
            <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary px-4 py-2" style="border-radius: 10px; font-weight: 600;">
                <i class="bx bx-arrow-back me-1"></i> Back to Articles
            </a>
        </div>
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
            <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-lg-8">
                        <div class="mb-3">
                            <label class="form-label text-dark fw-semibold">Article Title *</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $post->title) }}" required style="border-radius: 8px;">
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-dark fw-semibold">Custom URL Slug</label>
                            <input type="text" name="slug" class="form-control" value="{{ old('slug', $post->slug) }}" style="border-radius: 8px;">
                            <small class="text-muted">Current URL: <code>/blog/{{ $post->slug }}</code></small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-dark fw-semibold">Short Excerpt / Summary</label>
                            <textarea name="excerpt" class="form-control" rows="3" style="border-radius: 8px;">{{ old('excerpt', $post->excerpt) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-dark fw-semibold">Article Content *</label>
                            <textarea name="content" class="form-control" rows="12" required style="border-radius: 8px;">{{ old('content', $post->content) }}</textarea>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="p-3 bg-light rounded-3 mb-3 border">
                            <h6 class="fw-bold mb-3 text-dark">Publishing Settings</h6>

                            <div class="mb-3">
                                <label class="form-label text-dark fw-semibold">Status *</label>
                                <select name="status" class="form-select" required style="border-radius: 8px;">
                                    <option value="1" {{ old('status', $post->status) == 1 ? 'selected' : '' }}>Published (Active on site)</option>
                                    <option value="2" {{ old('status', $post->status) == 2 ? 'selected' : '' }}>Draft (Hidden from public)</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-dark fw-semibold">Author Name</label>
                                <input type="text" name="author_name" class="form-control" value="{{ old('author_name', $post->author_name) }}" style="border-radius: 8px;">
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-dark fw-semibold">Publish Date</label>
                                <input type="datetime-local" name="published_at" class="form-control" value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}" style="border-radius: 8px;">
                            </div>
                        </div>

                        <div class="p-3 bg-light rounded-3 border">
                            <h6 class="fw-bold mb-2 text-dark">Featured Image</h6>
                            <p class="small text-muted mb-3">Upload a new image only if you want to replace the current one.</p>
                            
                            @if ($post->featured_image)
                                <div class="mb-3 text-center">
                                    <span class="d-block small text-muted mb-1">Current Image:</span>
                                    <img src="{{ asset($post->featured_image) }}" alt="Current Image" class="img-fluid rounded border" style="max-height: 140px;">
                                </div>
                            @endif

                            <input type="file" name="featured_image" id="featuredImgInput" class="form-control mb-2" accept="image/*" style="border-radius: 8px;" onchange="previewFeaturedImage(this);">
                            
                            <div id="imagePreviewContainer" class="mt-2 text-center d-none">
                                <span class="d-block small text-muted mb-1">New Image Preview:</span>
                                <img id="imagePreview" src="#" alt="Preview" class="img-fluid rounded border" style="max-height: 140px;">
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary" style="border-radius: 8px;">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4" style="border-radius: 8px; font-weight: 600;">
                        <i class="bx bx-save me-1"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewFeaturedImage(input) {
    var container = document.getElementById('imagePreviewContainer');
    var preview = document.getElementById('imagePreview');
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