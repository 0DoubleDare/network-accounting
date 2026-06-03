/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-11.4.9-MariaDB, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: network_accounting_db
-- ------------------------------------------------------
-- Server version	11.4.9-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `defects`
--

DROP TABLE IF EXISTS `defects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `defects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `point_id` int(11) NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `severity` enum('high','medium','low') DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` enum('open','in_progress','closed') DEFAULT 'open',
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `image_path` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `point_id` (`point_id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `defects_ibfk_1` FOREIGN KEY (`point_id`) REFERENCES `network_points` (`id`) ON DELETE CASCADE,
  CONSTRAINT `defects_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `defects`
--

LOCK TABLES `defects` WRITE;
/*!40000 ALTER TABLE `defects` DISABLE KEYS */;
INSERT INTO `defects` VALUES
(1,1,'Скрутка','high','Самодельная скрутка на 2 розетки, провода оголены','open',2,'2026-06-02 17:35:29',NULL),
(2,2,'Крепление','high','Розетка не закреплена, валяется на полу, без маркировки','open',3,'2026-06-02 17:35:29',NULL),
(3,3,'Кабель','medium','Старая розетка со скотчем, провода без короба','open',4,'2026-06-02 17:35:29',NULL),
(4,4,'Механический','high','Корпус сломан, плата вывалилась','in_progress',5,'2026-06-02 17:35:29',NULL),
(5,5,'Электрический','high','Голая плата на трубе отопления, оголённые провода','open',2,'2026-06-02 17:35:29',NULL),
(6,6,'Кабель','high','Огромный ком из кабелей под столами','open',6,'2026-06-02 17:35:29',NULL),
(7,7,'Электрический','high','Розетка без крышки за трубами воды','open',1,'2026-06-02 17:35:29',NULL),
(8,8,'Электрический','','Оголённые непромаркированные провода','open',3,'2026-06-02 17:35:29',NULL);
/*!40000 ALTER TABLE `defects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(100) DEFAULT NULL,
  `target_table` varchar(50) DEFAULT NULL,
  `target_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logs`
--

LOCK TABLES `logs` WRITE;
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
INSERT INTO `logs` VALUES
(1,1,'Вход в систему','users',1,'2026-06-01 06:00:00'),
(2,2,'Добавление','network_points',9,'2026-06-01 06:30:00'),
(3,3,'Редактирование','defects',4,'2026-06-01 07:15:00'),
(4,4,'Фиксация расхода','material_usage',1,'2026-06-01 08:00:00'),
(5,5,'Удаление','network_points',10,'2026-06-01 11:00:00'),
(6,6,'Экспорт отчёта','report',NULL,'2026-06-02 06:00:00'),
(7,1,'Закрытие дефекта','defects',1,'2026-06-02 08:00:00'),
(8,2,'Просмотр логов','logs',NULL,'2026-06-02 09:00:00');
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `material_usage`
--

DROP TABLE IF EXISTS `material_usage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `material_usage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `material_id` int(11) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `point_id` int(11) DEFAULT NULL,
  `defect_id` int(11) DEFAULT NULL,
  `used_by` int(11) NOT NULL,
  `used_at` datetime DEFAULT current_timestamp(),
  `comment` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `material_id` (`material_id`),
  KEY `point_id` (`point_id`),
  KEY `defect_id` (`defect_id`),
  KEY `used_by` (`used_by`),
  CONSTRAINT `material_usage_ibfk_1` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`),
  CONSTRAINT `material_usage_ibfk_2` FOREIGN KEY (`point_id`) REFERENCES `network_points` (`id`) ON DELETE SET NULL,
  CONSTRAINT `material_usage_ibfk_3` FOREIGN KEY (`defect_id`) REFERENCES `defects` (`id`) ON DELETE SET NULL,
  CONSTRAINT `material_usage_ibfk_4` FOREIGN KEY (`used_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `material_usage`
--

LOCK TABLES `material_usage` WRITE;
/*!40000 ALTER TABLE `material_usage` DISABLE KEYS */;
INSERT INTO `material_usage` VALUES
(15,1,25.50,3,3,2,'2026-05-31 10:00:00','Заменили повреждённый участок кабеля'),
(16,3,8.00,1,1,3,'2026-05-31 11:30:00','Переобжали концы на новые коннекторы'),
(17,4,3.00,4,4,4,'2026-06-01 09:00:00','Установили новые двойные розетки'),
(18,6,10.00,6,6,5,'2026-06-01 14:00:00','Проложили кабель-канал'),
(19,7,20.00,NULL,NULL,1,'2026-06-02 08:00:00','Закупили на склад для ремонта'),
(20,2,50.00,8,8,2,'2026-06-02 10:00:00','Проложили новый кабель cat6'),
(21,10,5.00,NULL,NULL,3,'2026-06-02 12:00:00','Патч-корды для свитча');
/*!40000 ALTER TABLE `material_usage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `materials`
--

DROP TABLE IF EXISTS `materials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `materials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `type` enum('cable','connector','socket','fastener','other') NOT NULL,
  `unit` enum('m','pcs') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `materials`
--

LOCK TABLES `materials` WRITE;
/*!40000 ALTER TABLE `materials` DISABLE KEYS */;
INSERT INTO `materials` VALUES
(1,'Кабель UTP cat5e','cable','m'),
(2,'Кабель UTP cat6','cable','m'),
(3,'Коннектор RJ45','connector','pcs'),
(4,'Розетка RJ45 двойная','socket','pcs'),
(5,'Розетка RJ45 одинарная','socket','pcs'),
(6,'Кабель-канал 20x10','fastener','m'),
(7,'Стяжки кабельные','fastener','pcs'),
(8,'Дюбель-хомуты','fastener','pcs'),
(9,'Патч-корд 0.5м','other','pcs'),
(10,'Патч-корд 1м','other','pcs'),
(11,'Изолента ПВХ','other','pcs'),
(12,'Коробка подрозетник','other','pcs');
/*!40000 ALTER TABLE `materials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `network_points`
--

DROP TABLE IF EXISTS `network_points`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_points` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(20) NOT NULL,
  `type` enum('socket','switch','cable_run','patch_cord') NOT NULL,
  `location` varchar(100) DEFAULT NULL,
  `status` enum('active','defect','decommissioned') DEFAULT 'active',
  `last_check` date DEFAULT NULL,
  `point_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image_path` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `label` (`label`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_points`
--

LOCK TABLES `network_points` WRITE;
/*!40000 ALTER TABLE `network_points` DISABLE KEYS */;
INSERT INTO `network_points` VALUES
(1,'ROOM319-1','socket','над плинтусом','defect','2026-05-30','2026-06-03 09:25:13',NULL),
(2,'ROOM319-2','socket','на полу у плинтуса','defect','2026-05-30','2026-06-03 09:25:13',NULL),
(3,'ROOM319-3','cable_run','на полу, старая розетка','defect','2026-05-30','2026-06-03 09:25:13',NULL),
(4,'ROOM319-4','socket','на стене, сломана','defect','2026-05-30','2026-06-03 09:25:13',NULL),
(5,'ROOM319-5','socket','на трубе отопления','defect','2026-05-30','2026-06-03 09:25:13',NULL),
(6,'ROOM319-6','cable_run','под столами, куча кабелей','defect','2026-05-30','2026-06-03 09:25:13',NULL),
(7,'ROOM319-7','socket','за трубами воды','defect','2026-05-30','2026-06-03 09:25:13',NULL),
(8,'ROOM319-8','cable_run','оголённые провода','defect','2026-05-30','2026-06-03 09:25:13',NULL);
/*!40000 ALTER TABLE `network_points` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','operator') DEFAULT 'operator',
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,'nikita','2213125345343','admin'),
(2,'kirill','3543534534','operator'),
(3,'timur','342432432432','operator'),
(4,'yaroslav','324433443','operator'),
(5,'vladislava','32424432','operator'),
(6,'almira','3432432423432','operator'),
(7,'ilya','6546456','operator'),
(8,'test','$2y$12$5BBAwnFgF9u/g9.q0iwVruk8hE9vJl/cezVG9ZYi17cDAcLBFPYt2','operator');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-06-03 14:52:22
