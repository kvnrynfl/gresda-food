<?php

return [
    'up' => function ($db) {
        $db->query("
            CREATE TABLE `tbl_food` (
                `id` CHAR(36) NOT NULL,
                `category_id` CHAR(36) NOT NULL,
                `name` VARCHAR(150) NOT NULL,
                `slug` VARCHAR(150) NOT NULL,
                `price` DECIMAL(12, 2) NOT NULL DEFAULT 0.00,
                `description` TEXT DEFAULT NULL,
                `image` VARCHAR(255) DEFAULT NULL,
                `weight` VARCHAR(50) DEFAULT NULL,
                `is_bestseller` TINYINT(1) NOT NULL DEFAULT 0,
                `is_new` TINYINT(1) NOT NULL DEFAULT 0,
                `is_spicy` TINYINT(1) NOT NULL DEFAULT 0,
                `is_active` TINYINT(1) NOT NULL DEFAULT 1,
                `stock` INT NOT NULL DEFAULT -1 COMMENT '-1 means unlimited',
                `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                UNIQUE KEY `uk_food_slug` (`slug`),
                KEY `idx_food_category` (`category_id`),
                KEY `idx_food_active` (`is_active`),
                KEY `idx_food_price` (`price`),
                CONSTRAINT `fk_food_category` FOREIGN KEY (`category_id`) 
                    REFERENCES `tbl_category`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
        $db->execute();
    },
    'down' => function ($db) {
        $db->query("DROP TABLE IF EXISTS `tbl_food`");
        $db->execute();
    }
];
