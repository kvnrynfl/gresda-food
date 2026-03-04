<?php

/**
 * UUID Generator
 * 
 * Generates cryptographically secure RFC 4122 UUID v4 values
 * and formatted order numbers.
 */
class UUID
{
    /**
     * Generate a valid RFC 4122 UUID version 4 using cryptographically secure randomness
     * @return string UUID v4 string (e.g., "550e8400-e29b-41d4-a716-446655440000")
     */
    public static function v4()
    {
        // Use random_bytes for cryptographic security (replaces mt_rand)
        $data = random_bytes(16);

        // Set version to 0100 (UUID v4)
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        // Set variant to 10xx
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    /**
     * Generate a formatted order number
     * Format: GF-YYYYMMDD-XXXX (e.g., GF-20260304-A7F2)
     * @return string Order number
     */
    public static function orderNumber()
    {
        $date = date('Ymd');
        $random = strtoupper(bin2hex(random_bytes(2))); // 4 hex chars
        return "GF-{$date}-{$random}";
    }

    /**
     * Generate a short unique identifier for tokens
     * @param int $length Number of bytes (output will be 2x in hex chars)
     * @return string Hex token string
     */
    public static function token($length = 32)
    {
        return bin2hex(random_bytes($length));
    }
}
