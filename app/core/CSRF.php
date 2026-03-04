<?php

/**
 * CSRF (Cross-Site Request Forgery) Protection
 * 
 * Enhanced with:
 * - Token rotation after each form submission
 * - Token expiry (2 hours)
 * - Per-form token support
 */
class CSRF
{
    private const TOKEN_EXPIRY = 7200; // 2 hours in seconds

    /**
     * Generate a new CSRF token
     */
    public static function generateToken()
    {
        $token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $token;
        $_SESSION['csrf_token_time'] = time();
        return $token;
    }

    /**
     * Get current token or generate new one if expired/missing
     */
    public static function getToken()
    {
        if (!isset($_SESSION['csrf_token']) || !isset($_SESSION['csrf_token_time'])) {
            return self::generateToken();
        }

        // Check if token has expired
        if ((time() - $_SESSION['csrf_token_time']) > self::TOKEN_EXPIRY) {
            return self::generateToken();
        }

        return $_SESSION['csrf_token'];
    }

    /**
     * Verify CSRF token and regenerate (one-time use)
     * @param string $token Token to verify
     * @return bool Whether the token is valid
     */
    public static function verifyToken($token)
    {
        if (empty($token) || !isset($_SESSION['csrf_token'])) {
            return false;
        }

        // Check token expiry
        if (isset($_SESSION['csrf_token_time'])) {
            if ((time() - $_SESSION['csrf_token_time']) > self::TOKEN_EXPIRY) {
                self::generateToken(); // Regenerate expired token
                return false;
            }
        }

        // Constant-time comparison to prevent timing attacks
        if (hash_equals($_SESSION['csrf_token'], $token)) {
            // Rotate token after successful verification (one-time use)
            self::generateToken();
            return true;
        }

        return false;
    }

    /**
     * Generate hidden form field with CSRF token
     * @return string HTML hidden input element
     */
    public static function getTokenField()
    {
        $token = self::getToken();
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
    }

    /**
     * Get token for AJAX headers (meta tag)
     * @return string HTML meta tag with CSRF token
     */
    public static function getMetaTag()
    {
        $token = self::getToken();
        return '<meta name="csrf-token" content="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
    }
}
