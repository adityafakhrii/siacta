-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 18, 2021 at 09:50 AM
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
(1, 1, '11.01.00', 'Kas', 'debit', 'tidak_pen', '2021-08-18 04:57:41', '2021-08-18 04:57:41'),
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
(27, 1, '13.0212', 'DETI 02/14', 'debit', 'tidak_pen', '2021-08-18 05:14:24', '2021-08-18 05:14:24'),
(28, 1, '13.02.13', 'ENGKOS 02/14', 'debit', 'tidak_pen', '2021-08-18 05:14:49', '2021-08-18 05:14:49'),
(29, 1, '13.02.14', 'ENJANG 02/14', 'debit', 'tidak_pen', '2021-08-18 05:15:11', '2021-08-18 05:15:11'),
(30, 1, '13.02.15', 'GURU JAJANG 02/14', 'debit', 'tidak_pen', '2021-08-18 05:15:34', '2021-08-18 05:15:34'),
(31, 1, '13.02.16', 'H. SANA 02/14', 'debit', 'tidak_pen', '2021-08-18 05:15:54', '2021-08-18 05:15:54'),
(32, 1, '13.02.17', 'H.AYUB I 02/14', 'debit', 'tidak_pen', '2021-08-18 05:16:14', '2021-08-18 05:16:14'),
(34, 1, '13.02.18', 'H. AYUB II 02/14', 'debit', 'tidak_pen', '2021-08-18 05:19:27', '2021-08-18 05:19:27'),
(35, 1, '13.02.19', 'IKIN 02/14', 'debit', 'tidak_pen', '2021-08-18 05:19:49', '2021-08-18 05:19:49'),
(36, 1, '13.02.20', 'JUHANA 02/14', 'debit', 'tidak_pen', '2021-08-18 05:20:41', '2021-08-18 05:20:41');

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
(33, 27, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:14:24', '2021-08-18 05:14:24'),
(34, 28, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:14:49', '2021-08-18 05:14:49'),
(35, 29, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:15:11', '2021-08-18 05:15:11'),
(36, 30, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:15:34', '2021-08-18 05:15:34'),
(37, 31, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:15:54', '2021-08-18 05:15:54'),
(38, 32, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:16:14', '2021-08-18 05:16:14'),
(39, 34, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:19:27', '2021-08-18 05:19:27'),
(40, 35, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:19:49', '2021-08-18 05:19:49'),
(41, 36, 0, NULL, 0, 'Saldo Awal', '2021-08-18 05:20:41', '2021-08-18 05:20:41');

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
(28, '2021_08_16_110315_create_neracasaldos_table', 11);

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
(7, 1, 0, NULL, 'belum_final', '2021-08-18 04:57:41', '2021-08-18 04:57:41'),
(8, 2, 0, NULL, 'belum_final', '2021-08-18 04:58:13', '2021-08-18 04:58:13'),
(9, 3, 0, NULL, 'belum_final', '2021-08-18 04:59:05', '2021-08-18 04:59:05'),
(10, 4, NULL, 0, 'belum_final', '2021-08-18 04:59:48', '2021-08-18 04:59:48'),
(11, 5, NULL, 0, 'belum_final', '2021-08-18 05:00:25', '2021-08-18 05:00:25'),
(12, 6, NULL, 0, 'belum_final', '2021-08-18 05:00:47', '2021-08-18 05:00:47'),
(13, 7, NULL, 0, 'belum_final', '2021-08-18 05:01:36', '2021-08-18 05:01:36'),
(14, 8, NULL, 0, 'belum_final', '2021-08-18 05:03:32', '2021-08-18 05:03:32'),
(15, 9, 0, NULL, 'belum_final', '2021-08-18 05:03:58', '2021-08-18 05:03:58'),
(16, 10, 0, NULL, 'belum_final', '2021-08-18 05:06:06', '2021-08-18 05:06:06'),
(17, 11, 0, NULL, 'belum_final', '2021-08-18 05:06:50', '2021-08-18 05:06:50'),
(18, 12, 0, NULL, 'belum_final', '2021-08-18 05:07:23', '2021-08-18 05:07:23'),
(19, 13, 0, NULL, 'belum_final', '2021-08-18 05:07:59', '2021-08-18 05:07:59'),
(20, 14, 0, NULL, 'belum_final', '2021-08-18 05:08:54', '2021-08-18 05:08:54'),
(21, 15, 0, NULL, 'belum_final', '2021-08-18 05:09:22', '2021-08-18 05:09:22'),
(22, 16, 0, NULL, 'belum_final', '2021-08-18 05:09:45', '2021-08-18 05:09:45'),
(23, 17, 0, NULL, 'belum_final', '2021-08-18 05:10:07', '2021-08-18 05:10:07'),
(24, 18, 0, NULL, 'belum_final', '2021-08-18 05:10:33', '2021-08-18 05:10:33'),
(25, 19, 0, NULL, 'belum_final', '2021-08-18 05:10:54', '2021-08-18 05:10:54'),
(26, 20, 0, NULL, 'belum_final', '2021-08-18 05:11:14', '2021-08-18 05:11:14'),
(27, 21, 0, NULL, 'belum_final', '2021-08-18 05:11:43', '2021-08-18 05:11:43'),
(28, 22, 0, NULL, 'belum_final', '2021-08-18 05:12:04', '2021-08-18 05:12:04'),
(29, 23, 0, NULL, 'belum_final', '2021-08-18 05:12:28', '2021-08-18 05:12:28'),
(30, 24, 0, NULL, 'belum_final', '2021-08-18 05:12:52', '2021-08-18 05:12:52'),
(31, 25, 0, NULL, 'belum_final', '2021-08-18 05:13:26', '2021-08-18 05:13:26'),
(32, 26, 0, NULL, 'belum_final', '2021-08-18 05:13:50', '2021-08-18 05:13:50'),
(33, 27, 0, NULL, 'belum_final', '2021-08-18 05:14:24', '2021-08-18 05:14:24'),
(34, 28, 0, NULL, 'belum_final', '2021-08-18 05:14:49', '2021-08-18 05:14:49'),
(35, 29, 0, NULL, 'belum_final', '2021-08-18 05:15:11', '2021-08-18 05:15:11'),
(36, 30, 0, NULL, 'belum_final', '2021-08-18 05:15:34', '2021-08-18 05:15:34'),
(37, 31, 0, NULL, 'belum_final', '2021-08-18 05:15:54', '2021-08-18 05:15:54'),
(38, 32, 0, NULL, 'belum_final', '2021-08-18 05:16:14', '2021-08-18 05:16:14'),
(39, 34, 0, NULL, 'belum_final', '2021-08-18 05:19:27', '2021-08-18 05:19:27'),
(40, 35, 0, NULL, 'belum_final', '2021-08-18 05:19:49', '2021-08-18 05:19:49'),
(41, 36, 0, NULL, 'belum_final', '2021-08-18 05:20:41', '2021-08-18 05:20:41');

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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `role`, `id_unitusaha`, `status_neracaawal`, `created_at`, `updated_at`) VALUES
(1, 'Aditya Fakhri', 'aditya@siacta-desacihideung.com', '$2y$10$6i1IFbxfx2xJI4PQLIcZzudOVTMXjib9B48L2Fmpse0D6BTOoM9cO', 'unitusaha', 1, 'belum_final', '2021-08-03 09:46:43', '2021-08-09 16:30:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akuns`
--
ALTER TABLE `akuns`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `akuns_no_akun_unique` (`no_akun`),
  ADD KEY `akuns_id_user_foreign` (`id_user`);

--
-- Indexes for table `bukubesars`
--
ALTER TABLE `bukubesars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bukubesars_id_akun_foreign` (`id_akun`);

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
-- AUTO_INCREMENT for table `akuns`
--
ALTER TABLE `akuns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `bukubesars`
--
ALTER TABLE `bukubesars`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `jurnalpenyesuaians`
--
ALTER TABLE `jurnalpenyesuaians`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jurnalumums`
--
ALTER TABLE `jurnalumums`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `neracasaldoawals`
--
ALTER TABLE `neracasaldoawals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `neracasaldos`
--
ALTER TABLE `neracasaldos`
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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
-- Constraints for table `akuns`
--
ALTER TABLE `akuns`
  ADD CONSTRAINT `akuns_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `bukubesars`
--
ALTER TABLE `bukubesars`
  ADD CONSTRAINT `bukubesars_id_akun_foreign` FOREIGN KEY (`id_akun`) REFERENCES `akuns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
