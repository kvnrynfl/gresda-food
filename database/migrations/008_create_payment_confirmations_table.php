<?php

return [
    'up' => function ($db) {
        $db->query("
            CREATE TABLE `tbl_payment_confirmations` (
                `id` CHAR(36) NOT NULL,
                `order_id` CHAR(36) NOT NULL,
                `user_id` CHAR(36) NOT NULL,
                `payment_method_id` CHAR(36) NOT NULL,
                `sender_name` VARCHAR(100) NOT NULL COMMENT 'Name on the sending account',
                `sender_account` VARCHAR(50) DEFAULT NULL COMMENT 'Account number of sender',
                `amount` DECIMAL(12, 2) NOT NULL DEFAULT 0.00,
                `proof_image` VARCHAR(255) NOT NULL,
                `payment_date` DATE NOT NULL,
                `verified_at` TIMESTAMP NULL DEFAULT NULL,
                `verified_by` CHAR(36) DEFAULT NULL COMMENT 'Admin who verified',
                `rejection_reason` TEXT DEFAULT NULL,
                `status` ENUM('pending','verified','rejected') NOT NULL DEFAULT 'pending',
                `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                KEY `idx_pc_order` (`order_id`),
                KEY `idx_pc_user` (`user_id`),
                KEY `idx_pc_status` (`status`),
                CONSTRAINT `fk_pc_order` FOREIGN KEY (`order_id`) 
                    REFERENCES `tbl_orders`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `fk_pc_user` FOREIGN KEY (`user_id`) 
                    REFERENCES `tbl_users`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
                CONSTRAINT `fk_pc_payment_method` FOREIGN KEY (`payment_method_id`) 
                    REFERENCES `tbl_payment_methods`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
        $db->execute();
    },
    'down' => function ($db) {
        $db->query("DROP TABLE IF EXISTS `tbl_payment_confirmations`");
        $db->execute();
    }
];
