@php
    $categories = \App\Models\Category::where('status', 1)->orderBy('orders', 'asc')->get();
    $cart = session('cart', []);
    $cartCount = array_sum(array_column($cart, 'qty'));
    $cartTotal = array_sum(array_map(fn($item) => $item['price'] * $item['qty'], $cart));
    $wishlistCount = count(session('wishlist', []));
    $compareCount = count(session('compare', []));
    $settings = \App\Models\SiteSetting::first();
@endphp
<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from live.themewild.com/gifoy/index-3.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 26 Mar 2026 17:21:48 GMT -->
<head>
    <!-- meta tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- title -->
    <title>Amarnath Hampers & Materials</title>

    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="{{ $settings?->favicon_path ? asset($settings->favicon_path) : asset('frontend/assets/img/logo/logo4.png') }}">

    <!-- css -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/all-fontawesome.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/magnific-popup.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/nice-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">

    <!-- Premium Slider Auto-Resizing Engine -->
    <style>
        .hs-3 .hero-single {
            background-size: cover !important;
            background-position: center center !important;
            background-repeat: no-repeat !important;
            /* Force the perfect high-res aspect ratio on larger displays */
            height: 720px !important;
            min-height: 720px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
        }

        /* Responsive Scaling for flawless display across all screen sizes */
        @media (max-width: 1599.98px) {
            .hs-3 .hero-single {
                height: 650px !important;
                min-height: 650px !important;
            }
        }
        @media (max-width: 1199.98px) {
            .hs-3 .hero-single {
                height: 550px !important;
                min-height: 550px !important;
            }
        }
        @media (max-width: 991.98px) {
            .hs-3 .hero-single {
                height: 480px !important;
                min-height: 480px !important;
            }
        }
        @media (max-width: 767.98px) {
            .hs-3 .hero-single {
                height: 400px !important;
                min-height: 400px !important;
            }
        }
        @media (max-width: 575.98px) {
            .hs-3 .hero-single {
                height: 350px !important;
                min-height: 350px !important;
            }
        }

        /* Premium Logo Preloader Styles */
        .preloader {
            background: #ffffff !important;
            animation: preloader-hide 0.5s ease 1.5s forwards !important;
            z-index: 99999 !important;
        }

        .loader-container {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 160px;
            height: 160px;
        }

        .loader-ring {
            position: absolute;
            width: 150px;
            height: 150px;
            border: 4px solid rgba(122, 78, 45, 0.08);
            border-top: 4px solid var(--theme-color, #7A4E2D);
            border-bottom: 4px solid var(--theme-color2, #C7A24A);
            border-radius: 50%;
            animation: loader-spin 1.5s cubic-bezier(0.5, 0, 0.5, 1) infinite;
        }

        .loader-logo {
            position: absolute;
            width: 100px;
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .loader-logo img {
            max-width: 100px;
            max-height: 100px;
            object-fit: contain;
            animation: loader-pulse 2s ease-in-out infinite;
        }

        @keyframes loader-spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes loader-pulse {
            0%, 100% {
                transform: scale(0.92);
            }
            50% {
                transform: scale(1.08);
            }
        }
    </style>
</head>

<body class="home-3">

    <!-- preloader -->
    <div class="preloader">
        <div class="loader-container">
            <div class="loader-ring"></div>
            <div class="loader-logo">
                <img src="{{ $settings?->logo_path ? asset($settings->logo_path) : asset('frontend/assets/img/logo/logo1.png') }}" alt="Loading Logo">
            </div>
        </div>
    </div>
    <!-- preloader end -->


    <!-- header area -->
    <header class="header">

        <!-- header top -->
        <div class="header-top">
            <div class="container">
                <div class="header-top-wrapper">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6 col-xl-5">
                            <div class="header-top-left">
                                <ul class="header-top-list">
                                    <li>
                                        <p><i class="fas fa-fire"></i> The Biggest Sale Ever 50% Off</p>
                                    </li>
                                    <li><a href="tel:{{ $settings?->phone ?: '+2 123 654 7898' }}"><i class="fas fa-headset"></i> {{ $settings?->phone ?: '+2 123 654 7898' }}</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6 col-xl-7">
                            <div class="header-top-right">
                                <ul class="header-top-list">
                                    <li>
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fas fa-rupee-sign"></i> INR
                                            </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#">INR</a>
                                                <a class="dropdown-item" href="#">EUR</a>
                                                <a class="dropdown-item" href="#">AUD</a>
                                                <a class="dropdown-item" href="#">CUD</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fas fa-globe-americas"></i> EN
                                            </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#">EN</a>
                                                <a class="dropdown-item" href="#">FR</a>
                                                <a class="dropdown-item" href="#">DE</a>
                                                <a class="dropdown-item" href="#">RU</a>
                                            </div>
                                        </div>
                                    </li>
                                    @if($settings?->facebook || $settings?->twitter || $settings?->instagram || $settings?->linkedin)
                                    <li class="social">
                                        <div class="header-top-social">
                                            <span>Follow Us: </span>
                                            @if($settings?->facebook)<a href="{{ $settings->facebook }}" target="_blank"><i class="fab fa-facebook-f"></i></a>@endif
                                            @if($settings?->twitter)<a href="{{ $settings->twitter }}" target="_blank"><i class="fab fa-x-twitter"></i></a>@endif
                                            @if($settings?->instagram)<a href="{{ $settings->instagram }}" target="_blank"><i class="fab fa-instagram"></i>@endif
                                            @if($settings?->linkedin)<a href="{{ $settings->linkedin }}" target="_blank"><i class="fab fa-linkedin-in"></i></a>@endif
                                        </div>
                                    </li>
                                    @else
                                    <li class="social">
                                        <div class="header-top-social">
                                            <span>Follow Us: </span>
                                            <a href="#"><i class="fab fa-facebook"></i></a>
                                            <a href="#"><i class="fab fa-x-twitter"></i></a>
                                            <a href="#"><i class="fab fa-instagram"></i></a>
                                            <a href="#"><i class="fab fa-linkedin"></i></a>
                                        </div>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- header top end -->

        <!-- navbar -->
        <div class="main-navigation">
            <nav class="navbar navbar-expand-lg">
                <div class="container position-relative">
                    <a class="navbar-brand" href="{{ route('home') }}">
                        <img src="{{ $settings?->logo_path ? asset($settings->logo_path) : asset('frontend/assets/img/logo/logo1.png') }}" alt="logo">
                    </a>
                    <div class="mobile-menu-right">
                        <div class="mobile-menu-btn">
                              <a href="#" class="nav-right-link search-box-outer"><i class="fas fa-search"></i></a>
                              <a href="{{ route('compare.index') }}" class="nav-right-link" title="Compare"><i
                                      class="fas fa-exchange-alt"></i><span>{{ $compareCount }}</span></a>
                              <a href="{{ route('wishlist.index') }}" class="nav-right-link" title="Wishlist"><i
                                      class="fas fa-heart"></i><span>{{ $wishlistCount }}</span></a>
                              <a href="{{ route('cart.index') }}" class="nav-right-link"><i
                                    class="fas fa-shopping-bag"></i><span>{{ $cartCount }}</span></a>
                        </div>
                        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar"
                            aria-label="Toggle navigation">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar"
                        aria-labelledby="offcanvasNavbarLabel">
                        <div class="offcanvas-header">
                            <a href="{{ route('home') }}" class="offcanvas-brand" id="offcanvasNavbarLabel">
                                <img src="{{ $settings?->logo_path ? asset($settings->logo_path) : asset('frontend/assets/img/logo/logo1.png') }}" alt="logo">
                            </a>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <ul class="navbar-nav justify-content-end flex-grow-1 pe-lg-5">
                                <li class="nav-item">
                                    <a class="nav-link active" href="{{ route('home') }}">Home</a>
                                </li>
                                <li class="nav-item mega-menu dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">All Category</a>
                                    <div class="dropdown-menu fade-down">
                                        <div class="mega-content">
                                            <div class="container-fluid px-lg-0">
                                                <div class="row">
                                                    @foreach($categories->chunk(6) as $chunk)
                                                    <div class="col-12 col-lg-2">
                                                        <h5 class="mega-menu-title">Category</h5>
                                                        <ul class="mega-menu-item">
                                                            @foreach($chunk as $cat)
                                                                <li><a class="dropdown-item" href="{{ route('shop.index', ['category' => $cat->slug]) }}">{{ $cat->name }}</a></li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    @endforeach
                                                    <div class="col-12 col-lg-4">
                                                        <div class="mega-menu-img">
                                                            <a href="#"><img
                                                                    src="{{ asset('frontend/assets/img/banner/mega-menu-banner.jpg') }}"
                                                                    alt=""></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About</a></li>
                                <!-- Removed redundant Pages dropdown -->
                                @auth
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Account</a>
                                    <ul class="dropdown-menu fade-down">
                                        <li><a class="dropdown-item" href="{{ route('customer.dashboard') }}">Dashboard</a></li>
                                        <li>
                                            <form action="{{ route('customer.logout') }}" method="POST" style="margin: 0;">
                                                @csrf
                                                <button type="submit" class="dropdown-item" style="border: none; background: none; width: 100%; text-align: left; padding: 0.25rem 1rem;">Logout</button>
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                                @endauth
                                <li class="nav-item"><a class="nav-link" href="{{ route('shop.index') }}">Shop</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('blog.index') }}">Blog</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contact</a></li>
                            </ul>
                            <!-- nav-right -->
                            <div class="nav-right">
                                <ul class="nav-right-list">
                                    <li>
                                        <a href="#" class="list-link search-box-outer">
                                            <i class="fas fa-search"></i>
                                        </a>
                                    </li>
                                      <li>
                                          <a href="{{ route('compare.index') }}" class="list-link" title="Compare">
                                              <i class="fas fa-exchange-alt"></i><span>{{ $compareCount }}</span>
                                          </a>
                                      </li>
                                      <li>
                                          <a href="{{ route('wishlist.index') }}" class="list-link" title="Wishlist">
                                              <i class="fas fa-heart"></i><span>{{ $wishlistCount }}</span>
                                          </a>
                                      </li>
                                    <li class="dropdown-cart">
                                        <a href="#" class="list-link shop-cart">
                                            <i class="fas fa-shopping-bag"></i><span>{{ $cartCount }}</span>
                                        </a>
                                        <div class="dropdown-cart-menu">
                                            <div class="dropdown-cart-header">
                                                <span>{{ count($cart) }} Items</span>
                                                <a href="{{ route('cart.index') }}">View Cart</a>
                                            </div>
                                            <ul class="dropdown-cart-list">
                                                @forelse($cart as $id => $item)
                                                <li>
                                                    <div class="dropdown-cart-item">
                                                        <div class="cart-img">
                                                            <a href="{{ route('shop.show', $item['slug']) }}"><img src="{{ asset($item['image']) }}"
                                                                    alt="{{ $item['name'] }}"></a>
                                                        </div>
                                                        <div class="cart-info">
                                                            <h4><a href="{{ route('shop.show', $item['slug']) }}">{{ $item['name'] }}</a></h4>
                                                            <p class="cart-qty">{{ $item['qty'] }}x - <span
                                                                    class="cart-amount">₹{{ number_format($item['price'], 2) }}</span></p>
                                                        </div>
                                                        <a href="{{ route('cart.remove', $id) }}" class="cart-remove" title="Remove this item"><i
                                                                class="fas fa-times-circle"></i></a>
                                                    </div>
                                                </li>
                                                @empty
                                                <li>
                                                    <div class="p-3 text-center text-muted">Your cart is empty.</div>
                                                </li>
                                                @endforelse
                                            </ul>
                                            @if(count($cart) > 0)
                                            <div class="dropdown-cart-bottom">
                                                <div class="dropdown-cart-total">
                                                    <span>Total</span>
                                                    <span class="total-amount">₹{{ number_format($cartTotal, 2) }}</span>
                                                </div>
                                                <a href="{{ route('checkout.index') }}" class="theme-btn">Checkout</a>
                                            </div>
                                            @endif
                                        </div>
                                    </li>
                                </ul>
                                <div class="nav-right-btn">
                                    @guest
                                        <a href="{{ route('customer.login') }}" class="theme-btn"><span class="fas fa-user-tie"></span> Login</a>
                                    @else
                                        <a href="{{ route('customer.dashboard') }}" class="theme-btn"><span class="fas fa-user-circle"></span> My Account</a>
                                    @endguest
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <!-- navbar end -->

    </header>
    <!-- header area end -->


    <!-- popup search -->
    <div class="search-popup">
        <button class="close-search"><span class="fas fa-times"></span></button>
        <form action="#">
            <div class="form-group">
                <input type="search" name="search-field" class="form-control" placeholder="Search Here..." required>
                <button type="submit"><i class="fas fa-search"></i></button>
            </div>
        </form>
    </div>
    <!-- popup search end -->


    <main class="main">
        @yield('content')
    </main>


    <!-- footer area -->
    <footer class="footer-area">
        <div class="footer-widget">
            <div class="container">
                <div class="row footer-widget-wrapper pt-100 pb-40">
                    <div class="col-md-6 col-lg-3">
                        <div class="footer-widget-box about-us">
                            <a href="{{ route('home') }}" class="footer-logo">
                                <img src="{{ $settings?->logo_path ? asset($settings->logo_path) : asset('frontend/assets/img/logo/logo4.png') }}" alt="logo">
                            </a>
                            <p class="mb-3">
                                {{ $settings?->footer_desc ?: 'Amarnath Hampers and Materials delivers quality hampers and essential materials with trusted service.' }}
                            </p>
                            <ul class="footer-contact">
                                <li><a href="tel:{{ $settings?->phone ?: '+2 123 654 7898' }}"><i class="fas fa-phone"></i>{{ $settings?->phone ?: '+2 123 654 7898' }}</a></li>
                                <li><i class="fas fa-map-marker-alt"></i>{{ $settings?->address ?: '25/B Milford Road, New York' }}</li>
                                <li><a href="mailto:{{ $settings?->email ?: 'info@example.com' }}" style="word-break: break-all;"><i class="fas fa-envelope"></i>{{ $settings?->email ?: 'info@example.com' }}</a></li>
                                <li><i class="fas fa-clock"></i>Mon-Fri (9.00AM - 8.00PM)</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2">
                        <div class="footer-widget-box list">
                            <h4 class="footer-widget-title">Quick Links</h4>
                            <ul class="footer-list">
                                <li><a href="{{ route('about') }}">About Us</a></li>
                                <li><a href="{{ route('contact') }}">Contact Us</a></li>
                                <li><a href="{{ route('blog.index') }}">Blog News</a></li>
                                <li><a href="{{ route('page.show', 'terms-of-service') }}">Terms Of Service</a></li>
                                <li><a href="{{ route('page.show', 'privacy-policy') }}">Privacy Policy</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2">
                        <div class="footer-widget-box list">
                            <h4 class="footer-widget-title">Browse Category</h4>
                            <ul class="footer-list">
                                @foreach($categories->take(7) as $cat)
                                    <li><a href="{{ route('shop.index') }}?category={{ $cat->id }}">{{ $cat->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2">
                        <div class="footer-widget-box list">
                            <h4 class="footer-widget-title">Support Center</h4>
                            <ul class="footer-list">
                                <li><a href="{{ route('page.show', 'faq') }}">FAQ's</a></li>
                                <li><a href="{{ route('page.show', 'how-to-buy') }}">How To Buy</a></li>
                                <li><a href="{{ route('contact') }}">Support Center</a></li>
                                <li><a href="{{ route('page.show', 'track-order') }}">Track Your Order</a></li>
                                <li><a href="{{ route('page.show', 'returns-policy') }}">Returns Policy</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="footer-widget-box list">
                            <h4 class="footer-widget-title">Newsletter</h4>
                            <p>Subscribe to our newsletter to receive updates on new trousseau designs and festive hampers.</p>
                            <div class="footer-newsletter mt-3">
                                <form action="#">
                                    <div class="input-group">
                                        <input type="email" class="form-control" placeholder="Your Email" required>
                                        <button class="theme-btn" type="submit" style="padding: 10px 15px;">Subscribe</button>
                                    </div>
                                </form>
                            </div>
                            <div class="footer-payment mt-20">
                                <span>We Accept:</span>
                                <img src="{{ asset('frontend/assets/img/payment/visa.svg') }}" alt="">
                                <img src="{{ asset('frontend/assets/img/payment/mastercard.svg') }}" alt="">
                                <img src="{{ asset('frontend/assets/img/payment/amex.svg') }}" alt="">
                                <img src="{{ asset('frontend/assets/img/payment/discover.svg') }}" alt="">
                                <img src="{{ asset('frontend/assets/img/payment/paypal.svg') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright">
            <div class="container">
                <div class="copyright-wrap">
                    <div class="row">
                        <div class="col-12 col-lg-6 align-self-center">
                            <p class="copyright-text">
                                &copy; Copyright <span id="date"></span> <a href="{{ route('home') }}"> {{ $settings?->copyright_text ?: 'Amarnath Hampers and Materials' }} </a> All Rights Reserved.
                            </p>
                        </div>
                        <div class="col-12 col-lg-6 align-self-center">
                            <div class="footer-social">
                                <span>Follow Us:</span>
                                @if($settings?->facebook)
                                    <a href="{{ $settings->facebook }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                @else
                                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                                @endif

                                @if($settings?->twitter)
                                    <a href="{{ $settings->twitter }}" target="_blank"><i class="fab fa-x-twitter"></i></a>
                                @else
                                    <a href="#"><i class="fab fa-x-twitter"></i></a>
                                @endif

                                @if($settings?->linkedin)
                                    <a href="{{ $settings->linkedin }}" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                                @else
                                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                @endif

                                @if($settings?->instagram)
                                    <a href="{{ $settings->instagram }}" target="_blank"><i class="fab fa-instagram"></i></a>
                                @else
                                    <a href="#"><i class="fab fa-youtube"></i></a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer area end -->


    <!-- scroll-top -->
    <a href="#" id="scroll-top"><i class="fas fa-arrow-up"></i></a>
    <!-- scroll-top end -->


    <!-- modal quick shop-->
    <div class="modal quickview fade" id="quickview" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="quickview" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="fas fa-xmark"></i></button>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <img src="{{ asset('frontend/assets/img/product/18.png') }}" alt="#">
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="quickview-content">
                                <h4 class="quickview-title">Special Gift Box</h4>
                                <div class="quickview-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <i class="fas fa-star"></i>
                                    <span class="rating-count"> (4 Customer Reviews)</span>
                                </div>
                                <div class="quickview-price">
                                    <h5><del>₹860</del><span>₹740</span></h5>
                                </div>
                                <ul class="quickview-list">
                                    <li>Brand:<span>Ricordi</span></li>
                                    <li>Category:<span>Gifts Box</span></li>
                                    <li>Stock:<span class="stock">Available</span></li>
                                    <li>Code:<span>789FGSA</span></li>
                                </ul>
                                <div class="quickview-cart">
                                    <a href="#" class="theme-btn">Add to cart</a>
                                </div>
                                <div class="quickview-social">
                                    <span>Share:</span>
                                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                                    <a href="#"><i class="fab fa-x-twitter"></i></a>
                                    <a href="#"><i class="fab fa-pinterest-p"></i></a>
                                    <a href="#"><i class="fab fa-instagram"></i></a>
                                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- modal quick shop end -->


    <!-- js -->
    <script>
        (function () {
            function hidePreloader() {
                var preloader = document.querySelector('.preloader');
                if (!preloader) return;
                preloader.style.opacity = '0';
                preloader.style.visibility = 'hidden';
                preloader.style.pointerEvents = 'none';
                preloader.style.display = 'none';
            }

            if (document.readyState === 'complete' || document.readyState === 'interactive') {
                hidePreloader();
            } else {
                document.addEventListener('DOMContentLoaded', hidePreloader, { once: true });
            }

            window.addEventListener('load', hidePreloader, { once: true });
            setTimeout(hidePreloader, 1500);
        })();
    </script>
    <script src="{{ asset('frontend/assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/modernizr.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/jquery.appear.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/counter-up.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/countdown.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/main.js') }}"></script>
    
    <!-- 3D Animations (VanillaTilt) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.1/vanilla-tilt.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            VanillaTilt.init(document.querySelectorAll(".tilt-3d"), {
                max: 15,
                speed: 400,
                glare: true,
                "max-glare": 0.2,
                perspective: 1000,
                scale: 1.02
            });
        });
    </script>
</body>


<!-- Mirrored from live.themewild.com/gifoy/index-3.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 26 Mar 2026 17:21:52 GMT -->
</html>





