<?php

class Sanitize {
    // Sanitize string (removes tags, encodes special chars)
    public static function string($value) {
        return htmlspecialchars(strip_tags(trim($value)), ENT_QUOTES, 'UTF-8');
    }

    // Sanitize email
    public static function email($value) {
        return filter_var(trim($value), FILTER_SANITIZE_EMAIL);
    }

    // Sanitize integer
    public static function int($value) {
        return filter_var(trim($value), FILTER_SANITIZE_NUMBER_INT);
    }

    // Sanitize array recursively
    public static function array($array) {
        $sanitized = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $sanitized[$key] = self::array($value);
            } else {
                $sanitized[$key] = self::string($value);
            }
        }
        return $sanitized;
    }
}
