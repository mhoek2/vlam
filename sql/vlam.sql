-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 11, 2025 at 02:32 PM
-- Server version: 8.0.42-0ubuntu0.20.04.1
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hklab69_vlam`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `id` int NOT NULL,
  `meeting_id` int NOT NULL,
  `sort_order` int NOT NULL,
  `name` text NOT NULL,
  `intro` text NOT NULL,
  `outro` text,
  `info` text NOT NULL,
  `sub_assignment` text,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `assignment_entry`
--

CREATE TABLE `assignment_entry` (
  `id` int NOT NULL,
  `sort_order` int NOT NULL,
  `name` text NOT NULL,
  `info` text NOT NULL,
  `assignment_id` int NOT NULL,
  `type` enum('mcq','text_input','text_separator','mcq-2','mcq-3','video_youtube','') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `optional` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `assignment_entry_properties`
--

CREATE TABLE `assignment_entry_properties` (
  `id` int NOT NULL,
  `entry_id` int NOT NULL,
  `content` text NOT NULL,
  `sort_order` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `assignment_result`
--

CREATE TABLE `assignment_result` (
  `id` int NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `assignment_id` int NOT NULL,
  `entry_id` int NOT NULL,
  `property_id` int DEFAULT NULL COMMENT '	if set to ''1'', this entry relies on stored property ids in value field	',
  `value` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups_users`
--

CREATE TABLE `auth_groups_users` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `group` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_identities`
--

CREATE TABLE `auth_identities` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `secret` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `secret2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `expires` datetime DEFAULT NULL,
  `extra` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `force_reset` tinyint(1) NOT NULL DEFAULT '0',
  `last_used_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `auth_identities`
--

INSERT INTO `auth_identities` (`id`, `user_id`, `type`, `name`, `secret`, `secret2`, `expires`, `extra`, `force_reset`, `last_used_at`, `created_at`, `updated_at`) VALUES
(2, 2, 'email_password', '', 'admin@vlam.nl', '$2y$12$CFeavzQijA.w4yu7.276auOuovnwGJQtKFj59AEVcu3EFllrXs4yG', NULL, NULL, 0, '2025-06-11 07:34:30', '2025-02-05 09:20:35', '2025-06-11 07:34:30'),
(3, 3, 'email_password', NULL, 'user1@vlam.nl', '$2y$12$2qVsxlZTaVhyA1ne60qDaudYkCX9VIdj4ObMlAOamVFtWfICm3/6i', NULL, NULL, 0, '2025-03-28 19:09:26', '2025-02-13 08:21:52', '2025-03-28 19:09:26'),
(4, 4, 'email_password', NULL, 'user2@vlam.nl', '$2y$12$vJPJlsyJgkXCerGvzzc1PePQQ7sOWNed3Rb.98HwrO7fkl09ZofrC', NULL, NULL, 0, NULL, '2025-02-13 08:22:30', '2025-02-13 08:22:31'),
(5, 5, 'email_password', NULL, 'user3@vlam.nl', '$2y$12$76GI7FOlmaDpflY6JZgrR.mxs5hyDb.7UR0h7pddjQ3xW99oyplJm', NULL, NULL, 0, NULL, '2025-02-13 08:22:57', '2025-02-13 08:22:57'),
(6, 6, 'email_password', NULL, 'user4@vlam.nl', '$2y$12$6AfG80CW1Kdd6NjkBsGNeO/cmb9ll/ZIOe.//ul1Q8AzKpvuOnQmW', NULL, NULL, 0, '2025-06-11 11:13:02', '2025-02-13 08:23:13', '2025-06-11 11:13:02'),
(7, 7, 'email_password', NULL, 'user5@vlam.nl', '$2y$12$aGbP0bWzJ4bxjHZjtytlDOfnyc3qtC4..pLaKPsAH5eGXnK8dhY5e', NULL, NULL, 0, '2025-06-11 12:06:58', '2025-02-13 08:23:40', '2025-06-11 12:06:58'),
(15, 15, 'email_password', NULL, 'user6@vlam.nl', '$2y$12$y91iuFAsF4LxeHRND0zQ3ek1vUovbQTk.CHOk3EGVbatUJgh3YP8a', NULL, NULL, 0, NULL, '2025-03-11 13:30:21', '2025-03-11 13:30:22');

-- --------------------------------------------------------

--
-- Table structure for table `auth_logins`
--

CREATE TABLE `auth_logins` (
  `id` int UNSIGNED NOT NULL,
  `ip_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `identifier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_permissions_users`
--

CREATE TABLE `auth_permissions_users` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `permission` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_remember_tokens`
--

CREATE TABLE `auth_remember_tokens` (
  `id` int UNSIGNED NOT NULL,
  `selector` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `hashedValidator` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `expires` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_token_logins`
--

CREATE TABLE `auth_token_logins` (
  `id` int UNSIGNED NOT NULL,
  `ip_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `identifier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cases`
--

CREATE TABLE `cases` (
  `id` int NOT NULL,
  `assignment_id` int NOT NULL,
  `sort_order` int NOT NULL,
  `name` text NOT NULL,
  `intro` text NOT NULL,
  `outro` text NOT NULL,
  `info` text NOT NULL,
  `complete_action` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `case_entry`
--

CREATE TABLE `case_entry` (
  `id` int NOT NULL,
  `sort_order` int NOT NULL,
  `name` text NOT NULL,
  `info` text NOT NULL,
  `case_id` int NOT NULL,
  `type` enum('mcq','text_input','text_separator','mcq-2','mcq-3','') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `optional` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `case_entry_properties`
--

CREATE TABLE `case_entry_properties` (
  `id` int NOT NULL,
  `entry_id` int NOT NULL,
  `content` text NOT NULL,
  `sort_order` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `case_result`
--

CREATE TABLE `case_result` (
  `id` int NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `assignment_id` int NOT NULL,
  `case_id` int NOT NULL,
  `entry_id` int NOT NULL,
  `property_id` int DEFAULT NULL COMMENT 'if set to ''1'', this entry relies on stored property ids in value field	',
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `meetings`
--

CREATE TABLE `meetings` (
  `id` int NOT NULL,
  `name` int NOT NULL,
  `info` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `intro` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meetings`
--

INSERT INTO `meetings` (`id`, `name`, `info`, `intro`) VALUES
(1, 1, 'Kennismaking en werkvoorwaarden', '<h2><span style=\"color:hsl(270,75%,60%);\">Lorem Ipsum332</span></h2><h4><i>\"Neque <span style=\"background-color:hsl(30,75%,60%);\">porro quisquam </span>est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...\"</i></h4><p><strong>Lorem Ipsum</strong><span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\"> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p>'),
(2, 2, 'Kwaliteiten en persoonlijk profiel', ''),
(3, 3, 'Het belang van een sterk CV', ''),
(4, 4, 'Openheid geven', ''),
(5, 5, 'Ervaringen van een oud student', ''),
(6, 6, 'Solicitatiegesprek en actieplan', '');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint UNSIGNED NOT NULL,
  `version` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `group` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `namespace` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `time` int NOT NULL,
  `batch` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int NOT NULL,
  `class` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `type` varchar(31) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'string',
  `context` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trainings`
--

CREATE TABLE `trainings` (
  `id` int NOT NULL,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `started` datetime DEFAULT NULL,
  `stopped` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `training_assignments`
--

CREATE TABLE `training_assignments` (
  `id` int NOT NULL,
  `training_id` int NOT NULL,
  `meeting_id` int NOT NULL,
  `sort_order` int NOT NULL,
  `name` text NOT NULL,
  `intro` text NOT NULL,
  `outro` text,
  `info` text NOT NULL,
  `sub_assignment` text,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `training_assignment_entry`
--

CREATE TABLE `training_assignment_entry` (
  `id` int NOT NULL,
  `sort_order` int NOT NULL,
  `name` text NOT NULL,
  `info` text NOT NULL,
  `assignment_id` int NOT NULL,
  `type` enum('mcq','text_input','text_separator','mcq-2','mcq-3','video_youtube','') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `optional` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `training_assignment_entry_properties`
--

CREATE TABLE `training_assignment_entry_properties` (
  `id` int NOT NULL,
  `entry_id` int NOT NULL,
  `content` text NOT NULL,
  `sort_order` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `training_assignment_result`
--

CREATE TABLE `training_assignment_result` (
  `id` int NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `assignment_id` int NOT NULL,
  `entry_id` int NOT NULL,
  `property_id` int DEFAULT NULL COMMENT 'if set to ''1'', this entry relies on stored property ids in value field',
  `value` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `training_cases`
--

CREATE TABLE `training_cases` (
  `id` int NOT NULL,
  `assignment_id` int NOT NULL,
  `sort_order` int NOT NULL,
  `name` text NOT NULL,
  `intro` text NOT NULL,
  `outro` text NOT NULL,
  `info` text NOT NULL,
  `complete_action` text,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `training_case_entry`
--

CREATE TABLE `training_case_entry` (
  `id` int NOT NULL,
  `sort_order` int NOT NULL,
  `name` text NOT NULL,
  `info` text NOT NULL,
  `case_id` int NOT NULL,
  `type` enum('mcq','text_input','text_separator','mcq-2','mcq-3','') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `optional` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `training_case_entry_properties`
--

CREATE TABLE `training_case_entry_properties` (
  `id` int NOT NULL,
  `entry_id` int NOT NULL,
  `content` text NOT NULL,
  `sort_order` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `training_case_result`
--

CREATE TABLE `training_case_result` (
  `id` int NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `assignment_id` int NOT NULL,
  `case_id` int NOT NULL,
  `entry_id` int NOT NULL,
  `property_id` int DEFAULT NULL COMMENT 'if set to ''1'', this entry relies on stored property ids in value field	',
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `training_meetings`
--

CREATE TABLE `training_meetings` (
  `id` int NOT NULL,
  `training_id` int NOT NULL,
  `name` int NOT NULL,
  `info` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `intro` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `training_schedule`
--

CREATE TABLE `training_schedule` (
  `id` int NOT NULL,
  `training_id` int NOT NULL,
  `meeting_id` int NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `training_users`
--

CREATE TABLE `training_users` (
  `id` int NOT NULL,
  `training_id` int NOT NULL,
  `user_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `training_user_meta`
--

CREATE TABLE `training_user_meta` (
  `id` int NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `value` text NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE `uploads` (
  `id` int NOT NULL,
  `global` int NOT NULL DEFAULT '0',
  `user_id` int UNSIGNED NOT NULL,
  `path` text NOT NULL,
  `filename` text NOT NULL,
  `extension` text NOT NULL,
  `mime_type` text NOT NULL,
  `bytes` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `username` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `firstname` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `middlename` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `lastname` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_message` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
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
(7, 'user5', 'User', '', '5', NULL, NULL, 1, NULL, '2025-02-13 08:23:39', '2025-02-13 08:23:40', NULL),
(15, 'user6', 'User', 'as', 'a.', NULL, NULL, 0, NULL, '2025-03-11 13:30:21', '2025-03-11 13:30:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_meta`
--

CREATE TABLE `user_meta` (
  `id` int NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `value` text NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `assignment_entry_assignment_id_foreign` (`assignment_id`);

--
-- Indexes for table `assignment_entry_properties`
--
ALTER TABLE `assignment_entry_properties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assignment_entry_property_entry_id_foreign` (`entry_id`);

--
-- Indexes for table `assignment_result`
--
ALTER TABLE `assignment_result`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `assignment_id` (`user_id`,`assignment_id`,`entry_id`) USING BTREE,
  ADD KEY `assignment_result_assignment_id_foreign` (`assignment_id`),
  ADD KEY `assignment_result_entry_id_foreign` (`entry_id`);

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
-- Indexes for table `cases`
--
ALTER TABLE `cases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cases_assignment_id_foreign` (`assignment_id`);

--
-- Indexes for table `case_entry`
--
ALTER TABLE `case_entry`
  ADD PRIMARY KEY (`id`),
  ADD KEY `case_entry_case_id_foreign` (`case_id`);

--
-- Indexes for table `case_entry_properties`
--
ALTER TABLE `case_entry_properties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `case_entry_properties_entry_id_foreign` (`entry_id`);

--
-- Indexes for table `case_result`
--
ALTER TABLE `case_result`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `assignment_id` (`user_id`,`assignment_id`,`case_id`,`entry_id`) USING BTREE,
  ADD KEY `case_result_assignment_id_foreign` (`assignment_id`),
  ADD KEY `case_result_case_id_foreign` (`case_id`),
  ADD KEY `case_result_entry_id_foreign` (`entry_id`);

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
-- Indexes for table `training_assignments`
--
ALTER TABLE `training_assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `training_assignments_trainings_id_foreign` (`training_id`);

--
-- Indexes for table `training_assignment_entry`
--
ALTER TABLE `training_assignment_entry`
  ADD PRIMARY KEY (`id`),
  ADD KEY `training_assignment_entry_assignment_id_foreign` (`assignment_id`);

--
-- Indexes for table `training_assignment_entry_properties`
--
ALTER TABLE `training_assignment_entry_properties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `training_assignment_entry_properties_entry_id_foreign` (`entry_id`);

--
-- Indexes for table `training_assignment_result`
--
ALTER TABLE `training_assignment_result`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `assignment_id` (`user_id`,`assignment_id`,`entry_id`) USING BTREE,
  ADD KEY `training_assignment_result_assignment_id_foreign` (`assignment_id`);

--
-- Indexes for table `training_cases`
--
ALTER TABLE `training_cases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `training_cases_assignment_id_foreign` (`assignment_id`);

--
-- Indexes for table `training_case_entry`
--
ALTER TABLE `training_case_entry`
  ADD PRIMARY KEY (`id`),
  ADD KEY `training_cases_entry_case_id_foreign` (`case_id`);

--
-- Indexes for table `training_case_entry_properties`
--
ALTER TABLE `training_case_entry_properties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `training_cases_entry_properties_entry_id_foreign` (`entry_id`);

--
-- Indexes for table `training_case_result`
--
ALTER TABLE `training_case_result`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `assignment_id` (`user_id`,`assignment_id`,`case_id`,`entry_id`) USING BTREE,
  ADD KEY `training_case_result_assignment_id_foreign` (`assignment_id`);

--
-- Indexes for table `training_meetings`
--
ALTER TABLE `training_meetings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `training_meetings_trainings_id_foreign` (`training_id`);

--
-- Indexes for table `training_schedule`
--
ALTER TABLE `training_schedule`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `training_id` (`training_id`,`meeting_id`),
  ADD KEY `training_schedule_meeting_id_foreign` (`meeting_id`);

--
-- Indexes for table `training_users`
--
ALTER TABLE `training_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `training_id` (`training_id`,`user_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `training_user_meta`
--
ALTER TABLE `training_user_meta`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`name`(200));

--
-- Indexes for table `uploads`
--
ALTER TABLE `uploads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uploads_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_meta`
--
ALTER TABLE `user_meta`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`name`(200));

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assignment_entry`
--
ALTER TABLE `assignment_entry`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assignment_entry_properties`
--
ALTER TABLE `assignment_entry_properties`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assignment_result`
--
ALTER TABLE `assignment_result`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_identities`
--
ALTER TABLE `auth_identities`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `auth_logins`
--
ALTER TABLE `auth_logins`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_permissions_users`
--
ALTER TABLE `auth_permissions_users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_remember_tokens`
--
ALTER TABLE `auth_remember_tokens`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_token_logins`
--
ALTER TABLE `auth_token_logins`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cases`
--
ALTER TABLE `cases`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `case_entry`
--
ALTER TABLE `case_entry`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `case_entry_properties`
--
ALTER TABLE `case_entry_properties`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `case_result`
--
ALTER TABLE `case_result`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meetings`
--
ALTER TABLE `meetings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trainings`
--
ALTER TABLE `trainings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `training_assignments`
--
ALTER TABLE `training_assignments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `training_assignment_entry`
--
ALTER TABLE `training_assignment_entry`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `training_assignment_entry_properties`
--
ALTER TABLE `training_assignment_entry_properties`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `training_assignment_result`
--
ALTER TABLE `training_assignment_result`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `training_cases`
--
ALTER TABLE `training_cases`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `training_case_entry`
--
ALTER TABLE `training_case_entry`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `training_case_entry_properties`
--
ALTER TABLE `training_case_entry_properties`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `training_case_result`
--
ALTER TABLE `training_case_result`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `training_meetings`
--
ALTER TABLE `training_meetings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `training_schedule`
--
ALTER TABLE `training_schedule`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `training_users`
--
ALTER TABLE `training_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `training_user_meta`
--
ALTER TABLE `training_user_meta`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uploads`
--
ALTER TABLE `uploads`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user_meta`
--
ALTER TABLE `user_meta`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignment_entry`
--
ALTER TABLE `assignment_entry`
  ADD CONSTRAINT `assignment_entry_assignment_id_foreign` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `assignment_entry_properties`
--
ALTER TABLE `assignment_entry_properties`
  ADD CONSTRAINT `assignment_entry_property_entry_id_foreign` FOREIGN KEY (`entry_id`) REFERENCES `assignment_entry` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `assignment_result`
--
ALTER TABLE `assignment_result`
  ADD CONSTRAINT `assignment_result_assignment_id_foreign` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assignment_result_entry_id_foreign` FOREIGN KEY (`entry_id`) REFERENCES `assignment_entry` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assignment_result_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

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

--
-- Constraints for table `cases`
--
ALTER TABLE `cases`
  ADD CONSTRAINT `cases_assignment_id_foreign` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `case_entry`
--
ALTER TABLE `case_entry`
  ADD CONSTRAINT `case_entry_case_id_foreign` FOREIGN KEY (`case_id`) REFERENCES `cases` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `case_entry_properties`
--
ALTER TABLE `case_entry_properties`
  ADD CONSTRAINT `case_entry_properties_entry_id_foreign` FOREIGN KEY (`entry_id`) REFERENCES `case_entry` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `case_result`
--
ALTER TABLE `case_result`
  ADD CONSTRAINT `case_result_assignment_id_foreign` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `case_result_case_id_foreign` FOREIGN KEY (`case_id`) REFERENCES `cases` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `case_result_entry_id_foreign` FOREIGN KEY (`entry_id`) REFERENCES `case_entry` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `case_result_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `training_assignments`
--
ALTER TABLE `training_assignments`
  ADD CONSTRAINT `training_assignments_trainings_id_foreign` FOREIGN KEY (`training_id`) REFERENCES `trainings` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `training_assignment_entry`
--
ALTER TABLE `training_assignment_entry`
  ADD CONSTRAINT `training_assignment_entry_assignment_id_foreign` FOREIGN KEY (`assignment_id`) REFERENCES `training_assignments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `training_assignment_entry_properties`
--
ALTER TABLE `training_assignment_entry_properties`
  ADD CONSTRAINT `training_assignment_entry_properties_entry_id_foreign` FOREIGN KEY (`entry_id`) REFERENCES `training_assignment_entry` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `training_assignment_result`
--
ALTER TABLE `training_assignment_result`
  ADD CONSTRAINT `training_assignment_result_assignment_id_foreign` FOREIGN KEY (`assignment_id`) REFERENCES `training_assignments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `training_assignment_result_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `training_users` (`user_id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `training_cases`
--
ALTER TABLE `training_cases`
  ADD CONSTRAINT `training_cases_assignment_id_foreign` FOREIGN KEY (`assignment_id`) REFERENCES `training_assignments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `training_case_entry`
--
ALTER TABLE `training_case_entry`
  ADD CONSTRAINT `training_cases_entry_case_id_foreign` FOREIGN KEY (`case_id`) REFERENCES `training_cases` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `training_case_entry_properties`
--
ALTER TABLE `training_case_entry_properties`
  ADD CONSTRAINT `training_cases_entry_properties_entry_id_foreign` FOREIGN KEY (`entry_id`) REFERENCES `training_case_entry` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `training_case_result`
--
ALTER TABLE `training_case_result`
  ADD CONSTRAINT `training_case_result_assignment_id_foreign` FOREIGN KEY (`assignment_id`) REFERENCES `training_assignments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `training_case_result_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `training_users` (`user_id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `training_meetings`
--
ALTER TABLE `training_meetings`
  ADD CONSTRAINT `training_meetings_trainings_id_foreign` FOREIGN KEY (`training_id`) REFERENCES `trainings` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `training_schedule`
--
ALTER TABLE `training_schedule`
  ADD CONSTRAINT `training_schedule_meeting_id_foreign` FOREIGN KEY (`meeting_id`) REFERENCES `training_meetings` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `training_users`
--
ALTER TABLE `training_users`
  ADD CONSTRAINT `training_users_trainings_id_foreign` FOREIGN KEY (`training_id`) REFERENCES `trainings` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `training_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `training_user_meta`
--
ALTER TABLE `training_user_meta`
  ADD CONSTRAINT `training_user_meta_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `training_users` (`user_id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `uploads`
--
ALTER TABLE `uploads`
  ADD CONSTRAINT `uploads_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `user_meta`
--
ALTER TABLE `user_meta`
  ADD CONSTRAINT `user_meta_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
