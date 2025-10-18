<?php

/*-----------------------------------------------------------
 | APPLICATION BOOTSTRAP FILE
 |-----------------------------------------------------------
 | 
 | Initializes the core Application instance with essential
 | configuration such as database, middleware, mail, sms,
 | user model, etc. Loads environment variables and 
 | helper functions as needed.
 |
 */

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/helpers.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

// Set global timezone for consistent timestamps
date_default_timezone_set('Asia/Manila');

$config = [
    'userModel'   => app\models\User::class,
    'db'          => require __DIR__ . '/../config/database.php',
    'mail'        => require __DIR__ . '/../config/mail.php',
    'sms'         => require __DIR__ . '/../config/sms.php',
    'middleware'  => require __DIR__ . '/../config/middleware.php',
    'performance' => require __DIR__ . '/../config/performance.php',
    'session'     => require __DIR__ . '/../config/session.php',
    'cache'       => require __DIR__ . '/../config/cache.php'
];

return new app\core\Application(dirname(__DIR__), $config);