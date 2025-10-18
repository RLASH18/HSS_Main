<?php

/*-----------------------------------------------------------
 | DATABASE CONFIGURATION FILE
 |-----------------------------------------------------------
 | 
 | This file returns an associative array with the
 | necessary connection details for the PDO instance.
 | It uses environment variables (from .env) for security
 | and flexibility between environments.
 |
 */

return [
    'dsn'      => env('DB_CONNECTION') . ":host=" . env('DB_HOST') . ";port=" . env('DB_PORT') . ";dbname=" . env('DB_DATABASE'),
    'user'     => env('DB_USERNAME'),
    'password' => env('DB_PASSWORD'),
    
    // Performance configuration
    'performance' => [
        'db_persistent'        => env('DB_PERSISTENT', 'false') === 'true',
        'db_emulate_prepares'  => env('DB_EMULATE_PREPARES', 'false') === 'true',
        'db_fetch_mode'        => \PDO::FETCH_ASSOC,
        'db_charset'           => env('DB_CHARSET', 'utf8mb4'),
        'db_collation'         => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
    ]
];