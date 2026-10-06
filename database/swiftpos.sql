-- SwiftPOS MySQL database export

SET NAMES utf8mb4;
SET time_zone = '+00:00';

CREATE DATABASE IF NOT EXISTS `swiftpos`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE `swiftpos`;

DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `customers`;

CREATE TABLE `customers` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `full_name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `phone` VARCHAR(25) NULL,
    `password_hash` VARCHAR(255) NOT NULL,
    `status` VARCHAR(20) NOT NULL DEFAULT 'Active',
    `created_at` DATETIME NOT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `uq_customers_email` UNIQUE (`email`),
    CONSTRAINT `chk_customers_status`
        CHECK (`status` IN ('Active', 'Inactive'))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `users` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(50) NOT NULL,
    `full_name` VARCHAR(100) NOT NULL,
    `role` VARCHAR(50) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `attendance_status` VARCHAR(20) NOT NULL DEFAULT 'Clocked Out',
    `is_verified` BOOLEAN NOT NULL DEFAULT FALSE,
    `created_at` DATETIME NOT NULL,
    `avatar` VARCHAR(255) NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `uq_users_username` UNIQUE (`username`),
    CONSTRAINT `chk_users_role`
        CHECK (`role` IN ('Admin', 'Store Manager', 'Cashier', 'Inventory')),
    CONSTRAINT `chk_users_attendance_status`
        CHECK (`attendance_status` IN ('Clocked In', 'Clocked Out', 'PTO', 'AWOL'))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `customers`
    (`id`, `full_name`, `email`, `phone`, `password_hash`, `status`, `created_at`)
VALUES
    (101, 'Maria Santos', 'maria.santos@email.com', '+63 917 123 4567', '$2y$12$TWzz4CprqFLRcpI1foz0lOu5LVonqXpNRPc8SJ4G3HIRTIAJ54A9m', 'Active', '2026-09-17 00:00:00'),
    (102, 'Juan Dela Cruz', 'juan.delacruz@email.com', '+63 918 234 5678', '$2y$12$TWzz4CprqFLRcpI1foz0lOu5LVonqXpNRPc8SJ4G3HIRTIAJ54A9m', 'Active', '2026-09-17 00:00:00'),
    (103, 'Carla Reyes', 'carla.reyes@email.com', '+63 920 345 6789', '$2y$12$TWzz4CprqFLRcpI1foz0lOu5LVonqXpNRPc8SJ4G3HIRTIAJ54A9m', 'Active', '2026-09-17 00:00:00'),
    (104, 'Eduardo Ramos', 'eduardo.ramos@email.com', '+63 922 456 7890', '$2y$12$TWzz4CprqFLRcpI1foz0lOu5LVonqXpNRPc8SJ4G3HIRTIAJ54A9m', 'Active', '2026-09-17 00:00:00'),
    (105, 'Patricia Tan', 'patricia.tan@email.com', NULL, '$2y$12$TWzz4CprqFLRcpI1foz0lOu5LVonqXpNRPc8SJ4G3HIRTIAJ54A9m', 'Active', '2026-09-17 00:00:00');

INSERT INTO `users`
    (`id`, `username`, `full_name`, `role`, `password`, `attendance_status`, `is_verified`, `created_at`)
VALUES
    (1, 'admin_reign', 'Adrien Russel Tan', 'Admin', '$2y$12$6XKzQzeYseyy/SqiVpWNxOzHtt9QbPENSKFZkyZ23thuJZdUJunW6', 'Clocked In', TRUE, '2026-09-17 00:00:00'),
    (2, 'mgr_echo', 'Jericho Macarang', 'Store Manager', '$2y$12$bZdW5ukErvqYbm0Hbxka4.seM1NoF/tbJaVkh8pF8BNOdplSxnE1.', 'Clocked Out', TRUE, '2026-09-17 00:00:00'),
    (3, 'cashier_aaa', 'aaa', 'Cashier', '$2y$12$S1XsgbRXpbDurXLSzWO.9OSccR.ViIAuQFnyoAH0oL.rcnSjUQoLm', 'PTO', TRUE, '2026-09-17 00:00:00'),
    (4, 'cashier_bbb', 'bbb', 'Cashier', '$2y$12$S1XsgbRXpbDurXLSzWO.9OSccR.ViIAuQFnyoAH0oL.rcnSjUQoLm', 'Clocked Out', FALSE, '2026-09-17 00:00:00'),
    (5, 'inv_ccc', 'ccc', 'Inventory', '$2y$12$xE6EgdUIpyxar/XiCi6sdO6PyZGeETkxTBs43QdOfoiOpCPS87FzW', 'AWOL', TRUE, '2026-09-17 00:00:00');
