<?php

return [
    'up' => function ($db) {
        $db->query("
            CREATE TABLE `tbl_orders` (
                `id` CHAR(36) NOT NULL,
                `order_number` VARCHAR(30) NOT NULL,
                `user_id` CHAR(36) NOT NULL,
                `status` ENUM('pending_payment','confirmed','processing','delivering','finished','cancelled') NOT NULL DEFAULT 'pending_payment',
                `subtotal` DECIMAL(12, 2) NOT NULL DEFAULT 0.00,
                `tax_amount` DECIMAL(12, 2) NOT NULL DEFAULT 0.00,
                `shipping_cost` DECIMAL(12, 2) NOT NULL DEFAULT 0.00,
                `discount_amount` DECIMAL(12, 2) NOT NULL DEFAULT 0.00,
                `grand_total` DECIMAL(12, 2) NOT NULL DEFAULT 0.00,
                `shipping_address` TEXT NOT NULL,
                `notes` TEXT DEFAULT NULL,
                `cancelled_reason` TEXT DEFAULT NULL,
                `ordered_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `paid_at` TIMESTAMP NULL DEFAULT NULL,
                `confirmed_at` TIMESTAMP NULL DEFAULT NULL,
                `delivering_at` TIMESTAMP NULL DEFAULT NULL,
                `finished_at` TIMESTAMP NULL DEFAULT NULL,
                `cancelled_at` TIMESTAMP NULL DEFAULT NULL,
                `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                UNIQUE KEY `uk_order_number` (`order_number`),
                KEY `idx_order_user` (`user_id`),
                KEY `idx_order_status` (`status`),
                KEY `idx_order_ordered_at` (`ordered_at`),
                CONSTRAINT `fk_order_user` FOREIGN KEY (`user_id`) 
                    REFERENCES `tbl_users`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
        $db->execute();
    },
    'down' => function ($db) {
        $db->query("DROP TABLE IF EXISTS `tbl_orders`");
        $db->execute();
    }
];
