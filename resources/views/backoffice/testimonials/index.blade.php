@extends('backoffice.master_layout')

@section('title', 'Manage Testimonials & Client Reviews')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px;">
            <i class="bx bx-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 text-dark fw-bold">Customer Testimonials & Reviews</h4>
            <span class="text-muted small">Manage real client reviews and ratings displayed on the homepage</span>
        </div>
        <a href="{{ route('testimonials.create') }}" class="btn btn-primary px-4 py-2" style="border-radius: 10px; font-weight: 600;">
            <i class="bx bx-plus me-1"></i> Add New Review
        </a>
    </div>

    <div class="card border-0" style="border-radius: 16px; box-shadow: 0 8px 26px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.05);">
        <div class="card-header border-bottom py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-dark fw-bold">All Client Testimonials</h5>
            <span class="badge bg-label-primary px-3 py-2 fw-semibold" style="border-radius: 6px;">Total: {{ $testimonials->total() }} Reviews</span>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="font-weight: 700; color: #566a7f;">Client</th>
                        <th style="font-weight: 700; color: #566a7f;">Review Quote</th>
                        <th style="font-weight: 700; color: #566a7f;">Rating</th>
                        <th style="font-weight: 700; color: #566a7f;">Order</th>
                        <th style="font-weight: 700; color: #566a7f;">Status</th>
                        <th style="font-weight: 700; color: #566a7f; text-align: right; padding-right: 24px;">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($testimonials as $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if ($item->photo)
                                        <img src="{{ asset($item->photo) }}" alt="{{ $item->name }}" class="rounded-circle me-3 border" style="width: 45px; height: 45px; object-fit: cover;">
                                    @else
                                        <div class="rounded-circle bg-label-primary d-flex align-items-center justify-content-center me-3 fw-bold" style="width: 45px; height: 45px;">
                                            {{ strtoupper(substr($item->name, 0, 2)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <strong class="text-dark fw-semibold d-block">{{ $item->name }}</strong>
                                        <small class="text-muted">{{ $item->designation ?? 'Customer' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td style="max-width: 320px; white-space: normal;">
                                <p class="mb-0 text-muted small" style="line-height: 1.4;">"{{ Str::limit($item->review_text, 120) }}"</p>
                            </td>
                            <td>
                                <div class="text-warning">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $item->rating)
                                            <i class="bx bxs-star"></i>
                                        @else
                                            <i class="bx bx-star text-muted"></i>
                                        @endif
                                    @endfor
                                    <span class="text-dark fw-bold ms-1 small">({{ $item->rating }}.0)</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-label-secondary px-2 py-1">{{ $item->sort_order }}</span>
                            </td>
                            <td>
                                @if ($item->status == 1)
                                    <span class="badge bg-label-success px-3 py-2 fw-semibold" style="border-radius: 6px;"><i class="bx bx-check me-1"></i> Active</span>
                                @else
                                    <span class="badge bg-label-secondary px-3 py-2 fw-semibold" style="border-radius: 6px;"><i class="bx bx-x me-1"></i> Hidden</span>
                                @endif
                            </td>
                            <td style="text-align: right; padding-right: 24px;">
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ route('testimonials.edit', $item->id) }}" class="btn btn-sm btn-icon btn-outline-primary" style="border-radius: 8px;" title="Edit Review">
                                        <i class="bx bx-edit"></i>
                                    </a>
                                    <form action="{{ route('testimonials.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this testimonial?')" style="margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-icon btn-outline-danger" style="border-radius: 8px;" title="Delete Review">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bx bx-message-rounded-dots text-muted d-block mb-3" style="font-size: 48px;"></i>
                                <span class="text-muted">No Testimonials / Reviews Added Yet. Click "Add New Review" to add one!</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($testimonials->hasPages())
            <div class="card-footer border-top py-3">
                {{ $testimonials->links() }}
            </div>
        @endif
    </div>
</div>
@endsection