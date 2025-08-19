<?php

namespace app\core\middlewares;

use app\core\Application;
use Exception;

/**
 * Class AdminMiddleware
 *
 * Restricts access to routes that require admin privileges.
 * Throws a 403 exception if the user is not an admin.
 */
class AdminMiddleware extends BaseMiddleware
{
    /**
     * Executes the admin check.
     *
     * Ensures the current user is logged in and has the 'admin' role.
     * Throws a 403 exception if the check fails.
     *
     * @throws Exception if the user is not an admin
     */
    public function execute()
    {
        $user = Application::$app->user;

        if (!$user || $user->role !== 'admin') {
            throw new Exception('Admin access required', 403);
        }
    }
}