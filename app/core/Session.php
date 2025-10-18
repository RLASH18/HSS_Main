<?php

namespace app\core;

/**
 * Class Session
 *
 * Manages session data and flash messages for one-time notifications.
 * Automatically handles flash message cleanup after each request.
 */
class Session
{
    /** Flash message session key */
    protected const FLASH_KEY = 'flash_messages';

    /** @var array Session configuration */
    protected array $config;

    /**
     * Starts session and marks old flash messages for removal.
     * 
     * @param array $config Session configuration
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;

        // Only start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            // Session cookie parameters for security
            $cookieParams = $config['cookie'] ?? [];
            session_set_cookie_params([
                'lifetime' => $cookieParams['lifetime'] ?? 0,
                'path' => $cookieParams['path'] ?? '/',
                'domain' => $cookieParams['domain'] ?? '',
                'secure' => $cookieParams['secure'] ?? false,
                'httponly' => $cookieParams['httponly'] ?? true,
                'samesite' => $cookieParams['samesite'] ?? 'Lax'
            ]);
            
            // Session configuration for performance
            $lifetime = $config['lifetime'] ?? 3600;
            $gcProbability = $config['gc_probability'] ?? 1;
            $gcDivisor = $config['gc_divisor'] ?? 100;
            
            ini_set('session.gc_maxlifetime', (string) $lifetime);
            ini_set('session.gc_probability', (string) $gcProbability);
            ini_set('session.gc_divisor', (string) $gcDivisor);
            
            // Use file-based sessions (optimized for shared hosting)
            $saveHandler = $config['save_handler'] ?? 'files';
            ini_set('session.save_handler', $saveHandler);
            
            // Set session save path
            $savePath = Application::$ROOT_DIR . ($config['save_path'] ?? '/runtime/sessions');
            ini_set('session.save_path', $savePath);
            
            // Ensure session directory exists
            if (!is_dir($savePath)) {
                mkdir($savePath, 0775, true);
            }
            
            session_start();
        }

        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];

        foreach ($flashMessages as $key => &$flashMessage) {
            $flashMessage['remove'] = true;
        }

        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

    /**
     * Sets a flash message that lasts for one request.
     */
    public function setFlash($key, $message)
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            'remove' => false,
            'value' => $message
        ];
    }

    /**
     * Retrieves a flash message by key.
     */
    public function getFlash($key)
    {
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }

    /**
     * Stores a session variable.
     */
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Gets a session variable by key.
     */
    public function get($key)
    {
        return $_SESSION[$key] ?? false;
    }

    /**
     * Removes a session variable.
     */
    public function remove($key)
    {
        unset($_SESSION[$key]);
    }

    /**
     * Cleans up flash messages after request ends.
     */
    public function __destruct()
    {
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];

        foreach ($flashMessages as $key => $flashMessage) {
            if ($flashMessage['remove']) {
                unset($flashMessages[$key]);
            }
        }

        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }
}
