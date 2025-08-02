<?php

namespace app\core;

/**
 * Class Application
 *
 * Core framework class that initializes and manages the main components:
 * request, response, router, session, database, and user authentication.
 *
 * It holds global app configuration, sets up all services,
 * and runs the main routing process via the run() method.
 *
 * Acts as the main entry point that ties everything together.
 */
class Application
{
    /** @var string Absolute root path of the project */
    public static string $ROOT_DIR;

    /** @var Application Singleton instance of the application */
    public static Application $app;

    // Core components
    public Request $request;
    public Response $response;
    public Router $router;
    public Session $session;
    public Database $db;

    /** @var Controller|null Currently resolved controller */
    public ?Controller $controller = null;

    /** @var string Class name used to represent the authenticated user */
    public string $userModel;

    /** @var Model|null The currently authenticated user (null if guest) */
    public ?Model $user = null;

    /** @var array Map of middleware aliases to their class implementations */
    public array $middlewareAliases = [];

    /** @var array Application configuration */
    public array $config = [];

    public function __construct($rootPath, array $config)
    {
        self::$ROOT_DIR = $rootPath;                // Set global root path
        self::$app = $this;                         // Store singleton instance
        $this->config = $config;                    // Store config

        // Load config
        $this->userModel         = $config['userModel'];
        $this->middlewareAliases = $config['middleware'];

        // Core services
        $this->request  = new Request();
        $this->response = new Response();
        $this->session  = new Session();
        $this->router   = new Router($this->request, $this->response);
        $this->db       = new Database($config['db']);

        // Load logged-in user if session exists
        $userId = $this->session->get('user');

        if ($userId) {
            $key = $this->userModel::primaryKey();
            $this->user = $this->userModel::where([$key => $userId]) ?: null;
        }
    }

    /**
     * Starts the app by resolving the current route.
     * Renders error pages on exceptions.
     */
    public function run()
    {
        try {
            echo $this->router->resolve();
        } catch (\Exception $e) {
            if ($e->getCode() === 403) {
                $this->response->setStatusCode(403);
                echo $this->router->renderErrorPage('403');
            } elseif ($e->getCode() === 419) {
                $this->response->setStatusCode(419);
                echo $this->router->renderErrorPage('419');
            } else {
                $this->response->setStatusCode(500);
                echo $this->router->renderErrorPage('500');
            }
        }
    }

    /**
     * Resolves a middleware alias to its full class name.
     *
     * @param string $alias Alias of the middleware (e.g., 'auth')
     * @return string Fully-qualified middleware class name
     */
    public function resolveMiddleware(string $alias): string
    {
        return $this->middlewareAliases[$alias] ?? $alias;
    }

    /**
     * Logs in the given user by saving their ID to the session.
     *
     * @param Model $user The user to authenticate
     * @return bool Always returns true
     */
    public function login(Model $user): bool
    {
        $this->user = $user;
        $key = $user->primaryKey();
        $this->session->set('user', $user->{$key});
        return true;
    }

    /**
     * Logs out the current user and clears their session data.
     */
    public function logout(): void
    {
        $this->user = null;
        $this->session->remove('user');
    }

    /**
     * Returns true if no user is currently authenticated.
     *
     * @return bool Whether the current user is a guest
     */
    public function isGuest(): bool
    {
        return $this->user === null;
    }
}
