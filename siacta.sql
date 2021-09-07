-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 07, 2021 at 04:47 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `siacta`
--

-- --------------------------------------------------------

--
-- Table structure for table `akumulasis`
--

CREATE TABLE `akumulasis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `nama_aset` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nilai_aset` bigint(20) NOT NULL,
  `jumlah_unit` int(11) NOT NULL,
  `total_harga` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `akuns`
--

CREATE TABLE `akuns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `no_akun` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_akun` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `saldo_normal` enum('debit','kredit') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('penyesuaian','tidak_pen') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `akuns`
--

INSERT INTO `akuns` (`id`, `id_user`, `no_akun`, `nama_akun`, `saldo_normal`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '11.01.00', 'Kas', 'debit', 'penyesuaian', '2021-08-18 04:57:41', '2021-08-18 04:57:41'),
(2, 1, '81.03.00', 'Potongan Penjualan', 'debit', 'tidak_pen', '2021-08-18 04:58:13', '2021-08-18 04:58:13'),
(3, 1, '13.01.00', 'Piutang Usaha', 'debit', 'tidak_pen', '2021-08-18 04:59:05', '2021-08-18 04:59:05'),
(4, 1, '50.01.00', 'Utang Usaha', 'kredit', 'tidak_pen', '2021-08-18 04:59:48', '2021-08-18 04:59:48'),
(5, 1, '50.13.00', 'Pph 23 Terutang', 'kredit', 'tidak_pen', '2021-08-18 05:00:25', '2021-08-18 05:00:25'),
(6, 1, '50.12.00', 'PPh 22 Terutang', 'kredit', 'tidak_pen', '2021-08-18 05:00:47', '2021-08-18 05:00:47'),
(7, 1, '91.13.00', 'Potongan Pembelian', 'kredit', 'tidak_pen', '2021-08-18 05:01:36', '2021-08-18 05:01:36'),
(8, 1, '50.21.00', 'PPN Keluaran', 'kredit', 'tidak_pen', '2021-08-18 05:03:32', '2021-08-18 05:03:32'),
(9, 1, '16.09.00', 'PPN Masukan', 'debit', 'tidak_pen', '2021-08-18 05:03:58', '2021-08-18 05:03:58'),
(10, 1, '11.02.00', 'Kas di Bank', 'debit', 'tidak_pen', '2021-08-18 05:06:06', '2021-08-18 05:06:06'),
(11, 1, '11.03.00', 'Kas Kecil', 'debit', 'tidak_pen', '2021-08-18 05:06:50', '2021-08-18 05:06:50'),
(12, 1, '12.01.00', 'Deposito', 'debit', 'tidak_pen', '2021-08-18 05:07:23', '2021-08-18 05:07:23'),
(13, 1, '12.02.00', 'Surat Berharga', 'debit', 'tidak_pen', '2021-08-18 05:07:59', '2021-08-18 05:07:59'),
(14, 1, '12.03.00', 'Investasi Jangka Pendek Lainnya', 'debit', 'tidak_pen', '2021-08-18 05:08:54', '2021-08-18 05:08:54'),
(15, 1, '13.02.00', 'Piutang PAMDes', 'debit', 'tidak_pen', '2021-08-18 05:09:22', '2021-08-18 05:09:22'),
(16, 1, '13.02.01', 'ADE KARNIA 02/14', 'debit', 'tidak_pen', '2021-08-18 05:09:45', '2021-08-18 05:09:45'),
(17, 1, '13.02.02', 'AGUS DESI 02/14', 'debit', 'tidak_pen', '2021-08-18 05:10:07', '2021-08-18 05:10:07'),
(18, 1, '13.02.03', 'ALO SUWANDI 02/14', 'debit', 'tidak_pen', '2021-08-18 05:10:33', '2021-08-18 05:10:33'),
(19, 1, '13.02.04', 'BAH ANDI 02/14', 'debit', 'tidak_pen', '2021-08-18 05:10:54', '2021-08-18 05:10:54'),
(20, 1, '13.02.05', 'CECEP MS 02/14', 'debit', 'tidak_pen', '2021-08-18 05:11:14', '2021-08-18 05:11:14'),
(21, 1, '13.02.06', 'DADANG BELESOY 02/14', 'debit', 'tidak_pen', '2021-08-18 05:11:43', '2021-08-18 05:11:43'),
(22, 1, '13.02.07', 'DAYAT 02/14', 'debit', 'tidak_pen', '2021-08-18 05:12:04', '2021-08-18 05:12:04'),
(23, 1, '13.02.08', 'DEDE 02/14', 'debit', 'tidak_pen', '2021-08-18 05:12:28', '2021-08-18 05:12:28'),
(24, 1, '13.02.09', 'DEDE WITA 02/14', 'debit', 'tidak_pen', '2021-08-18 05:12:52', '2021-08-18 05:12:52'),
(25, 1, '13.02.10', 'DEDEN BATU I 02/14', 'debit', 'tidak_pen', '2021-08-18 05:13:26', '2021-08-18 05:13:26'),
(26, 1, '13.02.11', 'DEDEN BATU II 02/14', 'debit', 'tidak_pen', '2021-08-18 05:13:50', '2021-08-18 05:13:50'),
(28, 1, '13.02.13', 'ENGKOS 02/14', 'debit', 'tidak_pen', '2021-08-18 05:14:49', '2021-08-18 05:14:49'),
(29, 1, '13.02.14', 'ENJANG 02/14', 'debit', 'tidak_pen', '2021-08-18 05:15:11', '2021-08-18 05:15:11'),
(30, 1, '13.02.15', 'GURU JAJANG 02/14', 'debit', 'tidak_pen', '2021-08-18 05:15:34', '2021-08-18 05:15:34'),
(31, 1, '13.02.16', 'H. SANA 02/14', 'debit', 'tidak_pen', '2021-08-18 05:15:54', '2021-08-18 05:15:54'),
(32, 1, '13.02.17', 'H.AYUB I 02/14', 'debit', 'tidak_pen', '2021-08-18 05:16:14', '2021-08-18 05:16:14'),
(34, 1, '13.02.18', 'H. AYUB II 02/14', 'debit', 'tidak_pen', '2021-08-18 05:19:27', '2021-08-18 05:19:27'),
(35, 1, '13.02.19', 'IKIN 02/14', 'debit', 'tidak_pen', '2021-08-18 05:19:49', '2021-08-18 05:19:49'),
(36, 1, '13.02.20', 'JUHANA 02/14', 'debit', 'tidak_pen', '2021-08-18 05:20:41', '2021-08-18 05:20:41'),
(37, 1, '13.02.21', 'KARSA 02/14', 'debit', 'tidak_pen', '2021-08-18 08:10:18', '2021-08-18 08:10:18'),
(38, 1, '13.02.12', 'DETI 02/14', 'debit', 'tidak_pen', '2021-08-19 00:31:23', '2021-08-19 00:31:23'),
(39, 1, '13.02.22', 'MA ADE 02/14', 'debit', 'tidak_pen', '2021-08-19 00:32:12', '2021-08-19 00:32:12'),
(40, 1, '13.02.23', 'MA OTIH 02/14', 'debit', 'tidak_pen', '2021-08-19 00:32:33', '2021-08-19 00:32:33'),
(41, 1, '13.02.24', 'MAMAH DEDEH 02/14', 'debit', 'tidak_pen', '2021-08-19 00:32:56', '2021-08-19 00:32:56'),
(42, 1, '13.02.25', 'MAMAT 02/14', 'debit', 'tidak_pen', '2021-08-19 00:33:15', '2021-08-19 00:33:15'),
(43, 1, '13.02.26', 'MAMAT EDAH 02/14', 'debit', 'tidak_pen', '2021-08-19 00:33:36', '2021-08-19 00:33:36'),
(44, 1, '13.02.27', 'MANG WAWA 02/14', 'debit', 'tidak_pen', '2021-08-19 00:33:52', '2021-08-19 00:33:52'),
(45, 1, '13.02.28', 'NANDANG 02/14', 'debit', 'tidak_pen', '2021-08-19 00:34:08', '2021-08-19 00:34:08'),
(46, 1, '13.02.29', 'NIA 02/14', 'debit', 'tidak_pen', '2021-08-19 00:34:23', '2021-08-19 00:34:23'),
(47, 1, '13.02.30', 'NONO 02/14', 'debit', 'tidak_pen', '2021-08-19 00:34:37', '2021-08-19 00:34:37'),
(48, 1, '13.02.31', 'ODI 02/14', 'debit', 'tidak_pen', '2021-08-19 00:34:54', '2021-08-19 00:34:54'),
(49, 1, '13.02.32', 'PAK AMANG 02/14', 'debit', 'tidak_pen', '2021-08-19 00:35:09', '2021-08-19 00:35:09'),
(50, 1, '13.02.33', 'RATMI 02/14', 'debit', 'tidak_pen', '2021-08-19 00:35:25', '2021-08-19 00:35:25'),
(51, 1, '13.02.34', 'TARYAT 02/14', 'debit', 'tidak_pen', '2021-08-19 00:35:40', '2021-08-19 00:35:40'),
(52, 1, '13.02.35', 'UCU 02/14', 'debit', 'tidak_pen', '2021-08-19 00:35:54', '2021-08-19 00:35:54'),
(53, 1, '13.02.36', 'UJANG CACA 02/14', 'debit', 'tidak_pen', '2021-08-19 00:36:57', '2021-08-19 00:36:57'),
(54, 1, '13.02.37', 'UJANG DADANG 02/14', 'debit', 'tidak_pen', '2021-08-19 00:37:14', '2021-08-19 00:37:14'),
(55, 1, '13.02.38', 'UJANG RAHMAT 02/14', 'debit', 'tidak_pen', '2021-08-19 00:37:30', '2021-08-19 00:37:30'),
(56, 1, '13.02.39', 'WAHYU 02/14', 'debit', 'tidak_pen', '2021-08-19 00:37:46', '2021-08-19 00:37:46'),
(57, 1, '13.02.40', 'YANI 02/14', 'debit', 'tidak_pen', '2021-08-19 00:38:05', '2021-08-19 00:38:05'),
(58, 1, '13.02.41', 'YUSUP 02/14', 'debit', 'tidak_pen', '2021-08-19 00:38:21', '2021-08-19 00:38:21'),
(59, 1, '13.02.42', 'ASEP ROMA 02/14', 'debit', 'tidak_pen', '2021-08-19 00:38:37', '2021-08-19 00:38:37'),
(60, 1, '13.02.43', 'CUCU 02/14', 'debit', 'tidak_pen', '2021-08-19 00:38:51', '2021-08-19 00:38:51'),
(61, 1, '13.02.44', 'DANA 02/14', 'debit', 'tidak_pen', '2021-08-19 00:39:06', '2021-08-19 00:39:06'),
(62, 1, '13.02.45', 'ETI 02/14', 'debit', 'tidak_pen', '2021-08-19 00:39:22', '2021-08-19 00:39:22'),
(63, 1, '13.02.46', 'KOKOM 02/14', 'debit', 'tidak_pen', '2021-08-19 00:39:51', '2021-08-19 00:39:51'),
(64, 1, '13.02.47', 'MA HAJI IPUK 02/14', 'debit', 'tidak_pen', '2021-08-19 00:41:19', '2021-08-19 00:41:19'),
(65, 1, '13.02.48', 'MA.RIAH 02/14', 'debit', 'tidak_pen', '2021-08-19 00:41:34', '2021-08-19 00:41:34'),
(66, 1, '13.02.49', 'MANG ADE 02/14', 'debit', 'tidak_pen', '2021-08-19 00:41:52', '2021-08-19 00:41:52'),
(67, 1, '13.02.50', 'SURYANA 02/14', 'debit', 'tidak_pen', '2021-08-19 00:42:10', '2021-08-19 00:42:10'),
(68, 1, '13.02.51', 'TINI 02/14', 'debit', 'tidak_pen', '2021-08-19 00:42:26', '2021-08-19 00:42:26'),
(69, 1, '13.02.52', 'WAWAN. H 02/14', 'debit', 'tidak_pen', '2021-08-19 00:42:41', '2021-08-19 00:42:41'),
(70, 1, '13.02.53', 'ACE 01/16', 'debit', 'tidak_pen', '2021-08-19 00:42:56', '2021-08-19 00:42:56'),
(71, 1, '13.02.54', 'ADE SOLIHIN 01/16', 'debit', 'tidak_pen', '2021-08-19 00:43:10', '2021-08-19 00:43:10'),
(72, 1, '13.02.55', 'ANING 01/16', 'debit', 'tidak_pen', '2021-08-19 00:43:26', '2021-08-19 00:43:26'),
(73, 1, '13.02.56', 'ASEP GURU 01/16', 'debit', 'tidak_pen', '2021-08-19 00:43:40', '2021-08-19 00:43:40'),
(74, 1, '13.02.57', 'AYEH 01/16', 'debit', 'tidak_pen', '2021-08-19 00:43:56', '2021-08-19 00:43:56'),
(75, 1, '13.02.58', 'BI PIAH 01/16', 'debit', 'tidak_pen', '2021-08-19 00:44:12', '2021-08-19 00:44:12'),
(76, 1, '13.02.59', 'CECEP 01/16', 'debit', 'tidak_pen', '2021-08-19 00:44:28', '2021-08-19 00:44:28'),
(77, 1, '13.02.60', 'DADAN 01/16', 'debit', 'tidak_pen', '2021-08-19 00:44:41', '2021-08-19 00:44:41'),
(78, 1, '13.02.61', 'DADI SURYADI 01/16', 'debit', 'tidak_pen', '2021-08-19 00:44:56', '2021-08-19 00:44:56'),
(79, 1, '13.02.62', 'DEDI 01/16', 'debit', 'tidak_pen', '2021-08-19 00:45:10', '2021-08-19 00:45:10'),
(80, 1, '13.02.63', 'ENUNG 01/16', 'debit', 'tidak_pen', '2021-08-19 00:45:23', '2021-08-19 00:45:23'),
(81, 1, '13.02.64', 'ENUNG KOMALA SARI 01/16', 'debit', 'tidak_pen', '2021-08-19 00:45:39', '2021-08-19 00:45:39'),
(82, 1, '13.02.65', 'H. ENJANG 01/16', 'debit', 'tidak_pen', '2021-08-19 00:45:58', '2021-08-19 00:45:58'),
(83, 1, '13.02.66', 'H. ENJANG GURU 01/16', 'debit', 'tidak_pen', '2021-08-19 00:46:14', '2021-08-19 00:46:14'),
(84, 1, '13.02.67', 'H. EUIS 01/16', 'debit', 'tidak_pen', '2021-08-19 00:46:28', '2021-08-19 00:46:28'),
(85, 1, '13.02.68', 'H. WAWAN 01/16', 'debit', 'tidak_pen', '2021-08-19 00:46:46', '2021-08-19 00:46:46'),
(86, 1, '13.02.69', 'H. YOYO 01/16', 'debit', 'tidak_pen', '2021-08-19 00:47:00', '2021-08-19 00:47:00'),
(87, 1, '13.02.70', 'H.RUHIAT 01/16', 'debit', 'tidak_pen', '2021-08-19 00:47:16', '2021-08-19 00:47:16'),
(88, 1, '13.02.71', 'HINDUN 01/16', 'debit', 'tidak_pen', '2021-08-19 00:47:31', '2021-08-19 00:47:31'),
(89, 1, '13.02.72', 'HJ. ETI 01/16', 'debit', 'tidak_pen', '2021-08-19 00:47:45', '2021-08-19 00:47:45'),
(90, 1, '13.02.73', 'IIS 01/16', 'debit', 'tidak_pen', '2021-08-19 00:48:04', '2021-08-19 00:48:04'),
(91, 1, '13.02.74', 'JANAH 01/16', 'debit', 'tidak_pen', '2021-08-19 00:48:19', '2021-08-19 00:48:19'),
(92, 1, '13.02.75', 'JUHANA 01/16', 'debit', 'tidak_pen', '2021-08-19 00:48:37', '2021-08-19 00:48:37'),
(93, 1, '13.02.76', 'MAMAT 01/16', 'debit', 'tidak_pen', '2021-08-19 00:48:54', '2021-08-19 00:48:54'),
(94, 1, '13.02.77', 'MANG KOSWARA 01/16', 'debit', 'tidak_pen', '2021-08-19 00:49:08', '2021-08-19 00:49:08'),
(95, 1, '13.02.78', 'OLANG 01/16', 'debit', 'tidak_pen', '2021-08-19 00:49:22', '2021-08-19 00:49:22'),
(96, 1, '13.02.79', 'PAK ENCUN 01/16', 'debit', 'tidak_pen', '2021-08-19 00:49:37', '2021-08-19 00:49:37'),
(97, 1, '13.02.80', 'SOLEH 01/16', 'debit', 'tidak_pen', '2021-08-19 00:49:52', '2021-08-19 00:49:52'),
(98, 1, '13.02.81', 'SONI 01/16', 'debit', 'tidak_pen', '2021-08-19 00:50:07', '2021-08-19 00:50:07'),
(99, 1, '13.02.82', 'UJANG SARIP 01/16', 'debit', 'tidak_pen', '2021-08-19 00:50:21', '2021-08-19 00:50:21'),
(100, 1, '13.02.83', 'UJANG TANU 01/16', 'debit', 'tidak_pen', '2021-08-19 00:50:37', '2021-08-19 00:50:37'),
(101, 1, '13.02.84', 'YUYUN 01/16', 'debit', 'tidak_pen', '2021-08-19 00:50:49', '2021-08-19 00:50:49'),
(102, 1, '13.02.85', 'ACENG 02/16', 'debit', 'tidak_pen', '2021-08-19 00:51:03', '2021-08-19 00:51:03'),
(103, 1, '13.02.86', 'AI ROHAETI 02/16', 'debit', 'tidak_pen', '2021-08-19 00:51:17', '2021-08-19 00:51:17'),
(104, 1, '13.02.87', 'AJANG 02/16', 'debit', 'tidak_pen', '2021-08-19 00:51:30', '2021-08-19 00:51:30'),
(105, 1, '13.02.88', 'AKO 02/16', 'debit', 'tidak_pen', '2021-08-19 00:51:46', '2021-08-19 00:51:46'),
(106, 1, '13.02.89', 'ASEP 02/16', 'debit', 'tidak_pen', '2021-08-19 00:51:58', '2021-08-19 00:51:58'),
(107, 1, '13.02.90', 'BANA 02/16', 'debit', 'tidak_pen', '2021-08-19 00:52:11', '2021-08-19 00:52:11'),
(108, 1, '13.02.91', 'CUCU CULI 02/16', 'debit', 'tidak_pen', '2021-08-19 00:52:41', '2021-08-19 00:52:41'),
(109, 1, '13.02.92', 'DADANG 02/16', 'debit', 'tidak_pen', '2021-08-19 00:52:55', '2021-08-19 00:52:55'),
(110, 1, '13.02.93', 'DADANG RW 02/16', 'debit', 'tidak_pen', '2021-08-19 00:53:08', '2021-08-19 00:53:08'),
(111, 1, '13.02.94', 'DEDE 02/16', 'debit', 'tidak_pen', '2021-08-19 00:53:24', '2021-08-19 00:53:24'),
(112, 1, '13.02.95', 'ENDED 02/16', 'debit', 'tidak_pen', '2021-08-19 00:53:38', '2021-08-19 00:53:38'),
(113, 1, '13.02.96', 'GITO 02/16', 'debit', 'tidak_pen', '2021-08-19 00:53:51', '2021-08-19 00:53:51'),
(114, 1, '13.02.97', 'LENI 02/16', 'debit', 'tidak_pen', '2021-08-19 00:54:05', '2021-08-19 00:54:05'),
(115, 1, '13.02.98', 'RUSDA 02/16', 'debit', 'tidak_pen', '2021-08-19 00:54:19', '2021-08-19 00:54:19'),
(116, 1, '13.02.99', 'TATA 02/16', 'debit', 'tidak_pen', '2021-08-19 00:54:33', '2021-08-19 00:54:33'),
(117, 1, '13.02.100', 'TATI ALIS HARTATI 02/16', 'debit', 'tidak_pen', '2021-08-19 00:54:49', '2021-08-19 00:54:49'),
(118, 1, '13.02.101', 'TITING 02/16', 'debit', 'tidak_pen', '2021-08-19 00:56:36', '2021-08-19 00:56:36'),
(119, 1, '13.02.102', 'ADE SAHIDIN 03/16', 'debit', 'tidak_pen', '2021-08-19 00:56:49', '2021-08-19 00:56:49'),
(120, 1, '13.02.103', 'AMO 03/16', 'debit', 'tidak_pen', '2021-08-19 00:57:02', '2021-08-19 00:57:02'),
(121, 1, '13.02.104', 'AYI 03/16', 'debit', 'tidak_pen', '2021-08-19 00:57:15', '2021-08-19 00:57:15'),
(122, 1, '13.02.105', 'BU CICAH 03/16', 'debit', 'tidak_pen', '2021-08-19 00:57:31', '2021-08-19 00:57:31'),
(123, 1, '13.02.106', 'EDEN 03/16', 'debit', 'tidak_pen', '2021-08-19 00:57:47', '2021-08-19 00:57:47'),
(124, 1, '13.02.107', 'EDEN 03/16', 'debit', 'tidak_pen', '2021-08-19 00:57:58', '2021-08-19 00:57:58'),
(125, 1, '13.02.108', 'GOWOK 03/16', 'debit', 'tidak_pen', '2021-08-19 00:58:11', '2021-08-19 00:58:11'),
(126, 1, '13.02.109', 'KARJO 03/16', 'debit', 'tidak_pen', '2021-08-19 00:58:25', '2021-08-19 00:58:25'),
(127, 1, '13.02.110', 'LONRI 03/16', 'debit', 'tidak_pen', '2021-08-19 00:58:39', '2021-08-19 00:58:39'),
(128, 1, '13.03.00', 'PIUTANG SIMPAN PINJAM', 'debit', 'tidak_pen', '2021-08-19 01:15:22', '2021-08-19 01:15:22'),
(129, 1, '13.03.01', 'AEP SAEPUDIN 01/12', 'debit', 'tidak_pen', '2021-08-19 01:15:42', '2021-08-19 01:15:42'),
(130, 1, '13.03.02', 'AJANG 01/12', 'debit', 'tidak_pen', '2021-08-19 01:15:59', '2021-08-19 01:15:59'),
(131, 1, '13.03.03', 'AOS SOLEHUDIN 01/12', 'debit', 'tidak_pen', '2021-08-19 01:16:15', '2021-08-19 01:16:15'),
(132, 1, '13.03.04', 'ARIS HERMAWAN 01/12', 'debit', 'tidak_pen', '2021-08-19 01:16:28', '2021-08-19 01:16:28'),
(133, 1, '13.03.05', 'AYI KOSASIH 01/12', 'debit', 'tidak_pen', '2021-08-19 01:16:41', '2021-08-19 01:16:41'),
(134, 1, '13.03.06', 'CAHYAT 01/12', 'debit', 'tidak_pen', '2021-08-19 01:16:55', '2021-08-19 01:16:55'),
(135, 1, '13.03.07', 'CEPI 01/12', 'debit', 'tidak_pen', '2021-08-19 01:17:09', '2021-08-19 01:17:09'),
(136, 1, '13.03.08', 'EDEN SODIK 01/12', 'debit', 'tidak_pen', '2021-08-19 01:17:22', '2021-08-19 01:17:22'),
(137, 1, '13.03.09', 'ENJANG WAHYU 01/12', 'debit', 'tidak_pen', '2021-08-19 01:17:36', '2021-08-19 01:17:36'),
(138, 1, '13.03.10', 'ETI ROHAETI 01/12', 'debit', 'tidak_pen', '2021-08-19 01:17:50', '2021-08-19 01:17:50'),
(139, 1, '13.03.11', 'GANJAR KURNIAWAN 01/12', 'debit', 'tidak_pen', '2021-08-19 01:18:04', '2021-08-19 01:18:04'),
(140, 1, '13.03.12', 'IKRARUDIN RAFNI 01/12', 'debit', 'tidak_pen', '2021-08-19 01:18:17', '2021-08-19 01:18:17'),
(141, 1, '13.03.13', 'ILA ROBIAH 01/12', 'debit', 'tidak_pen', '2021-08-19 01:18:32', '2021-08-19 01:18:32'),
(142, 1, '13.03.14', 'IMAS WAHNA 01/12', 'debit', 'tidak_pen', '2021-08-19 01:18:45', '2021-08-19 01:18:45'),
(143, 1, '13.03.15', 'IMAS WAHNA 01/12', 'debit', 'tidak_pen', '2021-08-19 01:18:58', '2021-08-19 01:18:58'),
(144, 1, '13.03.16', 'IMAT RISMAYANTI 01/12', 'debit', 'tidak_pen', '2021-08-19 01:19:10', '2021-08-19 01:19:10'),
(145, 1, '13.03.17', 'LILI KASUM 01/12', 'debit', 'tidak_pen', '2021-08-19 01:19:22', '2021-08-19 01:19:22'),
(146, 1, '13.03.18', 'NINING 01/12', 'debit', 'tidak_pen', '2021-08-19 01:19:36', '2021-08-19 01:19:36'),
(147, 1, '13.03.19', 'NONENG SUHARTINI 01/12', 'debit', 'tidak_pen', '2021-08-19 01:19:49', '2021-08-19 01:19:49'),
(148, 1, '13.03.20', 'TITA WARSITA 01/12', 'debit', 'tidak_pen', '2021-08-19 01:20:04', '2021-08-19 01:20:04'),
(149, 1, '13.03.21', 'USUP 01/12', 'debit', 'tidak_pen', '2021-08-19 01:20:16', '2021-08-19 01:20:16'),
(150, 1, '13.03.22', 'WINI ASTI YULIANI 01/12', 'debit', 'tidak_pen', '2021-08-19 01:20:30', '2021-08-19 01:20:30'),
(151, 1, '13.03.23', 'YANA 01/12', 'debit', 'tidak_pen', '2021-08-19 01:20:43', '2021-08-19 01:20:43'),
(152, 1, '13.03.24', 'YETI ROHAETI 01/12', 'debit', 'tidak_pen', '2021-08-19 01:20:57', '2021-08-19 01:20:57'),
(153, 1, '13.03.25', 'YOYOH 01/12', 'debit', 'tidak_pen', '2021-08-19 01:21:09', '2021-08-19 01:21:09'),
(154, 1, '13.03.26', 'YULI SUSILIDYAWATI 01/12', 'debit', 'tidak_pen', '2021-08-19 01:21:25', '2021-08-19 01:21:25'),
(155, 1, '13.04.00', 'Piutang Desa', 'debit', 'tidak_pen', '2021-08-19 01:21:41', '2021-08-19 01:21:41'),
(156, 1, '13.05.00', 'Piutang Usaha Lainnya', 'debit', 'tidak_pen', '2021-08-19 01:22:03', '2021-08-19 01:22:03'),
(157, 1, '13.05.01', 'Piutang Pendapatan', 'debit', 'penyesuaian', '2021-08-19 01:25:03', '2021-08-19 01:25:03'),
(158, 1, '13.01.01', 'Akumulasi Penyisihan Kerugian Piutang Usaha', 'kredit', 'tidak_pen', '2021-08-19 01:25:40', '2021-08-19 01:25:40'),
(159, 1, '14.02.00', 'Piutang Pajak', 'debit', 'tidak_pen', '2021-08-19 01:26:02', '2021-08-19 01:26:02'),
(160, 1, '14.03.00', 'Piutang Pegawai', 'debit', 'tidak_pen', '2021-08-19 01:44:34', '2021-08-19 01:44:34'),
(161, 1, '14.04.00', 'Piutang Non Usaha Lainnya', 'debit', 'tidak_pen', '2021-08-19 01:44:49', '2021-08-19 01:44:49'),
(162, 1, '14.04.01', 'Akumulasi Penyisihan Kerugian Piutang Non Usaha', 'kredit', 'tidak_pen', '2021-08-19 01:45:04', '2021-08-19 01:45:04'),
(163, 1, '15.01.00', 'Perlengkapan Toko', 'debit', 'penyesuaian', '2021-08-19 01:45:46', '2021-08-19 01:45:46'),
(164, 1, '15.02.00', 'Persediaan Lainnya', 'debit', 'tidak_pen', '2021-08-19 01:47:49', '2021-08-19 01:47:49'),
(165, 1, '16.01.00', 'Beban Dibayar Dimuka', 'debit', 'tidak_pen', '2021-08-19 01:48:55', '2021-08-19 01:48:55'),
(166, 1, '16.01.01', 'Gaji Dibayar Dimuka', 'debit', 'penyesuaian', '2021-08-19 01:49:12', '2021-08-19 01:49:12'),
(167, 1, '16.01.02', 'Bunga Bank Dibayar Dimuka', 'debit', 'penyesuaian', '2021-08-19 01:49:25', '2021-08-19 01:49:25'),
(168, 1, '16.02.00', 'Uang Muka Kerja', 'debit', 'tidak_pen', '2021-08-19 01:49:41', '2021-08-19 01:49:41'),
(169, 1, '16.03.00', 'Uang Muka Pembelian', 'debit', 'tidak_pen', '2021-08-19 01:49:54', '2021-08-19 01:49:54'),
(170, 1, '16.04.00', 'Pembayaran Dimuka Pajak', 'debit', 'tidak_pen', '2021-08-19 01:50:20', '2021-08-19 01:50:20'),
(171, 1, '16.05.00', 'Sewa Dibayar Dimuka', 'debit', 'tidak_pen', '2021-08-19 01:51:23', '2021-08-19 01:51:23'),
(172, 1, '16.05.01', 'Sewa Gedung Kantor Dibayar Dimuka', 'debit', 'penyesuaian', '2021-08-19 01:51:44', '2021-08-19 01:51:44'),
(173, 1, '16.05.02', 'Sewa Kendaraan Roda 2 Dibayar Dimuka', 'debit', 'penyesuaian', '2021-08-19 01:51:58', '2021-08-19 01:51:58'),
(174, 1, '16.05.03', 'Sewa Kendaraan Roda 3 Dibayar Dimuka', 'debit', 'penyesuaian', '2021-08-19 01:52:11', '2021-08-19 01:52:11'),
(175, 1, '16.05.04', 'Sewa Kendaraan Roda 4 Dibayar Dimuka', 'debit', 'penyesuaian', '2021-08-19 01:52:26', '2021-08-19 01:52:26'),
(176, 1, '16.05.05', 'Sewa Alat Berat Dibayar Dimuka', 'debit', 'penyesuaian', '2021-08-19 01:52:41', '2021-08-19 01:52:41'),
(177, 1, '16.05.06', 'Sewa Mesin Dibayar Dimuka', 'debit', 'penyesuaian', '2021-08-19 01:53:42', '2021-08-19 01:53:42'),
(178, 1, '16.05.07', 'Iklan Dibayar Dimuka', 'debit', 'penyesuaian', '2021-08-19 01:53:56', '2021-08-19 01:53:56'),
(179, 1, '16.06.00', 'Asuransi Dibayar Dimuka', 'debit', 'penyesuaian', '2021-08-19 01:54:14', '2021-08-19 01:54:14'),
(180, 1, '16.07.00', 'Uang Muka Pajak', 'debit', 'tidak_pen', '2021-08-19 01:54:56', '2021-08-19 01:54:56'),
(181, 1, '16.07.01', 'Uang Muka PPh 22', 'debit', 'tidak_pen', '2021-08-19 01:55:09', '2021-08-19 01:55:09'),
(182, 1, '16.07.02', 'Uang Muka PPh 23', 'debit', 'tidak_pen', '2021-08-19 01:55:22', '2021-08-19 01:55:22'),
(183, 1, '16.07.03', 'Uang Muka PPh 25', 'debit', 'tidak_pen', '2021-08-19 01:55:34', '2021-08-19 01:55:34'),
(184, 1, '16.08.00', 'Uang Muka Lainnya', 'debit', 'tidak_pen', '2021-08-19 01:55:47', '2021-08-19 01:55:47'),
(185, 1, '17.00.00', 'RK Pusat', 'debit', 'tidak_pen', '2021-08-19 01:56:00', '2021-08-19 01:56:00'),
(186, 1, '18.00.00', 'Aset Lancar Lainnya', 'debit', 'tidak_pen', '2021-08-19 01:56:14', '2021-08-19 01:56:14'),
(187, 1, '21.01.00', 'Deposito Berjangka Lebih Dari 1 Tahun', 'debit', 'tidak_pen', '2021-08-19 01:58:08', '2021-08-19 01:58:08'),
(188, 1, '21.02.00', 'Penyertaan Dalam Saham', 'debit', 'tidak_pen', '2021-08-19 01:58:25', '2021-08-19 01:58:25'),
(189, 1, '21.03.00', 'Penyertaan Dalam Obligasi', 'debit', 'tidak_pen', '2021-08-19 01:58:38', '2021-08-19 01:58:38'),
(190, 1, '21.04.00', 'Penanaman Dalam Aktiva Berwujud', 'debit', 'tidak_pen', '2021-08-19 01:58:54', '2021-08-19 01:58:54'),
(191, 1, '21.05.00', 'Penyertaan Dalam Perusahaan Patungan', 'debit', 'tidak_pen', '2021-08-19 01:59:07', '2021-08-19 01:59:07'),
(192, 1, '21.06.00', 'Penyertaan Dalam Perusahaan Anak', 'debit', 'tidak_pen', '2021-08-19 01:59:20', '2021-08-19 01:59:20'),
(193, 1, '21.07.00', 'Investasi Jangka Panjang Lainnya', 'debit', 'tidak_pen', '2021-08-19 01:59:34', '2021-08-19 01:59:34'),
(194, 1, '31.01.00', 'Tanah', 'debit', 'tidak_pen', '2021-08-19 01:59:55', '2021-08-19 01:59:55'),
(195, 1, '31.02.00', 'Gedung dan Bangunan', 'debit', 'tidak_pen', '2021-08-19 02:00:16', '2021-08-19 02:00:16'),
(196, 1, '31.03.00', 'Peralatan', 'debit', 'tidak_pen', '2021-08-19 02:00:30', '2021-08-19 02:00:30'),
(197, 1, '31.04.00', 'Kendaraan Roda 2', 'debit', 'tidak_pen', '2021-08-19 02:00:41', '2021-08-19 02:00:41'),
(198, 1, '31.05.00', 'Kendaraan Roda 3', 'debit', 'tidak_pen', '2021-08-19 02:00:55', '2021-08-19 02:00:55'),
(199, 1, '31.06.00', 'Kendaraan Roda 4', 'debit', 'tidak_pen', '2021-08-19 02:01:07', '2021-08-19 02:01:07'),
(200, 1, '31.07.00', 'Inventaris/ Perabotan Kantor', 'debit', 'tidak_pen', '2021-08-19 02:01:20', '2021-08-19 02:01:20'),
(201, 1, '31.08.00', 'Aset Tetap Lainnya', 'debit', 'tidak_pen', '2021-08-19 02:01:32', '2021-08-19 02:01:32'),
(202, 1, '31.09.00', 'Akumulasi Penyusutan', 'kredit', 'penyesuaian', '2021-08-19 02:01:45', '2021-08-19 02:01:45'),
(203, 1, '31.09.02', 'Akumulasi Penyusutan Gedung dan Bangunan', 'kredit', 'penyesuaian', '2021-08-19 02:01:59', '2021-08-19 02:01:59'),
(204, 1, '31.09.03', 'Akumulasi Penyusutan Peralatan', 'kredit', 'penyesuaian', '2021-08-19 02:02:14', '2021-08-19 02:02:14'),
(205, 1, '31.09.04', 'Akumulasi Penyusutan Kendaraan Roda 2', 'kredit', 'penyesuaian', '2021-08-19 02:02:25', '2021-08-19 02:02:25'),
(206, 1, '31.09.05', 'Akumulasi Penyusutan Kendaraan Roda 3', 'kredit', 'penyesuaian', '2021-08-19 02:02:40', '2021-08-19 02:02:40'),
(207, 1, '31.09.06', 'Akumalasi Penyusutan Kendaraan Roda 4', 'kredit', 'penyesuaian', '2021-08-19 02:02:53', '2021-08-19 02:02:53'),
(208, 1, '31.09.07', 'Akumulasi Penyusutan Inventaris/ Perabotan Kantor', 'kredit', 'penyesuaian', '2021-08-19 02:03:06', '2021-08-19 02:03:06'),
(209, 1, '31.09.08', 'Akumulasi Penyusutan Aset Tetap Lainnya', 'kredit', 'penyesuaian', '2021-08-19 02:03:26', '2021-08-19 02:03:26'),
(210, 1, '32.01.00', 'Aset Tetap Leasing', 'debit', 'tidak_pen', '2021-08-19 02:04:18', '2021-08-19 02:04:18'),
(211, 1, '32.02.00', 'Akumulasi Penyusutan Aset Tetap Leasing', 'kredit', 'penyesuaian', '2021-08-19 02:04:37', '2021-08-19 02:04:37'),
(212, 1, '33.01.00', 'Properti Investasi', 'debit', 'tidak_pen', '2021-08-19 02:04:53', '2021-08-19 02:04:53'),
(213, 1, '33.02.00', 'Akumulasi Penyusutan Properti Investasi', 'kredit', 'penyesuaian', '2021-08-19 02:05:07', '2021-08-19 02:05:07'),
(214, 1, '33.03.00', 'Akumulasi Penurunan Nilai Properti Investasi', 'kredit', 'tidak_pen', '2021-08-19 02:05:24', '2021-08-19 02:05:24'),
(215, 1, '37.01.00', 'Aset Tetap Dalam Penyelesaian', 'debit', 'tidak_pen', '2021-08-19 02:05:38', '2021-08-19 02:05:38'),
(216, 1, '42.01.00', 'Trademark', 'debit', 'tidak_pen', '2021-08-19 02:06:31', '2021-08-19 02:06:31'),
(217, 1, '42.02.00', 'Goodwill', 'debit', 'tidak_pen', '2021-08-19 02:06:43', '2021-08-19 02:06:43'),
(218, 1, '42.03.00', 'Aset Tidak Berwujud Lainnya', 'debit', 'tidak_pen', '2021-08-19 02:06:56', '2021-08-19 02:06:56'),
(219, 1, '42.04.00', 'Akumulasi Amortisasi', 'kredit', 'tidak_pen', '2021-08-19 02:07:14', '2021-08-19 02:07:14'),
(220, 1, '42.04.01', 'Akumulasi Amortisasi Trademark', 'kredit', 'tidak_pen', '2021-08-19 02:07:26', '2021-08-19 02:07:26'),
(221, 1, '42.04.02', 'Akumulasi Amortisasi Goodwill', 'kredit', 'tidak_pen', '2021-08-19 02:07:39', '2021-08-19 02:07:39'),
(222, 1, '42.04.03', 'Akumulasi Amortisasi Lainnya', 'kredit', 'tidak_pen', '2021-08-19 02:07:50', '2021-08-19 02:07:50'),
(223, 1, '50.01.01', 'Utang Listrik dan Air', 'kredit', 'penyesuaian', '2021-08-19 02:11:11', '2021-08-19 02:11:11'),
(224, 1, '50.01.02', 'Utang Pulsa dan Internet', 'kredit', 'penyesuaian', '2021-08-19 02:11:26', '2021-08-19 02:11:26'),
(225, 1, '50.02.00', 'Utang Usaha PAMDes', 'kredit', 'tidak_pen', '2021-08-19 02:11:38', '2021-08-19 02:11:38'),
(226, 1, '50.03.00', 'Utang Usaha Simpan Pinjam', 'kredit', 'tidak_pen', '2021-08-19 02:12:10', '2021-08-19 02:12:10'),
(227, 1, '50.04.00', 'Utang Gaji', 'kredit', 'penyesuaian', '2021-08-19 02:12:23', '2021-08-19 02:12:23'),
(229, 1, '50.04.01', 'Utang Gaji Manager', 'kredit', 'penyesuaian', '2021-08-19 02:14:33', '2021-08-19 02:14:33'),
(230, 1, '50.04.02', 'Utang Gaji Koordinator Lapangan', 'kredit', 'penyesuaian', '2021-08-19 02:14:49', '2021-08-19 02:14:49'),
(231, 1, '50.04.03', 'Utang Gaji Pegawai Honorer 1', 'kredit', 'penyesuaian', '2021-08-19 02:15:01', '2021-08-19 02:15:01'),
(232, 1, '50.04.04', 'Utang Gaji Pegawai Honorer 2', 'kredit', 'penyesuaian', '2021-08-19 02:15:14', '2021-08-19 02:15:14'),
(233, 1, '50.05.00', 'Utang Non Usaha', 'kredit', 'tidak_pen', '2021-08-19 02:17:53', '2021-08-19 02:17:53'),
(234, 1, '50.06.00', 'Beban Yang Masih Harus Dibayar', 'debit', 'tidak_pen', '2021-08-19 02:18:10', '2021-08-19 02:18:10'),
(235, 1, '81.04.05', 'Pendapatan Diterima Di Muka', 'kredit', 'tidak_pen', '2021-08-19 02:18:31', '2021-08-19 02:18:31'),
(236, 1, '50.08.00', 'Pinjaman Jangka Pendek', 'kredit', 'tidak_pen', '2021-08-19 02:18:44', '2021-08-19 02:18:44'),
(237, 1, '50.09.00', 'PPN Terutang', 'kredit', 'tidak_pen', '2021-08-19 02:18:58', '2021-08-19 02:18:58'),
(238, 1, '50.10.00', 'Utang Pajak Final', 'kredit', 'tidak_pen', '2021-08-19 02:19:10', '2021-08-19 02:19:10'),
(239, 1, '50.11.00', 'PPh 21 Terutang', 'kredit', 'penyesuaian', '2021-08-19 02:19:34', '2021-08-19 02:19:34'),
(241, 1, '50.14.00', 'PPh 24 Terutang', 'kredit', 'tidak_pen', '2021-08-19 02:20:58', '2021-08-19 02:20:58'),
(242, 1, '50.15.00', 'Utang Jangka Panjang Jatuh Tempo', 'kredit', 'tidak_pen', '2021-08-19 02:21:13', '2021-08-19 02:21:13'),
(243, 1, '50.16.00', 'Utang Bunga', 'kredit', 'tidak_pen', '2021-08-19 02:22:01', '2021-08-19 02:22:01'),
(244, 1, '50.17.00', 'Utang Imbalan Kerja', 'kredit', 'tidak_pen', '2021-08-19 02:22:13', '2021-08-19 02:22:13'),
(245, 1, '50.18.00', 'Titipan Jaminan Hari Tua', 'kredit', 'penyesuaian', '2021-08-19 02:22:59', '2021-08-19 02:22:59'),
(246, 1, '50.18.01', 'Titipan Jaminan Hari Tua Manager', 'kredit', 'penyesuaian', '2021-08-19 02:23:11', '2021-08-19 02:23:11'),
(247, 1, '50.18.02', 'Titipan Jaminan Hari Tua Koordinasi Lapangan', 'kredit', 'penyesuaian', '2021-08-19 02:23:25', '2021-08-19 02:23:25'),
(248, 1, '50.18.03', 'Titipan Jaminan Hari Tua Pegawai Honorer 1', 'kredit', 'penyesuaian', '2021-08-19 02:23:37', '2021-08-19 02:23:37'),
(249, 1, '50.18.04', 'Titipan Jaminan Hari Tua Pegawai Honorer 2', 'kredit', 'penyesuaian', '2021-08-19 02:23:49', '2021-08-19 02:23:49'),
(250, 1, '50.19.00', 'Titipan Jaminan Pensiun', 'kredit', 'penyesuaian', '2021-08-19 02:24:02', '2021-08-19 02:24:02'),
(251, 1, '50.19.01', 'Titipan Jaminan Pensiun Manager', 'kredit', 'penyesuaian', '2021-08-19 02:24:14', '2021-08-19 02:24:14'),
(252, 1, '50.19.02', 'Titipan Jaminan Pensiun Koordinator Lapangan', 'kredit', 'penyesuaian', '2021-08-19 02:24:26', '2021-08-19 02:24:26'),
(253, 1, '50.19.03', 'Titipan Jaminan Pensiun Pegawai Honorer 1', 'kredit', 'penyesuaian', '2021-08-19 02:24:37', '2021-08-19 02:24:37'),
(254, 1, '50.19.04', 'Titipan Jaminan Pensiun Pegawai Honorer 2', 'kredit', 'penyesuaian', '2021-08-19 02:24:52', '2021-08-19 02:24:52'),
(255, 1, '50.20.00', 'Utang Jangka Pendek Lainnya', 'kredit', 'tidak_pen', '2021-08-19 02:25:07', '2021-08-19 02:25:07'),
(256, 1, '61.01.00', 'Utang Kepada Pemerintah', 'kredit', 'tidak_pen', '2021-08-19 02:26:13', '2021-08-19 02:26:13'),
(257, 1, '61.02.00', 'Utang Komersil', 'kredit', 'tidak_pen', '2021-08-19 02:26:27', '2021-08-19 02:26:27'),
(258, 1, '61.03.00', 'Utang Leasing', 'kredit', 'tidak_pen', '2021-08-19 02:26:40', '2021-08-19 02:26:40'),
(259, 1, '61.04.00', 'Utang Iuran Pensiun Jangka Panjang', 'kredit', 'tidak_pen', '2021-08-19 02:26:51', '2021-08-19 02:26:51'),
(260, 1, '61.05.00', 'Kewajiban Jangka Panjang Lainnya', 'kredit', 'tidak_pen', '2021-08-19 02:27:10', '2021-08-19 02:27:10'),
(261, 1, '62.01.00', 'Cadangan Dana', 'kredit', 'tidak_pen', '2021-08-19 02:27:33', '2021-08-19 02:27:33'),
(262, 1, '62.02.00', 'Kewajiban lain-lain', 'kredit', 'tidak_pen', '2021-08-19 02:27:46', '2021-08-19 02:27:46'),
(263, 1, '62.02.01', 'Cadangan Kerugian Piutang', 'kredit', 'tidak_pen', '2021-08-19 02:28:00', '2021-08-19 02:28:00'),
(264, 1, '70.01.00', 'Kekayaan Desa Yang Dipisahkan (Penyertaan Modal Desa)', 'kredit', 'tidak_pen', '2021-08-19 02:28:14', '2021-08-19 02:28:14'),
(265, 1, '70.03.00', 'Penyertaan Yang Belum Ditetapkan Statusnya', 'kredit', 'tidak_pen', '2021-08-19 02:28:33', '2021-08-19 02:28:33'),
(266, 1, '70.04.00', 'Bagi Hasil Penyertaan Modal Desa', 'debit', 'tidak_pen', '2021-08-19 02:28:46', '2021-08-19 02:28:46'),
(267, 1, '70.05.00', 'Bagi Hasil Penyertaan Modal Masyarakat', 'debit', 'tidak_pen', '2021-08-19 02:28:58', '2021-08-19 02:28:58'),
(268, 1, '70.06.00', 'Laba Ditahan', 'kredit', 'tidak_pen', '2021-08-19 02:29:10', '2021-08-19 02:29:10'),
(269, 1, '81.01.00', 'Pendapatan Usaha', 'kredit', 'tidak_pen', '2021-08-19 02:30:00', '2021-08-19 02:30:00'),
(270, 1, '81.02.00', 'Pendapatan Jasa', 'kredit', 'penyesuaian', '2021-08-19 02:30:15', '2021-08-19 02:30:15'),
(271, 1, '81.04.00', 'Pendapatan Operasional Lainnya', 'kredit', 'tidak_pen', '2021-08-19 02:30:37', '2021-08-19 02:30:37'),
(272, 1, '81.04.01', 'Pendapatan Sewa', 'kredit', 'penyesuaian', '2021-08-19 02:31:21', '2021-08-19 02:31:21'),
(273, 1, '81.04.02', 'Sewa Diterima Dimuka', 'kredit', 'penyesuaian', '2021-08-19 02:31:48', '2021-08-19 02:31:48'),
(274, 1, '81.04.03', 'Bunga Diterima Dimuka', 'kredit', 'penyesuaian', '2021-08-19 02:32:02', '2021-08-19 02:32:02'),
(275, 1, '81.04.04', 'Pendapatan Bunga', 'kredit', 'penyesuaian', '2021-08-19 02:32:14', '2021-08-19 02:32:14'),
(276, 1, '91.01.00', 'Beban Operasional Unit Usaha', 'debit', 'tidak_pen', '2021-08-19 02:34:01', '2021-08-19 02:34:01'),
(277, 1, '91.02.00', 'Beban Listrik dan Air', 'debit', 'penyesuaian', '2021-08-19 02:34:55', '2021-08-19 02:34:55'),
(278, 1, '91.03.00', 'Beban Pulsa dan Internet', 'debit', 'penyesuaian', '2021-08-19 02:35:08', '2021-08-19 02:35:08'),
(279, 1, '91.04.00', 'Beban Konsumsi', 'debit', 'tidak_pen', '2021-08-19 02:35:21', '2021-08-19 02:35:21'),
(280, 1, '91.05.00', 'Beban Transportasi', 'debit', 'tidak_pen', '2021-08-19 02:35:34', '2021-08-19 02:35:34'),
(281, 1, '91.06.00', 'Beban Perlengkapan Toko', 'debit', 'penyesuaian', '2021-08-19 02:35:48', '2021-08-19 02:35:48'),
(282, 1, '91.07.00', 'Beban Penyusutan', 'debit', 'penyesuaian', '2021-08-19 02:36:01', '2021-08-19 02:36:01'),
(283, 1, '91.07.02', 'Beban Penyusutan Gedung dan Bangunan', 'debit', 'penyesuaian', '2021-08-19 02:36:13', '2021-08-19 02:36:13'),
(284, 1, '91.07.03', 'Beban Penyusutan Peralatan Toko', 'debit', 'penyesuaian', '2021-08-19 02:36:25', '2021-08-19 02:36:25'),
(285, 1, '91.07.04', 'Beban Penyusutan Kendaraan Roda 2', 'debit', 'penyesuaian', '2021-08-19 02:36:38', '2021-08-19 02:36:38'),
(286, 1, '91.07.05', 'Beban Penyusutan Kendaraan Roda 3', 'debit', 'penyesuaian', '2021-08-19 02:36:50', '2021-08-19 02:36:50'),
(287, 1, '91.07.06', 'Beban Penyusutan Kendaraan Roda 4', 'debit', 'penyesuaian', '2021-08-19 02:37:01', '2021-08-19 02:37:01'),
(288, 1, '91.07.07', 'Beban Penyusutan Inventaris dan Perabotan Kantor', 'debit', 'penyesuaian', '2021-08-19 02:37:13', '2021-08-19 02:37:13'),
(289, 1, '91.08.00', 'Beban Sewa', 'debit', 'tidak_pen', '2021-08-19 02:38:12', '2021-08-19 02:38:12'),
(290, 1, '91.08.01', 'Beban Sewa Gedung Kantor', 'debit', 'penyesuaian', '2021-08-19 02:38:23', '2021-08-19 02:38:23'),
(291, 1, '91.08.02', 'Beban Sewa Kendaraan Roda 2', 'debit', 'penyesuaian', '2021-08-19 02:38:35', '2021-08-19 02:38:35'),
(292, 1, '91.08.03', 'Beban Sewa Kendaraan Roda 3', 'debit', 'penyesuaian', '2021-08-19 02:38:51', '2021-08-19 02:38:51'),
(293, 1, '91.08.04', 'Beban Sewa Kendaraan Roda 4', 'debit', 'penyesuaian', '2021-08-19 02:39:02', '2021-08-19 02:39:02'),
(294, 1, '91.08.05', 'Beban Sewa Alat Berat', 'debit', 'penyesuaian', '2021-08-19 02:39:13', '2021-08-19 02:39:13'),
(295, 1, '91.08.06', 'Beban Sewa Mesin', 'debit', 'penyesuaian', '2021-08-19 02:39:26', '2021-08-19 02:39:26'),
(296, 1, '91.09.00', 'Beban Administrasi Bank', 'debit', 'tidak_pen', '2021-08-19 02:39:39', '2021-08-19 02:39:39'),
(297, 1, '91.09.01', 'Beban Bunga Bank', 'debit', 'penyesuaian', '2021-08-19 02:39:53', '2021-08-19 02:39:53'),
(298, 1, '91.09.02', 'Beban Bunga', 'debit', 'penyesuaian', '2021-08-19 02:40:10', '2021-08-19 02:40:10'),
(299, 1, '91.10.00', 'Beban Jasa', 'debit', 'tidak_pen', '2021-08-19 02:40:37', '2021-08-19 02:40:37'),
(300, 1, '91.10.01', 'Beban Iklan', 'debit', 'penyesuaian', '2021-08-19 02:40:50', '2021-08-19 02:40:50'),
(301, 1, '91.11.00', 'Beban Asuransi', 'debit', 'penyesuaian', '2021-08-19 02:41:20', '2021-08-19 02:41:20'),
(302, 1, '91.12.00', 'Beban PPh Final', 'debit', 'penyesuaian', '2021-08-19 02:41:35', '2021-08-19 02:41:35'),
(303, 1, '91.14.00', 'Beban Operasional Lainnya', 'debit', 'tidak_pen', '2021-08-19 02:41:49', '2021-08-19 02:41:49'),
(304, 1, '91.14.01', 'Beban Kerugian Piutang', 'debit', 'tidak_pen', '2021-08-19 02:42:01', '2021-08-19 02:42:01'),
(305, 1, '91.15.00', 'Beban Pajak', 'debit', 'penyesuaian', '2021-08-19 02:42:12', '2021-08-19 02:42:12'),
(306, 1, '91.15.01', 'Beban PPh 21', 'debit', 'penyesuaian', '2021-08-19 02:42:23', '2021-08-19 02:42:23'),
(307, 1, '91.15.02', 'Beban PPh 22', 'debit', 'penyesuaian', '2021-08-19 02:42:35', '2021-08-19 02:42:35'),
(308, 1, '91.15.03', 'Beban PPh 23', 'debit', 'penyesuaian', '2021-08-19 02:42:47', '2021-08-19 02:42:47'),
(309, 1, '91.15.04', 'Beban PPh 24', 'debit', 'penyesuaian', '2021-08-19 02:42:58', '2021-08-19 02:42:58'),
(310, 1, '91.15.05', 'Beban PPN', 'debit', 'penyesuaian', '2021-08-19 02:43:09', '2021-08-19 02:43:09'),
(311, 1, '92.01.00', 'Beban Gaji Pegawai', 'debit', 'penyesuaian', '2021-08-19 02:46:26', '2021-08-19 02:46:26'),
(312, 1, '92.01.01', 'Beban Gaji Manager', 'debit', 'penyesuaian', '2021-08-19 02:47:04', '2021-08-19 02:47:04'),
(313, 1, '92.01.02', 'Beban Gaji Koordinator Lapangan', 'debit', 'penyesuaian', '2021-08-19 02:47:17', '2021-08-19 02:47:17'),
(314, 1, '92.01.03', 'Beban Gaji Pegawai Honorer 1', 'debit', 'penyesuaian', '2021-08-19 02:47:29', '2021-08-19 02:47:29'),
(315, 1, '92.01.04', 'Beban Gaji Pegawai Honorer 2', 'debit', 'penyesuaian', '2021-08-19 02:47:41', '2021-08-19 02:47:41'),
(316, 1, '92.02.00', 'Beban Tunjangan Lainnya', 'debit', 'tidak_pen', '2021-08-19 02:47:57', '2021-08-19 02:47:57'),
(317, 1, '92.02.01', 'Beban Tunjangan Manager', 'debit', 'tidak_pen', '2021-08-19 02:48:09', '2021-08-19 02:48:09'),
(318, 1, '92.02.02', 'Beban Tunjangan Koordinator Lapangan', 'debit', 'tidak_pen', '2021-08-19 02:48:23', '2021-08-19 02:48:23'),
(319, 1, '92.02.03', 'Beban Tunjangan Pegawai Honorer 1', 'debit', 'tidak_pen', '2021-08-19 02:48:36', '2021-08-19 02:48:36'),
(320, 1, '92.02.04', 'Beban Tunjangan Pegawai Honorer 2', 'debit', 'tidak_pen', '2021-08-19 02:48:48', '2021-08-19 02:48:48'),
(321, 1, '92.03.00', 'Beban Jaminan Kecelakaan', 'debit', 'tidak_pen', '2021-08-19 02:49:00', '2021-08-19 02:49:00'),
(322, 1, '92.03.01', 'Beban Jaminan Kecelakaan Manager', 'debit', 'tidak_pen', '2021-08-19 02:49:39', '2021-08-19 02:49:39'),
(323, 1, '92.03.02', 'Beban Jaminan Kecelakaan Koordinator Lapangan', 'debit', 'tidak_pen', '2021-08-19 02:50:53', '2021-08-19 02:50:53'),
(324, 1, '92.03.03', 'Beban Jaminan Kecelakaan Pegawai Honorer 1', 'debit', 'tidak_pen', '2021-08-19 02:51:04', '2021-08-19 02:51:04'),
(325, 1, '92.03.04', 'Beban Jaminan Kecelakaan Pegawai Honorer 2', 'debit', 'tidak_pen', '2021-08-19 02:51:15', '2021-08-19 02:51:15'),
(326, 1, '92.04.00', 'Beban Kematian', 'debit', 'tidak_pen', '2021-08-19 02:51:26', '2021-08-19 02:51:26'),
(327, 1, '92.04.01', 'Beban Kematian Manager', 'debit', 'tidak_pen', '2021-08-19 02:51:37', '2021-08-19 02:51:37'),
(328, 1, '92.04.02', 'Beban Kematian Koordinator Lapangan', 'debit', 'tidak_pen', '2021-08-19 02:51:48', '2021-08-19 02:51:48'),
(329, 1, '92.04.03', 'Beban kematian Pegawai Honorer 1', 'debit', 'tidak_pen', '2021-08-19 02:51:59', '2021-08-19 02:51:59'),
(330, 1, '92.04.04', 'Beban Kematian Pegawai Honorer 2', 'debit', 'tidak_pen', '2021-08-19 02:52:13', '2021-08-19 02:52:13'),
(331, 1, '93.01.00', 'Beban Kantor', 'debit', 'tidak_pen', '2021-08-19 02:52:28', '2021-08-19 02:52:28'),
(332, 1, '94.01.00', 'Beban Penelitian Dan Pengembangan', 'debit', 'tidak_pen', '2021-08-19 02:52:39', '2021-08-19 02:52:39'),
(333, 1, '95.01.00', 'Beban Keuangan', 'debit', 'tidak_pen', '2021-08-19 02:52:49', '2021-08-19 02:52:49'),
(334, 1, '96.01.00', 'Beban Pemeliharaan', 'debit', 'tidak_pen', '2021-08-19 02:53:01', '2021-08-19 02:53:01'),
(335, 1, '97.01.00', 'Rupa-Rupa Beban Umum', 'debit', 'tidak_pen', '2021-08-19 02:53:14', '2021-08-19 02:53:14'),
(337, 1, '91.06.01', 'Beban Baut Tepingan', 'debit', 'penyesuaian', '2021-08-19 10:25:53', '2021-08-19 10:25:53'),
(338, 1, '15.01.01', 'Baut Tepingan', 'debit', 'penyesuaian', '2021-08-19 10:26:20', '2021-08-19 10:26:20'),
(341, 1, '70.08.00', 'Ikhtisar Laba Rugi', NULL, 'tidak_pen', NULL, NULL),
(342, 1, '70.07.01', 'Saldo Laba', 'debit', 'tidak_pen', '2021-09-01 17:01:17', '2021-09-01 17:01:17'),
(343, 1, '70.07.02', 'Saldo Rugi', 'kredit', 'tidak_pen', '2021-09-01 17:01:37', '2021-09-01 17:01:37'),
(349, 1, '91.15.06', 'Beban Pajak Final', 'debit', 'tidak_pen', '2021-09-07 14:47:07', '2021-09-07 14:47:07');

-- --------------------------------------------------------

--
-- Table structure for table `asetlains`
--

CREATE TABLE `asetlains` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_akun` bigint(20) UNSIGNED NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asetleasings`
--

CREATE TABLE `asetleasings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_akun` bigint(20) UNSIGNED NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asets`
--

CREATE TABLE `asets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `nama_aset` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nilai_aset` bigint(20) NOT NULL,
  `jumlah_unit` int(11) NOT NULL,
  `total_harga` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asettetaps`
--

CREATE TABLE `asettetaps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_akun` bigint(20) UNSIGNED NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asettidakberwujuds`
--

CREATE TABLE `asettidakberwujuds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_akun` bigint(20) UNSIGNED NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bukubesarpenyesuaians`
--

CREATE TABLE `bukubesarpenyesuaians` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_akun` bigint(20) UNSIGNED NOT NULL,
  `debit` int(11) DEFAULT NULL,
  `kredit` int(11) DEFAULT NULL,
  `saldo` int(11) DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bukubesarpenyesuaians`
--

INSERT INTO `bukubesarpenyesuaians` (`id`, `id_akun`, `debit`, `kredit`, `saldo`, `keterangan`, `created_at`, `updated_at`) VALUES
(7, 1, 0, NULL, 0, 'Saldo Awal', '2021-08-18 04:57:41', '2021-08-18 04:57:41'),
(8, 2, 0, NULL, 0, 'Saldo Awal', '2021-08-18 04:58:13', '2021-08-18 04:58:13'),
(9, 3, 0, NULL, 0, 'Saldo Awal', '2021-08-18 04:59:05', '2021-08-18 04:59:05'),
(10, 4, NULL, 0, 0, 'Saldo Awal', '2021-08-18 04:59:48', '2021-08-18 04:59:48'),
(11, 5, NULL, 0, 0, 'Saldo Awal', '2021-08-18 05:00:25', '2021-08-18 05:00:25'),
(12, 6, NULL, 0, 0, 'Saldo Awal', '2021-08-18 05:00:47', '2021-08-18 05:00:47'),
(13, 7, NULL, 0, 0, 'Saldo Awal', '2021-08-18 05:01:36', '2021-08-18 05:01:36'),
(14, 8, NULL, 0, 0, 'Saldo Awal', '2021-08-18 05:03:32', '2021-08-18 05:03:32'),
(15, 9, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:03:58', '2021-08-18 05:03:58'),
(16, 10, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:06:06', '2021-08-18 05:06:06'),
(17, 11, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:06:50', '2021-08-18 05:06:50'),
(18, 12, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:07:23', '2021-08-18 05:07:23'),
(19, 13, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:07:59', '2021-08-18 05:07:59'),
(20, 14, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:08:54', '2021-08-18 05:08:54'),
(21, 15, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:09:22', '2021-08-18 05:09:22'),
(22, 16, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:09:45', '2021-08-18 05:09:45'),
(23, 17, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:10:07', '2021-08-18 05:10:07'),
(24, 18, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:10:33', '2021-08-18 05:10:33'),
(25, 19, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:10:54', '2021-08-18 05:10:54'),
(26, 20, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:11:14', '2021-08-18 05:11:14'),
(27, 21, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:11:43', '2021-08-18 05:11:43'),
(28, 22, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:12:04', '2021-08-18 05:12:04'),
(29, 23, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:12:28', '2021-08-18 05:12:28'),
(30, 24, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:12:52', '2021-08-18 05:12:52'),
(31, 25, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:13:26', '2021-08-18 05:13:26'),
(32, 26, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:13:50', '2021-08-18 05:13:50'),
(34, 28, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:14:49', '2021-08-18 05:14:49'),
(35, 29, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:15:11', '2021-08-18 05:15:11'),
(36, 30, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:15:34', '2021-08-18 05:15:34'),
(37, 31, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:15:54', '2021-08-18 05:15:54'),
(38, 32, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:16:14', '2021-08-18 05:16:14'),
(39, 34, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:19:27', '2021-08-18 05:19:27'),
(40, 35, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:19:49', '2021-08-18 05:19:49'),
(41, 36, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:20:41', '2021-08-18 05:20:41'),
(42, 37, 0, NULL, 0, 'Saldo Awal', '2021-08-18 08:10:18', '2021-08-18 08:10:18'),
(43, 38, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:31:24', '2021-08-19 00:31:24'),
(44, 39, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:32:12', '2021-08-19 00:32:12'),
(45, 40, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:32:33', '2021-08-19 00:32:33'),
(46, 41, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:32:57', '2021-08-19 00:32:57'),
(47, 42, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:33:15', '2021-08-19 00:33:15'),
(48, 43, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:33:36', '2021-08-19 00:33:36'),
(49, 44, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:33:52', '2021-08-19 00:33:52'),
(50, 45, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:34:08', '2021-08-19 00:34:08'),
(51, 46, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:34:23', '2021-08-19 00:34:23'),
(52, 47, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:34:38', '2021-08-19 00:34:38'),
(53, 48, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:34:54', '2021-08-19 00:34:54'),
(54, 49, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:35:09', '2021-08-19 00:35:09'),
(55, 50, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:35:25', '2021-08-19 00:35:25'),
(56, 51, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:35:40', '2021-08-19 00:35:40'),
(57, 52, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:35:54', '2021-08-19 00:35:54'),
(58, 53, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:36:57', '2021-08-19 00:36:57'),
(59, 54, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:37:15', '2021-08-19 00:37:15'),
(60, 55, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:37:31', '2021-08-19 00:37:31'),
(61, 56, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:37:46', '2021-08-19 00:37:46'),
(62, 57, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:38:05', '2021-08-19 00:38:05'),
(63, 58, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:38:21', '2021-08-19 00:38:21'),
(64, 59, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:38:37', '2021-08-19 00:38:37'),
(65, 60, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:38:51', '2021-08-19 00:38:51'),
(66, 61, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:39:06', '2021-08-19 00:39:06'),
(67, 62, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:39:22', '2021-08-19 00:39:22'),
(68, 63, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:39:51', '2021-08-19 00:39:51'),
(69, 64, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:41:19', '2021-08-19 00:41:19'),
(70, 65, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:41:34', '2021-08-19 00:41:34'),
(71, 66, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:41:52', '2021-08-19 00:41:52'),
(72, 67, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:42:10', '2021-08-19 00:42:10'),
(73, 68, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:42:26', '2021-08-19 00:42:26'),
(74, 69, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:42:41', '2021-08-19 00:42:41'),
(75, 70, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:42:56', '2021-08-19 00:42:56'),
(76, 71, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:43:10', '2021-08-19 00:43:10'),
(77, 72, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:43:26', '2021-08-19 00:43:26'),
(78, 73, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:43:40', '2021-08-19 00:43:40'),
(79, 74, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:43:56', '2021-08-19 00:43:56'),
(80, 75, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:44:12', '2021-08-19 00:44:12'),
(81, 76, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:44:28', '2021-08-19 00:44:28'),
(82, 77, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:44:41', '2021-08-19 00:44:41'),
(83, 78, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:44:57', '2021-08-19 00:44:57'),
(84, 79, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:45:10', '2021-08-19 00:45:10'),
(85, 80, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:45:23', '2021-08-19 00:45:23'),
(86, 81, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:45:39', '2021-08-19 00:45:39'),
(87, 82, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:45:58', '2021-08-19 00:45:58'),
(88, 83, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:46:14', '2021-08-19 00:46:14'),
(89, 84, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:46:28', '2021-08-19 00:46:28'),
(90, 85, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:46:46', '2021-08-19 00:46:46'),
(91, 86, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:47:00', '2021-08-19 00:47:00'),
(92, 87, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:47:16', '2021-08-19 00:47:16'),
(93, 88, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:47:31', '2021-08-19 00:47:31'),
(94, 89, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:47:45', '2021-08-19 00:47:45'),
(95, 90, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:48:04', '2021-08-19 00:48:04'),
(96, 91, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:48:19', '2021-08-19 00:48:19'),
(97, 92, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:48:37', '2021-08-19 00:48:37'),
(98, 93, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:48:54', '2021-08-19 00:48:54'),
(99, 94, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:49:08', '2021-08-19 00:49:08'),
(100, 95, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:49:22', '2021-08-19 00:49:22'),
(101, 96, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:49:37', '2021-08-19 00:49:37'),
(102, 97, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:49:52', '2021-08-19 00:49:52'),
(103, 98, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:50:07', '2021-08-19 00:50:07'),
(104, 99, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:50:21', '2021-08-19 00:50:21'),
(105, 100, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:50:37', '2021-08-19 00:50:37'),
(106, 101, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:50:49', '2021-08-19 00:50:49'),
(107, 102, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:51:03', '2021-08-19 00:51:03'),
(108, 103, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:51:17', '2021-08-19 00:51:17'),
(109, 104, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:51:30', '2021-08-19 00:51:30'),
(110, 105, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:51:46', '2021-08-19 00:51:46'),
(111, 106, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:51:59', '2021-08-19 00:51:59'),
(112, 107, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:52:12', '2021-08-19 00:52:12'),
(113, 108, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:52:41', '2021-08-19 00:52:41'),
(114, 109, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:52:55', '2021-08-19 00:52:55'),
(115, 110, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:53:08', '2021-08-19 00:53:08'),
(116, 111, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:53:24', '2021-08-19 00:53:24'),
(117, 112, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:53:38', '2021-08-19 00:53:38'),
(118, 113, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:53:51', '2021-08-19 00:53:51'),
(119, 114, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:54:05', '2021-08-19 00:54:05'),
(120, 115, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:54:19', '2021-08-19 00:54:19'),
(121, 116, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:54:33', '2021-08-19 00:54:33'),
(122, 117, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:54:49', '2021-08-19 00:54:49'),
(123, 118, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:56:36', '2021-08-19 00:56:36'),
(124, 119, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:56:49', '2021-08-19 00:56:49'),
(125, 120, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:57:02', '2021-08-19 00:57:02'),
(126, 121, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:57:15', '2021-08-19 00:57:15'),
(127, 122, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:57:31', '2021-08-19 00:57:31'),
(128, 123, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:57:47', '2021-08-19 00:57:47'),
(129, 124, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:57:58', '2021-08-19 00:57:58'),
(130, 125, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:58:12', '2021-08-19 00:58:12'),
(131, 126, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:58:25', '2021-08-19 00:58:25'),
(132, 127, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:58:39', '2021-08-19 00:58:39'),
(133, 128, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:15:22', '2021-08-19 01:15:22'),
(134, 129, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:15:42', '2021-08-19 01:15:42'),
(135, 130, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:15:59', '2021-08-19 01:15:59'),
(136, 131, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:16:15', '2021-08-19 01:16:15'),
(137, 132, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:16:28', '2021-08-19 01:16:28'),
(138, 133, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:16:41', '2021-08-19 01:16:41'),
(139, 134, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:16:55', '2021-08-19 01:16:55'),
(140, 135, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:17:09', '2021-08-19 01:17:09'),
(141, 136, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:17:22', '2021-08-19 01:17:22'),
(142, 137, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:17:36', '2021-08-19 01:17:36'),
(143, 138, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:17:50', '2021-08-19 01:17:50'),
(144, 139, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:18:04', '2021-08-19 01:18:04'),
(145, 140, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:18:18', '2021-08-19 01:18:18'),
(146, 141, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:18:32', '2021-08-19 01:18:32'),
(147, 142, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:18:45', '2021-08-19 01:18:45'),
(148, 143, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:18:58', '2021-08-19 01:18:58'),
(149, 144, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:19:11', '2021-08-19 01:19:11'),
(150, 145, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:19:23', '2021-08-19 01:19:23'),
(151, 146, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:19:36', '2021-08-19 01:19:36'),
(152, 147, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:19:49', '2021-08-19 01:19:49'),
(153, 148, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:20:04', '2021-08-19 01:20:04'),
(154, 149, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:20:17', '2021-08-19 01:20:17'),
(155, 150, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:20:30', '2021-08-19 01:20:30'),
(156, 151, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:20:43', '2021-08-19 01:20:43'),
(157, 152, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:20:57', '2021-08-19 01:20:57'),
(158, 153, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:21:09', '2021-08-19 01:21:09'),
(159, 154, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:21:25', '2021-08-19 01:21:25'),
(160, 155, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:21:41', '2021-08-19 01:21:41'),
(161, 156, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:22:04', '2021-08-19 01:22:04'),
(162, 157, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:25:03', '2021-08-19 01:25:03'),
(163, 158, NULL, 0, 0, 'Saldo Awal', '2021-08-19 01:25:40', '2021-08-19 01:25:40'),
(164, 159, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:26:02', '2021-08-19 01:26:02'),
(165, 160, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:44:34', '2021-08-19 01:44:34'),
(166, 161, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:44:49', '2021-08-19 01:44:49'),
(167, 162, NULL, 0, 0, 'Saldo Awal', '2021-08-19 01:45:04', '2021-08-19 01:45:04'),
(168, 163, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:45:46', '2021-08-19 01:45:46'),
(169, 164, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:47:49', '2021-08-19 01:47:49'),
(170, 165, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:48:55', '2021-08-19 01:48:55'),
(171, 166, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:49:12', '2021-08-19 01:49:12'),
(172, 167, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:49:25', '2021-08-19 01:49:25'),
(173, 168, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:49:41', '2021-08-19 01:49:41'),
(174, 169, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:49:54', '2021-08-19 01:49:54'),
(175, 170, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:50:20', '2021-08-19 01:50:20'),
(176, 171, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:51:23', '2021-08-19 01:51:23'),
(177, 172, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:51:44', '2021-08-19 01:51:44'),
(178, 173, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:51:58', '2021-08-19 01:51:58'),
(179, 174, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:52:11', '2021-08-19 01:52:11'),
(180, 175, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:52:26', '2021-08-19 01:52:26'),
(181, 176, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:52:41', '2021-08-19 01:52:41'),
(182, 177, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:53:42', '2021-08-19 01:53:42'),
(183, 178, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:53:56', '2021-08-19 01:53:56'),
(184, 179, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:54:14', '2021-08-19 01:54:14'),
(185, 180, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:54:56', '2021-08-19 01:54:56'),
(186, 181, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:55:09', '2021-08-19 01:55:09'),
(187, 182, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:55:22', '2021-08-19 01:55:22'),
(188, 183, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:55:34', '2021-08-19 01:55:34'),
(189, 184, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:55:47', '2021-08-19 01:55:47'),
(190, 185, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:56:00', '2021-08-19 01:56:00'),
(191, 186, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:56:14', '2021-08-19 01:56:14'),
(192, 187, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:58:08', '2021-08-19 01:58:08'),
(193, 188, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:58:25', '2021-08-19 01:58:25'),
(194, 189, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:58:38', '2021-08-19 01:58:38'),
(195, 190, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:58:54', '2021-08-19 01:58:54'),
(196, 191, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:59:07', '2021-08-19 01:59:07'),
(197, 192, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:59:20', '2021-08-19 01:59:20'),
(198, 193, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:59:34', '2021-08-19 01:59:34'),
(199, 194, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:59:55', '2021-08-19 01:59:55'),
(200, 195, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:00:16', '2021-08-19 02:00:16'),
(201, 196, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:00:30', '2021-08-19 02:00:30'),
(202, 197, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:00:41', '2021-08-19 02:00:41'),
(203, 198, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:00:55', '2021-08-19 02:00:55'),
(204, 199, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:01:07', '2021-08-19 02:01:07'),
(205, 200, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:01:20', '2021-08-19 02:01:20'),
(206, 201, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:01:32', '2021-08-19 02:01:32'),
(207, 202, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:01:45', '2021-08-19 02:01:45'),
(208, 203, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:01:59', '2021-08-19 02:01:59'),
(209, 204, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:02:14', '2021-08-19 02:02:14'),
(210, 205, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:02:25', '2021-08-19 02:02:25'),
(211, 206, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:02:40', '2021-08-19 02:02:40'),
(212, 207, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:02:53', '2021-08-19 02:02:53'),
(213, 208, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:03:06', '2021-08-19 02:03:06'),
(214, 209, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:03:26', '2021-08-19 02:03:26'),
(215, 210, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:04:18', '2021-08-19 02:04:18'),
(216, 211, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:04:37', '2021-08-19 02:04:37'),
(217, 212, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:04:53', '2021-08-19 02:04:53'),
(218, 213, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:05:07', '2021-08-19 02:05:07'),
(219, 214, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:05:24', '2021-08-19 02:05:24'),
(220, 215, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:05:39', '2021-08-19 02:05:39'),
(221, 216, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:06:31', '2021-08-19 02:06:31'),
(222, 217, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:06:43', '2021-08-19 02:06:43'),
(223, 218, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:06:56', '2021-08-19 02:06:56'),
(224, 219, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:07:15', '2021-08-19 02:07:15'),
(225, 220, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:07:26', '2021-08-19 02:07:26'),
(226, 221, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:07:39', '2021-08-19 02:07:39'),
(227, 222, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:07:50', '2021-08-19 02:07:50'),
(228, 223, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:11:11', '2021-08-19 02:11:11'),
(229, 224, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:11:26', '2021-08-19 02:11:26'),
(230, 225, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:11:38', '2021-08-19 02:11:38'),
(231, 226, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:12:10', '2021-08-19 02:12:10'),
(232, 227, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:12:23', '2021-08-19 02:12:23'),
(234, 229, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:14:33', '2021-08-19 02:14:33'),
(235, 230, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:14:49', '2021-08-19 02:14:49'),
(236, 231, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:15:01', '2021-08-19 02:15:01'),
(237, 232, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:15:14', '2021-08-19 02:15:14'),
(238, 233, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:17:53', '2021-08-19 02:17:53'),
(239, 234, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:18:10', '2021-08-19 02:18:10'),
(240, 235, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:18:31', '2021-08-19 02:18:31'),
(241, 236, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:18:45', '2021-08-19 02:18:45'),
(242, 237, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:18:58', '2021-08-19 02:18:58'),
(243, 238, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:19:11', '2021-08-19 02:19:11'),
(244, 239, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:19:35', '2021-08-19 02:19:35'),
(245, 241, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:20:58', '2021-08-19 02:20:58'),
(246, 242, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:21:14', '2021-08-19 02:21:14'),
(247, 243, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:22:01', '2021-08-19 02:22:01'),
(248, 244, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:22:13', '2021-08-19 02:22:13'),
(249, 245, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:22:59', '2021-08-19 02:22:59'),
(250, 246, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:23:11', '2021-08-19 02:23:11'),
(251, 247, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:23:26', '2021-08-19 02:23:26'),
(252, 248, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:23:37', '2021-08-19 02:23:37'),
(253, 249, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:23:49', '2021-08-19 02:23:49'),
(254, 250, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:24:02', '2021-08-19 02:24:02'),
(255, 251, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:24:14', '2021-08-19 02:24:14'),
(256, 252, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:24:26', '2021-08-19 02:24:26'),
(257, 253, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:24:37', '2021-08-19 02:24:37'),
(258, 254, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:24:52', '2021-08-19 02:24:52'),
(259, 255, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:25:07', '2021-08-19 02:25:07'),
(260, 256, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:26:13', '2021-08-19 02:26:13'),
(261, 257, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:26:28', '2021-08-19 02:26:28'),
(262, 258, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:26:40', '2021-08-19 02:26:40'),
(263, 259, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:26:51', '2021-08-19 02:26:51'),
(264, 260, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:27:10', '2021-08-19 02:27:10'),
(265, 261, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:27:33', '2021-08-19 02:27:33'),
(266, 262, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:27:46', '2021-08-19 02:27:46'),
(267, 263, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:28:00', '2021-08-19 02:28:00'),
(268, 264, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:28:14', '2021-08-19 02:28:14'),
(269, 265, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:28:33', '2021-08-19 02:28:33'),
(270, 266, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:28:46', '2021-08-19 02:28:46'),
(271, 267, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:28:58', '2021-08-19 02:28:58'),
(272, 268, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:29:10', '2021-08-19 02:29:10'),
(273, 269, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:30:00', '2021-08-19 02:30:00'),
(274, 270, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:30:15', '2021-08-19 02:30:15'),
(275, 271, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:30:37', '2021-08-19 02:30:37'),
(276, 272, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:31:21', '2021-08-19 02:31:21'),
(277, 273, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:31:48', '2021-08-19 02:31:48'),
(278, 274, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:32:02', '2021-08-19 02:32:02'),
(279, 275, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:32:14', '2021-08-19 02:32:14'),
(280, 276, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:34:02', '2021-08-19 02:34:02'),
(281, 277, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:34:55', '2021-08-19 02:34:55'),
(282, 278, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:35:08', '2021-08-19 02:35:08'),
(283, 279, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:35:21', '2021-08-19 02:35:21'),
(284, 280, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:35:34', '2021-08-19 02:35:34'),
(285, 281, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:35:48', '2021-08-19 02:35:48'),
(286, 282, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:36:01', '2021-08-19 02:36:01'),
(287, 283, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:36:13', '2021-08-19 02:36:13'),
(288, 284, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:36:25', '2021-08-19 02:36:25'),
(289, 285, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:36:38', '2021-08-19 02:36:38'),
(290, 286, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:36:50', '2021-08-19 02:36:50'),
(291, 287, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:37:02', '2021-08-19 02:37:02'),
(292, 288, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:37:13', '2021-08-19 02:37:13'),
(293, 289, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:38:12', '2021-08-19 02:38:12'),
(294, 290, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:38:23', '2021-08-19 02:38:23'),
(295, 291, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:38:35', '2021-08-19 02:38:35'),
(296, 292, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:38:52', '2021-08-19 02:38:52'),
(297, 293, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:39:02', '2021-08-19 02:39:02'),
(298, 294, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:39:14', '2021-08-19 02:39:14'),
(299, 295, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:39:26', '2021-08-19 02:39:26'),
(300, 296, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:39:39', '2021-08-19 02:39:39'),
(301, 297, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:39:53', '2021-08-19 02:39:53'),
(302, 298, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:40:10', '2021-08-19 02:40:10'),
(303, 299, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:40:37', '2021-08-19 02:40:37'),
(304, 300, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:40:50', '2021-08-19 02:40:50'),
(305, 301, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:41:21', '2021-08-19 02:41:21'),
(306, 302, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:41:35', '2021-08-19 02:41:35'),
(307, 303, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:41:49', '2021-08-19 02:41:49'),
(308, 304, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:42:01', '2021-08-19 02:42:01'),
(309, 305, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:42:12', '2021-08-19 02:42:12'),
(310, 306, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:42:23', '2021-08-19 02:42:23'),
(311, 307, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:42:35', '2021-08-19 02:42:35'),
(312, 308, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:42:47', '2021-08-19 02:42:47'),
(313, 309, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:42:58', '2021-08-19 02:42:58'),
(314, 310, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:43:09', '2021-08-19 02:43:09'),
(315, 311, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:46:26', '2021-08-19 02:46:26'),
(316, 312, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:47:04', '2021-08-19 02:47:04'),
(317, 313, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:47:17', '2021-08-19 02:47:17'),
(318, 314, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:47:29', '2021-08-19 02:47:29'),
(319, 315, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:47:41', '2021-08-19 02:47:41'),
(320, 316, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:47:57', '2021-08-19 02:47:57'),
(321, 317, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:48:09', '2021-08-19 02:48:09'),
(322, 318, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:48:23', '2021-08-19 02:48:23'),
(323, 319, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:48:36', '2021-08-19 02:48:36'),
(324, 320, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:48:48', '2021-08-19 02:48:48'),
(325, 321, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:49:00', '2021-08-19 02:49:00'),
(326, 322, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:49:39', '2021-08-19 02:49:39'),
(327, 323, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:50:53', '2021-08-19 02:50:53'),
(328, 324, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:51:04', '2021-08-19 02:51:04'),
(329, 325, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:51:15', '2021-08-19 02:51:15'),
(330, 326, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:51:26', '2021-08-19 02:51:26'),
(331, 327, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:51:37', '2021-08-19 02:51:37'),
(332, 328, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:51:48', '2021-08-19 02:51:48'),
(333, 329, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:51:59', '2021-08-19 02:51:59'),
(334, 330, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:52:13', '2021-08-19 02:52:13'),
(335, 331, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:52:28', '2021-08-19 02:52:28'),
(336, 332, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:52:39', '2021-08-19 02:52:39'),
(337, 333, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:52:49', '2021-08-19 02:52:49'),
(338, 334, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:53:01', '2021-08-19 02:53:01'),
(339, 335, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:53:14', '2021-08-19 02:53:14'),
(341, 337, 0, NULL, 0, 'Saldo Awal', '2021-08-19 10:25:54', '2021-08-19 10:25:54'),
(342, 338, 0, NULL, 0, 'Saldo Awal', '2021-08-19 10:26:20', '2021-08-19 10:26:20'),
(475, 349, NULL, NULL, NULL, 'Saldo Awal', '2021-09-07 14:47:07', '2021-09-07 14:47:07');

-- --------------------------------------------------------

--
-- Table structure for table `bukubesars`
--

CREATE TABLE `bukubesars` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_akun` bigint(20) UNSIGNED NOT NULL,
  `debit` bigint(20) DEFAULT NULL,
  `kredit` bigint(20) DEFAULT NULL,
  `saldo` bigint(20) NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bukubesars`
--

INSERT INTO `bukubesars` (`id`, `id_akun`, `debit`, `kredit`, `saldo`, `keterangan`, `created_at`, `updated_at`) VALUES
(7, 1, 0, NULL, 0, 'Saldo Awal', '2021-08-18 04:57:41', '2021-08-18 04:57:41'),
(8, 2, 0, NULL, 0, 'Saldo Awal', '2021-08-18 04:58:13', '2021-08-18 04:58:13'),
(9, 3, 0, NULL, 0, 'Saldo Awal', '2021-08-18 04:59:05', '2021-08-18 04:59:05'),
(10, 4, NULL, 0, 0, 'Saldo Awal', '2021-08-18 04:59:48', '2021-08-18 04:59:48'),
(11, 5, NULL, 0, 0, 'Saldo Awal', '2021-08-18 05:00:25', '2021-08-18 05:00:25'),
(12, 6, NULL, 0, 0, 'Saldo Awal', '2021-08-18 05:00:47', '2021-08-18 05:00:47'),
(13, 7, NULL, 0, 0, 'Saldo Awal', '2021-08-18 05:01:36', '2021-08-18 05:01:36'),
(14, 8, NULL, 0, 0, 'Saldo Awal', '2021-08-18 05:03:32', '2021-08-18 05:03:32'),
(15, 9, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:03:58', '2021-08-18 05:03:58'),
(16, 10, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:06:06', '2021-08-18 05:06:06'),
(17, 11, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:06:50', '2021-08-18 05:06:50'),
(18, 12, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:07:23', '2021-08-18 05:07:23'),
(19, 13, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:07:59', '2021-08-18 05:07:59'),
(20, 14, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:08:54', '2021-08-18 05:08:54'),
(21, 15, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:09:22', '2021-08-18 05:09:22'),
(22, 16, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:09:45', '2021-08-18 05:09:45'),
(23, 17, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:10:07', '2021-08-18 05:10:07'),
(24, 18, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:10:33', '2021-08-18 05:10:33'),
(25, 19, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:10:54', '2021-08-18 05:10:54'),
(26, 20, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:11:14', '2021-08-18 05:11:14'),
(27, 21, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:11:43', '2021-08-18 05:11:43'),
(28, 22, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:12:04', '2021-08-18 05:12:04'),
(29, 23, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:12:28', '2021-08-18 05:12:28'),
(30, 24, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:12:52', '2021-08-18 05:12:52'),
(31, 25, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:13:26', '2021-08-18 05:13:26'),
(32, 26, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:13:50', '2021-08-18 05:13:50'),
(34, 28, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:14:49', '2021-08-18 05:14:49'),
(35, 29, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:15:11', '2021-08-18 05:15:11'),
(36, 30, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:15:34', '2021-08-18 05:15:34'),
(37, 31, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:15:54', '2021-08-18 05:15:54'),
(38, 32, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:16:14', '2021-08-18 05:16:14'),
(39, 34, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:19:27', '2021-08-18 05:19:27'),
(40, 35, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:19:49', '2021-08-18 05:19:49'),
(41, 36, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:20:41', '2021-08-18 05:20:41'),
(42, 37, 0, NULL, 0, 'Saldo Awal', '2021-08-18 08:10:18', '2021-08-18 08:10:18'),
(43, 38, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:31:24', '2021-08-19 00:31:24'),
(44, 39, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:32:12', '2021-08-19 00:32:12'),
(45, 40, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:32:33', '2021-08-19 00:32:33'),
(46, 41, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:32:57', '2021-08-19 00:32:57'),
(47, 42, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:33:15', '2021-08-19 00:33:15'),
(48, 43, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:33:36', '2021-08-19 00:33:36'),
(49, 44, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:33:52', '2021-08-19 00:33:52'),
(50, 45, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:34:08', '2021-08-19 00:34:08'),
(51, 46, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:34:23', '2021-08-19 00:34:23'),
(52, 47, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:34:38', '2021-08-19 00:34:38'),
(53, 48, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:34:54', '2021-08-19 00:34:54'),
(54, 49, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:35:09', '2021-08-19 00:35:09'),
(55, 50, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:35:25', '2021-08-19 00:35:25'),
(56, 51, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:35:40', '2021-08-19 00:35:40'),
(57, 52, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:35:54', '2021-08-19 00:35:54'),
(58, 53, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:36:57', '2021-08-19 00:36:57'),
(59, 54, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:37:15', '2021-08-19 00:37:15'),
(60, 55, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:37:31', '2021-08-19 00:37:31'),
(61, 56, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:37:46', '2021-08-19 00:37:46'),
(62, 57, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:38:05', '2021-08-19 00:38:05'),
(63, 58, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:38:21', '2021-08-19 00:38:21'),
(64, 59, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:38:37', '2021-08-19 00:38:37'),
(65, 60, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:38:51', '2021-08-19 00:38:51'),
(66, 61, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:39:06', '2021-08-19 00:39:06'),
(67, 62, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:39:22', '2021-08-19 00:39:22'),
(68, 63, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:39:51', '2021-08-19 00:39:51'),
(69, 64, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:41:19', '2021-08-19 00:41:19'),
(70, 65, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:41:34', '2021-08-19 00:41:34'),
(71, 66, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:41:52', '2021-08-19 00:41:52'),
(72, 67, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:42:10', '2021-08-19 00:42:10'),
(73, 68, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:42:26', '2021-08-19 00:42:26'),
(74, 69, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:42:41', '2021-08-19 00:42:41'),
(75, 70, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:42:56', '2021-08-19 00:42:56'),
(76, 71, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:43:10', '2021-08-19 00:43:10'),
(77, 72, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:43:26', '2021-08-19 00:43:26'),
(78, 73, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:43:40', '2021-08-19 00:43:40'),
(79, 74, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:43:56', '2021-08-19 00:43:56'),
(80, 75, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:44:12', '2021-08-19 00:44:12'),
(81, 76, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:44:28', '2021-08-19 00:44:28'),
(82, 77, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:44:41', '2021-08-19 00:44:41'),
(83, 78, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:44:57', '2021-08-19 00:44:57'),
(84, 79, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:45:10', '2021-08-19 00:45:10'),
(85, 80, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:45:23', '2021-08-19 00:45:23'),
(86, 81, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:45:39', '2021-08-19 00:45:39'),
(87, 82, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:45:58', '2021-08-19 00:45:58'),
(88, 83, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:46:14', '2021-08-19 00:46:14'),
(89, 84, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:46:28', '2021-08-19 00:46:28'),
(90, 85, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:46:46', '2021-08-19 00:46:46'),
(91, 86, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:47:00', '2021-08-19 00:47:00'),
(92, 87, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:47:16', '2021-08-19 00:47:16'),
(93, 88, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:47:31', '2021-08-19 00:47:31'),
(94, 89, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:47:45', '2021-08-19 00:47:45'),
(95, 90, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:48:04', '2021-08-19 00:48:04'),
(96, 91, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:48:19', '2021-08-19 00:48:19'),
(97, 92, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:48:37', '2021-08-19 00:48:37'),
(98, 93, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:48:54', '2021-08-19 00:48:54'),
(99, 94, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:49:08', '2021-08-19 00:49:08'),
(100, 95, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:49:22', '2021-08-19 00:49:22'),
(101, 96, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:49:37', '2021-08-19 00:49:37'),
(102, 97, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:49:52', '2021-08-19 00:49:52'),
(103, 98, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:50:07', '2021-08-19 00:50:07'),
(104, 99, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:50:21', '2021-08-19 00:50:21'),
(105, 100, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:50:37', '2021-08-19 00:50:37'),
(106, 101, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:50:49', '2021-08-19 00:50:49'),
(107, 102, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:51:03', '2021-08-19 00:51:03'),
(108, 103, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:51:17', '2021-08-19 00:51:17'),
(109, 104, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:51:30', '2021-08-19 00:51:30'),
(110, 105, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:51:46', '2021-08-19 00:51:46'),
(111, 106, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:51:59', '2021-08-19 00:51:59'),
(112, 107, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:52:12', '2021-08-19 00:52:12'),
(113, 108, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:52:41', '2021-08-19 00:52:41'),
(114, 109, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:52:55', '2021-08-19 00:52:55'),
(115, 110, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:53:08', '2021-08-19 00:53:08'),
(116, 111, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:53:24', '2021-08-19 00:53:24'),
(117, 112, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:53:38', '2021-08-19 00:53:38'),
(118, 113, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:53:51', '2021-08-19 00:53:51'),
(119, 114, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:54:05', '2021-08-19 00:54:05'),
(120, 115, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:54:19', '2021-08-19 00:54:19'),
(121, 116, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:54:33', '2021-08-19 00:54:33'),
(122, 117, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:54:49', '2021-08-19 00:54:49'),
(123, 118, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:56:36', '2021-08-19 00:56:36'),
(124, 119, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:56:49', '2021-08-19 00:56:49'),
(125, 120, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:57:02', '2021-08-19 00:57:02'),
(126, 121, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:57:15', '2021-08-19 00:57:15'),
(127, 122, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:57:31', '2021-08-19 00:57:31'),
(128, 123, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:57:47', '2021-08-19 00:57:47'),
(129, 124, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:57:58', '2021-08-19 00:57:58'),
(130, 125, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:58:12', '2021-08-19 00:58:12'),
(131, 126, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:58:25', '2021-08-19 00:58:25'),
(132, 127, 0, NULL, 0, 'Saldo Awal', '2021-08-19 00:58:39', '2021-08-19 00:58:39'),
(133, 128, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:15:22', '2021-08-19 01:15:22'),
(134, 129, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:15:42', '2021-08-19 01:15:42'),
(135, 130, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:15:59', '2021-08-19 01:15:59'),
(136, 131, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:16:15', '2021-08-19 01:16:15'),
(137, 132, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:16:28', '2021-08-19 01:16:28'),
(138, 133, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:16:41', '2021-08-19 01:16:41'),
(139, 134, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:16:55', '2021-08-19 01:16:55'),
(140, 135, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:17:09', '2021-08-19 01:17:09'),
(141, 136, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:17:22', '2021-08-19 01:17:22'),
(142, 137, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:17:36', '2021-08-19 01:17:36'),
(143, 138, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:17:50', '2021-08-19 01:17:50'),
(144, 139, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:18:04', '2021-08-19 01:18:04'),
(145, 140, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:18:18', '2021-08-19 01:18:18'),
(146, 141, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:18:32', '2021-08-19 01:18:32'),
(147, 142, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:18:45', '2021-08-19 01:18:45'),
(148, 143, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:18:58', '2021-08-19 01:18:58'),
(149, 144, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:19:11', '2021-08-19 01:19:11'),
(150, 145, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:19:23', '2021-08-19 01:19:23'),
(151, 146, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:19:36', '2021-08-19 01:19:36'),
(152, 147, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:19:49', '2021-08-19 01:19:49'),
(153, 148, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:20:04', '2021-08-19 01:20:04'),
(154, 149, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:20:17', '2021-08-19 01:20:17'),
(155, 150, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:20:30', '2021-08-19 01:20:30'),
(156, 151, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:20:43', '2021-08-19 01:20:43'),
(157, 152, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:20:57', '2021-08-19 01:20:57'),
(158, 153, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:21:09', '2021-08-19 01:21:09'),
(159, 154, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:21:25', '2021-08-19 01:21:25'),
(160, 155, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:21:41', '2021-08-19 01:21:41'),
(161, 156, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:22:04', '2021-08-19 01:22:04'),
(162, 157, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:25:03', '2021-08-19 01:25:03'),
(163, 158, NULL, 0, 0, 'Saldo Awal', '2021-08-19 01:25:40', '2021-08-19 01:25:40'),
(164, 159, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:26:02', '2021-08-19 01:26:02'),
(165, 160, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:44:34', '2021-08-19 01:44:34'),
(166, 161, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:44:49', '2021-08-19 01:44:49'),
(167, 162, NULL, 0, 0, 'Saldo Awal', '2021-08-19 01:45:04', '2021-08-19 01:45:04'),
(168, 163, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:45:46', '2021-08-19 01:45:46'),
(169, 164, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:47:49', '2021-08-19 01:47:49'),
(170, 165, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:48:55', '2021-08-19 01:48:55'),
(171, 166, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:49:12', '2021-08-19 01:49:12'),
(172, 167, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:49:25', '2021-08-19 01:49:25'),
(173, 168, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:49:41', '2021-08-19 01:49:41'),
(174, 169, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:49:54', '2021-08-19 01:49:54'),
(175, 170, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:50:20', '2021-08-19 01:50:20'),
(176, 171, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:51:23', '2021-08-19 01:51:23'),
(177, 172, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:51:44', '2021-08-19 01:51:44'),
(178, 173, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:51:58', '2021-08-19 01:51:58'),
(179, 174, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:52:11', '2021-08-19 01:52:11'),
(180, 175, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:52:26', '2021-08-19 01:52:26'),
(181, 176, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:52:41', '2021-08-19 01:52:41'),
(182, 177, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:53:42', '2021-08-19 01:53:42'),
(183, 178, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:53:56', '2021-08-19 01:53:56'),
(184, 179, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:54:14', '2021-08-19 01:54:14'),
(185, 180, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:54:56', '2021-08-19 01:54:56'),
(186, 181, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:55:09', '2021-08-19 01:55:09'),
(187, 182, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:55:22', '2021-08-19 01:55:22'),
(188, 183, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:55:34', '2021-08-19 01:55:34'),
(189, 184, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:55:47', '2021-08-19 01:55:47'),
(190, 185, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:56:00', '2021-08-19 01:56:00'),
(191, 186, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:56:14', '2021-08-19 01:56:14'),
(192, 187, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:58:08', '2021-08-19 01:58:08'),
(193, 188, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:58:25', '2021-08-19 01:58:25'),
(194, 189, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:58:38', '2021-08-19 01:58:38'),
(195, 190, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:58:54', '2021-08-19 01:58:54'),
(196, 191, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:59:07', '2021-08-19 01:59:07'),
(197, 192, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:59:20', '2021-08-19 01:59:20'),
(198, 193, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:59:34', '2021-08-19 01:59:34'),
(199, 194, 0, NULL, 0, 'Saldo Awal', '2021-08-19 01:59:55', '2021-08-19 01:59:55'),
(200, 195, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:00:16', '2021-08-19 02:00:16'),
(201, 196, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:00:30', '2021-08-19 02:00:30'),
(202, 197, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:00:41', '2021-08-19 02:00:41'),
(203, 198, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:00:55', '2021-08-19 02:00:55'),
(204, 199, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:01:07', '2021-08-19 02:01:07'),
(205, 200, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:01:20', '2021-08-19 02:01:20'),
(206, 201, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:01:32', '2021-08-19 02:01:32'),
(207, 202, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:01:45', '2021-08-19 02:01:45'),
(208, 203, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:01:59', '2021-08-19 02:01:59'),
(209, 204, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:02:14', '2021-08-19 02:02:14'),
(210, 205, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:02:25', '2021-08-19 02:02:25'),
(211, 206, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:02:40', '2021-08-19 02:02:40'),
(212, 207, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:02:53', '2021-08-19 02:02:53'),
(213, 208, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:03:06', '2021-08-19 02:03:06'),
(214, 209, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:03:26', '2021-08-19 02:03:26'),
(215, 210, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:04:18', '2021-08-19 02:04:18'),
(216, 211, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:04:37', '2021-08-19 02:04:37'),
(217, 212, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:04:53', '2021-08-19 02:04:53'),
(218, 213, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:05:07', '2021-08-19 02:05:07'),
(219, 214, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:05:24', '2021-08-19 02:05:24'),
(220, 215, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:05:39', '2021-08-19 02:05:39'),
(221, 216, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:06:31', '2021-08-19 02:06:31'),
(222, 217, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:06:43', '2021-08-19 02:06:43'),
(223, 218, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:06:56', '2021-08-19 02:06:56'),
(224, 219, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:07:15', '2021-08-19 02:07:15'),
(225, 220, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:07:26', '2021-08-19 02:07:26'),
(226, 221, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:07:39', '2021-08-19 02:07:39'),
(227, 222, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:07:50', '2021-08-19 02:07:50'),
(228, 223, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:11:11', '2021-08-19 02:11:11'),
(229, 224, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:11:26', '2021-08-19 02:11:26'),
(230, 225, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:11:38', '2021-08-19 02:11:38'),
(231, 226, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:12:10', '2021-08-19 02:12:10'),
(232, 227, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:12:23', '2021-08-19 02:12:23'),
(234, 229, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:14:33', '2021-08-19 02:14:33'),
(235, 230, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:14:49', '2021-08-19 02:14:49'),
(236, 231, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:15:01', '2021-08-19 02:15:01'),
(237, 232, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:15:14', '2021-08-19 02:15:14'),
(238, 233, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:17:53', '2021-08-19 02:17:53'),
(239, 234, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:18:10', '2021-08-19 02:18:10'),
(240, 235, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:18:31', '2021-08-19 02:18:31'),
(241, 236, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:18:45', '2021-08-19 02:18:45'),
(242, 237, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:18:58', '2021-08-19 02:18:58'),
(243, 238, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:19:11', '2021-08-19 02:19:11'),
(244, 239, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:19:35', '2021-08-19 02:19:35'),
(245, 241, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:20:58', '2021-08-19 02:20:58'),
(246, 242, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:21:14', '2021-08-19 02:21:14'),
(247, 243, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:22:01', '2021-08-19 02:22:01'),
(248, 244, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:22:13', '2021-08-19 02:22:13'),
(249, 245, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:22:59', '2021-08-19 02:22:59'),
(250, 246, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:23:11', '2021-08-19 02:23:11'),
(251, 247, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:23:26', '2021-08-19 02:23:26'),
(252, 248, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:23:37', '2021-08-19 02:23:37'),
(253, 249, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:23:49', '2021-08-19 02:23:49'),
(254, 250, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:24:02', '2021-08-19 02:24:02'),
(255, 251, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:24:14', '2021-08-19 02:24:14'),
(256, 252, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:24:26', '2021-08-19 02:24:26'),
(257, 253, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:24:37', '2021-08-19 02:24:37'),
(258, 254, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:24:52', '2021-08-19 02:24:52'),
(259, 255, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:25:07', '2021-08-19 02:25:07'),
(260, 256, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:26:13', '2021-08-19 02:26:13'),
(261, 257, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:26:28', '2021-08-19 02:26:28'),
(262, 258, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:26:40', '2021-08-19 02:26:40'),
(263, 259, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:26:51', '2021-08-19 02:26:51'),
(264, 260, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:27:10', '2021-08-19 02:27:10'),
(265, 261, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:27:33', '2021-08-19 02:27:33'),
(266, 262, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:27:46', '2021-08-19 02:27:46'),
(267, 263, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:28:00', '2021-08-19 02:28:00'),
(268, 264, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:28:14', '2021-08-19 02:28:14'),
(269, 265, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:28:33', '2021-08-19 02:28:33'),
(270, 266, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:28:46', '2021-08-19 02:28:46'),
(271, 267, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:28:58', '2021-08-19 02:28:58'),
(272, 268, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:29:10', '2021-08-19 02:29:10'),
(273, 269, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:30:00', '2021-08-19 02:30:00'),
(274, 270, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:30:15', '2021-08-19 02:30:15'),
(275, 271, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:30:37', '2021-08-19 02:30:37'),
(276, 272, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:31:21', '2021-08-19 02:31:21'),
(277, 273, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:31:48', '2021-08-19 02:31:48'),
(278, 274, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:32:02', '2021-08-19 02:32:02'),
(279, 275, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:32:14', '2021-08-19 02:32:14'),
(280, 276, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:34:02', '2021-08-19 02:34:02'),
(281, 277, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:34:55', '2021-08-19 02:34:55'),
(282, 278, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:35:08', '2021-08-19 02:35:08'),
(283, 279, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:35:21', '2021-08-19 02:35:21'),
(284, 280, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:35:34', '2021-08-19 02:35:34'),
(285, 281, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:35:48', '2021-08-19 02:35:48'),
(286, 282, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:36:01', '2021-08-19 02:36:01'),
(287, 283, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:36:13', '2021-08-19 02:36:13'),
(288, 284, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:36:25', '2021-08-19 02:36:25'),
(289, 285, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:36:38', '2021-08-19 02:36:38'),
(290, 286, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:36:50', '2021-08-19 02:36:50'),
(291, 287, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:37:02', '2021-08-19 02:37:02'),
(292, 288, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:37:13', '2021-08-19 02:37:13'),
(293, 289, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:38:12', '2021-08-19 02:38:12'),
(294, 290, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:38:23', '2021-08-19 02:38:23'),
(295, 291, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:38:35', '2021-08-19 02:38:35'),
(296, 292, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:38:52', '2021-08-19 02:38:52'),
(297, 293, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:39:02', '2021-08-19 02:39:02'),
(298, 294, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:39:14', '2021-08-19 02:39:14'),
(299, 295, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:39:26', '2021-08-19 02:39:26'),
(300, 296, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:39:39', '2021-08-19 02:39:39'),
(301, 297, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:39:53', '2021-08-19 02:39:53'),
(302, 298, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:40:10', '2021-08-19 02:40:10'),
(303, 299, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:40:37', '2021-08-19 02:40:37'),
(304, 300, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:40:50', '2021-08-19 02:40:50'),
(305, 301, NULL, 0, 0, 'Saldo Awal', '2021-08-19 02:41:21', '2021-08-19 02:41:21'),
(306, 302, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:41:35', '2021-08-19 02:41:35'),
(307, 303, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:41:49', '2021-08-19 02:41:49'),
(308, 304, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:42:01', '2021-08-19 02:42:01'),
(309, 305, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:42:12', '2021-08-19 02:42:12'),
(310, 306, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:42:23', '2021-08-19 02:42:23'),
(311, 307, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:42:35', '2021-08-19 02:42:35'),
(312, 308, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:42:47', '2021-08-19 02:42:47'),
(313, 309, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:42:58', '2021-08-19 02:42:58'),
(314, 310, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:43:09', '2021-08-19 02:43:09'),
(315, 311, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:46:26', '2021-08-19 02:46:26'),
(316, 312, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:47:04', '2021-08-19 02:47:04'),
(317, 313, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:47:17', '2021-08-19 02:47:17'),
(318, 314, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:47:29', '2021-08-19 02:47:29'),
(319, 315, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:47:41', '2021-08-19 02:47:41'),
(320, 316, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:47:57', '2021-08-19 02:47:57'),
(321, 317, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:48:09', '2021-08-19 02:48:09'),
(322, 318, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:48:23', '2021-08-19 02:48:23'),
(323, 319, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:48:36', '2021-08-19 02:48:36'),
(324, 320, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:48:48', '2021-08-19 02:48:48'),
(325, 321, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:49:00', '2021-08-19 02:49:00'),
(326, 322, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:49:39', '2021-08-19 02:49:39'),
(327, 323, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:50:53', '2021-08-19 02:50:53'),
(328, 324, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:51:04', '2021-08-19 02:51:04'),
(329, 325, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:51:15', '2021-08-19 02:51:15'),
(330, 326, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:51:26', '2021-08-19 02:51:26'),
(331, 327, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:51:37', '2021-08-19 02:51:37'),
(332, 328, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:51:48', '2021-08-19 02:51:48'),
(333, 329, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:51:59', '2021-08-19 02:51:59'),
(334, 330, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:52:13', '2021-08-19 02:52:13'),
(335, 331, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:52:28', '2021-08-19 02:52:28'),
(336, 332, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:52:39', '2021-08-19 02:52:39'),
(337, 333, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:52:49', '2021-08-19 02:52:49'),
(338, 334, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:53:01', '2021-08-19 02:53:01'),
(339, 335, 0, NULL, 0, 'Saldo Awal', '2021-08-19 02:53:14', '2021-08-19 02:53:14'),
(341, 337, 0, NULL, 0, 'Saldo Awal', '2021-08-19 10:25:54', '2021-08-19 10:25:54'),
(342, 338, 0, NULL, 0, 'Saldo Awal', '2021-08-19 10:26:20', '2021-08-19 10:26:20'),
(475, 349, 0, NULL, 0, 'Saldo Awal', '2021-09-07 14:47:07', '2021-09-07 14:47:07');

-- --------------------------------------------------------

--
-- Table structure for table `calks`
--

CREATE TABLE `calks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `umum` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pernyataan_kepatuhan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `dasar_penyusunan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `akum_penyusutan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pendapatan_beban` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `piutang_usaha` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `piutang_desa` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `piutang_lainnya` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `rk_pusat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `aset_tetap_penyelesaian` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ekuitas`
--

CREATE TABLE `ekuitas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_akun` bigint(20) UNSIGNED NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `investasipanjangs`
--

CREATE TABLE `investasipanjangs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_akun` bigint(20) UNSIGNED NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `investasipendeks`
--

CREATE TABLE `investasipendeks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_akun` bigint(20) UNSIGNED NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jurnalpenutups`
--

CREATE TABLE `jurnalpenutups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_bubespen` bigint(20) UNSIGNED NOT NULL,
  `id_akun` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `tgl` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `debit` int(11) DEFAULT NULL,
  `kredit` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jurnalpenyesuaians`
--

CREATE TABLE `jurnalpenyesuaians` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_transbaru` bigint(20) UNSIGNED NOT NULL,
  `id_akun` bigint(20) UNSIGNED NOT NULL,
  `tgl` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `debit` int(11) DEFAULT NULL,
  `kredit` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jurnalumums`
--

CREATE TABLE `jurnalumums` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_transaksi` bigint(20) UNSIGNED NOT NULL,
  `id_akun` bigint(20) UNSIGNED NOT NULL,
  `tgl` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `debit` bigint(20) DEFAULT NULL,
  `kredit` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kasbanks`
--

CREATE TABLE `kasbanks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_akun` bigint(20) UNSIGNED NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kewajibanlains`
--

CREATE TABLE `kewajibanlains` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_akun` bigint(20) UNSIGNED NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kewajibanpanjangs`
--

CREATE TABLE `kewajibanpanjangs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_akun` bigint(20) UNSIGNED NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kewajibanpendeks`
--

CREATE TABLE `kewajibanpendeks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_akun` bigint(20) UNSIGNED NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2021_06_02_224655_create_unitusahas_table', 1),
(2, '2021_07_30_231400_create_users_table', 1),
(4, '2021_09_01_011513_create_neracasaldoawals_table', 1),
(15, '2021_08_04_001741_create_jurnalumums_table', 5),
(16, '2021_09_03_171359_create_transaksis_table', 6),
(20, '2021_08_08_142222_create_bukubesars_table', 7),
(21, '2021_08_17_111125_create_statuspens_table', 8),
(25, '2021_08_17_094853_create_transbarus_table', 9),
(26, '2021_08_17_094918_create_jurnalpenyesuaians_table', 10),
(28, '2021_08_16_110315_create_neracasaldos_table', 11),
(29, '2021_08_25_150127_create_bukubesarpenyesuaians_table', 12),
(31, '2021_08_31_142312_create_jurnalpenutups_table', 13),
(32, '2021_09_03_170608_create_asets_table', 14),
(33, '2021_09_03_202507_create_akumulasis_table', 15),
(35, '2021_09_03_204842_create_piutangusahas_table', 16),
(36, '2021_09_03_212641_create_kasbanks_table', 17),
(37, '2021_09_03_214938_create_investasipendeks_table', 18),
(38, '2021_09_03_221219_create_piutangnons_table', 19),
(39, '2021_09_04_102850_create_perlengkapans_table', 20),
(40, '2021_09_04_104333_create_pembayaranmukas_table', 21),
(41, '2021_09_04_105833_create_asetlains_table', 22),
(42, '2021_09_04_111106_create_investasipanjangs_table', 23),
(43, '2021_09_04_112905_create_asettetaps_table', 24),
(44, '2021_09_04_114044_create_asetleasings_table', 25),
(45, '2021_09_04_131038_create_propertis_table', 26),
(46, '2021_09_04_132022_create_asettidakberwujuds_table', 27),
(48, '2021_09_04_132803_create_kewajibanpendeks_table', 28),
(49, '2021_09_04_133606_create_kewajibanpanjangs_table', 29),
(50, '2021_09_04_134142_create_kewajibanlains_table', 30),
(51, '2021_09_04_134706_create_ekuitas_table', 31),
(53, '2021_09_03_162441_create_calks_table', 32);

-- --------------------------------------------------------

--
-- Table structure for table `neracasaldoawals`
--

CREATE TABLE `neracasaldoawals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_akun` bigint(20) UNSIGNED NOT NULL,
  `debit` int(11) DEFAULT NULL,
  `kredit` int(11) DEFAULT NULL,
  `status` enum('belum_final','final') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `neracasaldoawals`
--

INSERT INTO `neracasaldoawals` (`id`, `id_akun`, `debit`, `kredit`, `status`, `created_at`, `updated_at`) VALUES
(7, 1, 0, NULL, 'belum_final', '2021-08-18 04:57:41', '2021-08-25 14:23:23'),
(8, 2, 0, NULL, 'belum_final', '2021-08-18 04:58:13', '2021-08-25 06:33:16'),
(9, 3, 0, NULL, 'belum_final', '2021-08-18 04:59:05', '2021-08-25 14:23:50'),
(10, 4, NULL, 0, 'belum_final', '2021-08-18 04:59:48', '2021-08-25 14:27:07'),
(11, 5, NULL, 0, 'belum_final', '2021-08-18 05:00:25', '2021-08-25 06:33:16'),
(12, 6, NULL, 0, 'belum_final', '2021-08-18 05:00:47', '2021-08-25 06:33:16'),
(13, 7, NULL, 0, 'belum_final', '2021-08-18 05:01:36', '2021-08-25 06:33:16'),
(14, 8, NULL, 0, 'belum_final', '2021-08-18 05:03:32', '2021-08-25 06:33:16'),
(15, 9, 0, NULL, 'belum_final', '2021-08-18 05:03:58', '2021-08-25 06:33:16'),
(16, 10, 0, NULL, 'belum_final', '2021-08-18 05:06:06', '2021-08-25 10:18:57'),
(17, 11, 0, NULL, 'belum_final', '2021-08-18 05:06:50', '2021-08-25 06:33:16'),
(18, 12, 0, NULL, 'belum_final', '2021-08-18 05:07:23', '2021-08-25 06:33:16'),
(19, 13, 0, NULL, 'belum_final', '2021-08-18 05:07:59', '2021-08-25 06:33:16'),
(20, 14, 0, NULL, 'belum_final', '2021-08-18 05:08:54', '2021-08-25 06:33:16'),
(21, 15, 0, NULL, 'belum_final', '2021-08-18 05:09:22', '2021-08-25 14:24:07'),
(22, 16, 0, NULL, 'belum_final', '2021-08-18 05:09:45', '2021-08-25 06:33:16'),
(23, 17, 0, NULL, 'belum_final', '2021-08-18 05:10:07', '2021-08-25 06:33:16'),
(24, 18, 0, NULL, 'belum_final', '2021-08-18 05:10:33', '2021-08-25 06:33:16'),
(25, 19, 0, NULL, 'belum_final', '2021-08-18 05:10:54', '2021-08-25 06:33:16'),
(26, 20, 0, NULL, 'belum_final', '2021-08-18 05:11:14', '2021-08-25 06:33:16'),
(27, 21, 0, NULL, 'belum_final', '2021-08-18 05:11:43', '2021-08-25 06:33:16'),
(28, 22, 0, NULL, 'belum_final', '2021-08-18 05:12:04', '2021-08-25 06:33:16'),
(29, 23, 0, NULL, 'belum_final', '2021-08-18 05:12:28', '2021-08-25 06:33:16'),
(30, 24, 0, NULL, 'belum_final', '2021-08-18 05:12:52', '2021-08-25 06:33:16'),
(31, 25, 0, NULL, 'belum_final', '2021-08-18 05:13:26', '2021-08-25 06:33:16'),
(32, 26, 0, NULL, 'belum_final', '2021-08-18 05:13:50', '2021-08-25 06:33:16'),
(34, 28, 0, NULL, 'belum_final', '2021-08-18 05:14:49', '2021-08-25 06:33:16'),
(35, 29, 0, NULL, 'belum_final', '2021-08-18 05:15:11', '2021-08-25 06:33:16'),
(36, 30, 0, NULL, 'belum_final', '2021-08-18 05:15:34', '2021-08-25 06:33:16'),
(37, 31, 0, NULL, 'belum_final', '2021-08-18 05:15:54', '2021-08-25 06:33:16'),
(38, 32, 0, NULL, 'belum_final', '2021-08-18 05:16:14', '2021-08-25 06:33:16'),
(39, 34, 0, NULL, 'belum_final', '2021-08-18 05:19:27', '2021-08-25 06:33:16'),
(40, 35, 0, NULL, 'belum_final', '2021-08-18 05:19:49', '2021-08-25 06:33:16'),
(41, 36, 0, NULL, 'belum_final', '2021-08-18 05:20:41', '2021-08-25 06:33:16'),
(42, 37, 0, NULL, 'belum_final', '2021-08-18 08:10:18', '2021-08-25 06:33:16'),
(43, 38, 0, NULL, 'belum_final', '2021-08-19 00:31:24', '2021-08-25 06:33:16'),
(44, 39, 0, NULL, 'belum_final', '2021-08-19 00:32:12', '2021-08-25 06:33:16'),
(45, 40, 0, NULL, 'belum_final', '2021-08-19 00:32:33', '2021-08-25 06:33:16'),
(46, 41, 0, NULL, 'belum_final', '2021-08-19 00:32:57', '2021-08-25 06:33:16'),
(47, 42, 0, NULL, 'belum_final', '2021-08-19 00:33:15', '2021-08-25 06:33:16'),
(48, 43, 0, NULL, 'belum_final', '2021-08-19 00:33:36', '2021-08-25 06:33:16'),
(49, 44, 0, NULL, 'belum_final', '2021-08-19 00:33:52', '2021-08-25 06:33:16'),
(50, 45, 0, NULL, 'belum_final', '2021-08-19 00:34:08', '2021-08-25 06:33:16'),
(51, 46, 0, NULL, 'belum_final', '2021-08-19 00:34:23', '2021-08-25 06:33:16'),
(52, 47, 0, NULL, 'belum_final', '2021-08-19 00:34:38', '2021-08-25 06:33:16'),
(53, 48, 0, NULL, 'belum_final', '2021-08-19 00:34:54', '2021-08-25 06:33:16'),
(54, 49, 0, NULL, 'belum_final', '2021-08-19 00:35:09', '2021-08-25 06:33:16'),
(55, 50, 0, NULL, 'belum_final', '2021-08-19 00:35:25', '2021-08-25 06:33:16'),
(56, 51, 0, NULL, 'belum_final', '2021-08-19 00:35:40', '2021-08-25 06:33:16'),
(57, 52, 0, NULL, 'belum_final', '2021-08-19 00:35:54', '2021-08-25 06:33:16'),
(58, 53, 0, NULL, 'belum_final', '2021-08-19 00:36:57', '2021-08-25 06:33:16'),
(59, 54, 0, NULL, 'belum_final', '2021-08-19 00:37:14', '2021-08-25 06:33:16'),
(60, 55, 0, NULL, 'belum_final', '2021-08-19 00:37:31', '2021-08-25 06:33:16'),
(61, 56, 0, NULL, 'belum_final', '2021-08-19 00:37:46', '2021-08-25 06:33:16'),
(62, 57, 0, NULL, 'belum_final', '2021-08-19 00:38:05', '2021-08-25 06:33:16'),
(63, 58, 0, NULL, 'belum_final', '2021-08-19 00:38:21', '2021-08-25 06:33:16'),
(64, 59, 0, NULL, 'belum_final', '2021-08-19 00:38:37', '2021-08-25 06:33:16'),
(65, 60, 0, NULL, 'belum_final', '2021-08-19 00:38:51', '2021-08-25 06:33:16'),
(66, 61, 0, NULL, 'belum_final', '2021-08-19 00:39:06', '2021-08-25 06:33:16'),
(67, 62, 0, NULL, 'belum_final', '2021-08-19 00:39:22', '2021-08-25 06:33:16'),
(68, 63, 0, NULL, 'belum_final', '2021-08-19 00:39:51', '2021-08-25 06:33:16'),
(69, 64, 0, NULL, 'belum_final', '2021-08-19 00:41:19', '2021-08-25 06:33:16'),
(70, 65, 0, NULL, 'belum_final', '2021-08-19 00:41:34', '2021-08-25 06:33:16'),
(71, 66, 0, NULL, 'belum_final', '2021-08-19 00:41:52', '2021-08-25 06:33:16'),
(72, 67, 0, NULL, 'belum_final', '2021-08-19 00:42:10', '2021-08-25 06:33:16'),
(73, 68, 0, NULL, 'belum_final', '2021-08-19 00:42:26', '2021-08-25 06:33:16'),
(74, 69, 0, NULL, 'belum_final', '2021-08-19 00:42:41', '2021-08-25 06:33:16'),
(75, 70, 0, NULL, 'belum_final', '2021-08-19 00:42:56', '2021-08-25 06:33:16'),
(76, 71, 0, NULL, 'belum_final', '2021-08-19 00:43:10', '2021-08-25 06:33:16'),
(77, 72, 0, NULL, 'belum_final', '2021-08-19 00:43:26', '2021-08-25 06:33:16'),
(78, 73, 0, NULL, 'belum_final', '2021-08-19 00:43:40', '2021-08-25 06:33:16'),
(79, 74, 0, NULL, 'belum_final', '2021-08-19 00:43:56', '2021-08-25 06:33:16'),
(80, 75, 0, NULL, 'belum_final', '2021-08-19 00:44:12', '2021-08-25 06:33:16'),
(81, 76, 0, NULL, 'belum_final', '2021-08-19 00:44:28', '2021-08-25 06:33:16'),
(82, 77, 0, NULL, 'belum_final', '2021-08-19 00:44:41', '2021-08-25 06:33:16'),
(83, 78, 0, NULL, 'belum_final', '2021-08-19 00:44:56', '2021-08-25 06:33:16'),
(84, 79, 0, NULL, 'belum_final', '2021-08-19 00:45:10', '2021-08-25 06:33:16'),
(85, 80, 0, NULL, 'belum_final', '2021-08-19 00:45:23', '2021-08-25 06:33:16'),
(86, 81, 0, NULL, 'belum_final', '2021-08-19 00:45:39', '2021-08-25 06:33:16'),
(87, 82, 0, NULL, 'belum_final', '2021-08-19 00:45:58', '2021-08-25 06:33:16'),
(88, 83, 0, NULL, 'belum_final', '2021-08-19 00:46:14', '2021-08-25 06:33:16'),
(89, 84, 0, NULL, 'belum_final', '2021-08-19 00:46:28', '2021-08-25 06:33:16'),
(90, 85, 0, NULL, 'belum_final', '2021-08-19 00:46:46', '2021-08-25 06:33:16'),
(91, 86, 0, NULL, 'belum_final', '2021-08-19 00:47:00', '2021-08-25 06:33:16'),
(92, 87, 0, NULL, 'belum_final', '2021-08-19 00:47:16', '2021-08-25 06:33:16'),
(93, 88, 0, NULL, 'belum_final', '2021-08-19 00:47:31', '2021-08-25 06:33:16'),
(94, 89, 0, NULL, 'belum_final', '2021-08-19 00:47:45', '2021-08-25 06:33:16'),
(95, 90, 0, NULL, 'belum_final', '2021-08-19 00:48:04', '2021-08-25 06:33:16'),
(96, 91, 0, NULL, 'belum_final', '2021-08-19 00:48:19', '2021-08-25 06:33:16'),
(97, 92, 0, NULL, 'belum_final', '2021-08-19 00:48:37', '2021-08-25 06:33:16'),
(98, 93, 0, NULL, 'belum_final', '2021-08-19 00:48:54', '2021-08-25 06:33:16'),
(99, 94, 0, NULL, 'belum_final', '2021-08-19 00:49:08', '2021-08-25 06:33:16'),
(100, 95, 0, NULL, 'belum_final', '2021-08-19 00:49:22', '2021-08-25 06:33:16'),
(101, 96, 0, NULL, 'belum_final', '2021-08-19 00:49:37', '2021-08-25 06:33:16'),
(102, 97, 0, NULL, 'belum_final', '2021-08-19 00:49:52', '2021-08-25 06:33:16'),
(103, 98, 0, NULL, 'belum_final', '2021-08-19 00:50:07', '2021-08-25 06:33:16'),
(104, 99, 0, NULL, 'belum_final', '2021-08-19 00:50:21', '2021-08-25 06:33:16'),
(105, 100, 0, NULL, 'belum_final', '2021-08-19 00:50:37', '2021-08-25 06:33:16'),
(106, 101, 0, NULL, 'belum_final', '2021-08-19 00:50:49', '2021-08-25 06:33:16'),
(107, 102, 0, NULL, 'belum_final', '2021-08-19 00:51:03', '2021-08-25 06:33:16'),
(108, 103, 0, NULL, 'belum_final', '2021-08-19 00:51:17', '2021-08-25 06:33:16'),
(109, 104, 0, NULL, 'belum_final', '2021-08-19 00:51:30', '2021-08-25 06:33:16'),
(110, 105, 0, NULL, 'belum_final', '2021-08-19 00:51:46', '2021-08-25 06:33:16'),
(111, 106, 0, NULL, 'belum_final', '2021-08-19 00:51:59', '2021-08-25 06:33:16'),
(112, 107, 0, NULL, 'belum_final', '2021-08-19 00:52:12', '2021-08-25 06:33:16'),
(113, 108, 0, NULL, 'belum_final', '2021-08-19 00:52:41', '2021-08-25 06:33:16'),
(114, 109, 0, NULL, 'belum_final', '2021-08-19 00:52:55', '2021-08-25 06:33:16'),
(115, 110, 0, NULL, 'belum_final', '2021-08-19 00:53:08', '2021-08-25 06:33:16'),
(116, 111, 0, NULL, 'belum_final', '2021-08-19 00:53:24', '2021-08-25 06:33:16'),
(117, 112, 0, NULL, 'belum_final', '2021-08-19 00:53:38', '2021-08-25 06:33:16'),
(118, 113, 0, NULL, 'belum_final', '2021-08-19 00:53:51', '2021-08-25 06:33:16'),
(119, 114, 0, NULL, 'belum_final', '2021-08-19 00:54:05', '2021-08-25 06:33:16'),
(120, 115, 0, NULL, 'belum_final', '2021-08-19 00:54:19', '2021-08-25 06:33:16'),
(121, 116, 0, NULL, 'belum_final', '2021-08-19 00:54:33', '2021-08-25 06:33:16'),
(122, 117, 0, NULL, 'belum_final', '2021-08-19 00:54:49', '2021-08-25 06:33:16'),
(123, 118, 0, NULL, 'belum_final', '2021-08-19 00:56:36', '2021-08-25 06:33:16'),
(124, 119, 0, NULL, 'belum_final', '2021-08-19 00:56:49', '2021-08-25 06:33:16'),
(125, 120, 0, NULL, 'belum_final', '2021-08-19 00:57:02', '2021-08-25 06:33:16'),
(126, 121, 0, NULL, 'belum_final', '2021-08-19 00:57:15', '2021-08-25 06:33:16'),
(127, 122, 0, NULL, 'belum_final', '2021-08-19 00:57:31', '2021-08-25 06:33:16'),
(128, 123, 0, NULL, 'belum_final', '2021-08-19 00:57:47', '2021-08-25 06:33:16'),
(129, 124, 0, NULL, 'belum_final', '2021-08-19 00:57:58', '2021-08-25 06:33:16'),
(130, 125, 0, NULL, 'belum_final', '2021-08-19 00:58:11', '2021-08-25 06:33:16'),
(131, 126, 0, NULL, 'belum_final', '2021-08-19 00:58:25', '2021-08-25 06:33:16'),
(132, 127, 0, NULL, 'belum_final', '2021-08-19 00:58:39', '2021-08-25 06:33:16'),
(133, 128, 0, NULL, 'belum_final', '2021-08-19 01:15:22', '2021-08-25 06:33:16'),
(134, 129, 0, NULL, 'belum_final', '2021-08-19 01:15:42', '2021-08-25 06:33:16'),
(135, 130, 0, NULL, 'belum_final', '2021-08-19 01:15:59', '2021-08-25 06:33:16'),
(136, 131, 0, NULL, 'belum_final', '2021-08-19 01:16:15', '2021-08-25 06:33:16'),
(137, 132, 0, NULL, 'belum_final', '2021-08-19 01:16:28', '2021-08-25 06:33:16'),
(138, 133, 0, NULL, 'belum_final', '2021-08-19 01:16:41', '2021-08-25 06:33:16'),
(139, 134, 0, NULL, 'belum_final', '2021-08-19 01:16:55', '2021-08-25 06:33:16'),
(140, 135, 0, NULL, 'belum_final', '2021-08-19 01:17:09', '2021-08-25 06:33:16'),
(141, 136, 0, NULL, 'belum_final', '2021-08-19 01:17:22', '2021-08-25 06:33:16'),
(142, 137, 0, NULL, 'belum_final', '2021-08-19 01:17:36', '2021-08-25 06:33:16'),
(143, 138, 0, NULL, 'belum_final', '2021-08-19 01:17:50', '2021-08-25 06:33:16'),
(144, 139, 0, NULL, 'belum_final', '2021-08-19 01:18:04', '2021-08-25 06:33:16'),
(145, 140, 0, NULL, 'belum_final', '2021-08-19 01:18:17', '2021-08-25 06:33:16'),
(146, 141, 0, NULL, 'belum_final', '2021-08-19 01:18:32', '2021-08-25 06:33:16'),
(147, 142, 0, NULL, 'belum_final', '2021-08-19 01:18:45', '2021-08-25 06:33:16'),
(148, 143, 0, NULL, 'belum_final', '2021-08-19 01:18:58', '2021-08-25 06:33:16'),
(149, 144, 0, NULL, 'belum_final', '2021-08-19 01:19:11', '2021-08-25 06:33:16'),
(150, 145, 0, NULL, 'belum_final', '2021-08-19 01:19:23', '2021-08-25 06:33:16'),
(151, 146, 0, NULL, 'belum_final', '2021-08-19 01:19:36', '2021-08-25 06:33:16'),
(152, 147, 0, NULL, 'belum_final', '2021-08-19 01:19:49', '2021-08-25 06:33:16'),
(153, 148, 0, NULL, 'belum_final', '2021-08-19 01:20:04', '2021-08-25 06:33:16'),
(154, 149, 0, NULL, 'belum_final', '2021-08-19 01:20:17', '2021-08-25 06:33:16'),
(155, 150, 0, NULL, 'belum_final', '2021-08-19 01:20:30', '2021-08-25 06:33:16'),
(156, 151, 0, NULL, 'belum_final', '2021-08-19 01:20:43', '2021-08-25 06:33:16'),
(157, 152, 0, NULL, 'belum_final', '2021-08-19 01:20:57', '2021-08-25 06:33:16'),
(158, 153, 0, NULL, 'belum_final', '2021-08-19 01:21:09', '2021-08-25 06:33:16'),
(159, 154, 0, NULL, 'belum_final', '2021-08-19 01:21:25', '2021-08-25 06:33:16'),
(160, 155, 0, NULL, 'belum_final', '2021-08-19 01:21:41', '2021-08-25 06:33:16'),
(161, 156, 0, NULL, 'belum_final', '2021-08-19 01:22:04', '2021-08-25 06:33:16'),
(162, 157, 0, NULL, 'belum_final', '2021-08-19 01:25:03', '2021-08-25 06:33:16'),
(163, 158, NULL, 0, 'belum_final', '2021-08-19 01:25:40', '2021-08-25 06:33:16'),
(164, 159, 0, NULL, 'belum_final', '2021-08-19 01:26:02', '2021-08-25 06:33:16'),
(165, 160, 0, NULL, 'belum_final', '2021-08-19 01:44:34', '2021-08-25 06:33:16'),
(166, 161, 0, NULL, 'belum_final', '2021-08-19 01:44:49', '2021-08-25 06:33:16'),
(167, 162, NULL, 0, 'belum_final', '2021-08-19 01:45:04', '2021-08-25 06:33:16'),
(168, 163, 0, NULL, 'belum_final', '2021-08-19 01:45:46', '2021-08-25 14:24:30'),
(169, 164, 0, NULL, 'belum_final', '2021-08-19 01:47:49', '2021-08-25 06:33:16'),
(170, 165, 0, NULL, 'belum_final', '2021-08-19 01:48:55', '2021-08-25 06:33:16'),
(171, 166, 0, NULL, 'belum_final', '2021-08-19 01:49:12', '2021-08-25 06:33:16'),
(172, 167, 0, NULL, 'belum_final', '2021-08-19 01:49:25', '2021-08-25 06:33:16'),
(173, 168, 0, NULL, 'belum_final', '2021-08-19 01:49:41', '2021-08-25 06:33:16'),
(174, 169, 0, NULL, 'belum_final', '2021-08-19 01:49:54', '2021-08-25 06:33:16'),
(175, 170, 0, NULL, 'belum_final', '2021-08-19 01:50:20', '2021-08-25 06:33:16'),
(176, 171, 0, NULL, 'belum_final', '2021-08-19 01:51:23', '2021-08-25 06:33:16'),
(177, 172, 0, NULL, 'belum_final', '2021-08-19 01:51:44', '2021-08-25 06:33:16'),
(178, 173, 0, NULL, 'belum_final', '2021-08-19 01:51:58', '2021-08-25 06:33:16'),
(179, 174, 0, NULL, 'belum_final', '2021-08-19 01:52:11', '2021-08-25 06:33:16'),
(180, 175, 0, NULL, 'belum_final', '2021-08-19 01:52:26', '2021-08-25 06:33:16'),
(181, 176, 0, NULL, 'belum_final', '2021-08-19 01:52:41', '2021-08-25 06:33:16'),
(182, 177, 0, NULL, 'belum_final', '2021-08-19 01:53:42', '2021-08-25 06:33:16'),
(183, 178, 0, NULL, 'belum_final', '2021-08-19 01:53:56', '2021-08-25 06:33:16'),
(184, 179, 0, NULL, 'belum_final', '2021-08-19 01:54:14', '2021-08-25 06:33:16'),
(185, 180, 0, NULL, 'belum_final', '2021-08-19 01:54:56', '2021-08-25 06:33:16'),
(186, 181, 0, NULL, 'belum_final', '2021-08-19 01:55:09', '2021-08-25 06:33:16'),
(187, 182, 0, NULL, 'belum_final', '2021-08-19 01:55:22', '2021-08-25 06:33:16'),
(188, 183, 0, NULL, 'belum_final', '2021-08-19 01:55:34', '2021-08-25 06:33:16'),
(189, 184, 0, NULL, 'belum_final', '2021-08-19 01:55:47', '2021-08-25 06:33:16'),
(190, 185, 0, NULL, 'belum_final', '2021-08-19 01:56:00', '2021-08-25 06:33:16'),
(191, 186, 0, NULL, 'belum_final', '2021-08-19 01:56:14', '2021-08-25 06:33:16'),
(192, 187, 0, NULL, 'belum_final', '2021-08-19 01:58:08', '2021-08-25 06:33:16'),
(193, 188, 0, NULL, 'belum_final', '2021-08-19 01:58:25', '2021-08-25 06:33:16'),
(194, 189, 0, NULL, 'belum_final', '2021-08-19 01:58:38', '2021-08-25 06:33:16'),
(195, 190, 0, NULL, 'belum_final', '2021-08-19 01:58:54', '2021-08-25 06:33:16'),
(196, 191, 0, NULL, 'belum_final', '2021-08-19 01:59:07', '2021-08-25 06:33:16'),
(197, 192, 0, NULL, 'belum_final', '2021-08-19 01:59:20', '2021-08-25 06:33:16'),
(198, 193, 0, NULL, 'belum_final', '2021-08-19 01:59:34', '2021-08-25 06:33:16'),
(199, 194, 0, NULL, 'belum_final', '2021-08-19 01:59:55', '2021-08-25 06:33:16'),
(200, 195, 0, NULL, 'belum_final', '2021-08-19 02:00:16', '2021-08-25 06:33:16'),
(201, 196, 0, NULL, 'belum_final', '2021-08-19 02:00:30', '2021-08-25 14:26:03'),
(202, 197, 0, NULL, 'belum_final', '2021-08-19 02:00:41', '2021-08-25 06:33:16'),
(203, 198, 0, NULL, 'belum_final', '2021-08-19 02:00:55', '2021-08-25 06:33:16'),
(204, 199, 0, NULL, 'belum_final', '2021-08-19 02:01:07', '2021-08-25 14:25:10'),
(205, 200, 0, NULL, 'belum_final', '2021-08-19 02:01:20', '2021-08-25 06:33:16'),
(206, 201, 0, NULL, 'belum_final', '2021-08-19 02:01:32', '2021-08-25 06:33:16'),
(207, 202, NULL, 0, 'belum_final', '2021-08-19 02:01:45', '2021-08-25 06:33:16'),
(208, 203, NULL, 0, 'belum_final', '2021-08-19 02:01:59', '2021-08-25 06:33:16'),
(209, 204, NULL, 0, 'belum_final', '2021-08-19 02:02:14', '2021-08-25 14:26:32'),
(210, 205, NULL, 0, 'belum_final', '2021-08-19 02:02:25', '2021-08-25 06:33:16'),
(211, 206, NULL, 0, 'belum_final', '2021-08-19 02:02:40', '2021-08-25 06:33:16'),
(212, 207, NULL, 0, 'belum_final', '2021-08-19 02:02:53', '2021-08-25 14:25:40'),
(213, 208, NULL, 0, 'belum_final', '2021-08-19 02:03:06', '2021-08-25 06:33:16'),
(214, 209, NULL, 0, 'belum_final', '2021-08-19 02:03:26', '2021-08-25 06:33:16'),
(215, 210, 0, NULL, 'belum_final', '2021-08-19 02:04:18', '2021-08-25 06:33:16'),
(216, 211, NULL, 0, 'belum_final', '2021-08-19 02:04:37', '2021-08-25 06:33:16'),
(217, 212, 0, NULL, 'belum_final', '2021-08-19 02:04:53', '2021-08-25 06:33:16'),
(218, 213, NULL, 0, 'belum_final', '2021-08-19 02:05:07', '2021-08-25 06:33:16'),
(219, 214, NULL, 0, 'belum_final', '2021-08-19 02:05:24', '2021-08-25 06:33:16'),
(220, 215, 0, NULL, 'belum_final', '2021-08-19 02:05:39', '2021-08-25 06:33:16'),
(221, 216, 0, NULL, 'belum_final', '2021-08-19 02:06:31', '2021-08-25 06:33:16'),
(222, 217, 0, NULL, 'belum_final', '2021-08-19 02:06:43', '2021-08-25 06:33:16'),
(223, 218, 0, NULL, 'belum_final', '2021-08-19 02:06:56', '2021-08-25 06:33:16'),
(224, 219, NULL, 0, 'belum_final', '2021-08-19 02:07:14', '2021-08-25 06:33:16'),
(225, 220, NULL, 0, 'belum_final', '2021-08-19 02:07:26', '2021-08-25 06:33:16'),
(226, 221, NULL, 0, 'belum_final', '2021-08-19 02:07:39', '2021-08-25 06:33:16'),
(227, 222, NULL, 0, 'belum_final', '2021-08-19 02:07:50', '2021-08-25 06:33:16'),
(228, 223, NULL, 0, 'belum_final', '2021-08-19 02:11:11', '2021-08-25 06:33:16'),
(229, 224, NULL, 0, 'belum_final', '2021-08-19 02:11:26', '2021-08-25 06:33:16'),
(230, 225, NULL, 0, 'belum_final', '2021-08-19 02:11:38', '2021-08-25 06:33:16'),
(231, 226, NULL, 0, 'belum_final', '2021-08-19 02:12:10', '2021-08-25 06:33:16'),
(232, 227, NULL, 0, 'belum_final', '2021-08-19 02:12:23', '2021-08-25 06:33:16'),
(234, 229, NULL, 0, 'belum_final', '2021-08-19 02:14:33', '2021-08-25 06:33:16'),
(235, 230, NULL, 0, 'belum_final', '2021-08-19 02:14:49', '2021-08-25 06:33:16'),
(236, 231, NULL, 0, 'belum_final', '2021-08-19 02:15:01', '2021-08-25 06:33:16'),
(237, 232, NULL, 0, 'belum_final', '2021-08-19 02:15:14', '2021-08-25 06:33:16'),
(238, 233, NULL, 0, 'belum_final', '2021-08-19 02:17:53', '2021-08-25 06:33:16'),
(239, 234, 0, NULL, 'belum_final', '2021-08-19 02:18:10', '2021-08-25 06:33:16'),
(240, 235, NULL, 0, 'belum_final', '2021-08-19 02:18:31', '2021-08-25 06:33:16'),
(241, 236, NULL, 0, 'belum_final', '2021-08-19 02:18:45', '2021-08-25 06:33:16'),
(242, 237, NULL, 0, 'belum_final', '2021-08-19 02:18:58', '2021-08-25 06:33:16'),
(243, 238, NULL, 0, 'belum_final', '2021-08-19 02:19:10', '2021-08-25 06:33:16'),
(244, 239, NULL, 0, 'belum_final', '2021-08-19 02:19:35', '2021-08-25 06:33:16'),
(245, 241, NULL, 0, 'belum_final', '2021-08-19 02:20:58', '2021-08-25 06:33:16'),
(246, 242, NULL, 0, 'belum_final', '2021-08-19 02:21:14', '2021-08-25 06:33:16'),
(247, 243, NULL, 0, 'belum_final', '2021-08-19 02:22:01', '2021-08-25 06:33:16'),
(248, 244, NULL, 0, 'belum_final', '2021-08-19 02:22:13', '2021-08-25 06:33:16'),
(249, 245, NULL, 0, 'belum_final', '2021-08-19 02:22:59', '2021-08-25 06:33:16'),
(250, 246, NULL, 0, 'belum_final', '2021-08-19 02:23:11', '2021-08-25 06:33:16'),
(251, 247, NULL, 0, 'belum_final', '2021-08-19 02:23:25', '2021-08-25 06:33:16'),
(252, 248, NULL, 0, 'belum_final', '2021-08-19 02:23:37', '2021-08-25 06:33:16'),
(253, 249, NULL, 0, 'belum_final', '2021-08-19 02:23:49', '2021-08-25 06:33:16'),
(254, 250, NULL, 0, 'belum_final', '2021-08-19 02:24:02', '2021-08-25 06:33:16'),
(255, 251, NULL, 0, 'belum_final', '2021-08-19 02:24:14', '2021-08-25 06:33:16'),
(256, 252, NULL, 0, 'belum_final', '2021-08-19 02:24:26', '2021-08-25 06:33:16'),
(257, 253, NULL, 0, 'belum_final', '2021-08-19 02:24:37', '2021-08-25 06:33:16'),
(258, 254, NULL, 0, 'belum_final', '2021-08-19 02:24:52', '2021-08-25 06:33:16'),
(259, 255, NULL, 0, 'belum_final', '2021-08-19 02:25:07', '2021-08-25 06:33:16'),
(260, 256, NULL, 0, 'belum_final', '2021-08-19 02:26:13', '2021-08-25 06:33:16'),
(261, 257, NULL, 0, 'belum_final', '2021-08-19 02:26:27', '2021-08-25 06:33:16'),
(262, 258, NULL, 0, 'belum_final', '2021-08-19 02:26:40', '2021-08-25 10:25:25'),
(263, 259, NULL, 0, 'belum_final', '2021-08-19 02:26:51', '2021-08-25 06:33:16'),
(264, 260, NULL, 0, 'belum_final', '2021-08-19 02:27:10', '2021-08-25 06:33:16'),
(265, 261, NULL, 0, 'belum_final', '2021-08-19 02:27:33', '2021-08-25 14:27:47'),
(266, 262, NULL, 0, 'belum_final', '2021-08-19 02:27:46', '2021-08-25 06:33:16'),
(267, 263, NULL, 0, 'belum_final', '2021-08-19 02:28:00', '2021-08-25 06:33:16'),
(268, 264, NULL, 0, 'belum_final', '2021-08-19 02:28:14', '2021-08-25 06:33:16'),
(269, 265, NULL, 0, 'belum_final', '2021-08-19 02:28:33', '2021-08-25 06:33:16'),
(270, 266, 0, NULL, 'belum_final', '2021-08-19 02:28:46', '2021-08-25 06:33:16'),
(271, 267, 0, NULL, 'belum_final', '2021-08-19 02:28:58', '2021-08-25 06:33:16'),
(272, 268, NULL, 0, 'belum_final', '2021-08-19 02:29:10', '2021-08-25 06:33:16'),
(273, 269, NULL, 0, 'belum_final', '2021-08-19 02:30:00', '2021-08-25 06:33:16'),
(274, 270, NULL, 0, 'belum_final', '2021-08-19 02:30:15', '2021-08-25 06:33:16'),
(275, 271, NULL, 0, 'belum_final', '2021-08-19 02:30:37', '2021-08-25 06:33:16'),
(276, 272, NULL, 0, 'belum_final', '2021-08-19 02:31:21', '2021-08-25 06:33:16'),
(277, 273, NULL, 0, 'belum_final', '2021-08-19 02:31:48', '2021-08-25 06:33:16'),
(278, 274, NULL, 0, 'belum_final', '2021-08-19 02:32:02', '2021-08-25 06:33:16'),
(279, 275, NULL, 0, 'belum_final', '2021-08-19 02:32:14', '2021-08-25 06:33:16'),
(280, 276, 0, NULL, 'belum_final', '2021-08-19 02:34:02', '2021-08-25 06:33:16'),
(281, 277, 0, NULL, 'belum_final', '2021-08-19 02:34:55', '2021-08-25 06:33:16'),
(282, 278, 0, NULL, 'belum_final', '2021-08-19 02:35:08', '2021-08-25 06:33:16'),
(283, 279, 0, NULL, 'belum_final', '2021-08-19 02:35:21', '2021-08-25 06:33:16'),
(284, 280, 0, NULL, 'belum_final', '2021-08-19 02:35:34', '2021-08-25 06:33:16'),
(285, 281, 0, NULL, 'belum_final', '2021-08-19 02:35:48', '2021-08-25 10:26:39'),
(286, 282, 0, NULL, 'belum_final', '2021-08-19 02:36:01', '2021-08-25 06:33:16'),
(287, 283, 0, NULL, 'belum_final', '2021-08-19 02:36:13', '2021-08-25 06:33:16'),
(288, 284, 0, NULL, 'belum_final', '2021-08-19 02:36:25', '2021-08-25 06:33:16'),
(289, 285, 0, NULL, 'belum_final', '2021-08-19 02:36:38', '2021-08-25 06:33:16'),
(290, 286, 0, NULL, 'belum_final', '2021-08-19 02:36:50', '2021-08-25 06:33:16'),
(291, 287, 0, NULL, 'belum_final', '2021-08-19 02:37:02', '2021-08-25 06:33:16'),
(292, 288, 0, NULL, 'belum_final', '2021-08-19 02:37:13', '2021-08-25 06:33:16'),
(293, 289, 0, NULL, 'belum_final', '2021-08-19 02:38:12', '2021-08-25 06:33:16'),
(294, 290, 0, NULL, 'belum_final', '2021-08-19 02:38:23', '2021-08-25 06:33:16'),
(295, 291, 0, NULL, 'belum_final', '2021-08-19 02:38:35', '2021-08-25 06:33:16'),
(296, 292, 0, NULL, 'belum_final', '2021-08-19 02:38:51', '2021-08-25 06:33:16'),
(297, 293, 0, NULL, 'belum_final', '2021-08-19 02:39:02', '2021-08-25 06:33:16'),
(298, 294, 0, NULL, 'belum_final', '2021-08-19 02:39:14', '2021-08-25 06:33:16'),
(299, 295, 0, NULL, 'belum_final', '2021-08-19 02:39:26', '2021-08-25 06:33:16'),
(300, 296, 0, NULL, 'belum_final', '2021-08-19 02:39:39', '2021-08-25 06:33:16'),
(301, 297, 0, NULL, 'belum_final', '2021-08-19 02:39:53', '2021-08-25 06:33:16'),
(302, 298, 0, NULL, 'belum_final', '2021-08-19 02:40:10', '2021-08-25 06:33:16'),
(303, 299, 0, NULL, 'belum_final', '2021-08-19 02:40:37', '2021-08-25 06:33:16'),
(304, 300, 0, NULL, 'belum_final', '2021-08-19 02:40:50', '2021-08-25 06:33:16'),
(305, 301, NULL, 0, 'belum_final', '2021-08-19 02:41:21', '2021-08-25 06:33:16'),
(306, 302, 0, NULL, 'belum_final', '2021-08-19 02:41:35', '2021-08-25 06:33:16'),
(307, 303, 0, NULL, 'belum_final', '2021-08-19 02:41:49', '2021-08-25 06:33:16'),
(308, 304, 0, NULL, 'belum_final', '2021-08-19 02:42:01', '2021-08-25 06:33:16'),
(309, 305, 0, NULL, 'belum_final', '2021-08-19 02:42:12', '2021-08-25 06:33:16'),
(310, 306, 0, NULL, 'belum_final', '2021-08-19 02:42:23', '2021-08-25 06:33:16'),
(311, 307, 0, NULL, 'belum_final', '2021-08-19 02:42:35', '2021-08-25 06:33:16'),
(312, 308, 0, NULL, 'belum_final', '2021-08-19 02:42:47', '2021-08-25 06:33:16'),
(313, 309, 0, NULL, 'belum_final', '2021-08-19 02:42:58', '2021-08-25 06:33:16'),
(314, 310, 0, NULL, 'belum_final', '2021-08-19 02:43:09', '2021-08-25 06:33:16'),
(315, 311, 0, NULL, 'belum_final', '2021-08-19 02:46:26', '2021-08-25 06:33:16'),
(316, 312, 0, NULL, 'belum_final', '2021-08-19 02:47:04', '2021-08-25 06:33:16'),
(317, 313, 0, NULL, 'belum_final', '2021-08-19 02:47:17', '2021-08-25 06:33:16'),
(318, 314, 0, NULL, 'belum_final', '2021-08-19 02:47:29', '2021-08-25 06:33:16'),
(319, 315, 0, NULL, 'belum_final', '2021-08-19 02:47:41', '2021-08-25 06:33:16'),
(320, 316, 0, NULL, 'belum_final', '2021-08-19 02:47:57', '2021-08-25 06:33:16'),
(321, 317, 0, NULL, 'belum_final', '2021-08-19 02:48:09', '2021-08-25 06:33:16'),
(322, 318, 0, NULL, 'belum_final', '2021-08-19 02:48:23', '2021-08-25 06:33:16'),
(323, 319, 0, NULL, 'belum_final', '2021-08-19 02:48:36', '2021-08-25 06:33:16'),
(324, 320, 0, NULL, 'belum_final', '2021-08-19 02:48:48', '2021-08-25 06:33:16'),
(325, 321, 0, NULL, 'belum_final', '2021-08-19 02:49:00', '2021-08-25 06:33:16'),
(326, 322, 0, NULL, 'belum_final', '2021-08-19 02:49:39', '2021-08-25 06:33:16'),
(327, 323, 0, NULL, 'belum_final', '2021-08-19 02:50:53', '2021-08-25 06:33:16'),
(328, 324, 0, NULL, 'belum_final', '2021-08-19 02:51:04', '2021-08-25 06:33:16'),
(329, 325, 0, NULL, 'belum_final', '2021-08-19 02:51:15', '2021-08-25 06:33:16'),
(330, 326, 0, NULL, 'belum_final', '2021-08-19 02:51:26', '2021-08-25 06:33:16'),
(331, 327, 0, NULL, 'belum_final', '2021-08-19 02:51:37', '2021-08-25 06:33:16'),
(332, 328, 0, NULL, 'belum_final', '2021-08-19 02:51:48', '2021-08-25 06:33:16'),
(333, 329, 0, NULL, 'belum_final', '2021-08-19 02:51:59', '2021-08-25 06:33:16'),
(334, 330, 0, NULL, 'belum_final', '2021-08-19 02:52:13', '2021-08-25 06:33:16'),
(335, 331, 0, NULL, 'belum_final', '2021-08-19 02:52:28', '2021-08-25 06:33:16'),
(336, 332, 0, NULL, 'belum_final', '2021-08-19 02:52:39', '2021-08-25 06:33:16'),
(337, 333, 0, NULL, 'belum_final', '2021-08-19 02:52:49', '2021-08-25 06:33:16'),
(338, 334, 0, NULL, 'belum_final', '2021-08-19 02:53:01', '2021-08-25 06:33:16'),
(339, 335, 0, NULL, 'belum_final', '2021-08-19 02:53:14', '2021-08-25 06:33:16'),
(341, 337, 0, NULL, 'belum_final', '2021-08-19 10:25:54', '2021-08-25 06:33:16'),
(342, 338, 0, NULL, 'belum_final', '2021-08-19 10:26:20', '2021-08-25 06:33:16'),
(345, 342, 0, NULL, 'belum_final', '2021-09-01 17:01:17', '2021-09-01 17:01:17'),
(346, 343, NULL, 0, 'belum_final', '2021-09-01 17:01:37', '2021-09-01 17:01:37'),
(351, 349, 0, NULL, 'belum_final', '2021-09-07 14:47:07', '2021-09-07 14:47:07');

-- --------------------------------------------------------

--
-- Table structure for table `neracasaldos`
--

CREATE TABLE `neracasaldos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_akun` bigint(20) UNSIGNED NOT NULL,
  `id_bukubesar` bigint(20) UNSIGNED DEFAULT NULL,
  `debit` int(11) DEFAULT NULL,
  `kredit` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembayaranmukas`
--

CREATE TABLE `pembayaranmukas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_akun` bigint(20) UNSIGNED NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `perlengkapans`
--

CREATE TABLE `perlengkapans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_akun` bigint(20) UNSIGNED NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `piutangnons`
--

CREATE TABLE `piutangnons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_akun` bigint(20) UNSIGNED NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `piutangusahas`
--

CREATE TABLE `piutangusahas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_akun` bigint(20) UNSIGNED NOT NULL,
  `saldo` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `propertis`
--

CREATE TABLE `propertis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_akun` bigint(20) UNSIGNED NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaksis`
--

CREATE TABLE `transaksis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_akun` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `dok_bukti` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_pembayaran` enum('tunai','kredit','dp') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `nominal` bigint(20) NOT NULL,
  `nominal_dp` int(11) DEFAULT NULL,
  `nominal_ppn` int(11) DEFAULT NULL,
  `nominal_pph22` int(11) DEFAULT NULL,
  `nominal_pph23` int(11) DEFAULT NULL,
  `potongan_pembelian` int(11) DEFAULT NULL,
  `potongan_penjualan` int(11) DEFAULT NULL,
  `umur_ekonomis` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nilai_sisa` int(11) DEFAULT NULL,
  `beban_penyusutan` int(11) DEFAULT NULL,
  `status` enum('pembelian','penjualan','penerimaan_kas','pengeluaran_kas','retur_penjualan','retur_pembelian') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transbarus`
--

CREATE TABLE `transbarus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_akun` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `tgl` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `nominal` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `unitusahas`
--

CREATE TABLE `unitusahas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jenis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `unitusahas`
--

INSERT INTO `unitusahas` (`id`, `jenis`, `created_at`, `updated_at`) VALUES
(1, 'Air PAMDes', '2021-08-03 09:46:42', NULL),
(2, 'Simpan Pinjam', '2021-08-03 09:46:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('superadmin','bumdes','unitusaha') COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_unitusaha` bigint(20) UNSIGNED DEFAULT NULL,
  `status_neracaawal` enum('belum_final','final') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_calk` enum('submitted','null') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `role`, `id_unitusaha`, `status_neracaawal`, `status_calk`, `created_at`, `updated_at`) VALUES
(1, 'Aditya Fakhri', 'aditya@siacta-desacihideung.com', '$2y$10$6i1IFbxfx2xJI4PQLIcZzudOVTMXjib9B48L2Fmpse0D6BTOoM9cO', 'unitusaha', 1, 'belum_final', 'submitted', '2021-08-03 09:46:43', '2021-08-25 06:33:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akumulasis`
--
ALTER TABLE `akumulasis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `akumulasis_id_user_foreign` (`id_user`);

--
-- Indexes for table `akuns`
--
ALTER TABLE `akuns`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `akuns_no_akun_unique` (`no_akun`),
  ADD KEY `akuns_id_user_foreign` (`id_user`);

--
-- Indexes for table `asetlains`
--
ALTER TABLE `asetlains`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asetlains_id_user_foreign` (`id_user`),
  ADD KEY `asetlains_id_akun_foreign` (`id_akun`);

--
-- Indexes for table `asetleasings`
--
ALTER TABLE `asetleasings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asetleasings_id_user_foreign` (`id_user`),
  ADD KEY `asetleasings_id_akun_foreign` (`id_akun`);

--
-- Indexes for table `asets`
--
ALTER TABLE `asets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asets_id_user_foreign` (`id_user`);

--
-- Indexes for table `asettetaps`
--
ALTER TABLE `asettetaps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asettetaps_id_user_foreign` (`id_user`),
  ADD KEY `asettetaps_id_akun_foreign` (`id_akun`);

--
-- Indexes for table `asettidakberwujuds`
--
ALTER TABLE `asettidakberwujuds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asettidakberwujuds_id_user_foreign` (`id_user`),
  ADD KEY `asettidakberwujuds_id_akun_foreign` (`id_akun`);

--
-- Indexes for table `bukubesarpenyesuaians`
--
ALTER TABLE `bukubesarpenyesuaians`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bukubesarpenyesuaians_id_akun_foreign` (`id_akun`);

--
-- Indexes for table `bukubesars`
--
ALTER TABLE `bukubesars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bukubesars_id_akun_foreign` (`id_akun`);

--
-- Indexes for table `calks`
--
ALTER TABLE `calks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `calks_id_user_foreign` (`id_user`);

--
-- Indexes for table `ekuitas`
--
ALTER TABLE `ekuitas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ekuitas_id_user_foreign` (`id_user`),
  ADD KEY `ekuitas_id_akun_foreign` (`id_akun`);

--
-- Indexes for table `investasipanjangs`
--
ALTER TABLE `investasipanjangs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `investasipanjangs_id_user_foreign` (`id_user`),
  ADD KEY `investasipanjangs_id_akun_foreign` (`id_akun`);

--
-- Indexes for table `investasipendeks`
--
ALTER TABLE `investasipendeks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `investasipendeks_id_user_foreign` (`id_user`),
  ADD KEY `investasipendeks_id_akun_foreign` (`id_akun`);

--
-- Indexes for table `jurnalpenutups`
--
ALTER TABLE `jurnalpenutups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jurnalpenutups_id_bubespen_foreign` (`id_bubespen`),
  ADD KEY `jurnalpenutups_id_akun_foreign` (`id_akun`),
  ADD KEY `jurnalpenutups_id_user_foreign` (`id_user`);

--
-- Indexes for table `jurnalpenyesuaians`
--
ALTER TABLE `jurnalpenyesuaians`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jurnalpenyesuaians_id_transbaru_foreign` (`id_transbaru`),
  ADD KEY `jurnalpenyesuaians_id_akun_foreign` (`id_akun`);

--
-- Indexes for table `jurnalumums`
--
ALTER TABLE `jurnalumums`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jurnalumums_id_transaksi_foreign` (`id_transaksi`),
  ADD KEY `jurnalumums_id_akun_foreign` (`id_akun`);

--
-- Indexes for table `kasbanks`
--
ALTER TABLE `kasbanks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kasbanks_id_user_foreign` (`id_user`),
  ADD KEY `kasbanks_id_akun_foreign` (`id_akun`);

--
-- Indexes for table `kewajibanlains`
--
ALTER TABLE `kewajibanlains`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kewajibanlains_id_user_foreign` (`id_user`),
  ADD KEY `kewajibanlains_id_akun_foreign` (`id_akun`);

--
-- Indexes for table `kewajibanpanjangs`
--
ALTER TABLE `kewajibanpanjangs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kewajibanpanjangs_id_user_foreign` (`id_user`),
  ADD KEY `kewajibanpanjangs_id_akun_foreign` (`id_akun`);

--
-- Indexes for table `kewajibanpendeks`
--
ALTER TABLE `kewajibanpendeks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kewajibanpendeks_id_user_foreign` (`id_user`),
  ADD KEY `kewajibanpendeks_id_akun_foreign` (`id_akun`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `neracasaldoawals`
--
ALTER TABLE `neracasaldoawals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `neracasaldoawals_id_akun_foreign` (`id_akun`);

--
-- Indexes for table `neracasaldos`
--
ALTER TABLE `neracasaldos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `neracasaldos_id_akun_foreign` (`id_akun`),
  ADD KEY `neracasaldos_id_bukubesar_foreign` (`id_bukubesar`);

--
-- Indexes for table `pembayaranmukas`
--
ALTER TABLE `pembayaranmukas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pembayaranmukas_id_user_foreign` (`id_user`),
  ADD KEY `pembayaranmukas_id_akun_foreign` (`id_akun`);

--
-- Indexes for table `perlengkapans`
--
ALTER TABLE `perlengkapans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `perlengkapans_id_user_foreign` (`id_user`),
  ADD KEY `perlengkapans_id_akun_foreign` (`id_akun`);

--
-- Indexes for table `piutangnons`
--
ALTER TABLE `piutangnons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `piutangnons_id_user_foreign` (`id_user`),
  ADD KEY `piutangnons_id_akun_foreign` (`id_akun`);

--
-- Indexes for table `piutangusahas`
--
ALTER TABLE `piutangusahas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `piutangusahas_id_user_foreign` (`id_user`),
  ADD KEY `piutangusahas_id_akun_foreign` (`id_akun`);

--
-- Indexes for table `propertis`
--
ALTER TABLE `propertis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `propertis_id_user_foreign` (`id_user`),
  ADD KEY `propertis_id_akun_foreign` (`id_akun`);

--
-- Indexes for table `transaksis`
--
ALTER TABLE `transaksis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksis_id_akun_foreign` (`id_akun`),
  ADD KEY `transaksis_id_user_foreign` (`id_user`);

--
-- Indexes for table `transbarus`
--
ALTER TABLE `transbarus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transbarus_id_akun_foreign` (`id_akun`),
  ADD KEY `transbarus_id_user_foreign` (`id_user`);

--
-- Indexes for table `unitusahas`
--
ALTER TABLE `unitusahas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_id_unitusaha_foreign` (`id_unitusaha`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akumulasis`
--
ALTER TABLE `akumulasis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akuns`
--
ALTER TABLE `akuns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=350;

--
-- AUTO_INCREMENT for table `asetlains`
--
ALTER TABLE `asetlains`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `asetleasings`
--
ALTER TABLE `asetleasings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `asets`
--
ALTER TABLE `asets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `asettetaps`
--
ALTER TABLE `asettetaps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `asettidakberwujuds`
--
ALTER TABLE `asettidakberwujuds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bukubesarpenyesuaians`
--
ALTER TABLE `bukubesarpenyesuaians`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=476;

--
-- AUTO_INCREMENT for table `bukubesars`
--
ALTER TABLE `bukubesars`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=476;

--
-- AUTO_INCREMENT for table `calks`
--
ALTER TABLE `calks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ekuitas`
--
ALTER TABLE `ekuitas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `investasipanjangs`
--
ALTER TABLE `investasipanjangs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `investasipendeks`
--
ALTER TABLE `investasipendeks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jurnalpenutups`
--
ALTER TABLE `jurnalpenutups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jurnalpenyesuaians`
--
ALTER TABLE `jurnalpenyesuaians`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jurnalumums`
--
ALTER TABLE `jurnalumums`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kasbanks`
--
ALTER TABLE `kasbanks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kewajibanlains`
--
ALTER TABLE `kewajibanlains`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kewajibanpanjangs`
--
ALTER TABLE `kewajibanpanjangs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kewajibanpendeks`
--
ALTER TABLE `kewajibanpendeks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `neracasaldoawals`
--
ALTER TABLE `neracasaldoawals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=352;

--
-- AUTO_INCREMENT for table `neracasaldos`
--
ALTER TABLE `neracasaldos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pembayaranmukas`
--
ALTER TABLE `pembayaranmukas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `perlengkapans`
--
ALTER TABLE `perlengkapans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `piutangnons`
--
ALTER TABLE `piutangnons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `piutangusahas`
--
ALTER TABLE `piutangusahas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `propertis`
--
ALTER TABLE `propertis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksis`
--
ALTER TABLE `transaksis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transbarus`
--
ALTER TABLE `transbarus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `unitusahas`
--
ALTER TABLE `unitusahas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `akumulasis`
--
ALTER TABLE `akumulasis`
  ADD CONSTRAINT `akumulasis_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `akuns`
--
ALTER TABLE `akuns`
  ADD CONSTRAINT `akuns_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `asetlains`
--
ALTER TABLE `asetlains`
  ADD CONSTRAINT `asetlains_id_akun_foreign` FOREIGN KEY (`id_akun`) REFERENCES `akuns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asetlains_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `asetleasings`
--
ALTER TABLE `asetleasings`
  ADD CONSTRAINT `asetleasings_id_akun_foreign` FOREIGN KEY (`id_akun`) REFERENCES `akuns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asetleasings_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `asets`
--
ALTER TABLE `asets`
  ADD CONSTRAINT `asets_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `asettetaps`
--
ALTER TABLE `asettetaps`
  ADD CONSTRAINT `asettetaps_id_akun_foreign` FOREIGN KEY (`id_akun`) REFERENCES `akuns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asettetaps_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `asettidakberwujuds`
--
ALTER TABLE `asettidakberwujuds`
  ADD CONSTRAINT `asettidakberwujuds_id_akun_foreign` FOREIGN KEY (`id_akun`) REFERENCES `akuns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asettidakberwujuds_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `bukubesarpenyesuaians`
--
ALTER TABLE `bukubesarpenyesuaians`
  ADD CONSTRAINT `bukubesarpenyesuaians_id_akun_foreign` FOREIGN KEY (`id_akun`) REFERENCES `akuns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `bukubesars`
--
ALTER TABLE `bukubesars`
  ADD CONSTRAINT `bukubesars_id_akun_foreign` FOREIGN KEY (`id_akun`) REFERENCES `akuns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `calks`
--
ALTER TABLE `calks`
  ADD CONSTRAINT `calks_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ekuitas`
--
ALTER TABLE `ekuitas`
  ADD CONSTRAINT `ekuitas_id_akun_foreign` FOREIGN KEY (`id_akun`) REFERENCES `akuns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ekuitas_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `investasipanjangs`
--
ALTER TABLE `investasipanjangs`
  ADD CONSTRAINT `investasipanjangs_id_akun_foreign` FOREIGN KEY (`id_akun`) REFERENCES `akuns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `investasipanjangs_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `investasipendeks`
--
ALTER TABLE `investasipendeks`
  ADD CONSTRAINT `investasipendeks_id_akun_foreign` FOREIGN KEY (`id_akun`) REFERENCES `akuns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `investasipendeks_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jurnalpenutups`
--
ALTER TABLE `jurnalpenutups`
  ADD CONSTRAINT `jurnalpenutups_id_akun_foreign` FOREIGN KEY (`id_akun`) REFERENCES `akuns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jurnalpenutups_id_bubespen_foreign` FOREIGN KEY (`id_bubespen`) REFERENCES `bukubesarpenyesuaians` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jurnalpenutups_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jurnalpenyesuaians`
--
ALTER TABLE `jurnalpenyesuaians`
  ADD CONSTRAINT `jurnalpenyesuaians_id_akun_foreign` FOREIGN KEY (`id_akun`) REFERENCES `akuns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jurnalpenyesuaians_id_transbaru_foreign` FOREIGN KEY (`id_transbaru`) REFERENCES `transbarus` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jurnalumums`
--
ALTER TABLE `jurnalumums`
  ADD CONSTRAINT `jurnalumums_id_akun_foreign` FOREIGN KEY (`id_akun`) REFERENCES `akuns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jurnalumums_id_transaksi_foreign` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kasbanks`
--
ALTER TABLE `kasbanks`
  ADD CONSTRAINT `kasbanks_id_akun_foreign` FOREIGN KEY (`id_akun`) REFERENCES `akuns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kasbanks_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kewajibanlains`
--
ALTER TABLE `kewajibanlains`
  ADD CONSTRAINT `kewajibanlains_id_akun_foreign` FOREIGN KEY (`id_akun`) REFERENCES `akuns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kewajibanlains_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kewajibanpanjangs`
--
ALTER TABLE `kewajibanpanjangs`
  ADD CONSTRAINT `kewajibanpanjangs_id_akun_foreign` FOREIGN KEY (`id_akun`) REFERENCES `akuns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kewajibanpanjangs_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kewajibanpendeks`
--
ALTER TABLE `kewajibanpendeks`
  ADD CONSTRAINT `kewajibanpendeks_id_akun_foreign` FOREIGN KEY (`id_akun`) REFERENCES `akuns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kewajibanpendeks_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `neracasaldoawals`
--
ALTER TABLE `neracasaldoawals`
  ADD CONSTRAINT `neracasaldoawals_id_akun_foreign` FOREIGN KEY (`id_akun`) REFERENCES `akuns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `neracasaldos`
--
ALTER TABLE `neracasaldos`
  ADD CONSTRAINT `neracasaldos_id_akun_foreign` FOREIGN KEY (`id_akun`) REFERENCES `akuns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `neracasaldos_id_bukubesar_foreign` FOREIGN KEY (`id_bukubesar`) REFERENCES `bukubesars` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pembayaranmukas`
--
ALTER TABLE `pembayaranmukas`
  ADD CONSTRAINT `pembayaranmukas_id_akun_foreign` FOREIGN KEY (`id_akun`) REFERENCES `akuns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pembayaranmukas_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `perlengkapans`
--
ALTER TABLE `perlengkapans`
  ADD CONSTRAINT `perlengkapans_id_akun_foreign` FOREIGN KEY (`id_akun`) REFERENCES `akuns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `perlengkapans_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `piutangnons`
--
ALTER TABLE `piutangnons`
  ADD CONSTRAINT `piutangnons_id_akun_foreign` FOREIGN KEY (`id_akun`) REFERENCES `akuns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `piutangnons_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `piutangusahas`
--
ALTER TABLE `piutangusahas`
  ADD CONSTRAINT `piutangusahas_id_akun_foreign` FOREIGN KEY (`id_akun`) REFERENCES `akuns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `piutangusahas_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `propertis`
--
ALTER TABLE `propertis`
  ADD CONSTRAINT `propertis_id_akun_foreign` FOREIGN KEY (`id_akun`) REFERENCES `akuns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `propertis_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaksis`
--
ALTER TABLE `transaksis`
  ADD CONSTRAINT `transaksis_id_akun_foreign` FOREIGN KEY (`id_akun`) REFERENCES `akuns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaksis_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transbarus`
--
ALTER TABLE `transbarus`
  ADD CONSTRAINT `transbarus_id_akun_foreign` FOREIGN KEY (`id_akun`) REFERENCES `akuns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transbarus_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_id_unitusaha_foreign` FOREIGN KEY (`id_unitusaha`) REFERENCES `unitusahas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
