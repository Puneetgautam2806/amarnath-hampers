@extends('frontend.layouts.app')

@section('content')

    <!-- site-breadcrumb -->
    <div class="site-breadcrumb">
        <div class="site-breadcrumb-bg" style="background: url({{ asset('frontend/assets/img/banner/breadcrumb.jpg') }}) center center/cover no-repeat;"></div>
        <div class="container">
            <div class="site-breadcrumb-wrap">
                <h4 class="breadcrumb-title">Our Blog & Stories</h4>
                <ul class="breadcrumb-menu">
                    <li><a href="{{ route('home') }}"><i class="fas fa-home"></i> Home</a></li>
                    <li class="active">Blog</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- site-breadcrumb end -->


    <!-- blog-area -->
    <div class="blog-area py-100">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="row g-4">
                        @forelse ($posts as $post)
                            <div class="col-md-6">
                                <div class="blog-item shadow-sm border rounded-3 overflow-hidden h-100 d-flex flex-column">
                                    <div class="blog-item-img">
                                        @if ($post->featured_image)
                                            <img src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}" style="width: 100%; height: 220px; object-fit: cover;">
                                        @else
                                            <img src="{{ asset('frontend/assets/img/blog/01.jpg') }}" alt="{{ $post->title }}" style="width: 100%; height: 220px; object-fit: cover;">
                                        @endif
                                        <span class="blog-date">
                                            <i class="fas fa-calendar-alt"></i> 
                                            {{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }}
                                        </span>
                                    </div>
                                    <div class="blog-item-info p-4 d-flex flex-column flex-grow-1">
                                        <div class="blog-item-meta mb-2">
                                            <ul>
                                                <li><a href="#"><i class="fas fa-user-circle"></i> {{ $post->author_name ?? 'Amar Nath Hampers' }}</a></li>
                                            </ul>
                                        </div>
                                        <h4 class="blog-title mb-2 fs-5">
                                            <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                                        </h4>
                                        <p class="text-muted flex-grow-1" style="font-size: 14px; line-height: 1.6;">{{ Str::limit($post->excerpt, 110) }}</p>
                                        <div class="mt-3">
                                            <a class="theme-btn py-2 px-3" style="font-size: 14px;" href="{{ route('blog.show', $post->slug) }}">Read Article <i class="fas fa-arrow-right ms-1"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-5">
                                <i class="fas fa-newspaper text-muted fs-1 mb-3"></i>
                                <h4 class="text-dark">No Articles Found</h4>
                                <p class="text-muted">We haven't published any articles matching your search criteria yet.</p>
                                <a href="{{ route('blog.index') }}" class="theme-btn mt-2">View All Articles</a>
                            </div>
                        @endforelse
                    </div>

                    <!-- pagination -->
                    @if ($posts->hasPages())
                        <div class="pagination-area mt-5">
                            {{ $posts->links() }}
                        </div>
                    @endif
                </div>

                <!-- blog sidebar -->
                <div class="col-lg-4">
                    <aside class="sidebar p-4 bg-light rounded-4 border shadow-sm">
                        <!-- search -->
                        <div class="widget search mb-4">
                            <h5 class="widget-title mb-3 fw-bold text-dark">Search Articles</h5>
                            <form action="{{ route('blog.index') }}" method="GET">
                                <div class="form-group position-relative">
                                    <input type="text" name="search" class="form-control" placeholder="Search blog topics..." value="{{ request('search') }}" style="border-radius: 10px; padding: 12px 16px;">
                                    <button type="submit" class="btn position-absolute top-50 end-0 translate-middle-y me-2 text-primary border-0 bg-transparent">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- recent posts -->
                        <div class="widget recent-post mb-4">
                            <h5 class="widget-title mb-3 fw-bold text-dark">Recent Articles</h5>
                            <hr class="my-2">
                            @forelse ($recentPosts as $rPost)
                                <div class="recent-post-single d-flex align-items-center gap-3 py-2 border-bottom">
                                    <div class="recent-post-img flex-shrink-0">
                                        @if ($rPost->featured_image)
                                            <img src="{{ asset($rPost->featured_image) }}" alt="{{ $rPost->title }}" style="width: 65px; height: 60px; object-fit: cover; border-radius: 8px;">
                                        @else
                                            <img src="{{ asset('frontend/assets/img/blog/01.jpg') }}" alt="{{ $rPost->title }}" style="width: 65px; height: 60px; object-fit: cover; border-radius: 8px;">
                                        @endif
                                    </div>
                                    <div class="recent-post-bio">
                                        <h6 class="mb-1" style="font-size: 14px; line-height: 1.4;">
                                            <a href="{{ route('blog.show', $rPost->slug) }}" class="text-dark fw-semibold">{{ Str::limit($rPost->title, 45) }}</a>
                                        </h6>
                                        <span class="text-muted small"><i class="fas fa-calendar-alt me-1"></i> {{ $rPost->published_at ? $rPost->published_at->format('M d, Y') : $rPost->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted small">No recent articles.</p>
                            @endforelse
                        </div>

                        <!-- category widget -->
                        <div class="widget category mb-4">
                            <h5 class="widget-title mb-3 fw-bold text-dark">Hamper Collections</h5>
                            <hr class="my-2">
                            <ul class="list-unstyled mb-0">
                                @foreach ($categories as $cat)
                                    <li class="py-2 d-flex justify-content-between align-items-center border-bottom">
                                        <a href="{{ route('shop.index', ['category' => $cat->slug]) }}" class="text-dark fw-medium">{{ $cat->name }}</a>
                                        <span class="badge bg-secondary rounded-pill">{{ $cat->products_count }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </div>
    <!-- blog-area end -->

@endsection
