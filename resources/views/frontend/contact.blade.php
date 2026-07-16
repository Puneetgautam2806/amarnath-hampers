@extends('frontend.layouts.app')
@section('content')
<div class='container my-5'>
  <div class='row'>
    <div class='col-12 text-center mb-5'>
      <h1 class="site-title">Contact <span>Us</span></h1>
      <p class="text-muted">We would love to hear from you for your bespoke gifting needs.</p>
    </div>
  </div>
  <div class='row g-4'>
    <div class='col-md-6'>
      <div class="p-4 bg-light rounded shadow-sm h-100">
          <h4>Our Studio</h4>
          <hr>
          <p><strong>Amar Nath Hampers & Materials</strong></p>
          <p><i class="fas fa-map-marker-alt text-primary me-2"></i> Kinari Bazar, Agra, Uttar Pradesh, India</p>
          <p><i class="fas fa-phone text-primary me-2"></i> +91 98765 43210</p>
          <p><i class="fas fa-envelope text-primary me-2"></i> contact@amarnathhampers.com</p>
          <p class="mt-4">Business Hours: Monday - Saturday (10:00 AM - 8:00 PM)</p>
      </div>
    </div>
    <div class='col-md-6'>
      <div class="p-4 bg-white rounded shadow-sm border h-100">
          <h4>Send Us a Message</h4>
          <hr>
          <form>
              <div class="mb-3">
                  <label class="form-label">Full Name</label>
                  <input type="text" class="form-control" placeholder="Your Name">
              </div>
              <div class="mb-3">
                  <label class="form-label">Email Address</label>
                  <input type="email" class="form-control" placeholder="Your Email">
              </div>
              <div class="mb-3">
                  <label class="form-label">Message / Inquiry (e.g., Trousseau packing)</label>
                  <textarea class="form-control" rows="4" placeholder="How can we help you?"></textarea>
              </div>
              <button type="submit" class="theme-btn w-100">Send Message</button>
          </form>
      </div>
    </div>
  </div>
</div>
@endsection
