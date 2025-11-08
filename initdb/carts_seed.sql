-- Partial seed for carts and cart_details tables
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- Carts
DROP TABLE IF EXISTS `carts`;
CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cart_sum` int(11) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `carts` (`id`, `cart_sum`, `user_id`, `created_at`, `updated_at`) VALUES
(24, 2, 23, '2025-04-15 19:44:41', '2025-04-15 19:44:43');

-- Cart Details
DROP TABLE IF EXISTS `cart_details`;
CREATE TABLE `cart_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cartDetails_checkbox` tinyint(1) NOT NULL DEFAULT 0,
  `cartDetails_quantity` bigint(20) NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `cart_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `cart_details` (`id`, `cartDetails_checkbox`, `cartDetails_quantity`, `product_id`, `cart_id`, `created_at`, `updated_at`) VALUES
(39, 0, 1, 2, 24, '2025-04-15 19:44:41', '2025-04-17 03:40:30'),
(40, 0, 1, 3, 24, '2025-04-15 19:44:43', '2025-04-17 03:40:30');

-- Primary keys
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `cart_details`
  ADD PRIMARY KEY (`id`);

-- Auto increments
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

ALTER TABLE `cart_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;