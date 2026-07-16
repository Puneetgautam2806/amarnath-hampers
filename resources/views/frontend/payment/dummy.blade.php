@extends('frontend.layouts.app')

@section('content')

<!-- breadcrumb -->
<div class="site-breadcrumb-wrap" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('{{ asset('frontend/assets/img/banner/big-banner.jpg') }}') no-repeat center center; background-size: cover; padding: 100px 0;">
    <div class="container">
        <div class="site-breadcrumb-content text-center text-white">
            <h2 class="breadcrumb-title text-white" style="font-size: 3rem; font-weight: 800; letter-spacing: 1px; margin-bottom: 10px; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">Payment Checkout</h2>
            <ul class="breadcrumb-menu d-flex justify-content-center gap-3 list-unstyled" style="font-size: 1.1rem; font-weight: 500;">
                <li><a href="{{ route('home') }}" class="text-white text-decoration-none hover-pink" style="transition: color 0.3s;">Home</a></li>
                <li class="text-white opacity-50"><i class="fas fa-chevron-right" style="font-size: 0.8rem;"></i></li>
                <li class="active text-pink" style="color: #ff7c8b !important;">Payment</li>
            </ul>
        </div>
    </div>
</div>
<!-- breadcrumb end -->

<div class="payment-area" style="padding: 100px 0; background-color: #f8f9fa;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                <div class="alert alert-info rounded-custom mb-4 border-0 p-4 d-flex align-items-center shadow-sm" style="background-color: #e3f2fd; color: #0277bd;">
                    <div style="background: rgba(2, 119, 189, 0.1); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                        <i class="fas fa-info-circle fa-lg"></i>
                    </div>
                    <div>
                        <h5 class="mb-1 font-weight-bold" style="color: #01579b;">Development Mode</h5>
                        <p class="mb-0">This is a simulated payment gateway. Clicking "Pay Now" will automatically approve the transaction.</p>
                    </div>
                </div>

                <div class="auth-card bg-white p-5">
                    <div class="text-center mb-5 border-bottom pb-4">
                        <div class="mx-auto mb-3" style="width: 80px; height: 80px; background: rgba(255, 124, 139, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #ff7c8b;">
                            <i class="fas fa-credit-card fa-3x"></i>
                        </div>
                        <h3 class="font-weight-bold" style="color: #1a1a1a;">Complete Your Payment</h3>
                        <p class="text-muted">Order Reference: <strong>{{ $order->order_number }}</strong></p>
                    </div>

                    <div class="row mb-5">
                        <div class="col-md-6 mb-4 mb-md-0">
                            <h5 class="font-weight-bold mb-3 border-bottom pb-2" style="color: #1a1a1a;">Billing Details</h5>
                            <p class="mb-1 text-muted"><i class="fas fa-user mr-2 text-pink"></i> {{ $order->name }}</p>
                            <p class="mb-1 text-muted"><i class="fas fa-envelope mr-2 text-pink"></i> {{ $order->email }}</p>
                            <p class="mb-1 text-muted"><i class="fas fa-phone mr-2 text-pink"></i> {{ $order->phone }}</p>
                            <p class="mb-0 text-muted"><i class="fas fa-map-marker-alt mr-2 text-pink"></i> {{ $order->address }}, {{ $order->city }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5 class="font-weight-bold mb-3 border-bottom pb-2" style="color: #1a1a1a;">Order Summary</h5>
                            <div class="d-flex justify-content-between mb-2 text-muted">
                                <span>Subtotal</span>
                                <span>₹{{ number_format($order->subtotal, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3 text-muted">
                                <span>Shipping</span>
                                <span>₹{{ number_format($order->shipping, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between pt-2 border-top">
                                <span class="font-weight-bold" style="color: #1a1a1a; font-size: 1.2rem;">Total Amount</span>
                                <span class="font-weight-bold text-pink" style="font-size: 1.3rem;">₹{{ number_format($order->total, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('payment.process', $order->order_number) }}" method="POST">
                        @csrf
                        <div class="bg-light p-4 rounded-custom mb-4 border">
                            <div class="custom-control custom-radio mb-3">
                                <input type="radio" id="payment_dummy" name="payment_method" class="custom-control-input" checked>
                                <label class="custom-control-label font-weight-bold d-flex align-items-center" for="payment_dummy">
                                    Simulated Credit Card
                                    <div class="ml-auto">
                                        <i class="fab fa-cc-visa fa-2x text-muted mx-1"></i>
                                        <i class="fab fa-cc-mastercard fa-2x text-muted mx-1"></i>
                                        <i class="fab fa-cc-amex fa-2x text-muted mx-1"></i>
                                    </div>
                                </label>
                            </div>
                            <div class="pl-4 ml-2 text-muted" style="font-size: 0.9rem;">
                                No real card details are required. Click the button below to process this order.
                            </div>
                        </div>

                        <button type="submit" class="btn w-100 auth-btn text-white d-flex justify-content-center align-items-center">
                            <i class="fas fa-lock-alt mr-2"></i> Pay ₹{{ number_format($order->total, 2) }} Now
                        </button>
                    </form>
                    
                    <div class="text-center mt-4">
                        <p class="text-muted small"><i class="fas fa-shield-check text-success mr-1"></i> Secure 256-bit SSL Encryption Simulation</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .auth-card {
        border: none;
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.06);
    }
    .rounded-custom { border-radius: 16px; }
    .auth-btn {
        background: linear-gradient(135deg, #ff7c8b, #ff5b6f);
        border: none;
        border-radius: 50px;
        height: 60px;
        font-weight: 700;
        font-size: 1.2rem;
        letter-spacing: 0.5px;
        transition: all 0.4s ease;
        box-shadow: 0 10px 20px rgba(255, 124, 139, 0.3);
    }
    .auth-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(255, 124, 139, 0.45);
        background: linear-gradient(135deg, #ff5b6f, #ff7c8b);
    }
    .text-pink { color: #ff7c8b !important; }
    .hover-pink:hover { color: #ff7c8b !important; text-decoration: none; }
    .custom-control-input:checked ~ .custom-control-label::before {
        border-color: #ff7c8b;
        background-color: #ff7c8b;
    }
</style>
@endsection
