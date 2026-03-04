<?php

return [
    'up' => function ($db) {
        $db->query("
            CREATE TABLE `tbl_reviews` (
                `id` CHAR(36) NOT NULL,
                `user_id` CHAR(36) NOT NULL,
                `order_id` CHAR(36) NOT NULL,
                `rating` TINYINT UNSIGNED NOT NULL COMMENT '1-5 star rating',
                `title` VARCHAR(150) DEFAULT NULL,
                `message` TEXT NOT NULL,
                `admin_reply` TEXT DEFAULT NULL,
                `status` ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
                `reviewed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `approved_at` TIMESTAMP NULL DEFAULT NULL,
                `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                KEY `idx_review_user` (`user_id`),
                KEY `idx_review_order` (`order_id`),
                KEY `idx_review_status` (`status`),
                KEY `idx_review_rating` (`rating`),
                CONSTRAINT `fk_review_user` FOREIGN KEY (`user_id`) 
                    REFERENCES `tbl_users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `fk_review_order` FOREIGN KEY (`order_id`) 
                    REFERENCES `tbl_orders`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
        $db->execute();
    },
    'down' => function ($db) {
        $db->query("DROP TABLE IF EXISTS `tbl_reviews`");
        $db->execute();
    }
];
