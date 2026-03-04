<?php

return [
    'up' => function ($db) {
        $db->query("
            CREATE TABLE `tbl_email_verifications` (
                `id` CHAR(36) NOT NULL,
                `user_id` CHAR(36) NOT NULL,
                `email` VARCHAR(150) NOT NULL,
                `token` VARCHAR(100) NOT NULL,
                `otp_code` CHAR(64) NULL DEFAULT NULL,
                `expires_at` TIMESTAMP NOT NULL,
                `verified_at` TIMESTAMP NULL DEFAULT NULL,
                `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                KEY `idx_ev_user` (`user_id`),
                KEY `idx_ev_token` (`token`),
                KEY `idx_ev_otp` (`otp_code`),
                KEY `idx_ev_expires` (`expires_at`),
                CONSTRAINT `fk_ev_user` FOREIGN KEY (`user_id`) 
                    REFERENCES `tbl_users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
        $db->execute();
    },
    'down' => function ($db) {
        $db->query("DROP TABLE IF EXISTS `tbl_email_verifications`");
        $db->execute();
    }
];
