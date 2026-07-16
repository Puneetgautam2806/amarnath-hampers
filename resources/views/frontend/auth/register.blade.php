@extends('frontend.layouts.app')

@section('content')

<!-- breadcrumb -->
<div class="site-breadcrumb-wrap" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('{{ asset('frontend/assets/img/banner/big-banner.jpg') }}') no-repeat center center; background-size: cover; padding: 100px 0;">
    <div class="container">
        <div class="site-breadcrumb-content text-center text-white">
            <h2 class="breadcrumb-title text-white" style="font-size: 3rem; font-weight: 800; letter-spacing: 1px; margin-bottom: 10px; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">Register</h2>
            <ul class="breadcrumb-menu d-flex justify-content-center gap-3 list-unstyled" style="font-size: 1.1rem; font-weight: 500;">
                <li><a href="{{ route('home') }}" class="text-white text-decoration-none hover-pink" style="transition: color 0.3s;">Home</a></li>
                <li class="text-white opacity-50"><i class="fas fa-chevron-right" style="font-size: 0.8rem;"></i></li>
                <li class="active text-pink" style="color: #ff7c8b !important;">Register</li>
            </ul>
        </div>
    </div>
</div>
<!-- breadcrumb end -->

<div class="login-area" style="padding: 120px 0; background-color: #fafafa;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="auth-card bg-white">
                    <div class="auth-card-body p-5">
                        <div class="auth-header">
                            <div class="auth-icon-wrap mb-4 mx-auto d-flex align-items-center justify-content-center" style="width: 70px; height: 70px; background: rgba(255, 124, 139, 0.1); border-radius: 50%; color: #ff7c8b; font-size: 1.8rem;">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <h3 class="auth-title">Create Account</h3>
                            <p class="auth-subtitle">Join us today to get the best gifting experience.</p>
                        </div>
                        
                        @if ($errors->any())
                            <div class="alert alert-danger rounded-custom mb-4 border-0 p-3" style="background-color: #fff0f1; color: #d9534f; border-left: 4px solid #d9534f !important;">
                                <ul class="mb-0 pl-3 list-unstyled">
                                    @foreach ($errors->all() as $error)
                                        <li><i class="fas fa-exclamation-circle mr-2"></i> {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('customer.register.submit') }}" method="POST">
                            @csrf
                            
                            <div class="form-group mb-4">
                                <label class="font-weight-bold text-dark mb-2" style="font-size: 0.95rem;">Full Name <span class="text-danger">*</span></label>
                                <div class="input-group auth-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text custom-icon"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" name="name" class="form-control custom-input with-icon" placeholder="e.g. John Doe" required value="{{ old('name') }}">
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label class="font-weight-bold text-dark mb-2" style="font-size: 0.95rem;">Email Address <span class="text-danger">*</span></label>
                                <div class="input-group auth-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text custom-icon"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input type="email" name="email" class="form-control custom-input with-icon" placeholder="name@example.com" required value="{{ old('email') }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-5">
                                        <label class="font-weight-bold text-dark mb-2" style="font-size: 0.95rem;">Password <span class="text-danger">*</span></label>
                                        <div class="input-group auth-input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text custom-icon"><i class="fas fa-lock"></i></span>
                                            </div>
                                            <input type="password" name="password" class="form-control custom-input with-icon" placeholder="Create password" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-5">
                                        <label class="font-weight-bold text-dark mb-2" style="font-size: 0.95rem;">Confirm Password <span class="text-danger">*</span></label>
                                        <div class="input-group auth-input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text custom-icon"><i class="fas fa-check-circle"></i></span>
                                            </div>
                                            <input type="password" name="password_confirmation" class="form-control custom-input with-icon" placeholder="Confirm password" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn w-100 auth-btn text-white">
                                Register Account <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </form>

                        <div class="auth-footer text-center mt-5 pt-4 border-top">
                            <p class="text-muted mb-0">Already have an account? <a href="{{ route('customer.login') }}" class="font-weight-bold text-dark ml-1 auth-link" style="border-bottom: 2px solid #ff7c8b; padding-bottom: 2px;">Login Here</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .auth-card {
        border: none;
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.06);
        transition: all 0.3s ease;
    }
    .auth-card:hover {
        box-shadow: 0 30px 60px rgba(0,0,0,0.1);
        transform: translateY(-5px);
    }
    .auth-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }
    .auth-title {
        font-weight: 800;
        color: #1a1a1a;
        font-size: 2rem;
        margin-bottom: 8px;
    }
    .auth-subtitle {
        color: #888;
        font-size: 0.95rem;
    }
    .auth-input-group {
        border-radius: 50px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.02);
    }
    .custom-input {
        height: 55px;
        padding: 10px 25px 10px 15px;
        border: 2px solid #f0f0f0;
        background-color: #fcfcfc;
        font-size: 1rem;
        font-weight: 500;
        color: #333;
        transition: all 0.3s ease;
    }
    .custom-input:focus {
        background-color: #fff;
        border-color: #ff7c8b;
        box-shadow: none;
    }
    .input-group-text.custom-icon {
        background-color: #fcfcfc;
        border: 2px solid #f0f0f0;
        border-right: none;
        padding-left: 25px;
        padding-right: 15px;
        color: #a0a0a0;
        border-radius: 50px 0 0 50px !important;
        transition: all 0.3s ease;
    }
    .custom-input:focus ~ .input-group-text.custom-icon,
    .auth-input-group:focus-within .input-group-text.custom-icon {
        border-color: #ff7c8b;
        color: #ff7c8b;
        background-color: #fff;
    }
    .custom-input.with-icon {
        border-radius: 0 50px 50px 0 !important;
        border-left: none;
    }
    .auth-btn {
        background: linear-gradient(135deg, #ff7c8b, #ff5b6f);
        border: none;
        border-radius: 50px;
        height: 55px;
        font-weight: 700;
        font-size: 1.1rem;
        letter-spacing: 0.5px;
        transition: all 0.4s ease;
        box-shadow: 0 10px 20px rgba(255, 124, 139, 0.3);
    }
    .auth-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(255, 124, 139, 0.45);
        background: linear-gradient(135deg, #ff5b6f, #ff7c8b);
    }
    .text-pink { color: #ff7c8b !important; }
    .hover-pink:hover { color: #ff7c8b !important; text-decoration: none; }
    .auth-link:hover { color: #ff7c8b !important; text-decoration: none; border-color: #1a1a1a !important; }
    .rounded-custom { border-radius: 12px; }
</style>
@endsection
