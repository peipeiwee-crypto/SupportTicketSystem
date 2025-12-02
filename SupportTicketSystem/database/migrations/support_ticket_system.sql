-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2025 at 10:42 AM
-- Server version: 8.0.44
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `support_ticket_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_12_01_040543_create_tickets_table', 1),
(6, '2025_12_01_040606_create_ticket_comments_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'auth_token', '7c2b190bb8ec07260db74ba783dd4e9db4b481407776dc59165575adde441da6', '[\"*\"]', '2025-11-30 22:11:26', NULL, '2025-11-30 22:04:05', '2025-11-30 22:11:26'),
(2, 'App\\Models\\User', 1, 'auth_token', '32cf9aa1ab700d388e1443710ca6c21485116b57affe0526a2bdd5513d3f7f56', '[\"*\"]', '2025-11-30 22:13:36', NULL, '2025-11-30 22:13:36', '2025-11-30 22:13:36'),
(3, 'App\\Models\\User', 1, 'auth_token', 'd982ded46e42f5e0e5e2c56a6c07f0b73af8bd20743555714b3b93e5c0adb798', '[\"*\"]', '2025-11-30 22:25:07', NULL, '2025-11-30 22:17:20', '2025-11-30 22:25:07'),
(4, 'App\\Models\\User', 1, 'auth_token', 'b932d6da3b4221e1aec78e6300cdfc35183a27bef7e171a078754ce84a38b8e6', '[\"*\"]', '2025-11-30 22:46:43', NULL, '2025-11-30 22:25:12', '2025-11-30 22:46:43'),
(5, 'App\\Models\\User', 1, 'auth_token', '9f1c2a6001bac60d9fcad6f843fbe9356db21c110e542137e7771a14715fb63e', '[\"*\"]', '2025-11-30 23:13:50', NULL, '2025-11-30 23:13:50', '2025-11-30 23:13:50'),
(6, 'App\\Models\\User', 1, 'auth_token', '85fd7c74c9dde53b377cb0cdab93955d72151b323a3a1c4c9bc3e475e1a9d7d5', '[\"*\"]', '2025-11-30 23:50:24', NULL, '2025-11-30 23:50:23', '2025-11-30 23:50:24'),
(7, 'App\\Models\\User', 1, 'auth_token', 'b6db7735242b38d24e33f56bbb4ae09d62d27ec377500b0761c7cbfcbf8b2aad', '[\"*\"]', '2025-11-30 23:52:35', NULL, '2025-11-30 23:52:35', '2025-11-30 23:52:35'),
(8, 'App\\Models\\User', 2, 'auth_token', '5c8fbd3e1824a2350d6e052502f7a5db8963315d3950717a87e6d1e41e688b51', '[\"*\"]', '2025-12-01 00:29:26', NULL, '2025-12-01 00:20:47', '2025-12-01 00:29:26'),
(9, 'App\\Models\\User', 1, 'auth_token', '03e8af4ebfd2cfb7a2490b51b9e15def26156a08eeda93cf0cf657dcfe975b61', '[\"*\"]', '2025-12-01 18:16:01', NULL, '2025-12-01 00:59:27', '2025-12-01 18:16:01'),
(10, 'App\\Models\\User', 2, 'auth_token', '4b35b8e3ba0e64ad4aa358b9fd0b926898ec104908461979af7ed1f4f10caddb', '[\"*\"]', '2025-12-01 18:22:48', NULL, '2025-12-01 18:16:20', '2025-12-01 18:22:48'),
(11, 'App\\Models\\User', 1, 'auth_token', 'bbb8f8d39d22c7df548317fe4bd19009e0fd4f6114b7e9f4483d0ebc52288a67', '[\"*\"]', '2025-12-01 18:32:29', NULL, '2025-12-01 18:23:05', '2025-12-01 18:32:29'),
(12, 'App\\Models\\User', 1, 'auth_token', 'fa6f6aa07d18b06d94d6b9d7d03db50872d35cc333c01cb8a43eee2783e7a1fd', '[\"*\"]', '2025-12-01 18:42:27', NULL, '2025-12-01 18:32:31', '2025-12-01 18:42:27'),
(13, 'App\\Models\\User', 1, 'auth_token', '9d72f5f9c8fe96b608adb1a3ef690a9c15dea47775df7aac1bf62d3e86e1aae7', '[\"*\"]', '2025-12-02 01:08:09', NULL, '2025-12-01 18:42:31', '2025-12-02 01:08:09');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('open','in_progress','resolved','closed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `priority` enum('low','medium','high') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'medium',
  `created_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `title`, `description`, `status`, `priority`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Ticket 1', 'Ticket 1 Trial', 'closed', 'low', 1, '2025-11-30 22:04:31', '2025-11-30 22:25:07', '2025-11-30 22:25:07'),
(2, 'Ticket 2', 'Ticket 2 Trial', 'in_progress', 'high', 1, '2025-11-30 22:05:24', '2025-11-30 22:05:43', NULL),
(3, 'Ticket 3', 'Ticket 3', 'in_progress', 'medium', 1, '2025-11-30 22:05:59', '2025-12-01 18:47:36', NULL),
(4, 'xe Ticket 1', 'xinen ticket 1', 'in_progress', 'medium', 2, '2025-12-01 00:22:01', '2025-12-01 00:22:09', NULL),
(5, 'Ticket 4', 'testing ticket 4', 'in_progress', 'low', 1, '2025-12-01 18:47:09', '2025-12-01 18:47:22', NULL),
(6, 'Ticket 5', 'trial 123', 'open', 'medium', 1, '2025-12-01 18:49:46', '2025-12-01 18:49:46', NULL),
(7, 'Title 1', 'Description 1', 'resolved', 'medium', 1, '2025-12-01 19:02:30', '2025-12-01 20:22:28', NULL),
(8, 'ticket 123', 'ticket 123', 'open', 'low', 1, '2025-12-01 21:48:04', '2025-12-01 21:48:04', NULL),
(9, 'title 12345', '12345', 'open', 'medium', 1, '2025-12-01 21:48:22', '2025-12-01 21:48:22', NULL),
(10, 'ticket 1111', '1111', 'open', 'high', 1, '2025-12-01 21:48:35', '2025-12-01 21:48:35', NULL),
(11, 'title 1111', '11111', 'open', 'low', 1, '2025-12-01 21:50:07', '2025-12-01 21:50:07', NULL),
(12, 'title 12222', '12222', 'open', 'medium', 1, '2025-12-01 21:50:16', '2025-12-01 21:50:16', NULL),
(13, 'title 11111', '32dwdq1', 'open', 'medium', 1, '2025-12-01 21:50:37', '2025-12-01 21:50:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ticket_comments`
--

CREATE TABLE `ticket_comments` (
  `id` bigint UNSIGNED NOT NULL,
  `ticket_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ticket_comments`
--

INSERT INTO `ticket_comments` (`id`, `ticket_id`, `user_id`, `message`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'I am trying on the ticket', '2025-11-30 22:04:50', '2025-11-30 22:04:50'),
(2, 4, 2, 'hihi', '2025-12-01 00:23:39', '2025-12-01 00:23:39'),
(3, 4, 2, 'hello when u can solve it', '2025-12-01 00:23:50', '2025-12-01 00:23:50'),
(4, 4, 1, 'hihi', '2025-12-01 18:39:41', '2025-12-01 18:39:41'),
(5, 3, 1, 'hellow', '2025-12-01 18:40:02', '2025-12-01 18:40:02'),
(6, 3, 1, 'hi', '2025-12-01 18:40:16', '2025-12-01 18:40:16'),
(7, 4, 1, 'hi', '2025-12-01 18:42:20', '2025-12-01 18:42:20'),
(8, 4, 1, 'trial 123', '2025-12-01 18:46:22', '2025-12-01 18:46:22'),
(9, 2, 1, 'trial324', '2025-12-01 18:46:34', '2025-12-01 18:46:34'),
(10, 2, 1, 'hii', '2025-12-01 23:33:36', '2025-12-01 23:33:36'),
(11, 4, 1, 'hi', '2025-12-02 01:08:07', '2025-12-02 01:08:07');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Pei Pei', 'peipei.wee@bitzaro.com', NULL, '$2y$12$/6IoLBWB5tHvqttZKDlPuO5h0p2/CB2rupryo.TBAMAoWqsR4eV9m', NULL, '2025-11-30 22:04:05', '2025-11-30 22:04:05'),
(2, 'Xin En', 'xinen.lim@bitzaro.com', NULL, '$2y$12$9rnZWouz2lDqjSI5rK1QouuEjQLonSHOyAtZVvrdBb79ZHC3S8n4G', NULL, '2025-12-01 00:20:47', '2025-12-01 00:20:47');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tickets_created_by_index` (`created_by`),
  ADD KEY `tickets_status_index` (`status`),
  ADD KEY `tickets_priority_index` (`priority`);

--
-- Indexes for table `ticket_comments`
--
ALTER TABLE `ticket_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_comments_ticket_id_index` (`ticket_id`),
  ADD KEY `ticket_comments_user_id_index` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `ticket_comments`
--
ALTER TABLE `ticket_comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ticket_comments`
--
ALTER TABLE `ticket_comments`
  ADD CONSTRAINT `ticket_comments_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ticket_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
