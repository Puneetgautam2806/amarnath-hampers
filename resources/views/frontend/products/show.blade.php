@extends('frontend.layouts.app')

@section('content')

    <!-- breadcrumb -->
    <div class="site-breadcrumb-wrap" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('frontend/assets/img/banner/big-banner.jpg') }}') no-repeat center center; background-size: cover; padding: 80px 0;">
        <div class="container">
            <div class="site-breadcrumb-content text-center text-white">
                <h2 class="breadcrumb-title text-white" style="font-size: 2.5rem; font-weight: 700; margin-bottom: 10px;">{{ $product->name }}</h2>
                <ul class="breadcrumb-menu d-flex justify-content-center gap-2 list-unstyled">
                    <li><a href="{{ route('home') }}" class="text-white opacity-75">Home</a></li>
                    <li class="text-white opacity-50">/</li>
                    <li><a href="{{ route('shop.index') }}" class="text-white opacity-75">Shop</a></li>
                    <li class="text-white opacity-50">/</li>
                    <li class="active text-white">Details</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- breadcrumb end -->

    <!-- product details area -->
    <div class="product-single-area py-100" style="padding: 80px 0;">
        <div class="container">
            
            <!-- Alert Display -->
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show rounded-pill px-4 mb-4" role="alert">
                    <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <!-- Product Image Column -->
                <div class="col-lg-6 mb-5">
                    <div class="product-single-img p-5 bg-white border rounded shadow-sm d-flex align-items-center justify-content-center" style="height: 480px; background-color: #fcf8f8;">
                        <img src="{{ asset($product->image) }}" class="img-fluid" style="max-height: 380px; object-fit: contain;" alt="{{ $product->name }}">
                    </div>
                </div>

                <!-- Product Details Column -->
                <div class="col-lg-6 mb-5">
                    <div class="product-single-details p-3">
                        
                        <!-- Category Badge -->
                        @if($product->category)
                            <a href="{{ route('shop.index', ['category' => $product->category->slug]) }}" class="badge text-white px-3 py-2 mb-3 text-uppercase font-weight-bold text-decoration-none" style="background-color: #ff7c8b; font-size: 0.75rem; letter-spacing: 1px;">
                                {{ $product->category->name }}
                            </a>
                        @endif

                        <h1 class="font-weight-bold mb-2" style="font-size: 2.2rem; color: #333; line-height: 1.2;">{{ $product->name }}</h1>
                        
                        <!-- Star Review -->
                        <div class="product-single-rate d-flex align-items-center mb-3">
                            <div class="text-warning mr-2" style="font-size: 0.95rem;">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <span class="text-muted">(5.0 Customer Rating)</span>
                        </div>

                        <!-- Price block -->
                        <div class="product-single-price d-flex align-items-center mb-4">
                            @if($product->compare_at_price)
                                <del class="text-muted mr-3" style="font-size: 1.3rem;">₹{{ number_format($product->compare_at_price, 2) }}</del>
                            @endif
                            <span class="font-weight-bold" style="font-size: 2rem; color: #ff7c8b;">₹{{ number_format($product->price, 2) }}</span>
                            
                            @if($product->compare_at_price > $product->price)
                                @php
                                    $discount = round((($product->compare_at_price - $product->price) / $product->compare_at_price) * 100);
                                @endphp
                                <span class="badge bg-danger text-white ml-3" style="font-size: 0.9rem; padding: 6px 12px;">Save {{ $discount }}%</span>
                            @endif
                        </div>

                        <!-- Short Description -->
                        <p class="text-muted mb-4" style="font-size: 1.05rem; line-height: 1.6;">
                            {{ $product->short_description ?: 'Treat yourself or someone special with this luxurious gift selection. Carefully selected, beautifully packed, and crafted to deliver maximum joy.' }}
                        </p>

                        <!-- Stock Indicator -->
                        <div class="stock-indicator mb-4 d-flex align-items-center">
                            <span class="mr-3 text-dark font-weight-bold">Availability:</span>
                            @if($product->stock > 0)
                                <span class="badge bg-success text-white px-3 py-2"><i class="fas fa-check-circle"></i> In Stock ({{ $product->stock }} items remaining)</span>
                            @else
                                <span class="badge bg-danger text-white px-3 py-2"><i class="fas fa-times-circle"></i> Out Of Stock</span>
                            @endif
                        </div>

                        <hr class="my-4">

                        <!-- Add to Cart & Actions Widget -->
                        <div class="d-flex align-items-center gap-3 flex-wrap">
                            @if($product->stock > 0)
                                <form action="{{ route('cart.add') }}" method="POST" class="d-flex align-items-center gap-3">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    
                                    <div class="quantity-selector d-flex align-items-center border rounded-pill overflow-hidden bg-light" style="width: 140px; height: 50px;">
                                        <button type="button" class="btn btn-link text-dark text-decoration-none px-3 font-weight-bold" onclick="decrementQty()"><i class="fas fa-minus"></i></button>
                                        <input type="number" id="qty-input" name="qty" class="form-control text-center bg-transparent border-0 font-weight-bold" value="1" min="1" max="{{ $product->stock }}" style="box-shadow: none;">
                                        <button type="button" class="btn btn-link text-dark text-decoration-none px-3 font-weight-bold" onclick="incrementQty()"><i class="fas fa-plus"></i></button>
                                    </div>

                                    <button type="submit" class="btn text-white px-5 rounded-pill font-weight-bold d-flex align-items-center gap-2" style="background-color: #ff7c8b; border-color: #ff7c8b; height: 50px; font-size: 1.1rem; transition: all 0.3s;">
                                        <i class="fas fa-shopping-bag"></i> Add To Cart
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-secondary px-5 rounded-pill font-weight-bold disabled" style="height: 50px; font-size: 1.1rem; background-color: #aaa; border-color: #aaa;">
                                    Out Of Stock
                                </button>
                            @endif

                            <!-- Wishlist & Compare Buttons -->
                            <form id="wl-form-show" action="{{ route('wishlist.add') }}" method="POST" class="d-none">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                            </form>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('wl-form-show').submit();" class="btn btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; border-color: #ccc;" data-tooltip="tooltip" title="Add To Wishlist">
                                <i class="fas fa-heart text-muted"></i>
                            </a>

                            <form id="cp-form-show" action="{{ route('compare.add') }}" method="POST" class="d-none">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                            </form>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('cp-form-show').submit();" class="btn btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; border-color: #ccc;" data-tooltip="tooltip" title="Add To Compare">
                                <i class="fas fa-exchange-alt text-muted"></i>
                            </a>
                        </div>

                        <hr class="my-4">

                        <!-- Details Block -->
                        <div class="product-details-meta list-unstyled m-0 p-0 text-muted" style="font-size: 0.95rem;">
                            <div class="mb-2"><strong class="text-dark">SKU:</strong> GH-{{ str_pad($product->id, 5, '0', STR_PAD_LEFT) }}</div>
                            <div class="mb-2"><strong class="text-dark">Category:</strong> {{ $product->category ? $product->category->name : 'N/A' }}</div>
                            <div><strong class="text-dark">Shipping:</strong> Standard 1-3 Business Days Delivery</div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Long Description tab block -->
            <div class="row mt-5">
                <div class="col-12">
                    <div class="product-description-tabs bg-white border rounded p-4 shadow-sm">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active font-weight-bold" style="color: #ff7c8b;" id="desc-tab" data-bs-toggle="tab" data-bs-target="#desc" type="button" role="tab" aria-controls="desc" aria-selected="true">Product Description</button>
                            </li>
                        </ul>
                        <div class="tab-content pt-4" id="myTabContent">
                            <div class="tab-pane fade show active text-muted" style="line-height: 1.7; font-size: 1.05rem;" id="desc" role="tabpanel" aria-labelledby="desc-tab">
                                {!! nl2br(e($product->description)) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Products Section -->
            @if($relatedProducts->isNotEmpty())
                <div class="row mt-5 pt-4">
                    <div class="col-12">
                        <h2 class="font-weight-bold mb-4" style="font-size: 1.8rem; border-left: 4px solid #ff7c8b; padding-left: 12px;">You May Also Like</h2>
                    </div>
                    @foreach($relatedProducts as $rel)
                    <div class="col-md-6 col-lg-3 mb-4">
                        <div class="product-item border rounded p-3 bg-white shadow-sm position-relative d-flex flex-column h-100" style="transition: all 0.3s;">
                            <div class="product-img text-center overflow-hidden mb-3 position-relative rounded" style="background-color: #fcf8f8; height: 200px; display: flex; align-items: center; justify-content: center;">
                                <a href="{{ route('shop.show', $rel->slug) }}" class="w-100">
                                    <img src="{{ asset($rel->image) }}" class="img-fluid p-2" style="max-height: 170px; object-fit: contain; transition: transform 0.3s;" alt="{{ $rel->name }}">
                                </a>
                            </div>
                            <div class="product-content d-flex flex-column flex-grow-1 text-center">
                                <h3 class="product-title font-weight-bold" style="font-size: 0.95rem; margin-bottom: 8px;">
                                    <a href="{{ route('shop.show', $rel->slug) }}" class="text-dark text-decoration-none hover-pink">{{ $rel->name }}</a>
                                </h3>
                                <div class="product-price mb-3">
                                    <span class="font-weight-bold" style="color: #ff7c8b;">₹{{ number_format($rel->price, 2) }}</span>
                                </div>
                                <a href="{{ route('shop.show', $rel->slug) }}" class="btn btn-sm btn-outline-dark rounded-pill mt-auto">View Details</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>

    <!-- Script for Quantity Increment/Decrement -->
    <script>
        function incrementQty() {
            var input = document.getElementById('qty-input');
            var val = parseInt(input.value);
            var max = parseInt(input.max);
            if (val < max) {
                input.value = val + 1;
            }
        }
        function decrementQty() {
            var input = document.getElementById('qty-input');
            var val = parseInt(input.value);
            if (val > 1) {
                input.value = val - 1;
            }
        }
    </script>

    <style>
        .hover-pink:hover {
            color: #ff7c8b !important;
        }
        .btn-primary:hover {
            background-color: #ff576a !important;
            border-color: #ff576a !important;
        }
        .product-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.08) !important;
            border-color: #ff7c8b !important;
        }
        .product-item:hover img {
            transform: scale(1.05);
        }
    </style>

@endsection
