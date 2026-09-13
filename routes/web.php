<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PayHereController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\WholesalePriceController;
use App\Http\Controllers\LegacyRedirectController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\SliderController;

/* ─── Legacy WordPress URLs → 301 redirects (pre-migration site) ─── */
Route::get('/product/{slug}', [LegacyRedirectController::class, 'product']);
Route::get('/category/{a}/{b?}/{c?}', [LegacyRedirectController::class, 'category']);
Route::get('/tag/{slug?}', [LegacyRedirectController::class, 'tag']);
Route::get('/author/{slug?}', fn() => redirect('/', 301));
Route::get('/product-brand/{slug?}', fn() => redirect()->route('products.index', [], 301));
Route::get('/true-ceylon-cinnamon-the-worlds-finest-cinnamon', fn() => redirect()->route('blog.index', [], 301));
Route::get('/ceylon-coffee-discover-sri-lankas-hidden-coffee-heritage', fn() => redirect()->route('blog.index', [], 301));
Route::get('/ceylon-black-pepper-the-king-of-spices-from-sri-lanka', fn() => redirect()->route('blog.index', [], 301));

/* ─── Renamed product slugs (pre-cleanup) → 301 redirects — must precede {product:slug} ─── */
Route::get('/products/refined-carrier-oils-carrier-oils', fn() => redirect()->route('products.show', 'refined-carrier-oils', 301));
Route::get('/products/herbal-powder-blends-herbal-powders', fn() => redirect()->route('products.show', 'herbal-powder-blends', 301));
Route::get('/products/cinnamon-cut-cinnamon-cut', fn() => redirect()->route('products.show', 'cinnamon-cut', 301));
Route::get('/products/traditional-sri-lankan-foods-dehydrated-foods', fn() => redirect()->route('products.show', 'traditional-sri-lankan-foods', 301));
Route::get('/products/ceylon-black-tea-op-grade-black-tea', fn() => redirect()->route('products.show', 'ceylon-black-tea', 301));
Route::get('/products/flavoured-ceylon-tea-flavoured-tea', fn() => redirect()->route('products.category', 'flavored-tea', 301));

/* ─── Frontend ─── */
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/category/{category:slug}', [ProductController::class, 'index'])->name('products.category');
Route::get('/products-suggest', [ProductController::class, 'suggestions'])->name('products.suggestions');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/wholesale-prices', [WholesalePriceController::class, 'index'])->name('wholesale-prices.index');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{blog_post:slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/contact', [InquiryController::class, 'show'])->name('contact');
Route::post('/inquiry', [InquiryController::class, 'store'])->name('inquiry.store')->middleware('throttle:5,10');
Route::get('/about', fn() => view('pages.about'))->name('about');
Route::get('/export', fn() => view('pages.export'))->name('export');
Route::get('/quality', fn() => view('pages.quality'))->name('quality');
Route::get('/private-label', fn() => view('pages.private-label'))->name('private-label');
Route::get('/privacy-policy', fn() => view('pages.privacy'))->name('privacy');
Route::get('/terms-conditions', fn() => view('pages.terms'))->name('terms');
Route::get('/return-policy', fn() => view('pages.returns'))->name('returns');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/wishlist', fn() => view('wishlist'))->name('wishlist');

/* ─── Cart ─── */
Route::get('/cart',              [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add',         [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update',      [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove',      [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear',       [CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/count',        [CartController::class, 'count'])->name('cart.count');

/* ─── Checkout & Orders ─── */
Route::get('/checkout',          [OrderController::class, 'checkout'])->name('checkout');
Route::post('/checkout',         [OrderController::class, 'store'])->name('checkout.store');
Route::get('/order/{orderNumber}',[OrderController::class, 'confirmation'])->name('order.confirmation');

/* ─── PayHere ─── */
Route::post('/payhere/init',     [PayHereController::class, 'initiate'])->name('checkout.payhere.init');
Route::post('/payhere/notify',   [PayHereController::class, 'notify'])->name('payhere.notify')->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
Route::get('/payhere/return',    [PayHereController::class, 'returnUrl'])->name('payhere.return');
Route::get('/payhere/cancel',    [PayHereController::class, 'cancelUrl'])->name('payhere.cancel');

/* ─── Customer Auth ─── */
Route::prefix('account')->name('customer.')->group(function () {
    Route::get('/login',            [CustomerAuthController::class, 'showLogin'])->name('login');
    Route::post('/login',           [CustomerAuthController::class, 'login'])->name('login.post')->middleware('throttle:5,5');
    Route::get('/register',         [CustomerAuthController::class, 'showRegister'])->name('register');
    Route::post('/register',        [CustomerAuthController::class, 'register'])->name('register.post')->middleware('throttle:8,10');
    Route::post('/logout',          [CustomerAuthController::class, 'logout'])->name('logout');
    Route::get('/auth/google',      [CustomerAuthController::class, 'redirectToGoogle'])->name('google');
    Route::get('/auth/google/callback', [CustomerAuthController::class, 'handleGoogleCallback'])->name('google.callback');
    Route::get('/otp/phone',        [CustomerAuthController::class, 'showPhoneLogin'])->name('otp.phone');
    Route::post('/otp/send',        [CustomerAuthController::class, 'sendOtp'])->name('otp.send')->middleware('throttle:5,5');
    Route::get('/otp/verify',       [CustomerAuthController::class, 'showVerifyOtp'])->name('otp.verify');
    Route::post('/otp/verify',      [CustomerAuthController::class, 'verifyOtp'])->name('otp.verify.post')->middleware('throttle:5,5');

    /* ─── Forgot / Reset Password ─── */
    Route::get('/forgot-password',   [CustomerAuthController::class, 'showForgotPassword'])->name('forgot-password');
    Route::post('/forgot-password',  [CustomerAuthController::class, 'sendResetLink'])->name('forgot-password.post')->middleware('throttle:5,10');
    Route::get('/reset-password',    [CustomerAuthController::class, 'showResetPassword'])->name('reset-password');
    Route::post('/reset-password',   [CustomerAuthController::class, 'resetPassword'])->name('reset-password.post');

    /* ─── Customer Protected ─── */
    Route::middleware('customer.auth')->group(function () {
        Route::get('/dashboard',        [CustomerController::class, 'dashboard'])->name('dashboard');
        Route::get('/orders',           [CustomerController::class, 'orders'])->name('orders');
        Route::get('/orders/{orderNumber}', [CustomerController::class, 'orderShow'])->name('order.show');
        Route::get('/profile',          [CustomerController::class, 'profile'])->name('profile');
        Route::patch('/profile',        [CustomerController::class, 'updateProfile'])->name('profile.update');
        Route::patch('/password',       [CustomerController::class, 'updatePassword'])->name('password.update');
    });
});

/* ─── Admin Auth ─── */
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login',  [Admin\AuthController::class, 'login'])->name('login');
    Route::post('/login', [Admin\AuthController::class, 'authenticate'])->name('authenticate')->middleware('throttle:5,5');
    Route::post('/logout',[Admin\AuthController::class, 'logout'])->name('logout');

    /* ─── Admin Protected ─── */
    Route::middleware('admin.auth')->group(function () {
        Route::get('/', fn() => redirect()->route('admin.dashboard'));
        Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

        Route::resource('/products',   Admin\ProductController::class);
        Route::resource('/categories', Admin\CategoryController::class)->except(['show']);
        Route::resource('/collections',Admin\CollectionController::class)->except(['show']);
        Route::resource('/blog',       Admin\BlogController::class)->except(['show']);

        Route::prefix('/inquiries')->name('inquiries.')->group(function () {
            Route::get('/',                 [Admin\InquiryController::class, 'index'])->name('index');
            Route::get('/{inquiry}',        [Admin\InquiryController::class, 'show'])->name('show');
            Route::patch('/{inquiry}/status',[Admin\InquiryController::class, 'updateStatus'])->name('status');
            Route::delete('/{inquiry}',     [Admin\InquiryController::class, 'destroy'])->name('destroy');
        });

        Route::resource('/sliders', Admin\SliderController::class)->except(['show']);
        Route::post('/sliders/reorder', [Admin\SliderController::class, 'reorder'])->name('sliders.reorder');

        Route::prefix('/customers')->name('customers.')->group(function () {
            Route::get('/',                         [Admin\CustomerController::class, 'index'])->name('index');
            Route::get('/{customer}',               [Admin\CustomerController::class, 'show'])->name('show');
            Route::patch('/{customer}/toggle',      [Admin\CustomerController::class, 'toggleStatus'])->name('toggle');
            Route::delete('/{customer}',            [Admin\CustomerController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('/orders')->name('orders.')->group(function () {
            Route::get('/',                    [Admin\OrderController::class, 'index'])->name('index');
            Route::get('/{order}',             [Admin\OrderController::class, 'show'])->name('show');
            Route::patch('/{order}/status',    [Admin\OrderController::class, 'updateStatus'])->name('status');
        });

        Route::prefix('/wholesale-prices')->name('wholesale-prices.')->group(function () {
            Route::get('/',           [Admin\WholesalePriceController::class, 'index'])->name('index');
            Route::post('/',          [Admin\WholesalePriceController::class, 'store'])->name('store');
            Route::delete('/{wholesalePrice}', [Admin\WholesalePriceController::class, 'destroy'])->name('destroy');
        });

        Route::resource('/users', Admin\UserController::class)->except(['show']);

        Route::get('/settings',  [Admin\SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [Admin\SettingController::class, 'update'])->name('settings.update');
    });
});
