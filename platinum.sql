-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for platinum
CREATE DATABASE IF NOT EXISTS `platinum` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `platinum`;

-- Dumping structure for table platinum.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table platinum.migrations: ~46 rows (approximately)
DELETE FROM `migrations`;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(2, '2026_01_23_025132_add_user_type_to_tbl_users_table', 1),
	(4, '2026_01_24_172015_create_tbl_studios_table', 2),
	(5, '2026_01_24_172022_create_tbl_location_table', 2),
	(8, '2026_01_22_093354_create_tbl_users_table', 3),
	(9, '2026_01_23_085704_create_tbl_categories_table', 3),
	(10, '2026_01_24_175854_create_tbl_studios_table', 4),
	(11, '2026_01_24_175920_create_tbl_location_table', 4),
	(12, '2026_01_24_180340_create_tbl_studio_categories_table', 5),
	(13, '2026_01_24_182149_add_service_coverage_area_to_tbl_studios_table', 6),
	(14, '2026_01_25_140023_drop_tbl_studio_categories_table', 7),
	(15, '2026_01_25_140045_add_category_id_to_tbl_studios_table', 7),
	(16, '2026_01_25_154427_create_tbl_services_table', 8),
	(17, '2026_01_25_161945_create_tbl_services_table', 9),
	(18, '2026_01_26_034254_create_packages_table', 10),
	(19, '2026_01_26_055451_create_tbl_packages_table', 11),
	(20, '2026_01_26_131528_remove_service_description_and_status_from_tbl_services_table', 12),
	(21, '2026_01_26_132323_change_service_name_to_json_in_tbl_services', 13),
	(22, '2026_01_27_085739_create_tbl_locations_table', 14),
	(23, '2026_01_28_041639_create_tbl_studio_schedules_table', 15),
	(24, '2026_01_28_151726_create_pvt_studio_categories_table', 16),
	(25, '2026_01_28_151746_remove_service_coverage_area_from_tbl_studios', 16),
	(26, '2026_01_28_151803_add_contact_info_to_tbl_studios', 16),
	(27, '2026_01_29_152148_create_freelancer_schedules_table', 17),
	(28, '2026_01_29_152148_create_freelancers_table', 17),
	(30, '2026_01_29_152148_create_pvt_freelancer_categories_table', 18),
	(31, '2026_01_31_161024_create_tbl_freelancer_services_table_fixed', 18),
	(32, '2026_01_31_162439_add_category_id_to_tbl_freelancer_services', 19),
	(33, '2026_02_01_071852_create_freelancer_packages_table', 20),
	(34, '2026_02_01_083143_add_unique_constraint_to_tbl_freelancer_services', 21),
	(35, '2026_01_31_161024_create_tbl_freelancer_services_table', 22),
	(36, '2026_02_02_004222_add_location_id_to_tbl_users_table', 23),
	(37, '2026_02_03_090801_create_tbl_studio_members_table', 24),
	(38, '2026_02_04_145521_create_tbl_studio_photographers_table', 25),
	(39, '2026_02_04_145527_create_pvt_studio_photographers_table', 25),
	(40, '2026_02_04_155822_simple_fix_specialization_column', 26),
	(41, '2026_02_04_160047_add_foreign_key_to_specialization', 27),
	(42, '2026_02_04_160453_create_tbl_studio_photographers_table_v2', 28),
	(43, '2026_02_05_023818_change_specialization_fk_to_services_in_studio_photographers', 29),
	(44, '2026_02_06_090123_drop_pvt_studio_photographers_table', 30),
	(45, '2026_02_08_093206_create_tbl_bookings_table', 31),
	(46, '2026_02_08_093213_create_tbl_payments_table', 31),
	(47, '2026_02_08_101236_create_bookings_and_payments_tables', 32),
	(48, '2026_02_08_102822_create_tbl_bookings_table', 33),
	(49, '2026_02_08_102828_create_tbl_payments_table', 33),
	(50, '2026_02_08_102833_create_tbl_booking_packages_table', 33),
	(51, '2026_02_08_150413_add_payment_type_to_bookings_table', 34),
	(52, '2026_02_09_132930_create_studio_photographer_assignments_table', 35),
	(53, '2026_02_09_134711_create_tbl_booking_photographers_table', 36),
	(54, '2026_02_09_151150_create_booking_assigned_photographers_table', 37),
	(57, '2026_02_11_035017_create_tbl_system_revenue_table', 38),
	(58, '2026_02_12_060445_add_online_gallery_and_photographer_count_to_tbl_packages_table', 39),
	(61, '2026_02_14_073655_create_tbl_studio_ratings_table', 40),
	(62, '2026_02_14_074433_create_tbl_studio_ratings_table', 41),
	(63, '2026_02_14_081201_create_tbl_studio_ratings_table', 42),
	(64, '2026_02_14_085714_create_tbl_freelancer_ratings_table', 43),
	(65, '2026_02_16_072329_create_tbl_online_gallery_table', 44),
	(66, '2026_02_16_091620_create_tbl_studio_online_gallery_table', 45),
	(67, '2026_02_16_093634_create_tbl_freelancer_online_gallery_table', 46);

-- Dumping structure for table platinum.pvt_freelancer_categories
CREATE TABLE IF NOT EXISTS `pvt_freelancer_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pvt_freelancer_categories_user_id_category_id_unique` (`user_id`,`category_id`),
  KEY `pvt_freelancer_categories_category_id_foreign` (`category_id`),
  CONSTRAINT `pvt_freelancer_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `tbl_categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pvt_freelancer_categories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table platinum.pvt_freelancer_categories: ~8 rows (approximately)
DELETE FROM `pvt_freelancer_categories`;
INSERT INTO `pvt_freelancer_categories` (`id`, `user_id`, `category_id`, `created_at`, `updated_at`) VALUES
	(1, 14, 3, '2026-02-05 06:18:56', '2026-02-05 06:18:56'),
	(2, 14, 4, '2026-02-05 06:18:56', '2026-02-05 06:18:56'),
	(3, 14, 5, '2026-02-05 06:18:56', '2026-02-05 06:18:56'),
	(4, 14, 6, '2026-02-05 06:18:56', '2026-02-05 06:18:56'),
	(5, 14, 7, '2026-02-05 06:18:56', '2026-02-05 06:18:56'),
	(6, 14, 8, '2026-02-05 06:18:56', '2026-02-05 06:18:56'),
	(7, 14, 9, '2026-02-05 06:18:56', '2026-02-05 06:18:56'),
	(8, 14, 10, '2026-02-05 06:18:56', '2026-02-05 06:18:56');

-- Dumping structure for table platinum.pvt_studio_categories
CREATE TABLE IF NOT EXISTS `pvt_studio_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `studio_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pvt_studio_categories_studio_id_category_id_unique` (`studio_id`,`category_id`),
  KEY `pvt_studio_categories_user_id_foreign` (`user_id`),
  KEY `pvt_studio_categories_category_id_foreign` (`category_id`),
  CONSTRAINT `pvt_studio_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `tbl_categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pvt_studio_categories_studio_id_foreign` FOREIGN KEY (`studio_id`) REFERENCES `tbl_studios` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pvt_studio_categories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table platinum.pvt_studio_categories: ~9 rows (approximately)
DELETE FROM `pvt_studio_categories`;
INSERT INTO `pvt_studio_categories` (`id`, `user_id`, `studio_id`, `category_id`, `created_at`, `updated_at`) VALUES
	(1, 2, 1, 1, '2026-02-04 23:08:45', '2026-02-04 23:08:45'),
	(2, 2, 1, 2, '2026-02-04 23:08:45', '2026-02-04 23:08:45'),
	(3, 2, 1, 3, '2026-02-04 23:08:45', '2026-02-04 23:08:45'),
	(4, 2, 1, 4, '2026-02-04 23:08:45', '2026-02-04 23:08:45'),
	(5, 2, 1, 10, '2026-02-04 23:08:45', '2026-02-04 23:08:45'),
	(6, 2, 2, 1, '2026-02-05 05:18:24', '2026-02-05 05:18:24'),
	(7, 2, 2, 2, '2026-02-05 05:18:24', '2026-02-05 05:18:24'),
	(8, 2, 2, 4, '2026-02-05 05:18:24', '2026-02-05 05:18:24'),
	(9, 2, 2, 7, '2026-02-05 05:18:24', '2026-02-05 05:18:24');

-- Dumping structure for table platinum.tbl_bookings
CREATE TABLE IF NOT EXISTS `tbl_bookings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `booking_reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_id` bigint unsigned NOT NULL,
  `booking_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned DEFAULT NULL,
  `event_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `location_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `venue_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barangay` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `province` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Cavite',
  `special_requests` text COLLATE utf8mb4_unicode_ci,
  `total_amount` decimal(10,2) NOT NULL,
  `down_payment` decimal(10,2) NOT NULL,
  `remaining_balance` decimal(10,2) NOT NULL,
  `deposit_policy` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '30%',
  `payment_type` enum('downpayment','full_payment') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'downpayment',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tbl_bookings_booking_reference_unique` (`booking_reference`),
  KEY `tbl_bookings_client_id_foreign` (`client_id`),
  KEY `tbl_bookings_category_id_foreign` (`category_id`),
  CONSTRAINT `tbl_bookings_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `tbl_categories` (`id`),
  CONSTRAINT `tbl_bookings_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table platinum.tbl_bookings: ~4 rows (approximately)
DELETE FROM `tbl_bookings`;
INSERT INTO `tbl_bookings` (`id`, `booking_reference`, `client_id`, `booking_type`, `provider_id`, `category_id`, `event_name`, `event_date`, `start_time`, `end_time`, `location_type`, `venue_name`, `street`, `barangay`, `city`, `province`, `special_requests`, `total_amount`, `down_payment`, `remaining_balance`, `deposit_policy`, `payment_type`, `status`, `payment_status`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'BK-698EE125AF63F', 53, 'studio', 1, 2, NULL, '2026-02-28', '08:00:00', '18:00:00', 'on-location', 'Silver Orchid Events Hall', '88 Summit Ridge Road, Ridgeview Complex', 'Pasong Camachile II', 'General Trias', 'Cavite', 'dasldjasiodiasdasio', 10000.00, 3000.00, 0.00, '30%', 'downpayment', 'completed', 'paid', '2026-02-13 00:30:29', '2026-02-13 06:57:41', NULL),
	(3, 'BK-698FEA41096D4', 53, 'studio', 2, 9, NULL, '2026-02-16', '08:00:00', '18:00:00', 'on-location', 'Sunrise Grand Pavilion', 'Blk 5 Lot 12, Mahogany Drive, Greenfields Subdivision', 'Santiago', 'General Trias', 'Cavite', 'Booking for real estate photography of a residential property for listing purposes. Kindly capture complete interior and exterior shots, including facade, living area, bedrooms, kitchen, bathrooms, parking, and amenities. Preferred style is bright and natural with wide-angle coverage. Property will be ready and staged before the scheduled shoot.', 12000.00, 3600.00, 0.00, '30%', 'downpayment', 'completed', 'paid', '2026-02-13 19:21:37', '2026-02-13 20:00:02', NULL),
	(4, 'BK-698FF5A12EEF9', 66, 'freelancer', 14, 7, NULL, '2026-02-16', '08:00:00', '18:00:00', 'on-location', 'The Bayleaf Hotel Cavite', NULL, 'San Francisco', 'General Trias', 'Cavite', 'Requesting documentary-style photography coverage focusing on candid moments, guest interactions, and behind-the-scenes details. Please avoid posed shots unless requested by participants. Coverage needed from preparation until end of program.', 45000.00, 13500.00, 0.00, '30%', 'downpayment', 'completed', 'paid', '2026-02-13 20:10:09', '2026-02-13 20:16:23', NULL),
	(5, 'BK-69903850B66F7', 53, 'freelancer', 14, 7, NULL, '2026-02-16', '04:54:00', '16:02:00', 'on-location', 'Tanisha Potts', 'Delectus sit aut v', 'Barangay 1 (Poblacion) - San Pablo', 'Carmona', 'Cavite', 'Consequuntur tenetur', 45000.00, 13500.00, 0.00, '30%', 'downpayment', 'completed', 'paid', '2026-02-14 00:54:40', '2026-02-14 00:54:54', NULL),
	(6, 'BK-6992F792B315C', 69, 'studio', 2, 9, NULL, '2026-02-28', '08:00:00', '18:00:00', 'in-studio', NULL, NULL, NULL, NULL, 'Cavite', 'sadsada', 6500.00, 1950.00, 4550.00, '30%', 'downpayment', 'pending', 'unpaid', '2026-02-16 02:55:14', '2026-02-16 02:55:14', NULL),
	(7, 'BK-6992F7B1C7893', 69, 'studio', 2, 9, NULL, '2026-02-28', '08:00:00', '18:00:00', 'in-studio', NULL, NULL, NULL, NULL, 'Cavite', 'sadsada', 6500.00, 1950.00, 2600.00, '30%', 'downpayment', 'confirmed', 'partially_paid', '2026-02-16 02:55:45', '2026-02-16 02:56:29', NULL);

-- Dumping structure for table platinum.tbl_booking_assigned_photographers
CREATE TABLE IF NOT EXISTS `tbl_booking_assigned_photographers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `booking_id` bigint unsigned NOT NULL,
  `studio_id` bigint unsigned NOT NULL,
  `photographer_id` bigint unsigned NOT NULL,
  `assigned_by` bigint unsigned NOT NULL,
  `status` enum('assigned','confirmed','in_progress','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'assigned',
  `assignment_notes` text COLLATE utf8mb4_unicode_ci,
  `cancellation_reason` text COLLATE utf8mb4_unicode_ci,
  `assigned_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_booking_assigned_photographers_studio_id_foreign` (`studio_id`),
  KEY `tbl_booking_assigned_photographers_booking_id_studio_id_index` (`booking_id`,`studio_id`),
  KEY `tbl_booking_assigned_photographers_photographer_id_status_index` (`photographer_id`,`status`),
  KEY `tbl_booking_assigned_photographers_assigned_by_index` (`assigned_by`),
  CONSTRAINT `tbl_booking_assigned_photographers_assigned_by_foreign` FOREIGN KEY (`assigned_by`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_booking_assigned_photographers_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `tbl_bookings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_booking_assigned_photographers_photographer_id_foreign` FOREIGN KEY (`photographer_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_booking_assigned_photographers_studio_id_foreign` FOREIGN KEY (`studio_id`) REFERENCES `tbl_studios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table platinum.tbl_booking_assigned_photographers: ~2 rows (approximately)
DELETE FROM `tbl_booking_assigned_photographers`;
INSERT INTO `tbl_booking_assigned_photographers` (`id`, `booking_id`, `studio_id`, `photographer_id`, `assigned_by`, `status`, `assignment_notes`, `cancellation_reason`, `assigned_at`, `confirmed_at`, `completed_at`, `cancelled_at`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 18, 2, 'completed', 'Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas. Iaculis massa nisl malesuada lacinia integer nunc posuere. Ut hendrerit semper vel class aptent taciti sociosqu. Ad litora torquent per conubia nostra inceptos himenaeos.', NULL, '2026-02-13 06:40:45', '2026-02-13 06:43:05', '2026-02-13 06:50:07', NULL, '2026-02-13 06:40:45', '2026-02-13 06:50:07'),
	(5, 3, 2, 84, 2, 'completed', NULL, NULL, '2026-02-13 19:49:53', '2026-02-13 19:54:18', '2026-02-13 19:57:54', NULL, '2026-02-13 19:49:53', '2026-02-13 19:57:54');

-- Dumping structure for table platinum.tbl_booking_packages
CREATE TABLE IF NOT EXISTS `tbl_booking_packages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `booking_id` bigint unsigned NOT NULL,
  `package_id` bigint unsigned NOT NULL,
  `package_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `package_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `package_price` decimal(10,2) NOT NULL,
  `package_inclusions` text COLLATE utf8mb4_unicode_ci,
  `duration` int DEFAULT NULL,
  `maximum_edited_photos` int DEFAULT NULL,
  `coverage_scope` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_booking_packages_booking_id_foreign` (`booking_id`),
  CONSTRAINT `tbl_booking_packages_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `tbl_bookings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table platinum.tbl_booking_packages: ~4 rows (approximately)
DELETE FROM `tbl_booking_packages`;
INSERT INTO `tbl_booking_packages` (`id`, `booking_id`, `package_id`, `package_type`, `package_name`, `package_price`, `package_inclusions`, `duration`, `maximum_edited_photos`, `coverage_scope`, `created_at`, `updated_at`) VALUES
	(1, 1, 4, 'studio', 'Event Essentials Package', 10000.00, '"[\\"1 professional photographer\\",\\"Unlimited raw shots during the event\\",\\"50 edited photos\\",\\"Online gallery for easy viewing and sharing\\",\\"3 hours coverage\\"]"', 3, 50, 'Small indoor or outdoor gatherings', '2026-02-13 00:30:29', '2026-02-13 00:30:29'),
	(3, 3, 15, 'studio', 'Essentials Property Shoot', 12000.00, '"\\"Up to 3 hours on-site photoshoot,Interior, exterior, and property detail shots,Advanced retouching and perspective correction,30 high-resolution edited photos,Drone aerial photography (5\\\\u20138 edited images)\\""', 3, 30, 'Inside and Outside of the Property', '2026-02-13 19:21:37', '2026-02-13 19:21:37'),
	(4, 4, 3, 'freelancer', 'Premium Documentary Coverage', 45000.00, '"[\\"Pre-project consultation (storyboarding & shot list planning)\\",\\"On-location coverage with professional equipment\\",\\"Unlimited raw shots during coverage\\",\\"80 professionally edited high-resolution photos\\",\\"Advanced retouching & color grading for storytelling impact\\"]"', 8, 80, 'Nationwide (travel fees may apply outside Metro Manila)', '2026-02-13 20:10:09', '2026-02-13 20:10:09'),
	(5, 5, 3, 'freelancer', 'Premium Documentary Coverage', 45000.00, '"[\\"Pre-project consultation (storyboarding & shot list planning)\\",\\"On-location coverage with professional equipment\\",\\"Unlimited raw shots during coverage\\",\\"80 professionally edited high-resolution photos\\",\\"Advanced retouching & color grading for storytelling impact\\"]"', 8, 80, 'Nationwide (travel fees may apply outside Metro Manila)', '2026-02-14 00:54:40', '2026-02-14 00:54:40'),
	(6, 6, 14, 'studio', 'Basic Property Shoot', 6500.00, '"\\"Up to 3 hours on-site photoshoot,Interior and exterior photography,Basic color correction and exposure editing,15 high-resolution edited photos,Private online gallery for download\\""', 3, 15, 'Inside and Outside of the House', '2026-02-16 02:55:14', '2026-02-16 02:55:14'),
	(7, 7, 14, 'studio', 'Basic Property Shoot', 6500.00, '"\\"Up to 3 hours on-site photoshoot,Interior and exterior photography,Basic color correction and exposure editing,15 high-resolution edited photos,Private online gallery for download\\""', 3, 15, 'Inside and Outside of the House', '2026-02-16 02:55:45', '2026-02-16 02:55:45');

-- Dumping structure for table platinum.tbl_categories
CREATE TABLE IF NOT EXISTS `tbl_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tbl_categories_category_name_unique` (`category_name`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table platinum.tbl_categories: ~10 rows (approximately)
DELETE FROM `tbl_categories`;
INSERT INTO `tbl_categories` (`id`, `category_name`, `description`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'Wedding Photography', 'Records moments and emotions from a couple’s wedding day.', 'active', '2026-01-24 09:51:50', '2026-01-24 09:51:50'),
	(2, 'Event Photography', 'Documents occasions like weddings, concerts, and corporate gatherings.', 'active', '2026-01-24 09:52:10', '2026-01-24 09:52:10'),
	(3, 'Family Portrait', 'Family and group portrait sessions', 'active', '2026-01-26 04:13:33', '2026-01-26 04:13:33'),
	(4, 'Product Photography', 'Photos for online selling and ads', 'active', '2026-01-26 04:13:55', '2026-01-26 04:13:55'),
	(5, 'Street Photography', 'Captures candid moments of everyday life in public places.', 'active', '2026-01-26 04:14:40', '2026-01-26 04:14:40'),
	(6, 'Fashion Photography', 'Displays clothing, accessories, and style, often for magazines or advertising.', 'active', '2026-01-26 04:14:51', '2026-01-26 04:14:51'),
	(7, 'Documentary Photography', 'Tells real-life stories through images, often with social or historical focus.', 'active', '2026-01-26 04:15:03', '2026-01-26 04:15:03'),
	(8, 'Food Photography', 'Makes dishes and drinks look appealing for menus, ads, or social media.', 'active', '2026-01-26 04:15:59', '2026-01-26 04:15:59'),
	(9, 'Real Estate Photography', 'Highlights properties and interiors for listings and marketing.', 'active', '2026-01-26 04:16:08', '2026-01-26 04:16:08'),
	(10, 'Pet Photography', 'Focuses on animals in domestic or stylized environments.', 'active', '2026-01-26 04:16:20', '2026-01-26 04:16:20');

-- Dumping structure for table platinum.tbl_freelancers
CREATE TABLE IF NOT EXISTS `tbl_freelancers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `location_id` bigint unsigned DEFAULT NULL,
  `brand_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tagline` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `years_experience` int DEFAULT NULL,
  `brand_logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barangay` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_area` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `starting_price` decimal(10,2) DEFAULT NULL,
  `deposit_policy` enum('required','not_required') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `portfolio_works` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `facebook_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valid_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_freelancers_user_id_foreign` (`user_id`),
  KEY `tbl_freelancers_location_id_foreign` (`location_id`),
  CONSTRAINT `tbl_freelancers_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `tbl_locations` (`id`) ON DELETE SET NULL,
  CONSTRAINT `tbl_freelancers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_freelancers_chk_1` CHECK (json_valid(`portfolio_works`))
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table platinum.tbl_freelancers: ~1 rows (approximately)
DELETE FROM `tbl_freelancers`;
INSERT INTO `tbl_freelancers` (`id`, `user_id`, `location_id`, `brand_name`, `tagline`, `bio`, `years_experience`, `brand_logo`, `street`, `barangay`, `service_area`, `starting_price`, `deposit_policy`, `portfolio_works`, `facebook_url`, `instagram_url`, `website_url`, `valid_id`, `created_at`, `updated_at`) VALUES
	(1, 14, 2, 'JT Visuals Photography', 'Capturing Stories Through Timeless Images', 'I’m a Cavite-based freelance photographer specializing in weddings, events, and lifestyle portraits. I focus on capturing natural emotions and meaningful moments, turning them into timeless photographs my clients can treasure. With a keen eye for detail and storytelling, I aim to deliver high-quality images that truly reflect each client’s vision.', 5, 'brand-logos/F4DKNVKSmBCwfVVcbgpJHOsr70VN5jPi3ea4DRoF.png', 'Blk 12 Lot 8, Prinza Road, General Trias City, Cavite', 'Pasong Kawayan II', 'Within my city only', 5000.00, 'required', '"[\\"portfolio-works\\\\\\/Yhyon8T27DQUSdsEjIYx8IL4aztziDi100J2DstA.png\\",\\"portfolio-works\\\\\\/CLgW0AwPgOVeXn4Auh45jRt4dDoJq5SWrXfef44m.png\\",\\"portfolio-works\\\\\\/hjAngKQ65e52DE8rIjiYkptYiWsC1nDEXNaBnNfu.png\\",\\"portfolio-works\\\\\\/MMSF96j05qZBn1WMfM0CLsuZ9QLSTzVAG9QgiuLo.png\\",\\"portfolio-works\\\\\\/JkfLCVKyzJ8lJkKwj87u8r3dZf4Ex9VXO4i7s21H.png\\"]"', 'https://facebook.com/jtvisualsph', 'https://instagram.com/jtvisuals.ph', 'https://www.jtvisualsph.com', 'valid-ids/NsQEz82S2Gyg3vLpybwlzNyfihsD4bRmcqEiIoDa.jpg', '2026-02-05 06:18:56', '2026-02-05 06:18:56');

-- Dumping structure for table platinum.tbl_freelancer_online_gallery
CREATE TABLE IF NOT EXISTS `tbl_freelancer_online_gallery` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `booking_id` bigint unsigned NOT NULL,
  `freelancer_id` bigint unsigned NOT NULL,
  `client_id` bigint unsigned NOT NULL,
  `gallery_reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gallery_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `images` json DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `total_photos` int NOT NULL DEFAULT '0',
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tbl_freelancer_online_gallery_gallery_reference_unique` (`gallery_reference`),
  KEY `tbl_freelancer_online_gallery_booking_id_index` (`booking_id`),
  KEY `tbl_freelancer_online_gallery_freelancer_id_index` (`freelancer_id`),
  KEY `tbl_freelancer_online_gallery_client_id_index` (`client_id`),
  KEY `tbl_freelancer_online_gallery_gallery_reference_index` (`gallery_reference`),
  CONSTRAINT `tbl_freelancer_online_gallery_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `tbl_bookings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_freelancer_online_gallery_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_freelancer_online_gallery_freelancer_id_foreign` FOREIGN KEY (`freelancer_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table platinum.tbl_freelancer_online_gallery: ~0 rows (approximately)
DELETE FROM `tbl_freelancer_online_gallery`;
INSERT INTO `tbl_freelancer_online_gallery` (`id`, `booking_id`, `freelancer_id`, `client_id`, `gallery_reference`, `gallery_name`, `description`, `images`, `status`, `total_photos`, `published_at`, `created_at`, `updated_at`) VALUES
	(1, 5, 14, 53, 'FL-GAL-6992E77EEDF9D', 'Forest Documentary Landscapes', 'Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas. Iaculis massa nisl malesuada lacinia integer nunc posuere. Ut hendrerit semper vel class aptent taciti sociosqu. Ad litora torquent per conubia nostra inceptos himenaeos.\r\n\r\nLorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas. Iaculis massa nisl malesuada lacinia integer nunc posuere. Ut hendrerit semper vel class aptent taciti sociosqu. Ad litora torquent per conubia nostra inceptos himenaeos.', '["freelancer-online-galleries/5/Uc5Ku3EYKI8c7Ylpu1rhG1mV2zOLe9QFap4RmEqn.png", "freelancer-online-galleries/5/Zpgp9Hjq2Q2GMbKSRWBdMXHjmjb30cbziZxQjv9x.png", "freelancer-online-galleries/5/2DVVzrSqd4tj8lulhfobTZWzW5MSCkZgg6l9x6uQ.png", "freelancer-online-galleries/5/SvnYchG1VQZRs0aDk454FkZikdhrjrVBIBtv4RXW.png", "freelancer-online-galleries/5/SzUzURppAx02RoLD8zNsaMdCrliyhXf8Npyqvn62.png", "freelancer-online-galleries/5/Rhj1JgqlX05Ke7J13Vei7TyH88lhuWTuAZEtT6MO.png", "freelancer-online-galleries/5/S43tINLZrDcng0udEhbm3NIiADycTB0ND6ssG69X.png", "freelancer-online-galleries/5/y4tms4iFsVyfbTeWRfHjOkz0EcgG2jnfxUHRp3cR.png", "freelancer-online-galleries/5/hsqIzlbKpmxGngkGKZLdVEjmd1EsHnt24R6doeTq.png"]', 'active', 9, '2026-02-16 01:46:38', '2026-02-16 01:46:38', '2026-02-16 01:46:38');

-- Dumping structure for table platinum.tbl_freelancer_packages
CREATE TABLE IF NOT EXISTS `tbl_freelancer_packages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  `package_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `package_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `package_inclusions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `duration` int NOT NULL,
  `maximum_edited_photos` int NOT NULL,
  `coverage_scope` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `package_price` decimal(10,2) NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_freelancer_packages_user_id_index` (`user_id`),
  KEY `tbl_freelancer_packages_category_id_index` (`category_id`),
  KEY `tbl_freelancer_packages_status_index` (`status`),
  CONSTRAINT `tbl_freelancer_packages_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `tbl_categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_freelancer_packages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_freelancer_packages_chk_1` CHECK (json_valid(`package_inclusions`))
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table platinum.tbl_freelancer_packages: ~2 rows (approximately)
DELETE FROM `tbl_freelancer_packages`;
INSERT INTO `tbl_freelancer_packages` (`id`, `user_id`, `category_id`, `package_name`, `package_description`, `package_inclusions`, `duration`, `maximum_edited_photos`, `coverage_scope`, `package_price`, `status`, `created_at`, `updated_at`) VALUES
	(1, 14, 6, 'Runway Ready Fashion Shoot', 'A professional fashion photography package tailored for models, designers, and brands. Includes studio or outdoor shoot, creative direction, and high-quality edited images for portfolio or campaign use.', '["Pre-shoot consultation (style & concept planning)","Professional lighting setup","Unlimited raw shots during session","30 professionally edited high-resolution photos","Creative direction and posing guidance"]', 4, 30, 'Metro Manila (studio or outdoor locations)', 18000.00, 'active', '2026-02-06 16:05:34', '2026-02-06 16:05:34'),
	(2, 14, 6, 'Elite Fashion Editorial Experience', 'An exclusive premium package designed for fashion brands, designers, and models who want high-end editorial-quality images. Includes full creative direction, professional styling, and extensive post-production for magazine-ready results.', '["Pre-shoot creative consultation (concept, mood board, styling)","Professional hair & makeup artist (HMUA) included","Wardrobe styling assistance (up to 3 looks)","Studio rental or outdoor location (Metro Manila)","Unlimited raw shots during session"]', 6, 60, 'Metro Manila (studio or outdoor locations)', 35000.00, 'active', '2026-02-06 16:07:01', '2026-02-06 16:07:01'),
	(3, 14, 7, 'Premium Documentary Coverage', 'A comprehensive premium package designed for organizations, events, and individuals who want authentic, story-driven documentary photography. This package captures moments with depth and emotion, providing a complete visual narrative with professional editing and archival-quality delivery.', '["Pre-project consultation (storyboarding & shot list planning)","On-location coverage with professional equipment","Unlimited raw shots during coverage","80 professionally edited high-resolution photos","Advanced retouching & color grading for storytelling impact"]', 8, 80, 'Nationwide (travel fees may apply outside Metro Manila)', 45000.00, 'active', '2026-02-06 16:09:35', '2026-02-06 16:09:35'),
	(4, 14, 5, 'Essential Package', 'Perfect for intimate weddings, this package covers the most important moments of your special day with professional photography.', '["1 professional photographer","Pre-wedding consultation","Coverage of ceremony and reception","Online gallery for viewing and sharing","USB drive with all edited photos"]', 6, 250, 'Ceremony, couple portraits, family portraits, and reception highlights', 25000.00, 'active', '2026-02-08 19:51:53', '2026-02-08 19:51:53');

-- Dumping structure for table platinum.tbl_freelancer_ratings
CREATE TABLE IF NOT EXISTS `tbl_freelancer_ratings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `booking_id` bigint unsigned NOT NULL,
  `client_id` bigint unsigned NOT NULL,
  `freelancer_id` bigint unsigned NOT NULL,
  `rating` tinyint unsigned NOT NULL COMMENT '1-5 stars',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `review_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `review_type` enum('positive','neutral','negative') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preset_used` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'The preset review template used',
  `is_recommend` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_freelancer_ratings_booking_id_foreign` (`booking_id`),
  KEY `tbl_freelancer_ratings_client_id_foreign` (`client_id`),
  CONSTRAINT `tbl_freelancer_ratings_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `tbl_bookings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_freelancer_ratings_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table platinum.tbl_freelancer_ratings: ~0 rows (approximately)
DELETE FROM `tbl_freelancer_ratings`;

-- Dumping structure for table platinum.tbl_freelancer_schedules
CREATE TABLE IF NOT EXISTS `tbl_freelancer_schedules` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `operating_days` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `booking_limit` int DEFAULT NULL,
  `advance_booking` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_freelancer_schedules_user_id_foreign` (`user_id`),
  CONSTRAINT `tbl_freelancer_schedules_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_freelancer_schedules_chk_1` CHECK (json_valid(`operating_days`))
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table platinum.tbl_freelancer_schedules: ~1 rows (approximately)
DELETE FROM `tbl_freelancer_schedules`;
INSERT INTO `tbl_freelancer_schedules` (`id`, `user_id`, `operating_days`, `start_time`, `end_time`, `booking_limit`, `advance_booking`, `created_at`, `updated_at`) VALUES
	(1, 14, '"[\\"monday\\",\\"tuesday\\",\\"wednesday\\",\\"thursday\\",\\"friday\\",\\"saturday\\"]"', '09:00:00', '18:00:00', 2, 7, '2026-02-05 06:18:56', '2026-02-05 06:18:56');

-- Dumping structure for table platinum.tbl_freelancer_services
CREATE TABLE IF NOT EXISTS `tbl_freelancer_services` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  `services_name` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_user_category` (`user_id`,`category_id`),
  KEY `tbl_freelancer_services_category_id_foreign` (`category_id`),
  CONSTRAINT `tbl_freelancer_services_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `tbl_categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_freelancer_services_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_freelancer_services_chk_1` CHECK (json_valid(`services_name`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table platinum.tbl_freelancer_services: ~0 rows (approximately)
DELETE FROM `tbl_freelancer_services`;

-- Dumping structure for table platinum.tbl_locations
CREATE TABLE IF NOT EXISTS `tbl_locations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `province` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cavite',
  `municipality` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `barangay` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `zip_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `tbl_locations_chk_1` CHECK (json_valid(`barangay`))
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table platinum.tbl_locations: ~8 rows (approximately)
DELETE FROM `tbl_locations`;
INSERT INTO `tbl_locations` (`id`, `province`, `municipality`, `barangay`, `zip_code`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'Cavite', 'Dasmariñas', '"[\\"Burol\\",\\"Burol I\\",\\"Burol II\\",\\"Burol III\\",\\"Fatima I\\",\\"Fatima II\\",\\"Fatima III\\",\\"Langkaan I\\",\\"Langkaan II\\",\\"Paliparan I\\",\\"Paliparan II\\",\\"Paliparan III\\",\\"Salitran I\\",\\"Salitran II\\",\\"Salitran III\\",\\"Salitran IV\\",\\"Zone I\\",\\"Zone I-B\\",\\"Zone II\\",\\"Zone III\\",\\"Zone IV\\"]"', '4115', 'active', '2026-01-27 01:04:27', '2026-01-27 01:04:27'),
	(2, 'Cavite', 'General Trias', '"[\\"Alingaro\\",\\"Arnaldo (Barangay 7)\\",\\"Bacao I\\",\\"Bacao II\\",\\"Bagumbayan (Barangay 5)\\",\\"Biclatan\\",\\"Buenavista I\\",\\"Buenavista II\\",\\"Buenavista III\\",\\"Corregidor (Barangay 10)\\",\\"Dulong Bayan (Barangay 3)\\",\\"Gov. Ferrer (Barangay 1)\\",\\"Javalera\\",\\"Manggahan\\",\\"Navarro\\",\\"Ninety Sixth (Barangay 8)\\",\\"Panungyanan\\",\\"Pasong Camachile I\\",\\"Pasong Camachile II\\",\\"Pasong Kawayan I\\",\\"Pasong Kawayan II\\",\\"Pinagtipunan\\",\\"Prinza (Barangay 9)\\",\\"Sampalucan (Barangay 2)\\",\\"San Francisco\\",\\"San Gabriel (Barangay 4)\\",\\"San Juan I\\",\\"San Juan II\\",\\"Santa Clara\\",\\"Santiago\\",\\"Tapia\\",\\"Tejero\\",\\"Vibora (Barangay 6)\\"]"', '4107', 'active', '2026-01-27 01:42:45', '2026-01-27 01:42:45'),
	(6, 'Cavite', 'Imus', '"[\\"Alapan I-A\\",\\"Alapan I-B\\",\\"Alapan I-C\\",\\"Alapan II-A\\",\\"Alapan II-B\\",\\"Anabu I-A\\",\\"Anabu I-B\\",\\"Anabu I-C\\",\\"Anabu I-D\\",\\"Anabu I-E\\",\\"Anabu I-F\\",\\"Anabu I-G\\",\\"Anabu II-A\\",\\"Anabu II-B\\",\\"Anabu II-C\\",\\"Anabu II-D\\",\\"Anabu II-E\\",\\"Anabu II-F\\",\\"Bagong Silang (Bahayang Pag-Asa)\\",\\"Bayan Luma I\\",\\"Bayan Luma II\\",\\"Bayan Luma III\\",\\"Bayan Luma IV\\",\\"Bayan Luma V\\",\\"Bayan Luma VI\\",\\"Bayan Luma VII\\",\\"Bayan Luma VIII\\",\\"Bayan Luma IX\\",\\"Bucandala I\\",\\"Bucandala II\\",\\"Bucandala III\\",\\"Bucandala IV\\",\\"Bucandala V\\",\\"Buhay na Tubig\\",\\"Carsadang Bago I\\",\\"Carsadang Bago II\\",\\"Magdalo\\",\\"Maharlika\\",\\"Malagasang I-A\\",\\"Malagasang I-B\\",\\"Malagasang I-C\\",\\"Malagasang I-D\\",\\"Malagasang I-E\\",\\"Malagasang I-F\\",\\"Malagasang I-G\\",\\"Malagasang II-A\\",\\"Malagasang II-B\\",\\"Malagasang II-C\\",\\"Malagasang II-D\\",\\"Malagasang II-E\\",\\"Malagasang II-F\\",\\"Malagasang II-G\\",\\"Mariano Espeleta I\\",\\"Mariano Espeleta II\\",\\"Mariano Espeleta III\\",\\"Medicion I-A\\",\\"Medicion I-B\\",\\"Medicion I-C\\",\\"Pag-Asa I\\",\\"Pag-Asa II\\",\\"Pag-Asa III\\",\\"Palico I\\",\\"Palico II\\",\\"Palico III\\",\\"Poblacion I-A\\",\\"Poblacion I-B\\",\\"Poblacion I-C\\",\\"Tanzang Luma I\\",\\"Tanzang Luma II\\",\\"Tanzang Luma III\\",\\"Toclong I-A\\",\\"Toclong I-B\\",\\"Toclong I-C\\"]"', '4103', 'active', '2026-01-28 06:05:50', '2026-01-28 06:05:50'),
	(7, 'Cavite', 'Silang', '"[\\"Adlas\\",\\"Balite I\\",\\"Balite II\\",\\"Balubad\\",\\"Batas\\",\\"Biga I\\",\\"Biluso\\",\\"Buho\\",\\"Bucal\\",\\"Bulihan\\",\\"Cabangaan\\",\\"Carmen\\",\\"Hukay\\",\\"Iba\\",\\"Inchican\\",\\"Kalubkob\\",\\"Kaong\\",\\"Lalaan I\\",\\"Lalaan II\\",\\"Litlit\\",\\"Lucsuhin\\",\\"Lumil\\",\\"Maguyam\\",\\"Malabag\\",\\"Mataas Na Burol\\",\\"Munting Ilog\\",\\"Paligawan\\",\\"Pasong Langka\\",\\"Pook I\\",\\"Pulong Bunga\\",\\"Pulong Saging\\",\\"Puting Kahoy\\",\\"Sabutan\\"]"', '4118', 'active', '2026-01-28 06:11:32', '2026-01-28 06:11:32'),
	(18, 'Cavite', 'Carmona', '"[\\"Barangay 1 (Poblacion) - San Pablo\\",\\"Barangay 2 (Poblacion) - San Jose\\",\\"Barangay 3 (Poblacion) - San Jose\\",\\"Barangay 4 (Poblacion) - J.M. Loyola\\",\\"Barangay 5 (Poblacion) - J.M. Loyola\\",\\"Barangay 6 (Poblacion) - Magallanes\\",\\"Barangay 7 (Poblacion) - Magallanes\\",\\"Barangay 8 (Poblacion) - Rosario\\",\\"Bancal\\",\\"Cabilang Baybay\\",\\"Lantic\\",\\"Mabuhay\\",\\"Maduya\\",\\"Milagrosa\\"]"', '4116', 'active', '2026-02-01 15:38:41', '2026-02-01 15:38:41'),
	(19, 'Cavite', 'General Mariano Alvarez', '"[\\"Aldiano Olaes\\",\\"Barangay 1 Poblacion\\",\\"Barangay 2 Poblacion\\",\\"Barangay 3 Poblacion\\",\\"Barangay 4 Poblacion\\",\\"Barangay 5 Poblacion\\",\\"Benjamin Tirona\\",\\"Bernardo Pulido\\",\\"Epifanio Malia\\",\\"Fiorello Calimag\\",\\"Francisco de Castro\\",\\"Francisco Reyes\\",\\"Gavino Maderan\\",\\"Gregoria de Jesus\\",\\"Inocencio Salud\\",\\"Jacinto Lumbreras\\",\\"Kapitan Kua\\",\\"Koronel Jose P. Elises\\",\\"Macario Dacon\\",\\"Marcelino Memije\\",\\"Nicolasa Virata\\",\\"Pantaleon Granados\\",\\"Ramon Cruz\\",\\"San Gabriel\\",\\"San Jose\\",\\"Severino de Las Alas\\",\\"Tiniente Tiago\\"]"', '4117', 'active', '2026-02-01 15:41:13', '2026-02-01 15:41:13'),
	(20, 'Cavite', 'Indang', '"[\\"Agus-us\\",\\"Alulod\\",\\"Banaba Cerca\\",\\"Banaba Lejos\\",\\"Bancod\\",\\"Barangay 1\\",\\"Barangay 2\\",\\"Barangay 3\\",\\"Barangay 4\\",\\"Buna Cerca\\",\\"Buna Lejos I\\",\\"Buna Lejos II\\",\\"Calumpang Cerca\\",\\"Calumpang Lejos I\\",\\"Carasuchi\\",\\"Daine I\\",\\"Daine II\\",\\"Guyam Malaki\\",\\"Guyam Munti\\",\\"Harasan\\",\\"Kayquit I\\",\\"Kayquit II\\",\\"Kayquit III\\",\\"Kaytambog\\",\\"Kaytapos\\",\\"Limbon\\",\\"Lumampong Balagbag\\",\\"Lumampong Halayhay\\",\\"Mahabangkahoy Cerca\\",\\"Mahabangkahoy Lejos\\",\\"Mataas na Lupa\\",\\"Pulo\\",\\"Tambo Balagbag\\",\\"Tambo Ilaya\\",\\"Tambo Kulit\\",\\"Tambo Malaki\\"]"', '4122', 'active', '2026-02-01 15:43:34', '2026-02-01 15:43:34'),
	(21, 'Cavite', 'Kawit', '"[\\"Balsahan-Bisita\\",\\"Batong Dalig\\",\\"Binakayan-Aplaya\\",\\"Binakayan-Kanluran\\",\\"Congbalay-Legaspi\\",\\"Gahak\\",\\"Kaingen\\",\\"Magdalo\\",\\"Manggahan-Lawin\\",\\"Marulas\\",\\"Panamitan\\",\\"Poblacion\\",\\"Pulvorista\\",\\"Samala-Marquez\\",\\"San Sebastian\\",\\"Santa Isabel\\",\\"Tabon I\\",\\"Tabon II\\",\\"Tabon III\\",\\"Toclong\\",\\"Tramo-Bantayan\\",\\"Wakas I\\",\\"Wakas II\\"]"', '4104', 'active', '2026-02-01 15:46:00', '2026-02-01 15:46:00');

-- Dumping structure for table platinum.tbl_online_gallery
CREATE TABLE IF NOT EXISTS `tbl_online_gallery` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `booking_id` bigint unsigned NOT NULL,
  `studio_id` bigint unsigned NOT NULL,
  `client_id` bigint unsigned NOT NULL,
  `gallery_reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gallery_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `images` json DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `total_photos` int NOT NULL DEFAULT '0',
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tbl_online_gallery_gallery_reference_unique` (`gallery_reference`),
  KEY `tbl_online_gallery_booking_id_index` (`booking_id`),
  KEY `tbl_online_gallery_studio_id_index` (`studio_id`),
  KEY `tbl_online_gallery_client_id_index` (`client_id`),
  KEY `tbl_online_gallery_status_index` (`status`),
  CONSTRAINT `tbl_online_gallery_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `tbl_bookings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_online_gallery_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_online_gallery_studio_id_foreign` FOREIGN KEY (`studio_id`) REFERENCES `tbl_studios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table platinum.tbl_online_gallery: ~0 rows (approximately)
DELETE FROM `tbl_online_gallery`;
INSERT INTO `tbl_online_gallery` (`id`, `booking_id`, `studio_id`, `client_id`, `gallery_reference`, `gallery_name`, `description`, `images`, `status`, `total_photos`, `published_at`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 53, 'GAL-6992CA5FAE2AB', 'Wedding', NULL, '["online-galleries/1/f6Cj5ebMTuMZbzIHSJEBJ1Z8a4fpIyQJsq9T9FwA.png", "online-galleries/1/e2ur5SsCO964LTZDg5TcAhNf4qMm0PMZDnUDywI2.png", "online-galleries/1/7O7GqKxtpjLL2nruBUEjLihU3xfx2ZTs577ScfBk.png", "online-galleries/1/qhtvC10kvMzxItEUEvBlycF3eSMnGDpFRMe0OVS3.png", "online-galleries/1/EFqI858VlDJ8h8H16AtEJbpbMyCjLDqS5FHgCrQG.png"]', 'active', 5, '2026-02-15 23:42:23', '2026-02-15 23:42:23', '2026-02-15 23:59:18'),
	(2, 3, 2, 53, 'GAL-6992DF741F7D7', 'The Wedding Landscape', 'Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas. Iaculis massa nisl malesuada lacinia integer nunc posuere. Ut hendrerit semper vel class aptent taciti sociosqu. Ad litora torquent per conubia nostra inceptos himenaeos.\r\n\r\nLorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas. Iaculis massa nisl malesuada lacinia integer nunc posuere. Ut hendrerit semper vel class aptent taciti sociosqu. Ad litora torquent per conubia nostra inceptos himenaeos.', '["online-galleries/3/n5uFU20Cjg9EdZbDeTLDND3cfHqvQUboEnRTMb9g.png", "online-galleries/3/B3Fbyt51FBwRkJiCfK7N2CuNqf7RyaldowsyVqt6.png", "online-galleries/3/OFYtFaFPqTrR0rjjGIQKrekjfZek17VXZzioxNgL.png", "online-galleries/3/eIvOcOOuXetW69RsL61mI01ZIrc27KM7QLFnyMZ0.png", "online-galleries/3/EARTzEvNYwmPEbDAq85fYyRt71VFMz759c6j5MOs.png"]', 'active', 5, '2026-02-16 01:12:20', '2026-02-16 01:12:20', '2026-02-16 01:12:20');

-- Dumping structure for table platinum.tbl_packages
CREATE TABLE IF NOT EXISTS `tbl_packages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `studio_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  `package_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `package_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `package_inclusions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `duration` int NOT NULL,
  `maximum_edited_photos` int NOT NULL,
  `coverage_scope` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `package_price` decimal(10,2) NOT NULL,
  `online_gallery` tinyint(1) NOT NULL DEFAULT '0',
  `photographer_count` int NOT NULL DEFAULT '0',
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_packages_studio_id_index` (`studio_id`),
  KEY `tbl_packages_category_id_index` (`category_id`),
  KEY `tbl_packages_status_index` (`status`),
  CONSTRAINT `tbl_packages_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `tbl_categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_packages_studio_id_foreign` FOREIGN KEY (`studio_id`) REFERENCES `tbl_studios` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_packages_chk_1` CHECK (json_valid(`package_inclusions`)),
  CONSTRAINT `tbl_packages_chk_2` CHECK (json_valid(`coverage_scope`))
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table platinum.tbl_packages: ~13 rows (approximately)
DELETE FROM `tbl_packages`;
INSERT INTO `tbl_packages` (`id`, `studio_id`, `category_id`, `package_name`, `package_description`, `package_inclusions`, `duration`, `maximum_edited_photos`, `coverage_scope`, `package_price`, `online_gallery`, `photographer_count`, `status`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 'Wedding Basic', 'Perfect for intimate weddings and civil ceremonies. Simple coverage with professionally edited highlights.', '["4 hours photo coverage","100 professionally edited photos","Online gallery with digital downloads"]', 4, 100, '"Church and Reception"', 8000.00, 1, 3, 'active', '2026-02-08 03:07:11', '2026-02-08 03:07:11'),
	(2, 1, 1, 'Wedding Essentials', 'Ideal for small to medium weddings, covering key moments from preparation to reception.', '["6 hours photo coverage","200 professionally edited photos","USB + online gallery delivery"]', 6, 200, '"Church and Reception"', 15000.00, 1, 3, 'active', '2026-02-08 03:07:55', '2026-02-08 03:07:55'),
	(3, 1, 1, 'Wedding Premium', 'Complete wedding day coverage with enhanced deliverables for couples who want everything beautifully documented.', '["10 hours full-day coverage (2 photographers)","350 professionally edited photos","Premium USB + online gallery + 20-page photo album"]', 10, 350, '"Church and Reception"', 28000.00, 1, 5, 'active', '2026-02-08 03:08:42', '2026-02-08 03:08:42'),
	(4, 1, 2, 'Event Essentials Package', 'An affordable package designed for intimate gatherings and small celebrations. Ideal for birthdays, reunions, or private parties where you want professional coverage without the premium cost.', '["1 professional photographer","Unlimited raw shots during the event","50 edited photos","Online gallery for easy viewing and sharing","3 hours coverage"]', 3, 50, '"Small indoor or outdoor gatherings"', 10000.00, 1, 1, 'active', '2026-02-11 20:57:06', '2026-02-11 20:57:06'),
	(5, 1, 2, 'Event Highlights Package', 'A balanced package for milestone events such as weddings, corporate functions, or anniversaries. Includes both photo and video highlights to capture the essence of your celebration.', '["1 professional photographer + assistant","Unlimited raw shots during the event","100 edited photos","1\\u20132 minute highlight reel (video montage)","Online gallery + USB drive with edited photos"]', 5, 100, '"Weddings, corporate events, and medium-sized celebrations"', 18000.00, 1, 1, 'active', '2026-02-11 20:58:23', '2026-02-11 20:58:23'),
	(6, 1, 2, 'Event Prestige Package', 'A premium package crafted for grand celebrations such as weddings, galas, and corporate launches. Full-day coverage with cinematic highlights and a keepsake photo album.', '["2 professional photographers + assistant","Unlimited raw shots during the event","150 edited photos","3\\u20135 minute cinematic highlight video","Online gallery + USB drive + printed photo album"]', 8, 150, '"Large-scale weddings, galas, and luxury events"', 25000.00, 1, 1, 'active', '2026-02-11 20:59:26', '2026-02-11 20:59:26'),
	(7, 1, 5, 'Urban Essentials Package', 'A starter package for casual street photography sessions, perfect for individuals who want candid portraits and lifestyle shots in vibrant city settings.', '["1 professional street photographer","Unlimited raw shots during the session","30 edited photos","Online gallery for easy viewing and sharing"]', 2, 30, '"Casual street walks, lifestyle shoots, small group sessions"', 8000.00, 0, 1, 'active', '2026-02-11 21:00:55', '2026-02-11 21:00:55'),
	(8, 1, 5, 'Urban Prestige Package', 'A premium package for full-day street photography coverage, ideal for fashion shoots, brand campaigns, or documentary-style projects.', '["2 professional street photographers","Unlimited raw shots during the session","120 edited photos","Online gallery + printed photo album"]', 8, 120, '"Fashion shoots, brand campaigns, documentary projects"', 25000.00, 1, 1, 'active', '2026-02-11 21:01:31', '2026-02-11 21:01:31'),
	(9, 1, 5, 'City Highlights Package', 'A mid-tier package designed for travelers, influencers, or couples who want curated street photography with more coverage and creative edits.', '["1 professional street photographer + assistant","Unlimited raw shots during the session","70 edited photos","USB drive with edited photos"]', 4, 70, '"City tours, couple shoots, travel documentation"', 15000.00, 1, 1, 'active', '2026-02-11 21:02:13', '2026-02-11 21:02:13'),
	(10, 1, 6, 'Runway Essentials Package', 'A starter package designed for aspiring models, influencers, or small fashion projects. Perfect for portfolio building and casual editorial shoots.', '["1 professional fashion photographer","40 edited photos","Online gallery for viewing and sharing","2 hours studio or outdoor session"]', 2, 40, '"Individual model shoots, lifestyle fashion sessions"', 12000.00, 1, 1, 'active', '2026-02-11 21:08:45', '2026-02-11 21:08:45'),
	(11, 1, 6, 'Editorial Highlights Package', 'A mid-tier package tailored for fashion brands, designers, and professional portfolios. Includes creative direction and extended coverage for editorial-style shoots.', '["1 professional fashion photographer + assistant","80 edited photos","USB drive with edited photos","4 hours studio or location shoot"]', 4, 78, '"Brand campaigns, designer collections, editorial shoots"', 20000.00, 1, 1, 'active', '2026-02-11 21:09:35', '2026-02-11 21:09:35'),
	(12, 1, 6, 'Couture Prestige Package', 'A premium package crafted for high-fashion campaigns, runway events, and luxury brand projects. Full-day coverage with professional styling and creative direction.', '["2 professional fashion photographers","150 edited photos","Online gallery + printed photo album","8 hours studio and\\/or event coverage"]', 8, 150, '"Runway shows, luxury brand campaigns, high-fashion editorials"', 30000.00, 1, 1, 'active', '2026-02-11 21:10:12', '2026-02-11 21:10:12'),
	(13, 1, 4, 'Product Essentials Package', 'A starter package designed for small businesses and online sellers who need clean, professional product shots for e-commerce listings and catalogs.', '"1 professional product photographer,20 edited product photos,White or plain background setup,Online gallery for easy download and sharing"', 2, 20, '"Small product shoots (e.g., accessories, food items, gadgets)"', 8000.00, 1, 1, 'active', '2026-02-11 22:16:05', '2026-02-11 22:16:05'),
	(14, 2, 9, 'Basic Property Shoot', 'Ideal for small properties, condos, or studio units needing professional listing photos.', '"Up to 3 hours on-site photoshoot,Interior and exterior photography,Basic color correction and exposure editing,15 high-resolution edited photos,Private online gallery for download"', 3, 15, '"Inside and Outside of the House"', 6500.00, 0, 1, 'active', '2026-02-13 07:20:13', '2026-02-13 07:20:13'),
	(15, 2, 9, 'Essentials Property Shoot', 'Perfect for residential homes and mid-sized properties requiring detailed coverage.', '"Up to 3 hours on-site photoshoot,Interior, exterior, and property detail shots,Advanced retouching and perspective correction,30 high-resolution edited photos,Drone aerial photography (5\\u20138 edited images)"', 3, 30, '"Inside and Outside of the Property"', 12000.00, 1, 1, 'active', '2026-02-13 07:21:45', '2026-02-13 07:21:45');

-- Dumping structure for table platinum.tbl_payments
CREATE TABLE IF NOT EXISTS `tbl_payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `booking_id` bigint unsigned NOT NULL,
  `payment_reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_payment_intent_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stripe_session_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'card',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_details` json DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tbl_payments_payment_reference_unique` (`payment_reference`),
  KEY `tbl_payments_booking_id_foreign` (`booking_id`),
  CONSTRAINT `tbl_payments_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `tbl_bookings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table platinum.tbl_payments: ~6 rows (approximately)
DELETE FROM `tbl_payments`;
INSERT INTO `tbl_payments` (`id`, `booking_id`, `payment_reference`, `stripe_payment_intent_id`, `stripe_session_id`, `amount`, `payment_method`, `status`, `payment_details`, `paid_at`, `created_at`, `updated_at`) VALUES
	(1, 1, 'PAY-698EE125B39CF', NULL, 'cs_test_a1rRwEssgTeRJBAPb8w73XgXZ13p5tH6eRCuE3BThjAnY9JNToCEJgcJq1', 10000.00, 'card', 'succeeded', '{"mode": "test", "amount": "3000.00", "created_at": "2026-02-13 08:30:33", "session_id": "cs_test_a1rRwEssgTeRJBAPb8w73XgXZ13p5tH6eRCuE3BThjAnY9JNToCEJgcJq1", "verified_at": "2026-02-13 08:32:25", "checkout_url": "https://checkout.stripe.com/c/pay/cs_test_a1rRwEssgTeRJBAPb8w73XgXZ13p5tH6eRCuE3BThjAnY9JNToCEJgcJq1#fidnandhYHdWcXxpYCc%2FJ2FgY2RwaXEnKSdkdWxOYHwnPyd1blpxYHZxWjA0VnxQMDRGR1RzbjRHfEB0PV82dTFiSWNGcGEyZHdCY0BASTIxQWhNc3A0QkJmY31vNUZDSmhfUkpOdzdkd3dGZ1FpN1RhPHBnY0hTZF9jdGB3VXRnPFxpNTVjR25ddjVDTScpJ2N3amhWYHdzYHcnP3F3cGApJ2dkZm5id2pwa2FGamlqdyc%2FJyZjY2NjY2MnKSdpZHxqcHFRfHVgJz8ndmxrYmlgWmxxYGgnKSdga2RnaWBVaWRmYG1qaWFgd3YnP3F3cGB4JSUl", "stripe_status": "paid", "checkout_session_created": true}', '2026-02-13 00:32:25', '2026-02-13 00:30:29', '2026-02-13 00:32:25'),
	(4, 3, 'PAY-698FEA4112514', NULL, 'cs_test_a1drVfqKj0u8B5nKt1eguamvl9ccqCGfSg5Ql7FX05fGnJw79izT9M2cwR', 3600.00, 'card', 'succeeded', '{"mode": "test", "amount": "3600.00", "created_at": "2026-02-14 03:22:00", "session_id": "cs_test_a1drVfqKj0u8B5nKt1eguamvl9ccqCGfSg5Ql7FX05fGnJw79izT9M2cwR", "verified_at": "2026-02-14 03:26:08", "checkout_url": "https://checkout.stripe.com/c/pay/cs_test_a1drVfqKj0u8B5nKt1eguamvl9ccqCGfSg5Ql7FX05fGnJw79izT9M2cwR#fidnandhYHdWcXxpYCc%2FJ2FgY2RwaXEnKSdkdWxOYHwnPyd1blpxYHZxWjA0VnxQMDRGR1RzbjRHfEB0PV82dTFiSWNGcGEyZHdCY0BASTIxQWhNc3A0QkJmY31vNUZDSmhfUkpOdzdkd3dGZ1FpN1RhPHBnY0hTZF9jdGB3VXRnPFxpNTVjR25ddjVDTScpJ2N3amhWYHdzYHcnP3F3cGApJ2dkZm5id2pwa2FGamlqdyc%2FJyZjY2NjY2MnKSdpZHxqcHFRfHVgJz8ndmxrYmlgWmxxYGgnKSdga2RnaWBVaWRmYG1qaWFgd3YnP3F3cGB4JSUl", "stripe_status": "paid", "is_balance_payment": false, "checkout_session_created": true}', '2026-02-13 19:26:08', '2026-02-13 19:21:37', '2026-02-13 19:26:08'),
	(5, 3, 'PAY-698FED89DA7CA', NULL, 'cs_test_a1QSofezKmxed2lfQ2R0bkPRgEkfeA3kbNm9OgKCLMyg5ALZUcxnqbyoEZ', 8400.00, 'card', 'succeeded', '{"mode": "test", "amount": "8400.00", "created_at": "2026-02-14 03:35:40", "session_id": "cs_test_a1QSofezKmxed2lfQ2R0bkPRgEkfeA3kbNm9OgKCLMyg5ALZUcxnqbyoEZ", "verified_at": "2026-02-14 03:36:33", "checkout_url": "https://checkout.stripe.com/c/pay/cs_test_a1QSofezKmxed2lfQ2R0bkPRgEkfeA3kbNm9OgKCLMyg5ALZUcxnqbyoEZ#fidnandhYHdWcXxpYCc%2FJ2FgY2RwaXEnKSdkdWxOYHwnPyd1blpxYHZxWjA0VnxQMDRGR1RzbjRHfEB0PV82dTFiSWNGcGEyZHdCY0BASTIxQWhNc3A0QkJmY31vNUZDSmhfUkpOdzdkd3dGZ1FpN1RhPHBnY0hTZF9jdGB3VXRnPFxpNTVjR25ddjVDTScpJ2N3amhWYHdzYHcnP3F3cGApJ2dkZm5id2pwa2FGamlqdyc%2FJyZjY2NjY2MnKSdpZHxqcHFRfHVgJz8ndmxrYmlgWmxxYGgnKSdga2RnaWBVaWRmYG1qaWFgd3YnP3F3cGB4JSUl", "stripe_status": "paid", "is_balance_payment": true, "checkout_session_created": true}', '2026-02-13 19:36:33', '2026-02-13 19:35:37', '2026-02-13 19:36:33'),
	(6, 4, 'PAY-698FF5A142347', NULL, 'cs_test_a1KnofqJ4I7p3kbOxvGm0zoKbpah6a7yUkDtMKUwS95WZP6M8VE9B43n0E', 13500.00, 'card', 'succeeded', '{"mode": "test", "amount": "13500.00", "created_at": "2026-02-14 04:10:15", "session_id": "cs_test_a1KnofqJ4I7p3kbOxvGm0zoKbpah6a7yUkDtMKUwS95WZP6M8VE9B43n0E", "verified_at": "2026-02-14 04:10:49", "checkout_url": "https://checkout.stripe.com/c/pay/cs_test_a1KnofqJ4I7p3kbOxvGm0zoKbpah6a7yUkDtMKUwS95WZP6M8VE9B43n0E#fidnandhYHdWcXxpYCc%2FJ2FgY2RwaXEnKSdkdWxOYHwnPyd1blpxYHZxWjA0VnxQMDRGR1RzbjRHfEB0PV82dTFiSWNGcGEyZHdCY0BASTIxQWhNc3A0QkJmY31vNUZDSmhfUkpOdzdkd3dGZ1FpN1RhPHBnY0hTZF9jdGB3VXRnPFxpNTVjR25ddjVDTScpJ2N3amhWYHdzYHcnP3F3cGApJ2dkZm5id2pwa2FGamlqdyc%2FJyZjY2NjY2MnKSdpZHxqcHFRfHVgJz8ndmxrYmlgWmxxYGgnKSdga2RnaWBVaWRmYG1qaWFgd3YnP3F3cGB4JSUl", "stripe_status": "paid", "is_balance_payment": false, "checkout_session_created": true}', '2026-02-13 20:10:49', '2026-02-13 20:10:09', '2026-02-13 20:10:49'),
	(7, 4, 'PAY-698FF689F009C', NULL, 'cs_test_a1q8oKZmmvow4jQAV5BZ14hxdOQqJsegcOybqNKj38rFbn082SifnCp3JX', 31500.00, 'card', 'succeeded', '{"mode": "test", "amount": "31500.00", "created_at": "2026-02-14 04:14:03", "session_id": "cs_test_a1q8oKZmmvow4jQAV5BZ14hxdOQqJsegcOybqNKj38rFbn082SifnCp3JX", "verified_at": "2026-02-14 04:14:24", "checkout_url": "https://checkout.stripe.com/c/pay/cs_test_a1q8oKZmmvow4jQAV5BZ14hxdOQqJsegcOybqNKj38rFbn082SifnCp3JX#fidnandhYHdWcXxpYCc%2FJ2FgY2RwaXEnKSdkdWxOYHwnPyd1blpxYHZxWjA0VnxQMDRGR1RzbjRHfEB0PV82dTFiSWNGcGEyZHdCY0BASTIxQWhNc3A0QkJmY31vNUZDSmhfUkpOdzdkd3dGZ1FpN1RhPHBnY0hTZF9jdGB3VXRnPFxpNTVjR25ddjVDTScpJ2N3amhWYHdzYHcnP3F3cGApJ2dkZm5id2pwa2FGamlqdyc%2FJyZjY2NjY2MnKSdpZHxqcHFRfHVgJz8ndmxrYmlgWmxxYGgnKSdga2RnaWBVaWRmYG1qaWFgd3YnP3F3cGB4JSUl", "stripe_status": "paid", "is_balance_payment": true, "checkout_session_created": true}', '2026-02-13 20:14:24', '2026-02-13 20:14:01', '2026-02-13 20:14:24'),
	(8, 5, 'PAY-69903850BAD01', NULL, 'cs_test_a1IiDGHfpWuhtkqn5A9vrjTjkBwXunQrGCYkQw3imV4kdymX0QutDlWa15', 45000.00, 'card', 'succeeded', '{"mode": "test", "amount": "13500.00", "created_at": "2026-02-14 08:54:44", "session_id": "cs_test_a1IiDGHfpWuhtkqn5A9vrjTjkBwXunQrGCYkQw3imV4kdymX0QutDlWa15", "verified_at": "2026-02-14 08:54:54", "checkout_url": "https://checkout.stripe.com/c/pay/cs_test_a1IiDGHfpWuhtkqn5A9vrjTjkBwXunQrGCYkQw3imV4kdymX0QutDlWa15#fidnandhYHdWcXxpYCc%2FJ2FgY2RwaXEnKSdkdWxOYHwnPyd1blpxYHZxWjA0VnxQMDRGR1RzbjRHfEB0PV82dTFiSWNGcGEyZHdCY0BASTIxQWhNc3A0QkJmY31vNUZDSmhfUkpOdzdkd3dGZ1FpN1RhPHBnY0hTZF9jdGB3VXRnPFxpNTVjR25ddjVDTScpJ2N3amhWYHdzYHcnP3F3cGApJ2dkZm5id2pwa2FGamlqdyc%2FJyZjY2NjY2MnKSdpZHxqcHFRfHVgJz8ndmxrYmlgWmxxYGgnKSdga2RnaWBVaWRmYG1qaWFgd3YnP3F3cGB4JSUl", "stripe_status": "paid", "is_balance_payment": false, "checkout_session_created": true}', '2026-02-14 00:54:54', '2026-02-14 00:54:40', '2026-02-14 00:54:54'),
	(9, 6, 'PAY-6992F792BDD3E', NULL, NULL, 1950.00, 'pending', 'pending', NULL, NULL, '2026-02-16 02:55:14', '2026-02-16 02:55:14'),
	(10, 7, 'PAY-6992F7B1D4231', NULL, 'cs_test_a1ukfRYKSLGtToMGEQDCWqnLsmhkIOTBM2k2q5GXpRfrLQbASlgiElJBAx', 1950.00, 'card', 'succeeded', '{"mode": "test", "amount": "1950.00", "created_at": "2026-02-16 10:56:05", "session_id": "cs_test_a1ukfRYKSLGtToMGEQDCWqnLsmhkIOTBM2k2q5GXpRfrLQbASlgiElJBAx", "verified_at": "2026-02-16 10:56:29", "checkout_url": "https://checkout.stripe.com/c/pay/cs_test_a1ukfRYKSLGtToMGEQDCWqnLsmhkIOTBM2k2q5GXpRfrLQbASlgiElJBAx#fidnandhYHdWcXxpYCc%2FJ2FgY2RwaXEnKSdkdWxOYHwnPyd1blpxYHZxWjA0VnxQMDRGR1RzbjRHfEB0PV82dTFiSWNGcGEyZHdCY0BASTIxQWhNc3A0QkJmY31vNUZDSmhfUkpOdzdkd3dGZ1FpN1RhPHBnY0hTZF9jdGB3VXRnPFxpNTVjR25ddjVDTScpJ2N3amhWYHdzYHcnP3F3cGApJ2dkZm5id2pwa2FGamlqdyc%2FJyZjY2NjY2MnKSdpZHxqcHFRfHVgJz8ndmxrYmlgWmxxYGgnKSdga2RnaWBVaWRmYG1qaWFgd3YnP3F3cGB4JSUl", "stripe_status": "paid", "is_balance_payment": false, "checkout_session_created": true}', '2026-02-16 02:56:29', '2026-02-16 02:55:45', '2026-02-16 02:56:29');

-- Dumping structure for table platinum.tbl_services
CREATE TABLE IF NOT EXISTS `tbl_services` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `studio_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  `service_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_services_category_id_foreign` (`category_id`),
  KEY `tbl_services_studio_id_category_id_index` (`studio_id`,`category_id`),
  CONSTRAINT `tbl_services_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `tbl_categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_services_studio_id_foreign` FOREIGN KEY (`studio_id`) REFERENCES `tbl_studios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table platinum.tbl_services: ~5 rows (approximately)
DELETE FROM `tbl_services`;
INSERT INTO `tbl_services` (`id`, `studio_id`, `category_id`, `service_name`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, '"[\\"Full-Day Wedding Coverage\\",\\"Pre-Wedding \\\\\\/ Engagement Shoot\\",\\"Candid & Documentary Photography\\",\\"High-Resolution Edited Photos\\",\\"Premium Photo Album \\\\\\/ Prints Package\\"]"', '2026-02-04 23:19:14', '2026-02-04 23:19:14'),
	(2, 1, 2, '"[\\"Wedding Moments\\",\\"Corporate Gala Coverage\\",\\"Birthday Celebration Capture\\",\\"Concert & Festival Photography\\",\\"Engagement & Pre-Event Shoots\\"]"', '2026-02-05 02:17:51', '2026-02-05 02:17:51'),
	(3, 1, 6, '"[\\"Editorial Elegance Package\\",\\"Runway & Backstage Coverage\\",\\"Designer Lookbook Creation\\",\\"Model Portfolio Development\\",\\"Street Style Chronicles\\"]"', '2026-02-05 02:18:56', '2026-02-05 02:18:56'),
	(4, 1, 4, '"[\\"E\\\\u2011Commerce Essentials Package\\",\\"Lifestyle Product\\",\\"Premium Studio Catalog\\",\\"Creative Branding Shots\\",\\"360\\\\u00b0 Interactive Product Views\\"]"', '2026-02-05 02:20:12', '2026-02-05 02:20:12'),
	(5, 1, 7, '"[\\"Social Impact\\",\\"Cultural Heritage Chronicles\\",\\"Human Journey Portraits\\",\\"Environmental Change Diaries\\",\\"Behind-the-Scenes Realities\\"]"', '2026-02-05 02:20:49', '2026-02-05 02:20:49'),
	(6, 2, 3, '"[\\"Classic Family Portrait Session\\",\\"Outdoor Lifestyle Family Shoot\\",\\"Studio Creative Family Portraits\\",\\"Holiday-Themed Family Portraits\\",\\"Generational Family Legacy Portrait\\"]"', '2026-02-06 20:22:13', '2026-02-06 20:22:13'),
	(7, 2, 9, '"[\\"Interior & Exterior Property Photography\\",\\"Luxury Real Estate Photo Package\\",\\"Aerial Drone Property Photography\\",\\"Twilight & Sunset Real Estate Shoot\\"]"', '2026-02-13 07:17:25', '2026-02-13 07:17:25');

-- Dumping structure for table platinum.tbl_studios
CREATE TABLE IF NOT EXISTS `tbl_studios` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned DEFAULT NULL,
  `location_id` bigint unsigned DEFAULT NULL,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barangay` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `studio_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `studio_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `studio_type` enum('photography_studio','video_production','mixed_media') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'photography_studio',
  `year_established` int NOT NULL,
  `studio_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `studio_logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `starting_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `operating_days` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `max_clients_per_day` int NOT NULL DEFAULT '1',
  `advance_booking_days` int NOT NULL DEFAULT '1',
  `business_permit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_id_document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','verified','rejected','active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `rejection_note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_studios_user_id_index` (`user_id`),
  KEY `tbl_studios_status_index` (`status`),
  KEY `tbl_studios_category_id_foreign` (`category_id`),
  KEY `fk_studios_location_id` (`location_id`),
  CONSTRAINT `fk_studios_location_id` FOREIGN KEY (`location_id`) REFERENCES `tbl_locations` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `tbl_studios_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `tbl_categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `tbl_studios_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_studios_chk_1` CHECK (json_valid(`operating_days`))
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table platinum.tbl_studios: ~2 rows (approximately)
DELETE FROM `tbl_studios`;
INSERT INTO `tbl_studios` (`id`, `user_id`, `category_id`, `location_id`, `street`, `barangay`, `contact_number`, `studio_email`, `facebook_url`, `instagram_url`, `website_url`, `studio_name`, `studio_type`, `year_established`, `studio_description`, `studio_logo`, `starting_price`, `operating_days`, `start_time`, `end_time`, `max_clients_per_day`, `advance_booking_days`, `business_permit`, `owner_id_document`, `status`, `rejection_note`, `created_at`, `updated_at`) VALUES
	(1, 2, 1, 1, 'Unit 3B Rivera Commercial Building, Advincula Road, Carsadang Bago II, Dasmarinas City, Cavite', 'Paliparan III', '+63 917 482 1934', 'hello@lumenforge.ph', 'https://facebook.com/lumenforgecreative', 'https://instagram.com/lumenforgecreative', 'https://www.lumenforge.ph', 'LumenForge Creative Studio', 'photography_studio', 2022, 'LumenForge Creative Studio is a Cavite-based visual storytelling brand focused on weddings, lifestyle portraits, and commercial photography. We blend natural light, cinematic composition, and authentic emotion to create timeless images for individuals and businesses.', 'studio_logo/fe095dd3-3cf1-4ec8-8ae9-86d66155f2b8.png', '10000', '"[\\"monday\\",\\"tuesday\\",\\"wednesday\\",\\"thursday\\",\\"friday\\",\\"saturday\\"]"', '10:00:00', '18:00:00', 2, 5, 'studio_documents/998a5f61-a76f-4f25-a679-58451c192809.pdf', 'studio_documents/4c932c43-3fa4-4a60-8c0a-bccc735e5227.jpg', 'verified', NULL, '2026-02-04 23:08:45', '2026-02-04 23:11:41'),
	(2, 2, 1, 1, 'Blk 5 Lot 12, Emerald Heights Subdivision, Salitran II', 'Salitran III', '+639178234512', 'contact@pixelframe.ph', 'https://facebook.com/pixelframecreative', 'https://instagram.com/pixelframe.ph', 'https://www.pixelframe.ph', 'PixelFrame Creative Studio', 'photography_studio', 2019, 'PixelFrame Creative Studio specializes in wedding, portrait, and commercial photography. We provide high-quality visual storytelling using professional equipment and creative direction tailored to each client.', 'studio_logo/987a8637-d17b-4eb5-ba3a-6f46a97776ce.png', '12000', '"[\\"monday\\",\\"tuesday\\",\\"wednesday\\",\\"thursday\\",\\"friday\\",\\"saturday\\"]"', '09:00:00', '18:00:00', 3, 3, 'studio_documents/243aba50-ddd5-4738-9616-91b2d8ba035b.pdf', 'studio_documents/21d424c9-2eea-42c7-88af-221a80a01b82.jpg', 'verified', NULL, '2026-02-05 05:18:24', '2026-02-06 15:54:18');

-- Dumping structure for table platinum.tbl_studio_members
CREATE TABLE IF NOT EXISTS `tbl_studio_members` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `studio_id` bigint unsigned NOT NULL,
  `freelancer_id` bigint unsigned NOT NULL,
  `invited_by` bigint unsigned NOT NULL,
  `invitation_message` text COLLATE utf8mb4_unicode_ci,
  `status` enum('pending','approved','rejected','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `response_message` text COLLATE utf8mb4_unicode_ci,
  `invited_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `responded_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_studio_freelancer` (`studio_id`,`freelancer_id`),
  KEY `tbl_studio_members_invited_by_foreign` (`invited_by`),
  KEY `tbl_studio_members_studio_id_status_index` (`studio_id`,`status`),
  KEY `tbl_studio_members_freelancer_id_status_index` (`freelancer_id`,`status`),
  CONSTRAINT `tbl_studio_members_freelancer_id_foreign` FOREIGN KEY (`freelancer_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_studio_members_invited_by_foreign` FOREIGN KEY (`invited_by`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_studio_members_studio_id_foreign` FOREIGN KEY (`studio_id`) REFERENCES `tbl_studios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table platinum.tbl_studio_members: ~1 rows (approximately)
DELETE FROM `tbl_studio_members`;
INSERT INTO `tbl_studio_members` (`id`, `studio_id`, `freelancer_id`, `invited_by`, `invitation_message`, `status`, `response_message`, `invited_at`, `responded_at`, `created_at`, `updated_at`) VALUES
	(1, 1, 14, 2, 'Hi Jane Trevino!\r\n\r\nI really love your photography style and would love to discuss possible collaboration for upcoming projects.\r\n\r\nBest regards,\r\nStudio Owner', 'approved', NULL, '2026-02-05 06:43:05', '2026-02-05 06:44:07', '2026-02-05 06:43:05', '2026-02-05 06:44:07');

-- Dumping structure for table platinum.tbl_studio_online_gallery
CREATE TABLE IF NOT EXISTS `tbl_studio_online_gallery` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `booking_id` bigint unsigned NOT NULL,
  `studio_id` bigint unsigned NOT NULL,
  `client_id` bigint unsigned NOT NULL,
  `gallery_reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gallery_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `images` json DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `total_photos` int NOT NULL DEFAULT '0',
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tbl_studio_online_gallery_gallery_reference_unique` (`gallery_reference`),
  KEY `tbl_studio_online_gallery_booking_id_index` (`booking_id`),
  KEY `tbl_studio_online_gallery_studio_id_index` (`studio_id`),
  KEY `tbl_studio_online_gallery_client_id_index` (`client_id`),
  KEY `tbl_studio_online_gallery_status_index` (`status`),
  CONSTRAINT `tbl_studio_online_gallery_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `tbl_bookings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_studio_online_gallery_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_studio_online_gallery_studio_id_foreign` FOREIGN KEY (`studio_id`) REFERENCES `tbl_studios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table platinum.tbl_studio_online_gallery: ~0 rows (approximately)
DELETE FROM `tbl_studio_online_gallery`;
INSERT INTO `tbl_studio_online_gallery` (`id`, `booking_id`, `studio_id`, `client_id`, `gallery_reference`, `gallery_name`, `description`, `images`, `status`, `total_photos`, `published_at`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 53, 'GAL-6992E2BBA9456', 'The Wedding Landscape', 'Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas. Iaculis massa nisl malesuada lacinia integer nunc posuere. Ut hendrerit semper vel class aptent taciti sociosqu. Ad litora torquent per conubia nostra inceptos himenaeos.', '["studio-online-galleries/1/6Pr2fn1I0BkQf6TQQPqEt0T3NG3GvFPi0XQhDhl6.png", "studio-online-galleries/1/ejkRLfl7XJO8MsqiZHiSbB4zXCZA3jh7y6BI8gPM.png", "studio-online-galleries/1/GnruyGbt5z2ty4vnPFFoaT045m09sUuhDt32fKWb.png", "studio-online-galleries/1/RjvQQIJ10fwFRRZYuFT2J5t6vQZp1GiA6Bdfx5Ht.png", "studio-online-galleries/1/RR4BpoLYxZny0Sl5AepNPHCwYgzHgp26NSSAzxu7.png"]', 'active', 5, '2026-02-16 01:26:19', '2026-02-16 01:26:19', '2026-02-16 01:26:19');

-- Dumping structure for table platinum.tbl_studio_photographers
CREATE TABLE IF NOT EXISTS `tbl_studio_photographers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `studio_id` bigint unsigned NOT NULL,
  `owner_id` bigint unsigned NOT NULL,
  `photographer_id` bigint unsigned NOT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `specialization` bigint unsigned DEFAULT NULL,
  `years_of_experience` int DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tbl_studio_photographers_studio_id_photographer_id_unique` (`studio_id`,`photographer_id`),
  KEY `tbl_studio_photographers_studio_id_index` (`studio_id`),
  KEY `tbl_studio_photographers_owner_id_index` (`owner_id`),
  KEY `tbl_studio_photographers_photographer_id_index` (`photographer_id`),
  KEY `tbl_studio_photographers_specialization_index` (`specialization`),
  KEY `tbl_studio_photographers_status_index` (`status`),
  CONSTRAINT `tbl_studio_photographers_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_studio_photographers_photographer_id_foreign` FOREIGN KEY (`photographer_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_studio_photographers_specialization_foreign` FOREIGN KEY (`specialization`) REFERENCES `tbl_services` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_studio_photographers_studio_id_foreign` FOREIGN KEY (`studio_id`) REFERENCES `tbl_studios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table platinum.tbl_studio_photographers: ~3 rows (approximately)
DELETE FROM `tbl_studio_photographers`;
INSERT INTO `tbl_studio_photographers` (`id`, `studio_id`, `owner_id`, `photographer_id`, `position`, `specialization`, `years_of_experience`, `status`, `created_at`, `updated_at`) VALUES
	(1, 1, 2, 18, 'Senior Photographer', 3, 12, 'active', '2026-02-06 00:27:03', '2026-02-06 00:27:03'),
	(2, 1, 2, 19, 'Photographer', 2, 5, 'active', '2026-02-06 00:28:42', '2026-02-06 00:28:42'),
	(4, 1, 2, 21, 'Senior Photographer', 4, 8, 'active', '2026-02-06 01:08:32', '2026-02-06 01:08:32'),
	(5, 2, 2, 22, 'Second Shooter', 6, 5, 'active', '2026-02-06 20:23:32', '2026-02-06 20:23:32'),
	(6, 1, 2, 83, 'Lead Photographer', 2, 4, 'active', '2026-02-11 22:56:30', '2026-02-11 22:56:30'),
	(7, 2, 2, 84, 'Senior Photographer', 7, 7, 'active', '2026-02-13 07:23:32', '2026-02-13 07:23:32');

-- Dumping structure for table platinum.tbl_studio_ratings
CREATE TABLE IF NOT EXISTS `tbl_studio_ratings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `booking_id` bigint unsigned NOT NULL,
  `client_id` bigint unsigned NOT NULL,
  `studio_id` bigint unsigned NOT NULL,
  `rating` tinyint unsigned NOT NULL COMMENT '1-5 stars',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `review_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `review_type` enum('positive','neutral','negative') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preset_used` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'The preset review template used',
  `is_recommend` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_booking_review` (`booking_id`),
  KEY `tbl_studio_ratings_client_id_foreign` (`client_id`),
  KEY `tbl_studio_ratings_studio_id_foreign` (`studio_id`),
  CONSTRAINT `tbl_studio_ratings_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `tbl_bookings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_studio_ratings_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_studio_ratings_studio_id_foreign` FOREIGN KEY (`studio_id`) REFERENCES `tbl_studios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table platinum.tbl_studio_ratings: ~2 rows (approximately)
DELETE FROM `tbl_studio_ratings`;
INSERT INTO `tbl_studio_ratings` (`id`, `booking_id`, `client_id`, `studio_id`, `rating`, `title`, `review_text`, `review_type`, `preset_used`, `is_recommend`, `created_at`, `updated_at`) VALUES
	(1, 1, 53, 1, 3, 'Non blanditiis aute', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'neutral', 'Good quality pictures, though communication could improve.', 1, '2026-02-14 00:21:21', '2026-02-14 00:21:21'),
	(2, 3, 53, 2, 5, NULL, 'Amazing experience! The photos turned out beautifully and the staff was very professional.', 'positive', 'Amazing experience! The photos turned out beautifully and the staff was very professional.', 1, '2026-02-14 00:35:07', '2026-02-14 00:35:07');

-- Dumping structure for table platinum.tbl_studio_schedules
CREATE TABLE IF NOT EXISTS `tbl_studio_schedules` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `studio_id` bigint unsigned NOT NULL,
  `location_id` bigint unsigned NOT NULL,
  `operating_days` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `opening_time` time NOT NULL,
  `closing_time` time NOT NULL,
  `booking_limit` int NOT NULL,
  `advance_booking` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_studio_schedules_studio_id_index` (`studio_id`),
  KEY `tbl_studio_schedules_location_id_index` (`location_id`),
  CONSTRAINT `tbl_studio_schedules_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `tbl_locations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_studio_schedules_studio_id_foreign` FOREIGN KEY (`studio_id`) REFERENCES `tbl_studios` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_studio_schedules_chk_1` CHECK (json_valid(`operating_days`))
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table platinum.tbl_studio_schedules: ~2 rows (approximately)
DELETE FROM `tbl_studio_schedules`;
INSERT INTO `tbl_studio_schedules` (`id`, `studio_id`, `location_id`, `operating_days`, `opening_time`, `closing_time`, `booking_limit`, `advance_booking`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, '"[\\"monday\\",\\"tuesday\\",\\"wednesday\\",\\"thursday\\",\\"friday\\",\\"saturday\\"]"', '10:00:00', '18:00:00', 2, 5, '2026-02-04 23:08:45', '2026-02-04 23:08:45'),
	(2, 2, 1, '"[\\"monday\\",\\"tuesday\\",\\"wednesday\\",\\"thursday\\",\\"friday\\",\\"saturday\\"]"', '09:00:00', '18:00:00', 3, 3, '2026-02-05 05:18:24', '2026-02-05 05:18:24');

-- Dumping structure for table platinum.tbl_system_revenue
CREATE TABLE IF NOT EXISTS `tbl_system_revenue` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `transaction_reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `booking_id` bigint unsigned NOT NULL,
  `payment_id` bigint unsigned NOT NULL,
  `total_amount` decimal(12,2) NOT NULL,
  `platform_fee_percentage` decimal(5,2) NOT NULL DEFAULT '10.00',
  `platform_fee_amount` decimal(12,2) NOT NULL,
  `provider_amount` decimal(12,2) NOT NULL,
  `provider_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider_id` bigint unsigned NOT NULL,
  `client_id` bigint unsigned NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `breakdown` json DEFAULT NULL,
  `settled_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tbl_system_revenue_transaction_reference_unique` (`transaction_reference`),
  KEY `tbl_system_revenue_transaction_reference_index` (`transaction_reference`),
  KEY `tbl_system_revenue_booking_id_index` (`booking_id`),
  KEY `tbl_system_revenue_payment_id_index` (`payment_id`),
  KEY `tbl_system_revenue_provider_id_index` (`provider_id`),
  KEY `tbl_system_revenue_client_id_index` (`client_id`),
  KEY `tbl_system_revenue_status_index` (`status`),
  CONSTRAINT `tbl_system_revenue_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `tbl_bookings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_system_revenue_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_system_revenue_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `tbl_payments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table platinum.tbl_system_revenue: ~5 rows (approximately)
DELETE FROM `tbl_system_revenue`;
INSERT INTO `tbl_system_revenue` (`id`, `transaction_reference`, `booking_id`, `payment_id`, `total_amount`, `platform_fee_percentage`, `platform_fee_amount`, `provider_amount`, `provider_type`, `provider_id`, `client_id`, `status`, `breakdown`, `settled_at`, `created_at`, `updated_at`) VALUES
	(1, 'REV-698EE199D9A21', 1, 1, 3000.00, 10.00, 300.00, 2700.00, 'studio', 1, 53, 'completed', '{"calculation": {"platform_fee": 300, "total_payment": "3000.00", "provider_earnings": 2700}, "payment_type": "downpayment", "booking_reference": "BK-698EE125AF63F", "payment_reference": "PAY-698EE125B39CF", "platform_fee_percentage": "10%"}', '2026-02-13 00:32:25', '2026-02-13 00:32:25', '2026-02-13 00:32:25'),
	(4, 'REV-698FEB50DA551', 3, 4, 3600.00, 10.00, 360.00, 3240.00, 'studio', 2, 53, 'completed', '{"calculation": {"platform_fee": 360, "total_payment": "3600.00", "provider_earnings": 3240}, "payment_type": "downpayment", "booking_reference": "BK-698FEA41096D4", "payment_reference": "PAY-698FEA4112514", "platform_fee_percentage": "10%"}', '2026-02-13 19:26:08', '2026-02-13 19:26:08', '2026-02-13 19:26:08'),
	(5, 'REV-698FEDC18A35F', 3, 5, 8400.00, 10.00, 840.00, 7560.00, 'studio', 2, 53, 'completed', '{"calculation": {"platform_fee": 840, "total_payment": "8400.00", "provider_earnings": 7560}, "payment_type": "downpayment", "booking_reference": "BK-698FEA41096D4", "payment_reference": "PAY-698FED89DA7CA", "platform_fee_percentage": "10%"}', '2026-02-13 19:36:33', '2026-02-13 19:36:33', '2026-02-13 19:36:33'),
	(6, 'REV-698FF5C9F32EE', 4, 6, 13500.00, 10.00, 1350.00, 12150.00, 'freelancer', 14, 66, 'completed', '{"calculation": {"platform_fee": 1350, "total_payment": "13500.00", "provider_earnings": 12150}, "payment_type": "downpayment", "booking_reference": "BK-698FF5A12EEF9", "payment_reference": "PAY-698FF5A142347", "platform_fee_percentage": "10%"}', '2026-02-13 20:10:49', '2026-02-13 20:10:49', '2026-02-13 20:10:49'),
	(7, 'REV-698FF6A074762', 4, 7, 31500.00, 10.00, 3150.00, 28350.00, 'freelancer', 14, 66, 'completed', '{"calculation": {"platform_fee": 3150, "total_payment": "31500.00", "provider_earnings": 28350}, "payment_type": "downpayment", "booking_reference": "BK-698FF5A12EEF9", "payment_reference": "PAY-698FF689F009C", "platform_fee_percentage": "10%"}', '2026-02-13 20:14:24', '2026-02-13 20:14:24', '2026-02-13 20:14:24'),
	(8, 'REV-6990385EEFD6B', 5, 8, 13500.00, 10.00, 1350.00, 12150.00, 'freelancer', 14, 53, 'completed', '{"calculation": {"platform_fee": 1350, "total_payment": "13500.00", "provider_earnings": 12150}, "payment_type": "downpayment", "booking_reference": "BK-69903850B66F7", "payment_reference": "PAY-69903850BAD01", "platform_fee_percentage": "10%"}', '2026-02-14 00:54:54', '2026-02-14 00:54:54', '2026-02-14 00:54:54'),
	(9, 'REV-6992F7DDD7AE5', 7, 10, 1950.00, 10.00, 195.00, 1755.00, 'studio', 2, 69, 'completed', '{"calculation": {"platform_fee": 195, "total_payment": "1950.00", "provider_earnings": 1755}, "payment_type": "downpayment", "booking_reference": "BK-6992F7B1C7893", "payment_reference": "PAY-6992F7B1D4231", "platform_fee_percentage": "10%"}', '2026-02-16 02:56:29', '2026-02-16 02:56:29', '2026-02-16 02:56:29');

-- Dumping structure for table platinum.tbl_users
CREATE TABLE IF NOT EXISTS `tbl_users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','owner','freelancer','client','studio-photographer','studio-staff') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'client',
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type` enum('Photographer','Customer','Admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Customer',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location_id` bigint unsigned DEFAULT NULL,
  `status` enum('active','inactive','suspended') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `email_verified` tinyint(1) NOT NULL DEFAULT '0',
  `verification_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token_expiry` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tbl_users_uuid_unique` (`uuid`),
  UNIQUE KEY `tbl_users_email_unique` (`email`),
  KEY `tbl_users_email_index` (`email`),
  KEY `tbl_users_role_index` (`role`),
  KEY `tbl_users_status_index` (`status`),
  KEY `tbl_users_location_id_index` (`location_id`),
  CONSTRAINT `tbl_users_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `tbl_locations` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table platinum.tbl_users: ~40 rows (approximately)
DELETE FROM `tbl_users`;
INSERT INTO `tbl_users` (`id`, `uuid`, `role`, `first_name`, `middle_name`, `last_name`, `user_type`, `email`, `mobile_number`, `password`, `profile_photo`, `location_id`, `status`, `email_verified`, `verification_token`, `token_expiry`, `created_at`, `updated_at`) VALUES
	(1, 'fe0cd758-dbd6-47f5-a71f-de0ef3dd6079', 'admin', 'Studio', 'System', 'Administrator', 'Admin', 'snapstudio_admin@gmail.com', '+633109293132', '$2y$12$1q3FNPIgmFlGo6tcIn/FT.2rvUxNAJW5.JlWJ/9Xq0bwTt8lMOxZS', NULL, 2, 'active', 1, NULL, NULL, '2026-01-24 09:49:41', '2026-01-24 09:49:41'),
	(2, '80de2178-c2ac-4db2-a2d9-d1b0066c8b7a', 'owner', 'Dexter', 'Macy Roy', 'Velazquez', 'Photographer', 'kysohive@denipl.com', '+639123456801', '$2y$12$1q3FNPIgmFlGo6tcIn/FT.2rvUxNAJW5.JlWJ/9Xq0bwTt8lMOxZS', NULL, 1, 'active', 1, NULL, NULL, '2026-02-04 23:00:35', '2026-02-04 23:00:35'),
	(14, '78d2b02a-a8c2-40b9-b563-758e1fc63696', 'freelancer', 'Jane', 'Moses Porter', 'Trevino', 'Photographer', 'tebuqah@mailinator.com', '+631111111111', '$2y$12$1q3FNPIgmFlGo6tcIn/FT.2rvUxNAJW5.JlWJ/9Xq0bwTt8lMOxZS', 'profile-photos/YR716wuQth7HnBuCYcK0MEgSzLbI57VflRAEYhm1.png', 18, 'active', 1, NULL, NULL, '2026-02-05 05:50:47', '2026-02-05 06:18:56'),
	(15, '6a92fbe3-eebb-47c1-ba42-bf61acc573e4', 'freelancer', 'Ivana', 'Fay Rutledge', 'Odom', 'Photographer', 'kefuje@mailinator.com', '+632222222222', '$2y$12$1q3FNPIgmFlGo6tcIn/FT.2rvUxNAJW5.JlWJ/9Xq0bwTt8lMOxZS', NULL, 6, 'active', 1, NULL, NULL, '2026-02-05 05:51:10', '2026-02-05 05:51:10'),
	(16, 'c3ec4fce-774d-4498-9264-1e983527e673', 'freelancer', 'Brody', 'Upton Robles', 'Stevens', 'Photographer', 'zuvadowur@mailinator.com', '+633333333333', '$2y$12$1q3FNPIgmFlGo6tcIn/FT.2rvUxNAJW5.JlWJ/9Xq0bwTt8lMOxZS', NULL, 19, 'active', 1, NULL, NULL, '2026-02-05 05:51:51', '2026-02-05 05:51:51'),
	(17, '91e9ff17-6308-4368-84bb-8d9f63d5ac90', 'freelancer', 'Chandler', 'Cheyenne Barron', 'Solomon', 'Photographer', 'fuposilyni@mailinator.com', '+634444444444', '$2y$12$1q3FNPIgmFlGo6tcIn/FT.2rvUxNAJW5.JlWJ/9Xq0bwTt8lMOxZS', NULL, 21, 'active', 1, NULL, NULL, '2026-02-05 05:53:05', '2026-02-05 05:53:05'),
	(18, 'e9fe37e4-2211-4968-aa54-8f1ea14c63d3', 'studio-photographer', 'Yardley', 'Rylee Figueroa', 'Kerr', 'Photographer', 'guniqo@mailinator.com', '+(63)761 231 2381', '$2y$12$p.EhdidWEeepCOzZkaLbrutsAzqLg2aUvBd75XXV9Opo.yJxJBTKa', 'profile_1770366421.png', NULL, 'active', 1, NULL, NULL, '2026-02-06 00:27:03', '2026-02-06 00:27:03'),
	(19, '1124eff4-bbe9-4272-9b88-7f4e7051081e', 'studio-photographer', 'Morgan', 'Nichole Hayden', 'Holder', 'Photographer', 'reguvahami@mailinator.com', '+(63)430 938 4093', '$2y$12$ME21Lf61g7XuhYOkJjP1IOSgwB0oznJGE24kO7O7/.C6CF9N4EQce', 'profile_1770366522.png', NULL, 'active', 1, NULL, NULL, '2026-02-06 00:28:42', '2026-02-06 00:28:42'),
	(21, '5bee937b-2dce-49c9-818e-16896a436e87', 'studio-photographer', 'Willa', 'Nell Hale', 'Quinn', 'Photographer', 'hefi@mailinator.com', '+(63)798 218 9379', '$2y$12$3dFd5bvVjZ1vGVO/QGpFkOKTesABZjLQH3RzsPImLzsIE.uVuI.CC', 'profile_1770368912.png', NULL, 'active', 1, NULL, NULL, '2026-02-06 01:08:32', '2026-02-06 01:08:32'),
	(22, '1fe7d76f-377c-401a-9dff-0aaf31a56024', 'studio-photographer', 'Jamal', 'Emi Mcmillan', 'Hopkins', 'Photographer', 'vixehocy@denipl.com', '+(63)311 231 2313', '$2y$12$1McMqTCrXM681mCpUFloDOR9N1r8WJdZ3KwpdsgO0mNu9uhtGcZDu', 'profile_1770438210.png', NULL, 'active', 1, NULL, NULL, '2026-02-06 20:23:32', '2026-02-06 20:23:32'),
	(53, '65031538-1347-4c1e-aec1-12fd77a0e476', 'client', 'David', 'O.', 'Miller', 'Customer', 'david.miller1@example.com', '+15349735002', '$2y$12$1q3FNPIgmFlGo6tcIn/FT.2rvUxNAJW5.JlWJ/9Xq0bwTt8lMOxZS', NULL, 2, 'active', 1, NULL, NULL, '2026-02-06 20:37:25', '2026-02-06 20:37:25'),
	(54, '09827a02-a1b2-48c9-8811-8dbc1764bbde', 'client', 'Mark', 'G.', 'Robinson', 'Customer', 'mark.robinson2@example.com', '+18423819131', '$2y$12$1q3FNPIgmFlGo6tcIn/FT.2rvUxNAJW5.JlWJ/9Xq0bwTt8lMOxZS', NULL, 18, 'active', 1, NULL, NULL, '2026-02-06 20:37:25', '2026-02-06 20:37:25'),
	(55, '691e653e-480c-4e14-861c-a8e96d2f7512', 'client', 'Sarah', 'J.', 'Clark', 'Customer', 'sarah.clark3@example.com', '+18627843220', '$2y$12$1q3FNPIgmFlGo6tcIn/FT.2rvUxNAJW5.JlWJ/9Xq0bwTt8lMOxZS', NULL, 2, 'active', 1, NULL, NULL, '2026-02-06 20:37:25', '2026-02-06 20:37:25'),
	(56, 'bbe3a03b-9e83-49dc-a08c-10e88060919c', 'client', 'Maria', 'Y.', 'Brown', 'Customer', 'maria.brown4@example.com', '+18947671590', '$2y$12$1q3FNPIgmFlGo6tcIn/FT.2rvUxNAJW5.JlWJ/9Xq0bwTt8lMOxZS', NULL, 20, 'active', 1, NULL, NULL, '2026-02-06 20:37:25', '2026-02-06 20:37:25'),
	(57, 'd5eda1b7-b0e4-4761-ad96-a50bbb5ba344', 'client', 'James', 'E.', 'Clark', 'Customer', 'james.clark5@example.com', '+14626537902', '$2y$12$1q3FNPIgmFlGo6tcIn/FT.2rvUxNAJW5.JlWJ/9Xq0bwTt8lMOxZS', NULL, 21, 'active', 1, NULL, NULL, '2026-02-06 20:37:25', '2026-02-06 20:37:25'),
	(58, '93ca180e-cbe2-4b32-902d-821e8e9ff86c', 'client', 'Daniel', 'V.', 'Brown', 'Customer', 'daniel.brown6@example.com', '+19175157707', '$2y$12$1q3FNPIgmFlGo6tcIn/FT.2rvUxNAJW5.JlWJ/9Xq0bwTt8lMOxZS', NULL, 18, 'active', 1, NULL, NULL, '2026-02-06 20:37:25', '2026-02-06 20:37:25'),
	(59, 'af990d67-73ec-438c-b194-10172c54a346', 'client', 'Robert', NULL, 'Clark', 'Customer', 'robert.clark7@example.com', '+14813087510', '$2y$12$1q3FNPIgmFlGo6tcIn/FT.2rvUxNAJW5.JlWJ/9Xq0bwTt8lMOxZS', NULL, 7, 'active', 1, NULL, NULL, '2026-02-06 20:37:25', '2026-02-06 20:37:25'),
	(60, 'f84b4275-1fd7-4b29-be54-47252b9f1016', 'client', 'Michael', NULL, 'Martinez', 'Customer', 'michael.martinez8@example.com', '+13105114736', '$2y$12$1q3FNPIgmFlGo6tcIn/FT.2rvUxNAJW5.JlWJ/9Xq0bwTt8lMOxZS', NULL, 2, 'active', 1, NULL, NULL, '2026-02-06 20:37:25', '2026-02-06 20:37:25'),
	(61, 'fecd1053-87ae-4955-bf94-5aa279773f37', 'client', 'Sarah', NULL, 'Brown', 'Customer', 'sarah.brown9@example.com', '+16281363729', '$2y$12$1q3FNPIgmFlGo6tcIn/FT.2rvUxNAJW5.JlWJ/9Xq0bwTt8lMOxZS', NULL, 2, 'active', 1, NULL, NULL, '2026-02-06 20:37:25', '2026-02-06 20:37:25'),
	(62, 'b204adc7-8fe9-4626-8697-efa11b8a4ab3', 'client', 'Anthony', NULL, 'Martin', 'Customer', 'anthony.martin10@example.com', '+19832946428', '$2y$12$1q3FNPIgmFlGo6tcIn/FT.2rvUxNAJW5.JlWJ/9Xq0bwTt8lMOxZS', NULL, 1, 'active', 1, NULL, NULL, '2026-02-06 20:37:25', '2026-02-06 20:37:25'),
	(63, '53f21a0e-474f-4f0d-b863-fdda1dfe8a12', 'client', 'Joseph', NULL, 'Lewis', 'Customer', 'joseph.lewis11@example.com', '+18395948374', '$2y$12$1q3FNPIgmFlGo6tcIn/FT.2rvUxNAJW5.JlWJ/9Xq0bwTt8lMOxZS', NULL, 20, 'active', 1, NULL, NULL, '2026-02-06 20:37:25', '2026-02-06 20:37:25'),
	(64, 'dd5f3e3e-2468-4b97-b7e6-cd110c52fd1b', 'client', 'Emily', NULL, 'Johnson', 'Customer', 'emily.johnson12@example.com', '+14213434459', '$2y$12$1q3FNPIgmFlGo6tcIn/FT.2rvUxNAJW5.JlWJ/9Xq0bwTt8lMOxZS', NULL, 7, 'active', 1, NULL, NULL, '2026-02-06 20:37:25', '2026-02-06 20:37:25'),
	(65, 'b157042a-97a2-4a45-8aa6-3e2dd8b9c20a', 'client', 'John', NULL, 'Gonzalez', 'Customer', 'john.gonzalez13@example.com', '+15535239662', '$2y$12$1q3FNPIgmFlGo6tcIn/FT.2rvUxNAJW5.JlWJ/9Xq0bwTt8lMOxZS', NULL, 19, 'active', 1, NULL, NULL, '2026-02-06 20:37:25', '2026-02-06 20:37:25'),
	(66, '027a92d8-8c52-43c6-ba25-cf2e8c0b1adf', 'client', 'Sarah', NULL, 'Taylor', 'Customer', 'sarah.taylor14@example.com', '+15337632509', '$2y$12$1q3FNPIgmFlGo6tcIn/FT.2rvUxNAJW5.JlWJ/9Xq0bwTt8lMOxZS', NULL, 7, 'active', 1, NULL, NULL, '2026-02-06 20:37:25', '2026-02-06 20:37:25'),
	(67, 'f392f106-1cd4-4151-9d33-222b3a6d4d2f', 'client', 'Jennifer', 'O.', 'Robinson', 'Customer', 'jennifer.robinson15@example.com', '+15378129628', '$2y$12$1q3FNPIgmFlGo6tcIn/FT.2rvUxNAJW5.JlWJ/9Xq0bwTt8lMOxZS', NULL, 18, 'active', 1, NULL, NULL, '2026-02-06 20:37:25', '2026-02-06 20:37:25'),
	(68, '748bfd07-0618-412c-8c71-f38aac96c2df', 'client', 'Daniel', NULL, 'Hernandez', 'Customer', 'daniel.hernandez16@example.com', '+19872282772', '$2y$12$1q3FNPIgmFlGo6tcIn/FT.2rvUxNAJW5.JlWJ/9Xq0bwTt8lMOxZS', NULL, 18, 'active', 1, NULL, NULL, '2026-02-06 20:37:25', '2026-02-06 20:37:25'),
	(69, 'ffaa058c-db7b-4ed8-81d8-a2f6d8949ec2', 'client', 'Nancy', NULL, 'Clark', 'Customer', 'nancy.clark17@example.com', '+17196323998', '$2y$12$1q3FNPIgmFlGo6tcIn/FT.2rvUxNAJW5.JlWJ/9Xq0bwTt8lMOxZS', NULL, 2, 'active', 1, NULL, NULL, '2026-02-06 20:37:25', '2026-02-06 20:37:25'),
	(70, '06a1a95a-cc44-41fc-ad50-cacfffc7396e', 'client', 'Richard', 'W.', 'Brown', 'Customer', 'richard.brown18@example.com', '+18402319037', '$2y$12$1q3FNPIgmFlGo6tcIn/FT.2rvUxNAJW5.JlWJ/9Xq0bwTt8lMOxZS', NULL, 18, 'active', 1, NULL, NULL, '2026-02-06 20:37:25', '2026-02-06 20:37:25'),
	(71, '3e649cda-7c08-4999-b6c6-dfede9cf46dd', 'client', 'Susan', 'Z.', 'Clark', 'Customer', 'susan.clark19@example.com', '+19955268580', '$2y$12$1q3FNPIgmFlGo6tcIn/FT.2rvUxNAJW5.JlWJ/9Xq0bwTt8lMOxZS', NULL, 6, 'active', 1, NULL, NULL, '2026-02-06 20:37:25', '2026-02-06 20:37:25'),
	(72, '670f859c-d217-4e84-92bb-893f980323d3', 'client', 'Emily', NULL, 'Moore', 'Customer', 'emily.moore20@example.com', '+18921822828', '$2y$12$1q3FNPIgmFlGo6tcIn/FT.2rvUxNAJW5.JlWJ/9Xq0bwTt8lMOxZS', NULL, 18, 'active', 1, NULL, NULL, '2026-02-06 20:37:25', '2026-02-06 20:37:25'),
	(73, '21bdcb15-bfec-4a96-aa94-5dc5b7af56dd', 'client', 'Joseph', NULL, 'Rodriguez', 'Customer', 'joseph.rodriguez21@example.com', '+13915917023', '$2y$12$1q3FNPIgmFlGo6tcIn/FT.2rvUxNAJW5.JlWJ/9Xq0bwTt8lMOxZS', NULL, 21, 'active', 1, NULL, NULL, '2026-02-06 20:37:25', '2026-02-06 20:37:25'),
	(74, '0ff7b4b9-9ace-4dd2-a775-b86265396bde', 'client', 'Maria', NULL, 'Martin', 'Customer', 'maria.martin22@example.com', '+14851716846', '$2y$12$1q3FNPIgmFlGo6tcIn/FT.2rvUxNAJW5.JlWJ/9Xq0bwTt8lMOxZS', NULL, 6, 'active', 1, NULL, NULL, '2026-02-06 20:37:25', '2026-02-06 20:37:25'),
	(75, '0211b56e-c69f-4eba-b25d-a5d2dfffe683', 'client', 'Karen', NULL, 'Jackson', 'Customer', 'karen.jackson23@example.com', '+18027527718', '$2y$12$1q3FNPIgmFlGo6tcIn/FT.2rvUxNAJW5.JlWJ/9Xq0bwTt8lMOxZS', NULL, 7, 'active', 1, NULL, NULL, '2026-02-06 20:37:25', '2026-02-06 20:37:25'),
	(76, '4fb36382-cd4a-4ff7-8a30-d97791173268', 'client', 'Sarah', 'P.', 'Rodriguez', 'Customer', 'sarah.rodriguez24@example.com', '+18941852604', '$2y$12$1q3FNPIgmFlGo6tcIn/FT.2rvUxNAJW5.JlWJ/9Xq0bwTt8lMOxZS', NULL, 2, 'active', 1, NULL, NULL, '2026-02-06 20:37:25', '2026-02-06 20:37:25'),
	(77, '85e92cc6-3c24-449b-9ce9-dc8f858b10af', 'client', 'Richard', 'E.', 'Sanchez', 'Customer', 'richard.sanchez25@example.com', '+13535151667', '$2y$12$1q3FNPIgmFlGo6tcIn/FT.2rvUxNAJW5.JlWJ/9Xq0bwTt8lMOxZS', NULL, 1, 'active', 1, NULL, NULL, '2026-02-06 20:37:25', '2026-02-06 20:37:25'),
	(78, '44c0784a-6a11-44fa-922e-27970ef814e8', 'client', 'Matthew', NULL, 'Thompson', 'Customer', 'matthew.thompson26@example.com', '+12858053882', '$2y$12$1q3FNPIgmFlGo6tcIn/FT.2rvUxNAJW5.JlWJ/9Xq0bwTt8lMOxZS', NULL, 18, 'active', 1, NULL, NULL, '2026-02-06 20:37:25', '2026-02-06 20:37:25'),
	(79, 'fa96b929-a0d3-462b-8028-c01f66ae5ef6', 'client', 'Anthony', NULL, 'Harris', 'Customer', 'anthony.harris27@example.com', '+15186578444', '$2y$12$1q3FNPIgmFlGo6tcIn/FT.2rvUxNAJW5.JlWJ/9Xq0bwTt8lMOxZS', NULL, 21, 'active', 1, NULL, NULL, '2026-02-06 20:37:25', '2026-02-06 20:37:25'),
	(80, '9d326391-1e37-4392-b5d1-5a3a017af1e8', 'client', 'Betty', 'L.', 'Clark', 'Customer', 'betty.clark28@example.com', '+12146441690', '$2y$12$1q3FNPIgmFlGo6tcIn/FT.2rvUxNAJW5.JlWJ/9Xq0bwTt8lMOxZS', NULL, 18, 'active', 1, NULL, NULL, '2026-02-06 20:37:25', '2026-02-06 20:37:25'),
	(81, '374401b1-8eaa-4d5a-9656-745858d5bf38', 'client', 'Maria', 'W.', 'Perez', 'Customer', 'maria.perez29@example.com', '+19011435631', '$2y$12$1q3FNPIgmFlGo6tcIn/FT.2rvUxNAJW5.JlWJ/9Xq0bwTt8lMOxZS', NULL, 1, 'active', 1, NULL, NULL, '2026-02-06 20:37:25', '2026-02-06 20:37:25'),
	(82, '5da0b71e-0cf8-4e86-9838-95dcecbfa83e', 'client', 'Mark', 'W.', 'Thomas', 'Customer', 'mark.thomas30@example.com', '+12655981727', '$2y$12$1q3FNPIgmFlGo6tcIn/FT.2rvUxNAJW5.JlWJ/9Xq0bwTt8lMOxZS', NULL, 6, 'active', 1, NULL, NULL, '2026-02-06 20:37:25', '2026-02-06 20:37:25'),
	(83, 'c289d457-7606-4677-a2bb-f28acdc341f3', 'studio-photographer', 'Isaiah', 'Yoko Johnson', 'Stephenson', 'Photographer', 'desucyle@mailinator.com', '+(63)819 231 2312', '$2y$12$UkrnIE6tnVQeyXJmsL9GZ.kcjSLq1eLX6OK9.a0PSdnc5tKK8K1cy', 'profile_1770879389.png', NULL, 'active', 1, NULL, NULL, '2026-02-11 22:56:30', '2026-02-11 22:56:30'),
	(84, '4bfea5fc-d1c4-4b1f-bbf1-5b7a208385c5', 'studio-photographer', 'Daniel', 'Reyes', 'Cruz', 'Photographer', 'daniel.cruz@pixelframecreative.com', '+(63)917 845 3291', '$2y$12$LQHBYdmMYxaCySfBEUf6lOSRYVFWuPqIieDOjHTwgqj8LNeKna04K', 'profile_1770996210.png', NULL, 'active', 1, NULL, NULL, '2026-02-13 07:23:32', '2026-02-13 07:23:32');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
