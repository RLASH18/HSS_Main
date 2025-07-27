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

    /**
     * Starts session and marks old flash messages for removal.
     */
    public function __construct()
    {
        session_start();

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
