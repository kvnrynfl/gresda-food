<?php

/**
 * Gresda Food — Database Migration & Seeder CLI Tool
 * 
 * Usage:
 *   php migrate.php up       — Run pending migrations
 *   php migrate.php down     — Rollback last batch
 *   php migrate.php fresh    — Drop all tables & re-run migrations
 *   php migrate.php seed     — Run all seeders
 *   php migrate.php status   — Show migration status
 *   php migrate.php fresh --seed  — Fresh + seed in one command
 */

// Ensure running from CLI
if (php_sapi_name() !== 'cli') {
    die('This script can only be run from the command line.');
}

echo "\n";
echo "  ╔═══════════════════════════════════════════╗\n";
echo "  ║   Gresda Food — Database Migration Tool   ║\n";
echo "  ╚═══════════════════════════════════════════╝\n\n";

// Bootstrap the application
require_once __DIR__ . '/app/init.php';

// Parse command
$command = $argv[1] ?? 'status';
$flags = array_slice($argv, 2);

try {
    switch ($command) {
        case 'up':
            echo "  Running migrations...\n\n";
            $migration = new Migration();
            $migration->up();
            break;

        case 'down':
            echo "  Rolling back last batch...\n\n";
            $migration = new Migration();
            $migration->down();
            break;

        case 'fresh':
            echo "  ⚠ Dropping ALL tables and re-running migrations...\n\n";
            $migration = new Migration();
            $migration->fresh();
            
            if (in_array('--seed', $flags)) {
                echo "\n  Running seeders...\n\n";
                $seeder = new Seeder();
                $seeder->runAll();
            }
            break;

        case 'seed':
            echo "  Running seeders...\n\n";
            $seeder = new Seeder();
            $seeder->runAll();
            break;

        case 'status':
            $migration = new Migration();
            $migration->status();
            break;

        default:
            echo "  Unknown command: {$command}\n";
            echo "  Available commands: up, down, fresh, seed, status\n";
            echo "  Flags: --seed (with fresh command)\n";
            break;
    }
} catch (Exception $e) {
    echo "\n  ✗ Error: " . $e->getMessage() . "\n";
    if (getenv('APP_DEBUG') === 'true') {
        echo "  File: " . $e->getFile() . ":" . $e->getLine() . "\n";
        echo "  Trace:\n" . $e->getTraceAsString() . "\n";
    }
    exit(1);
}

echo "\n  Done.\n\n";
