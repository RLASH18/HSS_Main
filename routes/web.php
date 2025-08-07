<?php

use app\controllers\InventoryController;
use app\controllers\AuthController;
use app\controllers\BillingController;
use app\controllers\DeliveryController;
use app\controllers\OrdersController;
use app\core\Route;

Route::group(['middleware' => 'guest'], function () {
    Route::view('/', 'welcome');
    Route::controller(AuthController::class, function () {
        Route::get('/login', 'login');
        Route::post('/loginForm', 'loginForm');
        Route::get('/register', 'register');
        Route::post('/registerForm', 'registerForm');
        Route::get('/verify-email', 'showVerifyEmail');
        Route::post('/verify-email-code', 'verifyEmail');
    });
});

Route::group(['middleware' => 'admin', 'prefix' => '/admin'], function () {
    Route::controller(InventoryController::class, function () {
        Route::get('/inventory', 'index');
        Route::get('/inventory/add', 'create');
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

Route::group(['middleware' => 'auth'], function () {});
