-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2021 at 01:20 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rest_api`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, 'category 1', 'some description', NULL, '2021-04-23 20:44:18', '2021-04-23 20:44:18'),
(2, 'category 2', 'some description goes here', NULL, '2021-04-23 20:44:18', '2021-04-23 20:44:18');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `sku`, `description`, `price`, `created_at`, `updated_at`) VALUES
(3, 1, 'tanjil hasan update product', '60848a76aa040', '122123165464789475613', 120, '2021-04-24 05:15:34', '2021-04-29 23:31:04'),
(6, 1, 'Lux', '608b16b6d1c0b', 'qweqweqweqweqweqweqw', 32, '2021-04-29 04:27:34', '2021-04-29 04:27:34'),
(8, 2, 'Lifebuoy 333333', '608b3ff92fa07', 'this is lifebuoy care. 100% better germ protection.', 350, '2021-04-29 19:23:37', '2021-04-30 00:36:30'),
(9, 2, 'Lifebuoy', '608b401651113', 'this is lifebuoy care. 100% better germ protection.', 35, '2021-04-29 19:24:06', '2021-04-30 05:40:19'),
(10, 2, 'Lifebuoy', '608b407f71f3c', 'this is lifebuoy care. 100% better germ protection.', 35, '2021-04-29 19:25:51', '2021-04-29 19:25:51'),
(11, 2, 'Lifebuoy', '608b40c9b84c2', 'this is lifebuoy care. 100% better germ protection.', 35, '2021-04-29 19:27:05', '2021-04-29 19:27:05'),
(12, 2, 'Lifebuoy', '608b41410c965', 'this is lifebuoy care. 100% better germ protection.', 35, '2021-04-29 19:29:05', '2021-04-29 19:29:05'),
(13, 1, 'This is a New product', '608b5b90402b4', 'ne productadf', 100, '2021-04-29 21:21:20', '2021-04-30 06:30:27'),
(14, 1, 'new product 2', '608b5dfcc4c28', 'new product description goes here', 150, '2021-04-29 21:31:40', '2021-04-29 21:31:40'),
(15, 1, 'Lux', '608b6f2b7d74a', 'srqwerwerfsadf', 23434, '2021-04-29 22:44:59', '2021-04-29 22:44:59'),
(16, 2, 'Lux 123', '608bd4664691d', '123123123asdfsdf', 123, '2021-04-30 05:56:54', '2021-04-30 05:56:54');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `path` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `path`, `created_at`, `updated_at`) VALUES
(1, 1, '1111111111111111111111111111111111111111111111111111111111.png', NULL, NULL),
(2, 1, '22222222222222222222222222222.png', NULL, NULL),
(3, 2, '333333333333333333333.png', NULL, NULL),
(4, 2, '44444444444444444.jpg', NULL, NULL),
(5, 12, 'public/products/c90cdef37f29cb95140fd416c8ee454c.jpg', '2021-04-29 19:29:05', '2021-04-29 19:29:05'),
(6, 13, 'public/products/0e03d87707af714543f9e17cc8c3864d.png', '2021-04-29 21:21:20', '2021-04-30 06:30:27'),
(7, 14, 'public/products/0e03d87707af714543f9e17cc8c3864d.png', '2021-04-29 21:31:40', '2021-04-29 21:31:40'),
(8, 15, 'public/products/a59a1e1fb0484d902b137c5bb4334db1.png', '2021-04-29 22:44:59', '2021-04-29 22:44:59'),
(9, 16, 'public/products/f32e3b787ef80c3df917b2ed6e1f656f.png', '2021-04-30 05:56:54', '2021-04-30 05:56:54');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `is_admin`, `address`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$Szlb4g.4c0joeBkMxr3jVefgUr1XgtxxgjPH7XEjx8dmtel6JvtEi', 1, '', '2021-04-21 14:19:01', '2021-04-21 14:19:01'),
(2, 'customer', 'customer@gmail.com', '$2y$10$Szlb4g.4c0joeBkMxr3jVefgUr1XgtxxgjPH7XEjx8dmtel6JvtEi', 0, '', '2021-04-21 14:19:01', NULL),
(3, 'Md. Tanjil Hasan', 'tanjil@tanjil.com', '123456', 0, '', '2021-04-21 03:49:01', '2021-04-21 03:49:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
