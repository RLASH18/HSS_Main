<?php

namespace app\core\middlewares;

use app\core\Application;

/**
 * Class LocationMiddleware
 *
 * Ensures that the user has approved location access before
 * allowing access to protected routes. If not approved, the
 * user is redirected back to the homepage with an error message.
 */
class LocationMiddleware extends BaseMiddleware
{
    /**
     * Executes the location access check.
     *
     * Verifies if the session contains the 'location_approved' flag.
     * If not, sets an error flash message and redirects the user.
     *
     * @return bool Returns true if location access is approved, false otherwise.
     */
    public function execute()
    {
        if (!Application::$app->session->get('location_approved')) {
            redirect('/');
            return false;
        }

        return true;
    }
}
