<?php

/*-----------------------------------------------------------
 | GLOBAL HELPER FUNCTIONS
 |-----------------------------------------------------------
 | 
 | Contains commonly used utility functions for views,
 | authentication, form handling, flash messaging, and CSRF.
 | These helpers simplify repetitive tasks across the app.
 |
 */

use app\core\Application;

/**
 * Get a value from the environment, with optional default.
 */
function env(string $key, $default = null)
{
    return $_ENV[$key] ?? $default;
}

/**
 * Loads the specified layout file and shares view data like $title, $name, etc.
 */
function layout(string $layout)
{
    if (isset($GLOBALS['__layoutData__'])) {
        extract($GLOBALS['__layoutData__']);
    }

    include Application::$ROOT_DIR . "/resources/views/layouts/$layout.view.php";
}

/**
 * Returns the previously submitted form input value, if available.
 */
function old(string $field)
{
    $value = $_SESSION['old'][$field] ?? '';
    unset($_SESSION['old'][$field]);

    if (empty($_SESSION['old'])) {
        unset($_SESSION['old']);
    }

    return htmlspecialchars($value);
}

/**
 * Adds red border styling to inputs with validation errors.
 */
function isInvalid(string $field)
{
    return isset($_SESSION['errors'][$field])
        ? 'style="border-color: #ef4444; outline: none; box-shadow: 0 0 0 1px #fca5a5;"'
        : '';
}

/**
 * Returns and clears the first validation error message for a field.
 */
function error(string $field)
{
    if (isset($_SESSION['errors'][$field])) {
        $error = $_SESSION['errors'][$field][0];
        unset($_SESSION['errors'][$field]);

        if (empty($_SESSION['errors'])) {
            unset($_SESSION['errors']);
        }

        return $error;
    }

    return '';
}

/**
 * Stores a flash message in session.
 */
function setFlash(string $key, string $message)
{
    return Application::$app->session->setFlash($key, $message);
}

/**
 * Retrieves and displays a flash message, styled with the given CSS class.
 */
function flash(string $key, $class = null)
{
    $message = Application::$app->session->getFlash($key);

    if ($message) {
        $icons = [
            'success' => '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>',
            'error'   => '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>',
            'warning' => '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M4.93 19.07A10 10 0 1119.07 4.93 10 10 0 014.93 19.07z" /></svg>',
            'info'    => '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 1010 10A10 10 0 0012 2z" /></svg>',
        ];

        if ($class === null) {
            $map = [
                'success' => 'alert alert-success',
                'error'   => 'alert alert-error',
                'warning' => 'alert alert-warning',
                'info'    => 'alert alert-info'
            ];
            $class = $map[$key] ?? 'alert';
        }

        $icon = $icons[$key] ?? '';
        return "<div class=\"$class\">$icon <span>$message</span></div>";
    }
    return '';
}

/**
 * Stores a SweetAlert message in session for display after redirect.
 */
function setSweetAlert(string $type, string $title, string $message)
{
    $_SESSION['swal'] = [
        'type' => $type,
        'title' => $title,
        'message' => $message
    ];
}

/**
 * Renders and clears any pending SweetAlert message from session.
 */
function renderSweetAlert()
{
    if (isset($_SESSION['swal'])) {
        $swal = $_SESSION['swal'];
        unset($_SESSION['swal']);

        $type = htmlspecialchars($swal['type'], ENT_QUOTES, 'UTF-8');
        $title = htmlspecialchars($swal['title'], ENT_QUOTES, 'UTF-8');
        $message = htmlspecialchars($swal['message'], ENT_QUOTES, 'UTF-8');

        echo "<script>
            window.swalData = {
                type: '{$type}',
                title: '{$title}',
                message: '{$message}'
            };
        </script>";
    }
}

/**
 * Returns the currently authenticated user, or null if guest.
 *
 * @return \app\model\User|null
 */
function auth()
{
    return Application::$app->user;
}

/**
 * Checks if no user is logged in.
 */
function guest()
{
    return Application::$app->isGuest();
}

/**
 * Logs in a user and stores their ID in session.
 */
function login($user)
{
    return Application::$app->login($user);
}

/**
 * Logs out the currently authenticated user.
 */
function logout()
{
    return Application::$app->logout();
}

/**
 * Returns a hidden CSRF token input element and generates one if needed.
 */
function csrf_token(): string
{
    if (empty($_SESSION['_csrf'])) {
        $_SESSION['_csrf'] = bin2hex(random_bytes(32));
    }

    $token = $_SESSION['_csrf'];
    return '<input type="hidden" name="_token" value="' . htmlspecialchars($token) . '">';
}

/**
 * Redirects the browser to a given URL.
 */
function redirect(string $url)
{
    return Application::$app->response->redirect($url);
}

/**
 * Build a breadcrumb trail based on the current URL
 * 
 * @return array
 */
function breadcrumbs(): array
{
    $uriPath = trim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH), '/');
    $segments = $uriPath === '' ? [] : explode('/', $uriPath);

    // If first segment is "admin", remove it from the trail
    if (isset($segments[0]) && $segments[0] === 'admin') {
        array_shift($segments);
    }

    // Map for pretty labels
    $labelMap = [
        'dashboard' => 'Dashboard',
        'inventory' => 'Inventory',
        'orders'    => 'Customer Orders',
        'billings'  => 'Billings',
        'delivery'  => 'Delivery',
        'settings'  => 'Settings',
    ];

    $trail = [];
    foreach ($segments as $seg) {
        // Skip numeric IDs
        if (is_numeric($seg)) {
            continue;
        }

        $trail[] = $labelMap[strtolower($seg)]
            ?? ucwords(str_replace(['-', '_'], ' ', $seg));
    }

    return $trail;
}
