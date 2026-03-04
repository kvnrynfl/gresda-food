<?php

/**
 * Base Controller
 * 
 * All controllers extend this class.
 * Enhanced with authentication helpers, JSON response, and flash messages.
 */
class Controller
{
    /**
     * Load and instantiate a model
     */
    public function model($model)
    {
        require_once __DIR__ . '/../models/' . $model . '.php';
        return new $model();
    }

    /**
     * Load a view file with data
     */
    public function view($view, $data = [])
    {
        $file = __DIR__ . '/../views/' . $view . '.php';
        if (file_exists($file)) {
            extract($data);
            require_once $file;
        } else {
            $this->show404();
        }
    }

    /**
     * Redirect to a URL
     */
    public function redirect($url)
    {
        header('Location: ' . BASEURL . $url);
        exit;
    }

    /**
     * Send JSON response (for AJAX)
     */
    public function json($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * Show 404 error page
     */
    public function show404()
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

    // ─── Authentication Helpers ─────────────────────────────────────

    /**
     * Check if user is logged in
     */
    public function isLoggedIn()
    {
        return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    }

    /**
     * Check if logged in user is admin
     */
    public function isAdmin()
    {
        return $this->isLoggedIn() && ($_SESSION['role'] ?? '') === 'admin';
    }

    /**
     * Require logged-in user, redirect to login if not
     */
    public function requireLogin()
    {
        if (!$this->isLoggedIn()) {
            $_SESSION['flash_error'] = 'Silakan login terlebih dahulu.';
            $this->redirect('/auth/login');
        }
    }

    /**
     * Require admin role, redirect if not
     */
    public function requireAdmin()
    {
        if (!$this->isAdmin()) {
            $this->redirect('/auth/login');
        }
    }

    // ─── Flash Messages ─────────────────────────────────────────────

    /**
     * Set a flash message
     */
    public function flash($key, $message)
    {
        $_SESSION['flash_' . $key] = $message;
    }

    /**
     * Get and clear a flash message
     */
    public function getFlash($key)
    {
        $message = $_SESSION['flash_' . $key] ?? '';
        unset($_SESSION['flash_' . $key]);
        return $message;
    }

    /**
     * Format money as Rupiah
     */
    public function formatRupiah($amount)
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}
