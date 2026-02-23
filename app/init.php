<?php

// Simple .env parser function
function loadEnv($path) {
    if (!file_exists($path)) {
        return;
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);

        if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
            putenv(sprintf('%s=%s', $name, $value));
            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;
        }
    }
}

// Load environment variables from the root .env file
loadEnv(__DIR__ . '/../.env');

// Application Constants (URL configuration)
define('BASEURL', $_ENV['APP_URL'] ?? 'http://localhost/Gresda-Food');

// Require core files
require_once 'core/App.php';
require_once 'core/Controller.php';
require_once 'core/Database.php';
require_once 'core/CSRF.php';
require_once 'core/Sanitize.php';
require_once 'core/Upload.php';
require_once 'core/Pagination.php';
require_once 'core/Mailer.php';
require_once 'core/UUID.php';
