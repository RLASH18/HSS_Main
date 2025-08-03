<?php

/*-----------------------------------------------------------
 | MIDDLEWARE ALIASES CONFIGURATION
 |-----------------------------------------------------------
 | 
 | This file maps middleware aliases to their class handlers.
 | These aliases can be used in route definitions to assign
 | middleware in a clean and readable way.
 |
 */

return [
    'admin'  => app\core\middlewares\AdminMiddleware::class,
    'auth'  => app\core\middlewares\AuthMiddleware::class,
    'guest' => app\core\middlewares\GuestMiddleware::class,
    'csrf'  => app\core\middlewares\CsrfMiddleware::class
];
