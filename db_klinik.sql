-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 20 Bulan Mei 2025 pada 21.52
-- Versi server: 10.11.11-MariaDB-cll-lve
-- Versi PHP: 8.3.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `buatsof1_klinik`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `clinics`
--

CREATE TABLE `clinics` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `schedule` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `clinics`
--

INSERT INTO `clinics` (`id`, `name`, `address`, `phone`, `schedule`, `created_at`, `updated_at`) VALUES
(1, 'Klinik Sehat', 'Jl. Merdeka No. 1, Jakarta', '081234567890', 'Senin - Jumat, 08:00 - 17:00', '2025-03-07 03:43:11', '2025-03-07 03:43:11'),
(2, 'Klinik Amanah', 'Jl. Sudirman No. 10, Bandung', '081298765432', 'Senin - Sabtu, 09:00 - 18:00', '2025-03-07 03:43:11', '2025-03-07 03:43:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `consultations`
--

CREATE TABLE `consultations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `schedule` datetime NOT NULL,
  `status` enum('scheduled','completed','canceled') DEFAULT 'scheduled',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `consultations`
--

INSERT INTO `consultations` (`id`, `user_id`, `doctor_id`, `schedule`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2025-03-10 10:00:00', 'scheduled', '2025-03-07 03:43:11', '2025-03-07 03:43:11'),
(2, 2, 2, '2025-03-11 14:00:00', 'completed', '2025-03-07 03:43:11', '2025-03-07 03:43:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `consultation_history`
--

CREATE TABLE `consultation_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `diagnosis` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `consultation_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `consultation_history`
--

INSERT INTO `consultation_history` (`id`, `user_id`, `doctor_id`, `diagnosis`, `notes`, `consultation_date`, `updated_at`) VALUES
(1, 1, 1, NULL, 'Pasien mengalami demam ringan.', '2025-03-07 03:43:11', '2025-03-07 03:43:11'),
(2, 2, 2, NULL, 'Keluhan sakit kepala berkurang setelah minum obat.', '2025-03-07 03:43:11', '2025-03-07 03:43:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `specialization` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `image` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `doctors`
--

INSERT INTO `doctors` (`id`, `name`, `specialization`, `phone`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Dr. Andi Wijaya To', 'Umum', '33441122', 'img/doctor/jXJf4nM2TuXRyLjJJrA7NQAANDp47R7O8kL2GiZq.jpg', '2025-03-07 03:43:11', '2025-05-20 14:21:08'),
(2, 'Dr. Siti Marlina', 'Gigi', '081322334455', NULL, '2025-03-07 03:43:11', '2025-03-07 03:43:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `dog_care_guides`
--

CREATE TABLE `dog_care_guides` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `dog_care_guides`
--

INSERT INTO `dog_care_guides` (`id`, `title`, `content`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Cara Merawat Anjing di Rumah', 'Pastikan anjing mendapatkan makanan bergizi dan rutin diperiksa ke dokter hewan.', NULL, '2025-03-07 03:43:11', '2025-03-07 03:43:11'),
(2, 'Vaksinasi Anjing', 'Vaksinasi wajib dilakukan sejak dini untuk mencegah penyakit berbahaya.', NULL, '2025-03-07 03:43:11', '2025-03-07 03:43:11'),
(3, 'Coba', 'Coba', 'img/guide/p4CSLS86dQBPFxPco60rqKdFVN1e9IB20RwuXDiN.jpg', '2025-05-20 13:15:38', '2025-05-20 14:10:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ectoparasite_diseases`
--

CREATE TABLE `ectoparasite_diseases` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `symptoms` text NOT NULL,
  `treatment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `ectoparasite_diseases`
--

INSERT INTO `ectoparasite_diseases` (`id`, `name`, `symptoms`, `treatment`, `created_at`, `updated_at`) VALUES
(1, 'Kutu Anjing', 'Gatal-gatal, kulit merah, sering menggaruk.', 'Gunakan sampo anti-kutu dan konsultasi dengan dokter hewan.', '2025-03-07 03:43:11', '2025-03-07 03:43:11'),
(2, 'Scabies', 'Kulit bersisik, rontok, dan luka akibat garukan.', 'Salep khusus scabies dan obat oral.', '2025-03-07 03:43:11', '2025-03-07 03:43:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `medical_records`
--

CREATE TABLE `medical_records` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `diagnosis` text NOT NULL,
  `treatment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `medical_records`
--

INSERT INTO `medical_records` (`id`, `user_id`, `doctor_id`, `diagnosis`, `treatment`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Flu ringan', 'Obat pereda flu dan istirahat cukup.', '2025-03-07 03:43:11', '2025-03-07 03:43:11'),
(2, 2, 2, 'Gigi berlubang', 'Tambal gigi dan hindari makanan manis berlebih.', '2025-03-07 03:43:11', '2025-03-07 03:43:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_04_27_010828_create_provinces_table', 1),
(4, '2019_04_27_010829_create_cities_table', 1),
(5, '2019_04_27_010830_create_districts_table', 1),
(6, '2019_05_04_155956_create_banners_table', 1),
(7, '2019_10_27_070618_create_master_table', 1),
(8, '2019_10_27_073331_create_raw_material_table', 1),
(9, '2019_10_27_074032_create_group_profile_table', 1),
(10, '2019_10_27_080518_create_group_item_table', 1),
(11, '2019_10_27_080556_create_group_bom_table', 1),
(12, '2019_10_27_080643_create_group_sales_table', 1),
(13, '2019_10_27_080644_create_group_purchase_table', 1),
(14, '2019_10_27_080645_create_group_inventory_table', 1),
(15, '2019_10_27_080745_create_group_production_table', 1),
(16, '2019_11_16_044518_create_log_prints_table', 1),
(17, '2019_11_17_122431_create_shipping_instructions_table', 1),
(18, '2019_11_17_122432_create_delivery_notes_table', 1),
(19, '2019_11_17_122450_create_shipping_instruction_details_table', 1),
(20, '2019_11_17_122451_create_delivery_note_details_table', 1),
(21, '2019_11_17_160651_create_sales_invoices_table', 1),
(22, '2019_11_17_160707_create_account_payables_table', 1),
(23, '2019_11_17_160716_create_account_receivables_table', 1),
(24, '2019_11_17_160717_create_sales_transactions_table', 1),
(25, '2019_11_18_130828_create_group_user_role_table', 1),
(26, '2019_11_28_024258_add_token_attributs_to_users_table', 1),
(27, '2019_12_07_013629_create_item_lengths_table', 1),
(28, '2019_12_08_080756_alter_region_users_table', 1),
(29, '2019_12_11_080829_create_inventory_adjustments_table', 1),
(30, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(31, '2019_12_19_043943_create_log_sales_transaction_notifications_table', 1),
(32, '2019_12_22_093059_create_shipping_costs_table', 1),
(33, '2019_12_23_123634_create_log_city_distances_table', 1),
(34, '2019_12_24_072656_create_application_paylaters_table', 1),
(35, '2019_12_25_221432_create_group_vouchers_table', 1),
(36, '2019_12_25_221433_create_chat_types_table', 1),
(37, '2019_12_25_221434_create_chat_headers_table', 1),
(38, '2019_12_25_221435_create_chat_messages_table', 1),
(39, '2020_01_18_014851_create_term_of_services_table', 1),
(40, '2020_03_20_131920_create_group_asset_table', 1),
(41, '2020_07_04_131901_create_asset_loans_return', 1),
(42, '2020_07_05_143634_create_coa_table', 1),
(43, '2020_07_07_214705_change_table_coa', 1),
(44, '2020_07_07_214929_create_finance_general_ledger', 1),
(45, '2020_07_08_124601_change_finance_coa', 1),
(46, '2020_07_08_134044_create_jobs_table', 1),
(47, '2020_07_08_141619_create_failed_jobs_table', 1),
(48, '2020_07_10_085935_change_payment_bank_channel', 1),
(49, '2020_07_14_150956_create_vouchers_table', 1),
(50, '2020_07_22_093616_create_template_income_statements_table', 1),
(51, '2020_07_22_210505_create_template_balance_sheets_table', 1),
(52, '2020_07_24_014211_create_sales_targets_table', 1),
(53, '2020_07_29_145312_add_lk', 1),
(54, '2020_08_21_002557_add_grade_to_item', 1),
(55, '2020_08_21_005217_add_min_stock_to_raw_materials', 1),
(56, '2020_08_21_042251_add_capacity_to_warehouses', 1),
(57, '2020_08_22_180136_delete_capacity_from_warehouses', 1),
(58, '2020_08_22_180822_add_stock_planning_to_items', 1),
(59, '2020_08_22_181301_add_stock_planning_to_raw_materials', 1),
(60, '2020_09_01_031740_change_finance_general_ledger', 1),
(61, '2020_10_03_002949_add_material_id_to_purchase_details', 1),
(62, '2024_09_21_082620_create_invoices_table', 2),
(63, '2024_09_21_082621_create_tax_invoices_table', 2),
(64, '2024_09_21_094912_create_vendor_token_table', 3),
(65, '2024_12_09_100113_create_running_text_table', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('pending','paid','completed','canceled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 50000.00, 'paid', '2025-05-02 08:07:09', '2025-05-18 04:55:29'),
(2, 6, 50000.00, 'pending', '2025-05-02 08:50:53', '2025-05-02 08:50:53'),
(3, 6, 50000.00, 'pending', '2025-05-02 08:51:13', '2025-05-02 08:51:13'),
(4, 2, 50000.00, 'pending', '2025-05-08 03:26:29', '2025-05-08 03:26:29'),
(5, 2, 50000.00, 'pending', '2025-05-08 03:26:49', '2025-05-08 03:26:49'),
(6, 2, 30000.00, 'pending', '2025-05-10 06:07:35', '2025-05-10 06:07:35'),
(7, 2, 30000.00, 'pending', '2025-05-15 02:05:38', '2025-05-15 02:05:38'),
(8, 8, 30000.00, 'paid', '2025-05-18 02:10:05', '2025-05-18 10:52:25'),
(9, 8, 50000.00, 'pending', '2025-05-20 09:52:12', '2025-05-20 09:52:12'),
(10, 13, 50000.00, 'pending', '2025-05-20 10:32:28', '2025-05-20 10:32:28'),
(11, 13, 50000.00, 'pending', '2025-05-20 10:39:02', '2025-05-20 10:39:02');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 50000.00, '2025-05-02 08:07:09', '2025-05-02 08:07:09'),
(2, 2, 1, 1, 50000.00, '2025-05-02 08:50:53', '2025-05-02 08:50:53'),
(3, 3, 1, 1, 50000.00, '2025-05-02 08:51:13', '2025-05-02 08:51:13'),
(4, 4, 1, 1, 50000.00, '2025-05-08 03:26:29', '2025-05-08 03:26:29'),
(5, 5, 1, 1, 50000.00, '2025-05-08 03:26:49', '2025-05-08 03:26:49'),
(6, 6, 2, 1, 30000.00, '2025-05-10 06:07:35', '2025-05-10 06:07:35'),
(7, 7, 2, 1, 30000.00, '2025-05-15 02:05:38', '2025-05-15 02:05:38'),
(8, 8, 2, 1, 30000.00, '2025-05-18 02:10:05', '2025-05-18 02:10:05'),
(9, 9, 1, 1, 50000.00, '2025-05-20 09:52:12', '2025-05-20 09:52:12'),
(10, 10, 1, 1, 50000.00, '2025-05-20 10:32:28', '2025-05-20 10:32:28'),
(11, 11, 1, 1, 50000.00, '2025-05-20 10:39:02', '2025-05-20 10:39:02');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `category` enum('obat','perawatan') NOT NULL,
  `image` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock`, `category`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Antibiotik Hewan', 'Obat antibiotik khusus untuk hewan peliharaan.', 50000.00, 92, 'obat', 'img/product/5TvNFwSfkTwQuSXEDwoH6z6kqTw3Q4Vm9DYD4z2G.jpg', '2025-03-07 08:07:14', '2025-05-20 10:39:02'),
(2, 'Vitamin Kucing & Anjing', 'Vitamin tambahan untuk meningkatkan daya tahan tubuh hewan.', 30000.00, 197, 'obat', 'vitamin-hewan.jpg', '2025-03-07 08:07:14', '2025-05-18 02:10:05'),
(3, 'Sampo Anti Kutu', 'Perawatan bulu hewan agar bebas dari kutu dan tetap sehat.', 45000.00, 150, 'perawatan', 'sampo-anti-kutu.jpg', '2025-03-07 08:07:14', '2025-03-07 08:07:14'),
(4, 'Salep Luka Hewan', 'Salep antiseptik untuk menyembuhkan luka pada hewan.', 60000.00, 80, 'perawatan', 'salep-luka-hewan.jpg', '2025-03-07 08:07:14', '2025-03-07 08:07:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `profiles`
--

CREATE TABLE `profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `image` varchar(191) DEFAULT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `fax` varchar(191) DEFAULT NULL,
  `npwp_number` varchar(191) DEFAULT NULL COMMENT 'nomor npwp',
  `identity_number` varchar(191) DEFAULT NULL COMMENT 'nomor ktp',
  `identity_image` varchar(191) DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_scan` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `profiles`
--

INSERT INTO `profiles` (`id`, `name`, `image`, `phone`, `fax`, `npwp_number`, `identity_number`, `identity_image`, `company_id`, `user_id`, `is_active`, `is_scan`, `created_at`, `updated_at`) VALUES
(1, 'Akhmad Naufal', NULL, '085895533053', NULL, NULL, '35782010010101111', NULL, NULL, 2, 1, 0, '2024-10-02 18:46:59', '2024-10-02 18:46:59'),
(2, 'PT PLN', NULL, NULL, NULL, NULL, '35782010010101111', NULL, NULL, 3, 1, 0, '2024-10-14 16:30:47', '2024-10-14 16:30:47'),
(3, 'Akhmad Naufal Refandi', NULL, '08579976679', NULL, NULL, NULL, NULL, NULL, 4, 1, 0, '2025-04-21 04:31:07', '2025-04-21 04:31:07'),
(4, 'Natan', NULL, '628135394131', NULL, NULL, NULL, NULL, NULL, 5, 1, 0, '2025-05-02 08:46:46', '2025-05-02 08:46:46'),
(5, 'Natan1234', NULL, '081353941310', NULL, NULL, NULL, NULL, NULL, 6, 1, 0, '2025-05-02 08:47:51', '2025-05-02 08:47:51'),
(6, 'Testing', 'img/customer/u6fWsVBVXQA78qgvwawRBi5uolUp9aBnc0rmLa8z.jpg', '087111828121', NULL, NULL, NULL, NULL, NULL, 7, 1, 0, '2025-05-13 12:06:37', '2025-05-20 14:51:47'),
(7, 'windah', NULL, '0813846813', NULL, NULL, NULL, NULL, NULL, 8, 1, 1, '2025-05-18 01:42:42', '2025-05-18 01:42:42'),
(8, 'jokowi', NULL, '0138446346', NULL, NULL, NULL, NULL, NULL, 13, 1, 1, '2025-05-20 10:10:16', '2025-05-20 10:10:56'),
(9, 'coba', NULL, '085895533536', NULL, NULL, NULL, NULL, NULL, 14, 1, 0, '2025-05-20 10:13:35', '2025-05-20 10:13:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `profile_addresses`
--

CREATE TABLE `profile_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `address` varchar(191) NOT NULL,
  `longtitude` varchar(191) DEFAULT NULL,
  `latitude` varchar(191) DEFAULT NULL,
  `region_type` smallint(6) DEFAULT NULL COMMENT '0=city, 1=district',
  `region_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'city_id / district_id tergantung region typenya',
  `is_default` tinyint(1) NOT NULL DEFAULT 1,
  `is_billing_address` tinyint(1) NOT NULL DEFAULT 1,
  `profile_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `profile_addresses`
--

INSERT INTO `profile_addresses` (`id`, `address`, `longtitude`, `latitude`, `region_type`, `region_id`, `is_default`, `is_billing_address`, `profile_id`, `is_active`, `created_at`, `updated_at`) VALUES
(3, 'Jl. Karangan Jaya VIII / 7', NULL, NULL, 0, 63, 1, 1, 2, 1, '2024-10-20 19:41:40', '2024-10-20 19:41:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `profile_transaction_settings`
--

CREATE TABLE `profile_transaction_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `limit` int(11) DEFAULT NULL,
  `tempo_type` varchar(12) NOT NULL DEFAULT 'NOT_USED' COMMENT 'lihat const model profile_transaction_settings',
  `tempo_charge_day` int(11) DEFAULT NULL COMMENT 'date/day tergantung tempo_type',
  `tempo_charge_month` int(11) DEFAULT NULL,
  `tempo_charge_week` int(11) DEFAULT NULL,
  `markdown_sales` int(11) DEFAULT NULL,
  `markdown_purchase` int(11) DEFAULT NULL,
  `is_allowed_paylater` tinyint(1) NOT NULL DEFAULT 0,
  `is_allowed_installment` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'cicilan',
  `minimum_downpayment` int(11) DEFAULT NULL COMMENT 'dp dalam %',
  `payment_method_id` bigint(20) UNSIGNED NOT NULL,
  `profile_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `purchase_history`
--

CREATE TABLE `purchase_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `purchase_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `reservations`
--

CREATE TABLE `reservations` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `pet_name` varchar(255) NOT NULL,
  `pet_type` varchar(100) NOT NULL,
  `reservation_date` date NOT NULL,
  `reservation_time` time NOT NULL,
  `symptoms` text DEFAULT NULL,
  `doctor_notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `reservations`
--

INSERT INTO `reservations` (`id`, `user_id`, `pet_name`, `pet_type`, `reservation_date`, `reservation_time`, `symptoms`, `doctor_notes`, `created_at`, `updated_at`) VALUES
(1, 2, 'Jon', 'Anjing', '2025-05-19', '09:00:00', 'kulit', 'OKeee', '2025-05-18 01:28:02', '2025-05-18 04:35:38'),
(3, 8, 'anjing', 'anjing', '2025-05-29', '11:00:00', 'sakit kusta', 'aman diberi obat', '2025-05-18 03:58:18', '2025-05-18 06:03:06'),
(4, 8, 'ikan', 'ome', '2025-05-22', '11:00:00', 'makan', NULL, '2025-05-20 09:55:22', '2025-05-20 09:55:22'),
(5, 13, 'hewn', 'ikan', '2025-05-23', '11:00:00', 'jwb', NULL, '2025-05-20 14:12:53', '2025-05-20 14:12:53'),
(6, 13, 'ciko', 'kucing', '2025-05-29', '11:00:00', 'tangan luka', NULL, '2025-05-20 14:24:36', '2025-05-20 14:24:36');

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(25) NOT NULL,
  `display_name` varchar(25) NOT NULL,
  `description` text DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `parent_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'super_admin', 'Super Admin', NULL, NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `role_menus`
--

CREATE TABLE `role_menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_key` varchar(191) NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `role_menus`
--

INSERT INTO `role_menus` (`id`, `menu_key`, `role_id`, `created_at`, `updated_at`) VALUES
(68, 'master/employee/role', 1, '2024-09-20 19:59:53', '2024-09-20 19:59:53'),
(69, 'master/employee', 1, '2024-09-20 19:59:53', '2024-09-20 19:59:53'),
(106, 'karyawan', 1, '2024-12-06 08:09:23', '2024-12-06 08:09:23'),
(126, 'master', 1, '2025-02-17 07:10:18', '2025-02-17 07:10:18'),
(127, 'master/clinic', 1, '2025-02-17 07:10:18', '2025-02-17 07:10:18'),
(128, 'master/doctor', 1, '2025-02-17 07:10:18', '2025-02-17 07:10:18'),
(129, 'master/guide', 1, '2025-02-17 07:10:18', '2025-02-17 07:10:18'),
(130, 'master/product', 1, '2025-02-17 07:10:18', '2025-02-17 07:10:18'),
(131, 'riwayat', 1, '2025-02-17 07:10:18', '2025-02-17 07:10:18'),
(133, 'history/history-purchase', 1, '2025-02-17 07:10:18', '2025-02-17 07:10:18'),
(137, 'laporan', 1, '2025-02-17 07:10:18', '2025-02-17 07:10:18'),
(138, 'order/report-consultation', 1, '2025-02-17 07:10:18', '2025-02-17 07:10:18'),
(139, 'order/report-purchase', 1, '2025-02-17 07:10:18', '2025-02-17 07:10:18'),
(140, 'report/report-examination', 1, '2025-02-17 07:10:18', '2025-02-17 07:10:18'),
(141, 'history/history-reservation', 1, '2025-05-18 02:03:42', '2025-05-18 02:03:42'),
(142, 'history/history-scan', 1, '2025-05-18 02:03:42', '2025-05-18 02:03:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `scan_result`
--

CREATE TABLE `scan_result` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `photo` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `scan_result`
--

INSERT INTO `scan_result` (`id`, `user_id`, `photo`, `created_at`, `updated_at`) VALUES
(1, 2, 'scans/ynkYj6SIDQ7ZknRAQgHZ0NEfLtaV25LuKT8FejHp.jpg', '2025-05-18 01:32:58', '2025-05-18 01:32:58'),
(2, 2, 'scans/znWuOxFW9z4TBcU1x5iQwOSjZLGUr2Hs7tyYbYe4.jpg', '2025-05-18 01:35:39', '2025-05-18 01:35:39'),
(3, 2, 'scans/jZVyOYT5sfyyTBVQSaXJWTko0wpnRtbk0kVTCagZ.jpg', '2025-05-18 01:35:43', '2025-05-18 01:35:43'),
(4, 8, 'scans/M1s0pILXTii5Zj5NHK40nmnKzvP0LTdqknT9tmDj.jpg', '2025-05-18 01:43:40', '2025-05-18 01:43:40'),
(5, 8, 'scans/E34icZv14XuJoYVUt54Ia7SD7y5vBZB3uhC7mZaM.jpg', '2025-05-18 01:43:42', '2025-05-18 01:43:42'),
(6, 8, 'scans/xLj5IdsQyAaXIHWSQxyFeOqM9gkVDB2ybV30Oz0S.jpg', '2025-05-18 02:13:23', '2025-05-18 02:13:23'),
(7, 8, 'scans/Y3PoiukXCU1I9UYCNzhqsL6ocvIGysk2V3GEMCox.jpg', '2025-05-18 02:14:39', '2025-05-18 02:14:39'),
(8, 2, 'scans/K0sZyJ9oUbLySN5PRNtHea1fQjrUC2xecUGwHHGD.jpg', '2025-05-18 02:16:44', '2025-05-18 02:16:44'),
(9, 2, 'scans/DIbm2Rhfc4csV8zqNq4iNxCYGGH41PbHZyoskDBF.jpg', '2025-05-18 02:40:06', '2025-05-18 02:40:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `notification_channel_id` varchar(191) DEFAULT NULL COMMENT 'onesignal player id',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `token_api` varchar(191) DEFAULT NULL,
  `token_email_verification` varchar(191) DEFAULT NULL,
  `region_type` smallint(6) DEFAULT NULL COMMENT '0=city, 1=district',
  `region_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'city_id / district_id tergantung region typenya'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `notification_channel_id`, `remember_token`, `created_at`, `updated_at`, `role_id`, `token_api`, `token_email_verification`, `region_type`, `region_id`) VALUES
(1, 'ERP Administrator', 'admin@klinik.com', NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(2, 'Natan', 'natan@gmail.com', NULL, '$2y$10$3uzDiVpt4L3fV91KfMtkqubKc0abrlAlO4PA7jl/4T.4Qno4hjInu', NULL, NULL, '2024-10-02 18:46:59', '2025-05-08 02:40:10', 2, 'KfjthKT2yq7K99jQwRTbYQSJKilXLbRrQ1VVruRaAOTxsMZajqQbKwMEsEoo', NULL, 0, NULL),
(3, 'PT PLN', 'ptpln@gmail.com', NULL, '$2y$10$5MQE4I45jEViLAxtT2/XsONgcNLwQ.iQ5ytXSi7txdPpNvhgyMHlC', NULL, NULL, '2024-10-14 16:30:47', '2024-10-20 19:41:40', 2, NULL, NULL, 0, NULL),
(4, 'Akhmad Naufal Refandi', 'nopal123@gmail.com', NULL, '$2y$10$CJO6Hl2fkDH5zNUgc26jDOWtbiCXIBtdGDTL8oxf5unhki33DfYCS', NULL, NULL, '2025-04-21 04:31:07', '2025-04-21 04:31:07', 2, '7QQca9LOqQ7OIlJuu1Kcx28R0NMJzUPbKkyUbJ1oHeN3ZtHmr99yIbGFdLFc', 'MHLNrJ9M8hx1', NULL, NULL),
(5, 'Natan', 'natan123@gmail.com', NULL, '$2y$10$lYGjnQWZ0jAoaiVmTGt3q.k6Go1TmAsOm255fAf5ACudqzxMQpGnO', NULL, NULL, '2025-05-02 08:46:46', '2025-05-02 08:46:46', 2, 'YoKvqi7cl95p7sNAts8iasOM0kVKcIyhGhNNrgyUeeCTRPUeAkXBVlnAS5RN', 'IOT1OdrOWYkN', NULL, NULL),
(6, 'Natan1234', 'natan1234@gmail.com', NULL, '$2y$10$vteb8TFRf4YOBz.Li4zlD.xBm5TED7aWY9ei0OoMDQ5SiFNsscCai', NULL, NULL, '2025-05-02 08:47:51', '2025-05-02 08:48:29', 2, 'UgUC951680jQsikLytVuIzGGsSXgfSr4uwIOii62EZVWkNHmIyRzWt9l6alz', 'H9VTZRa9AKIF', NULL, NULL),
(7, 'Testing', 'tes123@gmail.com', NULL, '$2y$10$YzxEcX.iJxu.vJqj2TwDIOUsCR6KXnteN1Cn/6bRoxEEu4WHql0ye', NULL, NULL, '2025-05-13 12:06:37', '2025-05-20 14:16:54', 2, 'jTpULmxn5euapsbIcHf8R5R1vBtdqcMbwXLjIU9FdNuHyEHuXInuafw1Vjai', 'AyMR9y9lH6Ia', NULL, NULL),
(8, 'windah', 'windahbasudara@gmail.com', NULL, '$2y$10$B2zEwtJnmM7GL/B6v.ysv./W855DmvKoorV9M.tz5LkQ85X/mjItq', NULL, NULL, '2025-05-18 01:42:42', '2025-05-20 10:09:42', 2, 'SMXNn5jOwHwqo7FylJPkfsUwnymyEnTL741KIzo4HtOnx0wRjyQOoE8CfuJn', 'LFW6yyJctRQk', NULL, NULL),
(13, 'jokowi', 'jokowi@gmail.com', NULL, '$2y$10$1/vKCJZ3QQ8Nras61NTFDu7jC.mnulHgXCnIkZm0rglrNEiuDHg8y', NULL, NULL, '2025-05-20 10:10:16', '2025-05-20 14:15:13', 2, 'kEkRpRXoqc3jJXMFcRwNcOAqF3CzIHuXOCeJYbIDIyhvviXeWYgZqceLDDjQ', 'SRSO2lVpV5hr', NULL, NULL),
(14, 'coba', 'coba@gmail.com', NULL, '$2y$10$//lltcwVIG5U9ANs9PQ/VeerRG3KFn0k1NMrAwPuz.ECHaneY4nF2', NULL, NULL, '2025-05-20 10:13:35', '2025-05-20 10:25:17', 2, 'GdCtZPMZakrIsELnt3umHpM9YK14brPjZv1LZKaHEA2nSnzpsPvfUhpUm6Dn', 'hCpHv3JfwYqa', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `clinics`
--
ALTER TABLE `clinics`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `consultations`
--
ALTER TABLE `consultations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `consultation_history`
--
ALTER TABLE `consultation_history`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `dog_care_guides`
--
ALTER TABLE `dog_care_guides`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `ectoparasite_diseases`
--
ALTER TABLE `ectoparasite_diseases`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `medical_records`
--
ALTER TABLE `medical_records`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profiles_company_id_foreign` (`company_id`),
  ADD KEY `profiles_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `profile_addresses`
--
ALTER TABLE `profile_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profile_addresses_profile_id_foreign` (`profile_id`);

--
-- Indeks untuk tabel `profile_transaction_settings`
--
ALTER TABLE `profile_transaction_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profile_transaction_settings_payment_method_id_foreign` (`payment_method_id`),
  ADD KEY `profile_transaction_settings_created_by_foreign` (`created_by`),
  ADD KEY `profile_transaction_settings_profile_id_foreign` (`profile_id`);

--
-- Indeks untuk tabel `purchase_history`
--
ALTER TABLE `purchase_history`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `roles_parent_id_foreign` (`parent_id`);

--
-- Indeks untuk tabel `role_menus`
--
ALTER TABLE `role_menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_menus_role_id_foreign` (`role_id`);

--
-- Indeks untuk tabel `scan_result`
--
ALTER TABLE `scan_result`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `clinics`
--
ALTER TABLE `clinics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `consultations`
--
ALTER TABLE `consultations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `consultation_history`
--
ALTER TABLE `consultation_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `dog_care_guides`
--
ALTER TABLE `dog_care_guides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `ectoparasite_diseases`
--
ALTER TABLE `ectoparasite_diseases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `medical_records`
--
ALTER TABLE `medical_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `profile_addresses`
--
ALTER TABLE `profile_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `profile_transaction_settings`
--
ALTER TABLE `profile_transaction_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `purchase_history`
--
ALTER TABLE `purchase_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `role_menus`
--
ALTER TABLE `role_menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT untuk tabel `scan_result`
--
ALTER TABLE `scan_result`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `profile_addresses`
--
ALTER TABLE `profile_addresses`
  ADD CONSTRAINT `profile_addresses_profile_id_foreign` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
