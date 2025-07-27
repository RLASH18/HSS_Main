<?php

namespace app\core;

/**
 * Class Controller
 *
 * The base controller all other controllers should extend.
 * Handles rendering views and passing data to them.
 */
class Controller
{
    /**
     * Loads a view file and passes optional data to it.
     *
     * @param string $view  The name of the view file (without extension)
     * @param array  $data  Associative array of variables to extract into the view
     * @return string       The rendered HTML content
     */
    public function view(string $view, array $data = []): string
    {
        // Expose $data to the view as individual variables (e.g., $title, $name, etc.)
        extract($data);

        // Make data accessible to layouts if needed (via global or static handlers)
        $GLOBALS['__layoutData__'] = $data;

        // Render the view through the router
        return Application::$app->router->renderView($view, $data);
    }

}
