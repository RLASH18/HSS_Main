<?php

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