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
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\DeliveryController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function () {
    
    // ==================== PUBLIC ENDPOINTS ====================
    Route::get('test', function () {
        return response()->json([
            'success' => true,
            'message' => 'API is working!',
            'timestamp' => now()
        ]);
    });

    // Authentication
    Route::post('login', [AuthController::class, 'loginApi']);
    Route::post('register', [AuthController::class, 'registerApi']);
    Route::post('logout', [AuthController::class, 'logoutApi'])->middleware('auth:sanctum');
    
    // Notification routes
    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationController::class, 'apiIndex']);
        Route::post('/send', [NotificationController::class, 'apiSendNotification']);
        Route::put('/{id}/read', [NotificationController::class, 'apiMarkAsRead']);
        Route::put('/read-all', [NotificationController::class, 'apiMarkAllAsRead']);
        Route::get('/unread-count', [NotificationController::class, 'apiUnreadCount']);
        Route::delete('/{id}', [NotificationController::class, 'apiDestroy']);
        Route::post('/update-fcm-token', [NotificationController::class, 'apiUpdateFcmToken']);
    });

    // Delivery routes
    Route::prefix('delivery')->group(function () {
        Route::get('/track/{order_code}', [DeliveryController::class, 'apiTrackOrder']);
        Route::post('/update-location', [DeliveryController::class, 'apiUpdateLocation']);
        Route::get('/driver/{order_code}', [DeliveryController::class, 'apiGetDriver']);
        Route::get('/estimation/{order_code}', [DeliveryController::class, 'apiGetEstimation']);
        Route::patch('/{order_code}/status', [DeliveryController::class, 'apiUpdateStatus']);
        Route::get('/{order_code}/history', [DeliveryController::class, 'apiGetDeliveryHistory']);
    });

    // Password Reset
    Route::post('forgot-password', [AuthController::class, 'sendResetOtpApi']);
    Route::post('reset-password', [AuthController::class, 'resetPasswordApi']);

    // Public Data
    Route::get('landing', [LandingPageController::class, 'apiIndex']);
    Route::get('tenants', [StudentTenantController::class, 'apiIndex']);
    Route::get('tenants/{tenant:slug}', [StudentTenantController::class, 'apiShow']);
    Route::get('menus', [MenuController::class, 'apiIndex']);
    Route::get('categories', [CategoryController::class, 'apiIndex']);
    Route::get('buildings', [BuildingController::class, 'apiIndex']);

    // ==================== PROTECTED ENDPOINTS ====================
    Route::middleware('auth:sanctum')->group(function () {
        
        // User & Profile
        Route::get('user', [AuthController::class, 'getUser']);
        Route::get('profile', [ProfileController::class, 'apiShow']);
        Route::put('profile', [ProfileController::class, 'apiUpdate']);
        Route::put('password', [ProfileController::class, 'apiUpdatePassword']);

        // Dashboard
        Route::get('dashboard', [DashboardController::class, 'apiIndex']);

        // ========== STUDENT ENDPOINTS ==========
        Route::prefix('student')->group(function () {
            // Cart Management
            Route::get('cart', [CartController::class, 'apiIndex']);
            Route::post('cart/add', [CartController::class, 'apiAddItem']);
            Route::put('cart/update/{cartItem}', [CartController::class, 'apiUpdateItem']);
            Route::delete('cart/remove/{cartItem}', [CartController::class, 'apiRemoveItem']);
            Route::delete('cart/clear', [CartController::class, 'apiClear']);
            
            // Orders
            Route::post('orders/checkout', [CartController::class, 'apiCheckout']);
            Route::get('orders', [StudentOrderController::class, 'apiIndex']);
            Route::get('orders/{order}', [StudentOrderController::class, 'apiShow']);
            Route::post('orders/{order}/cancel', [StudentOrderController::class, 'apiCancel']);
            
            // Payment
            Route::get('payment/{order_code}/qris', [PaymentController::class, 'apiShowQris']);
            Route::get('payment/{order_code}/virtual-account', [PaymentController::class, 'apiVirtualAccount']);
            Route::post('payment/{order_code}/proof', [PaymentController::class, 'apiStoreProof']);
            Route::get('payment/{order_code}/status', [PaymentController::class, 'apiCheckStatus']);
        });

        // ========== TENANT ENDPOINTS ==========
        Route::prefix('tenant')->middleware(IsTenantManagerMiddleware::class)->group(function () {
            // Stand Management
            Route::get('stand', [StandController::class, 'apiShow']);
            Route::put('stand', [StandController::class, 'apiUpdate']);
            
            // Menu Items
            Route::apiResource('menu-items', MenuItemController::class);
            
            // Orders
            Route::get('orders', [TenantOrderController::class, 'apiIndex']);
            Route::get('orders/{order}', [TenantOrderController::class, 'apiShow']);
            Route::patch('orders/{order}/status', [TenantOrderController::class, 'apiUpdateStatus']);
            Route::post('orders/{order}/ready', [TenantOrderController::class, 'apiMarkReady']);
        });

        // ========== ADMIN ENDPOINTS ==========
        Route::prefix('admin')->middleware(IsAdminMiddleware::class)->group(function () {
            Route::apiResource('users', UserController::class);
            Route::apiResource('buildings', BuildingController::class);
            Route::apiResource('tenants', TenantController::class);
            Route::apiResource('categories', CategoryController::class);
            
            // Reports
            Route::get('reports/orders', [TenantOrderController::class, 'apiOrderReports']);
            Route::get('reports/sales', [TenantOrderController::class, 'apiSalesReports']);
        });

        // ========== DELIVERY & NOTIFICATION ==========
        Route::prefix('delivery')->group(function () {
            Route::get('track/{order_code}', [DeliveryController::class, 'apiTrackOrder']);
            Route::post('update-location', [DeliveryController::class, 'apiUpdateLocation']);
            Route::get('driver/{order_code}', [DeliveryController::class, 'apiGetDriver']);
        });

        Route::prefix('notifications')->group(function () {
            Route::get('/', [NotificationController::class, 'apiIndex']);
            Route::post('send', [NotificationController::class, 'apiSendNotification']);
            Route::put('{notification}/read', [NotificationController::class, 'apiMarkAsRead']);
            Route::get('unread-count', [NotificationController::class, 'apiUnreadCount']);
        });
    });
});