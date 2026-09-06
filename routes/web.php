<?php
 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Middleware\ValidUser;
 
use App\Models\SiteSetting;
use App\Models\Slider;
use App\Http\Controllers\Backoffice\HomepageManagerController;
use App\Http\Controllers\Backoffice\CategoryController;
use App\Http\Controllers\Backoffice\ProductController;
use App\Http\Controllers\Backoffice\OrderController;

use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use Illuminate\Support\Facades\Artisan;

// Production Database Migration & Setup Helper Route
Route::get('/migrate-db', function () {
    try {
        Artisan::call('migrate', ['--force' => true]);
        $migrateOutput = Artisan::output();
        
        Artisan::call('db:seed', ['--class' => 'EcommerceSeeder', '--force' => true]);
        $seedOutput = Artisan::output();

        return "<div style='font-family: sans-serif; padding: 30px; line-height: 1.6; max-width: 800px; margin: 40px auto; border: 1px solid #ddd; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);'>
            <h2 style='color: #28a745;'>🎉 Database Migrations & Seeds Successful!</h2>
            <p>Your production MySQL database on InfinityFree has been updated with all latest tables and sample data.</p>
            <hr>
            <h4>Migration Log:</h4>
            <pre style='background: #f8f9fa; padding: 15px; border-radius: 8px; border: 1px solid #eee;'>" . e($migrateOutput) . "</pre>
            <h4>Seeder Log:</h4>
            <pre style='background: #f8f9fa; padding: 15px; border-radius: 8px; border: 1px solid #eee;'>" . e($seedOutput) . "</pre>
            <br>
            <a href='/' style='display: inline-block; background: #007bff; color: white; padding: 12px 24px; text-decoration: none; border-radius: 8px; font-weight: bold;'>Go to Homepage &rarr;</a>
        </div>";
    } catch (\Exception $e) {
        return "<div style='font-family: sans-serif; padding: 30px; line-height: 1.6; max-width: 800px; margin: 40px auto; border: 1px solid #dc3545; border-radius: 12px;'>
            <h2 style='color: #dc3545;'>⚠️ Error running migrations:</h2>
            <pre style='background: #fff3f3; padding: 15px; border-radius: 8px; border: 1px solid #f5c6cb; color: #721c24;'>" . e($e->getMessage()) . "\n\n" . e($e->getTraceAsString()) . "</pre>
        </div>";
    }
});

Route::get('/', function () {
    $settings = SiteSetting::first();
    $sliders = Slider::active()->orderBy('orders', 'asc')->get();
    $categories = App\Models\Category::where('status', 1)
        ->withCount('products')
        ->with(['products' => function ($query) {
            $query->where('status', 1)->orderBy('id', 'desc');
        }])
        ->orderBy('orders', 'asc')
        ->get();
    $products = App\Models\Product::where('status', 1)->orderBy('id', 'desc')->get();
    $featuredProducts = App\Models\Product::where('status', 1)->where('is_featured', 1)->orderBy('id', 'desc')->get();
    $dealProducts = App\Models\Product::where('status', 1)
        ->whereNotNull('compare_at_price')
        ->whereColumn('compare_at_price', '>', 'price')
        ->orderBy('id', 'desc')
        ->take(10)
        ->get();
    $recentPosts = App\Models\Post::where('status', 1)->orderBy('id', 'desc')->take(6)->get();
    $promoBanners = App\Models\PromoBanner::where('status', 1)->orderBy('sort_order', 'asc')->get();
    $testimonials = App\Models\Testimonial::where('status', 1)->orderBy('sort_order', 'asc')->orderBy('id', 'desc')->get();
    return view('frontend.index', compact('settings', 'sliders', 'categories', 'products', 'featuredProducts', 'dealProducts', 'recentPosts', 'promoBanners', 'testimonials'));
})->name('home');

// Storefront Shop & Catalog Routes
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/product/{slug}', [ShopController::class, 'show'])->name('shop.show');

// Storefront Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// Storefront Wishlist Routes
Route::get('/wishlist', [\App\Http\Controllers\Frontend\WishlistController::class, 'index'])->name('wishlist.index');
Route::post('/wishlist/add', [\App\Http\Controllers\Frontend\WishlistController::class, 'add'])->name('wishlist.add');
Route::get('/wishlist/remove/{id}', [\App\Http\Controllers\Frontend\WishlistController::class, 'remove'])->name('wishlist.remove');

// Storefront Compare Routes
Route::get('/compare', [\App\Http\Controllers\Frontend\CompareController::class, 'index'])->name('compare.index');
Route::post('/compare/add', [\App\Http\Controllers\Frontend\CompareController::class, 'add'])->name('compare.add');
Route::get('/compare/remove/{id}', [\App\Http\Controllers\Frontend\CompareController::class, 'remove'])->name('compare.remove');

// Storefront Checkout Routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/order-complete/{id}', [CheckoutController::class, 'complete'])->name('checkout.complete');

// Storefront Payment Routes
Route::get('/payment/{order_number}', [\App\Http\Controllers\Frontend\PaymentController::class, 'dummy'])->name('payment.dummy');
Route::post('/payment/process/{order_number}', [\App\Http\Controllers\Frontend\PaymentController::class, 'processDummy'])->name('payment.process');

// Storefront CMS Routes
Route::get('/blog', [\App\Http\Controllers\Frontend\PageController::class, 'blogIndex'])->name('blog.index');
Route::get('/blog/{slug}', [\App\Http\Controllers\Frontend\PageController::class, 'blogShow'])->name('blog.show');
Route::get('/page/{slug}', [\App\Http\Controllers\Frontend\PageController::class, 'pageShow'])->name('page.show');
Route::get('/about', function() {
    return redirect('/#about');
})->name('about');
Route::get('/contact', [\App\Http\Controllers\Frontend\PageController::class, 'contact'])->name('contact');
Route::post('/contact', [\App\Http\Controllers\Frontend\PageController::class, 'contactSubmit'])->name('contact.submit');

// Storefront Customer Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [\App\Http\Controllers\Frontend\CustomerAuthController::class, 'loginForm'])->name('customer.login');
    Route::post('/login', [\App\Http\Controllers\Frontend\CustomerAuthController::class, 'login'])->name('customer.login.submit');
    Route::get('/register', [\App\Http\Controllers\Frontend\CustomerAuthController::class, 'registerForm'])->name('customer.register');
    Route::post('/register', [\App\Http\Controllers\Frontend\CustomerAuthController::class, 'register'])->name('customer.register.submit');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Frontend\CustomerAuthController::class, 'logout'])->name('customer.logout');
    Route::get('/dashboard', [\App\Http\Controllers\Frontend\CustomerDashboardController::class, 'index'])->name('customer.dashboard');
});

// Public Backoffice Routes
Route::get('backoffice/login', function () {
    return view('backoffice.login');
})->name('login');

Route::post('LoginUser', [UserController::class, 'login'])->name('LoginUser');
Route::get('backoffice/logout', [UserController::class, 'logout'])->name('logout');

// Forgot / Reset Password Routes
Route::get('backoffice/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('backoffice/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('backoffice/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('backoffice/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');

// Protected Backoffice Routes
Route::middleware([ValidUser::class])->group(function () {
    Route::get('backoffice/dashboard', [UserController::class, 'dashboardPage'])->name('dashboard');

    // Dynamic Menu Logic route
    Route::get('backoffice/menu', [MenuController::class, 'getMenuCategory'])->name('menu.get');

    // Admin-only panel builder and admin management modules
    Route::middleware(['role:admin'])->group(function () {
        Route::get('menus/create', [MenuController::class, 'create'])->name('menus.create');
        Route::post('menus/store', [MenuController::class, 'store'])->name('menus.store');
        Route::get('menus/manage', [MenuController::class, 'manage'])->name('menus.manage');
        Route::get('menus/{menu}/edit', [MenuController::class, 'edit'])->name('menus.edit');
        Route::put('menus/{menu}', [MenuController::class, 'update'])->name('menus.update');
        Route::delete('menus/{menu}', [MenuController::class, 'destroy'])->name('menus.destroy');

        Route::get('users/create', [UserController::class, 'create'])->name('createUser');
        Route::post('users/store', [UserController::class, 'store'])->name('users.store');
        Route::get('users/manage', [UserController::class, 'manage'])->name('manageUser');

        Route::get('permissions', [PermissionController::class, 'index'])->name('permissions.index');
        Route::get('permissions/users/{user}', [PermissionController::class, 'editUser'])->name('permissions.editUser');
        Route::post('permissions/users/{user}', [PermissionController::class, 'updateUser'])->name('permissions.updateUser');

        // Homepage Manager routes
        Route::get('backoffice/homepage-manager', [HomepageManagerController::class, 'index'])->name('homepage.index');
        Route::post('backoffice/homepage-manager/settings', [HomepageManagerController::class, 'updateSettings'])->name('homepage.updateSettings');
        Route::get('backoffice/homepage-manager/sliders/create', [HomepageManagerController::class, 'createSlider'])->name('homepage.createSlider');
        Route::post('backoffice/homepage-manager/sliders', [HomepageManagerController::class, 'storeSlider'])->name('homepage.storeSlider');
        Route::get('backoffice/homepage-manager/sliders/{slider}/edit', [HomepageManagerController::class, 'editSlider'])->name('homepage.editSlider');
        Route::put('backoffice/homepage-manager/sliders/{slider}', [HomepageManagerController::class, 'updateSlider'])->name('homepage.updateSlider');
        Route::delete('backoffice/homepage-manager/sliders/{slider}', [HomepageManagerController::class, 'destroySlider'])->name('homepage.destroySlider');

        // Store Categories CRUD routes
        Route::get('backoffice/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::post('backoffice/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::put('backoffice/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('backoffice/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        // Store Products CRUD routes
        Route::get('backoffice/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('backoffice/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('backoffice/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('backoffice/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('backoffice/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('backoffice/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

        // Store Orders Tracker routes
        Route::get('backoffice/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('backoffice/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::put('backoffice/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

        // Stock Management routes
        Route::get('backoffice/stock', [\App\Http\Controllers\Backoffice\StockController::class, 'index'])->name('stock.index');
        Route::put('backoffice/stock/{product}', [\App\Http\Controllers\Backoffice\StockController::class, 'update'])->name('stock.update');

        // CMS Routes
        Route::resource('backoffice/pages', \App\Http\Controllers\Backoffice\PageController::class);
        Route::resource('backoffice/posts', \App\Http\Controllers\Backoffice\PostController::class);
        Route::resource('backoffice/promo_banners', \App\Http\Controllers\Backoffice\PromoBannerController::class);
        Route::resource('backoffice/testimonials', \App\Http\Controllers\Backoffice\TestimonialController::class);
        Route::resource('backoffice/contact-messages', \App\Http\Controllers\Backoffice\ContactMessageController::class);
        Route::post('backoffice/contact-messages/{contact_message}/toggle-read', [\App\Http\Controllers\Backoffice\ContactMessageController::class, 'toggleRead'])->name('contact-messages.toggle-read');
    });
});