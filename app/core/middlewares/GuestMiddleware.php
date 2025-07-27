<?php

namespace app\core\middlewares;

/**
 * Class GuestMiddleware
 *
 * Blocks access to routes if the user is already authenticated.
 * Redirects logged-in users to the homepage.
 */
class GuestMiddleware extends BaseMiddleware
{
    /**
     * Redirects authenticated users away from guest-only routes.
     */
    public function execute()
    {
        if (auth()) {
            redirect('/');
        }
    }
}
