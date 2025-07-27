<?php

/*-----------------------------------------------------------
 | DATABASE CONFIGURATION FILE
 |-----------------------------------------------------------
 | 
 | This file returns an associative array with the
 | necessary connection details for the PDO instance.
 | It uses environment variables (from .env) for security
 | and flexibility between environments.
 |
 */

return [
    'dsn'      => $_ENV['DB_CONNECTION'] . ":host=" . $_ENV['DB_HOST'] . ";port=" . $_ENV['DB_PORT'] . ";dbname=" . $_ENV['DB_DATABASE'],
    'user'     => $_ENV['DB_USERNAME'],
    'password' => $_ENV['DB_PASSWORD']
];