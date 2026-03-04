<?php

return [
    'up' => function ($db) {
        $db->query("
            CREATE TABLE `tbl_password_resets` (
                `id` CHAR(36) NOT NULL,
                `email` VARCHAR(150) NOT NULL,
                `token` VARCHAR(100) NOT NULL,
                `expires_at` TIMESTAMP NOT NULL,
                `used_at` TIMESTAMP NULL DEFAULT NULL,
                `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                KEY `idx_pr_email` (`email`),
                KEY `idx_pr_token` (`token`),
                KEY `idx_pr_expires` (`expires_at`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
        $db->execute();
    },
    'down' => function ($db) {
        $db->query("DROP TABLE IF EXISTS `tbl_password_resets`");
        $db->execute();
    }
];
