<?php

use app\controllers\InventoryController;
use app\controllers\AuthController;
use app\core\Route;

Route::group(['middleware' => 'guest'], function () {
    Route::controller(AuthController::class, function () {
        Route::get('/login', 'login');
        Route::post('/loginForm', 'loginForm');
        Route::get('/register', 'register');
        Route::post('/registerForm', 'registerForm');
    });
});

Route::group(['middleware' => 'auth', 'prefix' => '/admin'], function () {
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
});