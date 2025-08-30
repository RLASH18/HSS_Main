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

        if ($this->isGet()) {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if ($this->isPost()) {
            // Check if this is a JSON request
            $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
            if (strpos($contentType, 'application/json') !== false) {
                $jsonData = file_get_contents('php://input');
                $body = json_decode($jsonData, true) ?? [];
            } else {
                foreach ($_POST as $key => $value) {
                    $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
        }
        return $body;
    }

    /**
     * Gets JSON data from the request body
     * 
     * @return array
     */
    public function getJson()
    {
        $jsonData = file_get_contents('php://input');
        return json_decode($jsonData, true) ?? [];
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

            // If field is nullable AND empty, skip all validation for it
            if (in_array('nullable', $rulesArray) && empty($value)) {
                continue;
            }

            foreach ($rulesArray as $rule) {
                $ruleName = $rule;
                $param = null;

                // Check if the rule has a parameter (e.g., min:6, match:password)
                if (str_contains($rule, ':')) {
                    [$ruleName, $param] = explode(':', $rule);
                }

                // Rule: required – field must not be empty
                if ($ruleName === 'required' && !$value) {
                    $errors[$field][] = 'This field is required.';
                }

                // Rule: email – must be a valid email address format
                if ($ruleName === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $errors[$field][] = 'Invalid email address.';
                }

                // Rule: min – string must be at least X characters long
                if ($ruleName === 'min' && strlen($value) < (int)$param) {
                    $errors[$field][] = "Minimum of {$param} characters required.";
                }

                // Rule: max – string must not exceed X characters
                if ($ruleName === 'max' && strlen($value) > (int)$param) {
                    $errors[$field][] = "Maximum of {$param} characters exceeded.";
                }

                // Rule: match – field must match another field (e.g., confirmPassword = password)
                if ($ruleName === 'match' && $value !== ($data[$param] ?? '')) {
                    $errors[$field][] = "This field must match $param.";
                }

                // Rule: image – ensure a image is uploaded with no errors
                if ($ruleName === 'image') {
                    if (!isset($_FILES[$field]) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
                        $errors[$field][] = 'Please upload a valid image.';
                    }
                }

                // Rule: unique – value must not already exist in the specified table and column
                if ($ruleName === 'unique') {
                    $parts = explode(',', $param);

                    $table = $parts[0];
                    $column = $parts[1];
                    $ignoreId = $parts[2] ?? null; // optional 3rd param for ID to ignore

                    $sql = "SELECT * FROM $table WHERE $column = :value";
                    if ($ignoreId) {
                        $sql .= " AND id != :id";
                    }

                    $stmt = Application::$app->db->pdo->prepare($sql);
                    $stmt->bindValue(':value', $value);
                    if ($ignoreId) {
                        $stmt->bindValue(':id', $ignoreId);
                    }
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
