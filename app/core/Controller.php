<?php

namespace app\core;

/**
 * Class Controller
 *
 * Base controller all other controllers should extend.
 * Handles view rendering with optional data passing.
 */
class Controller
{
    /**
     * Renders a standard view for the web interface.
     * Makes provided data available as individual variables inside the view.
     *
     * @param string $view  Name of the view file (without extension)
     * @param array $data   Data to pass to the view
     * @return string       Rendered HTML content
     */
    public function view(string $view, array $data = []): string
    {
        extract($data);
        $GLOBALS['__layoutData__'] = $data;
        return Application::$app->router->renderView($view, $data);
    }
}
