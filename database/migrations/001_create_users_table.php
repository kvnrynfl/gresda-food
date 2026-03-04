<?php

return [
    'up' => function ($db) {
        $db->query("
            CREATE TABLE `tbl_users` (
                `id` CHAR(36) NOT NULL,
                `full_name` VARCHAR(100) NOT NULL,
                `username` VARCHAR(150) NOT NULL,
                `email` VARCHAR(150) NOT NULL,
                `password` VARCHAR(255) NOT NULL,
                `phone` VARCHAR(20) DEFAULT NULL,
                `address` TEXT DEFAULT NULL,
                `img_user` VARCHAR(255) NOT NULL DEFAULT 'default.jpg',
                `role` ENUM('admin', 'customer') NOT NULL DEFAULT 'customer',
                `email_verified_at` TIMESTAMP NULL DEFAULT NULL,
                `remember_token` VARCHAR(100) DEFAULT NULL,
                `is_active` TINYINT(1) NOT NULL DEFAULT 1,
                `last_login_at` TIMESTAMP NULL DEFAULT NULL,
                `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                UNIQUE KEY `uk_users_email` (`email`),
                UNIQUE KEY `uk_users_username` (`username`),
                KEY `idx_users_role` (`role`),
                KEY `idx_users_is_active` (`is_active`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
        $db->execute();
    },
    'down' => function ($db) {
        $db->query("DROP TABLE IF EXISTS `tbl_users`");
        $db->execute();
    }
];
