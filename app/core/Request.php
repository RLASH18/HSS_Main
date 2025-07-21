<?php

namespace app\core;

/**
 * Class Request
 *
 * Handles HTTP request data such as URL path, method, and form inputs.
 * Provides utilities for retrieving sanitized input and validating user data.
 */
class Request
{
    /**
     * Returns the path part of the requested URL, excluding query parameters.
     *
     * For example, if the full URL is:
     *   /contact?name=John
     * This returns:
     *   /contact
     *
     * @return string The requested path
     */
    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');

        if ($position === false) {
            return $path;
        }

        return substr($path, 0, $position);
    }

    /**
     * Returns the HTTP request method in lowercase (e.g., 'get', 'post').
     *
     * @return string
     */
    public function method()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    /**
     * Checks if the request method is GET.
     *
     * @return bool
     */
    public function isGet()
    {
        return $this->method() === 'get';
    }

    /**
     * Checks if the request method is POST.
     *
     * @return bool
     */
    public function isPost()
    {
        return $this->method() === 'post';
    }

    /**
     * Retrieves sanitized input data from the request.
     *
     * Automatically detects whether the method is GET or POST,
     * and applies FILTER_SANITIZE_SPECIAL_CHARS to all inputs to
     * prevent XSS (cross-site scripting).
     *
     * @return array Associative array of user inputs
     */
    public function getBody()
    {
        $body = [];

        if ($this->method() === 'get') {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if ($this->method() === 'post') {
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $body;
    }

    /**
     * Validates request input based on given rules.
     * Supports rules: required, email, min, max, match, nullable, file, unique
     *
     * Redirects back with errors if validation fails.
     *
     * @param array $rules
     * @return array
     */
    public function validate(array $rules): array
    {
        $data = $this->getBody();
        $errors = [];

        foreach ($rules as $field => $ruleString) {
            $value = $data[$field] ?? '';
            $rulesArray = explode('|', $ruleString);

            foreach ($rulesArray as $rule) {
                $ruleName = $rule;
                $param = null;

                if (str_contains($rule, ':')) {
                    [$ruleName, $param] = explode(':', $rule);
                }

                if ($ruleName === 'required' && !$value) {
                    $errors[$field][] = 'This field is required.';
                }

                if ($ruleName === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $errors[$field][] = 'Invalid email address.';
                }

                if ($ruleName === 'min' && strlen($value) < (int)$param) {
                    $errors[$field][] = "Minimum of {$param} characters required.";
                }

                if ($ruleName === 'max' && strlen($value) > (int)$param) {
                    $errors[$field][] = "Maximum of {$param} characters exceeded.";
                }

                if ($ruleName === 'match' && $value !== ($data[$param] ?? '')) {
                    $errors[$field][] = "This field must match $param.";
                }

                if ($ruleName === 'nullable' && empty($value)) {
                    continue;
                }

                if ($ruleName === 'file') {
                    if (!isset($_FILES[$field]) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
                        $errors[$field][] = 'Please upload a valid file.';
                    }
                }

                if ($ruleName === 'unique') {
                    [$table, $column] = explode(',', $param);

                    $stmt = Application::$app->db->pdo->prepare("SELECT * FROM $table WHERE $column = :value");
                    $stmt->bindValue(':value', $value);
                    $stmt->execute();

                    if ($stmt->fetch()) {
                        $errors[$field][] = ucfirst($column) . ' already exists.';
                    }
                }
            }
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $data;

            redirect($_SERVER['HTTP_REFERER'] ?? '/');
            exit;
        }

        return $data;
    }
}
