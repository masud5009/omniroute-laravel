-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 18, 2026 at 12:11 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `omniroute`
--

-- --------------------------------------------------------

--
-- Table structure for table `ai_providers`
--

CREATE TABLE `ai_providers` (
  `id` bigint UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `base_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `format` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'openai',
  `description` text COLLATE utf8mb4_unicode_ci,
  `models_catalog` json DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ai_providers`
--

INSERT INTO `ai_providers` (`id`, `slug`, `name`, `base_url`, `format`, `description`, `models_catalog`, `is_active`, `created_at`, `updated_at`) VALUES
(94, 'river-ai', 'River AI', 'https://api.river.ai/v1', 'openai', 'https://console.river.ai/\r\nmasudgaminghub@gmail.com', '[\"deepseek-ai/DeepSeek-V4.1-Flash\", \"nvidia/NVIDIA-Nemotron-3.5-Super-VL-120B-A12B-NVFP4\", \"zai-org/GLM-5.3-Flash\"]', 1, '2026-10-18 05:20:36', '2026-10-18 05:55:36');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gateway_keys`
--

CREATE TABLE `gateway_keys` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `daily_token_limit` bigint DEFAULT NULL,
  `tokens_used_today` bigint NOT NULL DEFAULT '0',
  `usage_reset_date` date DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gateway_keys`
--

INSERT INTO `gateway_keys` (`id`, `name`, `key`, `daily_token_limit`, `tokens_used_today`, `usage_reset_date`, `last_used_at`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Default Master Key', 'sk-omni-master-key-1234567890abcdef', NULL, 0, NULL, NULL, 1, '2026-10-14 23:56:31', '2026-10-14 23:56:31');

-- --------------------------------------------------------

--
-- Table structure for table `gateway_logs`
--

CREATE TABLE `gateway_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `gateway_key_id` bigint UNSIGNED DEFAULT NULL,
  `requested_model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `routed_provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `routed_model` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prompt_tokens` int NOT NULL DEFAULT '0',
  `completion_tokens` int NOT NULL DEFAULT '0',
  `total_tokens` int NOT NULL DEFAULT '0',
  `saved_tokens` int NOT NULL DEFAULT '0',
  `latency_ms` int NOT NULL DEFAULT '0',
  `status_code` int NOT NULL DEFAULT '200',
  `error_message` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gateway_logs`
--

INSERT INTO `gateway_logs` (`id`, `gateway_key_id`, `requested_model`, `routed_provider`, `routed_model`, `account_label`, `prompt_tokens`, `completion_tokens`, `total_tokens`, `saved_tokens`, `latency_ms`, `status_code`, `error_message`, `created_at`, `updated_at`) VALUES
(1, NULL, 'mock-chat-6ad49d46cc32b/mock-gpt-4o', 'mock-chat-6ad49d46cc32b', 'mock-gpt-4o', 'Mock Key', 10, 5, 15, 0, 0, 200, NULL, '2026-10-18 04:19:51', '2026-10-18 04:19:51'),
(2, NULL, 'river-ai/deepseek-ai/DeepSeek-V4.1-Flash', 'river-ai', 'deepseek-ai/DeepSeek-V4.1-Flash', 'river-ai', 39, 10, 49, 0, 1348, 200, NULL, '2026-10-18 05:21:46', '2026-10-18 05:21:46');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_10_15_000001_create_omniroute_tables', 1),
(5, '2026_10_18_112538_add_description_to_ai_providers_table', 2);

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
-- Table structure for table `provider_accounts`
--

CREATE TABLE `provider_accounts` (
  `id` bigint UNSIGNED NOT NULL,
  `ai_provider_id` bigint UNSIGNED NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `api_key` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority` int NOT NULL DEFAULT '1',
  `daily_token_limit` bigint DEFAULT NULL,
  `tokens_used_today` bigint NOT NULL DEFAULT '0',
  `usage_reset_date` date DEFAULT NULL,
  `cooldown_until` timestamp NULL DEFAULT NULL,
  `fail_count` int NOT NULL DEFAULT '0',
  `last_error` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `provider_accounts`
--

INSERT INTO `provider_accounts` (`id`, `ai_provider_id`, `label`, `api_key`, `priority`, `daily_token_limit`, `tokens_used_today`, `usage_reset_date`, `cooldown_until`, `fail_count`, `last_error`, `is_active`, `created_at`, `updated_at`) VALUES
(104, 94, 'river-ai', 'eyJpdiI6IjhhVy9jODBrRUxVdlQreWdUMHU3VVE9PSIsInZhbHVlIjoiMVFvNjVjeHdmRzNGendkbCtMaFFWekxKeHRWK2t5OUNmQnorYW4rZXI5N3dTK3VGUXNkRjcrMUFwSEtMTnkraiIsIm1hYyI6IjVmYmFjNGRmYTM0NjEzMzE1ZDExNGE5ODJlZjRiNTRhZjhkNzkxNjI4MjIxNzQ3MDI1YWMzZTU3NGE2ZDU5ZGYiLCJ0YWciOiIifQ==', 1, NULL, 49, '2026-10-18', NULL, 0, NULL, 1, '2026-10-18 05:21:25', '2026-10-18 05:21:46');

-- --------------------------------------------------------

--
-- Table structure for table `routing_combos`
--

CREATE TABLE `routing_combos` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `strategy` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'priority',
  `models` json NOT NULL,
  `compression_modes` json DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('1BV9GZDJkrqL699IRVT7mK6qRT1zDe1tEMHzdAkV', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.19041.6456', 'eyJfdG9rZW4iOiI2Y1A5cDRtd0VYWWVGOU9wNlNTcTV5QzZ5N2JMN09uWG9mZ1h5NUJjIiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvb21uaXJvdXRlLWxhcmF2ZWwudGVzdFwvZGFzaGJvYXJkXC9wcm92aWRlcnNcL3JpdmVyLWFpIn0sIl9wcmV2aW91cyI6eyJ1cmwiOiJodHRwOlwvXC9vbW5pcm91dGUtbGFyYXZlbC50ZXN0XC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1792324120),
('fignvXS7PjKHAO8aagyUdwEjdyu0Q6mnUy9MlrLa', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJnRTdlZkZMVFVscWdkWHB2VzBQb0w4Slhta1pQd25HNk5EZkJ1VFBBIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cHM6XC9cL29tbmlyb3V0ZS1sYXJhdmVsLnRlc3RcL2Rhc2hib2FyZFwvcHJvdmlkZXJzIiwicm91dGUiOiJkYXNoYm9hcmQucHJvdmlkZXJzIn0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoxLCJwYXNzd29yZF9oYXNoX3dlYiI6ImYwNjdjNTkwYjYyYWFlNWI1N2QxNmMxNzk0YWI1NWUzMmRjY2FjZWJmZjhmOWMwNDQxOWU5MWU4ZjUwOWJjOTYifQ==', 1792325504),
('htQtORD4eosmFBcVKJjOM72loQ1RdlCJzqHAj580', NULL, '127.0.0.1', 'curl/8.13.0', 'eyJfdG9rZW4iOiI5UmpKSDdlVHdUYkFoQXlTbzNwRG1uaGJaSUFOa29QYW1lS1hxWmNpIiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvb21uaXJvdXRlLWxhcmF2ZWwudGVzdFwvZGFzaGJvYXJkXC9wcm92aWRlcnNcL3JpdmVyLWFpIn0sIl9wcmV2aW91cyI6eyJ1cmwiOiJodHRwOlwvXC9vbW5pcm91dGUtbGFyYXZlbC50ZXN0XC9kYXNoYm9hcmRcL3Byb3ZpZGVyc1wvcml2ZXItYWkiLCJyb3V0ZSI6ImRhc2hib2FyZC5wcm92aWRlcnMuc2hvdyJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1792324142),
('nIBFzWzmxUasdorNqUUwNqcbpADUuxVabEV3MKWg', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJrZ3ZJa2R6eHdlMmFYUmVJT0dDNjVpdG9FODBPMlg1VWZjS2loSm9oIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvb21uaXJvdXRlLWxhcmF2ZWwudGVzdFwvZGFzaGJvYXJkXC9wcm92aWRlcnMiLCJyb3V0ZSI6ImRhc2hib2FyZC5wcm92aWRlcnMifSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjEsInBhc3N3b3JkX2hhc2hfd2ViIjoiZjA2N2M1OTBiNjJhYWU1YjU3ZDE2YzE3OTRhYjU1ZTMyZGNjYWNlYmZmOGY5YzA0NDE5ZTkxZThmNTA5YmM5NiJ9', 1792325366),
('OklxrEIKTVsjFhpLO77wIAUtUfaeawVazVWI8K5S', NULL, '127.0.0.1', 'curl/8.13.0', 'eyJfdG9rZW4iOiJGd0tEYlRGSE9DWTg2czd4Q3VNSVRsTFlveGRvMDVvNTNMT2tQU2RPIiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvb21uaXJvdXRlLWxhcmF2ZWwudGVzdFwvZGFzaGJvYXJkXC9wcm92aWRlcnNcL3JpdmVyLWFpIn0sIl9wcmV2aW91cyI6eyJ1cmwiOiJodHRwOlwvXC9vbW5pcm91dGUtbGFyYXZlbC50ZXN0XC9kYXNoYm9hcmRcL3Byb3ZpZGVyc1wvcml2ZXItYWkiLCJyb3V0ZSI6ImRhc2hib2FyZC5wcm92aWRlcnMuc2hvdyJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1792324135),
('xlbrxTLWpCCqBmDJvML0QCacnlBGcmA8w0fwTbxw', NULL, '127.0.0.1', 'curl/8.13.0', 'eyJfdG9rZW4iOiJhY3BBS0lVQm9mb3Z3WnZsT1JGYUVkZzBSWkFqWkNCVERPYU9ySGsyIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1792318818);

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
(1, 'OmniRoute Admin', 'admin@omniroute.local', '2026-10-14 23:56:31', '$2y$12$FzkkEdD7IaMQ5fI1Z.LiHuP9TzmYv7iU5lqVmkpgQf0lWAN.VVqme', 'Y9MCHleOK1YMVQkJ8GP0VjdalDKUtjy73wqg2iiHft8ASHUeiMDc9Gm63P5J', '2026-10-14 23:56:31', '2026-10-14 23:56:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ai_providers`
--
ALTER TABLE `ai_providers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ai_providers_slug_unique` (`slug`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Indexes for table `gateway_keys`
--
ALTER TABLE `gateway_keys`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gateway_keys_key_unique` (`key`);

--
-- Indexes for table `gateway_logs`
--
ALTER TABLE `gateway_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gateway_logs_gateway_key_id_foreign` (`gateway_key_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `provider_accounts`
--
ALTER TABLE `provider_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `provider_accounts_ai_provider_id_foreign` (`ai_provider_id`);

--
-- Indexes for table `routing_combos`
--
ALTER TABLE `routing_combos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `routing_combos_name_unique` (`name`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

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
-- AUTO_INCREMENT for table `ai_providers`
--
ALTER TABLE `ai_providers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gateway_keys`
--
ALTER TABLE `gateway_keys`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `gateway_logs`
--
ALTER TABLE `gateway_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `provider_accounts`
--
ALTER TABLE `provider_accounts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `routing_combos`
--
ALTER TABLE `routing_combos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gateway_logs`
--
ALTER TABLE `gateway_logs`
  ADD CONSTRAINT `gateway_logs_gateway_key_id_foreign` FOREIGN KEY (`gateway_key_id`) REFERENCES `gateway_keys` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `provider_accounts`
--
ALTER TABLE `provider_accounts`
  ADD CONSTRAINT `provider_accounts_ai_provider_id_foreign` FOREIGN KEY (`ai_provider_id`) REFERENCES `ai_providers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
