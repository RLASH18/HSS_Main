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
function flash(string $key, $class = 'alert alert-success')
{
    $message = Application::$app->session->getFlash($key);

    if ($message) {
        return "<div class=\"$class\">$message</div>";
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

        echo "<script>
            Swal.fire({
                icon: '{$swal['type']}',
                title: '{$swal['title']}',
                text: '{$swal['message']}',
                timer: 3000,
                showConfirmButton: false
            });
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
