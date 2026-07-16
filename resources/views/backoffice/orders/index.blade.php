@extends('backoffice.master_layout')

@section('title', 'Order Log')

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
            <h4 class="mb-0 text-dark fw-bold">Customer Orders</h4>
            <span class="text-muted small">Manage placed orders, review purchase receipts, and update order statuses</span>
        </div>
    </div>

    <!-- Status Tabs Nav -->
    <div class="card mb-6 border-0" style="border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.05);">
        <div class="card-body p-2">
            <ul class="nav nav-pills flex-column flex-sm-row gap-1">
                <li class="nav-item">
                    <a class="nav-link flex-sm-fill text-center {{ $status === 'all' ? 'active' : '' }}" href="{{ route('orders.index', ['status' => 'all']) }}" style="border-radius: 10px; font-weight: 600;">
                        <i class="bx bx-list-ul me-1"></i> All Orders 
                        <span class="badge bg-white text-dark ms-1" style="font-size: 10px;">{{ $counts['all'] }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link flex-sm-fill text-center text-warning {{ $status === 'pending' ? 'active bg-warning text-white' : '' }}" href="{{ route('orders.index', ['status' => 'pending']) }}" style="border-radius: 10px; font-weight: 600;">
                        <i class="bx bx-time me-1"></i> Pending
                        <span class="badge bg-white text-warning ms-1" style="font-size: 10px;">{{ $counts['pending'] }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link flex-sm-fill text-center text-info {{ $status === 'processing' ? 'active bg-info text-white' : '' }}" href="{{ route('orders.index', ['status' => 'processing']) }}" style="border-radius: 10px; font-weight: 600;">
                        <i class="bx bx-loader me-1"></i> Processing
                        <span class="badge bg-white text-info ms-1" style="font-size: 10px;">{{ $counts['processing'] }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link flex-sm-fill text-center text-success {{ $status === 'completed' ? 'active bg-success text-white' : '' }}" href="{{ route('orders.index', ['status' => 'completed']) }}" style="border-radius: 10px; font-weight: 600;">
                        <i class="bx bx-check-double me-1"></i> Completed
                        <span class="badge bg-white text-success ms-1" style="font-size: 10px;">{{ $counts['completed'] }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link flex-sm-fill text-center text-danger {{ $status === 'cancelled' ? 'active bg-danger text-white' : '' }}" href="{{ route('orders.index', ['status' => 'cancelled']) }}" style="border-radius: 10px; font-weight: 600;">
                        <i class="bx bx-block me-1"></i> Cancelled
                        <span class="badge bg-white text-danger ms-1" style="font-size: 10px;">{{ $counts['cancelled'] }}</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Orders Table Card -->
    <div class="card border-0" style="border-radius: 16px; box-shadow: 0 8px 26px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.05);">
        <div class="card-header border-bottom py-4">
            <h5 class="mb-0 text-dark fw-bold">Recent Invoices</h5>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="font-weight: 700; color: #566a7f;">Order ID</th>
                        <th style="font-weight: 700; color: #566a7f;">Customer</th>
                        <th style="font-weight: 700; color: #566a7f;">Contact</th>
                        <th style="font-weight: 700; color: #566a7f;">City</th>
                        <th style="font-weight: 700; color: #566a7f;">Grand Total</th>
                        <th style="font-weight: 700; color: #566a7f;">Date Placed</th>
                        <th style="font-weight: 700; color: #566a7f;">Status</th>
                        <th style="font-weight: 700; color: #566a7f; text-align: right; padding-right: 24px;">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($orders as $ord)
                        <tr>
                            <td>
                                <a href="{{ route('orders.show', $ord->id) }}" class="text-primary fw-bold">
                                    {{ $ord->order_number }}
                                </a>
                            </td>
                            <td><strong class="text-dark fw-semibold">{{ $ord->name }}</strong></td>
                            <td>
                                <span class="d-block small text-dark"><i class="bx bx-phone me-1 small"></i>{{ $ord->phone }}</span>
                                <span class="d-block small text-muted"><i class="bx bx-envelope me-1 small"></i>{{ $ord->email }}</span>
                            </td>
                            <td><span class="badge bg-label-secondary px-3 py-2 fw-semibold" style="border-radius: 6px;">{{ $ord->city }}</span></td>
                            <td><strong class="text-success">₹{{ number_format($ord->total, 2) }}</strong></td>
                            <td><span class="text-muted small">{{ $ord->created_at->format('M d, Y h:i A') }}</span></td>
                            <td>
                                @if ($ord->status === 'pending')
                                    <span class="badge bg-label-warning px-3 py-2 fw-semibold" style="border-radius: 6px;"><i class="bx bx-time me-1"></i> Pending</span>
                                @elseif ($ord->status === 'processing')
                                    <span class="badge bg-label-info px-3 py-2 fw-semibold" style="border-radius: 6px;"><i class="bx bx-loader me-1"></i> Processing</span>
                                @elseif ($ord->status === 'completed')
                                    <span class="badge bg-label-success px-3 py-2 fw-semibold" style="border-radius: 6px;"><i class="bx bx-check-double me-1"></i> Completed</span>
                                @else
                                    <span class="badge bg-label-danger px-3 py-2 fw-semibold" style="border-radius: 6px;"><i class="bx bx-block me-1"></i> Cancelled</span>
                                @endif
                            </td>
                            <td style="text-align: right; padding-right: 24px;">
                                <a href="{{ route('orders.show', $ord->id) }}" class="btn btn-sm btn-icon btn-outline-primary" style="border-radius: 8px;" title="View Details">
                                    <i class="bx bx-show"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="bx bx-receipt text-muted d-block mb-3" style="font-size: 48px;"></i>
                                <span class="text-muted">No Orders Registered.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
