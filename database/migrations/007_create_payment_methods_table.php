<?php

return [
    'up' => function ($db) {
        $db->query("
            CREATE TABLE `tbl_payment_methods` (
                `id` CHAR(36) NOT NULL,
                `name` VARCHAR(50) NOT NULL,
                `type` ENUM('bank_transfer','e_wallet') NOT NULL DEFAULT 'bank_transfer',
                `account_number` VARCHAR(50) NOT NULL,
                `account_name` VARCHAR(100) NOT NULL,
                `icon` VARCHAR(255) DEFAULT NULL,
                `instructions` TEXT DEFAULT NULL,
                `is_active` TINYINT(1) NOT NULL DEFAULT 1,
                `sort_order` INT NOT NULL DEFAULT 0,
                `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                KEY `idx_pm_active` (`is_active`),
                KEY `idx_pm_sort` (`sort_order`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
        $db->execute();
    },
    'down' => function ($db) {
        $db->query("DROP TABLE IF EXISTS `tbl_payment_methods`");
        $db->execute();
    }
];
