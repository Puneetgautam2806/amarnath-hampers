@extends('frontend.layouts.app')

@section('content')

    <!-- breadcrumb -->
    <div class="site-breadcrumb-wrap" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('frontend/assets/img/banner/big-banner.jpg') }}') no-repeat center center; background-size: cover; padding: 80px 0;">
        <div class="container">
            <div class="site-breadcrumb-content text-center text-white">
                <h2 class="breadcrumb-title text-white" style="font-size: 2.5rem; font-weight: 700; margin-bottom: 10px;">Order Confirmation</h2>
                <ul class="breadcrumb-menu d-flex justify-content-center gap-2 list-unstyled">
                    <li><a href="{{ route('home') }}" class="text-white opacity-75 text-decoration-none">Home</a></li>
                    <li class="text-white opacity-50">/</li>
                    <li class="active text-white">Order Completed</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- breadcrumb end -->

    <!-- invoice printing wrapper -->
    <div class="order-complete-area py-100" style="padding: 80px 0; background-color: #fcf8f8;" id="printable-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    
                    <!-- Alert Success -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show rounded-pill px-4 mb-4 text-center print-hide" role="alert" style="box-shadow: 0 4px 12px rgba(40, 167, 69, 0.1);">
                            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Invoice Header card -->
                    <div class="bg-white rounded border shadow-sm p-5 text-center mb-5 print-hide" style="border-radius: 20px !important;">
                        <div class="success-icon-wrap mb-4">
                            <div class="success-checkmark d-inline-flex align-items-center justify-content-center bg-soft-green rounded-circle" style="width: 90px; height: 90px; background-color: rgba(40, 167, 69, 0.1);">
                                <i class="fas fa-check text-green animate-bounce" style="font-size: 2.5rem; color: #28a745;"></i>
                            </div>
                        </div>
                        <h2 class="font-weight-bold mb-2 text-dark" style="font-size: 2rem;">Thank you for your order, {{ $order->name }}!</h2>
                        <p class="text-muted mb-4 px-lg-5">Your order has been received and is currently being prepared with love. A confirmation email has been dispatched to <strong>{{ $order->email }}</strong>.</p>
                        
                        <div class="d-flex justify-content-center gap-3 flex-wrap">
                            <a href="{{ route('shop.index') }}" class="btn btn-outline-dark rounded-pill px-4 py-2 font-weight-bold transition-all"><i class="fas fa-shopping-bag mr-2"></i> Continue Shopping</a>
                            <button onclick="window.print()" class="btn btn-primary rounded-pill px-4 py-2 font-weight-bold text-white button-pink-gradient shadow-pink border-0"><i class="fas fa-print mr-2"></i> Print Invoice Receipt</button>
                        </div>
                    </div>

                    <!-- Main Invoice Sheet -->
                    <div class="bg-white rounded border shadow-sm p-4 p-md-5" style="border-radius: 20px !important; border: 1.5px solid #eaeaea !important;">
                        
                        <!-- Invoice Title and Brand Logo -->
                        <div class="d-flex justify-content-between align-items-center mb-5 flex-wrap gap-4 border-bottom pb-4">
                            <div>
                                <h3 class="font-weight-bold text-dark mb-1" style="font-size: 1.8rem; letter-spacing: -0.5px;">INVOICE</h3>
                                <p class="text-muted mb-0">Invoice Number: <strong class="text-dark">{{ $order->order_number }}</strong></p>
                            </div>
                            <div class="text-md-end text-start">
                                <h4 class="font-weight-bold text-pink mb-1" style="color: #ff7c8b;">Amarnath Hampers</h4>
                                <p class="text-muted small mb-0">Premium Gift Hampers & Accessories<br>Email: info@amarnath-hampers.com</p>
                            </div>
                        </div>

                        <!-- Metadata Grid Dashboard -->
                        <div class="bg-light rounded p-4 mb-5" style="border-radius: 15px !important; border: 1px solid #f2eded; background-color: #fdfcfc !important;">
                            <div class="row g-3 text-center text-sm-start">
                                <div class="col-sm-3 border-sm-right">
                                    <span class="text-muted small uppercase font-weight-bold d-block mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">DATE PLACED</span>
                                    <strong class="text-dark" style="font-size: 0.95rem;">{{ $order->created_at->format('M d, Y h:i A') }}</strong>
                                </div>
                                <div class="col-sm-3 border-sm-right">
                                    <span class="text-muted small uppercase font-weight-bold d-block mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">ORDER STATUS</span>
                                    <span class="badge rounded-pill bg-warning text-dark px-3 py-1 font-weight-bold" style="font-size: 0.8rem; background-color: #ffeeba !important;">{{ ucfirst($order->status) }}</span>
                                </div>
                                <div class="col-sm-3 border-sm-right">
                                    <span class="text-muted small uppercase font-weight-bold d-block mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">PAYMENT METHOD</span>
                                    <strong class="text-dark" style="font-size: 0.95rem;">Cash On Delivery</strong>
                                </div>
                                <div class="col-sm-3">
                                    <span class="text-muted small uppercase font-weight-bold d-block mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">TOTAL AMOUNT</span>
                                    <strong class="text-pink" style="font-size: 1.1rem; color: #ff7c8b;">₹{{ number_format($order->total, 2) }}</strong>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Billing & Delivery Info -->
                        <div class="row g-4 mb-5">
                            <div class="col-md-6">
                                <div class="p-3 border rounded h-100" style="border-radius: 15px !important; border-color: #f1eeee !important; background-color: #fefefe;">
                                    <h5 class="font-weight-bold text-dark mb-3" style="font-size: 1.05rem; border-left: 3px solid #ff7c8b; padding-left: 8px;">Customer Information</h5>
                                    <ul class="list-unstyled mb-0" style="font-size: 0.95rem; line-height: 1.7;">
                                        <li><span class="text-muted">Name:</span> <strong class="text-dark">{{ $order->name }}</strong></li>
                                        <li><span class="text-muted">Email:</span> <a href="mailto:{{ $order->email }}" class="text-dark text-decoration-none">{{ $order->email }}</a></li>
                                        <li><span class="text-muted">Phone:</span> <span class="text-dark">{{ $order->phone }}</span></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 border rounded h-100" style="border-radius: 15px !important; border-color: #f1eeee !important; background-color: #fefefe;">
                                    <h5 class="font-weight-bold text-dark mb-3" style="font-size: 1.05rem; border-left: 3px solid #ff7c8b; padding-left: 8px;">Delivery Coordinates</h5>
                                    <ul class="list-unstyled mb-0" style="font-size: 0.95rem; line-height: 1.7;">
                                        <li><span class="text-muted">Street:</span> <span class="text-dark">{{ $order->address }}</span></li>
                                        <li><span class="text-muted">City/Town:</span> <span class="text-dark">{{ $order->city }}</span></li>
                                        <li><span class="text-muted">Country:</span> <span class="text-dark">United States (Standard Shipping)</span></li>
                                    </ul>
                                </div>
                            </div>
                            @if($order->order_note)
                            <div class="col-12">
                                <div class="p-3 border rounded bg-light" style="border-radius: 15px !important; border-color: #f1eeee !important;">
                                    <h5 class="font-weight-bold text-dark mb-2" style="font-size: 1.05rem;"><i class="fas fa-sticky-note mr-2 text-pink" style="color: #ff7c8b;"></i> Special Order Instructions</h5>
                                    <p class="text-dark mb-0 font-italic" style="font-size: 0.95rem; font-style: italic;">&ldquo;{{ $order->order_note }}&rdquo;</p>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Itemized Summary Table -->
                        <h5 class="font-weight-bold text-dark mb-3" style="font-size: 1.1rem;">Purchased Items</h5>
                        <div class="table-responsive rounded border mb-4">
                            <table class="table align-middle text-center mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="py-3 text-dark font-weight-bold" style="font-size: 0.9rem; border: none;">Product Name</th>
                                        <th class="py-3 text-dark font-weight-bold" style="font-size: 0.9rem; border: none;">Price</th>
                                        <th class="py-3 text-dark font-weight-bold" style="font-size: 0.9rem; border: none;">Quantity</th>
                                        <th class="py-3 text-dark font-weight-bold" style="font-size: 0.9rem; border: none;">Line Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                    <tr class="border-top">
                                        <td class="py-3 font-weight-bold text-dark" style="font-size: 0.95rem; text-align: center;">
                                            {{ $item->product_name }}
                                        </td>
                                        <td class="py-3 text-dark" style="font-size: 0.95rem;">
                                            ₹{{ number_format($item->price, 2) }}
                                        </td>
                                        <td class="py-3 text-dark font-weight-bold" style="font-size: 0.95rem;">
                                            &times;{{ $item->qty }}
                                        </td>
                                        <td class="py-3 font-weight-bold text-dark" style="font-size: 0.95rem;">
                                            ₹{{ number_format($item->total, 2) }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Final Calculation Sheet -->
                        <div class="row justify-content-end">
                            <div class="col-md-5">
                                <div class="bg-light p-3 rounded" style="border-radius: 12px !important; border: 1px solid #f1eeee;">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted small font-weight-bold">Subtotal</span>
                                        <span class="text-dark font-weight-bold">₹{{ number_format($order->subtotal, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted small font-weight-bold">Flat Rate Shipping</span>
                                        <span class="text-dark font-weight-bold">₹15.00</span>
                                    </div>
                                    <hr class="my-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-dark font-weight-bold" style="font-size: 1rem;">Invoice Total</span>
                                        <span class="font-weight-bold text-pink" style="font-size: 1.25rem; color: #ff7c8b;">₹{{ number_format($order->total, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- invoice printing wrapper end -->

    <!-- Custom CSS Stylesheets -->
    <style>
        .text-pink {
            color: #ff7c8b !important;
        }
        .bg-soft-green {
            background-color: rgba(40, 167, 69, 0.1) !important;
        }
        
        /* Pulse & bouncing animations for success */
        @keyframes bounce-custom {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }
        .animate-bounce {
            animation: bounce-custom 2s infinite ease-in-out;
        }
        
        .button-pink-gradient {
            background: linear-gradient(135deg, #ff7c8b 0%, #ff5270 100%) !important;
        }
        .button-pink-gradient:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 15px rgba(255, 82, 112, 0.25) !important;
        }
        .shadow-pink {
            box-shadow: 0 4px 15px rgba(255, 124, 139, 0.15);
        }

        /* Border right styles for metadata column display */
        @media (min-width: 576px) {
            .border-sm-right {
                border-right: 1px solid #e9ecef;
            }
        }
        
        /* Print Overrides */
        @media print {
            body * {
                visibility: hidden;
            }
            #printable-area, #printable-area * {
                visibility: visible;
            }
            #printable-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                background-color: #ffffff !important;
                padding: 0 !important;
            }
            .print-hide {
                display: none !important;
            }
            .border, .rounded {
                border-radius: 0 !important;
                border: none !important;
                box-shadow: none !important;
            }
            .bg-light {
                background-color: #f8f9fa !important;
            }
        }
    </style>

@endsection
