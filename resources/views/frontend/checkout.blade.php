@extends('frontend.layouts.app')

@section('content')

    <!-- breadcrumb -->
    <div class="site-breadcrumb-wrap" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('frontend/assets/img/banner/big-banner.jpg') }}') no-repeat center center; background-size: cover; padding: 80px 0;">
        <div class="container">
            <div class="site-breadcrumb-content text-center text-white">
                <h2 class="breadcrumb-title text-white" style="font-size: 2.5rem; font-weight: 700; margin-bottom: 10px;">Secure Checkout</h2>
                <ul class="breadcrumb-menu d-flex justify-content-center gap-2 list-unstyled">
                    <li><a href="{{ route('home') }}" class="text-white opacity-75 text-decoration-none">Home</a></li>
                    <li class="text-white opacity-50">/</li>
                    <li><a href="{{ route('cart.index') }}" class="text-white opacity-75 text-decoration-none">Cart</a></li>
                    <li class="text-white opacity-50">/</li>
                    <li class="active text-white">Checkout</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- breadcrumb end -->

    <!-- checkout area -->
    <div class="checkout-area py-100" style="padding: 80px 0; background-color: #fcf8f8;">
        <div class="container">
            
            <!-- Alert Display -->
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show rounded-pill px-4 mb-4" role="alert">
                    <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show rounded px-4 mb-4" role="alert" style="border-radius: 15px;">
                    <i class="fas fa-exclamation-circle mr-2 font-weight-bold"></i> <strong>Please correct the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf
                <div class="row">
                    <!-- Billing Details Column -->
                    <div class="col-lg-7 mb-5">
                        <div class="bg-white rounded border shadow-sm p-4 h-100" style="border-radius: 20px !important;">
                            <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                                <h3 class="font-weight-bold mb-0" style="font-size: 1.4rem; border-left: 4px solid #ff7c8b; padding-left: 10px;">Billing Details</h3>
                                <div class="badge rounded-pill bg-soft-pink text-pink py-2 px-3 d-flex align-items-center gap-1 cursor-pointer" onclick="jollyQuickFill()" style="background-color: rgba(255, 124, 139, 0.1); border: 1px solid rgba(255, 124, 139, 0.2); cursor: pointer; transition: all 0.2s;" id="jollyBadge" title="Click to reload Jolly's credentials">
                                    <i class="fas fa-sparkles text-pink animate-pulse"></i> <span>Jolly Demo Guest</span>
                                </div>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-12">
                                    <label class="form-label font-weight-bold text-dark mb-2" style="font-size: 0.95rem;">Full Name <span class="text-danger">*</span></label>
                                    <div class="input-group-custom">
                                        <i class="fas fa-user input-icon"></i>
                                        <input type="text" name="name" id="billing_name" class="form-control custom-input" placeholder="Your full name" value="{{ old('name', 'Jolly') }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label font-weight-bold text-dark mb-2" style="font-size: 0.95rem;">Email Address <span class="text-danger">*</span></label>
                                    <div class="input-group-custom">
                                        <i class="fas fa-envelope input-icon"></i>
                                        <input type="email" name="email" id="billing_email" class="form-control custom-input" placeholder="name@example.com" value="{{ old('email', 'jolly@example.com') }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label font-weight-bold text-dark mb-2" style="font-size: 0.95rem;">Phone Number <span class="text-danger">*</span></label>
                                    <div class="input-group-custom">
                                        <i class="fas fa-phone input-icon"></i>
                                        <input type="text" name="phone" id="billing_phone" class="form-control custom-input" placeholder="+1 (555) 000-0000" value="{{ old('phone', '+1 (555) 019-2834') }}" required>
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <label class="form-label font-weight-bold text-dark mb-2" style="font-size: 0.95rem;">Delivery Address <span class="text-danger">*</span></label>
                                    <div class="input-group-custom">
                                        <i class="fas fa-map-marker-alt input-icon"></i>
                                        <input type="text" name="address" id="billing_address" class="form-control custom-input" placeholder="Street Address, Apartment, Suite, Unit" value="{{ old('address', '777 Celebration Boulevard, Suite 100') }}" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label font-weight-bold text-dark mb-2" style="font-size: 0.95rem;">Town / City <span class="text-danger">*</span></label>
                                    <div class="input-group-custom">
                                        <i class="fas fa-building input-icon"></i>
                                        <input type="text" name="city" id="billing_city" class="form-control custom-input" placeholder="City" value="{{ old('city', 'Joyville') }}" required>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label font-weight-bold text-dark mb-2" style="font-size: 0.95rem;">Order Notes (Optional)</label>
                                    <textarea name="order_note" id="billing_note" class="form-control custom-textarea" rows="4" placeholder="Notes about your order, e.g. special delivery instructions or gift messages.">{{ old('order_note', 'Please wrap this gift hamper beautifully with a hand-written card saying \'Welcome, Jolly!\'') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary Column -->
                    <div class="col-lg-5 mb-5">
                        <div class="bg-white rounded border shadow-sm p-4 h-100" style="border-radius: 20px !important;">
                            <h3 class="font-weight-bold mb-4 pb-2 border-bottom" style="font-size: 1.4rem; border-left: 4px solid #ff7c8b; padding-left: 10px;">Your Order</h3>
                            
                            <!-- Items List -->
                            <div class="order-items-scroll mb-4" style="max-height: 280px; overflow-y: auto; padding-right: 5px;">
                                @php $subtotal = 0; @endphp
                                @foreach($cart as $id => $item)
                                    @php
                                        $itemTotal = $item['price'] * $item['qty'];
                                        $subtotal += $itemTotal;
                                    @endphp
                                    <div class="d-flex align-items-center justify-content-between py-3 border-bottom">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="border rounded bg-light p-1" style="width: 55px; height: 55px; display: flex; align-items: center; justify-content: center; background-color: #fcf8f8;">
                                                <img src="{{ asset($item['image']) }}" class="img-fluid" style="max-height: 45px; object-fit: contain;" alt="{{ $item['name'] }}">
                                            </div>
                                            <div>
                                                <h6 class="mb-0 text-dark font-weight-bold" style="font-size: 0.95rem; max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $item['name'] }}</h6>
                                                <small class="text-muted">₹{{ number_format($item['price'], 2) }} &times; {{ $item['qty'] }}</small>
                                            </div>
                                        </div>
                                        <span class="font-weight-bold text-dark" style="font-size: 1rem;">₹{{ number_format($itemTotal, 2) }}</span>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Totals Box -->
                            <div class="bg-light p-3 rounded mb-4" style="border-radius: 15px !important; background-color: #fcfbfb !important; border: 1px solid #f3efef;">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">Subtotal</span>
                                    <span class="font-weight-bold text-dark">₹{{ number_format($subtotal, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">Standard Flat Shipping</span>
                                    <span class="font-weight-bold text-dark">₹15.00</span>
                                </div>
                                <hr class="my-2 border-dashed">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-dark font-weight-bold" style="font-size: 1.05rem;">Grand Total</span>
                                    <span class="font-weight-bold text-pink" style="font-size: 1.4rem; color: #ff7c8b;">₹{{ number_format($subtotal + 15.00, 2) }}</span>
                                </div>
                            </div>

                            <!-- Payment Options -->
                            <div class="mb-4">
                                <h5 class="font-weight-bold mb-3" style="font-size: 1.05rem;">Payment Method</h5>
                                <div class="border rounded p-3 mb-2" style="border-radius: 12px !important; border-color: rgba(255, 124, 139, 0.3) !important; background-color: rgba(255, 124, 139, 0.02);">
                                    <div class="form-check d-flex align-items-center gap-2">
                                        <input class="form-check-input custom-radio" type="radio" name="payment_method" id="cod" checked style="accent-color: #ff7c8b;">
                                        <label class="form-check-label font-weight-bold text-dark mb-0" for="cod" style="cursor: pointer;">
                                            Cash on Delivery (COD)
                                        </label>
                                    </div>
                                    <p class="text-muted small mt-2 mb-0 pl-4">Pay securely in cash when our courier delivers the premium gift hamper directly to your doorstep. Free and reliable service.</p>
                                </div>
                                <div class="border rounded p-3 opacity-50 bg-light" style="border-radius: 12px !important; cursor: not-allowed;">
                                    <div class="form-check d-flex align-items-center gap-2">
                                        <input class="form-check-input" type="radio" name="payment_method" id="online" disabled>
                                        <label class="form-check-label font-weight-bold text-muted mb-0" for="online">
                                            Credit / Debit Card (Online Payment)
                                        </label>
                                    </div>
                                    <p class="text-muted small mt-2 mb-0">Temporarily offline for scheduled updates. Please use COD for express dispatch.</p>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary w-100 rounded-pill py-3 font-weight-bold text-white d-flex align-items-center justify-content-center gap-2 button-pink-gradient shadow-pink" style="font-size: 1.1rem; border: none; transition: all 0.3s;">
                                Place Order & Proceed <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
    <!-- checkout area end -->

    <!-- Javascript Quick Fill Engine for Jolly -->
    <script>
        function jollyQuickFill() {
            document.getElementById('billing_name').value = 'Jolly';
            document.getElementById('billing_email').value = 'jolly@example.com';
            document.getElementById('billing_phone').value = '+1 (555) 019-2834';
            document.getElementById('billing_address').value = '777 Celebration Boulevard, Suite 100';
            document.getElementById('billing_city').value = 'Joyville';
            document.getElementById('billing_note').value = "Please wrap this gift hamper beautifully with a hand-written card saying 'Welcome, Jolly!'";
            
            // Add custom animation feedback
            var badge = document.getElementById('jollyBadge');
            badge.style.transform = 'scale(1.1)';
            badge.style.backgroundColor = 'rgba(255, 124, 139, 0.25)';
            setTimeout(function() {
                badge.style.transform = 'scale(1)';
                badge.style.backgroundColor = 'rgba(255, 124, 139, 0.1)';
            }, 300);
        }
    </script>

    <!-- Custom Premium Stylesheets -->
    <style>
        .text-pink {
            color: #ff7c8b !important;
        }
        .bg-soft-pink {
            background-color: rgba(255, 124, 139, 0.1) !important;
        }
        .border-dashed {
            border-top: 1px dashed #dee2e6;
        }
        
        /* Premium custom inputs */
        .input-group-custom {
            position: relative;
            display: flex;
            align-items: center;
        }
        
        .input-icon {
            position: absolute;
            left: 20px;
            color: #b0b0b0;
            font-size: 0.95rem;
            pointer-events: none;
            transition: color 0.3s;
        }
        
        .custom-input {
            height: 50px;
            padding-left: 48px !important;
            padding-right: 20px !important;
            border-radius: 25px !important;
            border: 1.5px solid #e9ecef !important;
            background-color: #fdfdfd !important;
            font-size: 0.95rem;
            color: #495057;
            transition: all 0.3s ease-in-out;
        }
        
        .custom-input:focus {
            background-color: #ffffff !important;
            border-color: #ff7c8b !important;
            box-shadow: 0 0 0 4px rgba(255, 124, 139, 0.15) !important;
            color: #212529;
        }
        
        .custom-input:focus + .input-icon {
            color: #ff7c8b;
        }
        
        /* Custom Textarea */
        .custom-textarea {
            border-radius: 18px !important;
            border: 1.5px solid #e9ecef !important;
            padding: 15px 20px !important;
            background-color: #fdfdfd !important;
            font-size: 0.95rem;
            color: #495057;
            transition: all 0.3s ease-in-out;
            resize: none;
        }
        
        .custom-textarea:focus {
            background-color: #ffffff !important;
            border-color: #ff7c8b !important;
            box-shadow: 0 0 0 4px rgba(255, 124, 139, 0.15) !important;
            color: #212529;
        }
        
        /* Premium Gradient buttons */
        .button-pink-gradient {
            background: linear-gradient(135deg, #ff7c8b 0%, #ff5270 100%) !important;
        }
        
        .button-pink-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 82, 112, 0.3) !important;
            background: linear-gradient(135deg, #ff8d9c 0%, #ff637f 100%) !important;
        }
        
        .button-pink-gradient:active {
            transform: translateY(1px);
        }
        
        .shadow-pink {
            box-shadow: 0 4px 15px rgba(255, 124, 139, 0.2);
        }
        
        /* Custom Radio Styles */
        .custom-radio:checked {
            background-color: #ff7c8b;
            border-color: #ff7c8b;
        }
        
        /* Keyframe Pulse */
        @keyframes pulse-custom {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.6; transform: scale(0.92); }
        }
        .animate-pulse {
            animation: pulse-custom 2s infinite ease-in-out;
        }
    </style>

@endsection
