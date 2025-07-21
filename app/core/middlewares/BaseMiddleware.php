<?php

namespace app\core\middlewares;

/**
 * Class BaseMiddleware
 *
 * Base class for all middleware. Requires an execute() method to be implemented.
 */
abstract class BaseMiddleware
{
    abstract public function execute();
}