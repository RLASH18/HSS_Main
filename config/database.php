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
    'password' => env('DB_PASSWORD')
];