<?php

namespace app\core;

/**
 * Class Controller
 *
 * Base controller all other controllers should extend.
 * Provides utilities for rendering views and email templates.
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

    /**
     * Renders an email template and returns it as a string.
     * Useful for generating HTML email content with dynamic data.
     *
     * @param string $template  Name of the email template (without extension)
     * @param array $data       Data to inject into the template
     * @return string           Rendered email HTML content
     */
    public function mailView(string $template, array $data = []): string
    {
        extract($data);
        ob_start();
        include_once Application::$ROOT_DIR . "/resources/views/emails/{$template}.view.php";
        return ob_get_clean();
    }
}
