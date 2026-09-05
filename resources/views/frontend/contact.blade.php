@extends('frontend.layouts.app')

@section('content')

    <!-- site-breadcrumb -->
    <div class="site-breadcrumb">
        <div class="site-breadcrumb-bg" style="background: url({{ asset('frontend/assets/img/banner/breadcrumb.jpg') }}) center center/cover no-repeat;"></div>
        <div class="container">
            <div class="site-breadcrumb-wrap">
                <h4 class="breadcrumb-title">Contact Us</h4>
                <ul class="breadcrumb-menu">
                    <li><a href="{{ route('home') }}"><i class="fas fa-home"></i> Home</a></li>
                    <li class="active">Contact Us</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- site-breadcrumb end -->


    <!-- contact area -->
    <div class="contact-area py-100">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show p-4 mb-5 shadow-sm" role="alert" style="border-radius: 12px; font-size: 16px;">
                    <i class="fas fa-check-circle me-2 fs-5"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show p-4 mb-5 shadow-sm" role="alert" style="border-radius: 12px;">
                    <h5 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i> Please fix the following errors:</h5>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="contact-wrapper">
                <div class="row g-4">
                    <div class="col-lg-5">
                        <div class="contact-content p-4 p-md-5 bg-light rounded-4 h-100 shadow-sm border">
                            <div class="contact-info-wrap">
                                <div class="site-heading mb-4">
                                    <span class="site-title-tagline">Get In Touch</span>
                                    <h2 class="site-title">Have Questions For <span>Bespoke Gifting</span>?</h2>
                                    <p class="text-muted mt-2">
                                        We would love to assist you with custom wedding hampers, ring ceremony platters, trousseau packing, and bulk corporate orders.
                                    </p>
                                </div>

                                <div class="contact-info">
                                    <div class="contact-info-icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div class="contact-info-content">
                                        <h5>Studio & Store Location</h5>
                                        <p>{{ $settings?->address ?: 'Kinari Bazar, Agra, Uttar Pradesh, India' }}</p>
                                    </div>
                                </div>

                                <div class="contact-info">
                                    <div class="contact-info-icon">
                                        <i class="fas fa-phone-alt"></i>
                                    </div>
                                    <div class="contact-info-content">
                                        <h5>Call Us Directly</h5>
                                        <p><a href="tel:{{ $settings?->phone ?: '+91 98765 43210' }}">{{ $settings?->phone ?: '+91 98765 43210' }}</a></p>
                                    </div>
                                </div>

                                @if($settings?->whatsapp)
                                    <div class="contact-info">
                                        <div class="contact-info-icon" style="background-color: #25d366; color: white;">
                                            <i class="fab fa-whatsapp"></i>
                                        </div>
                                        <div class="contact-info-content">
                                            <h5>WhatsApp Gifting Concierge</h5>
                                            <p><a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->whatsapp) }}" target="_blank" class="text-success fw-bold">Chat on WhatsApp</a></p>
                                        </div>
                                    </div>
                                @endif

                                <div class="contact-info">
                                    <div class="contact-info-icon">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div class="contact-info-content">
                                        <h5>Email Address</h5>
                                        <p><a href="mailto:{{ $settings?->email ?: 'contact@amarnathhampers.com' }}">{{ $settings?->email ?: 'contact@amarnathhampers.com' }}</a></p>
                                    </div>
                                </div>

                                <div class="contact-info">
                                    <div class="contact-info-icon">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div class="contact-info-content">
                                        <h5>Visiting Hours</h5>
                                        <p>{{ $settings?->working_hours ?: 'Monday - Saturday: 10:00 AM - 08:30 PM (Sunday Closed)' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <div class="contact-form p-4 p-md-5 bg-white rounded-4 shadow-sm border">
                            <div class="contact-form-header mb-4">
                                <h3>Send Us A <span>Message</span></h3>
                                <p class="text-muted">Fill out the form below and our team will get in touch with you shortly.</p>
                            </div>
                            <form action="{{ route('contact.submit') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label class="form-label fw-semibold text-dark">Your Name *</label>
                                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="e.g. Rahul Sharma" required style="border-radius: 10px; padding: 12px 16px;">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label class="form-label fw-semibold text-dark">Your Email *</label>
                                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="e.g. rahul@example.com" required style="border-radius: 10px; padding: 12px 16px;">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label class="form-label fw-semibold text-dark">Phone / WhatsApp Number</label>
                                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="e.g. +91 9876543210" style="border-radius: 10px; padding: 12px 16px;">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label class="form-label fw-semibold text-dark">Subject / Inquiry Type</label>
                                            <input type="text" name="subject" class="form-control" value="{{ old('subject') }}" placeholder="e.g. Wedding Trousseau Packaging / Ring Platter" style="border-radius: 10px; padding: 12px 16px;">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <label class="form-label fw-semibold text-dark">Your Message / Requirement Details *</label>
                                    <textarea name="message" class="form-control" rows="5" placeholder="Tell us about your event date, required quantities, hamper theme, or budget..." required style="border-radius: 10px; padding: 14px 16px;">{{ old('message') }}</textarea>
                                </div>
                                <button type="submit" class="theme-btn w-100 py-3" style="font-size: 16px; font-weight: 700; border-radius: 10px;">
                                    Send Message <i class="fas fa-paper-plane ms-2"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- contact area end -->


    <!-- map area -->
    <div class="contact-map mb-0">
        @if (!empty($settings?->map_embed_url) && Str::startsWith($settings->map_embed_url, 'http'))
            <iframe src="{{ $settings->map_embed_url }}" style="border:0; width: 100%; height: 420px;" allowfullscreen="" loading="lazy"></iframe>
        @elseif (!empty($settings?->map_embed_url) && Str::contains($settings->map_embed_url, '<iframe'))
            {!! $settings->map_embed_url !!}
        @else
            <!-- Default Agra Map embed -->
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d113579.78749147572!2d77.90997194723049!3d27.176670116666838!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39740d857c2f41d9%3A0x784aef38a9523b42!2sAgra%2C%20Uttar%20Pradesh!5e0!3m2!1sen!2sin!4v1714000000000!5m2!1sen!2sin" style="border:0; width: 100%; height: 420px;" allowfullscreen="" loading="lazy"></iframe>
        @endif
    </div>
    <!-- map area end -->

@endsection
