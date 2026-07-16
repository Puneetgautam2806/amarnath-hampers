@extends('frontend.layouts.app')

@section('content')

<!-- breadcrumb -->
<div class="site-breadcrumb-wrap" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('{{ asset('frontend/assets/img/banner/big-banner.jpg') }}') no-repeat center center; background-size: cover; padding: 100px 0;">
    <div class="container">
        <div class="site-breadcrumb-content text-center text-white">
            <h2 class="breadcrumb-title text-white" style="font-size: 3rem; font-weight: 800; letter-spacing: 1px; margin-bottom: 10px; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">My Dashboard</h2>
            <ul class="breadcrumb-menu d-flex justify-content-center gap-3 list-unstyled" style="font-size: 1.1rem; font-weight: 500;">
                <li><a href="{{ route('home') }}" class="text-white text-decoration-none hover-pink" style="transition: color 0.3s;">Home</a></li>
                <li class="text-white opacity-50"><i class="fas fa-chevron-right" style="font-size: 0.8rem;"></i></li>
                <li class="active text-pink" style="color: #ff7c8b !important;">Dashboard</li>
            </ul>
        </div>
    </div>
</div>
<!-- breadcrumb end -->

<div class="dashboard-area" style="padding: 100px 0; background-color: #f8f9fa;">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success rounded-pill px-4 py-3 mb-5 border-0 shadow-sm d-flex align-items-center" style="background-color: #e8f5e9; color: #2e7d32; font-weight: 500;">
                <div style="background: #4caf50; color: white; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                    <i class="fas fa-check"></i>
                </div>
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 mb-5">
                <div class="user-profile-sidebar bg-white auth-card">
                    <div class="text-center p-5 border-bottom" style="background: linear-gradient(180deg, #fffcfc 0%, #ffffff 100%);">
                        <div class="user-avatar mb-3 mx-auto" style="width: 90px; height: 90px; background: rgba(255, 124, 139, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #ff7c8b;">
                            <i class="fas fa-user-circle fa-4x"></i>
                        </div>
                        <h4 class="font-weight-bold mb-1" style="font-size: 1.3rem; color: #1a1a1a;">{{ $user->name }}</h4>
                        <p class="text-muted mb-0" style="font-size: 0.9rem;">{{ $user->email }}</p>
                    </div>
                    <div class="p-3">
                        <ul class="list-unstyled mb-0 sidebar-menu">
                            <li><a href="#" class="active"><i class="fas fa-th-large"></i> Dashboard</a></li>
                            <li><a href="#"><i class="fas fa-shopping-bag"></i> My Orders <span class="badge badge-pill badge-light float-right text-muted" style="font-size: 0.7rem;">Soon</span></a></li>
                            <li><a href="#"><i class="fas fa-heart"></i> Wishlist <span class="badge badge-pill badge-light float-right text-muted" style="font-size: 0.7rem;">Soon</span></a></li>
                            <li><a href="#"><i class="fas fa-user-edit"></i> Edit Profile</a></li>
                            <li class="mt-4 pt-4 border-top">
                                <form action="{{ route('customer.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn auth-btn-outline w-100">
                                        <i class="fas fa-sign-out mr-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="col-lg-9">
                <div class="dashboard-content bg-white auth-card p-5">
                    <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                        <div>
                            <h3 class="font-weight-bold mb-1" style="color: #1a1a1a; font-size: 1.8rem;">Hello, {{ explode(' ', $user->name)[0] }}!</h3>
                            <p class="text-muted mb-0">Manage your recent orders and account details here.</p>
                        </div>
                    </div>
                    
                    <div class="row mt-5">
                        <div class="col-md-4 mb-4">
                            <div class="stat-card text-center p-4">
                                <div class="stat-icon mx-auto mb-3">
                                    <i class="fas fa-shopping-bag"></i>
                                </div>
                                <h2 class="font-weight-bold mb-1" style="color: #ff7c8b;">0</h2>
                                <p class="text-muted mb-0 font-weight-bold">Total Orders</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="stat-card text-center p-4">
                                <div class="stat-icon mx-auto mb-3">
                                    <i class="fas fa-heart"></i>
                                </div>
                                <h2 class="font-weight-bold mb-1" style="color: #ff7c8b;">0</h2>
                                <p class="text-muted mb-0 font-weight-bold">Wishlist Items</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="stat-card text-center p-4">
                                <div class="stat-icon mx-auto mb-3">
                                    <i class="fas fa-box-open"></i>
                                </div>
                                <h2 class="font-weight-bold mb-1" style="color: #ff7c8b;">0</h2>
                                <p class="text-muted mb-0 font-weight-bold">Pending Orders</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5">
                        <h4 class="font-weight-bold mb-4" style="color: #1a1a1a;">Recent Orders</h4>
                        <div class="text-center py-5 bg-light rounded" style="border: 2px dashed #e0e0e0;">
                            <i class="fas fa-clipboard-list fa-3x mb-3 text-muted" style="opacity: 0.5;"></i>
                            <h5 class="font-weight-bold text-muted">No orders found</h5>
                            <p class="text-muted mb-4">Looks like you haven't placed an order yet.</p>
                            <a href="{{ route('shop.index') }}" class="btn auth-btn text-white px-5">Start Shopping</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .auth-card {
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.04);
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.02);
    }
    .sidebar-menu li a {
        display: flex;
        align-items: center;
        padding: 14px 20px;
        color: #555;
        font-weight: 600;
        border-radius: 12px;
        transition: all 0.3s;
        text-decoration: none;
        margin-bottom: 8px;
    }
    .sidebar-menu li a i {
        width: 25px;
        font-size: 1.1rem;
        color: #999;
        transition: all 0.3s;
    }
    .sidebar-menu li a:hover, .sidebar-menu li a.active {
        background-color: #fff0f1;
        color: #ff7c8b;
    }
    .sidebar-menu li a:hover i, .sidebar-menu li a.active i {
        color: #ff7c8b;
    }
    .stat-card {
        border: 1px solid #f0f0f0;
        border-radius: 16px;
        background: #fff;
        transition: all 0.3s;
    }
    .stat-card:hover {
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        transform: translateY(-5px);
        border-color: #ffe0e4;
    }
    .stat-icon {
        width: 60px;
        height: 60px;
        background: #fcfcfc;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #ccc;
        transition: all 0.3s;
    }
    .stat-card:hover .stat-icon {
        background: #ff7c8b;
        color: #fff;
        box-shadow: 0 8px 15px rgba(255, 124, 139, 0.3);
    }
    .auth-btn {
        background: linear-gradient(135deg, #ff7c8b, #ff5b6f);
        border: none;
        border-radius: 50px;
        padding: 12px 25px;
        font-weight: 700;
        transition: all 0.4s ease;
        box-shadow: 0 10px 20px rgba(255, 124, 139, 0.3);
    }
    .auth-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(255, 124, 139, 0.45);
        background: linear-gradient(135deg, #ff5b6f, #ff7c8b);
    }
    .auth-btn-outline {
        background: transparent;
        border: 2px solid #ff7c8b;
        color: #ff7c8b;
        border-radius: 50px;
        padding: 10px 25px;
        font-weight: 700;
        transition: all 0.3s;
    }
    .auth-btn-outline:hover {
        background: #ff7c8b;
        color: white;
        box-shadow: 0 8px 15px rgba(255, 124, 139, 0.2);
    }
    .text-pink { color: #ff7c8b !important; }
    .hover-pink:hover { color: #ff7c8b !important; text-decoration: none; }
</style>
@endsection
