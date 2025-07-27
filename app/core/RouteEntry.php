<?php

namespace app\core;

/**
 * Class RouteEntry
 *
 * Represents a single registered route with its 
 * method, path, callback, and middlewares.
 */
class RouteEntry
{
    /** @var string HTTP method (get/post) */
    public string $method;

    /** @var string Route path (e.g., /login) */
    public string $path;

    /** @var callable|array|string Controller action or handler */
    public $callback;

    /** @var array List of middlewares assigned to the route */
    public array $middlewares = [];

    /**
     * Initializes a new route entry.
     *
     * @param string $method
     * @param string $path
     * @param mixed $callback
     */
    public function __construct(string $method, string $path, $callback)
    {
        $this->method = $method;
        $this->path = $path;
        $this->callback = $callback;
    }

    /**
     * Adds middleware(s) to the route.
     * Accepts either a single string or an array of middleware aliases/classes.
     *
     * @param string|array $middleware
     * @return $this
     */
    public function middleware(string|array $middleware): self
    {
        $items = (array)$middleware;

        foreach ($items as $item) {
            $resolved = class_exists($item) ? $item : Application::$app->resolveMiddleware($item);
            $this->middlewares[] = $resolved;
        }

        return $this;
    }

    /**
     * Gets the list of applied middleware for this route.
     *
     * @return array
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
}
