@extends('backoffice.master_layout')

@section('title', 'Product Manager')

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
            <h4 class="mb-0 text-dark fw-bold">Products Management</h4>
            <span class="text-muted small">Manage all your hampers and standard products here</span>
        </div>
        <a href="{{ route('products.create') }}" class="btn btn-primary px-4 py-2" style="border-radius: 10px; font-weight: 600;">
            <i class="bx bx-plus me-1"></i> Add Product
        </a>
    </div>

    <!-- Products Card -->
    <div class="card border-0" style="border-radius: 16px; box-shadow: 0 8px 26px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.05);">
        <div class="card-header border-bottom py-4">
            <h5 class="mb-0 text-dark fw-bold">All Products & Hampers</h5>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="font-weight: 700; color: #566a7f;">Thumbnail</th>
                        <th style="font-weight: 700; color: #566a7f;">Product Name</th>
                        <th style="font-weight: 700; color: #566a7f;">Category</th>
                        <th style="font-weight: 700; color: #566a7f;">Price</th>
                        <th style="font-weight: 700; color: #566a7f;">Stock</th>
                        <th style="font-weight: 700; color: #566a7f;">Status</th>
                        <th style="font-weight: 700; color: #566a7f;">Featured</th>
                        <th style="font-weight: 700; color: #566a7f; text-align: right; padding-right: 24px;">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($products as $prod)
                        <tr>
                            <td>
                                @if ($prod->image)
                                    <img src="{{ asset($prod->image) }}" alt="product thumbnail" style="width: 48px; height: 48px; object-fit: cover; border-radius: 8px; border: 1px solid rgba(0,0,0,0.08);">
                                @else
                                    <div class="bg-label-secondary d-flex justify-content-center align-items-center" style="width: 48px; height: 48px; border-radius: 8px;">
                                        <i class="bx bx-image text-muted" style="font-size: 24px;"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong class="text-dark fw-semibold d-block" style="font-size: 14px;">{{ $prod->name }}</strong>
                                <small class="text-muted">Slug: <code>{{ $prod->slug }}</code></small>
                            </td>
                            <td>
                                <span class="badge bg-label-primary px-3 py-2 fw-semibold" style="border-radius: 6px;">
                                    {{ $prod->category?->name ?: 'Unassigned' }}
                                </span>
                            </td>
                            <td>
                                <strong class="text-dark">₹{{ number_format($prod->price, 2) }}</strong>
                                @if ($prod->compare_at_price)
                                    <del class="text-muted ms-1 small">₹{{ number_format($prod->compare_at_price, 2) }}</del>
                                @endif
                            </td>
                            <td>
                                @if ($prod->stock > 5)
                                    <span class="badge bg-label-info px-3 py-2 fw-semibold" style="border-radius: 6px;">{{ $prod->stock }} in stock</span>
                                @elseif ($prod->stock > 0)
                                    <span class="badge bg-label-warning px-3 py-2 fw-semibold" style="border-radius: 6px;">Only {{ $prod->stock }} left</span>
                                @else
                                    <span class="badge bg-label-danger px-3 py-2 fw-semibold" style="border-radius: 6px;">Out of Stock</span>
                                @endif
                            </td>
                            <td>
                                @if ($prod->status == 1)
                                    <span class="badge bg-label-success px-3 py-2 fw-semibold" style="border-radius: 6px;"><i class="bx bx-check me-1"></i> Active</span>
                                @else
                                    <span class="badge bg-label-danger px-3 py-2 fw-semibold" style="border-radius: 6px;"><i class="bx bx-x me-1"></i> Inactive</span>
                                @endif
                            </td>
                            <td>
                                @if ($prod->is_featured == 1)
                                    <span class="badge bg-label-warning px-3 py-2 fw-semibold" style="border-radius: 6px;"><i class="bx bxs-star me-1"></i> Featured</span>
                                @else
                                    <span class="text-muted small">No</span>
                                @endif
                            </td>
                            <td style="text-align: right; padding-right: 24px;">
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ route('products.edit', $prod->id) }}" class="btn btn-sm btn-icon btn-outline-primary" style="border-radius: 8px;" title="Edit Product">
                                        <i class="bx bx-edit"></i>
                                    </a>
                                    <form action="{{ route('products.destroy', $prod->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product? This action cannot be undone.')" style="margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-icon btn-outline-danger" style="border-radius: 8px;" title="Delete Product">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="bx bx-package text-muted d-block mb-3" style="font-size: 48px;"></i>
                                <span class="text-muted">No Products Found. Let's create your first product hamper!</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
