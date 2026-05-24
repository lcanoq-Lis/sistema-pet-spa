-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 21, 2026 at 04:56 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spa_mascotas`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_log`
--

CREATE TABLE `audit_log` (
  `id` bigint UNSIGNED NOT NULL,
  `usuario_id` int UNSIGNED DEFAULT NULL,
  `tabla` varchar(100) NOT NULL,
  `registro_id` int UNSIGNED NOT NULL,
  `accion` enum('INSERT','UPDATE','DELETE') NOT NULL,
  `datos_anteriores` json DEFAULT NULL,
  `datos_nuevos` json DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `ejecutado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_logs`
--

CREATE TABLE `auth_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `usuario_id` bigint UNSIGNED DEFAULT NULL,
  `rol` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `evento` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `auth_logs`
--

INSERT INTO `auth_logs` (`id`, `usuario_id`, `rol`, `evento`, `descripcion`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
(1, 3, 'cliente', 'registro', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-02 04:03:20', '2026-05-02 04:03:20'),
(2, 3, 'cliente', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-02 04:05:53', '2026-05-02 04:05:53'),
(3, 3, 'cliente', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-02 04:09:24', '2026-05-02 04:09:24'),
(4, 3, 'cliente', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-02 04:09:39', '2026-05-02 04:09:39'),
(5, 3, 'cliente', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-02 04:29:38', '2026-05-02 04:29:38'),
(6, 4, 'cliente', 'registro', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-02 04:30:50', '2026-05-02 04:30:50'),
(7, 5, 'cliente', 'registro', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-02 04:43:50', '2026-05-02 04:43:50'),
(8, 5, 'cliente', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-02 04:46:48', '2026-05-02 04:46:48'),
(9, 5, 'cliente', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-02 04:46:55', '2026-05-02 04:46:55'),
(10, 5, 'cliente', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-02 04:53:06', '2026-05-02 04:53:06'),
(11, 5, 'cliente', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-02 04:57:40', '2026-05-02 04:57:40'),
(12, 5, 'cliente', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-02 04:57:53', '2026-05-02 04:57:53'),
(13, 6, 'cliente', 'login_google', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-02 05:24:44', '2026-05-02 05:24:44'),
(14, 7, 'admin', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-03 01:08:50', '2026-05-03 01:08:50'),
(15, 7, 'admin', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-03 01:29:25', '2026-05-03 01:29:25'),
(16, 7, 'admin', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-03 01:29:43', '2026-05-03 01:29:43'),
(17, 7, 'admin', 'crear_personal', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-03 01:40:56', '2026-05-03 01:40:56'),
(18, 7, 'admin', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-03 01:47:19', '2026-05-03 01:47:19'),
(19, 7, 'admin', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-03 01:55:09', '2026-05-03 01:55:09'),
(20, 7, 'admin', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-03 02:00:44', '2026-05-03 02:00:44'),
(21, 7, 'admin', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-03 02:01:04', '2026-05-03 02:01:04'),
(22, 7, 'admin', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-03 02:01:39', '2026-05-03 02:01:39'),
(23, 7, 'admin', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-03 02:01:57', '2026-05-03 02:01:57'),
(24, 10, 'cliente', 'registro', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-03 22:06:16', '2026-05-03 22:06:16'),
(25, 10, 'cliente', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-03 22:07:00', '2026-05-03 22:07:00'),
(26, 10, 'cliente', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-03 22:32:31', '2026-05-03 22:32:31'),
(27, 7, 'admin', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-03 22:34:19', '2026-05-03 22:34:19'),
(28, 7, 'admin', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-03 22:36:16', '2026-05-03 22:36:16'),
(29, 5, 'cliente', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-03 22:36:51', '2026-05-03 22:36:51'),
(30, 5, 'cliente', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-03 22:37:05', '2026-05-03 22:37:05'),
(31, 8, 'recepcion', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-03 22:37:37', '2026-05-03 22:37:37'),
(32, 8, 'recepcion', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-03 22:40:52', '2026-05-03 22:40:52'),
(33, 7, 'admin', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-03 22:41:32', '2026-05-03 22:41:32'),
(34, 7, 'admin', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-03 22:44:47', '2026-05-03 22:44:47'),
(35, 10, 'cliente', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-03 22:45:08', '2026-05-03 22:45:08'),
(36, 10, 'cliente', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-03 22:51:45', '2026-05-03 22:51:45'),
(37, 8, 'recepcion', 'login_fallido', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-03 22:52:51', '2026-05-03 22:52:51'),
(38, 8, 'recepcion', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-03 22:53:09', '2026-05-03 22:53:09'),
(39, 8, 'recepcion', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-03 23:03:20', '2026-05-03 23:03:20'),
(40, 10, 'cliente', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-03 23:03:52', '2026-05-03 23:03:52'),
(41, 10, 'cliente', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-03 23:04:01', '2026-05-03 23:04:01'),
(42, 7, 'admin', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-03 23:04:13', '2026-05-03 23:04:13'),
(43, 7, 'admin', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-03 23:05:11', '2026-05-03 23:05:11'),
(44, 7, 'admin', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 03:10:27', '2026-05-04 03:10:27'),
(45, 7, 'admin', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 03:18:34', '2026-05-04 03:18:34'),
(46, 7, 'admin', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 03:18:47', '2026-05-04 03:18:47'),
(47, 7, 'admin', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 03:25:48', '2026-05-04 03:25:48'),
(48, 7, 'admin', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 04:36:46', '2026-05-04 04:36:46'),
(49, 7, 'admin', 'crear_personal', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 04:38:30', '2026-05-04 04:38:30'),
(50, 13, 'cliente', 'registro', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 07:08:30', '2026-05-04 07:08:30'),
(51, 13, 'cliente', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 07:09:35', '2026-05-04 07:09:35'),
(52, 13, 'cliente', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 07:10:34', '2026-05-04 07:10:34'),
(53, 13, 'cliente', 'login_fallido', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 07:10:47', '2026-05-04 07:10:47'),
(54, 13, 'cliente', 'login_fallido', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 07:10:57', '2026-05-04 07:10:57'),
(55, 13, 'cliente', 'login_fallido', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 07:11:11', '2026-05-04 07:11:11'),
(56, 13, 'cliente', 'login_fallido', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 07:11:19', '2026-05-04 07:11:19'),
(57, 13, 'cliente', 'login_fallido', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 07:11:28', '2026-05-04 07:11:28'),
(58, 6, 'cliente', 'login_google', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 07:12:49', '2026-05-04 07:12:49'),
(59, 6, 'cliente', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 07:13:12', '2026-05-04 07:13:12'),
(60, 7, 'admin', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 07:13:42', '2026-05-04 07:13:42'),
(61, 8, 'recepcion', 'login_fallido', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 07:16:28', '2026-05-04 07:16:28'),
(62, 8, 'recepcion', 'login_fallido', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 07:16:45', '2026-05-04 07:16:45'),
(63, 7, 'admin', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 07:17:20', '2026-05-04 07:17:20'),
(64, 8, 'recepcion', 'login_fallido', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 07:17:30', '2026-05-04 07:17:30'),
(65, 8, 'recepcion', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 07:17:59', '2026-05-04 07:17:59'),
(66, 8, 'recepcion', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 07:19:08', '2026-05-04 07:19:08'),
(67, 6, 'cliente', 'login_google', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-04 07:24:07', '2026-05-04 07:24:07'),
(68, 8, 'recepcion', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-07 20:46:18', '2026-05-07 20:46:18'),
(69, 6, 'cliente', 'login_google', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-15 23:40:42', '2026-05-15 23:40:42'),
(70, 10, 'cliente', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-15 23:43:32', '2026-05-15 23:43:32'),
(71, 6, 'cliente', 'login_google', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-15 23:48:13', '2026-05-15 23:48:13'),
(72, 6, 'cliente', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-16 00:24:34', '2026-05-16 00:24:34'),
(73, 6, 'cliente', 'login_google', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-16 04:14:11', '2026-05-16 04:14:11'),
(74, 6, 'cliente', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-16 04:32:32', '2026-05-16 04:32:32'),
(75, 7, 'admin', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-16 04:33:05', '2026-05-16 04:33:05'),
(76, 7, 'admin', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-16 04:47:27', '2026-05-16 04:47:27'),
(77, 7, 'admin', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-16 04:47:49', '2026-05-16 04:47:49'),
(78, 7, 'admin', 'crear_personal', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-16 04:55:40', '2026-05-16 04:55:40'),
(79, 7, 'admin', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-16 04:56:13', '2026-05-16 04:56:13'),
(80, 14, 'groomer', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-16 04:56:30', '2026-05-16 04:56:30'),
(81, 14, 'groomer', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-16 04:57:20', '2026-05-16 04:57:20'),
(82, 6, 'cliente', 'login_google', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-16 04:57:34', '2026-05-16 04:57:34'),
(83, 6, 'cliente', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-16 04:58:33', '2026-05-16 04:58:33'),
(84, 14, 'groomer', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-16 04:58:53', '2026-05-16 04:58:53'),
(85, 14, 'groomer', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-16 05:07:34', '2026-05-16 05:07:34'),
(86, 6, 'cliente', 'login_google', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-16 05:07:47', '2026-05-16 05:07:47'),
(87, 6, 'cliente', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-16 05:13:04', '2026-05-16 05:13:04'),
(88, NULL, NULL, 'recuperar_contrasena', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 01:13:24', '2026-05-17 01:13:24'),
(89, NULL, NULL, 'recuperar_contrasena', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 01:15:47', '2026-05-17 01:15:47'),
(90, NULL, NULL, 'recuperar_contrasena', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 01:20:01', '2026-05-17 01:20:01'),
(91, NULL, NULL, 'recuperar_contrasena', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 01:30:48', '2026-05-17 01:30:48'),
(92, NULL, NULL, 'reset_contrasena', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 01:31:22', '2026-05-17 01:31:22'),
(93, 8, 'recepcion', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 01:31:31', '2026-05-17 01:31:31'),
(94, 14, 'groomer', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 01:33:26', '2026-05-17 01:33:26'),
(95, 14, 'groomer', 'cambio_contrasena', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 01:36:27', '2026-05-17 01:36:27'),
(96, 6, 'cliente', 'login_google', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 01:53:12', '2026-05-17 01:53:12'),
(97, 7, 'admin', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 07:42:13', '2026-05-17 07:42:13'),
(98, 7, 'admin', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 07:43:08', '2026-05-17 07:43:08'),
(99, 7, 'admin', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 07:52:36', '2026-05-17 07:52:36'),
(100, 6, 'cliente', 'login_google', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 07:52:48', '2026-05-17 07:52:48'),
(101, 8, 'recepcion', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 20:26:47', '2026-05-17 20:26:47'),
(102, 8, 'recepcion', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 20:28:49', '2026-05-17 20:28:49'),
(103, 14, 'groomer', 'login_fallido', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 20:29:07', '2026-05-17 20:29:07'),
(104, 14, 'groomer', 'login_fallido', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 20:29:30', '2026-05-17 20:29:30'),
(105, 10, 'cliente', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 20:30:04', '2026-05-17 20:30:04'),
(106, 10, 'cliente', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 20:30:13', '2026-05-17 20:30:13'),
(107, 14, 'groomer', 'login_fallido', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 20:30:37', '2026-05-17 20:30:37'),
(108, 7, 'admin', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 20:31:02', '2026-05-17 20:31:02'),
(109, 7, 'admin', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 20:32:30', '2026-05-17 20:32:30'),
(110, NULL, NULL, 'recuperar_contrasena', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 20:32:50', '2026-05-17 20:32:50'),
(111, NULL, NULL, 'reset_contrasena', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 20:37:31', '2026-05-17 20:37:31'),
(112, 11, 'groomer', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 20:37:55', '2026-05-17 20:37:55'),
(113, 11, 'groomer', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 20:38:07', '2026-05-17 20:38:07'),
(114, 6, 'cliente', 'login_google', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 20:38:21', '2026-05-17 20:38:21'),
(115, 6, 'cliente', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 20:39:32', '2026-05-17 20:39:32'),
(116, 7, 'admin', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 20:40:03', '2026-05-17 20:40:03'),
(117, 7, 'admin', 'personal_creado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 20:51:24', '2026-05-17 20:51:24'),
(118, 7, 'admin', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 20:52:37', '2026-05-17 20:52:37'),
(119, 6, 'cliente', 'login_google', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 20:52:57', '2026-05-17 20:52:57'),
(120, 6, 'cliente', 'cita_creada', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 20:53:58', '2026-05-17 20:53:58'),
(121, 6, 'cliente', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 20:54:09', '2026-05-17 20:54:09'),
(122, 16, 'groomer', 'login_fallido', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 20:54:47', '2026-05-17 20:54:47'),
(123, 16, 'groomer', 'login_fallido', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 20:55:31', '2026-05-17 20:55:31'),
(124, 16, 'groomer', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 20:57:33', '2026-05-17 20:57:33'),
(125, 10, 'cliente', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 21:09:21', '2026-05-17 21:09:21'),
(126, 10, 'cliente', 'mascota_registrada', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 21:11:13', '2026-05-17 21:11:13'),
(127, 10, 'cliente', 'cita_creada', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 21:11:38', '2026-05-17 21:11:38'),
(128, 10, 'cliente', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 21:14:57', '2026-05-17 21:14:57'),
(129, 13, 'cliente', 'login_google', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 21:15:09', '2026-05-17 21:15:09'),
(130, 13, 'cliente', 'mascota_registrada', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 21:15:51', '2026-05-17 21:15:51'),
(131, 13, 'cliente', 'cita_creada', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 21:16:21', '2026-05-17 21:16:21'),
(132, 13, 'cliente', 'cita_creada', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 21:33:40', '2026-05-17 21:33:40'),
(133, 13, 'cliente', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 21:45:00', '2026-05-17 21:45:00'),
(134, 7, 'admin', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 21:45:19', '2026-05-17 21:45:19'),
(135, 7, 'admin', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 21:49:30', '2026-05-17 21:49:30'),
(136, 13, 'cliente', 'login_google', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-17 21:49:34', '2026-05-17 21:49:34'),
(137, 7, 'admin', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-18 01:42:52', '2026-05-18 01:42:52'),
(138, 7, 'admin', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-18 02:32:44', '2026-05-18 02:32:44'),
(139, 7, 'admin', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-18 02:51:40', '2026-05-18 02:51:40'),
(140, 11, 'groomer', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-18 02:52:05', '2026-05-18 02:52:05'),
(141, 11, 'groomer', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-18 02:53:04', '2026-05-18 02:53:04'),
(142, 16, 'groomer', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-18 02:55:17', '2026-05-18 02:55:17'),
(143, 6, 'cliente', 'login_google', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-19 01:05:55', '2026-05-19 01:05:55'),
(144, 6, 'cliente', 'mascota_registrada', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-19 01:07:05', '2026-05-19 01:07:05'),
(145, 6, 'cliente', 'cita_creada', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-19 01:07:53', '2026-05-19 01:07:53'),
(146, 6, 'cliente', 'login_google', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-19 03:12:53', '2026-05-19 03:12:53'),
(147, 6, 'cliente', 'cita_creada', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-19 03:13:39', '2026-05-19 03:13:39'),
(148, 8, 'recepcion', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-19 03:14:18', '2026-05-19 03:14:18'),
(149, 8, 'recepcion', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-19 03:23:34', '2026-05-19 03:23:34'),
(150, 7, 'admin', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-19 03:23:51', '2026-05-19 03:23:51'),
(151, 16, 'groomer', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-20 01:37:34', '2026-05-20 01:37:34'),
(152, 13, 'cliente', 'login_google', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-20 01:38:18', '2026-05-20 01:38:18'),
(153, 8, 'recepcion', 'login_google', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-20 01:38:37', '2026-05-20 01:38:37'),
(154, 13, 'cliente', 'cita_creada', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-20 01:39:26', '2026-05-20 01:39:26'),
(155, 13, 'cliente', 'cita_creada', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-20 02:08:42', '2026-05-20 02:08:42'),
(156, 13, 'cliente', 'login_google', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-20 02:39:41', '2026-05-20 02:39:41'),
(157, 13, 'cliente', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-20 02:40:05', '2026-05-20 02:40:05'),
(158, 7, 'admin', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-20 02:40:28', '2026-05-20 02:40:28'),
(159, 6, 'cliente', 'login_google', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-20 05:16:29', '2026-05-20 05:16:29'),
(160, 6, 'cliente', 'cita_creada', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-20 06:06:22', '2026-05-20 06:06:22'),
(161, 6, 'cliente', 'cita_cancelada', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-20 06:07:07', '2026-05-20 06:07:07'),
(162, 8, 'recepcion', 'login_google', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-20 06:47:56', '2026-05-20 06:47:56'),
(163, 7, 'admin', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-20 07:23:12', '2026-05-20 07:23:12'),
(164, 6, 'cliente', 'login_google', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-20 23:14:24', '2026-05-20 23:14:24'),
(165, 6, 'cliente', 'login_google', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-20 23:24:49', '2026-05-20 23:24:49'),
(166, 8, 'recepcion', 'login_google', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-20 23:33:11', '2026-05-20 23:33:11'),
(167, 6, 'cliente', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-21 00:09:31', '2026-05-21 00:09:31'),
(168, 16, 'groomer', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-21 00:10:08', '2026-05-21 00:10:08'),
(169, 16, 'groomer', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-21 01:03:26', '2026-05-21 01:03:26'),
(170, 6, 'cliente', 'login_google', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-21 05:35:47', '2026-05-21 05:35:47'),
(171, 6, 'cliente', 'cita_creada', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-21 05:37:14', '2026-05-21 05:37:14'),
(172, 6, 'cliente', 'cita_creada', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-21 05:40:11', '2026-05-21 05:40:11'),
(173, 6, 'cliente', 'cita_creada', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-21 05:40:44', '2026-05-21 05:40:44'),
(174, 8, 'recepcion', 'login_google', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-21 09:07:36', '2026-05-21 09:07:36'),
(175, 6, 'cliente', 'login_google', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-21 09:10:49', '2026-05-21 09:10:49'),
(176, 6, 'cliente', 'mascota_registrada', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-21 09:12:42', '2026-05-21 09:12:42'),
(177, 6, 'cliente', 'cita_creada', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-21 09:14:24', '2026-05-21 09:14:24'),
(178, 6, 'cliente', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-21 09:18:01', '2026-05-21 09:18:01'),
(179, 16, 'groomer', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-21 09:18:30', '2026-05-21 09:18:30'),
(180, 16, 'groomer', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-21 19:31:05', '2026-05-21 19:31:05'),
(181, 8, 'recepcion', 'login_google', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-21 19:41:03', '2026-05-21 19:41:03'),
(182, 8, 'recepcion', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-21 20:03:44', '2026-05-21 20:03:44'),
(183, 7, 'admin', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-21 20:04:04', '2026-05-21 20:04:04'),
(184, 7, 'admin', 'personal_desactivado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-21 20:10:56', '2026-05-21 20:10:56'),
(185, 7, 'admin', 'logout', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-21 20:11:02', '2026-05-21 20:11:02'),
(186, 16, 'groomer', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-21 20:46:28', '2026-05-21 20:46:28'),
(187, 8, 'recepcion', 'login_google', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-21 20:47:04', '2026-05-21 20:47:04'),
(188, 7, 'admin', 'login_fallido', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-21 20:48:15', '2026-05-21 20:48:15'),
(189, 7, 'admin', 'login', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-21 20:48:32', '2026-05-21 20:48:32');

-- --------------------------------------------------------

--
-- Table structure for table `bloqueos_agenda`
--

CREATE TABLE `bloqueos_agenda` (
  `id` bigint UNSIGNED NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `tipo` enum('feriado','mantenimiento','ausencia','otro') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'otro',
  `motivo` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `groomer_id` bigint UNSIGNED DEFAULT NULL,
  `creado_por` bigint UNSIGNED DEFAULT NULL,
  `creado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bloqueos_agenda`
--

INSERT INTO `bloqueos_agenda` (`id`, `fecha_inicio`, `fecha_fin`, `tipo`, `motivo`, `groomer_id`, `creado_por`, `creado_en`) VALUES
(1, '2026-05-23', '2026-05-23', 'mantenimiento', 'limpieza y mantenimiento del sistema', NULL, 7, '2026-05-19 22:58:00');

-- --------------------------------------------------------

--
-- Table structure for table `bloqueos_calendario`
--

CREATE TABLE `bloqueos_calendario` (
  `id` int UNSIGNED NOT NULL,
  `groomer_id` int UNSIGNED DEFAULT NULL,
  `tipo` enum('feriado','vacaciones','mantenimiento','ausencia') NOT NULL,
  `titulo` varchar(150) DEFAULT NULL,
  `fecha_inicio` datetime NOT NULL,
  `fecha_fin` datetime NOT NULL,
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ;

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
-- Table structure for table `carritos`
--

CREATE TABLE `carritos` (
  `id` int UNSIGNED NOT NULL,
  `cliente_id` int UNSIGNED DEFAULT NULL,
  `session_token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categorias_productos`
--

CREATE TABLE `categorias_productos` (
  `id` int UNSIGNED NOT NULL,
  `padre_id` int UNSIGNED DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categorias_productos`
--

INSERT INTO `categorias_productos` (`id`, `padre_id`, `nombre`, `descripcion`, `activo`) VALUES
(1, NULL, 'Alimentos', 'Comida para mascotas', 1),
(2, NULL, 'Shampoos', 'Productos de baño', 1),
(3, NULL, 'Juguetes', 'Juguetes para mascotas', 1),
(4, NULL, 'Accesorios', 'Collares y correas', 1);

-- --------------------------------------------------------

--
-- Table structure for table `checklist_items_catalogo`
--

CREATE TABLE `checklist_items_catalogo` (
  `id` int UNSIGNED NOT NULL,
  `servicio_id` int UNSIGNED DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `requiere_observacion` tinyint(1) NOT NULL DEFAULT '0',
  `orden` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `activo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `checklist_items_catalogo`
--

INSERT INTO `checklist_items_catalogo` (`id`, `servicio_id`, `nombre`, `descripcion`, `requiere_observacion`, `orden`, `activo`) VALUES
(1, NULL, 'Baño', NULL, 0, 1, 1),
(2, NULL, 'Corte', NULL, 0, 2, 1),
(3, NULL, 'Uñas', NULL, 1, 3, 1),
(4, NULL, 'Limpieza de oídos', NULL, 1, 4, 1),
(5, NULL, 'Glándulas', NULL, 1, 5, 1),
(6, NULL, 'Perfume / secado', NULL, 0, 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `citas`
--

CREATE TABLE `citas` (
  `id` int UNSIGNED NOT NULL,
  `mascota_id` int UNSIGNED NOT NULL,
  `groomer_id` int UNSIGNED NOT NULL,
  `servicio_id` int UNSIGNED NOT NULL,
  `sucursal_id` int UNSIGNED DEFAULT NULL,
  `creado_por_usuario_id` bigint UNSIGNED DEFAULT NULL,
  `estado` enum('en_revision','agendada','confirmada','en_progreso','completada','cancelada','no_asistio') NOT NULL DEFAULT 'en_revision',
  `fecha_hora_inicio` datetime NOT NULL,
  `fecha_hora_fin_estimada` datetime NOT NULL,
  `duracion_real_minutos` smallint UNSIGNED DEFAULT NULL,
  `precio_acordado` decimal(10,2) NOT NULL,
  `notas_cliente` text,
  `motivo_cancelacion` text,
  `reprogramada_desde_id` int UNSIGNED DEFAULT NULL,
  `reprogramada_por_id` bigint UNSIGNED DEFAULT NULL,
  `reprogramada_en` datetime DEFAULT NULL,
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ;

--
-- Dumping data for table `citas`
--

INSERT INTO `citas` (`id`, `mascota_id`, `groomer_id`, `servicio_id`, `sucursal_id`, `creado_por_usuario_id`, `estado`, `fecha_hora_inicio`, `fecha_hora_fin_estimada`, `duracion_real_minutos`, `precio_acordado`, `notas_cliente`, `motivo_cancelacion`, `reprogramada_desde_id`, `reprogramada_por_id`, `reprogramada_en`, `creado_en`, `actualizado_en`) VALUES
(2, 3, 2, 2, NULL, 6, 'confirmada', '2026-05-16 14:00:00', '2026-05-16 15:30:00', NULL, 80.00, 'sea cuidadoso', NULL, NULL, NULL, NULL, '2026-05-16 00:21:11', '2026-05-16 21:43:02'),
(3, 3, 3, 1, NULL, 6, 'confirmada', '2026-05-18 14:00:00', '2026-05-18 14:30:00', NULL, 50.00, 't43t43', NULL, NULL, NULL, NULL, '2026-05-16 00:58:19', '2026-05-17 16:27:29'),
(4, 3, 3, 3, NULL, 6, 'completada', '2026-05-16 09:00:00', '2026-05-16 10:30:00', NULL, 100.00, 'gyug', NULL, NULL, NULL, NULL, '2026-05-16 01:12:55', '2026-05-16 21:49:02'),
(5, 3, 3, 8, NULL, 6, 'en_progreso', '2026-07-16 17:30:00', '2026-07-16 19:30:00', NULL, 150.00, 'ninguno', NULL, NULL, NULL, NULL, '2026-05-16 21:54:01', '2026-05-18 23:18:28'),
(6, 3, 3, 8, NULL, 6, 'completada', '2026-05-16 17:30:00', '2026-05-16 19:30:00', NULL, 150.00, 'wqeqw', NULL, NULL, NULL, NULL, '2026-05-16 21:55:06', '2026-05-16 22:04:27'),
(7, 3, 4, 8, NULL, 6, 'completada', '2026-05-17 13:00:00', '2026-05-17 15:00:00', NULL, 150.00, 'ninguna', NULL, NULL, NULL, NULL, '2026-05-17 16:53:58', '2026-05-17 16:59:00'),
(8, 4, 4, 1, NULL, 10, 'en_progreso', '2026-05-17 15:00:00', '2026-05-17 15:35:00', NULL, 50.00, NULL, NULL, NULL, NULL, NULL, '2026-05-17 17:11:38', '2026-05-17 22:55:51'),
(9, 5, 4, 5, NULL, 13, 'completada', '2026-05-17 14:30:00', '2026-05-17 15:00:00', NULL, 50.00, NULL, NULL, NULL, NULL, NULL, '2026-05-17 17:16:21', '2026-05-17 17:17:37'),
(10, 5, 4, 1, NULL, 13, 'cancelada', '2026-05-17 16:00:00', '2026-05-17 16:30:00', NULL, 50.00, NULL, 'no se puede', NULL, NULL, NULL, '2026-05-17 17:33:40', '2026-05-21 16:03:25'),
(11, 6, 2, 1, NULL, 6, 'confirmada', '2026-05-18 14:00:00', '2026-05-18 14:35:00', NULL, 50.00, NULL, NULL, NULL, NULL, NULL, '2026-05-18 21:07:52', '2026-05-18 23:19:37'),
(12, 6, 4, 1, NULL, 6, 'confirmada', '2026-05-22 09:30:00', '2026-05-22 10:05:00', NULL, 50.00, NULL, NULL, 12, 8, '2026-05-21 16:02:48', '2026-05-18 23:13:34', '2026-05-21 16:02:48'),
(13, 5, 4, 1, NULL, 13, 'completada', '2026-05-19 17:30:00', '2026-05-19 18:00:00', NULL, 50.00, NULL, NULL, NULL, NULL, NULL, '2026-05-19 21:39:20', '2026-05-19 22:01:14'),
(14, 5, 4, 1, NULL, 13, 'completada', '2026-05-20 17:30:00', '2026-05-20 18:00:00', NULL, 50.00, NULL, NULL, NULL, NULL, NULL, '2026-05-19 22:08:36', '2026-05-20 21:03:56'),
(15, 6, 4, 2, NULL, 6, 'cancelada', '2026-05-21 11:30:00', '2026-05-21 12:39:00', NULL, 80.00, NULL, 'Emergencia familiar', NULL, NULL, NULL, '2026-05-20 02:06:08', '2026-05-20 02:07:07'),
(16, 6, 4, 1, NULL, 6, 'completada', '2026-05-21 09:30:00', '2026-05-21 10:05:00', NULL, 50.00, NULL, NULL, NULL, NULL, NULL, '2026-05-21 01:37:03', '2026-05-21 05:22:04'),
(18, 3, 4, 1, NULL, 6, 'confirmada', '2026-05-21 12:30:00', '2026-05-21 13:00:00', NULL, 50.00, NULL, NULL, NULL, NULL, NULL, '2026-05-21 01:40:05', '2026-05-21 05:08:40'),
(19, 6, 4, 3, NULL, 6, 'confirmada', '2026-05-21 16:30:00', '2026-05-21 18:14:00', NULL, 100.00, NULL, NULL, NULL, NULL, NULL, '2026-05-21 01:40:38', '2026-05-21 05:08:27'),
(20, 7, 4, 2, NULL, 6, 'cancelada', '2026-05-21 11:00:00', '2026-05-21 12:12:00', NULL, 80.00, NULL, 'no tenemos disponible ese horario', NULL, NULL, NULL, '2026-05-21 05:14:18', '2026-05-21 05:16:25');

-- --------------------------------------------------------

--
-- Table structure for table `clientes`
--

CREATE TABLE `clientes` (
  `id` int UNSIGNED NOT NULL,
  `usuario_id` bigint UNSIGNED DEFAULT NULL,
  `sucursal_id` int UNSIGNED DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `canal_notificacion` enum('email','whatsapp','sms','telegram') DEFAULT 'whatsapp',
  `horario_preferido` varchar(100) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `clientes`
--

INSERT INTO `clientes` (`id`, `usuario_id`, `sucursal_id`, `nombre`, `apellido`, `telefono`, `canal_notificacion`, `horario_preferido`, `direccion`, `creado_en`, `actualizado_en`) VALUES
(2, 3, NULL, 'lisel', NULL, '748329748', 'whatsapp', NULL, NULL, '2026-05-02 00:03:14', '2026-05-02 00:03:14'),
(3, 4, NULL, 'anahi', NULL, '67868767', 'whatsapp', NULL, NULL, '2026-05-02 00:30:44', '2026-05-02 00:30:44'),
(4, 5, NULL, 'Nicole', NULL, '63081630', 'whatsapp', NULL, NULL, '2026-05-02 00:43:45', '2026-05-02 00:43:45'),
(5, 6, NULL, 'LISBETH NICOLE CANO QUISPE', NULL, NULL, 'whatsapp', NULL, NULL, '2026-05-02 01:24:44', '2026-05-02 01:24:44'),
(6, 10, NULL, 'mario', NULL, NULL, 'whatsapp', NULL, NULL, '2026-05-03 18:06:07', '2026-05-03 18:06:07'),
(7, 13, NULL, 'lisbeth nicole', NULL, NULL, 'whatsapp', NULL, NULL, '2026-05-04 03:08:26', '2026-05-04 03:08:26');

-- --------------------------------------------------------

--
-- Table structure for table `consumo_insumos_ficha`
--

CREATE TABLE `consumo_insumos_ficha` (
  `id` int UNSIGNED NOT NULL,
  `ficha_id` int UNSIGNED NOT NULL,
  `producto_id` int UNSIGNED NOT NULL,
  `variante_id` int UNSIGNED DEFAULT NULL,
  `cantidad` decimal(8,3) NOT NULL,
  `registrado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ;

-- --------------------------------------------------------

--
-- Table structure for table `detalle_carrito`
--

CREATE TABLE `detalle_carrito` (
  `id` int UNSIGNED NOT NULL,
  `carrito_id` int UNSIGNED NOT NULL,
  `producto_id` int UNSIGNED NOT NULL,
  `variante_id` int UNSIGNED DEFAULT NULL,
  `cantidad` smallint UNSIGNED NOT NULL DEFAULT '1',
  `precio_unitario` decimal(10,2) NOT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `detalle_factura`
--

CREATE TABLE `detalle_factura` (
  `id` int UNSIGNED NOT NULL,
  `factura_id` int UNSIGNED NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `cantidad` smallint UNSIGNED NOT NULL DEFAULT '1',
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `detalle_pedido`
--

CREATE TABLE `detalle_pedido` (
  `id` int UNSIGNED NOT NULL,
  `pedido_id` int UNSIGNED NOT NULL,
  `producto_id` int UNSIGNED NOT NULL,
  `variante_id` int UNSIGNED DEFAULT NULL,
  `cantidad` smallint UNSIGNED NOT NULL DEFAULT '1',
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `disponibilidad_groomer`
--

CREATE TABLE `disponibilidad_groomer` (
  `id` int UNSIGNED NOT NULL,
  `groomer_id` int UNSIGNED NOT NULL,
  `dia_semana` tinyint UNSIGNED NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `intervalo_descanso` json DEFAULT NULL,
  `buffer_minutos` tinyint UNSIGNED NOT NULL DEFAULT '15'
) ;

-- --------------------------------------------------------

--
-- Table structure for table `encuestas_satisfaccion`
--

CREATE TABLE `encuestas_satisfaccion` (
  `id` int UNSIGNED NOT NULL,
  `cita_id` int UNSIGNED NOT NULL,
  `cliente_id` int UNSIGNED DEFAULT NULL,
  `calificacion` tinyint UNSIGNED NOT NULL,
  `comentario` text,
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ;

-- --------------------------------------------------------

--
-- Table structure for table `facturas`
--

CREATE TABLE `facturas` (
  `id` int UNSIGNED NOT NULL,
  `numero_factura` varchar(50) NOT NULL,
  `cliente_id` int UNSIGNED DEFAULT NULL,
  `cita_id` int UNSIGNED DEFAULT NULL,
  `pedido_id` int UNSIGNED DEFAULT NULL,
  `sucursal_id` int UNSIGNED DEFAULT NULL,
  `subtotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `impuesto` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `estado` enum('pendiente','pagada','cancelada') NOT NULL DEFAULT 'pendiente',
  `metodo_pago` enum('efectivo','qr','transferencia') NOT NULL DEFAULT 'efectivo',
  `fecha_emision` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
-- Table structure for table `fichas_checklist`
--

CREATE TABLE `fichas_checklist` (
  `id` int UNSIGNED NOT NULL,
  `ficha_id` int UNSIGNED NOT NULL,
  `item_id` int UNSIGNED NOT NULL,
  `completado` tinyint(1) NOT NULL DEFAULT '0',
  `observacion` text,
  `completado_en` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `fichas_checklist`
--

INSERT INTO `fichas_checklist` (`id`, `ficha_id`, `item_id`, `completado`, `observacion`, `completado_en`) VALUES
(1, 3, 1, 1, NULL, '2026-05-16 22:04:20'),
(2, 3, 2, 1, NULL, '2026-05-16 22:04:20'),
(3, 3, 3, 1, NULL, '2026-05-16 22:04:20'),
(4, 3, 4, 1, NULL, '2026-05-16 22:04:20'),
(5, 3, 5, 1, NULL, '2026-05-16 22:04:20'),
(6, 3, 6, 1, NULL, '2026-05-16 22:04:20'),
(7, 4, 1, 1, NULL, '2026-05-17 16:58:53'),
(8, 4, 2, 1, NULL, '2026-05-17 16:58:53'),
(9, 4, 3, 1, NULL, '2026-05-17 16:58:53'),
(10, 4, 4, 1, NULL, '2026-05-17 16:58:53'),
(11, 4, 5, 1, NULL, '2026-05-17 16:58:53'),
(12, 4, 6, 1, NULL, '2026-05-17 16:58:53'),
(13, 5, 1, 1, NULL, '2026-05-17 17:17:33'),
(14, 5, 2, 1, NULL, '2026-05-17 17:17:33'),
(15, 5, 3, 1, NULL, '2026-05-17 17:17:33'),
(16, 5, 4, 1, NULL, '2026-05-17 17:17:33'),
(17, 5, 5, 1, NULL, '2026-05-17 17:17:33'),
(18, 5, 6, 1, NULL, '2026-05-17 17:17:33'),
(19, 6, 1, 0, NULL, NULL),
(20, 6, 2, 0, NULL, NULL),
(21, 6, 3, 0, NULL, NULL),
(22, 6, 4, 0, NULL, NULL),
(23, 6, 5, 0, NULL, NULL),
(24, 6, 6, 0, NULL, NULL),
(25, 7, 1, 1, NULL, '2026-05-19 22:01:03'),
(26, 7, 2, 1, NULL, '2026-05-19 22:01:03'),
(27, 7, 3, 1, NULL, '2026-05-19 22:01:03'),
(28, 7, 4, 1, NULL, '2026-05-19 22:01:03'),
(29, 7, 5, 1, NULL, '2026-05-19 22:01:03'),
(30, 7, 6, 1, NULL, '2026-05-19 22:01:03'),
(31, 8, 1, 1, NULL, NULL),
(32, 8, 2, 1, NULL, NULL),
(33, 8, 3, 1, NULL, NULL),
(34, 8, 4, 1, NULL, NULL),
(35, 8, 5, 1, NULL, NULL),
(36, 8, 6, 1, NULL, NULL),
(37, 9, 1, 0, NULL, NULL),
(38, 9, 2, 0, NULL, NULL),
(39, 9, 3, 0, NULL, NULL),
(40, 9, 4, 0, NULL, NULL),
(41, 9, 5, 0, NULL, NULL),
(42, 9, 6, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fichas_grooming`
--

CREATE TABLE `fichas_grooming` (
  `id` int UNSIGNED NOT NULL,
  `cita_id` int UNSIGNED NOT NULL,
  `raza_momento` varchar(100) DEFAULT NULL,
  `tamano_momento` enum('xs','s','m','l','xl') DEFAULT NULL,
  `temperatura_ingreso` decimal(4,1) DEFAULT NULL,
  `estado_inicial` text,
  `estado_final` text,
  `notas_internas` text,
  `consumido_inventario` tinyint(1) NOT NULL DEFAULT '0',
  `fecha_cierre` datetime DEFAULT NULL,
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `fichas_grooming`
--

INSERT INTO `fichas_grooming` (`id`, `cita_id`, `raza_momento`, `tamano_momento`, `temperatura_ingreso`, `estado_inicial`, `estado_final`, `notas_internas`, `consumido_inventario`, `fecha_cierre`, `creado_en`, `actualizado_en`) VALUES
(1, 4, 'ninguna', 'xs', 38.5, 'Mascota tranquila, pelo con algunos nudos', 'Mascota limpia, pelo sin nudos, perfumada', NULL, 0, '2026-05-16 21:49:02', '2026-05-16 21:44:55', '2026-05-16 21:49:02'),
(3, 6, 'ninguna', 'xs', 38.5, 'etwetewt', 'muy cambiado', NULL, 0, '2026-05-16 22:04:27', '2026-05-16 21:57:45', '2026-05-16 22:04:27'),
(4, 7, 'ninguna', 'xs', 36.0, 'un poco descuidada con algunos nudos', 'irreconocible a mascosta', NULL, 0, '2026-05-17 16:59:00', '2026-05-17 16:58:28', '2026-05-17 16:59:00'),
(5, 9, 'persa', 's', 36.0, 'descuidado', 'bueno', NULL, 0, '2026-05-17 17:17:37', '2026-05-17 17:16:48', '2026-05-17 17:17:37'),
(6, 8, 'persa', 'm', 36.0, '5435', NULL, '435345', 0, NULL, '2026-05-17 22:55:51', '2026-05-17 22:55:51'),
(7, 13, 'persa', 's', 36.0, 'wqdqwd', 'bueno', 'wdqd', 0, '2026-05-19 22:01:14', '2026-05-19 21:40:26', '2026-05-19 22:01:14'),
(8, 14, 'persa', 's', 36.0, 'eqwe', NULL, 'weqweqw', 0, '2026-05-20 21:03:56', '2026-05-20 20:11:25', '2026-05-20 21:03:56'),
(9, 16, NULL, NULL, NULL, 'descuido completo', NULL, NULL, 0, '2026-05-21 05:22:04', '2026-05-21 05:19:26', '2026-05-21 05:22:04');

-- --------------------------------------------------------

--
-- Table structure for table `fotos_grooming`
--

CREATE TABLE `fotos_grooming` (
  `id` int UNSIGNED NOT NULL,
  `ficha_id` int UNSIGNED NOT NULL,
  `tipo` enum('antes','despues') NOT NULL,
  `url` varchar(500) NOT NULL,
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `fotos_grooming`
--

INSERT INTO `fotos_grooming` (`id`, `ficha_id`, `tipo`, `url`, `creado_en`) VALUES
(4, 7, 'despues', 'fotos-grooming/vE5lm1j12iPLRa3O674qjQ8EOljasEKVPPsd4QpV.png', '2026-05-19 22:00:21'),
(5, 7, 'antes', 'fotos-grooming/nL80Q6JOfppAcl1GaulS6rzNvqw9C7Ru51iAIQhA.png', '2026-05-19 22:00:36'),
(6, 8, 'despues', 'fotos-grooming/GIbyTAJtpkBSwTzFZcgPG0kpZ23jawlsYwat3V7U.png', '2026-05-20 20:13:14'),
(7, 8, 'antes', 'fotos-grooming/fTRG5m2PlRaMA5x2InPoTmTn95CdUNrL1l8Sldp2.png', '2026-05-20 20:13:31'),
(8, 9, 'despues', 'fichas/2K5Z1BaorQOxPQzsvNbBOKRiHPnWChWxjcQQvO79.png', '2026-05-21 05:20:33'),
(9, 9, 'antes', 'fichas/UKgpx6sKA5hPEPvcEykqSZFEZXNzBk95NkvfRw2d.png', '2026-05-21 05:20:45');

-- --------------------------------------------------------

--
-- Table structure for table `groomers`
--

CREATE TABLE `groomers` (
  `id` int UNSIGNED NOT NULL,
  `usuario_id` bigint UNSIGNED DEFAULT NULL,
  `sucursal_id` int UNSIGNED DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `especialidad` varchar(150) DEFAULT NULL,
  `capacidad_simultanea` tinyint UNSIGNED NOT NULL DEFAULT '1',
  `horario_trabajo` json DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `groomers`
--

INSERT INTO `groomers` (`id`, `usuario_id`, `sucursal_id`, `nombre`, `apellido`, `telefono`, `especialidad`, `capacidad_simultanea`, `horario_trabajo`, `activo`, `creado_en`, `actualizado_en`) VALUES
(2, 12, NULL, 'eduardo', NULL, NULL, NULL, 1, NULL, 1, '2026-05-04 00:38:22', '2026-05-04 00:38:22'),
(3, 14, NULL, 'omar', NULL, '+59167868767', 'en todo', 1, NULL, 1, '2026-05-16 00:55:32', '2026-05-16 00:55:32'),
(4, 16, NULL, 'Juan Daniel Cruz', NULL, '67331887', 'corte fino', 1, NULL, 1, '2026-05-17 16:51:20', '2026-05-17 16:51:20');

-- --------------------------------------------------------

--
-- Table structure for table `historial_mascotas`
--

CREATE TABLE `historial_mascotas` (
  `id` int UNSIGNED NOT NULL,
  `mascota_id` int UNSIGNED NOT NULL,
  `tipo_evento` enum('servicio','recomendacion','alerta','cancelacion','otro') NOT NULL,
  `descripcion` text NOT NULL,
  `referencia_id` int UNSIGNED DEFAULT NULL,
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `horarios_spa`
--

CREATE TABLE `horarios_spa` (
  `id` bigint UNSIGNED NOT NULL,
  `dia_semana` tinyint UNSIGNED NOT NULL COMMENT '0=Dom, 1=Lun, 2=Mar, 3=Mie, 4=Jue, 5=Vie, 6=Sab',
  `hora_apertura` time NOT NULL DEFAULT '09:00:00',
  `hora_cierre` time NOT NULL DEFAULT '18:00:00',
  `activo` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'false = día cerrado',
  `creado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `horarios_spa`
--

INSERT INTO `horarios_spa` (`id`, `dia_semana`, `hora_apertura`, `hora_cierre`, `activo`, `creado_en`, `actualizado_en`) VALUES
(1, 0, '09:00:00', '18:00:00', 0, '2026-05-19 22:34:40', '2026-05-19 22:34:40'),
(2, 1, '09:00:00', '18:00:00', 1, '2026-05-19 22:34:40', '2026-05-19 22:34:40'),
(3, 2, '09:00:00', '18:00:00', 1, '2026-05-19 22:34:40', '2026-05-19 22:34:40'),
(4, 3, '09:00:00', '18:00:00', 1, '2026-05-19 22:34:40', '2026-05-19 22:34:40'),
(5, 4, '09:00:00', '18:00:00', 1, '2026-05-19 22:34:40', '2026-05-19 22:34:40'),
(6, 5, '09:00:00', '18:00:00', 1, '2026-05-19 22:34:40', '2026-05-19 22:34:40'),
(7, 6, '09:00:00', '14:00:00', 1, '2026-05-19 22:34:40', '2026-05-19 22:34:40');

-- --------------------------------------------------------

--
-- Table structure for table `insumos_grooming`
--

CREATE TABLE `insumos_grooming` (
  `id` bigint UNSIGNED NOT NULL,
  `ficha_id` bigint UNSIGNED NOT NULL,
  `producto_id` bigint UNSIGNED NOT NULL,
  `cantidad` decimal(8,2) NOT NULL DEFAULT '1.00',
  `unidad` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unidad' COMMENT 'unidad, ml, g, etc',
  `observacion` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `insumos_grooming`
--

INSERT INTO `insumos_grooming` (`id`, `ficha_id`, `producto_id`, `cantidad`, `unidad`, `observacion`, `creado_en`) VALUES
(1, 8, 1, 1.00, 'unidad', NULL, '2026-05-20 20:11:52'),
(2, 9, 2, 1.00, 'unidad', NULL, '2026-05-21 05:20:03');

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
-- Table structure for table `log_notificaciones`
--

CREATE TABLE `log_notificaciones` (
  `id` int UNSIGNED NOT NULL,
  `notificacion_id` int UNSIGNED NOT NULL,
  `intento` tinyint UNSIGNED NOT NULL DEFAULT '1',
  `exitoso` tinyint(1) NOT NULL DEFAULT '0',
  `respuesta` text,
  `ejecutado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mascotas`
--

CREATE TABLE `mascotas` (
  `id` int UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `especie` varchar(50) NOT NULL,
  `raza` varchar(100) DEFAULT NULL,
  `tamano` enum('xs','s','m','l','xl') NOT NULL DEFAULT 'm',
  `peso_kg` decimal(5,2) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `temperamento` varchar(100) DEFAULT NULL,
  `alergias` text,
  `restricciones_medicas` text,
  `foto_url` varchar(500) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `mascotas`
--

INSERT INTO `mascotas` (`id`, `nombre`, `especie`, `raza`, `tamano`, `peso_kg`, `fecha_nacimiento`, `temperamento`, `alergias`, `restricciones_medicas`, `foto_url`, `activo`, `creado_en`, `actualizado_en`) VALUES
(1, 'max', 'perro', 'beethoben', 'xl', 54.70, '2011-12-01', NULL, 'tiene', 'tampoco', NULL, 0, '2026-05-15 19:49:08', '2026-05-15 19:53:24'),
(2, 'max', 'perro', 'beethoben', 'xl', 54.60, '2025-12-01', 'jugueton', 'nada', 'ninguno', NULL, 0, '2026-05-15 19:55:41', '2026-05-15 19:59:27'),
(3, 'max', 'hamster', 'ninguna', 'xs', 0.20, '2025-01-01', 'hiperactivo y nervioso', 'ninguna', 'nada', NULL, 1, '2026-05-15 20:11:33', '2026-05-15 20:11:33'),
(4, 'bruno', 'gato', 'persa', 'm', 5.00, '2021-02-18', 'jugueton', 'al shammpo con aromas', NULL, NULL, 1, '2026-05-17 17:11:13', '2026-05-17 17:11:13'),
(5, 'chesnut', 'gato', 'persa', 's', 5.00, '2024-06-17', 'agresivo', 'al polen', NULL, NULL, 1, '2026-05-17 17:15:51', '2026-05-17 17:15:51'),
(6, 'manchas', 'gato', 'mestizo', 'm', 6.00, '2024-01-01', 'jugueton', NULL, NULL, NULL, 1, '2026-05-18 21:07:05', '2026-05-18 21:07:05'),
(7, 'bruno', 'perro', 'Golden retriver', 'xs', 50.00, '2017-06-21', 'nervioso', 'ninguna', 'ninguna', NULL, 1, '2026-05-21 05:12:42', '2026-05-21 05:12:42');

-- --------------------------------------------------------

--
-- Table structure for table `mascota_dueno`
--

CREATE TABLE `mascota_dueno` (
  `mascota_id` int UNSIGNED NOT NULL,
  `cliente_id` int UNSIGNED NOT NULL,
  `es_primario` tinyint(1) NOT NULL DEFAULT '0',
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `mascota_dueno`
--

INSERT INTO `mascota_dueno` (`mascota_id`, `cliente_id`, `es_primario`, `creado_en`) VALUES
(1, 5, 1, '2026-05-15 15:49:08'),
(2, 5, 1, '2026-05-15 15:55:41'),
(3, 5, 1, '2026-05-15 16:11:33'),
(4, 6, 1, '2026-05-17 13:11:13'),
(5, 7, 1, '2026-05-17 13:15:51'),
(6, 5, 1, '2026-05-18 17:07:05'),
(7, 5, 1, '2026-05-21 01:12:42');

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
(4, '2026_05_01_224445_crear_tabla_roles', 2),
(5, '2026_05_01_224457_modificar_tabla_users', 3),
(6, '2026_05_01_224505_crear_tabla_auth_logs', 3),
(7, '2026_05_01_224512_crear_tabla_clientes', 4),
(8, '2026_05_01_224519_crear_tabla_groomers', 4),
(9, '2026_05_19_000001_crear_tabla_horarios_spa', 5),
(10, '2026_05_19_000002_crear_tabla_bloqueos_agenda', 6),
(11, '2026_05_19_000003_crear_tabla_pagos', 7),
(12, '2026_05_20_000001_crear_tabla_insumos_grooming', 8);

-- --------------------------------------------------------

--
-- Table structure for table `notificaciones`
--

CREATE TABLE `notificaciones` (
  `id` int UNSIGNED NOT NULL,
  `cliente_id` int UNSIGNED DEFAULT NULL,
  `cita_id` int UNSIGNED DEFAULT NULL,
  `tipo_evento` enum('confirmacion','recordatorio_24h','recordatorio_2h','listo_recoger','encuesta','promocion') NOT NULL,
  `canal` enum('email','whatsapp','sms','telegram') NOT NULL,
  `destino` varchar(150) NOT NULL,
  `contenido` text,
  `fecha_programacion` datetime NOT NULL,
  `fecha_envio` datetime DEFAULT NULL,
  `estado` enum('pendiente','enviado','fallido') NOT NULL DEFAULT 'pendiente',
  `intentos` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `notificaciones`
--

INSERT INTO `notificaciones` (`id`, `cliente_id`, `cita_id`, `tipo_evento`, `canal`, `destino`, `contenido`, `fecha_programacion`, `fecha_envio`, `estado`, `intentos`, `creado_en`) VALUES
(1, 5, 3, 'confirmacion', 'email', 'lcanoq@fcpn.edu.bo', 'Tu cita para max el 18/05/2026 14:00 ha sido confirmada.', '2026-05-17 16:27:29', '2026-05-17 16:27:38', 'enviado', 0, '2026-05-17 16:27:29'),
(2, 7, 9, 'listo_recoger', 'email', 'lisbethnicolecanoquispe@gmail.com', 'chesnut ya está listo para ser recogido.', '2026-05-17 17:17:37', '2026-05-17 17:17:42', 'enviado', 0, '2026-05-17 17:17:37'),
(3, 6, 8, 'confirmacion', 'email', 'ceneg94470@iapapi.com', 'Tu cita para bruno el 17/05/2026 15:00 ha sido confirmada.', '2026-05-17 17:26:44', '2026-05-17 17:26:49', 'enviado', 0, '2026-05-17 17:26:44'),
(4, 6, 8, 'confirmacion', 'email', 'ceneg94470@iapapi.com', 'Tu cita para bruno el 17/05/2026 15:00 ha sido confirmada.', '2026-05-17 17:26:49', '2026-05-17 17:26:53', 'enviado', 0, '2026-05-17 17:26:49'),
(5, 5, 5, 'confirmacion', 'email', 'lcanoq@fcpn.edu.bo', 'Tu cita para max el 16/07/2026 17:30 ha sido confirmada.', '2026-05-18 23:14:59', '2026-05-18 23:15:04', 'enviado', 0, '2026-05-18 23:14:59'),
(6, 5, 12, 'confirmacion', 'email', 'lcanoq@fcpn.edu.bo', 'Tu cita para manchas el 18/05/2026 17:30 ha sido confirmada.', '2026-05-18 23:18:35', '2026-05-18 23:18:38', 'enviado', 0, '2026-05-18 23:18:35'),
(7, 5, 11, 'confirmacion', 'email', 'lcanoq@fcpn.edu.bo', 'Tu cita para manchas el 18/05/2026 14:00 ha sido confirmada.', '2026-05-18 23:19:37', '2026-05-18 23:19:41', 'enviado', 0, '2026-05-18 23:19:37'),
(8, 7, 10, 'confirmacion', 'email', 'lisbethnicolecanoquispe@gmail.com', 'Tu cita para chesnut el 17/05/2026 16:00 ha sido confirmada.', '2026-05-18 23:20:11', '2026-05-18 23:20:14', 'enviado', 0, '2026-05-18 23:20:11'),
(9, 7, 13, 'confirmacion', 'email', 'lisbethnicolecanoquispe@gmail.com', 'Tu cita para chesnut el 19/05/2026 17:30 ha sido confirmada.', '2026-05-19 21:39:54', '2026-05-19 21:39:59', 'enviado', 0, '2026-05-19 21:39:54'),
(10, 7, 13, 'listo_recoger', 'email', 'lisbethnicolecanoquispe@gmail.com', 'chesnut ya está listo para ser recogido.', '2026-05-19 22:01:14', '2026-05-19 22:01:18', 'enviado', 0, '2026-05-19 22:01:14'),
(11, 7, 14, 'confirmacion', 'email', 'lisbethnicolecanoquispe@gmail.com', 'Tu cita para chesnut el 20/05/2026 17:30 ha sido confirmada.', '2026-05-19 22:09:15', '2026-05-19 22:09:19', 'enviado', 0, '2026-05-19 22:09:15'),
(12, 5, 19, 'confirmacion', 'email', 'lcanoq@fcpn.edu.bo', 'Tu cita para manchas el 21/05/2026 16:30 ha sido confirmada.', '2026-05-21 05:08:27', '2026-05-21 05:08:37', 'enviado', 0, '2026-05-21 05:08:27'),
(13, 5, 18, 'confirmacion', 'email', 'lcanoq@fcpn.edu.bo', 'Tu cita para max el 21/05/2026 12:30 ha sido confirmada.', '2026-05-21 05:08:41', '2026-05-21 05:08:45', 'enviado', 0, '2026-05-21 05:08:41'),
(14, 5, 16, 'confirmacion', 'email', 'lcanoq@fcpn.edu.bo', 'Tu cita para manchas el 21/05/2026 09:30 ha sido confirmada.', '2026-05-21 05:08:48', '2026-05-21 05:08:52', 'enviado', 0, '2026-05-21 05:08:48');

-- --------------------------------------------------------

--
-- Table structure for table `pagos`
--

CREATE TABLE `pagos` (
  `id` bigint UNSIGNED NOT NULL,
  `cita_id` bigint UNSIGNED NOT NULL,
  `metodo` enum('efectivo','qr','transferencia') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'efectivo',
  `monto` decimal(10,2) NOT NULL,
  `descuento` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total` decimal(10,2) NOT NULL,
  `referencia` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Nro. de transferencia o QR',
  `observaciones` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` enum('pendiente','pagado','anulado') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pendiente',
  `registrado_por` bigint UNSIGNED DEFAULT NULL,
  `creado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pagos`
--

INSERT INTO `pagos` (`id`, `cita_id`, `metodo`, `monto`, `descuento`, `total`, `referencia`, `observaciones`, `estado`, `registrado_por`, `creado_en`, `actualizado_en`) VALUES
(1, 4, 'efectivo', 100.00, 0.12, 99.88, NULL, NULL, 'pagado', 8, '2026-05-20 06:59:34', '2026-05-20 06:59:34'),
(2, 6, 'qr', 150.00, 0.50, 149.50, 'TRX-202600123', NULL, 'pagado', 8, '2026-05-20 07:02:25', '2026-05-20 07:02:25');

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
-- Table structure for table `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int UNSIGNED NOT NULL,
  `carrito_id` int UNSIGNED DEFAULT NULL,
  `cliente_id` int UNSIGNED DEFAULT NULL,
  `sucursal_id` int UNSIGNED DEFAULT NULL,
  `estado` enum('pendiente','enviado','confirmado','pagado','entregado','cancelado') NOT NULL DEFAULT 'pendiente',
  `metodo_contacto` enum('whatsapp','telegram') NOT NULL DEFAULT 'whatsapp',
  `subtotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `descuento` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `notas` text,
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `productos`
--

CREATE TABLE `productos` (
  `id` int UNSIGNED NOT NULL,
  `categoria_id` int UNSIGNED DEFAULT NULL,
  `sucursal_id` int UNSIGNED DEFAULT NULL,
  `sku` varchar(100) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text,
  `precio_base` decimal(10,2) NOT NULL DEFAULT '0.00',
  `stock` int UNSIGNED NOT NULL DEFAULT '0',
  `stock_minimo` int UNSIGNED NOT NULL DEFAULT '0',
  `imagen_url` varchar(500) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ;

--
-- Dumping data for table `productos`
--

INSERT INTO `productos` (`id`, `categoria_id`, `sucursal_id`, `sku`, `nombre`, `descripcion`, `precio_base`, `stock`, `stock_minimo`, `imagen_url`, `activo`, `creado_en`, `actualizado_en`) VALUES
(1, 2, NULL, 'PROD-001', 'Shampoo para perros', NULL, 35.00, 19, 5, NULL, 1, '2026-05-17 03:51:35', '2026-05-20 20:11:52'),
(2, 2, NULL, 'PROD-002', 'Shampoo Pelo Corto Natural Pet Co.', 'El Shampoo para Pelo Corto de Natural Pet Co. es un shampoo diseñado para perros y gatos adultos.\r\nEste shampoo contiene protector capilar que cuida la piel y pelaje de tu mascota luego del paso de los agentes de limpieza.', 38.00, 13, 5, 'https://d34xtejqjqcp3x.cloudfront.net/store/00a5bc450dbdc3bbaf3d034637bda293.webp?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=AKIAYIRW3MP4AFEFPOFU%2F20260517%2Fsa-east-1%2Fs3%2Faws4_request&X-Amz-Date=20260517T174739Z&X-Amz-Expires=900&X-Amz-SignedHeaders=host&X-Amz-Signature=6005cb7fb51c4783bbefd323e72e43740284e190bd0467121ab7c717deeaa9a1', 1, '2026-05-17 17:49:15', '2026-05-21 05:20:03');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int UNSIGNED NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `nombre`, `descripcion`, `creado_en`) VALUES
(1, 'admin', 'Acceso total al sistema', '2026-05-01 21:57:56'),
(2, 'recepcion', 'Gestión de citas, clientes y caja', '2026-05-01 21:57:56'),
(3, 'groomer', 'Acceso a sus citas y fichas de grooming', '2026-05-01 21:57:56'),
(4, 'cliente', 'Autogestión: citas, mascotas, facturas', '2026-05-01 21:57:56');

-- --------------------------------------------------------

--
-- Table structure for table `servicios`
--

CREATE TABLE `servicios` (
  `id` int UNSIGNED NOT NULL,
  `sucursal_id` int UNSIGNED DEFAULT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text,
  `precio_base` decimal(10,2) NOT NULL DEFAULT '0.00',
  `duracion_base_minutos` smallint UNSIGNED NOT NULL,
  `factor_tamano_raza` json DEFAULT NULL,
  `consumo_insumos` json DEFAULT NULL,
  `permite_doble_booking` tinyint(1) NOT NULL DEFAULT '0',
  `requiere_bloqueo_consecutivo` tinyint(1) NOT NULL DEFAULT '0',
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ;

--
-- Dumping data for table `servicios`
--

INSERT INTO `servicios` (`id`, `sucursal_id`, `nombre`, `descripcion`, `precio_base`, `duracion_base_minutos`, `factor_tamano_raza`, `consumo_insumos`, `permite_doble_booking`, `requiere_bloqueo_consecutivo`, `activo`, `creado_en`, `actualizado_en`) VALUES
(1, NULL, 'Baño rápido', 'Baño básico con secado', 50.00, 30, '{\"l\": 1.3, \"m\": 1.15, \"s\": 1, \"xl\": 1.5, \"xs\": 1}', NULL, 0, 0, 1, '2026-05-15 20:19:46', '2026-05-15 20:19:46'),
(2, NULL, 'Baño completo', 'Baño, secado y perfume', 80.00, 60, '{\"l\": 1.3, \"m\": 1.15, \"s\": 1, \"xl\": 1.5, \"xs\": 1}', NULL, 0, 0, 1, '2026-05-15 20:19:46', '2026-05-15 20:19:46'),
(3, NULL, 'Corte y peinado', 'Corte de pelo y peinado profesional', 100.00, 90, '{\"l\": 1.3, \"m\": 1.15, \"s\": 1, \"xl\": 1.5, \"xs\": 1}', NULL, 0, 0, 1, '2026-05-15 20:19:47', '2026-05-15 20:19:47'),
(4, NULL, 'Servicio completo', 'Baño, corte, peinado y perfume', 150.00, 120, '{\"l\": 1.3, \"m\": 1.15, \"s\": 1, \"xl\": 1.5, \"xs\": 1}', NULL, 0, 0, 1, '2026-05-15 20:19:49', '2026-05-15 20:19:49'),
(5, NULL, 'Baño rápido', 'Baño básico con secado', 50.00, 30, '{\"l\": 1.3, \"m\": 1.15, \"s\": 1, \"xl\": 1.5, \"xs\": 1}', NULL, 0, 0, 0, '2026-05-15 20:20:27', '2026-05-17 22:39:05'),
(6, NULL, 'Baño completo', 'Baño, secado y perfume', 80.00, 60, '{\"l\": 1.3, \"m\": 1.15, \"s\": 1, \"xl\": 1.5, \"xs\": 1}', NULL, 0, 0, 0, '2026-05-15 20:20:53', '2026-05-17 22:39:05'),
(7, NULL, 'Corte y peinado', 'Corte de pelo y peinado profesional', 100.00, 90, '{\"l\": 1.3, \"m\": 1.15, \"s\": 1, \"xl\": 1.5, \"xs\": 1}', NULL, 0, 0, 0, '2026-05-15 20:21:05', '2026-05-17 22:39:05'),
(8, NULL, 'Servicio completo', 'Baño, corte, peinado y perfume', 150.00, 120, '{\"l\": 1.3, \"m\": 1.15, \"s\": 1, \"xl\": 1.5, \"xs\": 1}', NULL, 0, 0, 0, '2026-05-15 20:21:16', '2026-05-17 22:39:05');

-- --------------------------------------------------------

--
-- Table structure for table `sesiones_usuario`
--

CREATE TABLE `sesiones_usuario` (
  `id` int UNSIGNED NOT NULL,
  `usuario_id` int UNSIGNED NOT NULL,
  `token_jwt` text NOT NULL,
  `refresh_token` varchar(512) NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(500) DEFAULT NULL,
  `fecha_expiracion` datetime NOT NULL,
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
('4b5GSRaQRI3AcqgrbQ7e2uT6JalPvZ00YinSmeKU', 16, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJudXhKVWl0UXVLWUVOeFdPbG1qN0RSQ2JZbHJlOWZ0RlVseWRDbkpOIiwidXJsIjpbXSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9ncm9vbWVyXC9hZ2VuZGEiLCJyb3V0ZSI6Imdyb29tZXIuYWdlbmRhLmluZGV4In0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjE2LCJ1bHRpbWFfYWN0aXZpZGFkIjoxNzc5MzgxOTk2fQ==', 1779381996),
('9yNB9TVUM6aLrou1xPC0QJ8Qw3Z2W17usOnFSkD2', 8, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJKNkNzamZTM1hFN25xY0ZsNDVTMnY5SW5IMkxFRU1EUDkyd0o3QWxsIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9kYXNoYm9hcmQiLCJyb3V0ZSI6ImRhc2hib2FyZCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjo4LCJ1bHRpbWFfYWN0aXZpZGFkIjoxNzc5MzgyMDI2fQ==', 1779382026),
('OiaK6nv0ItTo2MFgULlI3JnUUqpHR1EyJT5Wv4ZL', 7, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJ5ZWRqUFJkVTJhUlNZeWluZjl6OUdya3BuRVBMV1VFM2RMcnBjRmo4IiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2Rhc2hib2FyZCJ9LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2Rhc2hib2FyZCIsInJvdXRlIjoiZGFzaGJvYXJkIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjcsIjJmYV92ZXJpZmljYWRvIjp0cnVlLCJ1bHRpbWFfYWN0aXZpZGFkIjoxNzc5MzgyMTQ3fQ==', 1779382147);

-- --------------------------------------------------------

--
-- Table structure for table `sucursales`
--

CREATE TABLE `sucursales` (
  `id` int UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `updated_at` timestamp NULL DEFAULT NULL,
  `rol_id` bigint UNSIGNED DEFAULT NULL,
  `ci` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `proveedor_oauth` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oauth_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verificado` tinyint(1) NOT NULL DEFAULT '0',
  `token_verificacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token_expira_en` datetime DEFAULT NULL,
  `intentos_fallidos` tinyint NOT NULL DEFAULT '0',
  `bloqueado_hasta` datetime DEFAULT NULL,
  `two_factor_secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `ultimo_acceso` datetime DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `rol_id`, `ci`, `proveedor_oauth`, `oauth_id`, `email_verificado`, `token_verificacion`, `token_expira_en`, `intentos_fallidos`, `bloqueado_hasta`, `two_factor_secret`, `two_factor_enabled`, `ultimo_acceso`, `activo`) VALUES
(1, 'anahi', 'ana@gmail.com', NULL, '$2y$12$/pstsooqMQ9jqbpjEdcQHeecanP2FcmL8MNPQiq8wuezx32m/Zy6G', NULL, '2026-05-02 03:46:01', '2026-05-02 03:46:01', 4, NULL, NULL, NULL, 0, '49354cb9d4b4b31dac13e530a0930f7651ebefcc7f6197fc09314b22d6babbd6', '2026-05-02 00:01:01', 0, NULL, NULL, 0, NULL, 0),
(2, 'lisel', 'usuriariod@prueba.gmail.com', NULL, '$2y$12$m58vJAPMTgRcsSK/BygYwOiYI3Iy9ajAcaNHYx47K7u2yCqKsBlC6', NULL, '2026-05-02 03:59:25', '2026-05-02 03:59:25', 4, NULL, NULL, NULL, 0, '84f66bf3e298414a784b5c7c2c012be192a84b919fbfec9e445e9b2170a00be5', '2026-05-02 00:14:25', 0, NULL, NULL, 0, NULL, 0),
(3, 'lisel', 'puede@gmail.com', NULL, '$2y$12$AXvQuxJcuNcavyiSmGcOvOXO1l6EyHVn8nd4wWN7fksTVUx3m0OnS', NULL, '2026-05-02 04:03:14', '2026-05-02 04:09:39', 4, NULL, NULL, NULL, 1, NULL, NULL, 0, NULL, NULL, 0, '2026-05-02 00:09:39', 1),
(4, 'anahi', 'anahicanoquispe@gmail.com', NULL, '$2y$12$PlGSiCPR6S/qIgGso7UyOO2UgI8P9gtAUjNZ3NyHTIAT4KEX.cJZ.', NULL, '2026-05-02 04:30:44', '2026-05-02 04:30:44', 4, NULL, NULL, NULL, 0, '0b5a12e50651c14c2aeb1e02d804e162cd14f1cb36b434d21fdbf825acf86ed5', '2026-05-02 00:45:44', 0, NULL, NULL, 0, NULL, 0),
(5, 'Nicole', 'canoquispelisel@gmail.com', NULL, '$2y$12$Kj.DutJsxOIVhoVroPDQ/egrtsdlMIR7SYjPYNZKfzx/DdZHeWMVC', NULL, '2026-05-02 04:43:45', '2026-05-03 22:36:51', 4, NULL, NULL, NULL, 1, NULL, NULL, 0, NULL, NULL, 0, '2026-05-03 18:36:51', 1),
(6, 'LISBETH NICOLE CANO QUISPE', 'lcanoq@fcpn.edu.bo', NULL, '$2y$12$.AllK/c.yfv5p215F5Eo/Oh97GvmjfafAvTfJDY42nzphMrqdpdry', NULL, '2026-05-02 05:24:44', '2026-05-02 05:24:44', 4, NULL, 'google', '104523743246774182018', 1, NULL, NULL, 0, NULL, NULL, 0, NULL, 1),
(7, 'Administrador', 'admin@petspa.com', NULL, '$2y$12$zsvpPGe4klJx5xFbdTWQ2.Zh77EqHave7kNxBzOQqoSMCmMm4gMgO', NULL, '2026-05-03 01:07:19', '2026-05-21 20:48:32', 1, NULL, NULL, NULL, 1, NULL, NULL, 0, NULL, 'NBPMCSKB6THBOMCE', 1, '2026-05-21 16:48:32', 1),
(8, 'lisbeth', 'lisbethcanoquispe@gmail.com', NULL, '$2y$12$sJIDN1jVmXS8j8UL.wUC9.0XiHFFqs/zhAqZ1Om2zVnNhaYQShrS6', NULL, '2026-05-03 01:40:52', '2026-05-19 03:14:18', 2, NULL, NULL, NULL, 1, NULL, NULL, 0, NULL, NULL, 0, '2026-05-18 23:14:18', 1),
(9, 'nahomi calle quispe', 'nahomicanoquispe@gmail.com', NULL, '$2y$12$tgFuFtru8InBgF5rGvNuFOjZw7sJ6fYyebS71tQFlwuZld2uIlN0G', NULL, '2026-05-03 02:04:42', '2026-05-03 02:10:49', 3, NULL, NULL, NULL, 1, NULL, NULL, 0, NULL, NULL, 0, NULL, 0),
(10, 'mario', 'ceneg94470@iapapi.com', NULL, '$2y$12$G4.C/B5SIOdL/Y22DvLPcepJmHee3Zq1.tB3DKOLL9ItrzvthznQ6', NULL, '2026-05-03 22:06:07', '2026-05-17 21:09:21', 4, NULL, NULL, NULL, 1, NULL, NULL, 0, NULL, NULL, 0, '2026-05-17 17:09:21', 1),
(11, 'Alejandro Cano Quispe', 'noe.canq@gmail.com', NULL, '$2y$12$l8Lcv23xBPiu85dbxhFDeOxswSnbyHisxKT82YKK1GXMNey0taIiW', NULL, '2026-05-04 03:11:55', '2026-05-21 20:10:56', 3, NULL, NULL, NULL, 1, NULL, NULL, 0, NULL, NULL, 0, '2026-05-17 22:52:05', 0),
(12, 'eduardo', 'n1fztngsck@ruutukf.com', NULL, '$2y$12$euaTYTQeHe6tB3lOlli8qeKpuBHOUBZvANxhRUKxpTaTeV1ah0LsO', NULL, '2026-05-04 04:38:22', '2026-05-04 04:38:22', 3, NULL, NULL, NULL, 1, NULL, NULL, 0, NULL, NULL, 0, NULL, 1),
(13, 'lisbeth nicole', 'lisbethnicolecanoquispe@gmail.com', NULL, '$2y$12$vQZsvapLoUkzQrD0uOw5TeLe1HjyvTCqd.jf3ws7wVYP2z68W3zHC', NULL, '2026-05-04 07:08:26', '2026-05-04 07:11:28', 4, NULL, NULL, NULL, 1, NULL, NULL, 5, '2026-05-04 03:26:28', NULL, 0, '2026-05-04 03:09:35', 1),
(14, 'omar', 'nrgl6yqj4d@wnbaldwy.com', NULL, '$2y$12$.P0Wqvf29Z8ahhXTzrACv.tPG12CtoW4urG7fpkDh.mlbJ8nq6vy.', NULL, '2026-05-16 04:55:32', '2026-05-17 20:30:37', 3, NULL, NULL, NULL, 1, NULL, NULL, 3, NULL, NULL, 0, '2026-05-16 21:33:26', 1),
(15, 'Juan Daniel Cruz Suntura', 'juandanielcruzsuntura@gmail.com', NULL, '$2y$12$VbbjLi1NJ/nBsBBEyd6Gke.RgdUq4C4gFpcoBL/uyetTAZd.UKZ62', NULL, '2026-05-17 20:42:04', '2026-05-17 20:42:04', 3, NULL, NULL, NULL, 1, NULL, NULL, 0, NULL, NULL, 0, NULL, 1),
(16, 'Juan Daniel Cruz', 'kivito.cruz@gmail.com', NULL, '$2y$12$44i7AV9OSozFN1eeBD70r.btGuDwl4H54C1CTuQwM..bDeQY23bwS', NULL, '2026-05-17 20:51:20', '2026-05-21 20:46:27', 3, NULL, NULL, NULL, 1, NULL, NULL, 0, NULL, NULL, 0, '2026-05-21 16:46:27', 1);

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int UNSIGNED NOT NULL,
  `rol_id` int UNSIGNED DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `two_factor_secret` varchar(100) DEFAULT NULL,
  `two_factor_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `ultimo_acceso` datetime DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vacunas_mascota`
--

CREATE TABLE `vacunas_mascota` (
  `id` int UNSIGNED NOT NULL,
  `mascota_id` int UNSIGNED NOT NULL,
  `nombre_vacuna` varchar(100) NOT NULL,
  `fecha_aplicacion` date NOT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `observaciones` text,
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `vacunas_mascota`
--

INSERT INTO `vacunas_mascota` (`id`, `mascota_id`, `nombre_vacuna`, `fecha_aplicacion`, `fecha_vencimiento`, `observaciones`, `creado_en`) VALUES
(1, 6, 'esta es mi tajreta de control', '2026-05-19', '2027-06-19', 'http://127.0.0.1:8000/storage/vacunas/dECO10gmmplZ86hcMoGj2ne6HSQlTMM7mrmqQVDo.jpg', '2026-05-19 21:57:23'),
(2, 3, 'rabia', '2026-05-19', '2027-05-19', 'http://127.0.0.1:8000/storage/vacunas/jQieGMq1NQjKPCT6rseBmH9lEW2JtD3yw2YkoJAv.pdf', '2026-05-19 22:01:08');

-- --------------------------------------------------------

--
-- Table structure for table `variantes_producto`
--

CREATE TABLE `variantes_producto` (
  `id` int UNSIGNED NOT NULL,
  `producto_id` int UNSIGNED NOT NULL,
  `sku_variante` varchar(100) NOT NULL,
  `atributo` varchar(50) NOT NULL,
  `valor` varchar(100) NOT NULL,
  `precio_extra` decimal(10,2) NOT NULL DEFAULT '0.00',
  `stock` int UNSIGNED NOT NULL DEFAULT '0',
  `activo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_log`
--
ALTER TABLE `audit_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_audit_usuario` (`usuario_id`);

--
-- Indexes for table `auth_logs`
--
ALTER TABLE `auth_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auth_logs_usuario_id_foreign` (`usuario_id`);

--
-- Indexes for table `bloqueos_agenda`
--
ALTER TABLE `bloqueos_agenda`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bloqueos_calendario`
--
ALTER TABLE `bloqueos_calendario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bloqueo_groomer` (`groomer_id`);

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
-- Indexes for table `carritos`
--
ALTER TABLE `carritos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `session_token` (`session_token`),
  ADD KEY `fk_carrito_cliente` (`cliente_id`),
  ADD KEY `idx_carrito_expires` (`expires_at`);

--
-- Indexes for table `categorias_productos`
--
ALTER TABLE `categorias_productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cat_padre` (`padre_id`);

--
-- Indexes for table `checklist_items_catalogo`
--
ALTER TABLE `checklist_items_catalogo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_checklist_cat_servicio` (`servicio_id`);

--
-- Indexes for table `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_groomer_inicio` (`groomer_id`,`fecha_hora_inicio`),
  ADD KEY `fk_citas_servicio` (`servicio_id`),
  ADD KEY `fk_citas_sucursal` (`sucursal_id`),
  ADD KEY `fk_citas_reprog_id` (`reprogramada_desde_id`),
  ADD KEY `idx_citas_mascota` (`mascota_id`),
  ADD KEY `idx_citas_groomer_fecha` (`groomer_id`,`fecha_hora_inicio`),
  ADD KEY `idx_citas_estado` (`estado`),
  ADD KEY `idx_citas_fecha` (`fecha_hora_inicio`),
  ADD KEY `fk_citas_creador` (`creado_por_usuario_id`),
  ADD KEY `fk_citas_reprog_usr` (`reprogramada_por_id`);

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario_id` (`usuario_id`),
  ADD KEY `fk_clientes_sucursal` (`sucursal_id`);

--
-- Indexes for table `consumo_insumos_ficha`
--
ALTER TABLE `consumo_insumos_ficha`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_consumo_ficha` (`ficha_id`),
  ADD KEY `fk_consumo_producto` (`producto_id`),
  ADD KEY `fk_consumo_variante` (`variante_id`);

--
-- Indexes for table `detalle_carrito`
--
ALTER TABLE `detalle_carrito`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_det_carrito_carrito` (`carrito_id`),
  ADD KEY `fk_det_carrito_producto` (`producto_id`),
  ADD KEY `fk_det_carrito_variante` (`variante_id`);

--
-- Indexes for table `detalle_factura`
--
ALTER TABLE `detalle_factura`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_det_factura` (`factura_id`);

--
-- Indexes for table `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_det_pedido_pedido` (`pedido_id`),
  ADD KEY `fk_det_pedido_producto` (`producto_id`),
  ADD KEY `fk_det_pedido_variante` (`variante_id`);

--
-- Indexes for table `disponibilidad_groomer`
--
ALTER TABLE `disponibilidad_groomer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_disp_groomer_dia` (`groomer_id`,`dia_semana`);

--
-- Indexes for table `encuestas_satisfaccion`
--
ALTER TABLE `encuestas_satisfaccion`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cita_id` (`cita_id`),
  ADD KEY `fk_encuesta_cliente` (`cliente_id`);

--
-- Indexes for table `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero_factura` (`numero_factura`),
  ADD KEY `fk_factura_cita` (`cita_id`),
  ADD KEY `fk_factura_pedido` (`pedido_id`),
  ADD KEY `fk_factura_sucursal` (`sucursal_id`),
  ADD KEY `idx_facturas_cliente` (`cliente_id`),
  ADD KEY `idx_facturas_estado` (`estado`),
  ADD KEY `idx_facturas_fecha` (`fecha_emision`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fichas_checklist`
--
ALTER TABLE `fichas_checklist`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_ficha_item` (`ficha_id`,`item_id`),
  ADD KEY `fk_fichas_checklist_item` (`item_id`);

--
-- Indexes for table `fichas_grooming`
--
ALTER TABLE `fichas_grooming`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cita_id` (`cita_id`);

--
-- Indexes for table `fotos_grooming`
--
ALTER TABLE `fotos_grooming`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_fotos_ficha` (`ficha_id`);

--
-- Indexes for table `groomers`
--
ALTER TABLE `groomers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario_id` (`usuario_id`),
  ADD KEY `fk_groomers_sucursal` (`sucursal_id`);

--
-- Indexes for table `historial_mascotas`
--
ALTER TABLE `historial_mascotas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_historial_mascota` (`mascota_id`,`creado_en`);

--
-- Indexes for table `horarios_spa`
--
ALTER TABLE `horarios_spa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `insumos_grooming`
--
ALTER TABLE `insumos_grooming`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `log_notificaciones`
--
ALTER TABLE `log_notificaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_log_noti` (`notificacion_id`);

--
-- Indexes for table `mascotas`
--
ALTER TABLE `mascotas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mascota_dueno`
--
ALTER TABLE `mascota_dueno`
  ADD PRIMARY KEY (`mascota_id`,`cliente_id`),
  ADD KEY `fk_md_cliente` (`cliente_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_noti_cita` (`cita_id`),
  ADD KEY `idx_noti_programacion` (`fecha_programacion`,`estado`),
  ADD KEY `idx_noti_cliente` (`cliente_id`);

--
-- Indexes for table `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pedido_carrito` (`carrito_id`),
  ADD KEY `fk_pedido_sucursal` (`sucursal_id`),
  ADD KEY `idx_pedidos_cliente` (`cliente_id`),
  ADD KEY `idx_pedidos_estado` (`estado`);

--
-- Indexes for table `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sku` (`sku`),
  ADD KEY `fk_productos_sucursal` (`sucursal_id`),
  ADD KEY `idx_prod_categoria` (`categoria_id`),
  ADD KEY `idx_prod_stock` (`stock`,`stock_minimo`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indexes for table `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_servicios_sucursal` (`sucursal_id`);

--
-- Indexes for table `sesiones_usuario`
--
ALTER TABLE `sesiones_usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `refresh_token` (`refresh_token`),
  ADD KEY `fk_sesiones_usuario` (`usuario_id`),
  ADD KEY `idx_sesiones_token` (`refresh_token`),
  ADD KEY `idx_sesiones_expiracion` (`fecha_expiracion`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `sucursales`
--
ALTER TABLE `sucursales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_usuarios_rol` (`rol_id`);

--
-- Indexes for table `vacunas_mascota`
--
ALTER TABLE `vacunas_mascota`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_vacunas_mascota` (`mascota_id`);

--
-- Indexes for table `variantes_producto`
--
ALTER TABLE `variantes_producto`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sku_variante` (`sku_variante`),
  ADD KEY `fk_variante_producto` (`producto_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_log`
--
ALTER TABLE `audit_log`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_logs`
--
ALTER TABLE `auth_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=190;

--
-- AUTO_INCREMENT for table `bloqueos_agenda`
--
ALTER TABLE `bloqueos_agenda`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bloqueos_calendario`
--
ALTER TABLE `bloqueos_calendario`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `carritos`
--
ALTER TABLE `carritos`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categorias_productos`
--
ALTER TABLE `categorias_productos`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `checklist_items_catalogo`
--
ALTER TABLE `checklist_items_catalogo`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `citas`
--
ALTER TABLE `citas`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `consumo_insumos_ficha`
--
ALTER TABLE `consumo_insumos_ficha`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detalle_carrito`
--
ALTER TABLE `detalle_carrito`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detalle_factura`
--
ALTER TABLE `detalle_factura`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `disponibilidad_groomer`
--
ALTER TABLE `disponibilidad_groomer`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `encuestas_satisfaccion`
--
ALTER TABLE `encuestas_satisfaccion`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `facturas`
--
ALTER TABLE `facturas`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fichas_checklist`
--
ALTER TABLE `fichas_checklist`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `fichas_grooming`
--
ALTER TABLE `fichas_grooming`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `fotos_grooming`
--
ALTER TABLE `fotos_grooming`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `groomers`
--
ALTER TABLE `groomers`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `historial_mascotas`
--
ALTER TABLE `historial_mascotas`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `horarios_spa`
--
ALTER TABLE `horarios_spa`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `insumos_grooming`
--
ALTER TABLE `insumos_grooming`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log_notificaciones`
--
ALTER TABLE `log_notificaciones`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mascotas`
--
ALTER TABLE `mascotas`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sesiones_usuario`
--
ALTER TABLE `sesiones_usuario`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sucursales`
--
ALTER TABLE `sucursales`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vacunas_mascota`
--
ALTER TABLE `vacunas_mascota`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `variantes_producto`
--
ALTER TABLE `variantes_producto`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `audit_log`
--
ALTER TABLE `audit_log`
  ADD CONSTRAINT `fk_audit_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `auth_logs`
--
ALTER TABLE `auth_logs`
  ADD CONSTRAINT `auth_logs_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `bloqueos_calendario`
--
ALTER TABLE `bloqueos_calendario`
  ADD CONSTRAINT `fk_bloqueo_groomer` FOREIGN KEY (`groomer_id`) REFERENCES `groomers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `carritos`
--
ALTER TABLE `carritos`
  ADD CONSTRAINT `fk_carrito_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `categorias_productos`
--
ALTER TABLE `categorias_productos`
  ADD CONSTRAINT `fk_cat_padre` FOREIGN KEY (`padre_id`) REFERENCES `categorias_productos` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `checklist_items_catalogo`
--
ALTER TABLE `checklist_items_catalogo`
  ADD CONSTRAINT `fk_checklist_cat_servicio` FOREIGN KEY (`servicio_id`) REFERENCES `servicios` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `fk_citas_creador` FOREIGN KEY (`creado_por_usuario_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_citas_groomer` FOREIGN KEY (`groomer_id`) REFERENCES `groomers` (`id`),
  ADD CONSTRAINT `fk_citas_mascota` FOREIGN KEY (`mascota_id`) REFERENCES `mascotas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_citas_reprog_id` FOREIGN KEY (`reprogramada_desde_id`) REFERENCES `citas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_citas_reprog_usr` FOREIGN KEY (`reprogramada_por_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_citas_servicio` FOREIGN KEY (`servicio_id`) REFERENCES `servicios` (`id`),
  ADD CONSTRAINT `fk_citas_sucursal` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `fk_clientes_sucursal` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_clientes_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `consumo_insumos_ficha`
--
ALTER TABLE `consumo_insumos_ficha`
  ADD CONSTRAINT `fk_consumo_ficha` FOREIGN KEY (`ficha_id`) REFERENCES `fichas_grooming` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_consumo_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `fk_consumo_variante` FOREIGN KEY (`variante_id`) REFERENCES `variantes_producto` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `detalle_carrito`
--
ALTER TABLE `detalle_carrito`
  ADD CONSTRAINT `fk_det_carrito_carrito` FOREIGN KEY (`carrito_id`) REFERENCES `carritos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_det_carrito_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `fk_det_carrito_variante` FOREIGN KEY (`variante_id`) REFERENCES `variantes_producto` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `detalle_factura`
--
ALTER TABLE `detalle_factura`
  ADD CONSTRAINT `fk_det_factura` FOREIGN KEY (`factura_id`) REFERENCES `facturas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD CONSTRAINT `fk_det_pedido_pedido` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_det_pedido_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `fk_det_pedido_variante` FOREIGN KEY (`variante_id`) REFERENCES `variantes_producto` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `disponibilidad_groomer`
--
ALTER TABLE `disponibilidad_groomer`
  ADD CONSTRAINT `fk_disp_groomer` FOREIGN KEY (`groomer_id`) REFERENCES `groomers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `encuestas_satisfaccion`
--
ALTER TABLE `encuestas_satisfaccion`
  ADD CONSTRAINT `fk_encuesta_cita` FOREIGN KEY (`cita_id`) REFERENCES `citas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_encuesta_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `facturas`
--
ALTER TABLE `facturas`
  ADD CONSTRAINT `fk_factura_cita` FOREIGN KEY (`cita_id`) REFERENCES `citas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_factura_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_factura_pedido` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_factura_sucursal` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `fichas_checklist`
--
ALTER TABLE `fichas_checklist`
  ADD CONSTRAINT `fk_fichas_checklist_ficha` FOREIGN KEY (`ficha_id`) REFERENCES `fichas_grooming` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_fichas_checklist_item` FOREIGN KEY (`item_id`) REFERENCES `checklist_items_catalogo` (`id`);

--
-- Constraints for table `fichas_grooming`
--
ALTER TABLE `fichas_grooming`
  ADD CONSTRAINT `fk_fichas_cita` FOREIGN KEY (`cita_id`) REFERENCES `citas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fotos_grooming`
--
ALTER TABLE `fotos_grooming`
  ADD CONSTRAINT `fk_fotos_ficha` FOREIGN KEY (`ficha_id`) REFERENCES `fichas_grooming` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `groomers`
--
ALTER TABLE `groomers`
  ADD CONSTRAINT `fk_groomers_sucursal` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_groomers_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `historial_mascotas`
--
ALTER TABLE `historial_mascotas`
  ADD CONSTRAINT `fk_historial_mascota` FOREIGN KEY (`mascota_id`) REFERENCES `mascotas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `log_notificaciones`
--
ALTER TABLE `log_notificaciones`
  ADD CONSTRAINT `fk_log_noti` FOREIGN KEY (`notificacion_id`) REFERENCES `notificaciones` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mascota_dueno`
--
ALTER TABLE `mascota_dueno`
  ADD CONSTRAINT `fk_md_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_md_mascota` FOREIGN KEY (`mascota_id`) REFERENCES `mascotas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD CONSTRAINT `fk_noti_cita` FOREIGN KEY (`cita_id`) REFERENCES `citas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_noti_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_pedido_carrito` FOREIGN KEY (`carrito_id`) REFERENCES `carritos` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_pedido_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_pedido_sucursal` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_productos_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias_productos` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_productos_sucursal` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `servicios`
--
ALTER TABLE `servicios`
  ADD CONSTRAINT `fk_servicios_sucursal` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `sesiones_usuario`
--
ALTER TABLE `sesiones_usuario`
  ADD CONSTRAINT `fk_sesiones_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_rol` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `vacunas_mascota`
--
ALTER TABLE `vacunas_mascota`
  ADD CONSTRAINT `fk_vacunas_mascota` FOREIGN KEY (`mascota_id`) REFERENCES `mascotas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `variantes_producto`
--
ALTER TABLE `variantes_producto`
  ADD CONSTRAINT `fk_variante_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
