<?php

/**
 * Migration Runner
 * 
 * Reads migration files from database/migrations/ in order,
 * tracks executed migrations in a `migrations` table,
 * and supports up/down operations.
 */
class Migration
{
    private $db;
    private $migrationsPath;

    public function __construct()
    {
        $this->db = new Database();
        $this->migrationsPath = __DIR__ . '/../../database/migrations';
        $this->ensureMigrationsTable();
    }

    /**
     * Create the migrations tracking table if it doesn't exist
     */
    private function ensureMigrationsTable()
    {
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `migrations` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `migration` VARCHAR(255) NOT NULL,
                `batch` INT NOT NULL,
                `executed_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
        $this->db->execute();
    }

    /**
     * Get list of already executed migrations
     */
    private function getExecutedMigrations()
    {
        $this->db->query("SELECT migration FROM migrations ORDER BY id ASC");
        $results = $this->db->resultSet();
        return array_column($results, 'migration');
    }

    /**
     * Get list of all migration files
     */
    private function getMigrationFiles()
    {
        $files = glob($this->migrationsPath . '/*.php');
        sort($files);
        return $files;
    }

    /**
     * Get current batch number
     */
    private function getCurrentBatch()
    {
        $this->db->query("SELECT MAX(batch) as max_batch FROM migrations");
        $result = $this->db->single();
        return ($result['max_batch'] ?? 0) + 1;
    }

    /**
     * Run all pending migrations
     */
    public function up()
    {
        $executed = $this->getExecutedMigrations();
        $files = $this->getMigrationFiles();
        $batch = $this->getCurrentBatch();
        $ran = 0;

        foreach ($files as $file) {
            $migrationName = basename($file, '.php');
            
            if (in_array($migrationName, $executed)) {
                continue;
            }

            echo "  Migrating: {$migrationName}\n";

            $migration = require $file;
            
            if (is_array($migration) && isset($migration['up'])) {
                $migration['up']($this->db);
            }

            // Record migration
            $this->db->query("INSERT INTO migrations (migration, batch) VALUES (:migration, :batch)");
            $this->db->bind(':migration', $migrationName);
            $this->db->bind(':batch', $batch);
            $this->db->execute();

            echo "  Migrated:  {$migrationName} ✓\n";
            $ran++;
        }

        if ($ran === 0) {
            echo "  Nothing to migrate.\n";
        } else {
            echo "\n  Ran {$ran} migration(s) successfully.\n";
        }
    }

    /**
     * Rollback last batch of migrations
     */
    public function down()
    {
        $this->db->query("SELECT MAX(batch) as max_batch FROM migrations");
        $result = $this->db->single();
        $lastBatch = $result['max_batch'] ?? 0;

        if ($lastBatch === 0) {
            echo "  Nothing to rollback.\n";
            return;
        }

        $this->db->query("SELECT migration FROM migrations WHERE batch = :batch ORDER BY id DESC");
        $this->db->bind(':batch', $lastBatch);
        $migrations = $this->db->resultSet();

        foreach ($migrations as $row) {
            $migrationName = $row['migration'];
            $file = $this->migrationsPath . '/' . $migrationName . '.php';

            if (!file_exists($file)) {
                echo "  Migration file not found: {$migrationName}\n";
                continue;
            }

            echo "  Rolling back: {$migrationName}\n";

            $migration = require $file;
            
            if (is_array($migration) && isset($migration['down'])) {
                $migration['down']($this->db);
            }

            $this->db->query("DELETE FROM migrations WHERE migration = :migration");
            $this->db->bind(':migration', $migrationName);
            $this->db->execute();

            echo "  Rolled back: {$migrationName} ✓\n";
        }
    }

    /**
     * Drop all tables and re-run all migrations
     */
    public function fresh()
    {
        echo "  Dropping all tables...\n";

        // Disable FK checks for drops
        $this->db->query("SET FOREIGN_KEY_CHECKS = 0");
        $this->db->execute();

        $this->db->query("SHOW TABLES");
        $tables = $this->db->resultSet();

        foreach ($tables as $table) {
            $tableName = array_values($table)[0];
            $this->db->query("DROP TABLE IF EXISTS `{$tableName}`");
            $this->db->execute();
            echo "    Dropped: {$tableName}\n";
        }

        $this->db->query("SET FOREIGN_KEY_CHECKS = 1");
        $this->db->execute();

        echo "  All tables dropped.\n\n";

        // Recreate migrations table and run
        $this->ensureMigrationsTable();
        $this->up();
    }

    /**
     * Show current migration status
     */
    public function status()
    {
        $executed = $this->getExecutedMigrations();
        $files = $this->getMigrationFiles();

        echo "\n  Migration Status:\n";
        echo "  " . str_repeat('-', 60) . "\n";
        echo sprintf("  %-50s %s\n", "Migration", "Status");
        echo "  " . str_repeat('-', 60) . "\n";

        foreach ($files as $file) {
            $name = basename($file, '.php');
            $status = in_array($name, $executed) ? '✓ Ran' : '✗ Pending';
            echo sprintf("  %-50s %s\n", $name, $status);
        }

        echo "  " . str_repeat('-', 60) . "\n";
    }
}
