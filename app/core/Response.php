<?php

namespace app\core;

/**
 * Class Response
 *
 * Handles outgoing HTTP responses, including setting response status codes
 * and performing URL redirects. Centralizes all response-related behavior
 * to keep controller and routing logic clean and consistent.
 */
class Response
{
    /**
     * Sets the HTTP status code for the current response.
     *
     * @param int $code HTTP status code (e.g., 200, 404, 500)
     */
    public function setStatusCode(int $code)
    {
        http_response_code($code);
    }

    /**
     * Sends an HTTP redirect response to the specified URL and halts further execution.
     *
     * @param string $url The destination URL to redirect to
     */
    public function redirect(string $url)
    {
        header('Location: ' . $url);
        exit;
    }
}
