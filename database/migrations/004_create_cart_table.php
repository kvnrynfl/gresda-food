<?php

return [
    'up' => function ($db) {
        $db->query("
            CREATE TABLE `tbl_cart` (
                `id` CHAR(36) NOT NULL,
                `user_id` CHAR(36) NOT NULL,
                `food_id` CHAR(36) NOT NULL,
                `qty` INT UNSIGNED NOT NULL DEFAULT 1,
                `notes` TEXT DEFAULT NULL,
                `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                UNIQUE KEY `uk_cart_user_food` (`user_id`, `food_id`),
                KEY `idx_cart_user` (`user_id`),
                KEY `idx_cart_food` (`food_id`),
                CONSTRAINT `fk_cart_user` FOREIGN KEY (`user_id`) 
                    REFERENCES `tbl_users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `fk_cart_food` FOREIGN KEY (`food_id`) 
                    REFERENCES `tbl_food`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
        $db->execute();
    },
    'down' => function ($db) {
        $db->query("DROP TABLE IF EXISTS `tbl_cart`");
        $db->execute();
    }
];
