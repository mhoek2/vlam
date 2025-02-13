-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2025 at 02:55 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vlam`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `id` int(11) NOT NULL,
  `meeting_id` int(11) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `name` text NOT NULL,
  `intro` text NOT NULL,
  `info` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`id`, `meeting_id`, `sort_order`, `name`, `intro`, `info`) VALUES
(1, 1, 0, 'Opdracht 1', '<p><span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. V</span><span style=\"background-color:hsl(210,75%,60%);color:hsl(0,0%,100%);\">ivamu</span><span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\">s nulla mauris, mattis vel pulvinar sit amet, efficitur a purus. Donec sit amet accumsan diam, a euismod felis. Duis dolor orci, lobortis maximus convallis nec, venenatis at neque. Morbi a pretium risus. Morbi sed dolor eleifend, ultricies urna at, tempor risus. Maecenas sed posuere augue. Quisque mollis ac odio sed molestie. Maecenas bibendum, magna vitae fringilla elementum, arcu velit tristique mauris, bibendum lobortis sem sem ut quam.</span></p>', 'Herken de werkervaring'),
(2, 1, 5, 'Opdracht 2', 'Opdracht 2', ''),
(3, 1, 2, 'Opdracht 3', 'Opdracht 3', ''),
(4, 1, 4, 'Opdracht 4', 'Opdracht 4', ''),
(5, 1, 3, 'Opdracht 5', 'Opdracht 5', ''),
(6, 1, 1, 'Opdracht 6', 'Opdracht 6', '');

-- --------------------------------------------------------

--
-- Table structure for table `assignment_entry`
--

CREATE TABLE `assignment_entry` (
  `id` int(11) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `name` text NOT NULL,
  `info` text NOT NULL,
  `assignment_id` int(11) NOT NULL,
  `type` enum('mcq','text_input','text_separator','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `assignment_entry`
--

INSERT INTO `assignment_entry` (`id`, `sort_order`, `name`, `info`, `assignment_id`, `type`) VALUES
(24, 1, 'Vraag 1', '', 1, 'mcq'),
(25, 2, 'Separator', '', 1, 'text_separator'),
(28, 0, 'Separator', '', 1, 'text_separator'),
(29, 3, 'Vraag 2', '', 1, 'mcq'),
(30, 4, 'Vraag 3', '', 1, 'mcq');

-- --------------------------------------------------------

--
-- Table structure for table `assignment_entry_properties`
--

CREATE TABLE `assignment_entry_properties` (
  `id` int(11) NOT NULL,
  `entry_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `sort_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `assignment_entry_properties`
--

INSERT INTO `assignment_entry_properties` (`id`, `entry_id`, `content`, `sort_order`) VALUES
(26, 24, 'Ja', 1),
(27, 24, 'Nee', 0),
(32, 28, '<p><strong>Lorem Ipsum</strong><span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\"> is simply dummy text of the printing and typesetting industry.</span></p>', 0),
(33, 25, '<p><i>Dit is ook Tekst</i></p>', 0),
(34, 29, 'Nee', 0),
(35, 29, 'Misschien', 1),
(36, 29, 'Ja', 2),
(37, 29, 'Zeker weten', 3),
(38, 30, 'test 1', 0),
(39, 30, 'test 2', 0);

-- --------------------------------------------------------

--
-- Table structure for table `assignment_result`
--

CREATE TABLE `assignment_result` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `meeting` text NOT NULL,
  `name` text NOT NULL,
  `info` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignment_result`
--

INSERT INTO `assignment_result` (`id`, `user_id`, `meeting`, `name`, `info`) VALUES
(12, 2, '1_Kennismaking en werkvoorwaarden', 'Opdracht 1', 'Herken de werkervaring');

-- --------------------------------------------------------

--
-- Table structure for table `assignment_result_entry`
--

CREATE TABLE `assignment_result_entry` (
  `id` int(11) NOT NULL,
  `result_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `value` text NOT NULL,
  `type` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignment_result_entry`
--

INSERT INTO `assignment_result_entry` (`id`, `result_id`, `name`, `value`, `type`) VALUES
(67, 12, 'Vraag 1', 'Ja', 'mcq'),
(68, 12, 'Vraag 2', 'Nee', 'mcq'),
(69, 12, 'Vraag 3', 'test 2', 'mcq');

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups_users`
--

CREATE TABLE `auth_groups_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `auth_groups_users`
--

INSERT INTO `auth_groups_users` (`id`, `user_id`, `group`, `created_at`) VALUES
(2, 2, 'admin', '2025-02-05 09:20:35'),
(3, 3, 'user', '2025-02-13 08:21:52'),
(4, 4, 'user', '2025-02-13 08:22:31'),
(5, 5, 'user', '2025-02-13 08:22:57'),
(6, 6, 'user', '2025-02-13 08:23:14'),
(7, 7, 'user', '2025-02-13 08:23:40');

-- --------------------------------------------------------

--
-- Table structure for table `auth_identities`
--

CREATE TABLE `auth_identities` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `secret` varchar(255) NOT NULL,
  `secret2` varchar(255) DEFAULT NULL,
  `expires` datetime DEFAULT NULL,
  `extra` text DEFAULT NULL,
  `force_reset` tinyint(1) NOT NULL DEFAULT 0,
  `last_used_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `auth_identities`
--

INSERT INTO `auth_identities` (`id`, `user_id`, `type`, `name`, `secret`, `secret2`, `expires`, `extra`, `force_reset`, `last_used_at`, `created_at`, `updated_at`) VALUES
(2, 2, 'email_password', '', 'admin@vlam.nl', '$2y$12$03WJ08uzWhj7t16adUAhD.lNkR.D1/HIQPwjWOIiAExsemWypgjZG', NULL, NULL, 0, '2025-02-13 11:16:38', '2025-02-05 09:20:35', '2025-02-13 11:16:38'),
(3, 3, 'email_password', NULL, 'user1@vlam.nl', '$2y$12$2qVsxlZTaVhyA1ne60qDaudYkCX9VIdj4ObMlAOamVFtWfICm3/6i', NULL, NULL, 0, NULL, '2025-02-13 08:21:52', '2025-02-13 08:21:52'),
(4, 4, 'email_password', NULL, 'user2@vlam.nl', '$2y$12$vJPJlsyJgkXCerGvzzc1PePQQ7sOWNed3Rb.98HwrO7fkl09ZofrC', NULL, NULL, 0, NULL, '2025-02-13 08:22:30', '2025-02-13 08:22:31'),
(5, 5, 'email_password', NULL, 'user3@vlam.nl', '$2y$12$76GI7FOlmaDpflY6JZgrR.mxs5hyDb.7UR0h7pddjQ3xW99oyplJm', NULL, NULL, 0, NULL, '2025-02-13 08:22:57', '2025-02-13 08:22:57'),
(6, 6, 'email_password', NULL, 'user4@vlam.nl', '$2y$12$6AfG80CW1Kdd6NjkBsGNeO/cmb9ll/ZIOe.//ul1Q8AzKpvuOnQmW', NULL, NULL, 0, NULL, '2025-02-13 08:23:13', '2025-02-13 08:23:14'),
(7, 7, 'email_password', NULL, 'user5@vlam.nl', '$2y$12$GRu651L2VS4KPJ06uMsT.eWd8CX.wL36oheZJejTgbhpIjuJKBfOi', NULL, NULL, 0, NULL, '2025-02-13 08:23:40', '2025-02-13 08:23:40');

-- --------------------------------------------------------

--
-- Table structure for table `auth_logins`
--

CREATE TABLE `auth_logins` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `id_type` varchar(255) NOT NULL,
  `identifier` varchar(255) NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `auth_logins`
--

INSERT INTO `auth_logins` (`id`, `ip_address`, `user_agent`, `id_type`, `identifier`, `user_id`, `date`, `success`) VALUES
(15, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'email_password', 'admin@vlam.nl', 2, '2025-02-11 10:10:40', 1),
(16, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'email_password', 'admin@vlam.nl', 2, '2025-02-11 10:13:07', 1),
(17, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'email_password', 'admin@vlam.nl', 2, '2025-02-11 10:15:10', 1),
(18, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'email_password', 'admin@vlam.nl', 2, '2025-02-11 10:18:58', 1),
(19, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'email_password', 'admin@vlam.nl', 2, '2025-02-11 10:28:16', 1),
(20, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'email_password', 'admin@vlam.nl', 2, '2025-02-11 10:58:47', 1),
(21, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'email_password', 'admin@vlam.nl', 2, '2025-02-11 12:15:51', 1),
(22, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'email_password', 'admin@vlam.nl', 2, '2025-02-12 08:29:17', 1),
(23, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'email_password', 'admin@vlam.nl', NULL, '2025-02-13 08:07:03', 0),
(24, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'email_password', 'admin@vlam.nl', 2, '2025-02-13 08:07:08', 1),
(25, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'email_password', 'admin@vlam.nl', 2, '2025-02-13 08:23:47', 1),
(26, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'email_password', 'admin@vlam.nl', 2, '2025-02-13 11:16:38', 1);

-- --------------------------------------------------------

--
-- Table structure for table `auth_permissions_users`
--

CREATE TABLE `auth_permissions_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `permission` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_remember_tokens`
--

CREATE TABLE `auth_remember_tokens` (
  `id` int(11) UNSIGNED NOT NULL,
  `selector` varchar(255) NOT NULL,
  `hashedValidator` varchar(255) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `expires` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_token_logins`
--

CREATE TABLE `auth_token_logins` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `id_type` varchar(255) NOT NULL,
  `identifier` varchar(255) NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `meetings`
--

CREATE TABLE `meetings` (
  `id` int(11) NOT NULL,
  `name` int(11) NOT NULL,
  `info` text NOT NULL,
  `intro` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meetings`
--

INSERT INTO `meetings` (`id`, `name`, `info`, `intro`) VALUES
(1, 1, 'Kennismaking en werkvoorwaarden', '<h2><span style=\"color:hsl(270,75%,60%);\">Lorem Ipsum</span></h2><h4><i>\"Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...\"</i></h4><p><strong>Lorem Ipsum</strong><span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\"> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p>'),
(2, 2, 'Kwaliteiten en persoonlijk profiel', ''),
(3, 3, 'Het belang van een sterk CV', ''),
(4, 4, 'Openheid geven', ''),
(5, 5, 'Ervaringen van een oud student', ''),
(6, 6, 'Solicitatiegesprek en actieplan', '<p>2</p>');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2020-12-28-223112', 'CodeIgniter\\Shield\\Database\\Migrations\\CreateAuthTables', 'default', 'CodeIgniter\\Shield', 1738745678, 1),
(2, '2021-07-04-041948', 'CodeIgniter\\Settings\\Database\\Migrations\\CreateSettingsTable', 'default', 'CodeIgniter\\Settings', 1738745678, 1),
(3, '2021-11-14-143905', 'CodeIgniter\\Settings\\Database\\Migrations\\AddContextColumn', 'default', 'CodeIgniter\\Settings', 1738745678, 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(9) NOT NULL,
  `class` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `type` varchar(31) NOT NULL DEFAULT 'string',
  `context` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trainings`
--

CREATE TABLE `trainings` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `started` datetime DEFAULT NULL,
  `stopped` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainings`
--

INSERT INTO `trainings` (`id`, `name`, `started`, `stopped`, `created_at`) VALUES
(6, 'Training #3', NULL, NULL, '2025-02-13 14:23:31');

-- --------------------------------------------------------

--
-- Table structure for table `training_users`
--

CREATE TABLE `training_users` (
  `id` int(11) NOT NULL,
  `training_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `training_users`
--

INSERT INTO `training_users` (`id`, `training_id`, `user_id`) VALUES
(14, 6, 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `firstname` text NOT NULL,
  `middlename` text NOT NULL,
  `lastname` text NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `status_message` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `last_active` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `firstname`, `middlename`, `lastname`, `status`, `status_message`, `active`, `last_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'vlam_admin', 'Admin', '', 'Vlam', NULL, NULL, 1, NULL, '2025-02-05 09:20:35', '2025-02-05 09:20:35', NULL),
(3, 'user1', 'User', '', '1', NULL, NULL, 1, NULL, '2025-02-13 08:21:52', '2025-02-13 08:21:52', NULL),
(4, 'user2', 'User', '', '2', NULL, NULL, 1, NULL, '2025-02-13 08:22:30', '2025-02-13 08:22:31', NULL),
(5, 'user3', 'User', '', '3', NULL, NULL, 1, NULL, '2025-02-13 08:22:57', '2025-02-13 08:22:57', NULL),
(6, 'user4', 'User', '', '4', NULL, NULL, 1, NULL, '2025-02-13 08:23:13', '2025-02-13 08:23:14', NULL),
(7, 'user5', 'User', '', '5', NULL, NULL, 1, NULL, '2025-02-13 08:23:39', '2025-02-13 08:23:40', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignment_entry`
--
ALTER TABLE `assignment_entry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignment_entry_properties`
--
ALTER TABLE `assignment_entry_properties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignment_result`
--
ALTER TABLE `assignment_result`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignment_result_entry`
--
ALTER TABLE `assignment_result_entry`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE` (`name`(200));

--
-- Indexes for table `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auth_groups_users_user_id_foreign` (`user_id`);

--
-- Indexes for table `auth_identities`
--
ALTER TABLE `auth_identities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type_secret` (`type`,`secret`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `auth_logins`
--
ALTER TABLE `auth_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_type_identifier` (`id_type`,`identifier`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `auth_permissions_users`
--
ALTER TABLE `auth_permissions_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auth_permissions_users_user_id_foreign` (`user_id`);

--
-- Indexes for table `auth_remember_tokens`
--
ALTER TABLE `auth_remember_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `selector` (`selector`),
  ADD KEY `auth_remember_tokens_user_id_foreign` (`user_id`);

--
-- Indexes for table `auth_token_logins`
--
ALTER TABLE `auth_token_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_type_identifier` (`id_type`,`identifier`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `meetings`
--
ALTER TABLE `meetings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trainings`
--
ALTER TABLE `trainings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `training_users`
--
ALTER TABLE `training_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `training_id` (`training_id`,`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `assignment_entry`
--
ALTER TABLE `assignment_entry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `assignment_entry_properties`
--
ALTER TABLE `assignment_entry_properties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `assignment_result`
--
ALTER TABLE `assignment_result`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `assignment_result_entry`
--
ALTER TABLE `assignment_result_entry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `auth_identities`
--
ALTER TABLE `auth_identities`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `auth_logins`
--
ALTER TABLE `auth_logins`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `auth_permissions_users`
--
ALTER TABLE `auth_permissions_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_remember_tokens`
--
ALTER TABLE `auth_remember_tokens`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_token_logins`
--
ALTER TABLE `auth_token_logins`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meetings`
--
ALTER TABLE `meetings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trainings`
--
ALTER TABLE `trainings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `training_users`
--
ALTER TABLE `training_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  ADD CONSTRAINT `auth_groups_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_identities`
--
ALTER TABLE `auth_identities`
  ADD CONSTRAINT `auth_identities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_permissions_users`
--
ALTER TABLE `auth_permissions_users`
  ADD CONSTRAINT `auth_permissions_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_remember_tokens`
--
ALTER TABLE `auth_remember_tokens`
  ADD CONSTRAINT `auth_remember_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
