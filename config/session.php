<?php

/**
 * Session Configuration
 * 
 * Configuration for session management and security.
 */

return [
    /*
    |--------------------------------------------------------------------------
    | Session Lifetime
    |--------------------------------------------------------------------------
    |
    | Session lifetime in seconds. After this time, the session will expire.
    | Default: 3600 seconds (1 hour)
    |
    */
    'lifetime' => (int) env('SESSION_LIFETIME', 3600),

    /*
    |--------------------------------------------------------------------------
    | Session Cookie Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for session cookies including security settings.
    |
    */
    'cookie' => [
        'lifetime' => 0, // Session cookie (expires when browser closes)
        'path' => '/',
        'domain' => '',
        'secure' => env('APP_ENV', 'development') === 'production', // HTTPS only in production
        'httponly' => true, // Prevent JavaScript access
        'samesite' => 'Lax', // CSRF protection
    ],

    /*
    |--------------------------------------------------------------------------
    | Garbage Collection
    |--------------------------------------------------------------------------
    |
    | Probability and divisor for session garbage collection.
    | Probability/Divisor = chance of cleanup (e.g., 1/100 = 1%)
    |
    */
    'gc_probability' => (int) env('SESSION_GC_PROBABILITY', 1),
    'gc_divisor' => (int) env('SESSION_GC_DIVISOR', 100),

    /*
    |--------------------------------------------------------------------------
    | Session Save Path
    |--------------------------------------------------------------------------
    |
    | Directory where session files will be stored.
    | Relative to the application root directory.
    |
    */
    'save_path' => '/runtime/sessions',

    /*
    |--------------------------------------------------------------------------
    | Session Save Handler
    |--------------------------------------------------------------------------
    |
    | Handler for session storage. Default is 'files'.
    | Options: files, memcached, redis
    |
    */
    'save_handler' => env('SESSION_DRIVER', 'files'),
];
