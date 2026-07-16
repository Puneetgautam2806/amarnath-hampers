@extends('backoffice.master_layout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Store Management /</span> Stock Management</h4>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Product Inventory</h5>
            
            <form action="{{ route('stock.index') }}" method="GET" class="d-flex" style="width: 300px;">
                <input type="text" name="search" class="form-control me-2" placeholder="Search products..." value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit"><i class="bx bx-search"></i></button>
            </form>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Current Stock</th>
                        <th>Status</th>
                        <th>Quick Update</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse($products as $product)
                    <tr>
                        <td>#{{ $product->id }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($product->image)
                                <img src="{{ asset($product->image) }}" alt="Product Image" class="rounded me-3" style="width: 40px; height: 40px; object-fit: cover;">
                                @else
                                <div class="rounded me-3 bg-light d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="bx bx-image text-muted"></i>
                                </div>
                                @endif
                                <strong>{{ $product->name }}</strong>
                            </div>
                        </td>
                        <td>
                            @if($product->stock <= 0)
                                <span class="badge bg-label-danger me-1">Out of Stock ({{ $product->stock }})</span>
                            @elseif($product->stock <= 5)
                                <span class="badge bg-label-warning me-1">Low Stock ({{ $product->stock }})</span>
                            @else
                                <span class="badge bg-label-success me-1">{{ $product->stock }} in stock</span>
                            @endif
                        </td>
                        <td>
                            @if($product->status == 1)
                                <span class="badge bg-label-success">Active</span>
                            @else
                                <span class="badge bg-label-danger">Draft</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('stock.update', $product->id) }}" method="POST" class="d-flex align-items-center">
                                @csrf
                                @method('PUT')
                                <input type="number" name="stock" value="{{ $product->stock }}" class="form-control form-control-sm me-2" style="width: 80px;" min="0" required>
                                <button type="submit" class="btn btn-sm btn-outline-primary">Update</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">No products found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="card-footer d-flex justify-content-center">
            {{ $products->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
