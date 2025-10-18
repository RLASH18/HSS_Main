<?php

/**
 * Performance Configuration
 * 
 * Configuration for performance-related settings including
 * database optimizations and caching.
 */

return [
    /*
    |--------------------------------------------------------------------------
    | Database Persistent Connections
    |--------------------------------------------------------------------------
    |
    | Enable persistent database connections for better performance.
    | Persistent connections are reused across requests, reducing
    | connection overhead by 50-70%.
    |
    */
    'db_persistent' => env('DB_PERSISTENT', 'true') === 'true',

    /*
    |--------------------------------------------------------------------------
    | Database Emulate Prepares
    |--------------------------------------------------------------------------
    |
    | Whether to use emulated prepared statements or real ones.
    | Set to false for better performance and security.
    |
    */
    'db_emulate_prepares' => env('DB_EMULATE_PREPARES', 'false') === 'true',

    /*
    |--------------------------------------------------------------------------
    | Database Default Fetch Mode
    |--------------------------------------------------------------------------
    |
    | Default PDO fetch mode for database queries.
    | Options: FETCH_ASSOC, FETCH_OBJ, FETCH_BOTH
    |
    */
    'db_fetch_mode' => \PDO::FETCH_ASSOC,

    /*
    |--------------------------------------------------------------------------
    | Database Charset
    |--------------------------------------------------------------------------
    |
    | Character set and collation for database connections.
    |
    */
    'db_charset' => env('DB_CHARSET', 'utf8mb4'),
    'db_collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
];
