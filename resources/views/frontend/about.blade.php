@extends('frontend.layouts.app')

@section('content')

    <!-- site-breadcrumb -->
    <div class="site-breadcrumb">
        <div class="site-breadcrumb-bg" style="background: url({{ asset('frontend/assets/img/banner/breadcrumb.jpg') }}) center center/cover no-repeat;"></div>
        <div class="container">
            <div class="site-breadcrumb-wrap">
                <h4 class="breadcrumb-title">About Us</h4>
                <ul class="breadcrumb-menu">
                    <li><a href="{{ route('home') }}"><i class="fas fa-home"></i> Home</a></li>
                    <li class="active">About Us</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- site-breadcrumb end -->


    <!-- about area -->
    <div class="about-area py-120">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="about-left wow fadeInLeft" data-wow-delay=".25s">
                        <div class="about-img">
                            <div class="img-1">
                                <img src="{{ asset('frontend/assets/img/about/01.jpg') }}" alt="Hamper Crafting">
                            </div>
                            <img class="img-2" src="{{ asset('frontend/assets/img/about/02.jpg') }}" alt="Gifting Hampers">
                            <img class="img-3" src="{{ asset('frontend/assets/img/about/03.jpg') }}" alt="Bridal Presentation">
                        </div>
                        <div class="about-experience">
                            <div class="about-experience-icon">
                                <img src="{{ asset('frontend/assets/img/icon/experience.svg') }}" alt="Experience">
                            </div>
                            <b>30 Years Of <br> Legacy</b>
                        </div>
                        <div class="about-shape">
                            <img src="{{ asset('frontend/assets/img/shape/01.png') }}" alt="Shape">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-right wow fadeInRight" data-wow-delay=".25s">
                        <div class="site-heading mb-3">
                            <span class="site-title-tagline justify-content-start">
                                <i class="fas fa-info-circle"></i> ABOUT US
                            </span>
                            <h2 class="site-title">
                                Crafting Exquisite <span>Trousseau & Hampers</span> For Your Special Day
                            </h2>
                        </div>
                        <p class="mb-3" style="font-size: 16px; line-height: 1.8; color: #555;">
                            Based in the historic city of Agra, <strong>Amar Nath Hampers & Materials</strong> specializes in creating luxurious, hand-crafted wedding trays, ring ceremony platters, bridal accessories, and bespoke festive gifting solutions. We bring elegance and authentic Indian traditions together to make every milestone celebration unforgettable.
                        </p>
                        <p class="mb-4" style="font-size: 15px; line-height: 1.7; color: #666;">
                            From jewel-toned velvet trousseau trays to personalized engagement ring platters, each piece is painstakingly crafted by master artisans in our Kinari Bazar studio.
                        </p>
                        <div class="about-list">
                            <ul>
                                <li><i class="fas fa-check-circle text-primary"></i> <strong>Premium Handcrafted Designs:</strong> Rich silks, brocades, and fine zari detailing.</li>
                                <li><i class="fas fa-check-circle text-primary"></i> <strong>Custom Trousseau Packing:</strong> Customized color palettes matching bride & groom outfits.</li>
                                <li><i class="fas fa-check-circle text-primary"></i> <strong>Traditional & Modern Fusion:</strong> Ambient LED lighting & contemporary acrylic finishes.</li>
                                <li><i class="fas fa-check-circle text-primary"></i> <strong>Trusted by Elite Families:</strong> Over 3 decades of trusted service in Agra & across India.</li>
                            </ul>
                        </div>
                        <div class="d-flex flex-wrap gap-3 mt-4">
                            <a href="{{ route('shop.index') }}" class="theme-btn">Explore Collections <i class="fas fa-arrow-right ms-2"></i></a>
                            <a href="{{ route('contact') }}" class="theme-btn" style="background: transparent; color: var(--theme-color); border: 2px solid var(--theme-color);">Book Consultation <i class="fas fa-calendar-check ms-2"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- about area end -->


    <!-- feature area -->
    <div class="feature-area bg-light py-80">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="feature-item p-4 bg-white rounded-4 shadow-sm border text-center h-100">
                        <div class="feature-icon mb-3" style="font-size: 38px; color: var(--theme-color, #c89551);">
                            <i class="fas fa-hands"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">100% Handcrafted</h5>
                        <p class="text-muted small mb-0">Every platter and hamper is handcrafted with love by traditional artisans in Agra.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-item p-4 bg-white rounded-4 shadow-sm border text-center h-100">
                        <div class="feature-icon mb-3" style="font-size: 38px; color: var(--theme-color, #c89551);">
                            <i class="fas fa-palette"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">Bespoke Customization</h5>
                        <p class="text-muted small mb-0">Personalized themes, initials, florals, and color matching for your wedding.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-item p-4 bg-white rounded-4 shadow-sm border text-center h-100">
                        <div class="feature-icon mb-3" style="font-size: 38px; color: var(--theme-color, #c89551);">
                            <i class="fas fa-truck-fast"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">Safe & Timely Delivery</h5>
                        <p class="text-muted small mb-0">Carefully cushioned packaging guaranteed to arrive pristine before your event.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-item p-4 bg-white rounded-4 shadow-sm border text-center h-100">
                        <div class="feature-icon mb-3" style="font-size: 38px; color: var(--theme-color, #c89551);">
                            <i class="fas fa-award"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">Uncompromised Quality</h5>
                        <p class="text-muted small mb-0">Premium velvets, raw silk, gotapatti, and high-gsm metallic materials.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- feature area end -->


    <!-- testimonial area -->
    @if(isset($testimonials) && $testimonials->isNotEmpty())
        <div class="testimonial-area bg ts-bg py-90">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mx-auto wow fadeInDown" data-wow-delay=".25s">
                        <div class="site-heading text-center">
                            <span class="site-title-tagline">Testimonials</span>
                            <h2 class="site-title">What Our Clients <span>Say</span> About Us</h2>
                        </div>
                    </div>
                </div>
                @if ($testimonials->count() == 1)
                    <div class="row justify-content-center">
                        @foreach ($testimonials as $t)
                            <div class="col-lg-6 col-md-8">
                                <div class="testimonial-item shadow-sm border rounded-4 p-4" style="background: #fff; position: relative;">
                                    <div class="testimonial-author d-flex align-items-center mb-3">
                                        <div class="testimonial-author-img d-flex align-items-center justify-content-center overflow-hidden me-3" style="width: 65px; height: 65px; border-radius: 50%; flex-shrink: 0;">
                                            @if ($t->photo)
                                                <img src="{{ asset($t->photo) }}" alt="{{ $t->name }}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($t->name) }}&background=a0734f&color=fff&size=100';">
                                            @else
                                                <div class="w-100 h-100 d-flex align-items-center justify-content-center text-white fw-bold" style="background: linear-gradient(135deg, #a0734f, #6c4728); font-size: 20px;">
                                                    {{ strtoupper(substr($t->name, 0, 2)) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="testimonial-author-info">
                                            <h4 class="mb-1 text-dark fw-bold">{{ $t->name }}</h4>
                                            <p class="text-muted small mb-0">{{ $t->designation ?? 'Verified Customer' }}</p>
                                        </div>
                                    </div>
                                    <div class="testimonial-quote mb-3">
                                        <p class="text-dark mb-0" style="font-size: 15px; line-height: 1.6;">"{{ $t->review_text }}"</p>
                                    </div>
                                    <div class="testimonial-rate text-warning">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $t->rating)
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <div class="testimonial-quote-icon" style="position: absolute; right: 25px; bottom: 20px; opacity: 0.15;"><img src="{{ asset('frontend/assets/img/icon/quote.svg') }}" alt="Quote" width="40"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @elseif ($testimonials->count() == 2)
                    <div class="row justify-content-center g-4">
                        @foreach ($testimonials as $t)
                            <div class="col-lg-5 col-md-6">
                                <div class="testimonial-item shadow-sm border rounded-4 p-4 h-100" style="background: #fff; position: relative;">
                                    <div class="testimonial-author d-flex align-items-center mb-3">
                                        <div class="testimonial-author-img d-flex align-items-center justify-content-center overflow-hidden me-3" style="width: 65px; height: 65px; border-radius: 50%; flex-shrink: 0;">
                                            @if ($t->photo)
                                                <img src="{{ asset($t->photo) }}" alt="{{ $t->name }}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($t->name) }}&background=a0734f&color=fff&size=100';">
                                            @else
                                                <div class="w-100 h-100 d-flex align-items-center justify-content-center text-white fw-bold" style="background: linear-gradient(135deg, #a0734f, #6c4728); font-size: 20px;">
                                                    {{ strtoupper(substr($t->name, 0, 2)) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="testimonial-author-info">
                                            <h4 class="mb-1 text-dark fw-bold">{{ $t->name }}</h4>
                                            <p class="text-muted small mb-0">{{ $t->designation ?? 'Verified Customer' }}</p>
                                        </div>
                                    </div>
                                    <div class="testimonial-quote mb-3">
                                        <p class="text-dark mb-0" style="font-size: 15px; line-height: 1.6;">"{{ $t->review_text }}"</p>
                                    </div>
                                    <div class="testimonial-rate text-warning">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $t->rating)
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <div class="testimonial-quote-icon" style="position: absolute; right: 25px; bottom: 20px; opacity: 0.15;"><img src="{{ asset('frontend/assets/img/icon/quote.svg') }}" alt="Quote" width="40"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="testimonial-slider owl-carousel owl-theme wow fadeInUp" data-wow-delay=".25s">
                        @foreach ($testimonials as $t)
                            <div class="testimonial-item">
                                <div class="testimonial-author">
                                    <div class="testimonial-author-img d-flex align-items-center justify-content-center overflow-hidden" style="width: 65px; height: 65px; border-radius: 50%;">
                                        @if ($t->photo)
                                            <img src="{{ asset($t->photo) }}" alt="{{ $t->name }}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($t->name) }}&background=a0734f&color=fff&size=100';">
                                        @else
                                            <div class="w-100 h-100 d-flex align-items-center justify-content-center text-white fw-bold" style="background: linear-gradient(135deg, #a0734f, #6c4728); font-size: 20px;">
                                                {{ strtoupper(substr($t->name, 0, 2)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="testimonial-author-info">
                                        <h4>{{ $t->name }}</h4>
                                        <p>{{ $t->designation ?? 'Verified Customer' }}</p>
                                    </div>
                                </div>
                                <div class="testimonial-quote">
                                    <p>"{{ $t->review_text }}"</p>
                                </div>
                                <div class="testimonial-rate">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $t->rating)
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <div class="testimonial-quote-icon"><img src="{{ asset('frontend/assets/img/icon/quote.svg') }}" alt="Quote"></div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endif
    <!-- testimonial area end -->

@endsection
