CREATE DATABASE  IF NOT EXISTS `capstone` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `capstone`;
-- MySQL dump 10.13  Distrib 5.7.12, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: capstone
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.21-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `accountant_notifications`
--

DROP TABLE IF EXISTS `accountant_notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accountant_notifications` (
  `an_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `notification_body` varchar(60) NOT NULL,
  `marked_as_read` tinyint(1) unsigned NOT NULL,
  `at_id` int(11) unsigned DEFAULT NULL,
  `admin_timestamp_id` int(11) unsigned DEFAULT NULL,
  `accountant_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`an_id`),
  KEY `accountant_notifications_admin_timestamp_id` (`admin_timestamp_id`),
  KEY `accountant_notifications_ct_id` (`at_id`),
  KEY `accountant_notifications_admin_accountant_id` (`accountant_id`),
  CONSTRAINT `accountant_notifications_admin_accountant_id` FOREIGN KEY (`accountant_id`) REFERENCES `accountants` (`accountant_id`),
  CONSTRAINT `accountant_notifications_admin_timestamp_id` FOREIGN KEY (`admin_timestamp_id`) REFERENCES `admin_timestamps` (`admin_timestamp_id`),
  CONSTRAINT `accountant_notifications_ct_id` FOREIGN KEY (`at_id`) REFERENCES `accountants_timestamps` (`at_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accountant_notifications`
--

LOCK TABLES `accountant_notifications` WRITE;
/*!40000 ALTER TABLE `accountant_notifications` DISABLE KEYS */;
INSERT INTO `accountant_notifications` VALUES (1,'A transaction from Jose Perez was assigned to you.',0,NULL,1,3),(2,'A transaction from Jose Perez was assigned to you.',0,NULL,2,4),(3,'A transaction from Jose Perez was assigned to you.',0,NULL,3,5),(4,'A transaction from Jose Perez was assigned to you.',0,NULL,4,6),(5,'A transaction from Jose Perez was assigned to you.',0,NULL,5,3),(6,'A transaction from Jose Perez was assigned to you.',0,NULL,6,3),(7,'A transaction from Jose Perez was assigned to you.',0,NULL,7,3),(8,'A transaction from Jose Perez was assigned to you.',0,NULL,8,3),(9,'A transaction from Jose Perez was assigned to you.',0,NULL,9,3),(10,'A transaction from Jose Perez was assigned to you.',0,NULL,10,3),(11,'A transaction from Jose Perez was assigned to you.',0,NULL,11,3),(12,'A transaction from Jose Perez was assigned to you.',0,NULL,12,3),(13,'A transaction from Jose Perez was assigned to you.',0,NULL,13,3),(14,'A transaction from Jose Perez was assigned to you.',0,NULL,14,3),(15,'A transaction from Jose Perez was assigned to you.',0,NULL,15,3),(16,'You assigned a transaction to yourself',0,15,NULL,4);
/*!40000 ALTER TABLE `accountant_notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `accountants`
--

DROP TABLE IF EXISTS `accountants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accountants` (
  `accountant_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `roles_id` int(10) unsigned NOT NULL,
  `user_info_id` char(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`accountant_id`),
  KEY `accountants_roles_id_foreign` (`roles_id`),
  KEY `accountants_user_info_id_foreign` (`user_info_id`),
  CONSTRAINT `accountants_roles_id_foreign` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`roles_id`),
  CONSTRAINT `accountants_user_info_id_foreign` FOREIGN KEY (`user_info_id`) REFERENCES `user_info` (`user_info_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accountants`
--

LOCK TABLES `accountants` WRITE;
/*!40000 ALTER TABLE `accountants` DISABLE KEYS */;
INSERT INTO `accountants` VALUES (3,2,'11'),(4,2,'7'),(5,2,'3'),(6,2,'12'),(7,4,'13');
/*!40000 ALTER TABLE `accountants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `accountants_timestamps`
--

DROP TABLE IF EXISTS `accountants_timestamps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accountants_timestamps` (
  `at_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `role` varchar(20) NOT NULL DEFAULT 'Accountant',
  `action` varchar(20) NOT NULL DEFAULT '',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `transaction_id` int(11) unsigned DEFAULT NULL,
  `accountant_id` int(11) unsigned DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`at_id`),
  KEY `transaction_FK` (`transaction_id`),
  KEY `researcher_FK` (`accountant_id`),
  CONSTRAINT `accountant_FK` FOREIGN KEY (`accountant_id`) REFERENCES `accountants` (`accountant_id`),
  CONSTRAINT `accountants_timestamps_ibfk_2` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`transaction_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accountants_timestamps`
--

LOCK TABLES `accountants_timestamps` WRITE;
/*!40000 ALTER TABLE `accountants_timestamps` DISABLE KEYS */;
INSERT INTO `accountants_timestamps` VALUES (4,'Accountant','approve','2017-04-13 17:27:36',2,3,'Joan Ortiz'),(5,'Accountant','Assigned Transaction','2017-04-23 23:00:45',6,3,'Joan Ortiz'),(12,'Accountant','Assigned Transaction','2017-04-24 21:42:04',7,3,'Joan Ortiz'),(13,'Accountant','Assigned Transaction','2017-05-02 18:59:07',7,3,'Joan Ortiz'),(15,'Accountant','Assigned Transaction','2017-05-08 22:23:35',5,4,'Bryan Matos'),(16,'Accountant','Approved Transaction','2017-05-08 22:23:51',5,4,'Bryan Matos');
/*!40000 ALTER TABLE `accountants_timestamps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_timestamps`
--

DROP TABLE IF EXISTS `admin_timestamps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_timestamps` (
  `admin_timestamp_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `role` varchar(20) NOT NULL DEFAULT 'Administrator',
  `action` varchar(20) NOT NULL DEFAULT '',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `transaction_id` int(11) unsigned DEFAULT NULL,
  `admin_id` int(11) unsigned DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`admin_timestamp_id`),
  KEY `admin_timestamps_transaction_id` (`transaction_id`),
  KEY `admin_timestamps_admin_id` (`admin_id`),
  CONSTRAINT `admin_timestamps_admin_id` FOREIGN KEY (`admin_id`) REFERENCES `administrators` (`admin_id`),
  CONSTRAINT `admin_timestamps_transaction_id` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`transaction_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_timestamps`
--

LOCK TABLES `admin_timestamps` WRITE;
/*!40000 ALTER TABLE `admin_timestamps` DISABLE KEYS */;
INSERT INTO `admin_timestamps` VALUES (1,'Administrator','Assigned Transaction','2017-05-02 18:52:56',13,1,'Carlos Ojeda'),(2,'Administrator','Assigned Transaction','2017-05-02 18:54:19',13,1,'Carlos Ojeda'),(3,'Administrator','Assigned Transaction','2017-05-02 18:54:24',13,1,'Carlos Ojeda'),(4,'Administrator','Assigned Transaction','2017-05-02 18:54:29',13,1,'Carlos Ojeda'),(5,'Administrator','Assigned Transaction','2017-05-02 18:54:35',13,1,'Carlos Ojeda'),(6,'Administrator','Assigned Transaction','2017-05-02 18:54:39',13,1,'Carlos Ojeda'),(7,'Administrator','Assigned Transaction','2017-05-02 18:54:40',13,1,'Carlos Ojeda'),(8,'Administrator','Assigned Transaction','2017-05-02 18:54:41',13,1,'Carlos Ojeda'),(9,'Administrator','Assigned Transaction','2017-05-02 18:54:41',13,1,'Carlos Ojeda'),(10,'Administrator','Assigned Transaction','2017-05-02 18:54:42',13,1,'Carlos Ojeda'),(11,'Administrator','Assigned Transaction','2017-05-02 18:54:44',13,1,'Carlos Ojeda'),(12,'Administrator','Assigned Transaction','2017-05-02 18:54:45',13,1,'Carlos Ojeda'),(13,'Administrator','Assigned Transaction','2017-05-02 18:54:46',13,1,'Carlos Ojeda'),(14,'Administrator','Assigned Transaction','2017-05-02 18:54:48',13,1,'Carlos Ojeda'),(15,'Administrator','Assigned Transaction','2017-05-02 18:54:50',13,1,'Carlos Ojeda');
/*!40000 ALTER TABLE `admin_timestamps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `administrators`
--

DROP TABLE IF EXISTS `administrators`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `administrators` (
  `admin_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `roles_id` int(10) unsigned NOT NULL,
  `user_info_id` varchar(255) NOT NULL,
  PRIMARY KEY (`admin_id`),
  KEY `administrators_roles_id` (`roles_id`),
  KEY `administrators_user_info_id` (`user_info_id`),
  CONSTRAINT `administrators_roles_id` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`roles_id`),
  CONSTRAINT `administrators_user_info_id` FOREIGN KEY (`user_info_id`) REFERENCES `user_info` (`user_info_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administrators`
--

LOCK TABLES `administrators` WRITE;
/*!40000 ALTER TABLE `administrators` DISABLE KEYS */;
INSERT INTO `administrators` VALUES (1,1,'13');
/*!40000 ALTER TABLE `administrators` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `comment_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `body_of_comment` varchar(255) CHARACTER SET utf8 NOT NULL,
  `transaction_id` int(10) unsigned NOT NULL,
  `accountant_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `comments_transaction_id_foreign` (`transaction_id`),
  KEY `comments_accountant_id_foreign` (`accountant_id`),
  CONSTRAINT `comments_accountant_id_foreign` FOREIGN KEY (`accountant_id`) REFERENCES `accountants` (`accountant_id`),
  CONSTRAINT `comments_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`transaction_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,'2017-03-02 04:00:00','2017-03-02 04:00:00','Not justified',2,3),(2,'2017-03-02 04:00:00','2017-03-02 04:00:00','Items cannot be approved',2,3),(3,'0000-00-00 00:00:00','0000-00-00 00:00:00','Hola',2,3);
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `credit_card`
--

DROP TABLE IF EXISTS `credit_card`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `credit_card` (
  `cc_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `credit_card_number` varchar(16) NOT NULL,
  `name_on_card` varchar(20) NOT NULL,
  `researcher_id` int(10) unsigned NOT NULL,
  `expiration_date` date NOT NULL,
  `is_active` tinyint(4) DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`cc_id`),
  KEY `credit_card_researcher_id_foreign` (`researcher_id`),
  CONSTRAINT `credit_card_researcher_id_foreign` FOREIGN KEY (`researcher_id`) REFERENCES `researchers` (`researcher_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `credit_card`
--

LOCK TABLES `credit_card` WRITE;
/*!40000 ALTER TABLE `credit_card` DISABLE KEYS */;
INSERT INTO `credit_card` VALUES (1,'1001','Jose Perez',1,'2017-03-01',0,NULL),(2,'1002','Luis Negron',2,'2017-03-07',1,NULL),(3,'1003','Victor Beltran',3,'2017-03-06',1,NULL),(4,'1004','Maria Rolon',4,'2017-03-18',1,NULL),(5,'1005','Juan Ortega',5,'2017-03-17',1,NULL),(6,'1006','Coral Suazo',6,'2017-03-24',1,NULL),(7,'1007','Christian Rivera',7,'2017-03-17',1,NULL),(8,'1008','Luz Calderon',8,'2017-03-09',1,NULL),(9,'1009','Michelle Velez',9,'2017-03-18',1,NULL),(10,'1010','Jose Perez',1,'2016-04-13',0,NULL),(11,'4549635936541236','Jose Perez',1,'2017-04-11',1,'because yes');
/*!40000 ALTER TABLE `credit_card` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `images` (
  `image_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `image_path` varchar(255) NOT NULL,
  PRIMARY KEY (`image_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
INSERT INTO `images` VALUES (1,'?PNG\r\n\Z\n\0\0\0\rIHDR\0\0?\0\0?\0\0\0:?$?\0\0\0sRGB\0???\0\0\0gAMA\0\0???a\0\0\0	pHYs\0\0?\0\0??o?d\0\0??IDATx^??|T?????[?5W??֫?:???r?녪??W?v	{??+?`n?,6?R?V???T\Z??J!V?q??Ͷ\nۤ??6E,?(?D???1?i6?!????6???d&̄	3	?Lf漞???03g?L?|?g?y?????????(??(??(??(??2??z{{EQEQEQEQEQ?'),(2,'../../../storage/uploads/ER.PNG'),(3,'../../../storage/uploads/sladfkj.PNG'),(4,'../../../storage/uploads/system_arch.PNG'),(5,'../../../storage/uploads/ER.PNG'),(6,'../../../storage/uploads/sladfkj.PNG'),(7,'../../../storage/uploads/system_arch.PNG'),(8,'../../../storage/uploads/ER.PNG'),(9,'../../../storage/uploads/sladfkj.PNG'),(10,'../../../storage/uploads/system_arch.PNG'),(11,'../../../storage/uploads/ER.PNG'),(12,'../../../storage/uploads/sladfkj.PNG'),(13,'../../../storage/uploads/system_arch.PNG'),(14,'../../../storage/uploads/test.PNG'),(15,'../../../storage/uploads/mmm.PNG'),(16,'../../../storage/uploads/mmm.PNG'),(17,'../../../storage/uploads/c0929ca7-3dbe-11e7-af1b-000f9d182451'),(18,'../../../storage/uploads/c092f387-3dbe-11e7-af1b-000f9d182451');
/*!40000 ALTER TABLE `images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `items` (
  `item_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_name` varchar(255) NOT NULL,
  `item_price` double NOT NULL,
  `quantity` int(11) NOT NULL,
  `transaction_id` int(10) unsigned NOT NULL,
  `pi_allowed_item` tinyint(1) NOT NULL,
  `item_code` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`item_id`),
  KEY `items_transaction_id_foreign` (`transaction_id`),
  CONSTRAINT `items_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`transaction_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` VALUES (1,'book2000',50,22,2,1,'9851'),(2,'markers',10,1,2,1,'2222'),(3,'BEST ITEM',25.25,4483,2,1,'3333'),(5,'BEST ITEM',25.25,4483,2,1,'4444'),(7,'MAMA MIA',5,52,29,1,'5555'),(8,'MAMA MIA',5,52,30,1,'6666'),(9,'Lapiz',2.5,850,31,1,'7777'),(10,'Foil',0.5,50,32,1,'8888'),(11,'dis',159,5,33,0,'9999'),(12,'lolo',7,7,35,1,'1212');
/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `items_paid_from`
--

DROP TABLE IF EXISTS `items_paid_from`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `items_paid_from` (
  `ipf_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ra_id` int(10) unsigned NOT NULL,
  `item_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ipf_id`),
  KEY `items_paid_from_item_id_foreign` (`item_id`),
  KEY `items_paid_from_ra_id_foreign` (`ra_id`),
  CONSTRAINT `items_paid_from_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`),
  CONSTRAINT `items_paid_from_ra_id_foreign` FOREIGN KEY (`ra_id`) REFERENCES `research_accounts` (`ra_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items_paid_from`
--

LOCK TABLES `items_paid_from` WRITE;
/*!40000 ALTER TABLE `items_paid_from` DISABLE KEYS */;
INSERT INTO `items_paid_from` VALUES (2,1,2),(3,3,2),(4,3,3),(14,0,7),(15,1,7),(16,23,7),(17,0,8),(18,1,8),(19,23,8),(20,0,1),(21,17,9),(22,23,9),(23,17,10),(24,14,10),(25,17,11),(26,0,12),(27,1,12);
/*!40000 ALTER TABLE `items_paid_from` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2017_03_14_221153_create_roles_table',1),(2,'2017_03_14_233115_create_user_info_table',1),(3,'2017_03_14_2453602_create_accountant',1),(4,'2017_03_15_170126_create_researcher_table',1),(5,'2017_03_15_170924_create_credit_card_table',1),(6,'2017_03_15_192008_create_research_accounts_table',1),(7,'2017_03_15_192943_create_researcher_has_accounts_table',1),(8,'2017_03_15_194219_create_transactions_table',1),(9,'2017_03_15_200656_create_transaction_info_table',1),(10,'2017_03_15_201410_create_items_table',1),(11,'2017_03_15_201707_create_items_paid_from_table',1),(12,'2017_03_15_202021_create_comments_table',1),(13,'2017_03_15_202906_create_notifications_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notes`
--

DROP TABLE IF EXISTS `notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notes` (
  `note_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `body_of_note` varchar(255) NOT NULL,
  `accountant_id` int(10) unsigned NOT NULL,
  `transaction_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`note_id`),
  KEY `accountant_id` (`accountant_id`),
  KEY `transaction_id` (`transaction_id`),
  CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`accountant_id`) REFERENCES `accountants` (`accountant_id`),
  CONSTRAINT `notes_ibfk_2` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notes`
--

LOCK TABLES `notes` WRITE;
/*!40000 ALTER TABLE `notes` DISABLE KEYS */;
/*!40000 ALTER TABLE `notes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `notification_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `notification_text` varchar(255) NOT NULL,
  `researcher_id` int(10) unsigned NOT NULL,
  `accountant_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`notification_id`),
  KEY `notifications_researcher_id_foreign` (`researcher_id`),
  KEY `notifications_accountant_id_foreign` (`accountant_id`),
  CONSTRAINT `notifications_accountant_id_foreign` FOREIGN KEY (`accountant_id`) REFERENCES `accountants` (`accountant_id`),
  CONSTRAINT `notifications_researcher_id_foreign` FOREIGN KEY (`researcher_id`) REFERENCES `researchers` (`researcher_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `research_accounts`
--

DROP TABLE IF EXISTS `research_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `research_accounts` (
  `ra_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `research_nickname` varchar(255) NOT NULL,
  `ufis_account_number` varchar(255) NOT NULL,
  `frs_account_number` varchar(255) DEFAULT NULL,
  `unofficial_budget` double DEFAULT NULL,
  `budget_remaining` double DEFAULT NULL,
  `principal_investigator` varchar(255) NOT NULL,
  `be_notified` smallint(1) DEFAULT NULL,
  PRIMARY KEY (`ra_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `research_accounts`
--

LOCK TABLES `research_accounts` WRITE;
/*!40000 ALTER TABLE `research_accounts` DISABLE KEYS */;
INSERT INTO `research_accounts` VALUES (0,'account0','30232.135.000.6431.210.331431720101.00','100',1000,951,'Jose Perez',1),(1,'account1','30232.135.000.6431.210.331431720101.01','101',1001,952,'Jose Perez',1),(2,'account2','30232.135.000.6431.210.331431720101.02','102',1002,1002,'Luis Negron',0),(3,'account3','30232.135.000.6431.210.331431720101.03','103',1003,1003,'Luis Negron',0),(4,'account4','30232.135.000.6431.210.331431720101.04','104',1004,1004,'Victor Beltran',0),(5,'account5','30232.135.000.6431.210.331431720101.05','105',1005,1005,'Victor Beltran',0),(6,'account6','30232.135.000.6431.210.331431720101.06','106',1006,1006,'Maria Rolon',0),(7,'account7','30232.135.000.6431.210.331431720101.07','107',1007,1007,'Maria Rolon',0),(8,'account8','30232.135.000.6431.210.331431720101.08','108',1008,1008,'Juan Ortega',0),(9,'account9','30232.135.000.6431.210.331431720101.09','109',1009,1009,'Juan Ortega',0),(10,'account10','30232.135.000.6431.210.331431720101.10','110',1010,1010,'Coral Suazo',0),(11,'account11','30232.135.000.6431.210.331431720101.11','111',1011,1011,'Coral Suazo',0),(12,'account12','30232.135.000.6431.210.331431720101.12','112',1012,1012,'Christian Rivera',0),(13,'account13','30232.135.000.6431.210.331431720101.13','113',1013,1013,'Christian Rivera',0),(14,'account14','30232.135.000.6431.210.331431720101.14','114',1014,989,'Luz Calderon',0),(15,'account15','30232.135.000.6431.210.331431720101.15','115',1015,1015,'Luz Calderon',0),(16,'account16','30232.135.000.6431.210.331431720101.16','116',1016,1016,'Michelle velez',0),(17,'account17','30232.135.000.6431.210.331431720101.18','117',1017,-1928,'Michelle Velez',1),(23,'TI','30232.135.000.6431.210.331431720101.20','654654',4483.5,-1619.5,'Jose Perez',0);
/*!40000 ALTER TABLE `research_accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `researcher_has_accounts`
--

DROP TABLE IF EXISTS `researcher_has_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `researcher_has_accounts` (
  `rha_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ra_id` int(10) unsigned NOT NULL,
  `researcher_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`rha_id`),
  KEY `researcher_has_accounts_researcher_id_foreign` (`researcher_id`),
  KEY `researcher_has_accounts_ra_id_foreign` (`ra_id`),
  CONSTRAINT `researcher_has_accounts_ra_id_foreign` FOREIGN KEY (`ra_id`) REFERENCES `research_accounts` (`ra_id`),
  CONSTRAINT `researcher_has_accounts_researcher_id_foreign` FOREIGN KEY (`researcher_id`) REFERENCES `researchers` (`researcher_id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `researcher_has_accounts`
--

LOCK TABLES `researcher_has_accounts` WRITE;
/*!40000 ALTER TABLE `researcher_has_accounts` DISABLE KEYS */;
INSERT INTO `researcher_has_accounts` VALUES (0,0,1),(1,1,1),(2,2,2),(3,3,2),(4,4,3),(5,5,3),(6,6,4),(7,7,4),(8,8,5),(9,9,5),(10,10,6),(11,11,6),(12,12,7),(13,13,7),(14,14,8),(15,15,8),(16,16,9),(17,17,9),(18,17,1),(19,14,1),(31,23,1),(32,23,2),(33,23,3),(34,23,4),(35,23,5);
/*!40000 ALTER TABLE `researcher_has_accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `researcher_notifications`
--

DROP TABLE IF EXISTS `researcher_notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `researcher_notifications` (
  `rn_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `notification_body` varchar(60) NOT NULL,
  `marked_as_read` tinyint(1) unsigned NOT NULL,
  `at_id` int(11) unsigned DEFAULT NULL,
  `admin_timestamp_id` int(11) unsigned DEFAULT NULL,
  `researcher_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`rn_id`),
  KEY `researcher_notifications_researcher_id` (`researcher_id`),
  KEY `researcher_notifications_at_id` (`at_id`),
  KEY `researcher_notifications_admin_timestamp_id` (`admin_timestamp_id`),
  CONSTRAINT `researcher_notifications_admin_timestamp_id` FOREIGN KEY (`admin_timestamp_id`) REFERENCES `admin_timestamps` (`admin_timestamp_id`),
  CONSTRAINT `researcher_notifications_at_id` FOREIGN KEY (`at_id`) REFERENCES `accountants_timestamps` (`at_id`),
  CONSTRAINT `researcher_notifications_researcher_id` FOREIGN KEY (`researcher_id`) REFERENCES `researchers` (`researcher_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `researcher_notifications`
--

LOCK TABLES `researcher_notifications` WRITE;
/*!40000 ALTER TABLE `researcher_notifications` DISABLE KEYS */;
INSERT INTO `researcher_notifications` VALUES (1,'Your transaction was assigned to Joan Ortiz.',0,12,NULL,1),(2,'Your transaction was assigned to Joan Ortiz.',0,NULL,1,1),(3,'Your transaction was assigned to Bryan Matos.',0,NULL,2,1),(4,'Your transaction was assigned to Carlos Rodriguez.',0,NULL,3,1),(5,'Your transaction was assigned to Unassigned Accountant.',0,NULL,4,1),(6,'Your transaction was assigned to Joan Ortiz.',0,NULL,5,1),(7,'Your transaction was assigned to Joan Ortiz.',0,NULL,6,1),(8,'Your transaction was assigned to Joan Ortiz.',0,NULL,7,1),(9,'Your transaction was assigned to Joan Ortiz.',0,NULL,8,1),(10,'Your transaction was assigned to Joan Ortiz.',0,NULL,9,1),(11,'Your transaction was assigned to Joan Ortiz.',0,NULL,10,1),(12,'Your transaction was assigned to Joan Ortiz.',0,NULL,11,1),(13,'Your transaction was assigned to Joan Ortiz.',0,NULL,12,1),(14,'Your transaction was assigned to Joan Ortiz.',0,NULL,13,1),(15,'Your transaction was assigned to Joan Ortiz.',0,NULL,14,1),(16,'Your transaction was assigned to Joan Ortiz.',0,NULL,15,1),(17,'Your transaction was approved by Bryan Matos.',0,16,NULL,2);
/*!40000 ALTER TABLE `researcher_notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `researchers`
--

DROP TABLE IF EXISTS `researchers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `researchers` (
  `researcher_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `roles_id` int(10) unsigned NOT NULL,
  `user_info_id` char(255) NOT NULL,
  `amex_account_id` varchar(50) NOT NULL,
  `employee_id` varchar(20) NOT NULL,
  `accountant_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`researcher_id`),
  KEY `researchers_roles_id_foreign` (`roles_id`),
  KEY `researchers_user_info_id_foreign` (`user_info_id`),
  KEY `researchers_accountant_id_foreign` (`accountant_id`),
  CONSTRAINT `researchers_accountant_id_foreign` FOREIGN KEY (`accountant_id`) REFERENCES `accountants` (`accountant_id`),
  CONSTRAINT `researchers_roles_id_foreign` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`roles_id`),
  CONSTRAINT `researchers_user_info_id_foreign` FOREIGN KEY (`user_info_id`) REFERENCES `user_info` (`user_info_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `researchers`
--

LOCK TABLES `researchers` WRITE;
/*!40000 ALTER TABLE `researchers` DISABLE KEYS */;
INSERT INTO `researchers` VALUES (1,3,'0','1234','100',3),(2,3,'1','4321','101',4),(3,3,'2','2345','102',5),(4,3,'4','5432','103',6),(5,3,'5','3456','104',6),(6,3,'6','3787-963022-33009','105',5),(7,3,'8','4567','106',4),(8,3,'9','7654','107',3),(9,3,'10','5678','108',3);
/*!40000 ALTER TABLE `researchers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `researchers_timestamps`
--

DROP TABLE IF EXISTS `researchers_timestamps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `researchers_timestamps` (
  `ct_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `role` varchar(20) NOT NULL DEFAULT 'Researcher',
  `action` varchar(20) NOT NULL DEFAULT '',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `transaction_id` int(11) unsigned DEFAULT NULL,
  `researcher_id` int(11) unsigned DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ct_id`),
  KEY `transaction_FK` (`transaction_id`),
  KEY `researcher_FK` (`researcher_id`),
  CONSTRAINT `researcher_FK` FOREIGN KEY (`researcher_id`) REFERENCES `researchers` (`researcher_id`),
  CONSTRAINT `transaction_FK` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`transaction_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `researchers_timestamps`
--

LOCK TABLES `researchers_timestamps` WRITE;
/*!40000 ALTER TABLE `researchers_timestamps` DISABLE KEYS */;
INSERT INTO `researchers_timestamps` VALUES (3,'Researcher','edit','2017-04-13 17:28:06',2,1,'Jose Perez'),(4,'Researcher','create','2017-04-13 17:28:12',2,1,'Jose Perez'),(5,'Researcher','deletion','2017-04-13 17:28:34',3,2,'Luis Negron'),(6,'Researcher','Created New Transact','2017-05-11 17:54:49',31,1,'Jose Perez'),(7,'Researcher','Created New Transact','2017-05-15 16:55:34',32,1,'Jose Perez'),(8,'Researcher','Created New Transact','2017-05-15 16:57:17',33,1,'Jose Perez'),(9,'Researcher','Created New Transact','2017-05-21 00:47:42',35,1,'Jose Perez');
/*!40000 ALTER TABLE `researchers_timestamps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `roles_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `system_roles` varchar(255) NOT NULL,
  PRIMARY KEY (`roles_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'administrator'),(2,'accountant'),(3,'researcher'),(4,'disabled');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaction_images`
--

DROP TABLE IF EXISTS `transaction_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaction_images` (
  `transaction_image_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `image_id` bigint(20) NOT NULL,
  `tinfo_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`transaction_image_id`),
  KEY `transaction_images_image_id_foreign` (`image_id`),
  KEY `transaction_images_tinfo_id_foreign` (`tinfo_id`),
  CONSTRAINT `transaction_images_image_id_foreign` FOREIGN KEY (`image_id`) REFERENCES `images` (`image_id`),
  CONSTRAINT `transaction_images_tinfo_id_foreign` FOREIGN KEY (`tinfo_id`) REFERENCES `transactions_info` (`tinfo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction_images`
--

LOCK TABLES `transaction_images` WRITE;
/*!40000 ALTER TABLE `transaction_images` DISABLE KEYS */;
INSERT INTO `transaction_images` VALUES (1,5,20),(2,6,20),(3,7,20),(4,8,21),(5,9,21),(6,10,21),(7,11,22),(8,12,22),(9,13,22),(10,14,23),(11,15,24),(12,16,25),(13,17,27),(14,18,27);
/*!40000 ALTER TABLE `transaction_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactions` (
  `transaction_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `billing_cycle` varchar(256) NOT NULL,
  `is_reconciliated` tinyint(1) NOT NULL,
  `researcher_id` int(10) unsigned NOT NULL,
  `accountant_id` int(10) unsigned DEFAULT NULL,
  `checked_pi` tinyint(1) NOT NULL,
  PRIMARY KEY (`transaction_id`),
  KEY `transactions_researcher_id_foreign` (`researcher_id`),
  KEY `transactions_accountant_id_foreign` (`accountant_id`),
  CONSTRAINT `transactions_accountant_id_foreign` FOREIGN KEY (`accountant_id`) REFERENCES `accountants` (`accountant_id`),
  CONSTRAINT `transactions_researcher_id_foreign` FOREIGN KEY (`researcher_id`) REFERENCES `researchers` (`researcher_id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` VALUES (2,'2017-03-02 04:00:00','2017-03-14 20:00:00','unassigned','March 2017',0,1,4,1),(3,'2017-03-02 04:00:00','2017-03-22 11:00:00','approved','March 2017',1,6,4,1),(4,'2017-03-02 04:00:00','2017-03-08 12:00:00','approved','March 2017',1,6,3,1),(5,'2017-03-18 13:00:00','2017-03-04 15:00:00','approved','April 2017',0,2,4,1),(6,'2017-03-02 04:00:00','2017-03-28 07:00:00','in progress','March 2017',0,2,3,1),(7,'2017-03-02 04:00:00','2017-03-31 17:00:00','in progress','February 2017',0,1,3,1),(8,'2017-03-02 04:00:00','2017-03-20 11:00:00','escalated','February 2017',0,1,3,1),(9,'2017-03-02 04:00:00','2017-03-25 04:00:00','escalated','February 2017',1,6,3,1),(10,'2017-03-02 04:00:00','2017-03-18 16:00:00','unathorized charge','April 2017',1,6,5,1),(11,'2017-03-02 04:00:00','2017-03-24 12:00:00','unathorized charge','April 2017',1,6,3,1),(12,'2017-03-02 04:00:00','2017-03-23 08:00:00','unassigned','April 2017',0,1,6,1),(13,'2017-03-02 04:00:00','2017-03-11 04:00:00','in progress','April 2017',0,1,3,1),(18,'2017-04-02 02:56:21','2017-03-11 04:00:00','approved','May 2017',1,6,4,1),(19,'2017-04-02 02:56:21','2017-03-11 04:00:00','approved','May 2017',1,6,4,1),(20,'2017-04-02 02:56:21','2017-03-11 04:00:00','approved','May 2017',1,6,4,1),(21,'2017-04-02 02:56:21','2017-03-11 04:00:00','approved','May 2017',1,6,4,1),(27,'2017-04-03 04:27:39','2017-03-11 04:00:00','in progress','June 2017',0,1,6,1),(28,'2017-04-03 04:31:38','2017-03-11 04:00:00','in progress','June 2017',0,1,6,1),(29,'2017-04-03 04:32:23','2017-03-11 04:00:00','in progress','June 2017',0,1,5,1),(30,'2017-04-03 04:32:31','2017-03-11 04:00:00','in progress','June 2017',0,1,5,1),(31,'2017-05-11 17:54:49','2017-05-11 17:54:49','unassigned','June 2017',0,1,NULL,1),(32,'2017-05-15 16:55:34','2017-05-15 16:55:34','unassigned','June 2017',0,1,NULL,1),(33,'2017-05-15 16:57:17','2017-05-15 16:57:17','unassigned','June 2017',0,1,NULL,0),(35,'2017-05-21 00:47:42','2017-05-21 00:47:42','unassigned','May 2017',0,1,NULL,1);
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions_info`
--

DROP TABLE IF EXISTS `transactions_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactions_info` (
  `tinfo_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `transaction_number` varchar(255) DEFAULT NULL,
  `receipt_number` varchar(255) DEFAULT NULL,
  `receipt_image_path` varchar(255) DEFAULT NULL,
  `date_bought` date NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `description_justification` varchar(255) NOT NULL,
  `total` double NOT NULL,
  `transaction_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tinfo_id`),
  KEY `transactions_info_transaction_id_foreign` (`transaction_id`),
  CONSTRAINT `transactions_info_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`transaction_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions_info`
--

LOCK TABLES `transactions_info` WRITE;
/*!40000 ALTER TABLE `transactions_info` DISABLE KEYS */;
INSERT INTO `transactions_info` VALUES (1,'1234567890','0987654321',NULL,'2017-03-01','Walmart','Needed materials for lab.',50,2),(2,'5416545616','65165654',NULL,'2017-03-17','JETBLUE AIRWAYS','TESTING PURPOSES',25,3),(3,'123450712','12301230',NULL,'2017-03-17','COMFORT INN','Necesitamos comidas para los invitados',1232.04,4),(4,'2567479652','21854005678',NULL,'2017-03-28','Kmart','School supplies for tutoring',300,5),(5,'123450712','12301230',NULL,'2017-03-30','Supermercados Econo','Necesitamos comidas para los invitados',500,6),(6,'2567479652','21854005678',NULL,'2017-03-28','Kmart','School supplies for tutoring',300,7),(7,'25213502678','236400185',NULL,'2017-03-14','Home Depot','Needed screws and stuff for construction of project prototype',20,8),(8,'2348943127419','12318413213',NULL,'2017-03-17','COMFORT INN','Ordered supplies for project',1232.04,9),(9,'25213502678','236400185',NULL,'2017-03-03','PRAXAIR PR BV','Needed screws and stuff for construction of project prototype',205,10),(10,'2348943127419','12318413213',NULL,'2017-03-06','GILMAN CORPORATION','Ordered supplies for project',241.71,11),(11,'123840315951464','5655081807',NULL,'2017-03-27','Office Depot','Supplies for upcoming prototype',200,12),(12,'326502681','3900685020',NULL,'2017-03-18','Office Max','Mouses and keyboards for programming ',50,13),(15,'26258432','49856151',NULL,'2017-03-13','AA PUERTO RICO MCCY USD ANCILLARY','',25,18),(16,'98546123','23156489',NULL,'2017-02-23','AMAZON.COM LLC','SDTGFCVHJ',35.18,19),(17,'89456','4916',NULL,'2017-02-23','AMAZON.COM LLC','YES',51.96,20),(18,'98416595','6365458',NULL,'2017-03-07','SMARTSHEET.COM','LLEVAMEEEEEE',99,21),(19,'789456','4561',NULL,'2017-02-03','PLEASE','miiiiii',25.25,27),(20,'789456','4561',NULL,'2017-02-03','PLEASE','miiiiii',25.25,28),(21,'789456','4561',NULL,'2017-02-03','PLEASE','miiiiii',25.25,29),(22,'789456','4561',NULL,'2017-02-03','PLEASE','miiiiii',25.25,30),(23,'Mumu','4984954',NULL,'2017-05-11','Cosa','Muio',56.36,31),(24,'84163859469','789159',NULL,'2017-05-15','Ferreteria La Fama','Google',59.36,32),(25,'789159','41986541',NULL,'2017-05-15','Pooil','dfsd',2465,33),(27,'43254','45.87',NULL,'2017-05-09','45354','hgf',49,35);
/*!40000 ALTER TABLE `transactions_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_info`
--

DROP TABLE IF EXISTS `user_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_info` (
  `user_info_id` char(36) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `department` varchar(30) NOT NULL,
  `office` varchar(6) NOT NULL,
  `phone_number` varchar(13) NOT NULL,
  `job_title` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_info_id`),
  UNIQUE KEY `user_info_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_info`
--

LOCK TABLES `user_info` WRITE;
/*!40000 ALTER TABLE `user_info` DISABLE KEYS */;
INSERT INTO `user_info` VALUES ('0','Jose','Perez','ECE','S-113','1234567890','Professor','jose.perez@upr.edu','test','2017-03-22 04:00:00','2017-03-22 04:00:00'),('1','Luis','Negron','ECE','S-222','1234567890','Professor','luis.negron@upr.edu','test','2017-03-22 04:00:00','2017-03-22 04:00:00'),('10','Michelle','Velez','ECE','S-409','1234567890','Professor','michelle.velez@upr.edu','test','2017-03-22 04:00:00','2017-03-22 04:00:00'),('11','Joan','Ortiz','ECE','S-410','123','Accountant','joan.ortiz@upr.edu','test','2017-03-22 04:00:00','2017-03-22 04:00:00'),('12','Unassigned','Accountant','','','','','','','2017-03-22 04:00:00','2017-03-22 04:00:00'),('13','Carlos','Ojeda','ECE','S-113','7874684493','Administrator','carlos.ojeda4@upr.edu','test',NULL,NULL),('2','Victor','Beltran','ECE','S-403','1234567890','Professor','victor.beltran@upr.edu','test','2017-03-22 04:00:00','2017-03-22 04:00:00'),('3','Carlos','Rodriguez','ECE','S-401','1234567890','Accountant','carlos.rodriguez@upr.edu','test','2017-03-22 04:00:00','2017-03-22 04:00:00'),('4','Maria','Rolon','ECE','S-402','1234567890','Professor','maria.rolon@upr.edu','test','2017-03-22 04:00:00','2017-03-22 04:00:00'),('5','Juan','Ortega','ECE','S-404','1234567890','Professor','juan.ortega@upr.edu','test','2017-03-22 04:00:00','2017-03-22 04:00:00'),('6','Coral','Suazo','ECE','S-405','1234567890','Professor','coral.suazo@upr.edu','test','2017-03-22 04:00:00','2017-03-22 04:00:00'),('7','Bryan','Matos','ECE','S-406','1234567890','Accountant','bryan.matos@upr.edu','test','2017-03-22 04:00:00','2017-03-22 04:00:00'),('8','Christian','Rivera','ECE','S-407','1234567890','Professor','christian.rivera@upr.edu','test','2017-03-22 04:00:00','2017-03-22 04:00:00'),('9','Luz','Calderon','ECE','S-408','1234567890','Professor','luz.calderon@upr.edu','test','2017-03-22 04:00:00','2017-03-22 04:00:00');
/*!40000 ALTER TABLE `user_info` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-05-22 12:46:01
