@extends('frontend.layouts.app')

@section('content')

    <!-- breadcrumb -->
    <div class="site-breadcrumb-wrap" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('frontend/assets/img/banner/big-banner.jpg') }}') no-repeat center center; background-size: cover; padding: 80px 0;">
        <div class="container">
            <div class="site-breadcrumb-content text-center text-white">
                <h2 class="breadcrumb-title text-white" style="font-size: 2.5rem; font-weight: 700; margin-bottom: 10px;">Shopping Cart</h2>
                <ul class="breadcrumb-menu d-flex justify-content-center gap-2 list-unstyled">
                    <li><a href="{{ route('home') }}" class="text-white opacity-75">Home</a></li>
                    <li class="text-white opacity-50">/</li>
                    <li class="active text-white">Cart</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- breadcrumb end -->

    <!-- cart area -->
    <div class="cart-area py-100" style="padding: 80px 0;">
        <div class="container">
            
            <!-- Alert Display -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-pill px-4 mb-4" role="alert">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show rounded-pill px-4 mb-4" role="alert">
                    <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(empty($cart))
                <div class="text-center py-5 rounded bg-white shadow-sm border">
                    <i class="fas fa-shopping-bag fa-5x mb-4 text-muted" style="color: #ff7c8b !important; opacity: 0.5;"></i>
                    <h2 class="font-weight-bold mb-2">Your Shopping Cart is Empty</h2>
                    <p class="text-muted mb-4">You have no items in your cart. Add premium gift hampers to start shopping.</p>
                    <a href="{{ route('shop.index') }}" class="btn btn-primary rounded-pill px-5 py-3 font-weight-bold text-white" style="background-color: #ff7c8b; border-color: #ff7c8b; transition: all 0.3s;">
                        Go To Shop <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            @else
                <form action="{{ route('cart.update') }}" method="POST">
                    @csrf
                    <div class="row">
                        <!-- Cart List Table -->
                        <div class="col-lg-8 mb-5">
                            <div class="table-responsive bg-white rounded border shadow-sm p-3">
                                <table class="table align-middle text-center mb-0" style="min-width: 600px;">
                                    <thead class="bg-light border-0">
                                        <tr>
                                            <th class="py-3 text-dark font-weight-bold" style="border:none;">Product</th>
                                            <th class="py-3 text-dark font-weight-bold" style="border:none;">Price</th>
                                            <th class="py-3 text-dark font-weight-bold" style="border:none;">Quantity</th>
                                            <th class="py-3 text-dark font-weight-bold" style="border:none;">Total</th>
                                            <th class="py-3 text-dark font-weight-bold" style="border:none;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $subtotal = 0; @endphp
                                        @foreach($cart as $id => $item)
                                        @php
                                            $totalPrice = $item['price'] * $item['qty'];
                                            $subtotal += $totalPrice;
                                            $productObj = \App\Models\Product::find($id);
                                            $maxStock = $productObj ? $productObj->stock : 10;
                                        @endphp
                                        <tr class="border-bottom">
                                            <td class="py-4 text-left d-flex align-items-center gap-3">
                                                <div class="cart-img border rounded bg-light p-2" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; background-color: #fcf8f8;">
                                                    <img src="{{ asset($item['image']) }}" class="img-fluid" style="max-height: 60px; object-fit: contain;" alt="{{ $item['name'] }}">
                                                </div>
                                                <div>
                                                    <h5 class="font-weight-bold mb-0 text-left" style="font-size: 1.05rem; text-align: left;">
                                                        <a href="{{ route('shop.show', $item['slug']) }}" class="text-dark text-decoration-none hover-pink">{{ $item['name'] }}</a>
                                                    </h5>
                                                </div>
                                            </td>
                                            <td class="py-4 font-weight-bold" style="font-size: 1.1rem;">
                                                ₹{{ number_format($item['price'], 2) }}
                                            </td>
                                            <td class="py-4">
                                                <div class="quantity-selector d-inline-flex align-items-center border rounded-pill overflow-hidden bg-light" style="width: 120px; height: 40px;">
                                                    <button type="button" class="btn btn-link text-dark text-decoration-none px-2 font-weight-bold" onclick="decrementQty({{ $id }})"><i class="fas fa-minus" style="font-size: 0.8rem;"></i></button>
                                                    <input type="number" id="qty-{{ $id }}" name="qty[{{ $id }}]" class="form-control text-center bg-transparent border-0 font-weight-bold p-0" value="{{ $item['qty'] }}" min="1" max="{{ $maxStock }}" style="box-shadow: none; font-size: 0.95rem;">
                                                    <button type="button" class="btn btn-link text-dark text-decoration-none px-2 font-weight-bold" onclick="incrementQty({{ $id }}, {{ $maxStock }})"><i class="fas fa-plus" style="font-size: 0.8rem;"></i></button>
                                                </div>
                                            </td>
                                            <td class="py-4 font-weight-bold text-pink" style="font-size: 1.1rem; color: #ff7c8b;">
                                                ₹{{ number_format($totalPrice, 2) }}
                                            </td>
                                            <td class="py-4">
                                                <a href="{{ route('cart.remove', $id) }}" class="btn btn-sm btn-outline-danger rounded-circle border-0 p-2" title="Remove Item" style="width: 38px; height: 38px; display: inline-flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Cart Buttons -->
                            <div class="cart-actions-bar d-flex justify-content-between align-items-center mt-4">
                                <a href="{{ route('shop.index') }}" class="btn btn-outline-dark rounded-pill px-4 py-2 font-weight-bold"><i class="fas fa-shopping-bag mr-2"></i> Continue Shopping</a>
                                <button type="submit" class="btn btn-dark rounded-pill px-4 py-2 font-weight-bold"><i class="fas fa-sync mr-2"></i> Update Cart</button>
                            </div>
                        </div>

                        <!-- Cart Summary Column -->
                        <div class="col-lg-4 mb-5">
                            <div class="cart-summary bg-white border rounded shadow-sm p-4">
                                <h3 class="font-weight-bold mb-4" style="font-size: 1.3rem; border-left: 3px solid #ff7c8b; padding-left: 10px;">Cart Summary</h3>
                                
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-muted">Subtotal</span>
                                    <span class="font-weight-bold">₹{{ number_format($subtotal, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-muted">Shipping Fee</span>
                                    <span class="font-weight-bold">₹15.00</span>
                                </div>
                                
                                <hr class="my-3">
                                
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <span class="text-dark font-weight-bold" style="font-size: 1.1rem;">Total Amount</span>
                                    <span class="font-weight-bold text-pink" style="font-size: 1.5rem; color: #ff7c8b;">₹{{ number_format($subtotal + 15, 2) }}</span>
                                </div>
                                
                                <a href="{{ route('checkout.index') }}" class="btn btn-primary w-100 rounded-pill py-3 font-weight-bold text-white d-flex align-items-center justify-content-center gap-2" style="background-color: #ff7c8b; border-color: #ff7c8b; font-size: 1.1rem; transition: all 0.3s;">
                                    Proceed To Checkout <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            @endif

        </div>
    </div>
    <!-- cart area end -->

    <!-- Script for Quantity Selector -->
    <script>
        function incrementQty(id, max) {
            var input = document.getElementById('qty-' + id);
            var val = parseInt(input.value);
            if (val < max) {
                input.value = val + 1;
            }
        }
        function decrementQty(id) {
            var input = document.getElementById('qty-' + id);
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
        .text-pink {
            color: #ff7c8b !important;
        }
    </style>

@endsection
