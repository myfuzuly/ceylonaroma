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
use App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\SliderController;

/* ─── Frontend ─── */
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');
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

        Route::resource('/users', Admin\UserController::class)->except(['show']);

        Route::get('/settings',  [Admin\SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [Admin\SettingController::class, 'update'])->name('settings.update');
    });
});
