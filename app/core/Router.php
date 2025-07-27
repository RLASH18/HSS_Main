<?php

namespace app\core;

use app\core\Request;
use app\core\Response;

/**
 * Class Router
 *
 * Handles route registration and resolution for HTTP GET and POST requests.
 * Supports dynamic route parameters (e.g., /item/{id}) and executes associated callbacks.
 */
class Router
{
    /** @var Request The current HTTP request */
    public Request $request;

    /** @var Response The current HTTP response */
    public Response $response;

    /** @var array Stores registered routes as [method][path] => RouteEntry */
    protected array $routes = [];

    /**
     * Initializes the Router with the request and response objects.
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * Registers a GET route.
     */
    public function get(RouteEntry $route)
    {
        $this->routes['get'][$route->path] = $route;
    }

    /**
     * Registers a POST route.
     */
    public function post(RouteEntry $route)
    {
        $this->routes['post'][$route->path] = $route;
    }

    /**
     * Resolves the current request path to a registered route.
     * Supports:
     *  - Exact match
     *  - Pattern-based dynamic routes using {parameter} syntax
     *
     * If a route is matched, its callback is invoked.
     * Otherwise, a 404 error page is rendered.
     */
    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->method();

        // Try to match exact route
        $route = $this->routes[$method][$path] ?? false;

        if ($route !== false) {
            return $this->callRoute($route, []);
        }

        // Attempt to match dynamic route (e.g., /item/{id})
        foreach ($this->routes[$method] as $routePath => $routeEntry) {
            // Convert {param} to regex group
            $pattern = preg_replace('#\{[a-zA-Z_][a-zA-Z0-9_]*\}#', '([^/]+)', $routePath);
            $pattern = "#^" . $pattern . "$#";

            if (preg_match($pattern, $path, $matches)) {
                array_shift($matches);
                return $this->callRoute($routeEntry, $matches);
            }
        }

        // Route not found
        $this->response->setStatusCode(404);
        return $this->renderErrorPage('404');
    }

    /**
     * Calls the route's callback with any extracted parameters.
     * Also executes any associated middlewares.
     *
     * @param RouteEntry $route
     * @param array $params
     * @return mixed
     */
    public function callRoute($route, $params)
    {
        $callback = $route instanceof RouteEntry ? $route->callback : $route;

        // Execute middlewares
        if ($route instanceof RouteEntry) {
            foreach ($route->getMiddlewares() as $middleware) {
                (new $middleware())->execute();
            }
        }

        // If the callback is a string (view name), render it directly
        if (is_string($callback)) {
            return $this->renderView($callback);
        }

        // If controller method: instantiate controller and set context
        if (is_array($callback)) {
            $controller = new $callback[0]();
            Application::$app->controller = $controller;
            $controller->action = $callback[1];
            $callback[0] = $controller;

            // Use reflection to check if the controller method expects a Request parameter
            $refMethod = new \ReflectionMethod($callback[0], $callback[1]);
            $expectsRequest = count($refMethod->getParameters()) > 0 &&
                $refMethod->getParameters()[0]->getType() &&
                $refMethod->getParameters()[0]->getType()->getName() === Request::class;

            // If the method expects a Request object, inject it as the first argument
            if ($expectsRequest) {
                return call_user_func_array($callback, array_merge([$this->request], $params));
            }
        }

        // Call the route's handler with any URL parameters
        return call_user_func_array($callback, $params);
    }

    /**
     * Renders a view by file name and optional data.
     */
    public function renderView($view, $data = [])
    {
        return $this->renderOnlyView($view, $data);
    }

    /**
     * Renders only the content of a view file.
     * Injects variables from the provided data array.
     */
    public function renderOnlyView($view, $data = [])
    {
        $path = Application::$ROOT_DIR . "/resources/views/$view.view.php";

        foreach ($data as $key => $value) {
            $$key = $value;
        }

        ob_start();
        include_once $path;
        return ob_get_clean();
    }

    /**
     * Renders an error page by HTTP status code (e.g., 404).
     */
    public function renderErrorPage($code)
    {
        return $this->getErrorView($code);
    }

    /**
     * Loads and returns the content of a specific error HTML file.
     */
    public function getErrorView($code)
    {
        $path = Application::$ROOT_DIR . "/public/errors/_$code.html";

        ob_start();
        include_once $path;
        return ob_get_clean();
    }
}
