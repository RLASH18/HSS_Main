<?php

namespace app\core;

/**
 * Class Cache
 *
 * Simple file-based caching system for production performance.
 * Stores cached data in the runtime/cache directory with TTL support.
 * 
 * Usage:
 *   Cache::set('key', $data, 3600); // Cache for 1 hour
 *   $data = Cache::get('key');
 *   Cache::delete('key');
 *   Cache::clear(); // Clear all cache
 */
class Cache
{
    /** @var string Cache directory path */
    private static string $cacheDir;

    /** @var bool Whether caching is enabled */
    private static bool $enabled = true;

    /**
     * Initialize cache directory
     */
    private static function init(): void
    {
        if (!isset(self::$cacheDir)) {
            // Get cache configuration from Application
            $cacheConfig = Application::$app->config['cache'] ?? [];
            
            // Set cache directory
            $cacheDir = $cacheConfig['cache_dir'] ?? '/runtime/cache';
            self::$cacheDir = Application::$ROOT_DIR . $cacheDir;
            
            // Check if caching is enabled
            self::$enabled = $cacheConfig['enabled'] ?? true;
            
            // Create cache directory if it doesn't exist
            if (self::$enabled && !is_dir(self::$cacheDir)) {
                mkdir(self::$cacheDir, 0775, true);
            }
        }
    }

    /**
     * Store data in cache with optional TTL (time to live)
     *
     * @param string $key Cache key
     * @param mixed $data Data to cache
     * @param int $ttl Time to live in seconds (default: 3600 = 1 hour)
     * @return bool Success status
     */
    public static function set(string $key, $data, int $ttl = 3600): bool
    {
        self::init();
        
        if (!self::$enabled) {
            return false;
        }

        $filename = self::getFilename($key);
        $cacheData = [
            'expires' => time() + $ttl,
            'data' => $data
        ];

        return file_put_contents($filename, serialize($cacheData), LOCK_EX) !== false;
    }

    /**
     * Retrieve data from cache
     *
     * @param string $key Cache key
     * @param mixed $default Default value if cache miss
     * @return mixed Cached data or default value
     */
    public static function get(string $key, $default = null)
    {
        self::init();
        
        if (!self::$enabled) {
            return $default;
        }

        $filename = self::getFilename($key);

        if (!file_exists($filename)) {
            return $default;
        }

        $cacheData = unserialize(file_get_contents($filename));

        // Check if cache has expired
        if ($cacheData['expires'] < time()) {
            self::delete($key);
            return $default;
        }

        return $cacheData['data'];
    }

    /**
     * Check if a cache key exists and is not expired
     *
     * @param string $key Cache key
     * @return bool
     */
    public static function has(string $key): bool
    {
        self::init();
        
        if (!self::$enabled) {
            return false;
        }

        $filename = self::getFilename($key);

        if (!file_exists($filename)) {
            return false;
        }

        $cacheData = unserialize(file_get_contents($filename));

        // Check if expired
        if ($cacheData['expires'] < time()) {
            self::delete($key);
            return false;
        }

        return true;
    }

    /**
     * Delete a specific cache entry
     *
     * @param string $key Cache key
     * @return bool Success status
     */
    public static function delete(string $key): bool
    {
        self::init();
        
        if (!self::$enabled) {
            return false;
        }

        $filename = self::getFilename($key);

        if (file_exists($filename)) {
            return unlink($filename);
        }

        return false;
    }

    /**
     * Clear all cache entries
     *
     * @return bool Success status
     */
    public static function clear(): bool
    {
        self::init();
        
        if (!self::$enabled) {
            return false;
        }

        $files = glob(self::$cacheDir . '/*.cache');
        
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }

        return true;
    }

    /**
     * Remember a value - get from cache or execute callback and cache result
     *
     * @param string $key Cache key
     * @param int $ttl Time to live in seconds
     * @param callable $callback Function to execute if cache miss
     * @return mixed Cached or fresh data
     */
    public static function remember(string $key, int $ttl, callable $callback)
    {
        self::init();
        
        if (!self::$enabled) {
            return $callback();
        }

        // Try to get from cache
        if (self::has($key)) {
            return self::get($key);
        }

        // Execute callback and cache result
        $data = $callback();
        self::set($key, $data, $ttl);

        return $data;
    }

    /**
     * Get cache filename for a given key
     *
     * @param string $key Cache key
     * @return string Full path to cache file
     */
    private static function getFilename(string $key): string
    {
        return self::$cacheDir . '/' . md5($key) . '.cache';
    }

    /**
     * Clean up expired cache entries
     *
     * @return int Number of deleted entries
     */
    public static function cleanup(): int
    {
        self::init();
        
        if (!self::$enabled) {
            return 0;
        }

        $deleted = 0;
        $files = glob(self::$cacheDir . '/*.cache');

        foreach ($files as $file) {
            if (is_file($file)) {
                $cacheData = unserialize(file_get_contents($file));
                
                if ($cacheData['expires'] < time()) {
                    unlink($file);
                    $deleted++;
                }
            }
        }

        return $deleted;
    }
}
