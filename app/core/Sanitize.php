<?php

/**
 * Input Sanitization Helper
 * 
 * Provides methods for sanitizing user input to prevent XSS attacks
 * and ensure data integrity.
 */
class Sanitize
{
    /**
     * Sanitize a string value
     */
    public static function string($value)
    {
        $value = trim($value);
        $value = stripslashes($value);
        $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        return $value;
    }

    /**
     * Sanitize an email address
     */
    public static function email($value)
    {
        $value = trim($value);
        $value = filter_var($value, FILTER_SANITIZE_EMAIL);
        return $value;
    }

    /**
     * Sanitize an integer
     */
    public static function int($value)
    {
        return (int) filter_var($value, FILTER_SANITIZE_NUMBER_INT);
    }

    /**
     * Sanitize a float
     */
    public static function float($value)
    {
        return (float) filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }

    /**
     * Sanitize all values in an array (recursive)
     */
    public static function array($data)
    {
        $sanitized = [];
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $sanitized[$key] = self::array($value);
            } else {
                $sanitized[$key] = self::string($value);
            }
        }
        return $sanitized;
    }

    /**
     * Sanitize a URL
     */
    public static function url($value)
    {
        return filter_var(trim($value), FILTER_SANITIZE_URL);
    }

    /**
     * Strip all HTML tags from a string
     */
    public static function stripTags($value)
    {
        return strip_tags(trim($value));
    }
}
