<?php

/**
 * Rate Limiter
 * 
 * Tracks login attempts by IP + email in tbl_login_attempts.
 * Blocks after configurable failed attempts for a configurable duration.
 * Auto-cleans old records.
 */
class RateLimiter
{
    private $db;
    private const MAX_ATTEMPTS = 5;           // Max failed attempts before lockout
    private const LOCKOUT_DURATION = 900;      // 15 minutes in seconds
    private const CLEANUP_PROBABILITY = 10;    // 10% chance to clean old records per check

    public function __construct()
    {
        $this->db = new Database();

        // Probabilistic cleanup of old records
        if (random_int(1, 100) <= self::CLEANUP_PROBABILITY) {
            $this->cleanup();
        }
    }

    /**
     * Check if login attempts are blocked for given IP + email
     * @param string $email User email
     * @return bool True if blocked
     */
    public function isBlocked($email)
    {
        $ip = $this->getClientIp();
        $since = date('Y-m-d H:i:s', time() - self::LOCKOUT_DURATION);

        $this->db->query("
            SELECT COUNT(*) as attempts 
            FROM tbl_login_attempts 
            WHERE ip_address = :ip AND email = :email AND attempted_at > :since AND success = 0
        ");
        $this->db->bind(':ip', $ip);
        $this->db->bind(':email', $email);
        $this->db->bind(':since', $since);
        $result = $this->db->single();

        return ($result['attempts'] ?? 0) >= self::MAX_ATTEMPTS;
    }

    /**
     * Record a failed login attempt
     * @param string $email User email
     */
    public function recordFailedAttempt($email)
    {
        $ip = $this->getClientIp();

        $this->db->query("
            INSERT INTO tbl_login_attempts (ip_address, email, attempted_at, success)
            VALUES (:ip, :email, NOW(), 0)
        ");
        $this->db->bind(':ip', $ip);
        $this->db->bind(':email', $email);
        $this->db->execute();
    }

    /**
     * Record a successful login (clears failed attempts)
     * @param string $email User email
     */
    public function recordSuccess($email)
    {
        $ip = $this->getClientIp();

        // Clear failed attempts for this IP + email
        $this->db->query("
            DELETE FROM tbl_login_attempts 
            WHERE ip_address = :ip AND email = :email
        ");
        $this->db->bind(':ip', $ip);
        $this->db->bind(':email', $email);
        $this->db->execute();
    }

    /**
     * Get remaining seconds until lockout expires
     * @param string $email User email
     * @return int Seconds remaining
     */
    public function getRemainingLockoutTime($email)
    {
        $ip = $this->getClientIp();
        $since = date('Y-m-d H:i:s', time() - self::LOCKOUT_DURATION);

        $this->db->query("
            SELECT MAX(attempted_at) as last_attempt 
            FROM tbl_login_attempts 
            WHERE ip_address = :ip AND email = :email AND attempted_at > :since AND success = 0
        ");
        $this->db->bind(':ip', $ip);
        $this->db->bind(':email', $email);
        $this->db->bind(':since', $since);
        $result = $this->db->single();

        if ($result && $result['last_attempt']) {
            $lastAttempt = strtotime($result['last_attempt']);
            $unlockTime = $lastAttempt + self::LOCKOUT_DURATION;
            $remaining = $unlockTime - time();
            return max(0, $remaining);
        }

        return 0;
    }

    /**
     * Get number of remaining attempts before lockout
     * @param string $email User email
     * @return int Remaining attempts
     */
    public function getRemainingAttempts($email)
    {
        $ip = $this->getClientIp();
        $since = date('Y-m-d H:i:s', time() - self::LOCKOUT_DURATION);

        $this->db->query("
            SELECT COUNT(*) as attempts 
            FROM tbl_login_attempts 
            WHERE ip_address = :ip AND email = :email AND attempted_at > :since AND success = 0
        ");
        $this->db->bind(':ip', $ip);
        $this->db->bind(':email', $email);
        $this->db->bind(':since', $since);
        $result = $this->db->single();

        return max(0, self::MAX_ATTEMPTS - ($result['attempts'] ?? 0));
    }

    /**
     * Clean up old login attempt records (older than lockout duration * 2)
     */
    private function cleanup()
    {
        $cutoff = date('Y-m-d H:i:s', time() - (self::LOCKOUT_DURATION * 2));

        $this->db->query("DELETE FROM tbl_login_attempts WHERE attempted_at < :cutoff");
        $this->db->bind(':cutoff', $cutoff);
        $this->db->execute();
    }

    /**
     * Get client IP address, handling proxies
     */
    private function getClientIp()
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';

        // Only trust X-Forwarded-For in production behind a known proxy
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && APP_ENV !== 'local') {
            $forwarded = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $ip = trim($forwarded[0]);
        }

        // Validate IP format
        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            $ip = '127.0.0.1';
        }

        return $ip;
    }
}
