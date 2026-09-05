@extends('backoffice.master_layout')

@section('title', 'View Customer Inquiry')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 text-dark fw-bold">Customer Inquiry Details</h4>
            <span class="text-muted small">Received on {{ $contact_message->created_at->format('F d, Y \a\t h:i A') }}</span>
        </div>
        <a href="{{ route('contact-messages.index') }}" class="btn btn-outline-secondary px-4 py-2" style="border-radius: 10px; font-weight: 600;">
            <i class="bx bx-arrow-back me-1"></i> Back to Inbox
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px;">
            <i class="bx bx-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 mb-4" style="border-radius: 16px; box-shadow: 0 8px 26px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.05);">
                <div class="card-header border-bottom py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-dark fw-bold">
                        Subject: {{ $contact_message->subject ?: 'General Inquiry / Bespoke Hampers' }}
                    </h5>
                    <span class="badge bg-label-success px-3 py-2 fw-semibold" style="border-radius: 6px;">
                        <i class="bx bx-check me-1"></i> Read
                    </span>
                </div>
                <div class="card-body p-4">
                    <h6 class="text-dark fw-bold mb-3">Message Content:</h6>
                    <div class="p-4 bg-light rounded-3 border mb-4" style="white-space: pre-wrap; font-size: 15px; line-height: 1.6; color: #333;">{{ $contact_message->message }}</div>

                    <div class="d-flex gap-2">
                        <a href="mailto:{{ $contact_message->email }}?subject=Re: {{ rawurlencode($contact_message->subject ?? 'Inquiry at Amar Nath Hampers') }}" class="btn btn-primary px-4 py-2" style="border-radius: 8px; font-weight: 600;">
                            <i class="bx bx-reply me-1"></i> Reply via Email
                        </a>
                        @if($contact_message->phone)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contact_message->phone) }}" target="_blank" class="btn btn-success px-4 py-2" style="border-radius: 8px; font-weight: 600;">
                                <i class="bx bxl-whatsapp me-1"></i> Chat on WhatsApp
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 mb-4" style="border-radius: 16px; box-shadow: 0 8px 26px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.05);">
                <div class="card-header border-bottom py-3">
                    <h5 class="mb-0 text-dark fw-bold">Sender Information</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="text-muted small d-block">Full Name</label>
                        <strong class="text-dark fs-6">{{ $contact_message->name }}</strong>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted small d-block">Email Address</label>
                        <a href="mailto:{{ $contact_message->email }}" class="text-primary fw-semibold">{{ $contact_message->email }}</a>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted small d-block">Phone Number</label>
                        @if ($contact_message->phone)
                            <a href="tel:{{ $contact_message->phone }}" class="text-dark fw-semibold">{{ $contact_message->phone }}</a>
                        @else
                            <span class="text-muted">Not provided</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="text-muted small d-block">Submitted At</label>
                        <span class="text-dark">{{ $contact_message->created_at->format('M d, Y - h:i A') }}</span>
                    </div>

                    <hr class="my-3">

                    <div class="d-flex justify-content-between align-items-center">
                        <form action="{{ route('contact-messages.toggle-read', $contact_message->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-secondary" style="border-radius: 6px;">
                                <i class="bx bx-envelope me-1"></i> Mark as Unread
                            </button>
                        </form>

                        <form action="{{ route('contact-messages.destroy', $contact_message->id) }}" method="POST" onsubmit="return confirm('Delete this inquiry?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" style="border-radius: 6px;">
                                <i class="bx bx-trash me-1"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
