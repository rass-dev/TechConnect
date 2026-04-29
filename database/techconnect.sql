-- MySQL dump 10.13  Distrib 8.4.3, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: techconnect
-- ------------------------------------------------------
-- Server version	8.4.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `banners`
--

DROP TABLE IF EXISTS `banners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `banners` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `show_title` tinyint(1) DEFAULT '0',
  `show_description` tinyint(1) DEFAULT '0',
  `show_button` tinyint(1) DEFAULT '0',
  `button_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `banners_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banners`
--

LOCK TABLES `banners` WRITE;
/*!40000 ALTER TABLE `banners` DISABLE KEYS */;
INSERT INTO `banners` VALUES (5,'test3','test3','uploads/banners/1758263731.png',NULL,'active','2025-08-27 21:42:17','2025-09-19 06:35:31',0,0,0,NULL),(6,'test2','test2','uploads/banners/1758263688.png',NULL,'active','2025-08-27 21:54:04','2025-09-19 06:34:48',0,0,0,NULL),(7,'test1','test1','uploads/banners/1758263626.png',NULL,'active','2025-08-27 21:55:01','2025-09-19 06:33:46',0,0,0,NULL);
/*!40000 ALTER TABLE `banners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `brands` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `brands_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brands`
--

LOCK TABLES `brands` WRITE;
/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
INSERT INTO `brands` VALUES (8,'Dell','dell','active','2025-08-27 22:08:37','2025-08-27 22:08:37'),(9,'HP','hp','active','2025-08-27 22:08:43','2025-08-27 22:08:43'),(10,'Lenovo','lenovo','active','2025-08-27 22:08:51','2025-08-27 22:08:51'),(11,'ASUS','asus','active','2025-08-27 22:08:57','2025-08-27 22:08:57'),(12,'Acer','acer','active','2025-08-27 22:09:05','2025-08-27 22:09:05'),(13,'A4Tech','a4tech','active','2025-08-27 22:09:43','2025-08-27 22:09:43'),(14,'Gigahertz','gigahertz','active','2025-08-27 22:45:02','2025-08-27 22:45:02');
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carts`
--

DROP TABLE IF EXISTS `carts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `order_id` bigint unsigned DEFAULT NULL,
  `shipping_id` bigint unsigned DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `price` double(8,2) NOT NULL,
  `status` enum('new','progress','delivered','cancel') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `quantity` int NOT NULL DEFAULT '1',
  `amount` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_checked` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `carts_product_id_foreign` (`product_id`),
  KEY `carts_user_id_foreign` (`user_id`),
  KEY `carts_order_id_foreign` (`order_id`),
  CONSTRAINT `carts_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL,
  CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carts`
--

LOCK TABLES `carts` WRITE;
/*!40000 ALTER TABLE `carts` DISABLE KEYS */;
INSERT INTO `carts` VALUES (20,26,11,3,42,22499.10,'progress',1,22499.10,'2025-09-18 21:28:57','2025-09-18 21:29:12',1),(21,27,12,3,43,3676.00,'new',1,3676.00,'2025-09-18 21:41:39','2025-09-18 21:47:53',1),(22,25,NULL,NULL,42,19934.10,'new',1,19934.10,'2025-09-19 00:06:29','2025-09-19 00:06:29',1),(23,26,NULL,NULL,43,22499.10,'new',1,22499.10,'2025-09-19 06:59:23','2025-09-19 06:59:23',1),(24,27,NULL,NULL,45,3676.00,'new',1,3676.00,'2025-09-19 08:59:15','2025-09-19 08:59:15',1);
/*!40000 ALTER TABLE `carts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `summary` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `photo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_parent` tinyint(1) NOT NULL DEFAULT '1',
  `parent_id` bigint unsigned DEFAULT NULL,
  `added_by` bigint unsigned DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`),
  KEY `categories_parent_id_foreign` (`parent_id`),
  KEY `categories_added_by_foreign` (`added_by`),
  CONSTRAINT `categories_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (14,'Laptops','laptops',NULL,NULL,1,NULL,NULL,'active','2025-08-27 22:05:31','2025-08-27 22:05:31'),(15,'Desktops','desktops',NULL,NULL,1,NULL,NULL,'active','2025-08-27 22:05:37','2025-08-27 22:05:37'),(16,'Monitors','monitors',NULL,NULL,1,NULL,NULL,'active','2025-08-27 22:05:43','2025-08-27 22:05:43'),(17,'Keyboards','keyboards',NULL,NULL,1,NULL,NULL,'active','2025-08-27 22:05:53','2025-08-27 22:05:53'),(18,'Processors','processors',NULL,NULL,1,NULL,NULL,'active','2025-08-27 22:06:07','2025-08-27 22:06:07'),(19,'Headset','headset',NULL,NULL,1,NULL,NULL,'active','2025-08-27 22:06:31','2025-08-27 22:06:31'),(20,'Monitor','monitor',NULL,NULL,1,NULL,NULL,'active','2025-08-27 22:07:55','2025-08-27 22:07:55'),(22,'Mouse','mouse',NULL,NULL,1,NULL,NULL,'active','2025-08-28 10:25:37','2025-08-28 10:25:37');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coupons`
--

DROP TABLE IF EXISTS `coupons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `coupons` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('fixed','percent') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'fixed',
  `value` decimal(20,2) NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `coupons_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coupons`
--

LOCK TABLES `coupons` WRITE;
/*!40000 ALTER TABLE `coupons` DISABLE KEYS */;
INSERT INTO `coupons` VALUES (1,'freeCoupon1','fixed',200.00,'active','2025-08-29 00:56:21','2025-08-29 00:56:21');
/*!40000 ALTER TABLE `coupons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `messages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2020_07_10_021010_create_brands_table',1),(5,'2020_07_10_025334_create_banners_table',1),(6,'2020_07_10_112147_create_categories_table',1),(7,'2020_07_11_063857_create_products_table',1),(8,'2020_07_12_073132_create_post_categories_table',1),(9,'2020_07_12_073701_create_post_tags_table',1),(10,'2020_07_12_083638_create_posts_table',1),(11,'2020_07_13_151329_create_messages_table',1),(12,'2020_07_14_023748_create_shippings_table',1),(13,'2020_07_15_054356_create_orders_table',1),(14,'2020_07_15_102626_create_carts_table',1),(15,'2020_07_16_041623_create_notifications_table',1),(16,'2020_07_16_053240_create_coupons_table',1),(17,'2020_07_23_143757_create_wishlists_table',1),(18,'2020_07_24_074930_create_product_reviews_table',1),(19,'2020_07_24_131727_create_post_comments_table',1),(20,'2020_08_01_143408_create_settings_table',1),(21,'2025_08_10_000001_create_products_table',1),(22,'2025_08_10_000002_create_wishlists_table',1),(23,'2025_08_10_000003_create_product_reviews_table',1),(24,'2025_08_10_000004_create_users_table',1),(25,'2025_08_27_135747_add_show_fields_to_banners_table',1),(26,'2025_08_27_140405_add_visibility_columns_to_banners_table',1),(27,'2025_08_28_031539_add_address_to_users_table',1),(28,'2025_08_28_051950_add_show_columns_to_banners_table',1),(29,'2025_8_10_0000007_create_carts_table',1),(30,'2025_8_10_000005_create_banners_table',1),(31,'2025_8_10_000006_create_brands_table',1),(32,'2025_8_10_000008_create_categories_table',1),(41,'2025_08_28_061933_add_user_and_active_to_shippings_table',1),(42,'2025_08_28_100741_add_shipping_fee_to_shippings_table',1),(43,'2025_8_10_000009_create_coupons_table',2),(44,'2025_8_10_000010_create_failed_jobs_table',2),(45,'2025_8_10_000011_create_messages_table',2),(46,'2025_8_10_000012_create_notifications_table',2),(47,'2025_8_10_000013_create_orders_table',2),(48,'2025_8_10_000014_create_password_resets_table',2),(49,'2025_8_10_000015_create_settings_table',2),(50,'2025_8_10_000016_create_shippings_table',1),(51,'2025_08_28_200723_add_name_to_orders_table',3),(52,'2025_08_28_201034_add_name_address_postcode_to_orders_table',4),(53,'2025_08_28_201539_add_price_to_shippings_table',5),(54,'2025_08_28_211210_add_shipping_id_to_carts_table',6),(55,'2025_08_28_211422_add_shipping_id_to_orders_table',7),(57,'2025_08_28_212304_drop_shippings_table',8);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint unsigned NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES ('24d283d2-9b0d-4963-be18-c6e636ad5a8d','App\\Notifications\\StatusNotification','App\\Models\\User',41,'{\"title\":\"New Product Rating!\",\"actionURL\":\"http:\\/\\/127.0.0.1:8000\\/product-detail\\/acer-predator-aethon-300-gaming-keyboard\",\"fas\":\"fa-star\"}',NULL,'2025-08-29 10:27:06','2025-08-29 10:27:06'),('38df47bf-0db1-4da6-ba39-cc644afba71e','App\\Notifications\\StatusNotification','App\\Models\\User',41,'{\"title\":\"New order created\",\"actionURL\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/order\\/1\",\"fas\":\"fa-file-alt\"}',NULL,'2025-08-28 12:13:51','2025-08-28 12:13:51'),('71fea6df-da38-44d7-9807-6635b39cd9d9','App\\Notifications\\StatusNotification','App\\Models\\User',43,'{\"title\":\"New order created\",\"actionURL\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/order\\/10\",\"fas\":\"fa-file-alt\"}','2025-09-18 21:27:31','2025-09-05 03:13:44','2025-09-18 21:27:31'),('72088186-a6d3-49cc-acf4-b805d36c91c4','App\\Notifications\\StatusNotification','App\\Models\\User',41,'{\"title\":\"New Product Rating!\",\"actionURL\":\"http:\\/\\/127.0.0.1:8000\\/product-detail\\/acer-predator-aethon-300-gaming-keyboard\",\"fas\":\"fa-star\"}',NULL,'2025-08-29 10:25:17','2025-08-29 10:25:17'),('7e862413-a46f-46a6-937b-27f9afd5900c','App\\Notifications\\StatusNotification','App\\Models\\User',41,'{\"title\":\"New Product Rating!\",\"actionURL\":\"http:\\/\\/127.0.0.1:8000\\/product-detail\\/asus-tuf-27-vg27vq-curved-gaming-monitor\",\"fas\":\"fa-star\"}',NULL,'2025-08-29 08:44:07','2025-08-29 08:44:07'),('a8a5d2c7-fb37-47a2-9c52-6085f55adfe4','App\\Notifications\\StatusNotification','App\\Models\\User',43,'{\"title\":\"New order created\",\"actionURL\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/order\\/11\",\"fas\":\"fa-file-alt\"}','2025-09-18 21:38:57','2025-09-18 21:29:14','2025-09-18 21:38:57'),('ea7b90bb-63a8-43ed-b3d7-50b22d4d0763','App\\Notifications\\StatusNotification','App\\Models\\User',43,'{\"title\":\"New order created\",\"actionURL\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/order\\/12\",\"fas\":\"fa-file-alt\"}',NULL,'2025-09-18 21:47:54','2025-09-18 21:47:54');
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_histories`
--

DROP TABLE IF EXISTS `order_histories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_histories` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int unsigned NOT NULL,
  `user_id` int unsigned DEFAULT NULL,
  `role` enum('admin','superadmin','user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `previous_status` enum('new','process','on_the_way','delivered','completed','cancel') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `new_status` enum('new','process','on_the_way','delivered','completed','cancel') COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `order_id_idx` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_histories`
--

LOCK TABLES `order_histories` WRITE;
/*!40000 ALTER TABLE `order_histories` DISABLE KEYS */;
INSERT INTO `order_histories` VALUES (1,9,43,'admin','completed','completed','Status changed from completed to completed by admin','2025-09-03 17:08:54','2025-09-03 17:08:54'),(2,9,43,'admin','completed','cancel','Status changed from completed to cancel by admin','2025-09-03 17:09:15','2025-09-03 17:09:15'),(3,11,42,'user','on_the_way','cancel','Order cancelled by User','2025-09-19 01:16:57','2025-09-19 01:16:57'),(4,11,43,'admin','cancel','delivered','Status changed from cancel to delivered by admin','2025-09-19 07:35:39','2025-09-19 07:35:39');
/*!40000 ALTER TABLE `order_histories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_total` double(8,2) NOT NULL,
  `shipping_id` bigint unsigned DEFAULT NULL,
  `coupon` double(8,2) DEFAULT NULL,
  `total_amount` double(8,2) NOT NULL,
  `quantity` int NOT NULL,
  `payment_method` enum('cod','paypal') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cod',
  `payment_status` enum('paid','unpaid') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `status` enum('new','process','on_the_way','delivered','completed','cancel') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_number_unique` (`order_number`),
  KEY `orders_user_id_foreign` (`user_id`),
  KEY `orders_shipping_id_foreign` (`shipping_id`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (11,'ORD-G8AF1KXHAT',42,'User',22499.10,3,0.00,22549.10,1,'cod','unpaid','on_the_way','user@gmail.com','09123456789','Congress Village, Rd 34','1421','2025-09-18 21:29:12','2025-09-19 07:35:39'),(12,'ORD-JUDC1PXBLX',43,'admin',3676.00,3,0.00,3726.00,1,'cod','unpaid','completed','admin@gmail.com','09123456789','Congress Village, Rd 34','1421','2025-09-18 21:47:53','2025-09-18 21:47:53');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_reviews`
--

DROP TABLE IF EXISTS `product_reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_reviews` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `product_id` bigint unsigned DEFAULT NULL,
  `rate` tinyint NOT NULL DEFAULT '0',
  `review` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_reviews_user_id_foreign` (`user_id`),
  KEY `product_reviews_product_id_foreign` (`product_id`),
  CONSTRAINT `product_reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL,
  CONSTRAINT `product_reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_reviews`
--

LOCK TABLES `product_reviews` WRITE;
/*!40000 ALTER TABLE `product_reviews` DISABLE KEYS */;
INSERT INTO `product_reviews` VALUES (21,42,23,5,'ASD','active','2025-08-29 08:44:06','2025-08-29 08:44:06'),(22,42,27,5,NULL,'active','2025-08-29 10:25:13','2025-08-29 10:25:13'),(23,42,27,5,'testing','active','2025-08-29 10:27:06','2025-08-29 10:27:06');
/*!40000 ALTER TABLE `product_reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `summary` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `photo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock` int NOT NULL DEFAULT '1',
  `size` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'M',
  `condition` enum('standard','new','hot') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'standard',
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive',
  `price` double(8,2) NOT NULL,
  `discount` double(8,2) NOT NULL,
  `is_featured` tinyint(1) NOT NULL,
  `cat_id` bigint unsigned DEFAULT NULL,
  `child_cat_id` bigint unsigned DEFAULT NULL,
  `brand_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`),
  KEY `products_brand_id_foreign` (`brand_id`),
  KEY `products_cat_id_foreign` (`cat_id`),
  KEY `products_child_cat_id_foreign` (`child_cat_id`),
  CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE SET NULL,
  CONSTRAINT `products_cat_id_foreign` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `products_child_cat_id_foreign` FOREIGN KEY (`child_cat_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (23,'Asus TUF 27\" VG27VQ Curved Gaming Monitor','asus-tuf-27-vg27vq-curved-gaming-monitor','<p>The <strong data-start=\"174\" data-end=\"200\">ASUS TUF Gaming VG27VQ</strong> is a 27-inch curved gaming monitor featuring a VA panel with Full HD (1920×1080) resolution, 165Hz refresh rate, and 1ms MPRT response time. Designed for immersive gameplay, it supports Adaptive-Sync (VRR), Extreme Low Motion Blur, and Shadow Boost technology. The monitor offers ergonomic adjustments including tilt, swivel, and height, along with multiple connectivity options such as DisplayPort, HDMI, and DVI. It also comes with built-in 2W stereo speakers and TÜV-certified Flicker-Free and Low Blue Light features for comfortable viewing.</p>','<p data-start=\"777\" data-end=\"1107\">Experience smooth, immersive gaming with the <strong data-start=\"822\" data-end=\"848\">ASUS TUF Gaming VG27VQ</strong>. Its <strong data-start=\"854\" data-end=\"887\">27-inch 1500R curved VA panel</strong> provides wide 178° viewing angles, 16.7M colors, and a high contrast ratio of 3000:1. With a <strong data-start=\"981\" data-end=\"1005\">1920×1080 resolution</strong>, <strong data-start=\"1007\" data-end=\"1029\">165Hz refresh rate</strong>, and <strong data-start=\"1035\" data-end=\"1061\">1ms MPRT response time</strong>, fast-paced action appears crisp and fluid.</p><p data-start=\"1109\" data-end=\"1423\">Advanced gaming features like <strong data-start=\"1139\" data-end=\"1171\">Adaptive-Sync VRR technology</strong>, <strong data-start=\"1173\" data-end=\"1200\">Extreme Low Motion Blur</strong>, <strong data-start=\"1202\" data-end=\"1214\">GamePlus</strong>, <strong data-start=\"1216\" data-end=\"1230\">GameVisual</strong>, and <strong data-start=\"1236\" data-end=\"1252\">Shadow Boost</strong> enhance gameplay performance and visual clarity. The monitor’s ergonomic design allows for tilt, swivel, and height adjustments, and it supports <strong data-start=\"1398\" data-end=\"1420\">VESA wall mounting</strong>.</p><p data-start=\"1425\" data-end=\"1681\">Connectivity options include <strong data-start=\"1454\" data-end=\"1473\">DisplayPort 1.2</strong>, <strong data-start=\"1475\" data-end=\"1487\">HDMI 2.0</strong>, <strong data-start=\"1489\" data-end=\"1496\">DVI</strong>, and audio jacks, while built-in <strong data-start=\"1530\" data-end=\"1545\">2W speakers</strong> provide basic sound. TÜV-certified <strong data-start=\"1581\" data-end=\"1597\">Flicker-Free</strong> and <strong data-start=\"1602\" data-end=\"1620\">Low Blue Light</strong> technologies reduce eye strain for longer gaming sessions.</p><p>\r\n\r\n\r\n</p><p data-start=\"1683\" data-end=\"1793\">This monitor is ideal for gamers seeking high performance, immersive visuals, and flexible ergonomic design.</p>','uploads/products/1756363005_asus-tuf-27-vg27vq-curved-gaming-monitor-asus-gigahertz-869983.jpg',200,'M','standard','active',13999.00,20.00,1,16,NULL,11,'2025-08-27 22:36:45','2025-08-27 22:36:45'),(24,'Acer Predator Galea 500 Gaming 3D Headset','acer-predator-galea-500-gaming-3d-headset','<p>The <strong data-start=\"154\" data-end=\"181\">Acer Predator Galea 500</strong> is a high-performance gaming headset designed for immersive experiences. Featuring <strong data-start=\"265\" data-end=\"287\">7.1 surround sound</strong>, customizable RGB lighting, and ergonomic comfort, it delivers precise audio for gaming on PC. Its flexible headband and soft ear cushions ensure long-lasting comfort during extended play sessions.</p>','<p><span style=\"color: rgb(22, 25, 27); font-family: customfont;\">The Acer Predator Galea 500 Gaming Headset is built for immersive gaming with its 7.1 surround sound and customizable RGB lighting. It features comfortable ear cushions and a flexible headband for extended gaming sessions.</span><br style=\"-webkit-font-smoothing: antialiased; color: rgb(22, 25, 27); font-family: customfont;\"><br style=\"-webkit-font-smoothing: antialiased; color: rgb(22, 25, 27); font-family: customfont;\"><span style=\"color: rgb(22, 25, 27); font-family: customfont;\">Dive into your games with lifelike audio and captivating effects. The Predator Galea 500 ensures you never miss a beat, enhancing your gaming experience with precision and style.</span></p>','uploads/products/1756363158_acer-predator-galea-500-gaming-headset-acer-headset-gigahertz-293857.jpg',200,'M','standard','active',13389.00,10.00,1,19,NULL,12,'2025-08-27 22:39:18','2025-08-27 22:39:18'),(25,'HP 14-dq2031tg 14\" FHD Laptop','hp-14-dq2031tg-14-fhd-laptop','<p>The <strong data-start=\"143\" data-end=\"161\">HP 14-dq2031tg</strong> is a compact 14-inch FHD laptop designed for everyday computing. Powered by an <strong data-start=\"241\" data-end=\"275\">Intel Core i3-1125G4 processor</strong> and <strong data-start=\"280\" data-end=\"297\">4 GB DDR4 RAM</strong>, it features a <strong data-start=\"313\" data-end=\"327\">128 GB SSD</strong> for fast storage and smooth performance. With <strong data-start=\"374\" data-end=\"407\">Intel UHD integrated graphics</strong>, Windows 11 Home, and a lightweight design, it’s ideal for productivity, browsing, and entertainment on the go.</p>','<p data-start=\"550\" data-end=\"791\">The <strong data-start=\"554\" data-end=\"579\">HP 14-dq2031tg Laptop</strong> delivers reliable performance in a sleek and portable package. Its <strong data-start=\"647\" data-end=\"678\">14-inch Full HD IPS display</strong> with anti-glare coating provides clear visuals and wide viewing angles, perfect for work, study, or streaming.</p><p data-start=\"793\" data-end=\"1087\">Under the hood, the laptop is powered by an <strong data-start=\"837\" data-end=\"871\">Intel Core i3-1125G4 processor</strong> (2.0 GHz base, up to 3.7 GHz with Turbo Boost) and <strong data-start=\"923\" data-end=\"940\">4 GB DDR4 RAM</strong>, paired with a <strong data-start=\"956\" data-end=\"970\">128 GB SSD</strong> for fast boot times and quick access to files. <strong data-start=\"1018\" data-end=\"1040\">Intel UHD Graphics</strong> handles everyday graphics tasks efficiently.</p><p>\r\n\r\n</p><p data-start=\"1089\" data-end=\"1471\">Connectivity is versatile, including <strong data-start=\"1126\" data-end=\"1158\">USB Type-C, USB Type-A, HDMI</strong>, Wi-Fi, and Bluetooth 4.2. Additional features include <strong data-start=\"1214\" data-end=\"1275\">HP True Vision 720p HD webcam with dual-array microphones</strong>, <strong data-start=\"1277\" data-end=\"1296\">stereo speakers</strong>, and a <strong data-start=\"1304\" data-end=\"1329\">3-cell, 41 Wh battery</strong> for mobile use. Running <strong data-start=\"1354\" data-end=\"1373\">Windows 11 Home</strong>, the HP 14-dq2031tg offers a modern, user-friendly interface in a lightweight, 3.24 lbs design.</p>','uploads/products/1756363332_HP15S-FQ5082TU.jpg',200,'M','new','active',24610.00,19.00,1,14,NULL,9,'2025-08-27 22:42:12','2025-08-27 22:42:12'),(26,'Giga Pro Desktop Intel® Core™ i3-8100 H310M-E','giga-pro-desktop-intel-core-i3-8100-h310m-e','<p>The <strong data-start=\"110\" data-end=\"130\">Giga Pro Desktop</strong> is a reliable entry-level desktop powered by an <strong data-start=\"179\" data-end=\"211\">Intel Core i3-8100 processor</strong>. Featuring <strong data-start=\"223\" data-end=\"235\">4 GB RAM</strong>, <strong data-start=\"237\" data-end=\"257\">1 TB HDD storage</strong>, and <strong data-start=\"263\" data-end=\"289\">Intel UHD Graphics 630</strong>, it is ideal for everyday computing tasks. Equipped with an <strong data-start=\"350\" data-end=\"384\">Asus Prime H310M-E motherboard</strong> and running <strong data-start=\"397\" data-end=\"423\">Windows 10 Home or Pro</strong>, it delivers dependable performance for work, study, and light multimedia use.</p>','<p data-start=\"533\" data-end=\"813\">The <strong data-start=\"537\" data-end=\"557\">Giga Pro Desktop</strong> combines performance and practicality in a compact package. Its <strong data-start=\"622\" data-end=\"654\">Intel Core i3-8100 processor</strong> ensures smooth multitasking, while <strong data-start=\"690\" data-end=\"705\">4 GB of RAM</strong> supports everyday applications. The <strong data-start=\"742\" data-end=\"754\">1 TB HDD</strong> offers ample storage for documents, media, and software.</p><p>\r\n</p><p data-start=\"815\" data-end=\"1142\">Integrated <strong data-start=\"826\" data-end=\"852\">Intel UHD Graphics 630</strong> handles basic graphics and multimedia tasks efficiently. The system is built on a reliable <strong data-start=\"944\" data-end=\"978\">Asus Prime H310M-E motherboard</strong> and can run either <strong data-start=\"998\" data-end=\"1017\">Windows 10 Home</strong> or <strong data-start=\"1021\" data-end=\"1039\">Windows 10 Pro</strong>. This desktop is perfect for students, home offices, and users seeking a cost-effective PC solution.</p>','uploads/products/1756363432_giga-gaming-desktop-9100f-h310m-e-gigahertz-gigahertz-966300.jpg',201,'M','new','active',24999.00,10.00,1,15,NULL,14,'2025-08-27 22:43:52','2025-09-19 01:16:57'),(27,'Acer Predator Aethon 300 Gaming Keyboard','acer-predator-aethon-300-gaming-keyboard','<p>The <strong data-start=\"138\" data-end=\"173\">Acer Predator Aethon 300 PKB910</strong> is a wired gaming keyboard featuring <strong data-start=\"211\" data-end=\"238\">Cherry MX Blue switches</strong> for tactile and responsive keystrokes. Designed for gamers, it offers <strong data-start=\"309\" data-end=\"331\">100% anti-ghosting</strong>, <strong data-start=\"333\" data-end=\"364\">10 dynamic lighting effects</strong>, braided USB cable, and durable build with 50 million key actuations. The keyboard is ideal for precise, high-speed gaming and long-lasting performance.</p>','<p data-start=\"548\" data-end=\"792\">Experience precision and speed with the <strong data-start=\"588\" data-end=\"639\">Acer Predator Aethon 300 PKB910 Gaming Keyboard</strong>. Equipped with <strong data-start=\"655\" data-end=\"682\">Cherry MX Blue switches</strong>, this keyboard delivers satisfying tactile feedback for accurate keystrokes, perfect for gaming and typing.</p><p data-start=\"794\" data-end=\"1097\">The keyboard supports <strong data-start=\"816\" data-end=\"838\">100% anti-ghosting</strong>, ensuring every keypress is registered even during intense gaming sessions. It features <strong data-start=\"927\" data-end=\"966\">single-color teal blue backlighting</strong> with <strong data-start=\"972\" data-end=\"1008\">10 customizable lighting effects</strong> including breathing, ripple, wave, and trigger effects for a visually immersive setup.</p><p>\r\n\r\n</p><p data-start=\"1099\" data-end=\"1380\">Built for durability, the keyboard boasts a <strong data-start=\"1143\" data-end=\"1176\">50 million key press lifespan</strong> and a <strong data-start=\"1183\" data-end=\"1210\">braided fiber USB cable</strong> with golden-plated connector for stable and reliable connectivity. Additional features include combo multimedia keys, Win key lock, Num Lock, and Caps Lock indicators.</p>','uploads/products/1756364250_acer-predator-aethon-300-gaming-keyboard-acer-keyboard-gigahertz-600791.png',200,'M','new','active',4595.00,20.00,1,17,NULL,12,'2025-08-27 22:57:30','2025-09-03 17:09:15'),(28,'test','test','<p>test</p>','<p>test</p>','uploads/products/1758278239_logo.png',197,'M','standard','active',200.00,5.00,1,14,NULL,8,'2025-09-19 10:37:19','2025-09-19 10:37:19');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shippings`
--

DROP TABLE IF EXISTS `shippings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shippings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shippings`
--

LOCK TABLES `shippings` WRITE;
/*!40000 ALTER TABLE `shippings` DISABLE KEYS */;
INSERT INTO `shippings` VALUES (3,'Standard',50.00,'2025-08-28 14:01:56','2025-08-28 14:01:56'),(4,'Express',120.00,'2025-08-28 14:01:56','2025-08-28 14:01:56');
/*!40000 ALTER TABLE `shippings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','user','superadmin') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `provider` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (41,'SuperAdmin','superadmin@gmail.com',NULL,NULL,NULL,NULL,'$2y$10$rcH35YVyKVAKDcwsvPRQ2.q2uBVRuEKDx1b8enka4JoKbUqPT2d.C','uploads/profile/1756428552_mountain 2.png','superadmin',NULL,NULL,'active',NULL,'2025-08-27 20:34:21','2025-09-01 08:05:59'),(42,'User','user@gmail.com','Congress Village, Rd 34','09123456789','1421',NULL,'$2y$10$5Iw25ztiU9DcmBUH66K89uTLy/NCJCxH/E8toKa7XJNSxKYc.WxZy',NULL,'user',NULL,NULL,'active',NULL,'2025-08-27 20:34:21','2025-08-28 11:17:32'),(43,'admin','admin@gmail.com','Congress Village, Rd 34','09123456789','1421',NULL,'$2y$10$Fn5eRMP2qkQDSA6oNAgXnOhrcqgQALRTgSYi6vrpROWWoxHMN84hG','uploads/users/1756713989.jpg','admin',NULL,NULL,'active',NULL,'2025-09-01 08:06:29','2025-09-18 21:41:58'),(44,'admin2','admin2@gmail.com',NULL,NULL,NULL,NULL,'$2y$10$kQAZ1UXsqf4N8HLCgJ.NLOh3lAWjvWpuA6rUrxh0u/EJT1arUxfC2','uploads/users/1756714171.jpg','user',NULL,NULL,'active',NULL,'2025-09-01 08:09:31','2025-09-01 08:09:31'),(45,'ras','user2@gmail.com',NULL,NULL,NULL,NULL,'$2y$10$h6eDQJYaD0VqkJOD0H.AquIKE8eeR42w5nifV8MqgqlkWOczgmhly',NULL,'user',NULL,NULL,'active',NULL,'2025-09-19 08:20:53','2025-09-19 08:20:53'),(46,'Usertest','user44@gmail.com',NULL,NULL,NULL,NULL,'$2y$10$QCBt3zb53jZ0EzN08omwG.0el.4K.6OrX9WaGHVQaHz90cWh5FPL2',NULL,'user',NULL,NULL,'active',NULL,'2025-09-19 09:53:57','2025-09-19 09:53:57');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wishlists`
--

DROP TABLE IF EXISTS `wishlists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wishlists` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `cart_id` bigint unsigned DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `price` double(8,2) NOT NULL,
  `quantity` int NOT NULL,
  `amount` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wishlists_product_id_foreign` (`product_id`),
  KEY `wishlists_user_id_foreign` (`user_id`),
  KEY `wishlists_cart_id_foreign` (`cart_id`),
  CONSTRAINT `wishlists_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE SET NULL,
  CONSTRAINT `wishlists_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wishlists`
--

LOCK TABLES `wishlists` WRITE;
/*!40000 ALTER TABLE `wishlists` DISABLE KEYS */;
INSERT INTO `wishlists` VALUES (3,26,NULL,45,22499.10,1,22499.10,'2025-09-19 08:59:22','2025-09-19 08:59:22');
/*!40000 ALTER TABLE `wishlists` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-10-06 17:14:04
