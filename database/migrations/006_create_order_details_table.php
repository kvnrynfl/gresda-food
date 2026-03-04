<?php

return [
    'up' => function ($db) {
        $db->query("
            CREATE TABLE `tbl_order_details` (
                `id` CHAR(36) NOT NULL,
                `order_id` CHAR(36) NOT NULL,
                `food_id` CHAR(36) NOT NULL,
                `food_name` VARCHAR(150) NOT NULL COMMENT 'Snapshot of food name at time of order',
                `qty` INT UNSIGNED NOT NULL DEFAULT 1,
                `unit_price` DECIMAL(12, 2) NOT NULL DEFAULT 0.00 COMMENT 'Price per item at time of order',
                `subtotal` DECIMAL(12, 2) NOT NULL DEFAULT 0.00 COMMENT 'qty * unit_price',
                `notes` TEXT DEFAULT NULL,
                `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                KEY `idx_od_order` (`order_id`),
                KEY `idx_od_food` (`food_id`),
                CONSTRAINT `fk_od_order` FOREIGN KEY (`order_id`) 
                    REFERENCES `tbl_orders`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `fk_od_food` FOREIGN KEY (`food_id`) 
                    REFERENCES `tbl_food`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
        $db->execute();
    },
    'down' => function ($db) {
        $db->query("DROP TABLE IF EXISTS `tbl_order_details`");
        $db->execute();
    }
];
