<?php

// ===================================================================
// Gresda Food — Front Controller
// ===================================================================
// All requests are routed through this file via .htaccess

// ─── Security: Hardened Session Configuration ───────────────────────
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_samesite', 'Strict');
ini_set('session.use_strict_mode', 1);
ini_set('session.use_only_cookies', 1);

// Enable secure cookies only in production (HTTPS)
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    ini_set('session.cookie_secure', 1);
}

// Set session lifetime (2 hours)
ini_set('session.gc_maxlifetime', 7200);
ini_set('session.cookie_lifetime', 0); // Session cookie (expires when browser closes)

if (!session_id()) {
    session_start();
}

// ─── Security: Response Headers ─────────────────────────────────────
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');
header('Permissions-Policy: camera=(), microphone=(), geolocation=()');

// ─── Bootstrap Application ──────────────────────────────────────────
require_once '../app/init.php';

// ─── Run Application ────────────────────────────────────────────────
$app = new App();
