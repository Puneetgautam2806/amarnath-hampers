@extends('frontend.layouts.app')

@section('content')

    <!-- site-breadcrumb -->
    <div class="site-breadcrumb">
        <div class="site-breadcrumb-bg" style="background: url({{ asset('frontend/assets/img/banner/breadcrumb.jpg') }}) center center/cover no-repeat;"></div>
        <div class="container">
            <div class="site-breadcrumb-wrap">
                <h4 class="breadcrumb-title">{{ $post->title }}</h4>
                <ul class="breadcrumb-menu">
                    <li><a href="{{ route('home') }}"><i class="fas fa-home"></i> Home</a></li>
                    <li><a href="{{ route('blog.index') }}">Blog</a></li>
                    <li class="active">{{ Str::limit($post->title, 30) }}</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- site-breadcrumb end -->


    <!-- blog single area -->
    <div class="blog-single-area py-100">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="blog-single-wrap bg-white p-4 p-md-5 rounded-4 shadow-sm border">
                        <div class="blog-single-content">
                            @if ($post->featured_image)
                                <div class="blog-single-img mb-4 text-center">
                                    <img src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}" class="img-fluid rounded-4 shadow-sm" style="max-height: 480px; width: 100%; object-fit: cover;">
                                </div>
                            @endif

                            <div class="blog-meta-wrapper d-flex flex-wrap align-items-center justify-content-between border-bottom pb-3 mb-4 text-muted small">
                                <div class="d-flex align-items-center gap-3">
                                    <span><i class="fas fa-user-circle me-1 text-primary"></i> {{ $post->author_name ?? 'Amar Nath Hampers' }}</span>
                                    <span><i class="fas fa-calendar-alt me-1 text-primary"></i> {{ $post->published_at ? $post->published_at->format('F d, Y') : $post->created_at->format('F d, Y') }}</span>
                                </div>
                                <div>
                                    <span class="badge bg-label-primary text-primary px-3 py-2 fw-semibold">Agra Bespoke Gifting</span>
                                </div>
                            </div>

                            <h2 class="blog-single-title mb-4 fw-bold text-dark" style="line-height: 1.3;">{{ $post->title }}</h2>

                            @if($post->excerpt)
                                <div class="p-3 bg-light rounded-3 border-start border-4 border-primary mb-4 fst-italic text-dark fs-6" style="line-height: 1.6;">
                                    "{{ $post->excerpt }}"
                                </div>
                            @endif

                            <div class="blog-single-body text-dark" style="font-size: 16px; line-height: 1.8;">
                                {!! nl2br(e($post->content)) !!}
                            </div>

                            <hr class="my-5">

                            <!-- Social Share and Tags -->
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 bg-light p-3 rounded-3 border">
                                <div class="fw-bold text-dark">
                                    <i class="fas fa-share-alt me-1 text-primary"></i> Share Article:
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="https://api.whatsapp.com/send?text={{ rawurlencode($post->title . ' - ' . url()->current()) }}" target="_blank" class="btn btn-sm btn-success px-3" style="border-radius: 6px;">
                                        <i class="fab fa-whatsapp me-1"></i> WhatsApp
                                    </a>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ rawurlencode(url()->current()) }}" target="_blank" class="btn btn-sm btn-primary px-3" style="border-radius: 6px;">
                                        <i class="fab fa-facebook-f me-1"></i> Facebook
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url={{ rawurlencode(url()->current()) }}&text={{ rawurlencode($post->title) }}" target="_blank" class="btn btn-sm btn-dark px-3" style="border-radius: 6px;">
                                        <i class="fab fa-x-twitter me-1"></i> X / Twitter
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- blog sidebar -->
                <div class="col-lg-4">
                    <aside class="sidebar p-4 bg-light rounded-4 border shadow-sm">
                        <!-- search -->
                        <div class="widget search mb-4">
                            <h5 class="widget-title mb-3 fw-bold text-dark">Search Articles</h5>
                            <form action="{{ route('blog.index') }}" method="GET">
                                <div class="form-group position-relative">
                                    <input type="text" name="search" class="form-control" placeholder="Search blog topics..." style="border-radius: 10px; padding: 12px 16px;">
                                    <button type="submit" class="btn position-absolute top-50 end-0 translate-middle-y me-2 text-primary border-0 bg-transparent">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- recent posts -->
                        <div class="widget recent-post mb-4">
                            <h5 class="widget-title mb-3 fw-bold text-dark">More Stories</h5>
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
                                <p class="text-muted small">No other articles available.</p>
                            @endforelse
                        </div>

                        <!-- categories widget -->
                        <div class="widget category mb-4">
                            <h5 class="widget-title mb-3 fw-bold text-dark">Hamper Categories</h5>
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
    <!-- blog single area end -->

@endsection
