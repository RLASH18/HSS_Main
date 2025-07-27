<?php

namespace app\core;

/**
 * Class Route
 *
 * Static helper for registering GET and POST routes to the main router.
 * Supports controller binding, route grouping, and middleware attachment.
 */
class Route
{
    /**
     * Temporarily stores the current controller class for grouped routes.
     */
    protected static ?string $currentController = null;

    /**
     * Registers a GET route.
     *
     * @param string $path
     * @param callable|array|string $callback
     * @return RouteEntry
     */
    public static function get(string $path, string|array|callable $callback): RouteEntry
    {
        $callback = self::qualifyCallback($callback);
        return self::registerRoute('get', $path, $callback);
    }

    /**
     * Registers a POST route.
     *
     * @param string $path
     * @param callable|array|string $callback
     * @return RouteEntry
     */
    public static function post(string $path, string|array|callable $callback): RouteEntry
    {
        $callback = self::qualifyCallback($callback);
        return self::registerRoute('post', $path, $callback);
    }

    /**
     * Binds a controller to a group of routes.
     *
     * @param string $controller
     * @param \Closure|null $callback
     * @return self
     */
    public static function controller(string $controller, \Closure $callback = null): self
    {
        self::$currentController = $controller;

        if ($callback) {
            $callback();
            self::$currentController = null;
        }

        return new static();
    }

    /**
     * Groups routes under shared attributes (like middleware or prefix).
     *
     * @param array $attributes
     * @param \Closure $callback
     */
    public static function group(array $attributes, \Closure $callback)
    {
        RouteGroup::start($attributes);
        $callback();
        RouteGroup::end();

        self::$currentController = null;
    }

    /**
     * Resolves controller method string to a callable array.
     *
     * @param callable|array|string $callback
     * @return callable|array|string
     */
    protected static function qualifyCallback($callback): array|string|callable
    {
        if (is_string($callback) && self::$currentController) {
            return [self::$currentController, $callback];
        }

        return $callback;
    }

    /**
     * Registers the route with the application's router.
     * Attaches group middlewares and CSRF middleware for POST requests.
     *
     * @param string $method
     * @param string $path
     * @param callable|array|string $callback
     * @return RouteEntry
     */
    public static function registerRoute(string $method, string $path, $callback): RouteEntry
    {
        $prefix = RouteGroup::getPrefix();
        $fullPath = $prefix . $path;

        $route = new RouteEntry($method, $fullPath, $callback);

        foreach (RouteGroup::getMiddlewares() as $mw) {
            $route->middleware($mw);
        }

        if ($method === 'post') {
            $route->middleware('csrf');
        }

        Application::$app->router->$method($route);
        return $route;
    }
}
