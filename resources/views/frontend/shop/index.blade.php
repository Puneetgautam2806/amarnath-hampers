@extends('frontend.layouts.app')

@section('content')

    <!-- breadcrumb -->
    <div class="site-breadcrumb-wrap" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('frontend/assets/img/banner/big-banner.jpg') }}') no-repeat center center; background-size: cover; padding: 80px 0;">
        <div class="container">
            <div class="site-breadcrumb-content text-center text-white">
                <h2 class="breadcrumb-title text-white" style="font-size: 2.5rem; font-weight: 700; margin-bottom: 10px;">
                    @if(request('category'))
                        {{ ucwords(str_replace('-', ' ', request('category'))) }}
                    @else
                        Premium Gift Hampers
                    @endif
                </h2>
                <ul class="breadcrumb-menu d-flex justify-content-center gap-2 list-unstyled">
                    <li><a href="{{ route('home') }}" class="text-white opacity-75">Home</a></li>
                    <li class="text-white opacity-50">/</li>
                    <li class="active text-white">Shop</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- breadcrumb end -->

    <!-- shop area -->
    <div class="shop-area py-100" style="padding: 80px 0;">
        <div class="container">
            <div class="row">
                <!-- Sidebar Filters -->
                <div class="col-lg-3">
                    <div class="shop-sidebar p-4 bg-white rounded shadow-sm border mb-5">
                        
                        <!-- Search Widget -->
                        <div class="shop-sidebar-widget mb-4 pb-4 border-bottom">
                            <h4 class="shop-sidebar-title font-weight-bold mb-3" style="font-size: 1.1rem; color: #333; border-left: 3px solid #ff7c8b; padding-left: 10px;">Search Hampers</h4>
                            <div class="shop-sidebar-search position-relative">
                                <form action="{{ route('shop.index') }}" method="GET">
                                    @if(request('category'))
                                        <input type="hidden" name="category" value="{{ request('category') }}">
                                    @endif
                                    <input type="text" name="search" class="form-control rounded-pill pr-5" style="border: 1px solid #ddd; padding: 10px 20px;" placeholder="Search our hampers..." value="{{ request('search') }}">
                                    <button type="submit" class="btn position-absolute" style="right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #ff7c8b;"><i class="fas fa-search"></i></button>
                                </form>
                            </div>
                        </div>

                        <!-- Categories Widget -->
                        <div class="shop-sidebar-widget mb-4 pb-4">
                            <h4 class="shop-sidebar-title font-weight-bold mb-3" style="font-size: 1.1rem; color: #333; border-left: 3px solid #ff7c8b; padding-left: 10px;">Categories</h4>
                            <ul class="shop-sidebar-category list-unstyled m-0 p-0">
                                <li class="mb-2">
                                    <a href="{{ route('shop.index', ['search' => request('search')]) }}" class="d-flex justify-content-between align-items-center text-dark text-decoration-none p-2 rounded {{ !request('category') ? 'bg-light font-weight-bold text-pink' : '' }}" style="transition: all 0.2s; {{ !request('category') ? 'color: #ff7c8b !important;' : '' }}">
                                        <span><i class="fas fa-chevron-right mr-2 text-muted"></i> All Products</span>
                                        <span class="badge badge-pill badge-secondary bg-dark text-white">{{ \App\Models\Product::where('status', 1)->count() }}</span>
                                    </a>
                                </li>
                                @foreach($categories as $cat)
                                @php $pCount = $cat->products()->where('status', 1)->count(); @endphp
                                <li class="mb-2">
                                    <a href="{{ route('shop.index', ['category' => $cat->slug, 'search' => request('search')]) }}" class="d-flex justify-content-between align-items-center text-dark text-decoration-none p-2 rounded {{ request('category') == $cat->slug ? 'bg-light font-weight-bold text-pink' : '' }}" style="transition: all 0.2s; {{ request('category') == $cat->slug ? 'color: #ff7c8b !important;' : '' }}">
                                        <span><i class="fas fa-chevron-right mr-2 text-muted"></i> {{ $cat->name }}</span>
                                        <span class="badge badge-pill badge-secondary bg-pink text-white" style="background-color: #ff7c8b;">{{ $pCount }}</span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="col-lg-9">
                    <div class="shop-products-wrap">
                        
                        <!-- Top Filter Bar -->
                        <div class="shop-filter-bar d-flex justify-content-between align-items-center mb-4 p-3 bg-light rounded border">
                            <div class="shop-filter-info text-muted">
                                Showing 1-{{ $products->count() }} of {{ $products->total() }} premium results
                            </div>
                            @if(request('search') || request('category'))
                                <a href="{{ route('shop.index') }}" class="btn btn-sm btn-outline-danger rounded-pill"><i class="fas fa-times-circle"></i> Clear Filters</a>
                            @endif
                        </div>

                        <!-- Products List -->
                        @if($products->isEmpty())
                            <div class="text-center py-5 rounded bg-white shadow-sm border">
                                <i class="fas fa-shopping-bag fa-4x mb-3 text-muted"></i>
                                <h3 class="font-weight-bold mb-2">No Gift Hampers Found</h3>
                                <p class="text-muted">We couldn't find any products matching your selection. Try clearing filters or using another search word.</p>
                                <a href="{{ route('shop.index') }}" class="btn btn-primary rounded-pill mt-3 px-4" style="background-color: #ff7c8b; border-color: #ff7c8b;">View All Hampers</a>
                            </div>
                        @else
                            <div class="row">
                                @foreach($products as $product)
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="product-item tilt-3d border rounded p-3 bg-white shadow-sm position-relative d-flex flex-column h-100" style="transition: all 0.3s;">
                                        <div class="product-img text-center overflow-hidden mb-3 position-relative rounded" style="background-color: #fcf8f8; height: 230px; display: flex; align-items: center; justify-content: center;">
                                            @if($product->compare_at_price > $product->price)
                                                @php
                                                    $discount = round((($product->compare_at_price - $product->price) / $product->compare_at_price) * 100);
                                                @endphp
                                                <span class="product-badge badge bg-danger text-white position-absolute" style="top: 10px; left: 10px; z-index: 5; border-radius: 4px; font-weight: 600;">-{{ $discount }}% Off</span>
                                            @elseif($product->is_featured)
                                                <span class="product-badge badge bg-warning text-dark position-absolute" style="top: 10px; left: 10px; z-index: 5; border-radius: 4px; font-weight: 600;">Featured</span>
                                            @endif

                                            <a href="{{ route('shop.show', $product->slug) }}" class="w-100">
                                                <img src="{{ asset($product->image) }}" class="img-fluid p-2" style="max-height: 200px; object-fit: contain; transition: transform 0.5s;" alt="{{ $product->name }}">
                                            </a>
                                            
                                            <div class="product-action-wrap position-absolute w-100 text-center" style="bottom: -50px; left: 0; transition: all 0.3s; background: rgba(255,255,255,0.9); padding: 8px 0;">
                                                <div class="product-action">
                                                    <a href="{{ route('shop.show', $product->slug) }}" class="btn btn-sm btn-outline-dark rounded-circle mx-1" data-bs-toggle="tooltip" title="Quick View"><i class="fas fa-eye"></i></a>
                                                    
                                                    <form id="wl-form-shop-{{ $product->id }}" action="{{ route('wishlist.add') }}" method="POST" class="d-none">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    </form>
                                                    <a href="#" onclick="event.preventDefault(); document.getElementById('wl-form-shop-{{ $product->id }}').submit();" class="btn btn-sm btn-outline-dark rounded-circle mx-1" data-bs-toggle="tooltip" title="Add To Wishlist">
                                                        <i class="fas fa-heart"></i>
                                                    </a>

                                                    <form id="cp-form-shop-{{ $product->id }}" action="{{ route('compare.add') }}" method="POST" class="d-none">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    </form>
                                                    <a href="#" onclick="event.preventDefault(); document.getElementById('cp-form-shop-{{ $product->id }}').submit();" class="btn btn-sm btn-outline-dark rounded-circle mx-1" data-bs-toggle="tooltip" title="Add To Compare">
                                                        <i class="fas fa-exchange-alt"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="product-content d-flex flex-column flex-grow-1">
                                            <div class="product-info flex-grow-1 text-center">
                                                <h3 class="product-title font-weight-bold" style="font-size: 1.05rem; margin-bottom: 8px; line-height: 1.4;">
                                                    <a href="{{ route('shop.show', $product->slug) }}" class="text-dark text-decoration-none hover-pink">{{ $product->name }}</a>
                                                </h3>
                                                <div class="product-rate text-warning mb-2" style="font-size: 0.8rem;">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </div>
                                                <div class="product-price mb-3">
                                                    @if($product->compare_at_price)
                                                        <del class="text-muted mr-2" style="font-size: 0.9rem;">₹{{ number_format($product->compare_at_price, 2) }}</del>
                                                    @endif
                                                    <span class="font-weight-bold" style="font-size: 1.2rem; color: #ff7c8b;">₹{{ number_format($product->price, 2) }}</span>
                                                </div>
                                            </div>
                                            <div class="text-center mt-auto">
                                                <form action="{{ route('cart.add') }}" method="POST" class="w-100">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    @if($product->stock > 0)
                                                        <button type="submit" class="btn btn-sm btn-primary rounded-pill w-100 py-2 d-flex align-items-center justify-content-center gap-2" style="background-color: #ff7c8b; border-color: #ff7c8b; transition: all 0.3s;">
                                                            <i class="fas fa-shopping-bag"></i> Add To Cart
                                                        </button>
                                                    @else
                                                        <button type="button" class="btn btn-sm btn-secondary rounded-pill w-100 py-2 disabled" style="background-color: #aaa; border-color: #aaa;">
                                                            Out Of Stock
                                                        </button>
                                                    @endif
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <!-- Pagination -->
                            <div class="pagination-wrap d-flex justify-content-center mt-5">
                                {{ $products->appends(request()->query())->links('pagination::bootstrap-4') }}
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- shop area end -->

    <!-- Custom Styling for Hover Effect -->
    <style>
        .product-item:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
            border-color: #ff7c8b !important;
        }
        .product-item:hover img {
            transform: scale(1.08);
        }
        .hover-pink:hover {
            color: #ff7c8b !important;
        }
        .text-pink {
            color: #ff7c8b !important;
        }
        .product-item:hover .product-action-wrap {
            bottom: 0px !important;
        }
    </style>

@endsection
