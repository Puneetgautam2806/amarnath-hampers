@extends('backoffice.master_layout')

@section('title', 'Manage Blog Posts')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px;">
            <i class="bx bx-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 text-dark fw-bold">Blog Articles & News</h4>
            <span class="text-muted small">Create and manage your articles, trousseau tips, and wedding hampers updates</span>
        </div>
        <a href="{{ route('posts.create') }}" class="btn btn-primary px-4 py-2" style="border-radius: 10px; font-weight: 600;">
            <i class="bx bx-plus me-1"></i> Write New Article
        </a>
    </div>

    <div class="card border-0" style="border-radius: 16px; box-shadow: 0 8px 26px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.05);">
        <div class="card-header border-bottom py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-dark fw-bold">All Blog Posts</h5>
            <span class="badge bg-label-primary px-3 py-2 fw-semibold" style="border-radius: 6px;">Total: {{ $posts->total() }} Articles</span>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="font-weight: 700; color: #566a7f;">Thumbnail</th>
                        <th style="font-weight: 700; color: #566a7f;">Title & Excerpt</th>
                        <th style="font-weight: 700; color: #566a7f;">Author</th>
                        <th style="font-weight: 700; color: #566a7f;">Status</th>
                        <th style="font-weight: 700; color: #566a7f;">Published Date</th>
                        <th style="font-weight: 700; color: #566a7f; text-align: right; padding-right: 24px;">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($posts as $post)
                        <tr>
                            <td>
                                @if ($post->featured_image)
                                    <img src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}" style="width: 60px; height: 45px; object-fit: cover; border-radius: 8px; border: 1px solid #eee;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center text-muted" style="width: 60px; height: 45px; border-radius: 8px; font-size: 11px;">No img</div>
                                @endif
                            </td>
                            <td>
                                <strong class="text-dark fw-semibold d-block">{{ Str::limit($post->title, 45) }}</strong>
                                <small class="text-muted">{{ Str::limit($post->excerpt, 60) }}</small>
                            </td>
                            <td>
                                <span class="badge bg-label-secondary px-2 py-1"><i class="bx bx-user me-1"></i> {{ $post->author_name ?? 'Admin' }}</span>
                            </td>
                            <td>
                                @if ($post->status == 1)
                                    <span class="badge bg-label-success px-3 py-2 fw-semibold" style="border-radius: 6px;"><i class="bx bx-check me-1"></i> Published</span>
                                @else
                                    <span class="badge bg-label-warning px-3 py-2 fw-semibold" style="border-radius: 6px;"><i class="bx bx-time-five me-1"></i> Draft</span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">{{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }}</small>
                            </td>
                            <td style="text-align: right; padding-right: 24px;">
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="btn btn-sm btn-icon btn-outline-secondary" style="border-radius: 8px;" title="View Live">
                                        <i class="bx bx-show"></i>
                                    </a>
                                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-icon btn-outline-primary" style="border-radius: 8px;" title="Edit Article">
                                        <i class="bx bx-edit"></i>
                                    </a>
                                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this blog post?')" style="margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-icon btn-outline-danger" style="border-radius: 8px;" title="Delete Article">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bx bx-news text-muted d-block mb-3" style="font-size: 48px;"></i>
                                <span class="text-muted">No Blog Articles Published Yet. Click "Write New Article" to add one!</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($posts->hasPages())
            <div class="card-footer border-top py-3">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
</div>
@endsection