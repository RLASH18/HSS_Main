<?php

use app\controllers\AuthController;
use app\controllers\HomeController;
use app\core\Route;

Route::group(['middleware' => 'guest'], function () {
    Route::controller(AuthController::class, function () {
        Route::get('/login', 'login');
        Route::post('/loginForm', 'loginForm');
        Route::get('/register', 'register');
        Route::post('/registerForm', 'registerForm');
    });
});

Route::group(['middleware' => 'auth'], function () {
    Route::controller(HomeController::class, function () {
        Route::get('/home', 'index');
        Route::get('/contact', 'contact');
        Route::post('/contactForm', 'contactForm');
        Route::get('/profile', 'profile');
        Route::get('/logout', 'logout');
    });
});
