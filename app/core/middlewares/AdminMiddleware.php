<?php

namespace app\core\middlewares;

use app\core\Application;
use Exception;

class AdminMiddleware extends BaseMiddleware
{
    public function execute()
    {
        $user = Application::$app->user;

        if (!$user || $user->role !== 'admin') {
            throw new Exception('Admin access required', 403);
        }
    }
}