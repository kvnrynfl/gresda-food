<?php

/**
 * Database Abstraction Layer (PDO Wrapper)
 * 
 * Enhanced with:
 * - UTF-8mb4 charset support
 * - Transaction support (begin, commit, rollback)
 * - Removed persistent connections for better concurrency
 * - Exception-based error handling
 */
class Database
{
    private $dbh;   // Database Handler (PDO instance)
    private $stmt;  // Prepared Statement
    private $error;

    public function __construct()
    {
        $host = $_ENV['DB_HOST'] ?? 'localhost';
        $user = $_ENV['DB_USER'] ?? 'root';
        $pass = $_ENV['DB_PASS'] ?? '';
        $dbname = $_ENV['DB_NAME'] ?? 'gresda_food';

        $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false, // Use native prepared statements
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci",
        ];

        try {
            $this->dbh = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();

            if (defined('APP_DEBUG') && APP_DEBUG) {
                die("Database Connection Error: " . $this->error);
            } else {
                error_log("Database Connection Error: " . $this->error);
                die("Terjadi kesalahan koneksi database. Silakan hubungi administrator.");
            }
        }
    }

    /**
     * Prepare statement with query
     */
    public function query($sql)
    {
        $this->stmt = $this->dbh->prepare($sql);
    }

    /**
     * Bind values to prepared statement
     */
    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    /**
     * Execute the prepared statement
     */
    public function execute()
    {
        return $this->stmt->execute();
    }

    /**
     * Get result set as array of associative arrays
     */
    public function resultSet()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get single record as associative array
     */
    public function single()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get row count from last executed statement
     */
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

    /**
     * Get last inserted ID
     */
    public function lastInsertId()
    {
        return $this->dbh->lastInsertId();
    }

    // ─── Transaction Support ────────────────────────────────────────

    /**
     * Begin a database transaction
     */
    public function beginTransaction()
    {
        return $this->dbh->beginTransaction();
    }

    /**
     * Commit the current transaction
     */
    public function commit()
    {
        return $this->dbh->commit();
    }

    /**
     * Rollback the current transaction
     */
    public function rollback()
    {
        return $this->dbh->rollBack();
    }

    /**
     * Check if currently in a transaction
     */
    public function inTransaction()
    {
        return $this->dbh->inTransaction();
    }
}
