<?php

return [
    'up' => function ($db) {
        $db->query("
            CREATE TABLE `tbl_login_attempts` (
                `id` INT AUTO_INCREMENT,
                `ip_address` VARCHAR(45) NOT NULL,
                `email` VARCHAR(150) NOT NULL,
                `attempted_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `success` TINYINT(1) NOT NULL DEFAULT 0,
                PRIMARY KEY (`id`),
                KEY `idx_la_ip_email` (`ip_address`, `email`),
                KEY `idx_la_attempted` (`attempted_at`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
        $db->execute();
    },
    'down' => function ($db) {
        $db->query("DROP TABLE IF EXISTS `tbl_login_attempts`");
        $db->execute();
    }
];
