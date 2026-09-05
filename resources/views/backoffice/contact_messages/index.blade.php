@extends('backoffice.master_layout')

@section('title', 'Customer Inquiries & Messages')

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
            <h4 class="mb-0 text-dark fw-bold">Customer Contact Inquiries</h4>
            <span class="text-muted small">Messages received via the frontend Contact Us page</span>
        </div>
        <div>
            @if ($unreadCount > 0)
                <span class="badge bg-danger px-3 py-2 fw-semibold" style="border-radius: 8px;">
                    <i class="bx bx-envelope me-1"></i> {{ $unreadCount }} Unread {{ Str::plural('Inquiry', $unreadCount) }}
                </span>
            @else
                <span class="badge bg-label-success px-3 py-2 fw-semibold" style="border-radius: 8px;">
                    <i class="bx bx-check-double me-1"></i> All Messages Read
                </span>
            @endif
        </div>
    </div>

    <div class="card border-0" style="border-radius: 16px; box-shadow: 0 8px 26px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.05);">
        <div class="card-header border-bottom py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-dark fw-bold">Inbox</h5>
            <span class="badge bg-label-primary px-3 py-2 fw-semibold" style="border-radius: 6px;">Total: {{ $messages->total() }}</span>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="font-weight: 700; color: #566a7f;">Status</th>
                        <th style="font-weight: 700; color: #566a7f;">Sender Details</th>
                        <th style="font-weight: 700; color: #566a7f;">Subject</th>
                        <th style="font-weight: 700; color: #566a7f;">Message Preview</th>
                        <th style="font-weight: 700; color: #566a7f;">Received At</th>
                        <th style="font-weight: 700; color: #566a7f; text-align: right; padding-right: 24px;">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($messages as $msg)
                        <tr class="{{ !$msg->is_read ? 'table-warning bg-opacity-10 fw-bold' : '' }}">
                            <td>
                                @if (!$msg->is_read)
                                    <span class="badge bg-danger px-2 py-1"><i class="bx bxs-envelope me-1"></i> New</span>
                                @else
                                    <span class="badge bg-label-secondary px-2 py-1"><i class="bx bx-envelope-open me-1"></i> Read</span>
                                @endif
                            </td>
                            <td>
                                <strong class="text-dark d-block">{{ $msg->name }}</strong>
                                <small class="text-muted d-block"><i class="bx bx-envelope me-1"></i>{{ $msg->email }}</small>
                                @if($msg->phone)
                                    <small class="text-muted d-block"><i class="bx bx-phone me-1"></i>{{ $msg->phone }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="text-dark">{{ $msg->subject ?: 'General Inquiry' }}</span>
                            </td>
                            <td style="max-width: 280px; white-space: normal;">
                                <p class="mb-0 text-muted small" style="line-height: 1.4;">{{ Str::limit($msg->message, 80) }}</p>
                            </td>
                            <td>
                                <small class="text-muted">{{ $msg->created_at->format('M d, Y h:i A') }}</small>
                                <br><small class="text-muted small">({{ $msg->created_at->diffForHumans() }})</small>
                            </td>
                            <td style="text-align: right; padding-right: 24px;">
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ route('contact-messages.show', $msg->id) }}" class="btn btn-sm btn-icon btn-outline-primary" style="border-radius: 8px;" title="View Message">
                                        <i class="bx bx-show"></i>
                                    </a>
                                    <a href="mailto:{{ $msg->email }}?subject=Re: {{ rawurlencode($msg->subject ?? 'Inquiry at Amar Nath Hampers') }}" class="btn btn-sm btn-icon btn-outline-success" style="border-radius: 8px;" title="Reply via Email">
                                        <i class="bx bx-reply"></i>
                                    </a>
                                    <form action="{{ route('contact-messages.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('Delete this inquiry?')" style="margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-icon btn-outline-danger" style="border-radius: 8px;" title="Delete Message">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bx bx-envelope-open text-muted d-block mb-3" style="font-size: 48px;"></i>
                                <span class="text-muted">No Inquiries or Messages Received Yet.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($messages->hasPages())
            <div class="card-footer border-top py-3">
                {{ $messages->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
