-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 25, 2025 at 02:55 PM
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
(1, 1, 0, 'Opdracht 1', '<p><span style=\"color:rgb(0,0,0);\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. V</span><span style=\"color:rgb(255,255,255);\">i</span><span style=\"color:#ffff00;\">vamu</span><span style=\"color:rgb(0,0,0);\">s nulla mauris, mattis vel pulvinar sit amet, efficitur a purus. Donec sit amet accumsan diam, a euismod felis. Duis dolor orci, lobortis maximus convallis nec, venenatis at neque. Morbi a pretium risus. Morbi sed dolor eleifend, ultricies urna at, tempor risus. Maecenas sed posuere augue. Quisque mollis ac odio sed molestie. Maecenas bibendum, magna vitae fringilla elementum, arcu velit tristique mauris, bibendum lobortis sem sem ut quam.</span></p>', '', 'Herken de werkervaring', 'CardController', '2025-02-17 19:05:20'),
(3, 1, 3, 'Opdracht 3', 'Opdracht 3', NULL, '', NULL, '2025-02-17 19:05:20'),
(5, 1, 2, 'Opdracht 2', '<p>Opdracht 5</p>', '', 'Podcast', 'PodcastController', '2025-02-17 19:05:20'),
(11, 1, 4, 'Sub Assignment', '<p>sadasdasdsad</p>', '<p>basdasd</p>', '', 'OutroController', '2025-02-25 10:35:54');

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
  `type` enum('mcq','text_input','text_separator','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `assignment_entry`
--

INSERT INTO `assignment_entry` (`id`, `sort_order`, `name`, `info`, `assignment_id`, `type`) VALUES
(24, 1, 'Vraag 1', '', 1, 'mcq'),
(25, 0, 'Separator', '', 1, 'text_separator'),
(28, 3, 'Separator', '', 1, 'text_separator'),
(29, 4, 'Vraag 2', '', 1, 'mcq'),
(30, 2, 'Vraag 3', '', 1, 'mcq'),
(34, 1, 'Verwijderen?', '', 3, 'mcq'),
(36, 6, 'Voer tekst in', '', 1, 'text_input'),
(37, 5, 'Extra toevoegingen:', '', 1, 'text_separator'),
(38, 7, 'nieuwe vraag', '', 1, 'text_input');

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
(26, 24, 'Ja', 1),
(27, 24, 'Nee', 0),
(32, 28, '<p><strong>Lorem Ipsum</strong><span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\"> is simply dummy text of the printing and typesetting industry.</span></p>', 0),
(33, 25, '<p><i>Dit is ook Tekst</i></p>', 0),
(34, 29, 'Nee', 0),
(35, 29, 'Misschien', 1),
(36, 29, 'Ja', 2),
(37, 29, 'Zeker weten', 3),
(38, 30, 'test 1', 1),
(39, 30, 'test 2', 0),
(49, 34, 'JA', 0),
(50, 34, 'NEE', 0),
(52, 37, '<p>Extra Toevoegingen:</p>', 0);

-- --------------------------------------------------------

--
-- Table structure for table `assignment_result`
--

CREATE TABLE `assignment_result` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `assignment_id` int NOT NULL,
  `entry_id` int NOT NULL,
  `property_id` int DEFAULT NULL,
  `value` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `assignment_result`
--

INSERT INTO `assignment_result` (`id`, `user_id`, `assignment_id`, `entry_id`, `property_id`, `value`) VALUES
(82, 2, 3, 34, 50, NULL),
(94, 2, 1, 24, 26, NULL),
(95, 2, 1, 30, 39, NULL),
(96, 2, 1, 29, 37, NULL),
(97, 2, 1, 36, NULL, 'adasdasdasd'),
(98, 2, 1, 38, NULL, 'sadasd2');

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
(7, 7, 'user', '2025-02-13 08:23:40');

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
(2, 2, 'email_password', '', 'admin@vlam.nl', '$2y$12$03WJ08uzWhj7t16adUAhD.lNkR.D1/HIQPwjWOIiAExsemWypgjZG', NULL, NULL, 0, '2025-02-25 08:05:52', '2025-02-05 09:20:35', '2025-02-25 08:05:52'),
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
  `id` int UNSIGNED NOT NULL,
  `ip_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `identifier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
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
(26, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'email_password', 'admin@vlam.nl', 2, '2025-02-13 11:16:38', 1),
(27, '31.21.96.98', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'email_password', 'admin@vlam.nl', 2, '2025-02-17 17:12:21', 1),
(28, '31.21.96.98', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'email_password', 'admin@vlam.nl', 2, '2025-02-17 17:58:53', 1),
(29, '31.21.96.98', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'email_password', 'admin@vlam.nl', 2, '2025-02-17 21:53:58', 1),
(30, '31.21.96.98', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'email_password', 'admin@vlam.nl', NULL, '2025-02-18 07:00:32', 0),
(31, '31.21.96.98', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'email_password', 'admin@vlam.nl', 2, '2025-02-18 07:00:38', 1),
(32, '31.21.96.98', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'email_password', 'admin@vlam.nl', NULL, '2025-02-18 11:55:55', 0),
(33, '31.21.96.98', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'email_password', 'admin@vlam.nl', 2, '2025-02-18 11:56:02', 1),
(34, '31.21.96.98', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'email_password', 'admin@vlam.nl', 2, '2025-02-19 10:40:04', 1),
(35, '31.21.96.98', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'email_password', 'admin@vlam.nl', NULL, '2025-02-19 22:20:11', 0),
(36, '31.21.96.98', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'email_password', 'admin@vlam.nl', 2, '2025-02-19 22:20:22', 1),
(37, '31.21.96.98', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'email_password', 'admin@vlam.nl', NULL, '2025-02-20 07:36:14', 0),
(38, '31.21.96.98', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'email_password', 'admin@vlam.nl', 2, '2025-02-20 07:36:19', 1),
(39, '31.21.96.98', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'email_password', 'admin@vlam.nl', 2, '2025-02-21 14:23:11', 1),
(40, '31.21.96.98', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'email_password', 'admin@vlam.nl', NULL, '2025-02-22 10:04:26', 0),
(41, '31.21.96.98', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'email_password', 'admin@vlam.nl', 2, '2025-02-22 10:04:58', 1),
(42, '31.21.96.98', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'email_password', 'admin@vlam.nl', 2, '2025-02-22 15:34:37', 1),
(43, '31.21.96.98', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'email_password', 'admin@vlam.nl', 2, '2025-02-23 10:39:59', 1),
(44, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'email_password', 'admin@vlam.nl', 2, '2025-02-24 10:21:23', 1),
(45, '31.21.96.98', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'email_password', 'admin@vlam.nl', NULL, '2025-02-24 15:06:29', 0),
(46, '31.21.96.98', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'email_password', 'admin@vlam.nl', NULL, '2025-02-24 15:06:34', 0),
(47, '31.21.96.98', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'email_password', 'admin@vlam.nl', 2, '2025-02-24 15:06:38', 1),
(48, '31.21.96.98', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'email_password', 'admin@vlam.nl', 2, '2025-02-24 19:53:06', 1),
(49, '84.27.224.56', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'email_password', 'admin@vlam.nl', NULL, '2025-02-25 08:05:48', 0),
(50, '84.27.224.56', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'email_password', 'admin@vlam.nl', 2, '2025-02-25 08:05:52', 1);

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
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `cases`
--

INSERT INTO `cases` (`id`, `assignment_id`, `sort_order`, `name`, `intro`, `outro`, `info`, `created_at`) VALUES
(9, 1, 0, 'Casus 1: Openheid over autisme op werk', '<p><span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\">2Lorem ipsum dolor sit amet, consectetur adipiscing elit. V</span><span style=\"background-color:hsl(210,75%,60%);color:hsl(0,0%,100%);\">ivamu</span><span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\">s nulla mauris, mattis vel pulvinar sit amet, efficitur a purus. Donec sit amet accumsan diam, a euismod felis. Duis dolor orci, lobortis maximus convallis nec, venenatis at neque. Morbi a pretium risus. Morbi sed dolor eleifend, ultricies urna at, tempor risus. Maecenas sed posuere augue. Quisque mollis ac odio sed molestie. Maecenas bibendum, magna vitae fringilla elementum, arcu velit tristique mauris, bibendum lobortis sem sem ut quam.</span></p>', '<h1>\r\n    Goed Gedaan!\r\n</h1>\r\n<p>\r\n    <span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\"><strong>L3orem ipsum dolor sit amet, consectetur adipiscing elit. V</strong></span><span style=\"background-color:hsl(210,75%,60%);color:hsl(0,0%,100%);\"><strong>ivamu</strong></span><span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\"><strong>s nulla mauris, mattis vel pulvinar sit amet, efficitur a purus. Donec sit amet accumsan diam, a euismod felis. Duis dolor orci, lobortis maximus convallis nec, venenatis at neque. Morbi a pretium risus.&nbsp;</strong></span>\r\n</p>\r\n<ul>\r\n    <li>\r\n        <span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\"><strong>Morbi sed:</strong> dolor eleifend, ultricies urna at, tempor risus. Maecenas sed posuere augue. Quisque mollis ac odio sed molestie. </span>\r\n    </li>\r\n    <li>\r\n        <span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\"><strong>Maecenas bibendum:</strong> magna vitae fringilla elementum, arcu velit tristique mauris, bibendum lobortis sem sem ut quam.</span>\r\n    </li>\r\n    <li>\r\n        <span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\"><strong>Maecenas bibendum:</strong> magna vitae fringilla elementum, arcu velit tristique mauris, bibendum lobortis sem sem ut quam.</span>\r\n    </li>\r\n</ul>\r\n<p>\r\n    <span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\"><strong>Wat nu?</strong></span>\r\n</p>\r\n<ul>\r\n    <li>\r\n        <span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\"><strong>Morbi sed:</strong> dolor eleifend, ultricies urna at, tempor risus. Maecenas sed posuere augue. Quisque mollis ac odio sed molestie.</span>\r\n    </li>\r\n    <li>\r\n        <span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\"><strong>Maecenas bibendum:</strong> magna vitae fringilla elementum, arcu velit tristique mauris, bibendum lobortis sem sem ut quam.</span>\r\n    </li>\r\n    <li>\r\n        <span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\"><strong>Maecenas bibendum:</strong> magna vitae fringilla elementum, arcu velit tristique mauris, bibendum lobortis sem sem ut quam.</span>\r\n    </li>\r\n</ul>', '', '2025-02-18 08:04:23'),
(11, 1, 1, 'Casus 2', '', '', '', '2025-02-19 14:47:53'),
(12, 1, 2, 'Casus 3', '', '', '', '2025-02-19 14:56:35'),
(13, 3, 1, 'Casus', '', '', '', '2025-02-24 13:10:54');

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
  `type` enum('mcq','text_input','text_separator','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `case_entry`
--

INSERT INTO `case_entry` (`id`, `sort_order`, `name`, `info`, `case_id`, `type`) VALUES
(1, 0, 'Wat zou jij doen als je in de situatie van de hoofdpersoon zat?', '', 9, 'mcq'),
(2, 3, 'Wanneer zou je openheid geven?', '', 9, 'mcq'),
(3, 1, 'Welke informatie zou jij delen?', '', 9, 'mcq'),
(4, 2, 'Aan wie zou je openheid geven', '', 12, 'mcq'),
(5, 1, 'test', '', 12, 'mcq'),
(6, 1, 'Verwijderen?', '', 13, 'mcq');

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
(43, 1, 'B: Ik geef geen openheid om stigmatisering te vermijden', 0),
(44, 2, 'A: Tijdens een functioneringsgesprek.', 0),
(45, 2, 'B: Zodra je merkt dat je klachten krijgt', 0),
(46, 2, 'C: Ik wacht totdat ik het echt niet meer volhoud.', 0),
(47, 1, 'C: Ik weet het niet en wil meer informatie', 0),
(48, 3, 'A: Ik deel alles, inclusief de details van mijn belemmeringen', 0),
(49, 3, 'B: Ik deel alleen wat relevant is voor mijn werk', 0),
(50, 3, 'C: Ik deel helemaal niets!', 0),
(51, 4, 'A: Alleen aan mijn leidinggevende', 0),
(52, 4, 'B: Aan mijn leidingevende en enkele collegas', 0),
(53, 4, 'C: Aan niemand', 0),
(54, 5, 'A', 0),
(55, 5, 'B', 0),
(56, 5, 'C', 0),
(57, 5, 'D', 0),
(58, 6, 'A: JA', 0),
(59, 6, 'B: NEE', 0);

-- --------------------------------------------------------

--
-- Table structure for table `case_result`
--

CREATE TABLE `case_result` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `assignment_id` int NOT NULL,
  `case_id` int NOT NULL,
  `entry_id` int NOT NULL,
  `property_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `case_result`
--

INSERT INTO `case_result` (`id`, `user_id`, `assignment_id`, `case_id`, `entry_id`, `property_id`) VALUES
(17, 2, 3, 13, 6, 59),
(21, 2, 1, 9, 1, 47),
(22, 2, 1, 9, 3, 50),
(23, 2, 1, 9, 2, 46);

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
(1, 1, 'Kennismaking en werkvoorwaarden', '<h2><span style=\"color:hsl(270,75%,60%);\">Lorem Ipsum</span></h2><h4><i>\"Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...\"</i></h4><p><strong>Lorem Ipsum</strong><span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\"> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p>'),
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
(6, 'Training #3', '2025-02-25 13:27:22', NULL, '2025-02-13 14:23:31');

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
(173, 6, 1, 0, 'Opdracht 1', '<p><span style=\"color:rgb(0,0,0);\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. V</span><span style=\"color:rgb(255,255,255);\">i</span><span style=\"color:#ffff00;\">vamu</span><span style=\"color:rgb(0,0,0);\">s nulla mauris, mattis vel pulvinar sit amet, efficitur a purus. Donec sit amet accumsan diam, a euismod felis. Duis dolor orci, lobortis maximus convallis nec, venenatis at neque. Morbi a pretium risus. Morbi sed dolor eleifend, ultricies urna at, tempor risus. Maecenas sed posuere augue. Quisque mollis ac odio sed molestie. Maecenas bibendum, magna vitae fringilla elementum, arcu velit tristique mauris, bibendum lobortis sem sem ut quam.</span></p>', NULL, 'Herken de werkervaring', NULL, '2025-02-25 14:27:22'),
(174, 6, 1, 3, 'Opdracht 3', 'Opdracht 3', NULL, '', NULL, '2025-02-25 14:27:22'),
(175, 6, 1, 2, 'Opdracht 5', 'Opdracht 5', NULL, '', NULL, '2025-02-25 14:27:22'),
(176, 6, 1, 1, 'Opdracht 6', 'Opdracht 6', NULL, '', NULL, '2025-02-25 14:27:22'),
(177, 6, 1, 4, 'Sub Assignment', '<p>sadasdasdsad</p>', '<p>basdasd</p>', '', 'OutroController', '2025-02-25 14:27:22');

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
  `type` enum('mcq','text_input','text_separator','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `training_assignment_entry`
--

INSERT INTO `training_assignment_entry` (`id`, `sort_order`, `name`, `info`, `assignment_id`, `type`) VALUES
(223, 1, 'Vraag 1', '', 173, 'mcq'),
(224, 0, 'Separator', '', 173, 'text_separator'),
(225, 3, 'Separator', '', 173, 'text_separator'),
(226, 4, 'Vraag 2', '', 173, 'mcq'),
(227, 2, 'Vraag 3', '', 173, 'mcq'),
(228, 1, 'test', '', 176, 'mcq'),
(229, 1, 'Verwijderen?', '', 174, 'mcq'),
(230, 6, 'Voer tekst in', '', 173, 'text_input'),
(231, 5, 'Extra toevoegingen:', '', 173, 'text_separator'),
(232, 7, 'nieuwe vraag', '', 173, 'text_input'),
(233, 1, 'test', '', 177, 'mcq');

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
(149, 223, 'Ja', 1),
(150, 223, 'Nee', 0),
(151, 225, '<p><strong>Lorem Ipsum</strong><span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\"> is simply dummy text of the printing and typesetting industry.</span></p>', 0),
(152, 224, '<p><i>Dit is ook Tekst</i></p>', 0),
(153, 226, 'Nee', 0),
(154, 226, 'Misschien', 1),
(155, 226, 'Ja', 2),
(156, 226, 'Zeker weten', 3),
(157, 227, 'test 1', 1),
(158, 227, 'test 2', 0),
(159, 228, 'ja', 0),
(160, 228, 'nee', 0),
(161, 229, 'JA', 0),
(162, 229, 'NEE', 0),
(163, 231, '<p>Extra Toevoegingen:</p>', 0),
(164, 233, 'ja', 0),
(165, 233, 'nee', 0);

-- --------------------------------------------------------

--
-- Table structure for table `training_assignment_result`
--

CREATE TABLE `training_assignment_result` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `assignment_id` int NOT NULL,
  `entry_id` int NOT NULL,
  `property_id` int DEFAULT NULL,
  `value` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `training_assignment_result`
--

INSERT INTO `training_assignment_result` (`id`, `user_id`, `assignment_id`, `entry_id`, `property_id`, `value`) VALUES
(53, 2, 177, 233, 165, NULL);

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
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `training_cases`
--

INSERT INTO `training_cases` (`id`, `assignment_id`, `sort_order`, `name`, `intro`, `outro`, `info`, `created_at`) VALUES
(30, 173, 0, 'Casus 1: Openheid over autisme op werk', '<p><span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\">2Lorem ipsum dolor sit amet, consectetur adipiscing elit. V</span><span style=\"background-color:hsl(210,75%,60%);color:hsl(0,0%,100%);\">ivamu</span><span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\">s nulla mauris, mattis vel pulvinar sit amet, efficitur a purus. Donec sit amet accumsan diam, a euismod felis. Duis dolor orci, lobortis maximus convallis nec, venenatis at neque. Morbi a pretium risus. Morbi sed dolor eleifend, ultricies urna at, tempor risus. Maecenas sed posuere augue. Quisque mollis ac odio sed molestie. Maecenas bibendum, magna vitae fringilla elementum, arcu velit tristique mauris, bibendum lobortis sem sem ut quam.</span></p>', '<h1>\r\n    Goed Gedaan!\r\n</h1>\r\n<p>\r\n    <span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\"><strong>L3orem ipsum dolor sit amet, consectetur adipiscing elit. V</strong></span><span style=\"background-color:hsl(210,75%,60%);color:hsl(0,0%,100%);\"><strong>ivamu</strong></span><span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\"><strong>s nulla mauris, mattis vel pulvinar sit amet, efficitur a purus. Donec sit amet accumsan diam, a euismod felis. Duis dolor orci, lobortis maximus convallis nec, venenatis at neque. Morbi a pretium risus.&nbsp;</strong></span>\r\n</p>\r\n<ul>\r\n    <li>\r\n        <span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\"><strong>Morbi sed:</strong> dolor eleifend, ultricies urna at, tempor risus. Maecenas sed posuere augue. Quisque mollis ac odio sed molestie. </span>\r\n    </li>\r\n    <li>\r\n        <span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\"><strong>Maecenas bibendum:</strong> magna vitae fringilla elementum, arcu velit tristique mauris, bibendum lobortis sem sem ut quam.</span>\r\n    </li>\r\n    <li>\r\n        <span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\"><strong>Maecenas bibendum:</strong> magna vitae fringilla elementum, arcu velit tristique mauris, bibendum lobortis sem sem ut quam.</span>\r\n    </li>\r\n</ul>\r\n<p>\r\n    <span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\"><strong>Wat nu?</strong></span>\r\n</p>\r\n<ul>\r\n    <li>\r\n        <span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\"><strong>Morbi sed:</strong> dolor eleifend, ultricies urna at, tempor risus. Maecenas sed posuere augue. Quisque mollis ac odio sed molestie.</span>\r\n    </li>\r\n    <li>\r\n        <span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\"><strong>Maecenas bibendum:</strong> magna vitae fringilla elementum, arcu velit tristique mauris, bibendum lobortis sem sem ut quam.</span>\r\n    </li>\r\n    <li>\r\n        <span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\"><strong>Maecenas bibendum:</strong> magna vitae fringilla elementum, arcu velit tristique mauris, bibendum lobortis sem sem ut quam.</span>\r\n    </li>\r\n</ul>', '', '2025-02-25 14:27:22'),
(31, 173, 1, 'Casus 2', '', '', '', '2025-02-25 14:27:22'),
(32, 173, 2, 'Casus 3', '', '', '', '2025-02-25 14:27:22'),
(33, 174, 1, 'Casus', '', '', '', '2025-02-25 14:27:22');

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
  `type` enum('mcq','text_input','text_separator','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `training_case_entry`
--

INSERT INTO `training_case_entry` (`id`, `sort_order`, `name`, `info`, `case_id`, `type`) VALUES
(48, 0, 'Wat zou jij doen als je in de situatie van de hoofdpersoon zat?', '', 30, 'mcq'),
(49, 3, 'Wanneer zou je openheid geven?', '', 30, 'mcq'),
(50, 1, 'Welke informatie zou jij delen?', '', 30, 'mcq'),
(51, 2, 'Aan wie zou je openheid geven', '', 32, 'mcq'),
(52, 1, 'test', '', 32, 'mcq'),
(53, 1, 'Verwijderen?', '', 33, 'mcq');

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
(149, 48, 'A: Ik geef openheid om ondersteuning te krijgen', 0),
(150, 48, 'B: Ik geef geen openheid om stigmatisering te vermijden', 0),
(151, 49, 'A: Tijdens een functioneringsgesprek.', 0),
(152, 49, 'B: Zodra je merkt dat je klachten krijgt', 0),
(153, 49, 'C: Ik wacht totdat ik het echt niet meer volhoud.', 0),
(154, 48, 'C: Ik weet het niet en wil meer informatie', 0),
(155, 50, 'A: Ik deel alles, inclusief de details van mijn belemmeringen', 0),
(156, 50, 'B: Ik deel alleen wat relevant is voor mijn werk', 0),
(157, 50, 'C: Ik deel helemaal niets!', 0),
(158, 51, 'A: Alleen aan mijn leidinggevende', 0),
(159, 51, 'B: Aan mijn leidingevende en enkele collegas', 0),
(160, 51, 'C: Aan niemand', 0),
(161, 52, 'A', 0),
(162, 52, 'B', 0),
(163, 52, 'C', 0),
(164, 52, 'D', 0),
(165, 53, 'A: JA', 0),
(166, 53, 'B: NEE', 0);

-- --------------------------------------------------------

--
-- Table structure for table `training_case_result`
--

CREATE TABLE `training_case_result` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `assignment_id` int NOT NULL,
  `case_id` int NOT NULL,
  `entry_id` int NOT NULL,
  `property_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `training_users`
--

CREATE TABLE `training_users` (
  `id` int NOT NULL,
  `training_id` int NOT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `training_users`
--

INSERT INTO `training_users` (`id`, `training_id`, `user_id`) VALUES
(20, 6, 2),
(19, 6, 3),
(14, 6, 4),
(18, 6, 7);

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
  ADD KEY `assignment_result_entry_id_foreign` (`entry_id`),
  ADD KEY `assignment_result_property_id_foreign` (`property_id`);

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
  ADD KEY `case_result_entry_id_foreign` (`entry_id`),
  ADD KEY `case_result_property_id_foreign` (`property_id`);

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
-- Indexes for table `training_users`
--
ALTER TABLE `training_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `training_id` (`training_id`,`user_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `assignment_entry`
--
ALTER TABLE `assignment_entry`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `assignment_entry_properties`
--
ALTER TABLE `assignment_entry_properties`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `assignment_result`
--
ALTER TABLE `assignment_result`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `auth_identities`
--
ALTER TABLE `auth_identities`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `auth_logins`
--
ALTER TABLE `auth_logins`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `case_entry`
--
ALTER TABLE `case_entry`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `case_entry_properties`
--
ALTER TABLE `case_entry_properties`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `case_result`
--
ALTER TABLE `case_result`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `training_assignments`
--
ALTER TABLE `training_assignments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;

--
-- AUTO_INCREMENT for table `training_assignment_entry`
--
ALTER TABLE `training_assignment_entry`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=234;

--
-- AUTO_INCREMENT for table `training_assignment_entry_properties`
--
ALTER TABLE `training_assignment_entry_properties`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT for table `training_assignment_result`
--
ALTER TABLE `training_assignment_result`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `training_cases`
--
ALTER TABLE `training_cases`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `training_case_entry`
--
ALTER TABLE `training_case_entry`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `training_case_entry_properties`
--
ALTER TABLE `training_case_entry_properties`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167;

--
-- AUTO_INCREMENT for table `training_case_result`
--
ALTER TABLE `training_case_result`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `training_users`
--
ALTER TABLE `training_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  ADD CONSTRAINT `assignment_result_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `assignment_entry_properties` (`id`) ON DELETE CASCADE;

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
  ADD CONSTRAINT `case_result_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `case_entry_properties` (`id`) ON DELETE CASCADE;

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
  ADD CONSTRAINT `training_assignment_result_assignment_id_foreign` FOREIGN KEY (`assignment_id`) REFERENCES `training_assignments` (`id`) ON DELETE CASCADE;

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
  ADD CONSTRAINT `training_case_result_assignment_id_foreign` FOREIGN KEY (`assignment_id`) REFERENCES `training_assignments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `training_users`
--
ALTER TABLE `training_users`
  ADD CONSTRAINT `training_users_trainings_id_foreign` FOREIGN KEY (`training_id`) REFERENCES `trainings` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
