-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 10, 2025 at 12:56 PM
-- Server version: 8.0.41-0ubuntu0.20.04.1
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
(3, 1, 2, 'Opdracht 3', '<p>Opdracht 3</p>', '', 'Kwaliteit Kaarten', 'CardController', '2025-02-17 19:05:20'),
(5, 1, 1, 'Opdracht 2', '<p>Opdracht 5</p>', '', 'Podcast', 'PodcastController', '2025-02-17 19:05:20'),
(11, 1, 3, 'Opdracht 4: Maatwerk na een opdracht', '<p>Deze tekst komt in beeld <strong>VOOR </strong>het opslaan van een opdracht</p>', '<p>Deze tekst komt in beeld <strong>NA </strong>het opslaan van een opdracht</p>', '', 'OutroController', '2025-02-25 10:35:54');

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
  `type` enum('mcq','text_input','text_separator','mcq-2','mcq-3','') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `optional` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `assignment_entry`
--

INSERT INTO `assignment_entry` (`id`, `sort_order`, `name`, `info`, `assignment_id`, `type`, `optional`) VALUES
(29, 2, 'Ben je tevreden', '', 1, 'mcq', 0),
(36, 4, 'Toevoeging 1', '', 1, 'text_input', 0),
(38, 5, 'Toevoeging 2', '', 1, 'text_input', 1),
(43, 1, 'Of een tussenvoegsel', '', 11, 'text_separator', 0),
(44, 0, 'Er moet wel een vraag zijn', '', 11, 'mcq', 0),
(48, 3, 'Tekstkop 1', '', 1, 'text_separator', 0),
(55, 0, 'Rustgevende kleur', '', 1, 'mcq-2', 0),
(64, 1, 'nog een optie', '', 1, 'mcq-2', 0);

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

--
-- Dumping data for table `assignment_entry_properties`
--

INSERT INTO `assignment_entry_properties` (`id`, `entry_id`, `content`, `sort_order`) VALUES
(34, 29, 'Nee', 0),
(35, 29, 'Misschien', 1),
(36, 29, 'Ja', 2),
(37, 29, 'Zeker weten', 3),
(62, 43, '<p>Of een tussenvoegsel.</p>', 0),
(67, 48, '<p>Dit is tekst tussen de vragen</p>', 0),
(72, 55, 'Rood', 0),
(73, 55, 'Groen', 3),
(74, 55, 'Blauw', 4),
(75, 55, 'Zwart', 1),
(76, 55, 'Oranje', 2),
(97, 64, '1', 0),
(98, 64, '2', 1),
(99, 64, '3', 2),
(100, 64, '4', 3),
(101, 64, '5', 4);

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

--
-- Dumping data for table `assignment_result`
--

INSERT INTO `assignment_result` (`id`, `user_id`, `assignment_id`, `entry_id`, `property_id`, `value`) VALUES
(1046, 2, 1, 55, 1, '[72]'),
(1047, 2, 1, 64, 1, '[97]'),
(1048, 2, 1, 29, 1, '[37]'),
(1049, 2, 1, 36, NULL, '1'),
(1050, 2, 1, 38, NULL, '');

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
(3, 3, 'user', '2025-02-13 08:21:52'),
(4, 4, 'user', '2025-02-13 08:22:31'),
(5, 5, 'user', '2025-02-13 08:22:57'),
(6, 6, 'user', '2025-02-13 08:23:14'),
(7, 7, 'user', '2025-02-13 08:23:40'),
(15, 15, 'user', '2025-03-11 13:30:22');

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
(2, 2, 'email_password', '', 'admin@vlam.nl', '$2y$12$CFeavzQijA.w4yu7.276auOuovnwGJQtKFj59AEVcu3EFllrXs4yG', NULL, NULL, 0, '2025-04-10 06:53:32', '2025-02-05 09:20:35', '2025-04-10 06:53:32'),
(3, 3, 'email_password', NULL, 'user1@vlam.nl', '$2y$12$2qVsxlZTaVhyA1ne60qDaudYkCX9VIdj4ObMlAOamVFtWfICm3/6i', NULL, NULL, 0, '2025-03-28 19:09:26', '2025-02-13 08:21:52', '2025-03-28 19:09:26'),
(4, 4, 'email_password', NULL, 'user2@vlam.nl', '$2y$12$vJPJlsyJgkXCerGvzzc1PePQQ7sOWNed3Rb.98HwrO7fkl09ZofrC', NULL, NULL, 0, NULL, '2025-02-13 08:22:30', '2025-02-13 08:22:31'),
(5, 5, 'email_password', NULL, 'user3@vlam.nl', '$2y$12$76GI7FOlmaDpflY6JZgrR.mxs5hyDb.7UR0h7pddjQ3xW99oyplJm', NULL, NULL, 0, NULL, '2025-02-13 08:22:57', '2025-02-13 08:22:57'),
(6, 6, 'email_password', NULL, 'user4@vlam.nl', '$2y$12$6AfG80CW1Kdd6NjkBsGNeO/cmb9ll/ZIOe.//ul1Q8AzKpvuOnQmW', NULL, NULL, 0, NULL, '2025-02-13 08:23:13', '2025-02-13 08:23:14'),
(7, 7, 'email_password', NULL, 'user5@vlam.nl', '$2y$12$oHNz7PkSRW5Bcgja7iAtiu5/NBEGh1i4fB.C6J/sPdvYMva0VQNBG', NULL, NULL, 0, '2025-04-02 16:30:16', '2025-02-13 08:23:40', '2025-04-02 16:30:16'),
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

--
-- Dumping data for table `cases`
--

INSERT INTO `cases` (`id`, `assignment_id`, `sort_order`, `name`, `intro`, `outro`, `info`, `complete_action`, `created_at`) VALUES
(9, 1, 0, 'Casus 1: Openheid over autisme op werk', '<p>2Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus nulla mauris, mattis vel pulvinar sit amet, efficitur a purus. Donec sit amet accumsan diam, a euismod felis. Duis dolor orci, lobortis maximus convallis nec, venenatis at neque. Morbi a pretium risus. Morbi sed dolor eleifend, ultricies urna at, tempor risus. Maecenas sed posuere augue. Quisque mollis ac odio sed molestie. Maecenas bibendum, magna vitae fringilla elementum, arcu velit tristique mauris, bibendum lobortis sem sem ut quam.</p><p>&nbsp;</p><p>asas</p><p>&nbsp;</p>', '<h1>Goed Gedaan!</h1><p><strong>L3orem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus nulla mauris, mattis vel pulvinar sit amet, efficitur a purus. Donec sit amet accumsan diam, a euismod felis. Duis dolor orci, lobortis maximus convallis nec, venenatis at neque. Morbi a pretium risus.&nbsp;</strong></p><ul><li><strong>Morbi sed:</strong> dolor eleifend, ultricies urna at, tempor risus. Maecenas sed posuere augue. Quisque mollis ac odio sed molestie.</li><li><strong>Maecenas bibendum:</strong> magna vitae fringilla elementum, arcu velit tristique mauris, bibendum lobortis sem sem ut quam.</li><li><strong>Maecenas bibendum:</strong> magna vitae fringilla elementum, arcu velit tristique mauris, bibendum lobortis sem sem ut quam.</li></ul><p><strong>Wat nu?</strong></p><ul><li><strong>Morbi sed:</strong> dolor eleifend, ultricies urna at, tempor risus. Maecenas sed posuere augue. Quisque mollis ac odio sed molestie.</li><li><strong>Maecenas bibendum:</strong> magna vitae fringilla elementum, arcu velit tristique mauris, bibendum lobortis sem sem ut quam.</li><li><strong>Maecenas bibendum:</strong> magna vitae fringilla elementum, arcu velit tristique mauris, bibendum lobortis sem sem ut quam.</li></ul>', 'Extra informatie', 'ExamplePostSaveController', '2025-02-18 08:04:23'),
(20, 1, 1, 'Casus', '', '', '', '', '2025-03-04 09:57:49');

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

--
-- Dumping data for table `case_entry`
--

INSERT INTO `case_entry` (`id`, `sort_order`, `name`, `info`, `case_id`, `type`, `optional`) VALUES
(1, 1, 'Wat zou jij doen als je in de situatie van de hoofdpersoon zat?', '', 9, 'mcq-2', 0),
(2, 2, 'Wanneer zou je openheid geven?', '', 9, 'mcq', 0),
(3, 3, 'Welke informatie zou jij delen?', '', 9, 'mcq', 0),
(22, 0, 'Mooie kleur', '', 20, 'mcq', 0),
(23, 0, 'test', '', 9, 'text_separator', 0);

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

--
-- Dumping data for table `case_entry_properties`
--

INSERT INTO `case_entry_properties` (`id`, `entry_id`, `content`, `sort_order`) VALUES
(42, 1, 'A: Ik geef openheid om ondersteuning te krijgen', 0),
(43, 1, 'B: Ik geef geen openheid om stigmatisering te vermijden', 1),
(47, 1, 'C: Ik weet het niet en wil meer informatie', 2),
(48, 3, 'A: Ik deel alles, inclusief de details van mijn belemmeringen', 0),
(49, 3, 'B: Ik deel alleen wat relevant is voor mijn werk', 0),
(50, 3, 'C: Ik deel helemaal niets!', 0),
(65, 2, 'A: Ik geef openheid om ondersteuning te krijgen', 0),
(66, 2, 'B: Ik geef geen openheid om stigmatisering te vermijden', 1),
(67, 2, 'C: Ik weet het niet en wil meer informatie', 2),
(89, 22, 'groen', 0),
(90, 22, 'zwart', 1),
(91, 23, '<p>asdasd</p>', 0);

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

--
-- Dumping data for table `case_result`
--

INSERT INTO `case_result` (`id`, `user_id`, `assignment_id`, `case_id`, `entry_id`, `property_id`, `value`) VALUES
(461, 2, 1, 9, 2, 1, '[65]'),
(462, 2, 1, 9, 3, 1, '[49]'),
(464, 2, 1, 9, 1, 1, '[-1]');

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
(1, 1, 'Kennismaking en werkvoorwaarden', '<h2><span style=\"color:hsl(270,75%,60%);\">Lorem Ipsum33</span></h2><h4><i>\"Neque <span style=\"background-color:hsl(30,75%,60%);\">porro quisquam </span>est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...\"</i></h4><p><strong>Lorem Ipsum</strong><span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\"> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p>'),
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

--
-- Dumping data for table `trainings`
--

INSERT INTO `trainings` (`id`, `name`, `started`, `stopped`, `created_at`) VALUES
(6, 'Training #3', NULL, NULL, '2025-02-13 14:23:31'),
(23, 'Training 23', '2025-03-13 10:59:58', NULL, '2025-03-12 12:39:58'),
(24, 'Nieuwe training', NULL, NULL, '2025-04-01 08:18:08');

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

--
-- Dumping data for table `training_assignments`
--

INSERT INTO `training_assignments` (`id`, `training_id`, `meeting_id`, `sort_order`, `name`, `intro`, `outro`, `info`, `sub_assignment`, `created_at`) VALUES
(306, 23, 1, 0, 'Opdracht 1', '<p><span style=\"color:rgb(0,0,0);\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. V</span><span style=\"color:rgb(255,255,255);\">i</span><span style=\"color:#ffff00;\">vamu</span><span style=\"color:rgb(0,0,0);\">s nulla mauris, mattis vel pulvinar sit amet, efficitur a purus. Donec sit amet accumsan diam, a euismod felis. Duis dolor orci, lobortis maximus convallis nec, venenatis at neque. Morbi a pretium risus. Morbi sed dolor eleifend, ultricies urna at, tempor risus. Maecenas sed posuere augue. Quisque mollis ac odio sed molestie. Maecenas bibendum, magna vitae fringilla elementum, arcu velit tristique mauris, bibendum lobortis sem sem ut quam.</span></p>', '<p>asdasd</p>', 'Herken de werkervaring', 'ExamplePostSaveController', '2025-03-13 11:59:58'),
(307, 23, 1, 2, 'Opdracht 3', '<p>Opdracht 3</p>', '', 'Kwaliteit Kaarten', 'CardController', '2025-03-13 11:59:58'),
(308, 23, 1, 1, 'Opdracht 2', '<p>Opdracht 5</p>', '', 'Podcast', 'PodcastController', '2025-03-13 11:59:58'),
(309, 23, 1, 3, 'Opdracht 4: Maatwerk na een opdracht', '<p>Deze tekst komt in beeld <strong>VOOR </strong>het opslaan van een opdracht</p>', '<p>Deze tekst komt in beeld <strong>NA </strong>het opslaan van een opdracht</p>', '', 'OutroController', '2025-03-13 11:59:58');

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
  `type` enum('mcq','text_input','text_separator','mcq-2','mcq-3','') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `optional` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `training_assignment_entry`
--

INSERT INTO `training_assignment_entry` (`id`, `sort_order`, `name`, `info`, `assignment_id`, `type`, `optional`) VALUES
(463, 1, 'Ben je tevreden', '', 306, 'mcq', 0),
(464, 3, 'Toevoeging 1', '', 306, 'text_input', 0),
(465, 4, 'Toevoeging 2', '', 306, 'text_input', 0),
(466, 1, 'Of een tussenvoegsel', '', 309, 'text_separator', 0),
(467, 0, 'Er moet wel een vraag zijn', '', 309, 'mcq', 0),
(468, 2, 'Tekstkop 1', '', 306, 'text_separator', 0),
(469, 0, 'Rustgevende kleur', '', 306, 'mcq-2', 0);

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

--
-- Dumping data for table `training_assignment_entry_properties`
--

INSERT INTO `training_assignment_entry_properties` (`id`, `entry_id`, `content`, `sort_order`) VALUES
(504, 463, 'Nee', 0),
(505, 463, 'Misschien', 1),
(506, 463, 'Ja', 2),
(507, 463, 'Zeker weten', 3),
(508, 466, '<p>Of een tussenvoegsel.</p>', 0),
(509, 468, '<p>Dit is tekst tussen de vragen</p>', 0),
(510, 469, 'Rood', 0),
(511, 469, 'Groen', 2),
(512, 469, 'Blauw', 3),
(513, 469, 'Zwart', 4),
(514, 469, 'Oranje', 1);

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

--
-- Dumping data for table `training_assignment_result`
--

INSERT INTO `training_assignment_result` (`id`, `user_id`, `assignment_id`, `entry_id`, `property_id`, `value`) VALUES
(314, 7, 306, 469, 1, '[511,512]'),
(315, 7, 306, 463, 1, '[504]'),
(316, 7, 306, 464, NULL, 'blab'),
(317, 7, 306, 465, NULL, 'bla');

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

--
-- Dumping data for table `training_cases`
--

INSERT INTO `training_cases` (`id`, `assignment_id`, `sort_order`, `name`, `intro`, `outro`, `info`, `complete_action`, `created_at`) VALUES
(91, 306, 0, 'Casus 1: Openheid over autisme op werk', '<p>2Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus nulla mauris, mattis vel pulvinar sit amet, efficitur a purus. Donec sit amet accumsan diam, a euismod felis. Duis dolor orci, lobortis maximus convallis nec, venenatis at neque. Morbi a pretium risus. Morbi sed dolor eleifend, ultricies urna at, tempor risus. Maecenas sed posuere augue. Quisque mollis ac odio sed molestie. Maecenas bibendum, magna vitae fringilla elementum, arcu velit tristique mauris, bibendum lobortis sem sem ut quam.</p><p>&nbsp;</p><p>asas</p><p>&nbsp;</p>', '<h1>Goed Gedaan!</h1><p><strong>L3orem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus nulla mauris, mattis vel pulvinar sit amet, efficitur a purus. Donec sit amet accumsan diam, a euismod felis. Duis dolor orci, lobortis maximus convallis nec, venenatis at neque. Morbi a pretium risus.&nbsp;</strong></p><ul><li><strong>Morbi sed:</strong> dolor eleifend, ultricies urna at, tempor risus. Maecenas sed posuere augue. Quisque mollis ac odio sed molestie.</li><li><strong>Maecenas bibendum:</strong> magna vitae fringilla elementum, arcu velit tristique mauris, bibendum lobortis sem sem ut quam.</li><li><strong>Maecenas bibendum:</strong> magna vitae fringilla elementum, arcu velit tristique mauris, bibendum lobortis sem sem ut quam.</li></ul><p><strong>Wat nu?</strong></p><ul><li><strong>Morbi sed:</strong> dolor eleifend, ultricies urna at, tempor risus. Maecenas sed posuere augue. Quisque mollis ac odio sed molestie.</li><li><strong>Maecenas bibendum:</strong> magna vitae fringilla elementum, arcu velit tristique mauris, bibendum lobortis sem sem ut quam.</li><li><strong>Maecenas bibendum:</strong> magna vitae fringilla elementum, arcu velit tristique mauris, bibendum lobortis sem sem ut quam.</li></ul>', 'Extra informatie', 'ExamplePostSaveController', '2025-03-13 11:59:58'),
(92, 306, 1, 'Casus', '', '', '', '', '2025-03-13 11:59:58');

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

--
-- Dumping data for table `training_case_entry`
--

INSERT INTO `training_case_entry` (`id`, `sort_order`, `name`, `info`, `case_id`, `type`, `optional`) VALUES
(178, 0, 'Wat zou jij doen als je in de situatie van de hoofdpersoon zat?', '', 91, 'mcq-2', 0),
(179, 1, 'Wanneer zou je openheid geven?', '', 91, 'mcq', 0),
(180, 3, 'Welke informatie zou jij delen?', '', 91, 'mcq', 0),
(181, 2, 'Handmatige invoer', '', 91, 'text_input', 0);

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

--
-- Dumping data for table `training_case_entry_properties`
--

INSERT INTO `training_case_entry_properties` (`id`, `entry_id`, `content`, `sort_order`) VALUES
(450, 178, 'A: Ik geef openheid om ondersteuning te krijgen', 0),
(451, 178, 'B: Ik geef geen openheid om stigmatisering te vermijden', 3),
(452, 178, 'C: Ik weet het niet en wil meer informatie', 1),
(453, 180, 'A: Ik deel alles, inclusief de details van mijn belemmeringen', 0),
(454, 180, 'B: Ik deel alleen wat relevant is voor mijn werk', 0),
(455, 180, 'C: Ik deel helemaal niets!', 0),
(456, 179, 'A: Ik geef openheid om ondersteuning te krijgen', 0),
(457, 179, 'B: Ik geef geen openheid om stigmatisering te vermijden', 1),
(458, 179, 'C: Ik weet het niet en wil meer informatie', 2);

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

--
-- Dumping data for table `training_case_result`
--

INSERT INTO `training_case_result` (`id`, `user_id`, `assignment_id`, `case_id`, `entry_id`, `property_id`, `value`) VALUES
(59, 7, 306, 91, 179, 1, '[457]'),
(62, 7, 306, 91, 178, 1, '[450,451]'),
(63, 7, 306, 91, 180, 1, '[455]');

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

--
-- Dumping data for table `training_schedule`
--

INSERT INTO `training_schedule` (`id`, `training_id`, `meeting_id`, `date`) VALUES
(43, 6, 1, '2025-03-12 10:30:00'),
(44, 6, 2, '2025-03-12 10:45:00'),
(45, 6, 3, '2025-03-12 11:00:00'),
(46, 6, 4, '2025-03-12 10:45:00'),
(47, 6, 5, '2025-03-12 11:15:00'),
(48, 6, 6, '2025-03-12 11:45:00'),
(67, 23, 1, '2025-03-12 12:00:00'),
(68, 23, 2, '2025-03-12 13:41:00'),
(69, 23, 3, '2025-03-12 14:45:00'),
(70, 23, 4, '2025-03-12 14:15:00'),
(71, 23, 5, '2025-03-12 11:15:00'),
(72, 23, 6, '2025-03-12 14:15:00');

-- --------------------------------------------------------

--
-- Table structure for table `training_users`
--

CREATE TABLE `training_users` (
  `id` int NOT NULL,
  `training_id` int NOT NULL,
  `user_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `training_users`
--

INSERT INTO `training_users` (`id`, `training_id`, `user_id`) VALUES
(61, 6, 3),
(60, 23, 2),
(59, 23, 7);

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

--
-- Dumping data for table `training_user_meta`
--

INSERT INTO `training_user_meta` (`id`, `user_id`, `name`, `value`, `created_at`) VALUES
(85, 7, 'assignment_meta', '[{\"value\":{\"511\":\"Groen\",\"512\":\"Blauw\"},\"property_id\":\"1\",\"entry_id\":\"469\",\"entry_name\":\"Rustgevende kleur\"},{\"value\":{\"504\":\"Nee\"},\"property_id\":\"1\",\"entry_id\":\"463\",\"entry_name\":\"Ben je tevreden\"},{\"value\":\"blab\",\"property_id\":null,\"entry_id\":\"464\",\"entry_name\":\"Toevoeging 1\"},{\"value\":\"bla\",\"property_id\":null,\"entry_id\":\"465\",\"entry_name\":\"Toevoeging 2\"}]', '2025-03-28 20:09:52'),
(86, 7, 'case_meta', '[{\"value\":{\"450\":\"A: Ik geef openheid om ondersteuning te krijgen\",\"451\":\"B: Ik geef geen openheid om stigmatisering te vermijden\"},\"property_id\":\"1\",\"entry_id\":\"178\",\"entry_name\":\"Wat zou jij doen als je in de situatie van de hoofdpersoon zat?\"},{\"value\":{\"457\":\"B: Ik geef geen openheid om stigmatisering te vermijden\"},\"property_id\":\"1\",\"entry_id\":\"179\",\"entry_name\":\"Wanneer zou je openheid geven?\"},{\"value\":{\"455\":\"C: Ik deel helemaal niets!\"},\"property_id\":\"1\",\"entry_id\":\"180\",\"entry_name\":\"Welke informatie zou jij delen?\"}]', '2025-03-28 20:10:06');

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
-- Dumping data for table `user_meta`
--

INSERT INTO `user_meta` (`id`, `user_id`, `name`, `value`, `created_at`) VALUES
(132, 2, 'case_meta', '[{\"value\":{\"43\":\"B: Ik geef geen openheid om stigmatisering te vermijden\",\"47\":\"C: Ik weet het niet en wil meer informatie\"},\"property_id\":\"1\",\"entry_id\":\"1\",\"entry_name\":\"Wat zou jij doen als je in de situatie van de hoofdpersoon zat?\"},{\"value\":{\"67\":\"C: Ik weet het niet en wil meer informatie\"},\"property_id\":\"1\",\"entry_id\":\"2\",\"entry_name\":\"Wanneer zou je openheid geven?\"},{\"value\":{\"50\":\"C: Ik deel helemaal niets!\"},\"property_id\":\"1\",\"entry_id\":\"3\",\"entry_name\":\"Welke informatie zou jij delen?\"}]', '2025-04-02 19:41:39'),
(143, 2, 'assignment_meta', '[{\"value\":{\"75\":\"Zwart\"},\"property_id\":\"1\",\"entry_id\":\"55\",\"entry_name\":\"Rustgevende kleur\"},{\"value\":{\"97\":\"1\"},\"property_id\":\"1\",\"entry_id\":\"64\",\"entry_name\":\"nog een optie\"},{\"value\":{\"37\":\"Zeker weten\"},\"property_id\":\"1\",\"entry_id\":\"29\",\"entry_name\":\"Ben je tevreden\"},{\"value\":\"asd\",\"property_id\":null,\"entry_id\":\"36\",\"entry_name\":\"Toevoeging 1\"},{\"value\":\"1\",\"property_id\":null,\"entry_id\":\"38\",\"entry_name\":\"Toevoeging 2\"}]', '2025-04-10 11:37:13');

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
-- Indexes for table `training_schedule`
--
ALTER TABLE `training_schedule`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `training_id` (`training_id`,`meeting_id`);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `assignment_entry`
--
ALTER TABLE `assignment_entry`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `assignment_entry_properties`
--
ALTER TABLE `assignment_entry_properties`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `assignment_result`
--
ALTER TABLE `assignment_result`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1051;

--
-- AUTO_INCREMENT for table `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `case_entry`
--
ALTER TABLE `case_entry`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `case_entry_properties`
--
ALTER TABLE `case_entry_properties`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `case_result`
--
ALTER TABLE `case_result`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=465;

--
-- AUTO_INCREMENT for table `meetings`
--
ALTER TABLE `meetings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trainings`
--
ALTER TABLE `trainings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `training_assignments`
--
ALTER TABLE `training_assignments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=310;

--
-- AUTO_INCREMENT for table `training_assignment_entry`
--
ALTER TABLE `training_assignment_entry`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=470;

--
-- AUTO_INCREMENT for table `training_assignment_entry_properties`
--
ALTER TABLE `training_assignment_entry_properties`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=515;

--
-- AUTO_INCREMENT for table `training_assignment_result`
--
ALTER TABLE `training_assignment_result`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=318;

--
-- AUTO_INCREMENT for table `training_cases`
--
ALTER TABLE `training_cases`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `training_case_entry`
--
ALTER TABLE `training_case_entry`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;

--
-- AUTO_INCREMENT for table `training_case_entry_properties`
--
ALTER TABLE `training_case_entry_properties`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=459;

--
-- AUTO_INCREMENT for table `training_case_result`
--
ALTER TABLE `training_case_result`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `training_schedule`
--
ALTER TABLE `training_schedule`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `training_users`
--
ALTER TABLE `training_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `training_user_meta`
--
ALTER TABLE `training_user_meta`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user_meta`
--
ALTER TABLE `user_meta`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

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
-- Constraints for table `training_schedule`
--
ALTER TABLE `training_schedule`
  ADD CONSTRAINT `training_schedule_training_id_foreign` FOREIGN KEY (`training_id`) REFERENCES `trainings` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

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
-- Constraints for table `user_meta`
--
ALTER TABLE `user_meta`
  ADD CONSTRAINT `user_meta_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
