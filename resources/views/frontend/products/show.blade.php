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
                    <div class="product-single-img p-5 bg-white border rounded shadow-sm d-flex align-items-center justify-content-center position-relative" style="height: 480px; background-color: #fcf8f8;">
                        <img id="mainProductImage" src="{{ asset($product->image) }}" class="img-fluid" style="max-height: 380px; object-fit: contain; transition: opacity 0.25s ease-in-out;" alt="{{ $product->name }}">
                        <div id="imageLoadingSpinner" class="position-absolute d-none">
                            <div class="spinner-border text-danger" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
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
                        <div class="product-single-price d-flex align-items-center mb-4" id="priceDisplayContainer">
                            <del class="text-muted mr-3 {{ $product->compare_at_price ? '' : 'd-none' }}" id="productComparePrice" style="font-size: 1.3rem;">
                                ₹{{ $product->compare_at_price ? number_format($product->compare_at_price, 2) : '' }}
                            </del>
                            <span class="font-weight-bold" id="productCurrentPrice" style="font-size: 2rem; color: #ff7c8b;">
                                ₹{{ number_format($product->price, 2) }}
                            </span>
                            
                            <span class="badge bg-danger text-white ml-3 {{ ($product->compare_at_price && $product->compare_at_price > $product->price) ? '' : 'd-none' }}" id="productDiscountBadge" style="font-size: 0.9rem; padding: 6px 12px;">
                                @if($product->compare_at_price && $product->compare_at_price > $product->price)
                                    Save {{ round((($product->compare_at_price - $product->price) / $product->compare_at_price) * 100) }}%
                                @endif
                            </span>
                        </div>

                        <!-- Short Description -->
                        <p class="text-muted mb-4" style="font-size: 1.05rem; line-height: 1.6;">
                            {{ $product->short_description ?: 'Treat yourself or someone special with this luxurious gift selection. Carefully selected, beautifully packed, and crafted to deliver maximum joy.' }}
                        </p>

                        <!-- Stock Indicator -->
                        <div class="stock-indicator mb-4 d-flex align-items-center" id="stockDisplayContainer">
                            <span class="mr-3 text-dark font-weight-bold">Availability:</span>
                            <span id="productStockBadge" class="badge {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }} text-white px-3 py-2">
                                @if($product->stock > 0)
                                    <i class="fas fa-check-circle"></i> In Stock (<span id="productStockCount">{{ $product->stock }}</span> items remaining)
                                @else
                                    <i class="fas fa-times-circle"></i> Out Of Stock
                                @endif
                            </span>
                        </div>

                        <hr class="my-4">

                        <!-- Add to Cart & Actions Widget -->
                        <div class="product-action-wrapper">
                            @if($product->stock > 0 || ($product->variants && $product->variants->sum('stock') > 0))
                                <form action="{{ route('cart.add') }}" method="POST" id="addToCartForm">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    
                                    <!-- Color Selector -->
                                    @if(count($product->colors_list) > 0)
                                        <div class="product-variant-color mb-4">
                                            <label class="d-block font-weight-bold text-dark mb-2" style="font-size: 0.95rem;">
                                                <i class="fas fa-palette me-1" style="color: #ff7c8b;"></i> Select Color: 
                                                <span id="selectedColorName" class="badge bg-dark text-white ms-1 px-2 py-1" style="font-size: 0.85rem;">{{ $product->colors_list[0] }}</span>
                                            </label>
                                            <div class="d-flex flex-wrap gap-2 align-items-center">
                                                @foreach($product->colors_list as $index => $color)
                                                    @php
                                                        // Check if variant has photo for this color
                                                        $colorVariant = $product->variants ? $product->variants->firstWhere('color', $color) : null;
                                                        $colorImg = $colorVariant && $colorVariant->image ? asset($colorVariant->image) : null;
                                                    @endphp
                                                    <label class="color-option-label mb-0" style="cursor: pointer;">
                                                        <input type="radio" name="color" value="{{ $color }}" class="d-none color-radio" {{ $index === 0 ? 'checked' : '' }} onchange="onColorVariantChange('{{ addslashes($color) }}');">
                                                        <span class="color-pill px-3 py-2 border rounded-pill d-inline-flex align-items-center gap-2" style="font-size: 0.85rem; font-weight: 600; background: #fdfdfd; transition: all 0.2s;">
                                                            @if($colorImg)
                                                                <img src="{{ $colorImg }}" class="rounded-circle border" style="width: 18px; height: 18px; object-fit: cover;">
                                                            @else
                                                                <span class="color-dot rounded-circle" data-color-name="{{ strtolower($color) }}" style="width: 14px; height: 14px; display: inline-block; border: 1px solid rgba(0,0,0,0.15); background-color: #888;"></span>
                                                            @endif
                                                            {{ $color }}
                                                        </span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Size / Dimension Selector -->
                                    @if(count($product->sizes_list) > 0)
                                        <div class="product-variant-size mb-4">
                                            <label class="d-block font-weight-bold text-dark mb-2" style="font-size: 0.95rem;">
                                                <i class="fas fa-ruler-combined me-1" style="color: #ff7c8b;"></i> Select Size / Dimensions: 
                                                <span id="selectedSizeName" class="badge bg-dark text-white ms-1 px-2 py-1" style="font-size: 0.85rem;">{{ $product->sizes_list[0] }}</span>
                                            </label>
                                            <div class="d-flex flex-wrap gap-2 align-items-center">
                                                @foreach($product->sizes_list as $index => $size)
                                                    <label class="size-option-label mb-0" style="cursor: pointer;">
                                                        <input type="radio" name="size" value="{{ $size }}" class="d-none size-radio" {{ $index === 0 ? 'checked' : '' }} onchange="onSizeVariantChange('{{ addslashes($size) }}');">
                                                        <span class="size-pill px-3 py-2 border rounded-3 d-inline-block" style="font-size: 0.85rem; font-weight: 600; min-width: 65px; text-align: center; background: #fdfdfd; transition: all 0.2s;">
                                                            {{ $size }}
                                                        </span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <div class="d-flex align-items-center gap-3 flex-wrap mt-4" id="cartActionContainer">
                                        <div class="quantity-selector d-flex align-items-center border rounded-pill overflow-hidden bg-light" style="width: 140px; height: 50px;">
                                            <button type="button" class="btn btn-link text-dark text-decoration-none px-3 font-weight-bold" onclick="decrementQty()"><i class="fas fa-minus"></i></button>
                                            <input type="number" id="qty-input" name="qty" class="form-control text-center bg-transparent border-0 font-weight-bold" value="1" min="1" max="{{ $product->stock }}" style="box-shadow: none;">
                                            <button type="button" class="btn btn-link text-dark text-decoration-none px-3 font-weight-bold" onclick="incrementQty()"><i class="fas fa-plus"></i></button>
                                        </div>

                                        <button type="submit" id="addToCartBtn" class="btn text-white px-5 rounded-pill font-weight-bold d-flex align-items-center gap-2" style="background-color: #ff7c8b; border-color: #ff7c8b; height: 50px; font-size: 1.1rem; transition: all 0.3s; box-shadow: 0 4px 15px rgba(255,124,139,0.3);">
                                            <i class="fas fa-shopping-bag"></i> Add To Cart
                                        </button>

                                        <!-- Wishlist & Compare Buttons -->
                                        <a href="#" onclick="event.preventDefault(); document.getElementById('wl-form-show').submit();" class="btn btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; border-color: #ccc;" data-tooltip="tooltip" title="Add To Wishlist">
                                            <i class="fas fa-heart text-muted"></i>
                                        </a>

                                        <a href="#" onclick="event.preventDefault(); document.getElementById('cp-form-show').submit();" class="btn btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; border-color: #ccc;" data-tooltip="tooltip" title="Add To Compare">
                                            <i class="fas fa-exchange-alt text-muted"></i>
                                        </a>
                                    </div>
                                </form>

                                <form id="wl-form-show" action="{{ route('wishlist.add') }}" method="POST" class="d-none">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                </form>

                                <form id="cp-form-show" action="{{ route('compare.add') }}" method="POST" class="d-none">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                </form>
                            @else
                                <div class="d-flex align-items-center gap-3">
                                    <button class="btn btn-secondary px-5 rounded-pill font-weight-bold disabled" style="height: 50px; font-size: 1.1rem; background-color: #aaa; border-color: #aaa;">
                                        Out Of Stock
                                    </button>
                                </div>
                            @endif
                        </div>

                        <hr class="my-4">

                        <!-- Details Block -->
                        <div class="product-details-meta list-unstyled m-0 p-0 text-muted" style="font-size: 0.95rem;">
                            <div class="mb-2"><strong class="text-dark">SKU:</strong> <span id="productSkuDisplay">GH-{{ str_pad($product->id, 5, '0', STR_PAD_LEFT) }}</span></div>
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

    <!-- Product Variations Data & Live Switching Engine -->
    <script id="product-variants-data" type="application/json">
        {!! json_encode($product->variants) !!}
    </script>

    <script>
        var baseProduct = {
            image: "{{ asset($product->image) }}",
            price: {{ (float)$product->price }},
            compare_at_price: {{ $product->compare_at_price ? (float)$product->compare_at_price : 'null' }},
            stock: {{ (int)$product->stock }},
            sku: "GH-{{ str_pad($product->id, 5, '0', STR_PAD_LEFT) }}"
        };

        var variantsData = [];
        try {
            var rawJson = document.getElementById('product-variants-data').textContent;
            variantsData = JSON.parse(rawJson) || [];
        } catch (e) {
            variantsData = [];
        }

        // Color name to hex color mapper for color dots
        var colorMap = {
            'maroon': '#800000',
            'royal maroon': '#720017',
            'red': '#dc3545',
            'deep red': '#990000',
            'crimson': '#dc143c',
            'gold': '#d4af37',
            'antique gold': '#cf9b13',
            'yellow': '#ffc107',
            'green': '#28a745',
            'emerald green': '#046307',
            'olive': '#808000',
            'blue': '#007bff',
            'royal blue': '#1c39bb',
            'navy': '#000080',
            'navy blue': '#000080',
            'pink': '#ff7c8b',
            'baby pink': '#f8b9cb',
            'rose pink': '#e85a71',
            'purple': '#6f42c1',
            'lavender': '#967bb6',
            'orange': '#fd7e14',
            'black': '#222222',
            'white': '#f8f9fa',
            'ivory': '#fffff0',
            'ivory white': '#fdfaf2',
            'silver': '#c0c0c0',
            'grey': '#6c757d',
            'gray': '#6c757d',
            'brown': '#8b4513',
            'chocolate': '#7b3f00',
            'beige': '#f5f5dc'
        };

        // Colorize dots automatically on page load
        document.addEventListener('DOMContentLoaded', function() {
            var dots = document.querySelectorAll('.color-dot');
            dots.forEach(function(dot) {
                var cName = (dot.getAttribute('data-color-name') || '').trim().toLowerCase();
                var resolvedColor = colorMap[cName];
                if (!resolvedColor) {
                    // Try partial match
                    for (var key in colorMap) {
                        if (cName.indexOf(key) !== -1) {
                            resolvedColor = colorMap[key];
                            break;
                        }
                    }
                }
                if (resolvedColor) {
                    dot.style.backgroundColor = resolvedColor;
                }
            });

            // Initial variant evaluation
            syncVariantSelection();
        });

        function onColorVariantChange(colorName) {
            var label = document.getElementById('selectedColorName');
            if (label) label.innerText = colorName;
            syncVariantSelection();
        }

        function onSizeVariantChange(sizeName) {
            var label = document.getElementById('selectedSizeName');
            if (label) label.innerText = sizeName;
            syncVariantSelection();
        }

        function syncVariantSelection() {
            var selColor = document.querySelector('input[name="color"]:checked')?.value || null;
            var selSize = document.querySelector('input[name="size"]:checked')?.value || null;

            var matchedVariant = null;

            if (variantsData && variantsData.length > 0) {
                // 1. Exact match (both Color AND Size)
                if (selColor && selSize) {
                    matchedVariant = variantsData.find(function(v) {
                        return (v.color && v.color.trim().toLowerCase() === selColor.trim().toLowerCase()) &&
                               (v.size && v.size.trim().toLowerCase() === selSize.trim().toLowerCase());
                    });
                }

                // 2. Color match fallback
                if (!matchedVariant && selColor) {
                    matchedVariant = variantsData.find(function(v) {
                        return v.color && v.color.trim().toLowerCase() === selColor.trim().toLowerCase();
                    });
                }

                // 3. Size match fallback
                if (!matchedVariant && selSize) {
                    matchedVariant = variantsData.find(function(v) {
                        return v.size && v.size.trim().toLowerCase() === selSize.trim().toLowerCase();
                    });
                }
            }

            // Target Values
            var targetImg = (matchedVariant && matchedVariant.image) ? ("{{ url('') }}/" + matchedVariant.image.replace(/^\//, '')) : baseProduct.image;
            var targetPrice = (matchedVariant && matchedVariant.price !== null && matchedVariant.price !== undefined) ? parseFloat(matchedVariant.price) : baseProduct.price;
            var targetCompare = (matchedVariant && matchedVariant.compare_at_price) ? parseFloat(matchedVariant.compare_at_price) : baseProduct.compare_at_price;
            var targetStock = (matchedVariant && matchedVariant.stock !== null && matchedVariant.stock !== undefined) ? parseInt(matchedVariant.stock) : baseProduct.stock;
            var targetSku = (matchedVariant && matchedVariant.sku) ? matchedVariant.sku : baseProduct.sku;

            // 1. Update Image with smooth fade
            var mainImg = document.getElementById('mainProductImage');
            if (mainImg && mainImg.src !== targetImg) {
                mainImg.style.opacity = '0.3';
                setTimeout(function() {
                    mainImg.src = targetImg;
                    mainImg.style.opacity = '1';
                }, 180);
            }

            // 2. Update Prices
            var priceElem = document.getElementById('productCurrentPrice');
            if (priceElem) {
                priceElem.innerText = '₹' + targetPrice.toFixed(2);
            }

            var compareElem = document.getElementById('productComparePrice');
            var discountBadge = document.getElementById('productDiscountBadge');

            if (targetCompare && targetCompare > targetPrice) {
                if (compareElem) {
                    compareElem.innerText = '₹' + targetCompare.toFixed(2);
                    compareElem.classList.remove('d-none');
                }
                if (discountBadge) {
                    var discountPct = Math.round(((targetCompare - targetPrice) / targetCompare) * 100);
                    discountBadge.innerText = 'Save ' + discountPct + '%';
                    discountBadge.classList.remove('d-none');
                }
            } else {
                if (compareElem) compareElem.classList.add('d-none');
                if (discountBadge) discountBadge.classList.add('d-none');
            }

            // 3. Update Stock & Availability
            var stockBadge = document.getElementById('productStockBadge');
            var stockCount = document.getElementById('productStockCount');
            var qtyInput = document.getElementById('qty-input');
            var addToCartBtn = document.getElementById('addToCartBtn');

            if (targetStock > 0) {
                if (stockBadge) {
                    stockBadge.className = 'badge bg-success text-white px-3 py-2';
                    stockBadge.innerHTML = '<i class="fas fa-check-circle"></i> In Stock (<span id="productStockCount">' + targetStock + '</span> items remaining)';
                }
                if (qtyInput) {
                    qtyInput.max = targetStock;
                    if (parseInt(qtyInput.value) > targetStock) {
                        qtyInput.value = targetStock;
                    }
                }
                if (addToCartBtn) {
                    addToCartBtn.disabled = false;
                    addToCartBtn.innerHTML = '<i class="fas fa-shopping-bag"></i> Add To Cart';
                    addToCartBtn.classList.remove('disabled');
                }
            } else {
                if (stockBadge) {
                    stockBadge.className = 'badge bg-danger text-white px-3 py-2';
                    stockBadge.innerHTML = '<i class="fas fa-times-circle"></i> Out Of Stock';
                }
                if (addToCartBtn) {
                    addToCartBtn.disabled = true;
                    addToCartBtn.innerText = 'Out Of Stock';
                    addToCartBtn.classList.add('disabled');
                }
            }

            // 4. Update SKU
            var skuElem = document.getElementById('productSkuDisplay');
            if (skuElem) {
                skuElem.innerText = targetSku;
            }
        }

        function incrementQty() {
            var input = document.getElementById('qty-input');
            var val = parseInt(input.value);
            var max = parseInt(input.max) || 999;
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

        /* Color & Size Variant Selection Styles */
        .color-radio:checked + .color-pill {
            background-color: #222 !important;
            color: #fff !important;
            border-color: #222 !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .color-radio:checked + .color-pill .color-dot {
            border-color: #fff !important;
        }
        .color-pill:hover {
            border-color: #ff7c8b !important;
        }

        .size-radio:checked + .size-pill {
            background-color: #ff7c8b !important;
            color: #fff !important;
            border-color: #ff7c8b !important;
            box-shadow: 0 4px 12px rgba(255,124,139,0.3);
        }
        .size-pill:hover {
            border-color: #ff7c8b !important;
        }
    </style>

@endsection
