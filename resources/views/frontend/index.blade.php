@extends('frontend.layouts.app')

@section('content')

        <!-- hero slider -->
        <div class="hero-section hs-3">
            <div class="container-fluid px-0">
                <div class="hero-slider owl-carousel owl-theme">
                    @forelse($sliders as $slider)
                        <div class="hero-single" style="background-image: url({{ asset($slider->image_path) }});">
                            <div class="container">
                                <div class="row align-items-center">
                                    <div class="col-lg-6">
                                        <div class="hero-content">
                                            @if($slider->subtitle)
                                                <h6 class="hero-sub-title" data-animation="fadeInUp" data-delay=".25s">{{ $slider->subtitle }}</h6>
                                            @endif
                                            <h1 class="hero-title" data-animation="fadeInRight" data-delay=".50s">
                                                {!! $slider->title !!}
                                            </h1>
                                            @if($slider->description)
                                                <p data-animation="fadeInLeft" data-delay=".75s">
                                                    {{ $slider->description }}
                                                </p>
                                            @endif
                                            @if($slider->btn1_text || $slider->btn2_text)
                                                <div class="hero-btn" data-animation="fadeInUp" data-delay="1s">
                                                    @if($slider->btn1_text)
                                                        <a href="{{ $slider->btn1_link ?: '#' }}" class="theme-btn">{{ $slider->btn1_text }}<i class="fas fa-arrow-right"></i></a>
                                                    @endif
                                                    @if($slider->btn2_text)
                                                        <a href="{{ $slider->btn2_link ?: '#' }}" class="theme-btn theme-btn2">{{ $slider->btn2_text }}<i class="fas fa-arrow-right"></i></a>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="hero-single" style="background-image: url({{ asset('frontend/assets/img/hero/slider-1.jpg') }});">
                            <div class="container">
                                <div class="row align-items-center">
                                    <div class="col-lg-6">
                                        <div class="hero-content">
                                            <h6 class="hero-sub-title" data-animation="fadeInUp" data-delay=".25s">Premium Gifting in Agra</h6>
                                            <h1 class="hero-title" data-animation="fadeInRight" data-delay=".50s">
                                                Exclusive Wedding & <span>Trousseau Hampers</span>
                                            </h1>
                                            <p data-animation="fadeInLeft" data-delay=".75s">
                                                Amar Nath Hampers & Materials offers exquisitely crafted wedding trays, ring ceremony platters, and bespoke gifting solutions to make your celebrations truly majestic.
                                            </p>
                                            <div class="hero-btn" data-animation="fadeInUp" data-delay="1s">
                                                <a href="about.html" class="theme-btn">About Us<i
                                                    class="fas fa-arrow-right"></i></a>
                                                <a href="shop-grid.html" class="theme-btn theme-btn2">Shop Now<i
                                                    class="fas fa-arrow-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hero-single" style="background-image: url({{ asset('frontend/assets/img/hero/slider-2.jpg') }});">
                            <div class="container">
                                <div class="row align-items-center">
                                    <div class="col-lg-6">
                                        <div class="hero-content">
                                            <h6 class="hero-sub-title" data-animation="fadeInUp" data-delay=".25s">Handcrafted Elegance</h6>
                                            <h1 class="hero-title" data-animation="fadeInRight" data-delay=".50s">
                                                Elegant Bridal <span>Accessories & Essentials</span>
                                            </h1>
                                            <p data-animation="fadeInLeft" data-delay=".75s">
                                                Discover our beautiful collection of handcrafted chuda boxes, designer potli bags, and traditional shagun envelopes designed to honor your Indian heritage.
                                            </p>
                                            <div class="hero-btn" data-animation="fadeInUp" data-delay="1s">
                                                <a href="about.html" class="theme-btn">About Us<i
                                                    class="fas fa-arrow-right"></i></a>
                                                <a href="shop-grid.html" class="theme-btn theme-btn2">Shop Now<i
                                                    class="fas fa-arrow-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hero-single" style="background-image: url({{ asset('frontend/assets/img/hero/slider-3.jpg') }});">
                            <div class="container">
                                <div class="row align-items-center">
                                    <div class="col-lg-6">
                                        <div class="hero-content">
                                            <h6 class="hero-sub-title" data-animation="fadeInUp" data-delay=".25s">Custom Gifts for Every Occasion</h6>
                                            <h1 class="hero-title" data-animation="fadeInRight" data-delay=".50s">
                                                Luxurious Corporate & <span>Festive Gifting</span>
                                            </h1>
                                            <p data-animation="fadeInLeft" data-delay=".75s">
                                                Impress your clients and loved ones with premium dry fruit boxes, customized hampers, and elegant silver-plated gifts sourced right from the heart of Agra.
                                            </p>
                                            <div class="hero-btn" data-animation="fadeInUp" data-delay="1s">
                                                <a href="about.html" class="theme-btn">About Us<i
                                                    class="fas fa-arrow-right"></i></a>
                                                <a href="shop-grid.html" class="theme-btn theme-btn2">Shop Now<i
                                                    class="fas fa-arrow-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        <!-- hero slider end -->


        <!-- category area -->
        <div class="category-area py-80">
            <div class="container">
                <div class="category-slider owl-carousel owl-theme">
                    @php
                        $categoryIcons = ['gift-box.svg', 'home.svg', 'jewelry.svg', 'garment.svg', 'office.svg', 'gift.svg', 'gift-2.svg'];
                    @endphp
                    @forelse($categories as $category)
                        @php
                            $icon = $categoryIcons[$loop->index % count($categoryIcons)];
                        @endphp
                        <div class="category-item tilt-3d">
                            <a href="{{ route('shop.index', ['category' => $category->slug]) }}">
                                <div class="category-info">
                                    <div class="icon">
                                        <img src="{{ asset('frontend/assets/img/icon/' . $icon) }}" alt="{{ $category->name }}">
                                    </div>
                                    <div class="content">
                                        <h4>{{ $category->name }}</h4>
                                        <p>{{ sprintf('%02d', $category->products_count) }} Items</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="category-item tilt-3d">
                            <a href="#">
                                <div class="category-info">
                                    <div class="icon">
                                        <img src="{{ asset('frontend/assets/img/icon/gift-box.svg') }}" alt="">
                                    </div>
                                    <div class="content">
                                        <h4>Gifts Box</h4>
                                        <p>30 Items</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        <!-- category area end-->


        <!-- trending item -->
        <div class="product-area">
            <div class="container">
                <div class="row">
                    <div class="col-12 wow fadeInDown" data-wow-delay=".25s">
                        <div class="site-heading-inline">
                            <h2 class="site-title">Trending Items</h2>
                            <a href="#">View More <i class="fas fa-angle-double-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="product-wrap item-2 wow fadeInUp" data-wow-delay=".25s">
                    <div class="product-slider owl-carousel owl-theme">
                        @forelse($products as $product)
                            <div class="product-item tilt-3d">
                                <div class="product-img">
                                    @if($product->compare_at_price > $product->price)
                                        @php
                                            $discount = round((($product->compare_at_price - $product->price) / $product->compare_at_price) * 100);
                                        @endphp
                                        <span class="type discount">{{ $discount }}% Off</span>
                                    @elseif($product->is_featured)
                                        <span class="type hot">Hot</span>
                                    @else
                                        <span class="type new">New</span>
                                    @endif
                                    <a href="{{ route('shop.show', $product->slug) }}"><img src="{{ asset($product->image) }}" alt="{{ $product->name }}"></a>
                                    <div class="product-action-wrap">
                                        <div class="product-action">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#quickview"
                                                data-tooltip="tooltip" title="Quick View"><i class="fas fa-eye"></i></a>
                                            
                                            <form id="wl-form-deal-{{ $product->id }}" action="{{ route('wishlist.add') }}" method="POST" class="d-none">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            </form>
                                            <a href="#" onclick="event.preventDefault(); document.getElementById('wl-form-deal-{{ $product->id }}').submit();" data-tooltip="tooltip" title="Add To Wishlist">
                                                <i class="fas fa-heart"></i>
                                            </a>

                                            <form id="cp-form-deal-{{ $product->id }}" action="{{ route('compare.add') }}" method="POST" class="d-none">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            </form>
                                            <a href="#" onclick="event.preventDefault(); document.getElementById('cp-form-deal-{{ $product->id }}').submit();" data-tooltip="tooltip" title="Add To Compare">
                                                <i class="fas fa-exchange-alt"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <div class="product-info">
                                        <h3 class="product-title"><a href="{{ route('shop.show', $product->slug) }}">{{ $product->name }}</a></h3>
                                        <div class="product-rate">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <div class="product-price">
                                            @if($product->compare_at_price)
                                                <del>₹{{ number_format($product->compare_at_price, 2) }}</del>
                                            @endif
                                            <span>₹{{ number_format($product->price, 2) }}</span>
                                        </div>
                                    </div>
                                    <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="qty" value="1">
                                        <button type="submit" class="product-cart-btn" data-bs-placement="left"
                                                    data-tooltip="tooltip" title="Add To Cart">
                                                    <i class="fas fa-shopping-bag"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="product-item tilt-3d">
                                <div class="product-img">
                                    <span class="type new">New</span>
                                    <a href="#"><img src="{{ asset('frontend/assets/img/product/01.png') }}" alt=""></a>
                                </div>
                                <div class="product-content">
                                    <div class="product-info">
                                        <h3 class="product-title"><a href="#">Special Gift Box</a></h3>
                                        <div class="product-price">
                                            <span>₹250.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <!-- trending item end -->


        <!-- small banner -->
        <div class="small-banner py-100">
            <div class="container wow fadeInUp" data-wow-delay=".25s">
                <div class="row g-4">
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="banner-item">
                            <img src="{{ asset('frontend/assets/img/banner/mini-banner-1.jpg') }}" alt="">
                            <div class="banner-content">
                                <p>Wedding Trays</p>
                                <h3>Exclusive Wedding <br> Trousseau Packing</h3>
                                <a href="#">Shop Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="banner-item">
                            <img src="{{ asset('frontend/assets/img/banner/mini-banner-2.jpg') }}" alt="">
                            <div class="banner-content">
                                <p>Bridal Accessories</p>
                                <h3>Beautiful Chuda <br> Boxes & Potlis</h3>
                                <a href="#">Discover Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="banner-item">
                            <img src="{{ asset('frontend/assets/img/banner/mini-banner-3.jpg') }}" alt="">
                            <div class="banner-content">
                                <p>Festive Gifts</p>
                                <h3>Premium Dry Fruit <br> Hampers Up To <span>15%</span> Off</h3>
                                <a href="#">Discover Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- small banner end -->


        <!-- feature area -->
        <div class="feature-area pb-100">
            <div class="container wow fadeInUp" data-wow-delay=".25s">
                <div class="feature-wrap">
                    <div class="row g-0">
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-truck"></i>
                                </div>
                                <div class="feature-content">
                                    <h4>Free Delivery</h4>
                                    <p>Orders Over $120</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-sync"></i>
                                </div>
                                <div class="feature-content">
                                    <h4>Get Refund</h4>
                                    <p>Within 30 Days Returns</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-wallet"></i>
                                </div>
                                <div class="feature-content">
                                    <h4>Safe Payment</h4>
                                    <p>100% Secure Payment</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-headset"></i>
                                </div>
                                <div class="feature-content">
                                    <h4>24/7 Support</h4>
                                    <p>Feel Free To Call Us</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- feature area end -->


        <!-- popular item -->
        <div class="product-area pb-100">
            <div class="container">
                <div class="row g-4">
                    <div class="col-lg-12">
                        @php
                            $tabCategories = $categories->filter(fn($cat) => $cat->products->count() > 0)->take(4);
                        @endphp
                        @if($tabCategories->isNotEmpty())
                            <div class="row">
                                <div class="col-12 wow fadeInDown" data-wow-delay=".25s">
                                    <div class="site-heading-inline item-tab">
                                        <h2 class="site-title">Popular Items</h2>
                                        <ul class="nav nav-pills" id="item-tab" role="tablist">
                                            @foreach($tabCategories as $index => $cat)
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link {{ $index === 0 ? 'active' : '' }}" id="item-tab-{{ $cat->id }}" data-bs-toggle="pill"
                                                        data-bs-target="#pill-item-tab-{{ $cat->id }}" type="button" role="tab"
                                                        aria-controls="pill-item-tab-{{ $cat->id }}" aria-selected="{{ $index === 0 ? 'true' : 'false' }}">{{ $cat->name }}</button>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-content wow fadeInUp" data-wow-delay=".25s" id="item-tabContent">
                                @foreach($tabCategories as $index => $cat)
                                    <div class="tab-pane {{ $index === 0 ? 'show active' : '' }}" id="pill-item-tab-{{ $cat->id }}" role="tabpanel" aria-labelledby="item-tab-{{ $cat->id }}"
                                        tabindex="0">
                                        <div class="row g-4 item-2">
                                            @foreach($cat->products->take(4) as $prod)
                                                <div class="col-md-6 col-lg-3">
                                                    <div class="product-item tilt-3d">
                                                        <div class="product-img">
                                                            @if($prod->compare_at_price > $prod->price)
                                                                @php
                                                                    $discount = round((($prod->compare_at_price - $prod->price) / $prod->compare_at_price) * 100);
                                                                @endphp
                                                                <span class="type discount">{{ $discount }}% Off</span>
                                                            @elseif($prod->is_featured)
                                                                <span class="type hot">Hot</span>
                                                            @else
                                                                <span class="type new">New</span>
                                                            @endif
                                                            <a href="{{ route('shop.show', $prod->slug) }}"><img src="{{ asset($prod->image) }}" alt="{{ $prod->name }}"></a>
                                                            <div class="product-action-wrap">
                                                                <div class="product-action">
                                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#quickview"
                                                                        data-bs-placement="right" data-tooltip="tooltip"
                                                                        title="Quick View"><i class="fas fa-eye"></i></a>
                                                                    
                                                                    <form id="wl-form-{{ $prod->id }}" action="{{ route('wishlist.add') }}" method="POST" class="d-none">
                                                                        @csrf
                                                                        <input type="hidden" name="product_id" value="{{ $prod->id }}">
                                                                    </form>
                                                                    <a href="#" onclick="event.preventDefault(); document.getElementById('wl-form-{{ $prod->id }}').submit();" data-bs-placement="right" data-tooltip="tooltip" title="Add To Wishlist">
                                                                        <i class="fas fa-heart"></i>
                                                                    </a>

                                                                    <form id="cp-form-{{ $prod->id }}" action="{{ route('compare.add') }}" method="POST" class="d-none">
                                                                        @csrf
                                                                        <input type="hidden" name="product_id" value="{{ $prod->id }}">
                                                                    </form>
                                                                    <a href="#" onclick="event.preventDefault(); document.getElementById('cp-form-{{ $prod->id }}').submit();" data-bs-placement="right" data-tooltip="tooltip" title="Add To Compare">
                                                                        <i class="fas fa-exchange-alt"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="product-content">
                                                            <div class="product-info">
                                                                <h3 class="product-title"><a href="{{ route('shop.show', $prod->slug) }}">{{ $prod->name }}</a></h3>
                                                                <div class="product-rate">
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                </div>
                                                                <div class="product-price">
                                                                    @if($prod->compare_at_price)
                                                                        <del>₹{{ number_format($prod->compare_at_price, 2) }}</del>
                                                                    @endif
                                                                    <span>₹{{ number_format($prod->price, 2) }}</span>
                                                                </div>
                                                            </div>
                                                            <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                                                                @csrf
                                                                <input type="hidden" name="product_id" value="{{ $prod->id }}">
                                                                <input type="hidden" name="qty" value="1">
                                                                <button type="submit" class="product-cart-btn" data-bs-placement="left"
                                                                            data-tooltip="tooltip" title="Add To Cart">
                                                                            <i class="fas fa-shopping-bag"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="row">
                                <div class="col-12 wow fadeInDown" data-wow-delay=".25s">
                                    <div class="site-heading-inline item-tab">
                                        <h2 class="site-title">Popular Items</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="p-5 text-center bg-white rounded shadow-sm">
                                <i class="fas fa-shopping-basket fa-3x text-muted mb-3"></i>
                                <h4 class="text-muted">No products available at the moment.</h4>
                                <p class="text-muted mb-0">Check back later or explore our full catalog below.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- popular item end -->


        <!-- deal area -->
        <div class="deal-area2 bg pt-20 pb-50">
            <div class="container">
                <div class="row">
                    <div class="col-12 wow fadeInDown" data-wow-delay=".25s">
                        <div class="site-heading-inline">
                            <h2 class="site-title">Best Deals For <span>This Week</span></h2>
                            <div class="deal-countdown">
                                <div class="countdown" data-countdown="{{ now()->addDays(7)->format('Y/m/d') }}"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product-wrap wow fadeInUp" data-wow-delay=".25s">
                    <div class="product-slider owl-carousel owl-theme">
                        @forelse($dealProducts->isNotEmpty() ? $dealProducts : $products->take(6) as $prod)
                            <div class="product-item tilt-3d">
                                <div class="product-img">
                                    @if($prod->compare_at_price > $prod->price)
                                        @php
                                            $discount = round((($prod->compare_at_price - $prod->price) / $prod->compare_at_price) * 100);
                                        @endphp
                                        <span class="type discount">{{ $discount }}% Off</span>
                                    @elseif($prod->is_featured)
                                        <span class="type hot">Hot</span>
                                    @else
                                        <span class="type new">New</span>
                                    @endif
                                    <a href="{{ route('shop.show', $prod->slug) }}"><img src="{{ asset($prod->image) }}" alt="{{ $prod->name }}"></a>
                                    <div class="product-action-wrap">
                                        <div class="product-action">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#quickview"
                                                data-tooltip="tooltip" title="Quick View"><i class="fas fa-eye"></i></a>
                                            
                                            <form id="wl-form-deal-{{ $prod->id }}" action="{{ route('wishlist.add') }}" method="POST" class="d-none">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $prod->id }}">
                                            </form>
                                            <a href="#" onclick="event.preventDefault(); document.getElementById('wl-form-deal-{{ $prod->id }}').submit();" data-tooltip="tooltip" title="Add To Wishlist">
                                                <i class="fas fa-heart"></i>
                                            </a>

                                            <form id="cp-form-deal-{{ $prod->id }}" action="{{ route('compare.add') }}" method="POST" class="d-none">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $prod->id }}">
                                            </form>
                                            <a href="#" onclick="event.preventDefault(); document.getElementById('cp-form-deal-{{ $prod->id }}').submit();" data-tooltip="tooltip" title="Add To Compare">
                                                <i class="fas fa-exchange-alt"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <div class="product-info">
                                        <h3 class="product-title"><a href="{{ route('shop.show', $prod->slug) }}">{{ $prod->name }}</a></h3>
                                        <div class="product-rate">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <div class="product-price">
                                            @if($prod->compare_at_price)
                                                <del>₹{{ number_format($prod->compare_at_price, 2) }}</del>
                                            @endif
                                            <span>₹{{ number_format($prod->price, 2) }}</span>
                                        </div>
                                    </div>
                                    <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $prod->id }}">
                                        <input type="hidden" name="qty" value="1">
                                        <button type="submit" class="product-cart-btn" data-bs-placement="left"
                                                    data-tooltip="tooltip" title="Add To Cart">
                                                    <i class="fas fa-shopping-bag"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="product-item tilt-3d">
                                <div class="product-img">
                                    <span class="type new">New</span>
                                    <a href="#"><img src="{{ asset('frontend/assets/img/product/01.png') }}" alt=""></a>
                                </div>
                                <div class="product-content">
                                    <div class="product-info">
                                        <h3 class="product-title"><a href="#">Special Gift Box</a></h3>
                                        <div class="product-price">
                                            <span>₹250.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <!-- deal area end -->


        <!-- about area -->
        <div class="about-area py-120">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="about-left wow fadeInLeft" data-wow-delay=".25s">
                            <div class="about-img">
                                <div class="img-1">
                                    <img src="{{ asset('frontend/assets/img/about/01.jpg') }}" alt="">
                                </div>
                                <img class="img-2" src="{{ asset('frontend/assets/img/about/02.jpg') }}" alt="">
                                <img class="img-3" src="{{ asset('frontend/assets/img/about/03.jpg') }}" alt="">
                            </div>
                            <div class="about-experience">
                                <div class="about-experience-icon">
                                    <img src="{{ asset('frontend/assets/img/icon/experience.svg') }}" alt="">
                                </div>
                                <b>30 Years Of <br> Experience</b>
                            </div>
                            <div class="about-shape">
                                <img src="{{ asset('frontend/assets/img/shape/01.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-right wow fadeInRight" data-wow-delay=".25s">
                            <div class="site-heading mb-3">
                                <span class="site-title-tagline justify-content-start">
                                    <i class="fas fa-info-circle"></i> About Us
                                </span>
                                <h2 class="site-title">
                                    Crafting Exquisite <span>Trousseau & Hampers</span> For Your Special Day
                                </h2>
                            </div>
                            <p>
                                Based in the historic city of Agra, Amar Nath Hampers & Materials specializes in creating luxurious, hand-crafted wedding trays, ring ceremony platters, and bespoke gifting solutions. We bring elegance and Indian tradition together to make every celebration memorable.
                            </p>
                            <div class="about-list">
                                <ul>
                                    <li><i class="fas fa-check-double"></i> Premium Handcrafted Designs</li>
                                    <li><i class="fas fa-check-double"></i> Custom Trousseau Packing</li>
                                    <li><i class="fas fa-check-double"></i> Traditional & Modern Concepts</li>
                                    <li><i class="fas fa-check-double"></i> Trusted by Elite Families in Agra</li>
                                </ul>
                            </div>
                            <a href="contact.html" class="theme-btn mt-4">Discover More<i
                                    class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- about area end -->


        <!-- big banner -->
        <div class="big-banner">
            <div class="container wow fadeInUp" data-wow-delay=".25s">
                <div class="banner-wrap" style="background-image: url({{ asset('frontend/assets/img/banner/big-banner.jpg') }});">
                    <div class="row">
                        <div class="col-lg-8 mx-auto">
                            <div class="banner-content">
                                <div class="banner-info">
                                    <h6>Exclusive Bridal Season</h6>
                                    <h2>Pre-Book Your <span>Wedding Hampers</span> Now</h2>
                                    <p>at our Agra studio</p>
                                </div>
                                <a href="#" class="theme-btn">Shop Now<i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- big banner end -->


        <!-- gallery-area -->
        <div class="gallery-area py-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <div class="site-heading text-center">
                            <span class="site-title-tagline">Our Gallery</span>
                            <h2 class="site-title">Let's Check Our Photo <span>Gallery</span></h2>
                        </div>
                    </div>
                </div>
                <div class="row g-4 popup-gallery">
                    <div class="col-md-4 col-lg-3">
                        <div class="gallery-item wow fadeInUp" data-wow-delay=".25s">
                            <div class="gallery-img">
                                <img src="{{ asset('frontend/assets/img/gallery/01.jpg') }}" alt="">
                                <a class="popup-img gallery-link" href="{{ asset('frontend/assets/img/gallery/01.jpg') }}"><i
                                        class="fas fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3">
                        <div class="gallery-item wow fadeInDown" data-wow-delay=".25s">
                            <div class="gallery-img">
                                <img src="{{ asset('frontend/assets/img/gallery/02.jpg') }}" alt="">
                                <a class="popup-img gallery-link" href="{{ asset('frontend/assets/img/gallery/02.jpg') }}"><i
                                        class="fas fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3">
                        <div class="gallery-item wow fadeInUp" data-wow-delay=".25s">
                            <div class="gallery-img">
                                <img src="{{ asset('frontend/assets/img/gallery/03.jpg') }}" alt="">
                                <a class="popup-img gallery-link" href="{{ asset('frontend/assets/img/gallery/03.jpg') }}"><i
                                        class="fas fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3">
                        <div class="gallery-item wow fadeInDown" data-wow-delay=".25s">
                            <div class="gallery-img">
                                <img src="{{ asset('frontend/assets/img/gallery/04.jpg') }}" alt="">
                                <a class="popup-img gallery-link" href="{{ asset('frontend/assets/img/gallery/04.jpg') }}"><i
                                        class="fas fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-lg-6">
                        <div class="gallery-item wow fadeInUp" data-wow-delay=".25s">
                            <div class="gallery-img">
                                <img src="{{ asset('frontend/assets/img/gallery/05.jpg') }}" alt="">
                                <a class="popup-img gallery-link" href="{{ asset('frontend/assets/img/gallery/05.jpg') }}"><i
                                        class="fas fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3">
                        <div class="gallery-item wow fadeInDown" data-wow-delay=".25s">
                            <div class="gallery-img">
                                <img src="{{ asset('frontend/assets/img/gallery/06.jpg') }}" alt="">
                                <a class="popup-img gallery-link" href="{{ asset('frontend/assets/img/gallery/06.jpg') }}"><i
                                        class="fas fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3">
                        <div class="gallery-item wow fadeInUp" data-wow-delay=".25s">
                            <div class="gallery-img">
                                <img src="{{ asset('frontend/assets/img/gallery/07.jpg') }}" alt="">
                                <a class="popup-img gallery-link" href="{{ asset('frontend/assets/img/gallery/07.jpg') }}"><i
                                        class="fas fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- gallery-area end -->


        <!-- testimonial area -->
        <div class="testimonial-area bg ts-bg py-90">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mx-auto wow fadeInDown" data-wow-delay=".25s">
                        <div class="site-heading text-center">
                            <span class="site-title-tagline">Testimonials</span>
                            <h2 class="site-title">What Our Clients <span>Say</span> About Us</h2>
                        </div>
                    </div>
                </div>
                <div class="testimonial-slider owl-carousel owl-theme wow fadeInUp" data-wow-delay=".25s">
                    @forelse ($testimonials as $t)
                        <div class="testimonial-item">
                            <div class="testimonial-author">
                                <div class="testimonial-author-img">
                                    @if ($t->photo)
                                        <img src="{{ asset($t->photo) }}" alt="{{ $t->name }}">
                                    @else
                                        <img src="{{ asset('frontend/assets/img/testimonial/01.jpg') }}" alt="{{ $t->name }}">
                                    @endif
                                </div>
                                <div class="testimonial-author-info">
                                    <h4>{{ $t->name }}</h4>
                                    <p>{{ $t->designation ?? 'Verified Customer' }}</p>
                                </div>
                            </div>
                            <div class="testimonial-quote">
                                <p>"{{ $t->review_text }}"</p>
                            </div>
                            <div class="testimonial-rate">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $t->rating)
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <div class="testimonial-quote-icon"><img src="{{ asset('frontend/assets/img/icon/quote.svg') }}" alt="Quote"></div>
                        </div>
                    @empty
                        <div class="testimonial-item">
                            <div class="testimonial-author">
                                <div class="testimonial-author-img">
                                    <img src="{{ asset('frontend/assets/img/testimonial/01.jpg') }}" alt="Sylvia">
                                </div>
                                <div class="testimonial-author-info">
                                    <h4>Sylvia H Green</h4>
                                    <p>Bride, Agra</p>
                                </div>
                            </div>
                            <div class="testimonial-quote">
                                <p>"Absolutely stunning work! Amar Nath Hampers transformed our wedding trousseau into something magical. Their attention to detail and traditional touches are unmatched in Agra."</p>
                            </div>
                            <div class="testimonial-rate">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="testimonial-quote-icon"><img src="{{ asset('frontend/assets/img/icon/quote.svg') }}" alt="Quote"></div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        <!-- testimonial area end -->


        <!-- blog area -->
        <div class="blog-area py-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <div class="site-heading text-center">
                            <span class="site-title-tagline">Our Blog</span>
                            <h2 class="site-title">Our Latest News & <span>Stories</span></h2>
                        </div>
                    </div>
                </div>
                <div class="row g-4">
                    @forelse ($recentPosts as $post)
                        <div class="col-md-6 col-lg-4">
                            <div class="blog-item wow fadeInUp" data-wow-delay=".25s">
                                <div class="blog-item-img">
                                    @if ($post->featured_image)
                                        <img src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}">
                                    @else
                                        <img src="{{ asset('frontend/assets/img/blog/01.jpg') }}" alt="{{ $post->title }}">
                                    @endif
                                    <span class="blog-date">
                                        <i class="fas fa-calendar-alt"></i> 
                                        {{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }}
                                    </span>
                                </div>
                                <div class="blog-item-info">
                                    <div class="blog-item-meta">
                                        <ul>
                                            <li><a href="#"><i class="fas fa-user-circle"></i> By {{ $post->author_name ?? 'Amar Nath Hampers' }}</a></li>
                                        </ul>
                                    </div>
                                    <h4 class="blog-title">
                                        <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                                    </h4>
                                    <p>{{ Str::limit($post->excerpt, 100) }}</p>
                                    <a class="theme-btn" href="{{ route('blog.show', $post->slug) }}">Read More<i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-md-6 col-lg-4">
                            <div class="blog-item wow fadeInUp" data-wow-delay=".25s">
                                <div class="blog-item-img">
                                    <img src="{{ asset('frontend/assets/img/blog/01.jpg') }}" alt="Thumb">
                                    <span class="blog-date"><i class="fas fa-calendar-alt"></i> Aug 12, 2026</span>
                                </div>
                                <div class="blog-item-info">
                                    <div class="blog-item-meta">
                                        <ul>
                                            <li><a href="#"><i class="fas fa-user-circle"></i> By Amar Nath Hampers</a></li>
                                        </ul>
                                    </div>
                                    <h4 class="blog-title">
                                        <a href="{{ route('blog.index') }}">Top 5 Trousseau Packing Trends for Agra Brides</a>
                                    </h4>
                                    <p>Discover the latest styles in trousseau packing, from velvet trays with zari work to personalized floral boxes.</p>
                                    <a class="theme-btn" href="{{ route('blog.index') }}">Read More<i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
                @if (count($recentPosts) > 0)
                    <div class="text-center mt-5">
                        <a href="{{ route('blog.index') }}" class="theme-btn">View All Articles <i class="fas fa-arrow-right ms-1"></i></a>
                    </div>
                @endif
            </div>
        </div>
        <!-- blog area end -->


        <!-- newsletter area -->
        <div class="newsletter-area pb-100">
            <div class="container wow fadeInUp" data-wow-delay=".25s">
                <div class="newsletter-wrap">
                    <div class="row">
                        <div class="col-lg-6 mx-auto">
                            <div class="newsletter-content">
                                <h3>Get <span>20%</span> Off Discount Coupon</h3>
                                <p>By Subscribe Our Newsletter</p>
                                <div class="subscribe-form">
                                    <form action="#">
                                        <input type="email" class="form-control" placeholder="Your Email Address">
                                        <button class="theme-btn" type="submit">
                                            Subscribe <i class="fas fa-paper-plane"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- newsletter area end -->

@endsection
