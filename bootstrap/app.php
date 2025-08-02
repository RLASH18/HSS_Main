<?php

/*-----------------------------------------------------------
 | APPLICATION BOOTSTRAP FILE
 |-----------------------------------------------------------
 | 
 | Initializes the core Application instance with essential
 | configuration such as database, middleware, mail,
 | and user model. Loads environment variables and 
 | helper functions as needed.
 |
 */

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/helpers.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$config = [
    'userModel'  => app\models\User::class,
    'db'         => require __DIR__ . '/../config/database.php',
    'mail'       => require __DIR__ . '/../config/mail.php',
    'middleware' => require __DIR__ . '/../config/middleware.php'
];

return new app\core\Application(dirname(__DIR__), $config);