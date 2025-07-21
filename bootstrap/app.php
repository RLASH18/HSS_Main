<?php

// ------------------------------------------------------
// APPLICATION BOOTSTRAP FILE
// ------------------------------------------------------
// This file initializes and returns the Application instance.
// It loads the environment variables, helper functions, and
// configuration needed to start the app.
// ------------------------------------------------------

use app\core\Application;
use app\models\User;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/helpers.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$config = [
    'userClass' => User::class,
    'db' => require __DIR__ . '/../config/database.php'
];

return new Application(dirname(__DIR__), $config);