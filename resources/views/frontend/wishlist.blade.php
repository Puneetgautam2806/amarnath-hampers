@extends('frontend.layouts.app')

@section('content')
<main class="main">

    <!-- breadcrumb -->
    <div class="site-breadcrumb" style="background: url({{ asset('frontend/assets/img/breadcrumb/01.jpg') }})">
        <div class="container">
            <h2 class="breadcrumb-title">My Wishlist</h2>
            <ul class="breadcrumb-menu">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li class="active">Wishlist</li>
            </ul>
        </div>
    </div>
    <!-- breadcrumb end -->

    <!-- wishlist area -->
    <div class="wishlist-area py-120">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="wishlist-wrap">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="wishlist-table table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light text-center">
                                    <tr>
                                        <th>Image</th>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Stock Status</th>
                                        <th>Add to Cart</th>
                                        <th>Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($products as $product)
                                        <tr class="text-center align-middle">
                                            <td>
                                                <a href="{{ route('shop.show', $product->slug) }}">
                                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" style="max-height: 80px; max-width: 80px; object-fit: contain;">
                                                </a>
                                            </td>
                                            <td class="text-start">
                                                <h5 class="mb-0">
                                                    <a href="{{ route('shop.show', $product->slug) }}" class="text-dark">{{ $product->name }}</a>
                                                </h5>
                                            </td>
                                            <td>
                                                <span class="text-pink fw-bold">₹{{ number_format($product->price, 2) }}</span>
                                            </td>
                                            <td>
                                                @if($product->stock > 0)
                                                    <span class="badge bg-success">In Stock</span>
                                                @else
                                                    <span class="badge bg-danger">Out of Stock</span>
                                                @endif
                                            </td>
                                            <td>
                                                <form action="{{ route('cart.add') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    <input type="hidden" name="qty" value="1">
                                                    <button type="submit" class="btn btn-sm btn-primary rounded-pill px-4" style="background-color: #ff7c8b; border-color: #ff7c8b;" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                                        <i class="fas fa-shopping-cart"></i> Add to Cart
                                                    </button>
                                                </form>
                                            </td>
                                            <td>
                                                <a href="{{ route('wishlist.remove', $product->id) }}" class="btn btn-sm btn-outline-danger rounded-circle" title="Remove">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5">
                                                <div class="d-flex flex-column align-items-center">
                                                    <i class="fas fa-heart fa-3x text-muted mb-3"></i>
                                                    <h4 class="text-muted">Your Wishlist is empty</h4>
                                                    <a href="{{ route('shop.index') }}" class="btn btn-primary mt-3 rounded-pill px-4" style="background-color: #ff7c8b; border-color: #ff7c8b;">Explore Products</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- wishlist area end -->

</main>
@endsection
