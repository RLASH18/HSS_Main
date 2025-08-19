<?php

namespace app\core\middlewares;

use Exception;

/**
 * Class CsrfMiddleware
 *
 * Ensures POST requests include a valid CSRF token.
 * Prevents Cross-Site Request Forgery attacks.
 */
class CsrfMiddleware extends BaseMiddleware
{
    /**
     * Routes that are exempt from CSRF protection
     */
    private $exemptRoutes = [
        '/set-location-session'
    ];

    /**
     * Validates the CSRF token on POST requests.
     *
     * @param Request $request The current request object.
     * @throws Exception If the CSRF token is missing or invalid.
     */
    public function execute()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Check if current route is exempt from CSRF protection
            $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            if (in_array($currentPath, $this->exemptRoutes)) {
                return;
            }

            $token = $_POST['_token'] ?? null;
            $sessionToken = $_SESSION['_csrf'] ?? null;
            if (!$token || !$sessionToken || !hash_equals($sessionToken, $token)) {
                throw new Exception('Expired', 419);
            }
        }
    }
}
