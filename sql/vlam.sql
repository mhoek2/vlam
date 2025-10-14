-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 14, 2025 at 10:23 AM
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

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`id`, `meeting_id`, `sort_order`, `name`, `intro`, `outro`, `info`, `sub_assignment`, `created_at`) VALUES
(1, 1, 0, 'Opdracht 1', '<p><span style=\"color:rgb(0,0,0);\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. V</span><span style=\"color:rgb(255,255,255);\">i</span><span style=\"color:#ffff00;\">vamu</span><span style=\"color:rgb(0,0,0);\">s nulla mauris, mattis vel pulvinar sit amet, efficitur a purus. Donec sit amet accumsan diam, a euismod felis. Duis dolor orci, lobortis maximus convallis nec, venenatis at neque. Morbi a pretium risus. Morbi sed dolor eleifend, ultricies urna at, tempor risus. Maecenas sed posuere augue. Quisque mollis ac odio sed molestie. Maecenas bibendum, magna vitae fringilla elementum, arcu velit tristique mauris, bibendum lobortis sem sem ut quam.</span></p>', '<p>asdasd</p>', 'Herken de werkervaring', 'ExamplePostSaveController', '2025-02-17 19:05:20'),
(32, 1, 2, 'Opdracht 2', '<h1>De tekst die de opdracht verder uitlegt. <strong>Dat kan ook vet.</strong></h1>', '', 'Informatie over de opdracht', 'default', '2025-09-03 11:34:57');

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

--
-- Dumping data for table `assignment_entry`
--

INSERT INTO `assignment_entry` (`id`, `sort_order`, `name`, `info`, `assignment_id`, `type`, `optional`) VALUES
(98, 1, 'Samenwerken met collega\'s aan een project', '', 1, 'mcq', 0),
(99, 2, 'Het bijwonen van vergaderingen', '', 1, 'mcq-2', 1),
(100, 3, 'Zelfstandig werken aan een taak', '', 1, 'mcq-2', 0),
(101, 4, 'Het geven van een presentatie of training', '', 1, 'mcq', 0),
(102, 5, 'Werken onder tijdsdruk of met strakke deadlines', '', 1, 'mcq', 0),
(103, 6, 'Het ontvangen van complimenten of erkenning voor je werk', '', 1, 'mcq', 0),
(104, 7, 'E-mails of berichten beantwoorden gedurende de dag', '', 1, 'mcq', 0),
(105, 0, 'Vraag 1', '', 32, 'mcq-2', 0),
(106, 1, 'Vraag 1', '', 32, 'mcq', 0),
(107, 3, 'Vraag 1', '', 32, 'mcq', 0),
(108, 4, 'Vraag 1', '', 32, 'text_separator', 0),
(109, 5, 'tekst gat', '', 32, 'text_separator', 0),
(110, 8, 'Typ iets', '', 1, 'text_input', 1),
(111, 2, 'https://www.youtube.com/watch?v=BgflggMXrv8', '', 32, 'video_youtube', 0);

-- --------------------------------------------------------

--
-- Table structure for table `assignment_entry_properties`
--

CREATE TABLE `assignment_entry_properties` (
  `id` int NOT NULL,
  `entry_id` int NOT NULL,
  `content` text NOT NULL,
  `placeholder` int NOT NULL DEFAULT '0',
  `sort_order` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `assignment_entry_properties`
--

INSERT INTO `assignment_entry_properties` (`id`, `entry_id`, `content`, `placeholder`, `sort_order`) VALUES
(141, 98, 'Geeft energie', 0, 1),
(142, 98, 'Kost energie', 0, 2),
(143, 99, 'Geeft energie', 0, 1),
(144, 100, 'Geeft energie', 0, 0),
(145, 101, 'Geeft energie', 0, 0),
(146, 102, 'Geeft energie', 0, 0),
(147, 103, 'Geeft energie', 0, 0),
(148, 104, 'Geeft energie', 0, 0),
(149, 104, 'Kost energie', 0, 1),
(150, 103, 'Kost energie', 0, 1),
(151, 102, 'Kost energie', 0, 1),
(152, 101, 'Kost energie', 0, 1),
(153, 100, 'Kost energie', 0, 1),
(154, 99, 'Kost energie', 0, 2),
(155, 105, 'antwoord 1', 0, 0),
(156, 105, 'antwoord 2', 0, 1),
(157, 108, '<p>asdasdasd</p>', 0, 0),
(158, 109, '<p>Gaten in de tekst</p>', 0, 0),
(159, 105, 'antwoord 3', 0, 2),
(160, 106, 'ja', 0, 0),
(161, 106, 'nee', 0, 1),
(163, 111, 'BgflggMXrv8', 0, 0),
(185, 98, 'Kies een optie', 1, 0),
(186, 99, 'Kies een optie', 1, 0);

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

--
-- Dumping data for table `auth_groups_users`
--

INSERT INTO `auth_groups_users` (`id`, `user_id`, `group`, `created_at`) VALUES
(2, 2, 'admin', '2025-02-05 09:20:35'),
(21, 21, 'user', '2025-09-10 12:27:50');

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
(2, 2, 'email_password', '', 'admin@vlam.nl', '$2y$12$CFeavzQijA.w4yu7.276auOuovnwGJQtKFj59AEVcu3EFllrXs4yG', NULL, NULL, 0, '2025-10-14 06:58:35', '2025-02-05 09:20:35', '2025-10-14 06:58:35'),
(21, 21, 'email_password', NULL, 'user1@vlam.nl', '$2y$12$XZfuth7qTumIQnte894NU.wrPKrF9fToYTaVtjdbK.DtADtYPJQ3q', NULL, NULL, 0, '2025-10-14 07:02:26', '2025-09-10 12:27:50', '2025-10-14 07:02:26');

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
(1, 1, 'Kennismaking en werkvoorwaarden', '<p>Toen ik aan het werk ging, ontdekte ik dat bepaalde onderdelen vna mij werk me blij maakten en me energie gaven om de slag te gan. Bijvoorbeeld, taken die goed aansloten bij mijn intresses en vaardigheden, zoals administratief werk en het organiseren van dingen. Ook werkte ik graag in een omgeving waarin ik me op mijn gemak voelde en leeftijdsgenoten om me heen.</p><p><i>Aan de andere kant waren er ook onderdelen van mijn werk die vermoeiden waren en ervoord zorgden dat het soms minder goed lukte. Bijvoorbeeld, te lange werkdagen en het reizen met het openbaar vervoer. Een werkomgeving, waar geen rekening wordt gehouden met mijn beperkingen, maakt het werk ook zwaarder.</i></p><p>&nbsp;</p><p><i>Dit is tekst.</i></p>'),
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
  `placeholder` int NOT NULL DEFAULT '0',
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
(21, '6572d1b3bc7cba77c72f', 'Piet', '', '12', NULL, NULL, 0, NULL, '2025-09-10 12:27:50', '2025-09-10 12:27:50', NULL);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `assignment_entry`
--
ALTER TABLE `assignment_entry`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `assignment_entry_properties`
--
ALTER TABLE `assignment_entry_properties`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=187;

--
-- AUTO_INCREMENT for table `assignment_result`
--
ALTER TABLE `assignment_result`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `auth_identities`
--
ALTER TABLE `auth_identities`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

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
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

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
