-- LaundryGue Database Backup
-- Generated on 2026-11-05 17:08:40

SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `expenses`;
CREATE TABLE `expenses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `item_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(12,2) NOT NULL,
  `total_price` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` varchar(255) NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` smallint(5) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `landing_media`;
CREATE TABLE `landing_media` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL,
  `original_name` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `file_size` bigint(20) unsigned NOT NULL DEFAULT 0,
  `mime_type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `landing_media` (`id`, `filename`, `original_name`, `path`, `file_size`, `mime_type`, `created_at`, `updated_at`) VALUES ('1', 'hero-bg.jpg', 'Foto Hero Mesin Cuci Laundry (Default)', 'img/hero/hero-bg.jpg', '657678', 'image/jpeg', '2026-11-05 04:37:27', '2026-11-05 04:37:27');
INSERT INTO `landing_media` (`id`, `filename`, `original_name`, `path`, `file_size`, `mime_type`, `created_at`, `updated_at`) VALUES ('2', 'promo-bg.jpg', 'Foto Promo Background (Default)', 'img/backgrounds/promo-bg.jpg', '532897', 'image/jpeg', '2026-11-05 04:37:27', '2026-11-05 04:37:27');
INSERT INTO `landing_media` (`id`, `filename`, `original_name`, `path`, `file_size`, `mime_type`, `created_at`, `updated_at`) VALUES ('3', 'mesin-cuci.jpg', 'Mesin Cuci Industri (Default)', 'img/gallery/mesin-cuci.jpg', '95995', 'image/jpeg', '2026-11-05 04:37:27', '2026-11-05 04:37:27');
INSERT INTO `landing_media` (`id`, `filename`, `original_name`, `path`, `file_size`, `mime_type`, `created_at`, `updated_at`) VALUES ('4', 'setrika.jpg', 'Setrika Uap Presisi (Default)', 'img/gallery/setrika.jpg', '41690', 'image/jpeg', '2026-11-05 04:37:27', '2026-11-05 04:37:27');
INSERT INTO `landing_media` (`id`, `filename`, `original_name`, `path`, `file_size`, `mime_type`, `created_at`, `updated_at`) VALUES ('5', 'pakaian-rapi.jpg', 'Pakaian Rapi Lipatan Higienis (Default)', 'img/gallery/pakaian-rapi.jpg', '65558', 'image/jpeg', '2026-11-05 04:37:27', '2026-11-05 04:37:27');
INSERT INTO `landing_media` (`id`, `filename`, `original_name`, `path`, `file_size`, `mime_type`, `created_at`, `updated_at`) VALUES ('6', 'tekstil.jpg', 'Perawatan Serat Tekstil (Default)', 'img/gallery/tekstil.jpg', '85851', 'image/jpeg', '2026-11-05 04:37:27', '2026-11-05 04:37:27');
INSERT INTO `landing_media` (`id`, `filename`, `original_name`, `path`, `file_size`, `mime_type`, `created_at`, `updated_at`) VALUES ('7', 'contact-bg.jpg', 'Background Kontak CS (Default)', 'img/backgrounds/contact-bg.jpg', '116748', 'image/jpeg', '2026-11-05 04:37:27', '2026-11-05 04:37:27');
INSERT INTO `landing_media` (`id`, `filename`, `original_name`, `path`, `file_size`, `mime_type`, `created_at`, `updated_at`) VALUES ('8', 'calculator-bg.jpg', 'Background Kalkulator (Default)', 'img/backgrounds/calculator-bg.jpg', '184086', 'image/jpeg', '2026-11-05 04:37:27', '2026-11-05 04:37:27');
INSERT INTO `landing_media` (`id`, `filename`, `original_name`, `path`, `file_size`, `mime_type`, `created_at`, `updated_at`) VALUES ('9', 'logo.png', 'Logo LaundryGue (Default)', 'img/logo.png', '153883', 'image/png', '2026-11-05 04:37:27', '2026-11-05 04:37:27');

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('1', '0001_01_01_000000_create_users_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('2', '0001_01_01_000001_create_cache_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('3', '0001_01_01_000002_create_jobs_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('4', '2026_08_19_050933_create_transactions_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('5', '2026_08_19_050934_create_promos_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('6', '2026_08_19_050935_create_testimonials_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('7', '2026_08_19_052159_create_services_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('8', '2026_08_19_052352_create_transaction_details_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('9', '2026_08_19_074422_add_role_and_soft_delete_to_users_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('10', '2026_08_19_080222_add_phone_to_users_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('11', '2026_08_19_081532_create_expenses_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('12', '2026_08_26_170037_create_settings_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('13', '2026_10_21_182356_create_testimonial_tokens_table', '2');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('14', '2026_11_05_042412_create_landing_media_table', '3');

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `promos`;
CREATE TABLE `promos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `type` enum('percentage','fixed') NOT NULL DEFAULT 'percentage',
  `value` decimal(12,2) NOT NULL,
  `description` text NOT NULL,
  `expired_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `promos_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `promos` (`id`, `title`, `code`, `type`, `value`, `description`, `expired_date`, `created_at`, `updated_at`) VALUES ('1', 'Diskon Merdeka Laundry', 'MERDEKA50', 'percentage', '50.00', 'Nikmati potongan harga spesial untuk minimal transaksi 5kg.', '2026-08-31', '2026-08-26 18:08:22', '2026-08-26 18:08:22');
INSERT INTO `promos` (`id`, `title`, `code`, `type`, `value`, `description`, `expired_date`, `created_at`, `updated_at`) VALUES ('2', 'Promo Member Baru', 'WELCOME10', 'percentage', '10.00', 'Khusus pendaftaran member baru di outlet atau via WhatsApp.', '2026-12-31', '2026-08-26 18:08:22', '2026-08-26 18:08:22');
INSERT INTO `promos` (`id`, `title`, `code`, `type`, `value`, `description`, `expired_date`, `created_at`, `updated_at`) VALUES ('3', 'hohihio', 'ipjpjpo', 'percentage', '90.00', '98098', '2026-10-20', '2026-10-21 17:19:45', '2026-10-21 17:19:45');

DROP TABLE IF EXISTS `services`;
CREATE TABLE `services` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `duration` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `services` (`id`, `name`, `category`, `duration`, `price`, `unit`, `created_at`, `updated_at`) VALUES ('1', 'Cuci Sertrika Wangi (2 Hari)', 'Laundry Baju', '2 Hari', '7000', 'Kg', '2026-08-26 18:08:22', '2026-08-26 18:08:22');
INSERT INTO `services` (`id`, `name`, `category`, `duration`, `price`, `unit`, `created_at`, `updated_at`) VALUES ('2', 'Cuci Sertrika Wangi (1 Hari)', 'Laundry Baju', '1 Hari', '10000', 'Kg', '2026-08-26 18:08:22', '2026-08-26 18:08:22');
INSERT INTO `services` (`id`, `name`, `category`, `duration`, `price`, `unit`, `created_at`, `updated_at`) VALUES ('3', 'Cuci Sertrika Wangi (6 Jam)', 'Laundry Baju', '6 Jam', '12000', 'Kg', '2026-08-26 18:08:22', '2026-08-26 18:08:22');
INSERT INTO `services` (`id`, `name`, `category`, `duration`, `price`, `unit`, `created_at`, `updated_at`) VALUES ('4', 'Sertrika Wangi (2 Hari)', 'Laundry Baju', '2 Hari', '5000', 'Kg', '2026-08-26 18:08:22', '2026-08-26 18:08:22');
INSERT INTO `services` (`id`, `name`, `category`, `duration`, `price`, `unit`, `created_at`, `updated_at`) VALUES ('5', 'Sertrika Wangi (1 Hari)', 'Laundry Baju', '1 Hari', '7000', 'Kg', '2026-08-26 18:08:22', '2026-08-26 18:08:22');
INSERT INTO `services` (`id`, `name`, `category`, `duration`, `price`, `unit`, `created_at`, `updated_at`) VALUES ('6', 'Sertrika Wangi (6 Jam)', 'Laundry Baju', '6 Jam', '9000', 'Kg', '2026-08-26 18:08:22', '2026-08-26 18:08:22');
INSERT INTO `services` (`id`, `name`, `category`, `duration`, `price`, `unit`, `created_at`, `updated_at`) VALUES ('7', 'Cuci Lipat Wangi (1 Hari)', 'Laundry Baju', '1 Hari', '5000', 'Kg', '2026-08-26 18:08:22', '2026-08-26 18:08:22');
INSERT INTO `services` (`id`, `name`, `category`, `duration`, `price`, `unit`, `created_at`, `updated_at`) VALUES ('8', 'Deep Clean (3 - 4 Hari)', 'Laundry Sepatu', '3 - 4 Hari', '35000', 'Psg', '2026-08-26 18:08:22', '2026-08-26 18:08:22');
INSERT INTO `services` (`id`, `name`, `category`, `duration`, `price`, `unit`, `created_at`, `updated_at`) VALUES ('9', 'Deep Clean (1 Hari)', 'Laundry Sepatu', '1 Hari', '45000', 'Psg', '2026-08-26 18:08:22', '2026-08-26 18:08:22');
INSERT INTO `services` (`id`, `name`, `category`, `duration`, `price`, `unit`, `created_at`, `updated_at`) VALUES ('10', 'Express Clean (45 Menit)', 'Laundry Sepatu', '45 Menit', '40000', 'Psg', '2026-08-26 18:08:22', '2026-08-26 18:08:22');
INSERT INTO `services` (`id`, `name`, `category`, `duration`, `price`, `unit`, `created_at`, `updated_at`) VALUES ('11', 'Bed Cover (Kecil)', 'Laundry Bedding', '3 Hari', '25000', 'Pcs', '2026-08-26 18:08:22', '2026-08-26 18:08:22');
INSERT INTO `services` (`id`, `name`, `category`, `duration`, `price`, `unit`, `created_at`, `updated_at`) VALUES ('12', 'Bed Cover (Medium)', 'Laundry Bedding', '3 Hari', '30000', 'Pcs', '2026-08-26 18:08:22', '2026-08-26 18:08:22');
INSERT INTO `services` (`id`, `name`, `category`, `duration`, `price`, `unit`, `created_at`, `updated_at`) VALUES ('13', 'Bed Cover (Besar)', 'Laundry Bedding', '3 Hari', '35000', 'Pcs', '2026-08-26 18:08:22', '2026-08-26 18:08:22');
INSERT INTO `services` (`id`, `name`, `category`, `duration`, `price`, `unit`, `created_at`, `updated_at`) VALUES ('14', 'Selimut (Kecil)', 'Laundry Bedding', '3 Hari', '20000', 'Pcs', '2026-08-26 18:08:22', '2026-08-26 18:08:22');
INSERT INTO `services` (`id`, `name`, `category`, `duration`, `price`, `unit`, `created_at`, `updated_at`) VALUES ('15', 'Selimut (Medium)', 'Laundry Bedding', '3 Hari', '25000', 'Pcs', '2026-08-26 18:08:22', '2026-08-26 18:08:22');
INSERT INTO `services` (`id`, `name`, `category`, `duration`, `price`, `unit`, `created_at`, `updated_at`) VALUES ('16', 'Selimut (Besar)', 'Laundry Bedding', '3 Hari', '30000', 'Pcs', '2026-08-26 18:08:22', '2026-08-26 18:08:22');
INSERT INTO `services` (`id`, `name`, `category`, `duration`, `price`, `unit`, `created_at`, `updated_at`) VALUES ('17', 'Karpet & Surpet (5 - 7 Hari)', 'Furnishing Laundry', '5 - 7 Hari', '15000', 'm²', '2026-08-26 18:08:22', '2026-08-26 18:08:22');
INSERT INTO `services` (`id`, `name`, `category`, `duration`, `price`, `unit`, `created_at`, `updated_at`) VALUES ('18', 'Gorden (3 Hari)', 'Furnishing Laundry', '3 Hari', '13000', 'm²', '2026-08-26 18:08:22', '2026-08-26 18:08:22');

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('hz8GD415k1P7YXAyzgJQoWF04HVWGAfsUAm0kIcC', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.1 Safari/605.1.15', 'eyJfdG9rZW4iOiIxWGJlYWxqWmxGaUpPNmloWXByVFFPTzZITzJIaVJkakFPajc3S3RSIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2xvZ2luIiwicm91dGUiOiJsb2dpbiJ9LCJ1cmwiOnsiaW50ZW5kZWQiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYWRtaW5cL3RyYW5zYWN0aW9uc1wvY3JlYXRlIn19', '1793897325');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('idoIX8nGzuQ7S1h6rKp0OEDCoylW6WsbwquiWSEl', '1', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.1 Safari/605.1.15', 'eyJfdG9rZW4iOiJFWGxjdDlGWFIzUHJtTTQ4Qm9GZGU4QXFoRzVIcVZPSjhaRkllb2t1IiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2FkbWluXC90cmFuc2FjdGlvbnNcL2NyZWF0ZSIsInJvdXRlIjoiYWRtaW4udHJhbnNhY3Rpb25zLmNyZWF0ZSJ9LCJ1cmwiOltdLCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6MX0=', '1793856975');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('Jzrp2YFoh8cm4B0G1UKYNZUZSRDvpU3DcWqbOvir', NULL, '127.0.0.1', 'Symfony', 'eyJfdG9rZW4iOiJGcjc1bTA2VXNhcU5HOWRWeTNldHNaTkhKeE1qSmNaMEU2UWpnNGhrIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', '1793897577');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('KKbNAw9ojI6VQdfw5fbc9Tuz7jJiioiez5Gh9UeL', NULL, '127.0.0.1', 'Symfony', 'eyJfdG9rZW4iOiJxYUZCOFQ2WUoySHNjbDIyVXplNVI5ZGpjTjBVdmJzVmd6VEVndlZ0IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvc2VtdWEtdGVzdGltb25pIiwicm91dGUiOiJmcm9udGVuZC50ZXN0aW1vbmlhbHMifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', '1793897566');

DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES ('1', 'whatsapp', '6281220295876', '2026-08-26 18:08:22', '2026-11-05 04:28:32');
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES ('2', 'address', 'Jl. Somawinata cidahu No.139, Tanimulya, Kec. Ngamprah, Kabupaten Bandung Barat', '2026-08-26 18:08:22', '2026-08-26 18:23:03');
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES ('3', 'operational_hours', 'Selasa - Minggu: 10.00 - 17.00 WIB', '2026-08-26 18:08:22', '2026-08-26 18:08:22');
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES ('4', 'enable_splash_screen', '0', '2026-11-02 04:11:53', '2026-11-05 04:47:26');
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES ('5', 'landing_hero_bg', 'img/hero/hero-bg.jpg', '2026-11-05 04:43:38', '2026-11-05 05:15:55');

DROP TABLE IF EXISTS `testimonial_tokens`;
CREATE TABLE `testimonial_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `token` varchar(64) NOT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(255) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `is_used` tinyint(1) NOT NULL DEFAULT 0,
  `used_at` timestamp NULL DEFAULT NULL,
  `testimonial_id` bigint(20) unsigned DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `testimonial_tokens_token_unique` (`token`),
  KEY `testimonial_tokens_testimonial_id_foreign` (`testimonial_id`),
  CONSTRAINT `testimonial_tokens_testimonial_id_foreign` FOREIGN KEY (`testimonial_id`) REFERENCES `testimonials` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `testimonial_tokens` (`id`, `token`, `customer_name`, `customer_phone`, `notes`, `is_used`, `used_at`, `testimonial_id`, `expires_at`, `created_at`, `updated_at`) VALUES ('1', 'FmYLuDeLKC8jV6ePrQ8dvsP3mlVh9S6s', NULL, NULL, NULL, '0', NULL, NULL, NULL, '2026-10-21 18:32:04', '2026-10-21 18:32:04');
INSERT INTO `testimonial_tokens` (`id`, `token`, `customer_name`, `customer_phone`, `notes`, `is_used`, `used_at`, `testimonial_id`, `expires_at`, `created_at`, `updated_at`) VALUES ('2', 'imh8CQkg0xUIBuLv4uf4CJKhu9TuIWOZ', 'Bu rina', '01230840242', 'INV-999', '0', NULL, NULL, NULL, '2026-10-21 18:32:54', '2026-10-21 18:32:54');
INSERT INTO `testimonial_tokens` (`id`, `token`, `customer_name`, `customer_phone`, `notes`, `is_used`, `used_at`, `testimonial_id`, `expires_at`, `created_at`, `updated_at`) VALUES ('3', 'VXra9a0oP6bTkIKe6OmdFGcgmxiTaYun', 'danldld', '20u42u024u2', 'Invoice #INV-20261021-801 (Baru)', '1', '2026-10-21 18:56:13', '5', NULL, '2026-10-21 18:55:44', '2026-10-21 18:56:13');

DROP TABLE IF EXISTS `testimonials`;
CREATE TABLE `testimonials` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'Pelanggan Setia',
  `message` text NOT NULL,
  `rating` int(11) NOT NULL DEFAULT 5,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `testimonials` (`id`, `name`, `role`, `message`, `rating`, `created_at`, `updated_at`) VALUES ('1', 'Budi Santoso', 'Warga Tanimulya', 'Cucian di sini sangat bersih, wangi, dan rapi banget lipatannya. Paling mantap karena ada layanan antar-jemput!', '5', '2026-08-26 18:08:22', '2026-08-26 18:08:22');
INSERT INTO `testimonials` (`id`, `name`, `role`, `message`, `rating`, `created_at`, `updated_at`) VALUES ('2', 'Siti Aminah', 'Ibu Rumah Tangga', 'Pelayanannya ramah dan cepat. Sangat membantu saya yang sibuk kerja jadi tidak sempat cuci baju sendiri.', '5', '2026-08-26 18:08:22', '2026-08-26 18:08:22');
INSERT INTO `testimonials` (`id`, `name`, `role`, `message`, `rating`, `created_at`, `updated_at`) VALUES ('3', 'Rian Hidayat', 'Karyawan Swasta', 'Jas kantor dan pakaian formal saya selalu cuci di sini. Hasilnya tidak pernah mengecewakan, rapi dan tidak merusak kain.', '5', '2026-08-26 18:08:22', '2026-08-26 18:08:22');
INSERT INTO `testimonials` (`id`, `name`, `role`, `message`, `rating`, `created_at`, `updated_at`) VALUES ('4', 'rian', 'mahasiswa', 'sangat keren', '5', '2026-10-21 18:15:28', '2026-10-21 18:15:28');
INSERT INTO `testimonials` (`id`, `name`, `role`, `message`, `rating`, `created_at`, `updated_at`) VALUES ('5', 'danldld', 'Pelanggan Setia', 'Pelayanannya baik', '5', '2026-10-21 18:56:13', '2026-10-21 18:56:13');

DROP TABLE IF EXISTS `transaction_details`;
CREATE TABLE `transaction_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `transaction_id` bigint(20) unsigned NOT NULL,
  `service_id` bigint(20) unsigned NOT NULL,
  `quantity` double NOT NULL,
  `subtotal` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transaction_details_transaction_id_foreign` (`transaction_id`),
  KEY `transaction_details_service_id_foreign` (`service_id`),
  CONSTRAINT `transaction_details_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  CONSTRAINT `transaction_details_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `transaction_details` (`id`, `transaction_id`, `service_id`, `quantity`, `subtotal`, `created_at`, `updated_at`) VALUES ('2', '2', '2', '2', '20000', '2026-10-21 00:00:00', '2026-10-21 00:00:00');
INSERT INTO `transaction_details` (`id`, `transaction_id`, `service_id`, `quantity`, `subtotal`, `created_at`, `updated_at`) VALUES ('3', '3', '12', '5', '150000', '2026-10-21 00:00:00', '2026-10-21 00:00:00');
INSERT INTO `transaction_details` (`id`, `transaction_id`, `service_id`, `quantity`, `subtotal`, `created_at`, `updated_at`) VALUES ('4', '4', '7', '1', '5000', '2026-10-21 00:00:00', '2026-10-21 00:00:00');
INSERT INTO `transaction_details` (`id`, `transaction_id`, `service_id`, `quantity`, `subtotal`, `created_at`, `updated_at`) VALUES ('5', '5', '1', '2', '14000', '2026-10-21 00:00:00', '2026-10-21 00:00:00');
INSERT INTO `transaction_details` (`id`, `transaction_id`, `service_id`, `quantity`, `subtotal`, `created_at`, `updated_at`) VALUES ('6', '6', '2', '10', '90000', '2026-10-21 16:05:06', '2026-10-21 16:05:06');
INSERT INTO `transaction_details` (`id`, `transaction_id`, `service_id`, `quantity`, `subtotal`, `created_at`, `updated_at`) VALUES ('7', '7', '3', '1', '12000', '2026-10-21 16:54:26', '2026-10-21 16:54:26');
INSERT INTO `transaction_details` (`id`, `transaction_id`, `service_id`, `quantity`, `subtotal`, `created_at`, `updated_at`) VALUES ('8', '8', '3', '10', '120000', '2026-10-21 17:11:46', '2026-10-21 17:11:46');

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE `transactions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `invoice_code` varchar(255) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_phone` varchar(255) NOT NULL,
  `total_price` decimal(12,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Baru',
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transactions_user_id_foreign` (`user_id`),
  CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `transactions` (`id`, `invoice_code`, `customer_name`, `customer_phone`, `total_price`, `status`, `user_id`, `created_at`, `updated_at`) VALUES ('2', 'INV-20261021-444', 'andi', '43242324', '20000.00', 'Diambil', '1', '2026-10-21 00:00:00', '2026-10-21 00:00:00');
INSERT INTO `transactions` (`id`, `invoice_code`, `customer_name`, `customer_phone`, `total_price`, `status`, `user_id`, `created_at`, `updated_at`) VALUES ('3', 'INV-20261021-381', 'upi', '423242', '150000.00', 'Diambil', '1', '2026-10-21 00:00:00', '2026-10-21 00:00:00');
INSERT INTO `transactions` (`id`, `invoice_code`, `customer_name`, `customer_phone`, `total_price`, `status`, `user_id`, `created_at`, `updated_at`) VALUES ('4', 'INV-20261021-973', 'ali', '42342', '5000.00', 'Diambil', '1', '2026-10-21 00:00:00', '2026-10-21 00:00:00');
INSERT INTO `transactions` (`id`, `invoice_code`, `customer_name`, `customer_phone`, `total_price`, `status`, `user_id`, `created_at`, `updated_at`) VALUES ('5', 'INV-20261021-129', 'moses', '42343242', '14000.00', 'Diambil', '1', '2026-10-21 00:00:00', '2026-10-21 00:00:00');
INSERT INTO `transactions` (`id`, `invoice_code`, `customer_name`, `customer_phone`, `total_price`, `status`, `user_id`, `created_at`, `updated_at`) VALUES ('6', 'INV-20261021-723', 'Siska', '081237481', '90000.00', 'Baru', '2', '2026-10-21 16:05:06', '2026-10-21 16:37:59');
INSERT INTO `transactions` (`id`, `invoice_code`, `customer_name`, `customer_phone`, `total_price`, `status`, `user_id`, `created_at`, `updated_at`) VALUES ('7', 'INV-20261021-443', 'kgkj', 'yyy9y880', '12000.00', 'Baru', '1', '2026-10-21 16:54:26', '2026-10-21 16:54:26');
INSERT INTO `transactions` (`id`, `invoice_code`, `customer_name`, `customer_phone`, `total_price`, `status`, `user_id`, `created_at`, `updated_at`) VALUES ('8', 'INV-20261021-801', 'danldld', '20u42u024u2', '120000.00', 'Selesai', '1', '2026-10-21 17:11:46', '2026-10-26 13:31:24');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'kasir',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES ('1', 'Admin Laundry', 'admin1@gmail.com', NULL, 'admin', NULL, '$2y$12$oLZlapNcpeEK9/gPZ3bY3uJaYhARJhU2pmINAghYukYxvyEqnkdu.', NULL, '2026-08-26 18:08:22', '2026-08-26 18:08:22', NULL);
INSERT INTO `users` (`id`, `name`, `email`, `phone`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES ('2', 'Kasir Laundry', 'kasir1@gmail.com', NULL, 'kasir', NULL, '$2y$12$h9dWKkASPosn/TH6s4.N/OZD2cLMdp/fZjIauPYmHAGZ6HyXXQbWC', NULL, '2026-08-26 18:08:22', '2026-08-26 18:08:22', NULL);

SET FOREIGN_KEY_CHECKS=1;
