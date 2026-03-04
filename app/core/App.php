<?php

/**
 * Application Router
 * 
 * Enhanced with:
 * - Method access control (only public methods callable)
 * - 404 handling for missing controllers/methods
 * - Clean URL parsing
 */
class App
{
    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseUrl();

        // Controller resolution
        if (isset($url[0]) && !empty($url[0])) {
            $controllerName = ucfirst($url[0]) . 'Controller';
            $controllerFile = __DIR__ . '/../controllers/' . $controllerName . '.php';

            if (file_exists($controllerFile)) {
                $this->controller = $controllerName;
                unset($url[0]);
            } else {
                // If no controller file matches, show 404
                $this->show404();
                return;
            }
        }

        // Load controller
        require_once __DIR__ . '/../controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // Method resolution
        if (isset($url[1]) && !empty($url[1])) {
            $methodName = $url[1];

            // Security: Only allow public methods, block inherited/magic methods
            if (method_exists($this->controller, $methodName) && $this->isCallable($methodName)) {
                $this->method = $methodName;
                unset($url[1]);
            } else {
                $this->show404();
                return;
            }
        }

        // Parameters
        $this->params = $url ? array_values($url) : [];

        // Execute
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    /**
     * Parse URL into segments
     */
    private function parseUrl()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
        return [];
    }

    /**
     * Check if a method is safe to call (public, not inherited from base helpers)
     */
    private function isCallable($method)
    {
        // Block magic methods
        if (strpos($method, '__') === 0) {
            return false;
        }

        // Block base controller methods from being called via URL
        $blockedMethods = [
            'model', 'view', 'redirect', 'json', 'show404',
            'isLoggedIn', 'isAdmin', 'requireLogin', 'requireAdmin',
            'flash', 'getFlash', 'formatRupiah'
        ];

        if (in_array($method, $blockedMethods)) {
            return false;
        }

        // Only allow public methods
        $reflection = new ReflectionMethod($this->controller, $method);
        return $reflection->isPublic() && !$reflection->isStatic();
    }

    /**
     * Show 404 page
     */
    private function show404()
    {
        http_response_code(404);
        $file = __DIR__ . '/../views/errors/404.php';
        if (file_exists($file)) {
            require_once $file;
        } else {
            echo '<h1>404 — Halaman Tidak Ditemukan</h1>';
        }
        exit;
    }
}
