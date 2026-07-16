@extends('frontend.layouts.app')

@section('content')
<main class="main">

    <!-- breadcrumb -->
    <div class="site-breadcrumb" style="background: url({{ asset('frontend/assets/img/breadcrumb/01.jpg') }})">
        <div class="container">
            <h2 class="breadcrumb-title">Compare Products</h2>
            <ul class="breadcrumb-menu">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li class="active">Compare</li>
            </ul>
        </div>
    </div>
    <!-- breadcrumb end -->

    <!-- compare area -->
    <div class="compare-area py-120">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="compare-wrap">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="compare-table table-responsive">
                            <table class="table table-bordered table-hover" style="table-layout: fixed; min-width: 800px;">
                                @if(count($products) > 0)
                                    <tbody>
                                        <!-- Images -->
                                        <tr>
                                            <th class="table-light align-middle text-center fw-bold" style="width: 20%;">Product Image</th>
                                            @foreach($products as $product)
                                                <td class="text-center position-relative">
                                                    <a href="{{ route('compare.remove', $product->id) }}" class="position-absolute top-0 end-0 m-2 text-danger" title="Remove">
                                                        <i class="fas fa-times-circle fa-lg"></i>
                                                    </a>
                                                    <a href="{{ route('shop.show', $product->slug) }}">
                                                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" style="max-height: 150px; max-width: 150px; object-fit: contain;">
                                                    </a>
                                                </td>
                                            @endforeach
                                        </tr>

                                        <!-- Names -->
                                        <tr>
                                            <th class="table-light align-middle text-center fw-bold">Name</th>
                                            @foreach($products as $product)
                                                <td class="text-center align-middle" style="white-space: normal; word-wrap: break-word;">
                                                    <h5 class="mb-0"><a href="{{ route('shop.show', $product->slug) }}" class="text-dark">{{ $product->name }}</a></h5>
                                                </td>
                                            @endforeach
                                        </tr>

                                        <!-- Prices -->
                                        <tr>
                                            <th class="table-light align-middle text-center fw-bold">Price</th>
                                            @foreach($products as $product)
                                                <td class="text-center align-middle">
                                                    @if($product->compare_at_price)
                                                        <del class="text-muted mr-1">₹{{ number_format($product->compare_at_price, 2) }}</del>
                                                    @endif
                                                    <span class="text-pink fw-bold" style="font-size: 1.1rem;">₹{{ number_format($product->price, 2) }}</span>
                                                </td>
                                            @endforeach
                                        </tr>

                                        <!-- Category -->
                                        <tr>
                                            <th class="table-light align-middle text-center fw-bold">Category</th>
                                            @foreach($products as $product)
                                                <td class="text-center align-middle text-muted">
                                                    {{ $product->category->name ?? 'Uncategorized' }}
                                                </td>
                                            @endforeach
                                        </tr>

                                        <!-- Description -->
                                        <tr>
                                            <th class="table-light align-middle text-center fw-bold">Description</th>
                                            @foreach($products as $product)
                                                <td class="align-middle text-muted" style="font-size: 0.9rem; white-space: normal; word-wrap: break-word;">
                                                    {{ Str::limit(strip_tags($product->description), 120) }}
                                                </td>
                                            @endforeach
                                        </tr>

                                        <!-- Stock -->
                                        <tr>
                                            <th class="table-light align-middle text-center fw-bold">Availability</th>
                                            @foreach($products as $product)
                                                <td class="text-center align-middle">
                                                    @if($product->stock > 0)
                                                        <span class="badge bg-success">In Stock</span>
                                                    @else
                                                        <span class="badge bg-danger">Out of Stock</span>
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>

                                        <!-- Add to Cart -->
                                        <tr>
                                            <th class="table-light align-middle text-center fw-bold">Action</th>
                                            @foreach($products as $product)
                                                <td class="text-center align-middle">
                                                    <form action="{{ route('cart.add') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                        <input type="hidden" name="qty" value="1">
                                                        <button type="submit" class="btn btn-sm btn-primary rounded-pill px-4" style="background-color: #ff7c8b; border-color: #ff7c8b;" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                                            <i class="fas fa-shopping-cart"></i> Add to Cart
                                                        </button>
                                                    </form>
                                                </td>
                                            @endforeach
                                        </tr>
                                    </tbody>
                                @else
                                    <tbody>
                                        <tr>
                                            <td class="text-center py-5">
                                                <div class="d-flex flex-column align-items-center">
                                                    <i class="fas fa-exchange-alt fa-3x text-muted mb-3"></i>
                                                    <h4 class="text-muted">Your Compare list is empty</h4>
                                                    <a href="{{ route('shop.index') }}" class="btn btn-primary mt-3 rounded-pill px-4" style="background-color: #ff7c8b; border-color: #ff7c8b;">Explore Products</a>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- compare area end -->

</main>
@endsection
