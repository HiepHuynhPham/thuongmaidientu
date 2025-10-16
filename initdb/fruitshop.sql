-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Apr 17, 2025 at 01:12 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fruitshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cart_sum` int(11) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `cart_sum`, `user_id`, `created_at`, `updated_at`) VALUES
(24, 2, 23, '2025-04-15 19:44:41', '2025-04-15 19:44:43');

-- --------------------------------------------------------

--
-- Table structure for table `cart_details`
--

CREATE TABLE `cart_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cartDetails_checkbox` tinyint(1) NOT NULL DEFAULT 0,
  `cartDetails_quantity` bigint(20) NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `cart_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_details`
--

INSERT INTO `cart_details` (`id`, `cartDetails_checkbox`, `cartDetails_quantity`, `product_id`, `cart_id`, `created_at`, `updated_at`) VALUES
(39, 0, 1, 2, 24, '2025-04-15 19:44:41', '2025-04-17 03:40:30'),
(40, 0, 1, 3, 24, '2025-04-15 19:44:43', '2025-04-17 03:40:30');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `address_id` bigint(20) DEFAULT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `order_status` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `receiver_phone` varchar(20) DEFAULT NULL,
  `receiver_address` varchar(255) DEFAULT NULL,
  `receiver_name` varchar(100) DEFAULT NULL,
  `payment_method` varchar(50) NOT NULL,
  `pay` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `address_id`, `total_price`, `order_status`, `created_at`, `updated_at`, `receiver_phone`, `receiver_address`, `receiver_name`, `payment_method`, `pay`) VALUES
(29, 23, NULL, 100000.00, 'shipping', '2025-03-19 22:56:19', '2025-03-20 03:44:37', '0123456', '123 dak mar dak ha kon tum', 'hoang tan dung', 'MOMO', 1),
(30, 23, NULL, 40000.00, 'pending', '2025-03-20 22:33:20', '2025-03-20 22:34:32', '0123456', '123 dak mar dak ha kon tum', 'hoang tan dung', 'MOMO', 1),
(31, 23, NULL, 120000.00, 'pending', '2025-03-20 23:19:09', '2025-03-20 23:19:36', '0123456', '123 dak mar dak ha kon tum', 'hoang tan dung', 'MOMO', 1),
(32, 23, NULL, 90000.00, 'pending', '2025-03-23 19:53:17', '2025-03-23 19:54:02', '0123456', '123 dak mar dak ha kon tum', 'hoang tan dung', 'MOMO', 1),
(33, 23, NULL, 120000.00, 'pending', '2025-03-23 21:49:34', '2025-03-23 21:50:08', '0123456', '123 dak mar dak ha kon tum', 'hoang tan dung', 'MOMO', 1),
(34, 23, NULL, 470000.00, 'cancel', '2025-04-14 09:07:04', '2025-04-14 09:08:30', '0123456', '123 dak mar dak ha kon tum', 'hoang tan dung', 'MOMO', 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `payment_method` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `quantity`, `payment_method`, `price`, `created_at`, `updated_at`) VALUES
(27, 29, 1, 1, 'MOMO', 100000.00, '2025-03-19 22:56:19', '2025-03-19 22:56:19'),
(28, 30, 7, 1, 'MOMO', 40000.00, '2025-03-20 22:33:20', '2025-03-20 22:33:20'),
(29, 31, 2, 1, 'MOMO', 120000.00, '2025-03-20 23:19:09', '2025-03-20 23:19:09'),
(30, 32, 6, 1, 'MOMO', 90000.00, '2025-03-23 19:53:17', '2025-03-23 19:53:17'),
(31, 33, 2, 1, 'MOMO', 120000.00, '2025-03-23 21:49:34', '2025-03-23 21:49:34'),
(32, 34, 20, 1, 'MOMO', 120000.00, '2025-04-14 09:07:04', '2025-04-14 09:07:04'),
(33, 34, 24, 1, 'MOMO', 70000.00, '2025-04-14 09:07:04', '2025-04-14 09:07:04'),
(34, 34, 22, 1, 'MOMO', 280000.00, '2025-04-14 09:07:04', '2025-04-14 09:07:04');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_detailDesc` text DEFAULT NULL,
  `product_shortDesc` text DEFAULT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `product_factory` text DEFAULT NULL,
  `product_target` text DEFAULT NULL,
  `product_type` text DEFAULT NULL,
  `product_quantity` int(11) NOT NULL,
  `product_image_url` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `star` int(11) DEFAULT 5
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `product_detailDesc`, `product_shortDesc`, `product_price`, `product_factory`, `product_target`, `product_type`, `product_quantity`, `product_image_url`, `created_at`, `updated_at`, `star`) VALUES
(1, 'Quả sầu riêng', 'Sầu riêng Thái, cơm vàng đậm, mùi thơm nồng, hạt lép.', 'Sầu riêng Thái.', 100000.00, 'FoodMap', 'Ăn tươi - làm bánh', 'Trái cây tươi', 100, '1.jpg', NULL, NULL, 5),
(2, 'Táo đỏ Mỹ', 'Táo nhập khẩu Mỹ, quả to, vị ngọt, giòn, giàu dinh dưỡng.', 'Táo Mỹ giòn, ngọt.', 120000.00, 'Vinfruits', 'Ăn tươi', 'Trái cây nhập khẩu', 80, '2.jpg', NULL, NULL, 5),
(3, 'Cam sành Việt Nam', 'Cam sành nhiều nước, vị ngọt thanh, chứa nhiều vitamin C.', 'Cam sành mọng nước.', 70000.00, 'Nông trại Việt', 'Ăn tươi - vắt nước', 'Trái cây nội địa', 90, '3.jpg', NULL, NULL, 5),
(4, 'Chuối Laba', 'Chuối đặc sản Lâm Đồng, quả to, thơm ngon, ngọt đậm.', 'Chuối Laba ngọt.', 50000.00, 'Nông trại Đà Lạt', 'Ăn tươi - làm bánh', 'Trái cây nội địa', 120, '4.jpg', NULL, NULL, 5),
(5, 'Xoài cát Hòa Lộc', 'Xoài Hòa Lộc ngọt đậm, thịt dẻo, hương thơm đặc trưng.', 'Xoài Hòa Lộc ngọt.', 140000.00, 'VietGAP', 'Ăn tươi - sinh tố', 'Trái cây nội địa', 60, '5.jpg', NULL, NULL, 5),
(6, 'Bưởi da xanh', 'Bưởi da xanh múi to, không hạt, vị ngọt thanh mát.', 'Bưởi da xanh ngon.', 90000.00, 'Bến Tre Fruits', 'Ăn tươi - làm salad', 'Trái cây nội địa', 75, '6.jpg', NULL, NULL, 5),
(7, 'Dưa hấu ruột đỏ', 'Dưa hấu ruột đỏ, vỏ mỏng, ngọt mát, trồng theo tiêu chuẩn sạch.', 'Dưa hấu đỏ, ngọt.', 40000.00, 'Farm Fresh', 'Ăn tươi - ép nước', 'Trái cây nội địa', 110, '7.jpg', NULL, NULL, 5),
(8, 'Lê Hàn Quốc', 'Lê nhập khẩu Hàn Quốc, quả to, vị ngọt mát, nhiều nước.', 'Lê Hàn Quốc ngọt.', 150000.00, 'KoreaFruit', 'Ăn tươi', 'Trái cây nhập khẩu', 50, '8.jpg', NULL, NULL, 5),
(9, 'Nho Mỹ không hạt', 'Nho Mỹ quả to, vỏ mỏng, vị ngọt đậm, giàu dinh dưỡng.', 'Nho Mỹ không hạt.', 200000.00, 'USA Fruit', 'Ăn tươi - làm bánh', 'Trái cây nhập khẩu', 40, '9.jpg', NULL, NULL, 5),
(10, 'Mít Thái', 'Mít Thái siêu ngọt, múi to, vàng óng, giàu vitamin.', 'Mít Thái thơm, ngọt.', 60000.00, 'Nông sản Việt', 'Ăn tươi', 'Trái cây nội địa', 95, '10.jpg', NULL, NULL, 5),
(11, 'Dâu tây Đà Lạt', 'Dâu tây đỏ mọng, vị chua ngọt tự nhiên, trồng công nghệ cao.', 'Dâu Đà Lạt đỏ mọng.', 250000.00, 'FreshFarm', 'Ăn tươi - làm bánh', 'Trái cây nội địa', 35, '11.jpg', NULL, NULL, 5),
(12, 'Sầu riêng Ri6', 'Sầu riêng Ri6, cơm vàng đậm, hạt lép, vị béo ngọt.', 'Sầu riêng Ri6 béo.', 300000.00, 'Bến Tre Fruits', 'Ăn tươi - làm bánh', 'Trái cây nội địa', 25, '12.jpg', NULL, NULL, 5),
(13, 'Ổi lê Đài Loan', 'Ổi lê Đài Loan, vỏ xanh, ruột trắng, giòn ngọt, ít hạt.', 'Ổi lê Đài Loan giòn.', 50000.00, 'Nông sản Việt', 'Ăn tươi', 'Trái cây nội địa', 85, '13.jpg', NULL, NULL, 5),
(14, 'Chôm chôm nhãn', 'Chôm chôm nhãn vỏ mỏng, thịt trắng dày, vị ngọt.', 'Chôm chôm nhãn ngọt.', 80000.00, 'Miền Tây Fruits', 'Ăn tươi', 'Trái cây nội địa', 70, '14.jpg', NULL, NULL, 5),
(15, 'Thanh long ruột đỏ', 'Thanh long ruột đỏ ngọt dịu, nhiều nước, tốt cho sức khỏe.', 'Thanh long ruột đỏ.', 70000.00, 'Bình Thuận Fruits', 'Ăn tươi - làm sinh tố', 'Trái cây nội địa', 90, '15.jpg', NULL, NULL, 5),
(16, 'Dưa lưới Nhật', 'Dưa lưới Nhật Bản, vị ngọt thanh, thịt giòn, thơm nhẹ.', 'Dưa lưới Nhật.', 180000.00, 'Japan Fruits', 'Ăn tươi - ép nước', 'Trái cây nhập khẩu', 30, '16.jpg', NULL, NULL, 5),
(17, 'Lựu đỏ Ấn Độ', 'Lựu đỏ nhập khẩu Ấn Độ, hạt mọng nước, vị ngọt thanh.', 'Lựu đỏ Ấn Độ.', 130000.00, 'Indian Fruits', 'Ăn tươi', 'Trái cây nhập khẩu', 55, '17.jpg', NULL, NULL, 5),
(18, 'Mận hậu Sơn La', 'Mận hậu Sơn La, vỏ đỏ, vị chua nhẹ, ngọt thanh, giòn.', 'Mận hậu Sơn La.', 60000.00, 'Nông sản Việt', 'Ăn tươi', 'Trái cây nội địa', 100, '18.jpg', NULL, NULL, 5),
(19, 'Bơ 034', 'Bơ 034 Lâm Đồng, vỏ xanh, cơm dẻo, vị béo ngậy, ít xơ.', 'Bơ 034 béo.', 80000.00, 'Đà Lạt Fruits', 'Ăn tươi - làm sinh tố', 'Trái cây nội địa', 85, '19.jpg', NULL, NULL, 5),
(20, 'Măng cụt Thái', 'Măng cụt Thái, vỏ mỏng, ruột trắng, vị ngọt thanh.', 'Măng cụt Thái.', 120000.00, 'Thai Fruits', 'Ăn tươi', 'Trái cây nhập khẩu', 60, '20.jpg', NULL, NULL, 5),
(21, 'Dứa (Thơm) Queen', 'Dứa Queen, ruột vàng, thơm ngọt, ít xơ, giàu vitamin C.', 'Dứa Queen thơm.', 40000.00, 'Nông sản Việt', 'Ăn tươi - làm nước ép', 'Trái cây nội địa', 95, '21.jpg', NULL, NULL, 5),
(22, 'Việt quất Mỹ', 'Việt quất nhập Mỹ, quả nhỏ, giàu chất chống oxy hóa.', 'Việt quất Mỹ.', 280000.00, 'USA Fruits', 'Ăn tươi - làm bánh', 'Trái cây nhập khẩu', 45, '22.jpg', NULL, NULL, 5),
(23, 'Mơ vàng', 'Mơ vàng, vị chua nhẹ, giòn, dùng làm ô mai, nước giải khát.', 'Mơ vàng giòn.', 50000.00, 'Nông sản Việt', 'Ăn tươi - làm ô mai', 'Trái cây nội địa', 90, '23.jpg', NULL, NULL, 5),
(24, 'Hồng giòn Đà Lạt', 'Hồng giòn Đà Lạt, vỏ mỏng, thịt giòn, vị ngọt tự nhiên.', 'Hồng giòn Đà Lạt.', 70000.00, 'Đà Lạt Fruits', 'Ăn tươi', 'Trái cây nội địa', 75, '24.jpg', NULL, NULL, 5),
(25, 'Mít tố nữ', 'Mít tố nữ, múi nhỏ, vị ngọt đậm, thơm đặc trưng.', 'Mít tố nữ thơm.', 60000.00, 'Miền Tây Fruits', 'Ăn tươi', 'Trái cây nội địa', 80, '25.jpg', NULL, NULL, 5);

-- --------------------------------------------------------

--
-- Table structure for table `product_discounts`
--

CREATE TABLE `product_discounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `discount_percent` decimal(10,2) NOT NULL,
  `start_date` timestamp NULL DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_discounts`
--

INSERT INTO `product_discounts` (`id`, `product_id`, `discount_percent`, `start_date`, `end_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 6, 30.00, '2025-04-16 17:00:00', '2025-05-16 17:00:00', 0, '2025-04-15 10:04:50', '2025-04-15 11:50:31'),
(2, 2, 10.00, '2025-04-16 17:00:00', '2025-05-09 17:00:00', 1, '2025-04-15 11:45:01', '2025-04-15 11:45:01'),
(3, 9, 25.00, '2025-04-16 17:00:00', '2025-06-04 17:00:00', 1, '2025-04-15 11:45:20', '2025-04-15 11:45:20'),
(4, 17, 20.00, '2025-04-17 17:00:00', '2025-05-09 17:00:00', 1, '2025-04-15 11:45:42', '2025-04-15 11:45:42'),
(5, 19, 20.00, '2025-04-15 17:00:00', '2025-05-15 17:00:00', 1, '2025-04-15 11:45:59', '2025-04-15 11:45:59'),
(6, 18, 20.00, '2025-04-15 17:00:00', '2025-05-15 17:00:00', 1, '2025-04-15 11:46:25', '2025-04-15 11:46:25'),
(7, 20, 20.00, '2025-04-15 17:00:00', '2025-05-15 17:00:00', 1, '2025-04-15 11:46:46', '2025-04-15 11:46:46'),
(8, 22, 20.00, '2025-04-15 17:00:00', '2025-05-15 17:00:00', 1, '2025-04-15 11:47:04', '2025-04-15 11:47:04');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `product_id`, `rating`, `comment`, `created_at`, `updated_at`) VALUES
(2, 23, 2, 5, 'táo nhìn ngon quá đi thôi', '2025-04-14 20:36:07', '2025-04-14 20:36:07'),
(10, 23, 2, 5, 'hoàng tấn dũng', '2025-04-15 02:11:15', '2025-04-15 02:11:15');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_name` varchar(255) NOT NULL,
  `role_description` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `role_description`, `created_at`, `updated_at`) VALUES
(1, 'ADMIN', 'Quản trị viên hệ thống', NULL, NULL),
(2, 'SHIPPER', 'Người vận chuyển đơn hàng', NULL, NULL),
(3, 'USER', 'Người dùng thông thường', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shippings`
--

CREATE TABLE `shippings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `address_id` char(36) NOT NULL,
  `shipping_method` varchar(50) NOT NULL,
  `shipping_status` varchar(50) NOT NULL DEFAULT 'Đang chuẩn bị',
  `estimated_delivery_date` timestamp NULL DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_phone` varchar(20) DEFAULT NULL,
  `user_avatar` text DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_address` varchar(255) DEFAULT NULL,
  `provider` varchar(50) DEFAULT NULL,
  `provider_id` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_name`, `user_email`, `user_password`, `user_phone`, `user_avatar`, `role_id`, `created_at`, `updated_at`, `user_address`, `provider`, `provider_id`) VALUES
(1, 'Admin Account', 'admin@gmail.com', '$2y$10$0QX0lZXtx/i6Td.qRZB8DusIw1jcqWt8ETTgM8gWR/5RThWK.04vC', '0123456789', 'default-google.png', 1, NULL, NULL, 'TP HCM', NULL, NULL),
(2, 'Shipper Account', 'shipper@gmail.com', '$2y$10$0QX0lZXtx/i6Td.qRZB8DusIw1jcqWt8ETTgM8gWR/5RThWK.04vC', '0987654321', 'default-google.png', 2, NULL, NULL, 'TP HCM', NULL, NULL),
(3, 'User Account', 'user@gmail.com', '$2y$10$0QX0lZXtx/i6Td.qRZB8DusIw1jcqWt8ETTgM8gWR/5RThWK.04vC', '0345678912', 'default-google.png', 3, NULL, NULL, 'TP HCM', NULL, NULL),
(23, 'Hoang Tan dung', 'test@gmail.com', '$2y$10$QOMnxMd77O8fFwCznwGOU.WduNZzflmQ.yjEUmzm4KO8NscIbkE2m', '0123456789', 'M90i6FdoVaJXoWSBhqsdIKDm16cwpTXz9NxUNN0q.png', 3, '2025-03-18 19:06:39', '2025-04-17 03:12:27', 'HA NOI', NULL, NULL),
(31, 'HOÀNG TẤN DŨNG', 'dungakaishi900@gmail.com', '$2y$10$lfMMzZDYJjW2/IiF3WAih.jxV4acRB1bPqD3TfroCrztGjDu9Nuh6', NULL, '2bYEheZx5h74kFilqAR0.jpg', 3, '2025-04-15 20:57:47', '2025-04-15 20:57:47', NULL, 'GOOGLE', '115133837947112457243');

-- --------------------------------------------------------

--
-- Table structure for table `user_addresses`
--

CREATE TABLE `user_addresses` (
  `address_id` char(36) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `address` text NOT NULL,
  `address_type` varchar(255) NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_user_id_foreign` (`user_id`);

--
-- Indexes for table `cart_details`
--
ALTER TABLE `cart_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_details_product_id_foreign` (`product_id`),
  ADD KEY `cart_details_cart_id_foreign` (`cart_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_details_order_id_foreign` (`order_id`),
  ADD KEY `order_details_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_discounts`
--
ALTER TABLE `product_discounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_discounts_product_id_foreign` (`product_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shippings`
--
ALTER TABLE `shippings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `shippings_order_id_unique` (`order_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_user_email_unique` (`user_email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- Indexes for table `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD PRIMARY KEY (`address_id`),
  ADD KEY `user_addresses_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `cart_details`
--
ALTER TABLE `cart_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `product_discounts`
--
ALTER TABLE `product_discounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `shippings`
--
ALTER TABLE `shippings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `cart_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `cart_details`
--
ALTER TABLE `cart_details`
  ADD CONSTRAINT `cart_details_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`),
  ADD CONSTRAINT `cart_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `product_discounts`
--
ALTER TABLE `product_discounts`
  ADD CONSTRAINT `product_discounts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `shippings`
--
ALTER TABLE `shippings`
  ADD CONSTRAINT `shippings_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD CONSTRAINT `user_addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
