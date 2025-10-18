<?php

/**
 * Cache Configuration
 * 
 * Configuration for the application's caching system.
 */

return [
    /*
    |--------------------------------------------------------------------------
    | Cache Enabled
    |--------------------------------------------------------------------------
    |
    | Enable or disable the caching system. Set to false to disable all
    | caching operations (useful for debugging).
    |
    */
    'enabled' => env('CACHE_ENABLED', 'true') === 'true',

    /*
    |--------------------------------------------------------------------------
    | Default Cache TTL
    |--------------------------------------------------------------------------
    |
    | Default time-to-live for cached items in seconds.
    | Default: 300 seconds (5 minutes)
    |
    */
    'default_ttl' => (int) env('CACHE_DEFAULT_TTL', 300),

    /*
    |--------------------------------------------------------------------------
    | Cache Directory
    |--------------------------------------------------------------------------
    |
    | Directory where cache files will be stored.
    | Relative to the application root directory.
    |
    */
    'cache_dir' => '/runtime/cache',
];
