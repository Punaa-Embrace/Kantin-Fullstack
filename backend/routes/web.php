<?php

use App\Http\Controllers\Admin\BuildingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TenantController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student\CartController;
use App\Http\Controllers\Student\MenuController;
use App\Http\Controllers\Student\OrderController as StudentOrderController;
use App\Http\Controllers\Tenant\OrderController as TenantOrderController;
use App\Http\Controllers\Student\PaymentController;
use App\Http\Controllers\Student\TenantController as StudentTenantController;
use App\Http\Controllers\Tenant\MenuItemController;
use App\Http\Controllers\Tenant\StandController;
use App\Http\Middleware\IsAdminMiddleware;
use App\Http\Middleware\IsTenantManagerMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingPageController::class, 'index'])->name('welcome');


Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);

    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);

    Route::get('otp', [AuthController::class, 'showOtpForm'])->name('otp.form');
    Route::post('otp/verify', [AuthController::class, 'verifyOtp'])->name('otp.verify');
    Route::post('otp/resend', [AuthController::class, 'resendOtp'])->name('otp.resend');

    Route::get('forget-password', [AuthController::class, 'showForgetPasswordForm'])->name('password.request');
    Route::post('forget-password', [AuthController::class, 'sendResetOtp'])->name('password.email');
    Route::get('reset-password', [AuthController::class, 'showNewPasswordForm'])->name('password.reset');
    Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.reset.update');
});


Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');

    Route::prefix('admin')
        ->name('admin.')
        ->middleware(IsAdminMiddleware::class)
        ->group(function () {
            Route::resource('users', UserController::class);
            Route::resource('buildings', BuildingController::class);
            Route::resource('tenants', TenantController::class);
            Route::resource('categories', CategoryController::class);
        });

    Route::prefix('tenant')
        ->name('tenant.')
        ->middleware(IsTenantManagerMiddleware::class)
        ->group(function () {
            Route::get('/stand/edit', [StandController::class, 'edit'])->name('stand.edit');
            Route::put('/stand/update', [StandController::class, 'update'])->name('stand.update');
            Route::resource('menu-items', MenuItemController::class);

            Route::get('/orders', [TenantOrderController::class, 'index'])->name('orders.index');
            Route::get('/orders/{order}', [TenantOrderController::class, 'show'])->name('orders.show');
            Route::patch('/orders/{order}/status', [TenantOrderController::class, 'updateStatus'])->name('orders.updateStatus');
        });

    Route::prefix('student')
        ->name('student.')
        ->group(function () {
            Route::get('/tenants', [StudentTenantController::class, 'index'])->name('tenants.index');
            Route::get('/stand/{tenant:slug}', [StudentTenantController::class, 'show'])->name('tenants.show');
            Route::get('/menus', [MenuController::class, 'index'])->name('menus.index');

            Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
            Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

            Route::get('/orders', [StudentOrderController::class, 'index'])->name('orders.index');
            Route::get('/orders/{order}', [StudentOrderController::class, 'show'])->name('orders.show');

            Route::get('/payment/qris', [PaymentController::class, 'showQris'])->name('payment.qris');
            Route::post('/payment/proof/{order_code}', [PaymentController::class, 'storeProof'])->name('payment.store_proof');
        });
});
