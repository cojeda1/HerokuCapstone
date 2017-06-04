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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accountants`
--

LOCK TABLES `accountants` WRITE;
/*!40000 ALTER TABLE `accountants` DISABLE KEYS */;
INSERT INTO `accountants` VALUES (3,2,'11'),(4,2,'7'),(5,2,'3'),(6,2,'12');
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
  `action` varchar(40) NOT NULL DEFAULT '',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `transaction_id` int(11) unsigned DEFAULT NULL,
  `accountant_id` int(11) unsigned DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`at_id`),
  KEY `transaction_FK` (`transaction_id`),
  KEY `researcher_FK` (`accountant_id`),
  CONSTRAINT `accountant_FK` FOREIGN KEY (`accountant_id`) REFERENCES `accountants` (`accountant_id`),
  CONSTRAINT `accountants_timestamps_ibfk_2` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`transaction_id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accountants_timestamps`
--

LOCK TABLES `accountants_timestamps` WRITE;
/*!40000 ALTER TABLE `accountants_timestamps` DISABLE KEYS */;
INSERT INTO `accountants_timestamps` VALUES (4,'Accountant','approve','2017-04-13 17:27:36',2,3,'Joan Ortiz'),(5,'Accountant','New Comment','2017-04-19 19:15:49',3,4,'Bryan Matos'),(6,'Accountant','New Comment','2017-04-19 19:18:24',3,4,'Bryan Matos'),(7,'Accountant','New Comment','2017-04-19 19:18:46',3,4,'Bryan Matos'),(8,'Accountant','New Note','2017-04-19 22:17:02',2,4,'Bryan Matos'),(9,'Accountant','Edited Note','2017-04-21 20:22:22',2,4,'Bryan Matos'),(10,'Accountant','New Note','2017-04-21 20:23:28',2,4,'Bryan Matos'),(11,'Accountant','Edited Note','2017-04-21 20:25:36',2,4,'Bryan Matos'),(12,'Accountant','New Comment','2017-04-21 20:28:18',2,4,'Bryan Matos'),(13,'Accountant','Edited Comment','2017-04-21 20:30:27',2,4,'Bryan Matos'),(14,'Accountant','Edited Note','2017-04-21 20:31:55',2,4,'Bryan Matos'),(15,'Accountant','Deleted Comment','2017-04-21 20:35:55',2,4,'Bryan Matos'),(16,'Accountant','Edited Note','2017-04-21 20:37:06',2,4,'Bryan Matos'),(17,'Accountant','New Comment','2017-04-21 20:37:49',2,4,'Bryan Matos'),(18,'Accountant','New Comment','2017-04-21 20:44:24',2,4,'Bryan Matos'),(19,'Accountant','Assigned Transaction','2017-04-22 00:04:00',34,4,'Bryan Matos'),(20,'Accountant','New Comment','2017-04-22 00:04:48',34,4,'Bryan Matos'),(21,'Accountant','New Note','2017-04-22 00:04:59',34,4,'Bryan Matos'),(22,'Accountant','Edited Comment','2017-04-22 00:05:59',34,4,'Bryan Matos'),(23,'Accountant','Edited Note','2017-04-22 00:06:16',34,4,'Bryan Matos'),(24,'Accountant','Deleted Note','2017-04-22 00:06:23',34,4,'Bryan Matos'),(25,'Accountant','Deleted Comment','2017-04-22 00:06:34',34,4,'Bryan Matos'),(26,'Accountant','New Comment','2017-04-22 20:56:30',20,4,'Bryan Matos'),(27,'Accountant','Deleted Comment','2017-04-22 21:39:59',2,4,'Bryan Matos'),(28,'Accountant','Auited Transaction: ','2017-04-22 22:14:27',2,4,'Bryan Matos'),(29,'Accountant','Auited Transaction: ','2017-04-22 22:17:52',2,4,'Bryan Matos'),(30,'Accountant','Auited Transaction: approved','2017-04-22 22:19:14',2,4,'Bryan Matos'),(36,'Accountant','Assigned Transaction','2017-04-24 21:33:26',36,4,'Bryan Matos');
/*!40000 ALTER TABLE `accountants_timestamps` ENABLE KEYS */;
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
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `body_of_comment` varchar(255) CHARACTER SET utf8 NOT NULL,
  `transaction_id` int(10) unsigned NOT NULL,
  `accountant_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `comments_transaction_id_foreign` (`transaction_id`),
  KEY `comments_accountant_id_foreign` (`accountant_id`),
  CONSTRAINT `comments_accountant_id_foreign` FOREIGN KEY (`accountant_id`) REFERENCES `accountants` (`accountant_id`),
  CONSTRAINT `comments_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`transaction_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,'2017-03-02 04:00:00','2017-03-02 04:00:00','Not justified',2,3),(2,'2017-03-02 04:00:00','2017-03-02 04:00:00','Items cannot be approved',2,3),(3,'0000-00-00 00:00:00','0000-00-00 00:00:00','Hola',2,3),(4,'0000-00-00 00:00:00','0000-00-00 00:00:00','hmmmm\n',31,4),(12,'0000-00-00 00:00:00','0000-00-00 00:00:00','jiji',3,4),(14,'0000-00-00 00:00:00','0000-00-00 00:00:00','please work',3,4),(15,'2017-04-19 19:18:24','0000-00-00 00:00:00','how about now',3,4),(16,'2017-04-19 19:18:46','0000-00-00 00:00:00','mmm',3,4),(18,'2017-04-21 20:37:49','0000-00-00 00:00:00','test',2,4),(20,'2017-04-22 20:56:30','0000-00-00 00:00:00','etytwh',20,4);
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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
INSERT INTO `images` VALUES (1,'?PNG\r\n\Z\n\0\0\0\rIHDR\0\0?\0\0?\0\0\0:?$?\0\0\0sRGB\0???\0\0\0gAMA\0\0???a\0\0\0	pHYs\0\0?\0\0??o?d\0\0??IDATx^??|T?????[?5W??֫?:???r?녪??W?v	{??+?`n?,6?R?V???T\Z??J!V?q??Ͷ\nۤ??6E,?(?D???1?i6?!????6???d&̄	3	?Lf漞???03g?L?|?g?y?????????(??(??(??(??2??z{{EQEQEQEQEQ?'),(2,'../../../storage/uploads/ER.PNG'),(3,'../../../storage/uploads/sladfkj.PNG'),(4,'../../../storage/uploads/system_arch.PNG'),(5,'../../../storage/uploads/ER.PNG'),(6,'../../../storage/uploads/sladfkj.PNG'),(7,'../../../storage/uploads/system_arch.PNG'),(8,'../../../storage/uploads/ER.PNG'),(9,'../../../storage/uploads/sladfkj.PNG'),(10,'../../../storage/uploads/system_arch.PNG'),(11,'../../../storage/uploads/ER.PNG'),(12,'../../../storage/uploads/sladfkj.PNG'),(13,'../../../storage/uploads/system_arch.PNG'),(14,'../../../storage/uploads/Screen Shot 2017-04-18 at 7.10.40 PM.png'),(17,'../../../storage/uploads/Screen Shot 2017-04-19 at 3.26.05 PM.png'),(18,'../../../storage/uploads/mmm.PNG'),(19,'../../../storage/uploads/sladfkj.PNG');
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
  `pi_allowed_item` tinyint(4) NOT NULL,
  PRIMARY KEY (`item_id`),
  KEY `items_transaction_id_foreign` (`transaction_id`),
  CONSTRAINT `items_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`transaction_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` VALUES (1,'book',50,2,2,1),(2,'markers',10,1,2,1),(3,'BEST ITEM',25.25,4483,2,1),(5,'BEST ITEM',25.25,4483,2,1),(6,'BEST ITEM',25.25,4483,2,0),(7,'MAMA MIA',5,52,29,1),(8,'MAMA MIA',5,52,30,1),(9,'Lapiz',50,100,31,0),(12,'Lapiz',80,20,34,0),(13,'Pencil',43.34,89,35,1),(14,'Test Item 0',85,2,36,1);
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
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items_paid_from`
--

LOCK TABLES `items_paid_from` WRITE;
/*!40000 ALTER TABLE `items_paid_from` DISABLE KEYS */;
INSERT INTO `items_paid_from` VALUES (1,0,1),(2,1,2),(3,3,2),(4,3,3),(10,2,6),(11,3,6),(12,4,6),(13,5,6),(14,0,7),(15,1,7),(16,23,7),(17,0,8),(18,1,8),(19,23,8),(20,1,9),(21,23,9),(26,0,12),(27,1,12),(28,1,13),(29,0,13),(30,0,14);
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
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `body_of_note` varchar(255) NOT NULL,
  `accountant_id` int(10) unsigned NOT NULL,
  `transaction_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`note_id`),
  KEY `accountant_id` (`accountant_id`),
  KEY `transaction_id` (`transaction_id`),
  CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`accountant_id`) REFERENCES `accountants` (`accountant_id`),
  CONSTRAINT `notes_ibfk_2` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`transaction_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notes`
--

LOCK TABLES `notes` WRITE;
/*!40000 ALTER TABLE `notes` DISABLE KEYS */;
INSERT INTO `notes` VALUES (1,'0000-00-00 00:00:00','2017-04-21 21:59:21','huuh',4,31);
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
INSERT INTO `research_accounts` VALUES (0,'account0','100','100',1000,1000,'Jose Perez',1),(1,'account1','101','101',1001,1001,'Jose Perez',1),(2,'account2','102','102',1002,1002,'Luis Negron',0),(3,'account3','103','103',1003,1003,'Luis Negron',0),(4,'account4','104','104',1004,1004,'Victor Beltran',0),(5,'account5','105','105',1005,1005,'Victor Beltran',0),(6,'account6','106','106',1006,1006,'Maria Rolon',0),(7,'account7','107','107',1007,1007,'Maria Rolon',0),(8,'account8','108','108',1008,1008,'Juan Ortega',0),(9,'account9','109','109',1009,1009,'Juan Ortega',0),(10,'account10','110','110',1010,1010,'Coral Suazo',0),(11,'account11','111','111',1011,1011,'Coral Suazo',0),(12,'account12','112','112',1012,1012,'Christian Rivera',0),(13,'account13','113','113',1013,1013,'Christian Rivera',0),(14,'account14','114','114',1014,1014,'Luz Calderon',0),(15,'account15','115','115',1015,1015,'Luz Calderon',0),(16,'account16','116','116',1016,1016,'Michelle velez',0),(17,'account17','117','117',1017,1017,'Michelle Velez',0),(23,'TI','065146541','654654',4483.5,505.5,'Jose Perez',0);
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
  `at_id` int(11) unsigned NOT NULL,
  `researcher_id` int(10) unsigned NOT NULL,
  `transaction_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`rn_id`),
  KEY `researcher_notifications_researcher_id` (`researcher_id`),
  KEY `researcher_notifications_at_id` (`at_id`),
  KEY `researcher_notifications_transaction_id` (`transaction_id`),
  CONSTRAINT `researcher_notifications_at_id` FOREIGN KEY (`at_id`) REFERENCES `accountants_timestamps` (`at_id`),
  CONSTRAINT `researcher_notifications_researcher_id` FOREIGN KEY (`researcher_id`) REFERENCES `researchers` (`researcher_id`),
  CONSTRAINT `researcher_notifications_transaction_id` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`transaction_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `researcher_notifications`
--

LOCK TABLES `researcher_notifications` WRITE;
/*!40000 ALTER TABLE `researcher_notifications` DISABLE KEYS */;
INSERT INTO `researcher_notifications` VALUES (1,'Your transaction was assigned to Bryan Matos.',0,36,1,36);
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
  `action` varchar(40) NOT NULL DEFAULT '',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `transaction_id` int(11) unsigned DEFAULT NULL,
  `researcher_id` int(11) unsigned DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ct_id`),
  KEY `transaction_FK` (`transaction_id`),
  KEY `researcher_FK` (`researcher_id`),
  CONSTRAINT `researcher_FK` FOREIGN KEY (`researcher_id`) REFERENCES `researchers` (`researcher_id`),
  CONSTRAINT `transaction_FK` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`transaction_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `researchers_timestamps`
--

LOCK TABLES `researchers_timestamps` WRITE;
/*!40000 ALTER TABLE `researchers_timestamps` DISABLE KEYS */;
INSERT INTO `researchers_timestamps` VALUES (3,'Researcher','edit','2017-04-13 17:28:06',2,1,'Jose Perez'),(4,'Researcher','create','2017-04-13 17:28:12',2,1,'Jose Perez'),(5,'Researcher','deletion','2017-04-13 17:28:34',3,2,'Luis Negron'),(6,'Researcher','Created New Transact','2017-04-21 22:09:40',34,1,'Jose Perez'),(7,'Researcher','Created New Transaction','2017-04-22 22:29:41',35,1,'Jose Perez'),(8,'Researcher','Created New Transaction','2017-04-24 20:59:14',36,1,'Jose Perez');
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
INSERT INTO `roles` VALUES (1,'administrator'),(2,'accountant'),(3,'researcher'),(4,'administrator accountant');
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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction_images`
--

LOCK TABLES `transaction_images` WRITE;
/*!40000 ALTER TABLE `transaction_images` DISABLE KEYS */;
INSERT INTO `transaction_images` VALUES (1,5,20),(2,6,20),(3,7,20),(4,8,21),(5,9,21),(6,10,21),(7,11,22),(8,12,22),(9,13,22),(10,14,23),(13,17,26),(14,18,27),(15,19,28);
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
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` varchar(20) NOT NULL,
  `billing_cycle` date NOT NULL,
  `is_reconciliated` tinyint(1) NOT NULL,
  `researcher_id` int(10) unsigned NOT NULL,
  `accountant_id` int(10) unsigned DEFAULT NULL,
  `checked_pi` tinyint(4) NOT NULL,
  PRIMARY KEY (`transaction_id`),
  KEY `transactions_researcher_id_foreign` (`researcher_id`),
  KEY `transactions_accountant_id_foreign` (`accountant_id`),
  CONSTRAINT `transactions_accountant_id_foreign` FOREIGN KEY (`accountant_id`) REFERENCES `accountants` (`accountant_id`),
  CONSTRAINT `transactions_researcher_id_foreign` FOREIGN KEY (`researcher_id`) REFERENCES `researchers` (`researcher_id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` VALUES (2,'2017-03-02 04:00:00','2017-04-24 19:01:07','approved','2017-03-22',0,1,4,1),(3,'2017-03-02 04:00:00','2017-04-24 19:01:07','denied','2017-04-18',1,6,4,1),(4,'2017-03-02 04:00:00','2017-04-24 19:01:07','approved','2017-03-01',1,6,3,1),(5,'2017-03-18 13:00:00','2017-04-24 19:01:07','in progress','2017-03-14',0,2,3,1),(6,'2017-03-02 04:00:00','2017-04-24 19:01:07','denied','2017-03-03',0,2,3,1),(7,'2017-03-02 04:00:00','2017-04-24 19:01:07','denied','2017-03-21',0,1,3,1),(8,'2017-03-02 04:00:00','2017-04-24 19:01:07','escalated','2017-03-18',0,1,3,1),(9,'2017-03-02 04:00:00','2017-04-24 19:01:07','escalated','2017-03-27',1,6,3,1),(10,'2017-03-02 04:00:00','2017-04-24 19:01:07','unathorized charge','2017-03-03',1,6,5,1),(11,'2017-03-02 04:00:00','2017-04-24 19:01:07','unathorized charge','2017-03-01',1,6,3,1),(12,'2017-03-02 04:00:00','2017-04-24 19:01:07','unassigned','2017-03-11',0,1,6,1),(13,'2017-03-02 04:00:00','2017-04-24 19:01:07','unassigned','2017-03-01',0,1,3,1),(18,'2017-04-02 02:56:21','2017-04-24 19:01:07','escalated','0000-00-00',1,6,4,1),(19,'2017-04-02 02:56:21','2017-04-24 19:01:07','approved','0000-00-00',1,6,4,1),(20,'2017-04-02 02:56:21','2017-04-24 19:01:07','approved','0000-00-00',1,6,4,1),(21,'2017-04-02 02:56:21','2017-04-24 19:01:07','approved','0000-00-00',1,6,4,1),(27,'2017-04-03 04:27:39','2017-04-24 19:01:07','in_progress','0000-00-00',0,1,NULL,1),(28,'2017-04-03 04:31:38','2017-04-24 19:01:07','in_progress','0000-00-00',0,1,NULL,1),(29,'2017-04-03 04:32:23','2017-04-24 19:01:07','in_progress','0000-00-00',0,1,NULL,1),(30,'2017-04-03 04:32:31','2017-04-24 19:01:07','in_progress','0000-00-00',0,1,NULL,1),(31,'2017-04-18 23:26:39','2017-04-24 19:19:45','in progress','0000-00-00',0,1,4,0),(34,'2017-04-21 22:09:40','2017-04-24 19:01:37','in progress','0000-00-00',0,1,4,0),(35,'2017-04-22 22:29:41','2017-04-24 19:16:20','in progress','0000-00-00',0,1,NULL,0),(36,'2017-04-24 20:59:14','2017-04-24 21:33:26','in progress','0000-00-00',0,1,4,0);
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
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions_info`
--

LOCK TABLES `transactions_info` WRITE;
/*!40000 ALTER TABLE `transactions_info` DISABLE KEYS */;
INSERT INTO `transactions_info` VALUES (1,'1234567890','0987654321',NULL,'2017-03-01','Walmart','Needed materials for lab.',50,2),(2,'5416545616','65165654',NULL,'2017-03-17','JETBLUE AIRWAYS','TESTING PURPOSES',25,3),(3,'123450712','12301230',NULL,'2017-03-17','COMFORT INN','Necesitamos comidas para los invitados',1232.04,4),(4,'2567479652','21854005678',NULL,'2017-03-28','Kmart','School supplies for tutoring',300,5),(5,'123450712','12301230',NULL,'2017-03-30','Supermercados Econo','Necesitamos comidas para los invitados',500,6),(6,'2567479652','21854005678',NULL,'2017-03-28','Kmart','School supplies for tutoring',300,7),(7,'25213502678','236400185',NULL,'2017-03-14','Home Depot','Needed screws and stuff for construction of project prototype',20,8),(8,'2348943127419','12318413213',NULL,'2017-03-17','COMFORT INN','Ordered supplies for project',1232.04,9),(9,'25213502678','236400185',NULL,'2017-03-03','PRAXAIR PR BV','Needed screws and stuff for construction of project prototype',205,10),(10,'2348943127419','12318413213',NULL,'2017-03-06','GILMAN CORPORATION','Ordered supplies for project',241.71,11),(11,'123840315951464','5655081807',NULL,'2017-03-27','Office Depot','Supplies for upcoming prototype',200,12),(12,'326502681','3900685020',NULL,'2017-03-18','Office Max','Mouses and keyboards for programming ',50,13),(15,'26258432','49856151',NULL,'2017-03-13','AA PUERTO RICO MCCY USD ANCILLARY','',25,18),(16,'98546123','23156489',NULL,'2017-02-23','AMAZON.COM LLC','SDTGFCVHJ',35.18,19),(17,'89456','4916',NULL,'2017-02-23','AMAZON.COM LLC','YES',51.96,20),(18,'98416595','6365458',NULL,'2017-03-07','SMARTSHEET.COM','LLEVAMEEEEEE',99,21),(19,'789456','4561',NULL,'2017-02-03','PLEASE','miiiiii',25.25,27),(20,'789456','4561',NULL,'2017-02-03','PLEASE','miiiiii',25.25,28),(21,'789456','4561',NULL,'2017-02-03','PLEASE','miiiiii',25.25,29),(22,'789456','4561',NULL,'2017-02-03','PLEASE','miiiiii',25.25,30),(23,'4567890','809123487',NULL,'0000-00-00','AMAZON','',0,31),(26,'39485230984','49238502938',NULL,'2017-02-10','AMAZON','testing purposes',89.9,34),(27,'342131','685465',NULL,'2017-02-03','Not Amazn','adfs',451.25,35),(28,'8456165','123456789',NULL,'2017-04-03','Home ','Please',256.3,36);
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
INSERT INTO `user_info` VALUES ('0','Jose','Perez','ECE','S-113','1234567890','Professor','jose.perez@upr.edu','test','2017-03-22 04:00:00','2017-03-22 04:00:00'),('1','Luis','Negron','ECE','S-222','1234567890','Professor','luis.negron@upr.edu','test','2017-03-22 04:00:00','2017-03-22 04:00:00'),('10','Michelle','Velez','ECE','S-409','1234567890','Professor','michelle.velez@upr.edu','test','2017-03-22 04:00:00','2017-03-22 04:00:00'),('11','Joan','Ortiz','ECE','S-410','123','Accountant','joan.ortiz@upr.edu','test','2017-03-22 04:00:00','2017-03-22 04:00:00'),('12','Unassigned','Accountant','','','','','','','2017-03-22 04:00:00','2017-03-22 04:00:00'),('2','Victor','Beltran','ECE','S-403','1234567890','Professor','victor.beltran@upr.edu','test','2017-03-22 04:00:00','2017-03-22 04:00:00'),('3','Carlos','Rodriguez','ECE','S-401','3737','Accountant','carlos.rodriguez@upr.edu','1234','2017-03-22 04:00:00','0000-00-00 00:00:00'),('4','Maria','Rolon','ECE','S-402','1234567890','Professor','maria.rolon@upr.edu','test','2017-03-22 04:00:00','2017-03-22 04:00:00'),('5','Juan','Ortega','ECE','S-404','1234567890','Professor','juan.ortega@upr.edu','test','2017-03-22 04:00:00','2017-03-22 04:00:00'),('6','Coral','Suazo','ECE','S-405','1234567890','Professor','coral.suazo@upr.edu','test','2017-03-22 04:00:00','2017-03-22 04:00:00'),('7','Bryan','Matos','ECE','S-406','1234567890','Accountant','bryan.matos@upr.edu','test','2017-03-22 04:00:00','2017-03-22 04:00:00'),('8','Christian','Rivera','ECE','S-407','1234567890','Professor','christian.rivera@upr.edu','test','2017-03-22 04:00:00','2017-03-22 04:00:00'),('9','Luz','Calderon','ECE','S-408','1234567890','Professor','luz.calderon@upr.edu','test','2017-03-22 04:00:00','2017-03-22 04:00:00');
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

-- Dump completed on 2017-04-24 17:38:51
