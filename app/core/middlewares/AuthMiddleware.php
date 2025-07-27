<?php

namespace app\core\middlewares;

use app\core\Application;
use Exception;

/**
 * Class AuthMiddleware
 *
 * Protects specific controller actions from unauthenticated access.
 * If the user is not logged in, access to these actions is forbidden.
 */
class AuthMiddleware extends BaseMiddleware
{
    /** @var array List of protected controller actions. */
    public array $actions = [];

    /**
     * Constructs the middleware with optional action restrictions.
     *
     * @param array $actions Actions that require authentication.
     */
    public function __construct(array $actions = [])
    {
        $this->actions = $actions;
    }

    /**
     * Executes the middleware logic.
     * If the user is not authenticated and the current action is protected,
     * a 403 Forbidden exception is thrown.
     *
     * @throws Exception
     */
    public function execute()
    {
        if (guest()) {
            $action = Application::$app->controller?->action;

            // Allow access if the current action is NOT protected
            if (empty($this->actions) || in_array($action, $this->actions)) {
                throw new Exception('Forbidden', 403);
            }
        }
    }
}
