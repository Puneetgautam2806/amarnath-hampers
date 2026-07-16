@extends('backoffice.master_layout')

@section('title', 'Order Details')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px;">
            <i class="bx bx-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h4 class="mb-0 text-dark fw-bold">Order Details: {{ $order->order_number }}</h4>
            <span class="text-muted small">Placed on {{ $order->created_at->format('M d, Y \a\t h:i A') }}</span>
        </div>
        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary px-4 py-2" style="border-radius: 10px; font-weight: 600;">
            <i class="bx bx-arrow-back me-1"></i> Back to Orders
        </a>
    </div>

    <div class="row">
        <!-- Left Side: Order items list & Customer details -->
        <div class="col-lg-8">
            <!-- Purchased Items Card -->
            <div class="card mb-6 border-0" style="border-radius: 16px; box-shadow: 0 8px 26px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.05);">
                <div class="card-header border-bottom py-4">
                    <h5 class="mb-0 text-dark fw-bold">Purchased Items</h5>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="font-weight: 700; color: #566a7f;">Item Thumbnail</th>
                                <th style="font-weight: 700; color: #566a7f;">Product/Hamper</th>
                                <th style="font-weight: 700; color: #566a7f;">Unit Price</th>
                                <th style="font-weight: 700; color: #566a7f;">Quantity</th>
                                <th style="font-weight: 700; color: #566a7f; text-align: right; padding-right: 24px;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $item)
                                <tr>
                                    <td>
                                        @if ($item->product && $item->product->image)
                                            <img src="{{ asset($item->product->image) }}" alt="item thumbnail" style="width: 48px; height: 48px; object-fit: cover; border-radius: 8px; border: 1px solid rgba(0,0,0,0.08);">
                                        @else
                                            <div class="bg-label-secondary d-flex justify-content-center align-items-center" style="width: 48px; height: 48px; border-radius: 8px;">
                                                <i class="bx bx-image text-muted" style="font-size: 24px;"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <strong class="text-dark d-block fw-semibold">{{ $item->product_name }}</strong>
                                        @if ($item->product)
                                            <small class="text-muted">Category: {{ $item->product->category?->name ?: 'Standard' }}</small>
                                        @endif
                                    </td>
                                    <td><strong class="text-dark">₹{{ number_format($item->price, 2) }}</strong></td>
                                    <td><span class="badge bg-label-secondary px-3 py-2 fw-bold" style="border-radius: 6px;">{{ $item->qty }}x</span></td>
                                    <td style="text-align: right; padding-right: 24px;"><strong class="text-dark">₹{{ number_format($item->total, 2) }}</strong></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Totals Section -->
                <div class="card-footer border-top py-4 bg-light bg-opacity-10">
                    <div class="row justify-content-end">
                        <div class="col-md-5 col-sm-8 text-nowrap">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted fw-semibold">Subtotal:</span>
                                <strong class="text-dark">₹{{ number_format($order->subtotal, 2) }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted fw-semibold">Shipping/Delivery:</span>
                                <strong class="text-dark">₹{{ number_format($order->shipping, 2) }}</strong>
                            </div>
                            <hr class="my-2">
                            <div class="d-flex justify-content-between">
                                <span class="text-dark fw-bold" style="font-size: 16px;">Grand Total:</span>
                                <strong class="text-success" style="font-size: 18px;">₹{{ number_format($order->total, 2) }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shipping & Delivery Address Card -->
            <div class="card mb-6 border-0" style="border-radius: 16px; box-shadow: 0 8px 26px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.05);">
                <div class="card-header border-bottom py-4">
                    <h5 class="mb-0 text-dark fw-bold"><i class="bx bx-map me-1 text-primary"></i> Shipping Information</h5>
                </div>
                <div class="card-body pt-6">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <span class="text-muted small d-block mb-1">Customer Name</span>
                            <strong class="text-dark" style="font-size: 15px;">{{ $order->name }}</strong>
                        </div>
                        <div class="col-md-6 mb-4">
                            <span class="text-muted small d-block mb-1">City</span>
                            <span class="badge bg-label-secondary px-3 py-2 fw-semibold" style="border-radius: 6px;">{{ $order->city }}</span>
                        </div>
                    </div>
                    <div class="mb-4">
                        <span class="text-muted small d-block mb-1">Delivery Address</span>
                        <p class="text-dark mb-0 bg-light p-3" style="border-radius: 8px; border: 1px solid rgba(0,0,0,0.04); font-size: 14px; line-height: 1.5;">{{ $order->address }}</p>
                    </div>
                    @if ($order->order_note)
                        <div>
                            <span class="text-muted small d-block mb-1">Order Notes / Instructions</span>
                            <p class="text-dark mb-0 bg-light p-3" style="border-radius: 8px; border: 1px solid rgba(0,0,0,0.04); font-size: 14px; line-height: 1.5; font-style: italic;">{{ $order->order_note }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Side: Order Status Action & Customer Contacts -->
        <div class="col-lg-4">
            <!-- Order status manager card -->
            <div class="card mb-6 border-0" style="border-radius: 16px; box-shadow: 0 8px 26px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.05);">
                <div class="card-header border-bottom py-4">
                    <h5 class="mb-0 text-dark fw-bold">Order Action</h5>
                </div>
                <div class="card-body pt-6">
                    <span class="text-muted small d-block mb-1">Current Status</span>
                    <div class="mb-4">
                        @if ($order->status === 'pending')
                            <span class="badge bg-label-warning px-4 py-2 fw-bold" style="border-radius: 6px; font-size: 13px;"><i class="bx bx-time me-1"></i> Pending Payment / Review</span>
                        @elseif ($order->status === 'processing')
                            <span class="badge bg-label-info px-4 py-2 fw-bold" style="border-radius: 6px; font-size: 13px;"><i class="bx bx-loader me-1"></i> Packing / Processing</span>
                        @elseif ($order->status === 'completed')
                            <span class="badge bg-label-success px-4 py-2 fw-bold" style="border-radius: 6px; font-size: 13px;"><i class="bx bx-check-double me-1"></i> Delivered & Completed</span>
                        @else
                            <span class="badge bg-label-danger px-4 py-2 fw-bold" style="border-radius: 6px; font-size: 13px;"><i class="bx bx-block me-1"></i> Cancelled</span>
                        @endif
                    </div>

                    <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label text-dark fw-semibold">Update Status</label>
                            <select name="status" class="form-select" style="border-radius: 8px; padding: 10px 14px;">
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold" style="border-radius: 10px;">
                            <i class="bx bx-sync me-1"></i> Update Status
                        </button>
                    </form>
                </div>
            </div>

            <!-- Customer Details Card -->
            <div class="card border-0" style="border-radius: 16px; box-shadow: 0 8px 26px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.05);">
                <div class="card-header border-bottom py-4">
                    <h5 class="mb-0 text-dark fw-bold">Customer Profile</h5>
                </div>
                <div class="card-body pt-6">
                    <div class="mb-4">
                        <span class="text-muted small d-block mb-1">Full Name</span>
                        <strong class="text-dark" style="font-size: 15px;">{{ $order->name }}</strong>
                    </div>
                    <div class="mb-4">
                        <span class="text-muted small d-block mb-1">Email Address</span>
                        <a href="mailto:{{ $order->email }}" class="text-primary fw-semibold"><i class="bx bx-envelope me-1"></i>{{ $order->email }}</a>
                    </div>
                    <div>
                        <span class="text-muted small d-block mb-1">Phone Number</span>
                        <a href="tel:{{ $order->phone }}" class="text-dark fw-bold"><i class="bx bx-phone me-1 text-muted"></i>{{ $order->phone }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
