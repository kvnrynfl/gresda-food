<?php

/**
 * Seeder Runner
 * 
 * Reads seeder files from database/seeders/ and runs them
 * to populate the database with test/demo data.
 */
class Seeder
{
    private $db;
    private $seedersPath;

    public function __construct()
    {
        $this->db = new Database();
        $this->seedersPath = __DIR__ . '/../../database/seeders';
    }

    /**
     * Run all seeders in order
     */
    public function runAll()
    {
        $files = glob($this->seedersPath . '/*.php');
        sort($files);

        if (empty($files)) {
            echo "  No seeders found.\n";
            return;
        }

        // Disable FK checks during seeding for easier insertion order
        $this->db->query("SET FOREIGN_KEY_CHECKS = 0");
        $this->db->execute();

        foreach ($files as $file) {
            $seederName = basename($file, '.php');
            echo "  Seeding: {$seederName}\n";

            $seeder = require $file;

            if (is_callable($seeder)) {
                $seeder($this->db);
            }

            echo "  Seeded:  {$seederName} ✓\n";
        }

        $this->db->query("SET FOREIGN_KEY_CHECKS = 1");
        $this->db->execute();

        echo "\n  All seeders completed successfully.\n";
    }

    /**
     * Run a specific seeder by name
     */
    public function run($seederName)
    {
        $file = $this->seedersPath . '/' . $seederName . '.php';

        if (!file_exists($file)) {
            echo "  Seeder not found: {$seederName}\n";
            return;
        }

        echo "  Seeding: {$seederName}\n";

        $seeder = require $file;

        if (is_callable($seeder)) {
            $seeder($this->db);
        }

        echo "  Seeded:  {$seederName} ✓\n";
    }
}
