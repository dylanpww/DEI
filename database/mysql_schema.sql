-- ============================================================================
-- Crave (DEI) - MySQL Database Schema
-- ============================================================================
-- Generated from Laravel migrations for InfinityFree deployment.
-- Import this file via phpMyAdmin on InfinityFree Control Panel.
-- After importing, run the seeders or manually insert initial data.
-- ============================================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- -----------------------------------------------------------
-- 1. migrations table (Laravel migration tracking)
-- -----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `migrations` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `migration` VARCHAR(255) NOT NULL,
    `batch` INT NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------
-- 2. users table
-- -----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
    `user_ID` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `role` VARCHAR(255) NOT NULL DEFAULT 'user',
    `remember_token` VARCHAR(100) DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    `status` VARCHAR(255) NOT NULL DEFAULT 'active',
    `warning_count` INT NOT NULL DEFAULT 0,
    `blocked_until` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`user_ID`),
    UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------
-- 3. password_reset_tokens table
-- -----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
    `email` VARCHAR(255) NOT NULL,
    `token` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------
-- 4. sessions table
-- -----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `sessions` (
    `id` VARCHAR(255) NOT NULL,
    `user_id` BIGINT UNSIGNED DEFAULT NULL,
    `ip_address` VARCHAR(45) DEFAULT NULL,
    `user_agent` TEXT DEFAULT NULL,
    `payload` LONGTEXT NOT NULL,
    `last_activity` INT NOT NULL,
    PRIMARY KEY (`id`),
    KEY `sessions_user_id_index` (`user_id`),
    KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------
-- 5. cache table
-- -----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `cache` (
    `key` VARCHAR(255) NOT NULL,
    `value` MEDIUMTEXT NOT NULL,
    `expiration` BIGINT NOT NULL,
    PRIMARY KEY (`key`),
    KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------
-- 6. cache_locks table
-- -----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `cache_locks` (
    `key` VARCHAR(255) NOT NULL,
    `owner` VARCHAR(255) NOT NULL,
    `expiration` BIGINT NOT NULL,
    PRIMARY KEY (`key`),
    KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------
-- 7. jobs table
-- -----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `jobs` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `queue` VARCHAR(255) NOT NULL,
    `payload` LONGTEXT NOT NULL,
    `attempts` TINYINT UNSIGNED NOT NULL,
    `reserved_at` INT UNSIGNED DEFAULT NULL,
    `available_at` INT UNSIGNED NOT NULL,
    `created_at` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`),
    KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------
-- 8. job_batches table
-- -----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `job_batches` (
    `id` VARCHAR(255) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `total_jobs` INT NOT NULL,
    `pending_jobs` INT NOT NULL,
    `failed_jobs` INT NOT NULL,
    `failed_job_ids` LONGTEXT NOT NULL,
    `options` MEDIUMTEXT DEFAULT NULL,
    `cancelled_at` INT DEFAULT NULL,
    `created_at` INT NOT NULL,
    `finished_at` INT DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------
-- 9. failed_jobs table
-- -----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `failed_jobs` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `uuid` VARCHAR(255) NOT NULL,
    `connection` TEXT NOT NULL,
    `queue` TEXT NOT NULL,
    `payload` LONGTEXT NOT NULL,
    `exception` LONGTEXT NOT NULL,
    `failed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------
-- 10. categories table
-- -----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `categories` (
    `category_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `description` TEXT DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------
-- 11. addresses table
-- -----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `addresses` (
    `Address_ID` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_ID` BIGINT UNSIGNED NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `completeAddress` TEXT NOT NULL,
    `telephoneNumber` VARCHAR(255) NOT NULL,
    `notes` TEXT DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`Address_ID`),
    KEY `addresses_user_id_foreign` (`user_ID`),
    CONSTRAINT `addresses_user_id_foreign` FOREIGN KEY (`user_ID`) REFERENCES `users` (`user_ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------
-- 12. carts table
-- -----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `carts` (
    `cart_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `totalPrice` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`cart_id`),
    KEY `carts_user_id_foreign` (`user_id`),
    CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------
-- 13. products table (with image column)
-- -----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `products` (
    `product_ID` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `category_id` BIGINT UNSIGNED NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `actualPrice` DECIMAL(10,2) NOT NULL,
    `discount` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    `stock` INT NOT NULL,
    `status` VARCHAR(255) NOT NULL DEFAULT 'available',
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    `image` VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY (`product_ID`),
    KEY `products_user_id_foreign` (`user_id`),
    KEY `products_category_id_foreign` (`category_id`),
    CONSTRAINT `products_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_ID`) ON DELETE CASCADE,
    CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------
-- 14. orders table
-- -----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `orders` (
    `order_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `address_ID` BIGINT UNSIGNED NOT NULL,
    `totalPrice` DECIMAL(10,2) NOT NULL,
    `status` VARCHAR(255) NOT NULL DEFAULT 'pending',
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`order_id`),
    KEY `orders_user_id_foreign` (`user_id`),
    KEY `orders_address_id_foreign` (`address_ID`),
    CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_ID`) ON DELETE CASCADE,
    CONSTRAINT `orders_address_id_foreign` FOREIGN KEY (`address_ID`) REFERENCES `addresses` (`Address_ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------
-- 15. products_carts table (pivot)
-- -----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `products_carts` (
    `product_cart_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `cart_id` BIGINT UNSIGNED NOT NULL,
    `product_id` BIGINT UNSIGNED NOT NULL,
    `qty` INT NOT NULL,
    `subTotal` DECIMAL(10,2) NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`product_cart_id`),
    KEY `products_carts_cart_id_foreign` (`cart_id`),
    KEY `products_carts_product_id_foreign` (`product_id`),
    CONSTRAINT `products_carts_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`cart_id`) ON DELETE CASCADE,
    CONSTRAINT `products_carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------
-- 16. orders_items table
-- -----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `orders_items` (
    `orders_item_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `order_id` BIGINT UNSIGNED NOT NULL,
    `product_id` BIGINT UNSIGNED NOT NULL,
    `qty` INT NOT NULL,
    `subTotal` DECIMAL(10,2) NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`orders_item_id`),
    KEY `orders_items_order_id_foreign` (`order_id`),
    KEY `orders_items_product_id_foreign` (`product_id`),
    CONSTRAINT `orders_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
    CONSTRAINT `orders_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------
-- 17. transactions table
-- -----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `transactions` (
    `transaction_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `order_id` BIGINT UNSIGNED NOT NULL,
    `midtrans_transaction_id` VARCHAR(255) DEFAULT NULL,
    `payment_type` VARCHAR(255) DEFAULT NULL,
    `gross_amount` DECIMAL(10,2) NOT NULL,
    `status` VARCHAR(255) NOT NULL DEFAULT 'pending',
    `snap_token` VARCHAR(255) DEFAULT NULL,
    `snap_url` VARCHAR(255) DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`transaction_id`),
    UNIQUE KEY `transactions_midtrans_transaction_id_unique` (`midtrans_transaction_id`),
    KEY `transactions_order_id_foreign` (`order_id`),
    CONSTRAINT `transactions_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------
-- 18. reviews table
-- -----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `reviews` (
    `review_ID` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_ID` BIGINT UNSIGNED NOT NULL,
    `product_ID` BIGINT UNSIGNED NOT NULL,
    `rating` INT NOT NULL,
    `comment` TEXT DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`review_ID`),
    KEY `reviews_user_id_foreign` (`user_ID`),
    KEY `reviews_product_id_foreign` (`product_ID`),
    CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_ID`) REFERENCES `users` (`user_ID`) ON DELETE CASCADE,
    CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_ID`) REFERENCES `products` (`product_ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- Record all migrations as "already run" so Laravel won't try to re-run them
-- ============================================================================
INSERT INTO `migrations` (`migration`, `batch`) VALUES
('0001_01_01_000000_create_users_table', 1),
('0001_01_01_000001_create_cache_table', 1),
('0001_01_01_000002_create_jobs_table', 1),
('2026_05_05_114014_create_addresses_table', 1),
('2026_05_05_114014_create_carts_table', 1),
('2026_05_05_114014_create_categories_table', 1),
('2026_05_05_114014_create_products_table', 1),
('2026_05_05_114015_create_orders_table', 1),
('2026_05_05_114015_create_products_carts_table', 1),
('2026_05_05_114437_create_orders_items_table', 1),
('2026_05_05_115208_create_transactions_table', 1),
('2026_05_05_132212_add_image_to_products_table', 1),
('2026_05_05_225809_create_reviews_table', 1),
('2026_05_06_042811_add_status_to_users_table', 1);

-- ============================================================================
-- Seed Data: Default Users
-- ============================================================================
-- Password for all users is: password (bcrypt hash)
-- You may need to regenerate these hashes if the bcrypt rounds differ.
-- ============================================================================
INSERT INTO `users` (`username`, `email`, `password`, `role`, `status`, `warning_count`, `created_at`, `updated_at`) VALUES
('Super Admin', 'admin@crave', '$2y$12$LQv3c1yqBo9SkvXS7rPXae.gg/nOzcA6dsMUUzMQbkmfQvQr/BHVS', 'admin', 'active', 0, NOW(), NOW()),
('Crave Partner Resto', 'partner@crave', '$2y$12$LQv3c1yqBo9SkvXS7rPXae.gg/nOzcA6dsMUUzMQbkmfQvQr/BHVS', 'seller', 'active', 0, NOW(), NOW()),
('user', 'user@crave', '$2y$12$LQv3c1yqBo9SkvXS7rPXae.gg/nOzcA6dsMUUzMQbkmfQvQr/BHVS', 'user', 'active', 0, NOW(), NOW());

-- ============================================================================
-- Seed Data: Categories
-- ============================================================================
INSERT INTO `categories` (`name`, `description`, `created_at`, `updated_at`) VALUES
('Makanan', 'Kategori untuk semua jenis makanan.', NOW(), NOW()),
('Minuman', 'Kategori untuk semua jenis minuman.', NOW(), NOW());

SET FOREIGN_KEY_CHECKS = 1;
