<?php

use app\controllers\AuthController;
use app\controllers\admin\AdminController;
use app\controllers\admin\BillingController;
use app\controllers\admin\DeliveryController;
use app\controllers\admin\InventoryController;
use app\controllers\admin\OrdersController;
use app\controllers\customer\CartController;
use app\controllers\customer\CheckoutController;
use app\controllers\customer\CustomerController;
use app\core\Route;

/**
 * Guest Routes
 */
Route::group(['middleware' => 'guest'], function () {
    Route::view('/', 'welcome');
    Route::post('/set-location-session', [AuthController::class, 'setLocationSession']);
    Route::group(['middleware' => 'location'], function () {
        Route::controller(AuthController::class, function () {
            Route::get('/login', 'login');
            Route::post('/loginForm', 'loginForm');
            Route::get('/register', 'register');
            Route::post('/registerForm', 'registerForm');
            Route::get('/verify-email', 'showVerifyEmail');
            Route::post('/verify-email-code', 'verifyEmail');
        });
    });
});

/**
 * Admin Routes
 */
Route::group(['middleware' => 'admin', 'prefix' => '/admin'], function () {
    Route::controller(AdminController::class, function () {
        Route::get('/dashboard', 'dashboard');
        Route::get('/settings', 'settings');
        Route::post('/logout', 'logout');
    });

    Route::controller(InventoryController::class, function () {
        Route::get('/inventory', 'index');
        Route::get('/inventory/create', 'create');
        Route::post('/inventory/store', 'store');
        Route::get('/inventory/show/{id}', 'show');
        Route::get('/inventory/edit/{id}', 'edit');
        Route::post('/inventory/update/{id}', 'update');
        Route::get('/inventory/delete/{id}', 'delete');
        Route::post('/inventory/destroy/{id}', 'destroy');
    });

    Route::controller(OrdersController::class, function () {
        Route::get('/orders', 'index');
        Route::get('/orders/{id}', 'show');
        Route::post('/orders/{id}/update-status', 'updateStatus');
        Route::post('/orders/{id}/cancel', 'cancel');
    });

    Route::controller(BillingController::class, function () {
        Route::get('/billings', 'index');
        Route::get('/billings/show/{id}', 'show');
    });

    Route::controller(DeliveryController::class, function () {
        Route::get('/delivery', 'index');
        Route::get('/delivery/create', 'create');
        Route::post('/delivery/store', 'store');
        Route::get('/delivery/show/{id}', 'show');
        Route::get('/delivery/edit/{id}', 'edit');
        Route::post('/delivery/update/{id}', 'update');
        Route::get('/delivery/delete/{id}', 'delete');
        Route::post('/delivery/destroy/{id}', 'destroy');
    });
});

/**
 * Auth Routes
 */
Route::group(['middleware' => 'auth', 'prefix' => '/customer'], function () {
    Route::controller(CustomerController::class, function () {
        Route::get('/home', 'index');
        Route::get('/home/category/{category}', 'categoryFilter');
        Route::get('/item/{id}', 'show');
        Route::get('/my-orders', 'orders');
        Route::get('/profile', 'profile');
        Route::get('/edit-profile', 'editProfile');
        Route::post('/update-profile', 'updateProfile');
        Route::post('/logout', 'logout');
    });

    Route::controller(CartController::class, function () {
        Route::get('/my-cart', 'index');
        Route::post('/add-to-cart', 'store');
        Route::post('/update-cart', 'update');
        Route::post('/delete-cart', 'delete');
    });

    Route::controller(CheckoutController::class, function () {
        Route::get('/checkout/{id}', 'checkout');
        Route::post('/place-order', 'placeOrder');
        Route::post('/buy-now', 'buyNow');
        Route::post('/process-buy-now', 'processBuyNow');
        Route::get('/payment-success', 'paymentSuccess');
        Route::get('/payment-failed', 'paymentFailed');
    });
});

Route::post('/webhook/paymongo', [CheckoutController::class, 'paymentWebhook']);
