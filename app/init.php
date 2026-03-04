<?php

// ===================================================================
// Gresda Food — Application Bootstrap
// ===================================================================

// ─── Composer Autoloader ────────────────────────────────────────────
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
}

// ─── Environment Variables ──────────────────────────────────────────
function loadEnv($path) {
    if (!file_exists($path)) {
        return;
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        // Skip comments and empty lines
        if (empty($line) || $line[0] === '#') {
            continue;
        }

        $parts = explode('=', $line, 2);
        if (count($parts) !== 2) {
            continue;
        }

        $name = trim($parts[0]);
        $value = trim($parts[1]);

        // Remove surrounding quotes if present
        if (preg_match('/^["\'](.*)["\']\s*$/', $value, $matches)) {
            $value = $matches[1];
        }

        if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
            putenv(sprintf('%s=%s', $name, $value));
            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;
        }
    }
}

// Load environment variables from the root .env file
loadEnv(__DIR__ . '/../.env');

// ─── Environment Validation ─────────────────────────────────────────
$requiredEnvVars = ['APP_URL', 'DB_HOST', 'DB_USER', 'DB_NAME'];
foreach ($requiredEnvVars as $var) {
    if (empty($_ENV[$var] ?? '')) {
        die("Missing required environment variable: {$var}. Please check your .env file.");
    }
}

// ─── Application Constants ──────────────────────────────────────────
define('BASEURL', rtrim($_ENV['APP_URL'] ?? 'http://localhost/Gresda-Food', '/'));
define('APP_ENV', $_ENV['APP_ENV'] ?? 'production');
define('APP_DEBUG', ($_ENV['APP_DEBUG'] ?? 'false') === 'true');
define('APP_KEY', $_ENV['APP_KEY'] ?? '');
define('STORAGE_PATH', __DIR__ . '/../storage');

// ─── Error Reporting ────────────────────────────────────────────────
if (APP_DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', STORAGE_PATH . '/logs/error.log');
}

// ─── Create storage directories if needed ───────────────────────────
$storageDirectories = [
    STORAGE_PATH,
    STORAGE_PATH . '/logs',
    STORAGE_PATH . '/cache',
];
foreach ($storageDirectories as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// ─── Require Core Framework Files ───────────────────────────────────
require_once __DIR__ . '/core/App.php';
require_once __DIR__ . '/core/Controller.php';
require_once __DIR__ . '/core/Database.php';
require_once __DIR__ . '/core/CSRF.php';
require_once __DIR__ . '/core/Sanitize.php';
require_once __DIR__ . '/core/Upload.php';
require_once __DIR__ . '/core/Pagination.php';
require_once __DIR__ . '/core/Mailer.php';
require_once __DIR__ . '/core/UUID.php';
require_once __DIR__ . '/core/RateLimiter.php';
require_once __DIR__ . '/core/Migration.php';
require_once __DIR__ . '/core/Seeder.php';
