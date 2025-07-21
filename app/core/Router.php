<?php

namespace app\core;

use app\core\Request;
use app\core\Response;

/**
 * Class Router
 *
 * Manages route registration and resolution for GET and POST requests.
 * Matches the current request to a route and executes its callback or renders an error.
 */
class Router
{
    /** Current HTTP request object */
    public Request $request;

    /** Current HTTP response object */
    public Response $response;

    /** @var array Stores routes as [method][path] => RouteEntry */
    protected array $routes = [];

    /**
     * Initializes the router with the current request and response.
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
     * Resolves the current request and returns the matched output.
     * Returns error views for unmatched or invalid methods.
     */
    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->method();
        $route = $this->routes[$method][$path] ?? false;

        if ($route === false) {
            // Check if the path exists in another method
            $isGet = isset($this->routes['get'][$path]);
            $isPost = isset($this->routes['post'][$path]);

            if ($isGet || $isPost) {
                $this->response->setStatusCode(405);
                return $this->renderErrorPage(405);
            }

            $this->response->setStatusCode(404);
            return $this->renderErrorPage('404');
        }

        $callback = $route instanceof RouteEntry ? $route->callback : $route;

        // Execute middlewares if applicable
        if ($route instanceof RouteEntry) {
            foreach ($route->getMiddlewares() as $middleware) {
                (new $middleware())->execute();
            }
        }

        // Render view if callback is a view name
        if (is_string($callback)) {
            return $this->renderView($callback);
        }

        // If controller method: instantiate and inject
        if (is_array($callback)) {
            $controller = new $callback[0]();
            Application::$app->controller = $controller;
            $controller->action = $callback[1];
            $callback[0] = $controller;
        }

        return call_user_func($callback, $this->request);
    }

    /**
     * Renders a view file with optional data.
     */
    public function renderView($view, $data = [])
    {
        $viewContent = $this->renderOnlyView($view, $data);
        return $viewContent;
    }

    /**
     * Loads a view file and injects provided data into it.
     */
    public function renderOnlyView($view, $data = [])
    {
        $path = Application::$ROOT_DIR . "/app/views/$view.view.php";

        foreach ($data as $key => $value) {
            $$key = $value;
        }

        ob_start();
        include_once $path;
        return ob_get_clean();
    }

    /**
     * Renders an error page by HTTP status code.
     */
    public function renderErrorPage($code)
    {
        return $this->getErrorView($code);
    }

    /**
     * Loads a specific error view file.
     */
    public function getErrorView($code)
    {
        $path = Application::$ROOT_DIR . "/public/errors/_$code.view.php";

        ob_start();
        include_once $path;
        return ob_get_clean();
    }
}
