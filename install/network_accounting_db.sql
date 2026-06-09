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
-- Table structure for table `defect_category`
--

DROP TABLE IF EXISTS `defect_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `defect_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `defect_category`
--

LOCK TABLES `defect_category` WRITE;
/*!40000 ALTER TABLE `defect_category` DISABLE KEYS */;
INSERT INTO `defect_category` VALUES
(24,'physical_damage','Физическое повреждение'),
(25,'connection_issue','Проблема с соединением'),
(26,'signal_loss','Потеря сигнала'),
(27,'power_issue','Проблема питания'),
(28,'labeling_error','Ошибка маркировки'),
(29,'other','Другое');
/*!40000 ALTER TABLE `defect_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `defects`
--

DROP TABLE IF EXISTS `defects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `defects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `point_id` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `severity` enum('high','medium','low') DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` enum('open','in_progress','closed') DEFAULT 'open',
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `image_name` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `point_id` (`point_id`),
  KEY `created_by` (`created_by`),
  KEY `fk_defects_category` (`category`),
  CONSTRAINT `defects_ibfk_1` FOREIGN KEY (`point_id`) REFERENCES `network_points` (`id`) ON DELETE CASCADE,
  CONSTRAINT `defects_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_defects_category` FOREIGN KEY (`category`) REFERENCES `defect_category` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `defects`
--

LOCK TABLES `defects` WRITE;
/*!40000 ALTER TABLE `defects` DISABLE KEYS */;
INSERT INTO `defects` VALUES
(50,30,24,'high','Дефект на существующей точке','in_progress',51,'2026-05-11 06:00:00','defect_30.jpg'),
(51,72,25,'medium','При подключении нет сигнала','open',52,'2026-05-13 11:30:00',NULL),
(52,73,24,'high','Треснул корпус розетки','in_progress',53,'2026-05-12 07:15:00','defect_32.jpg'),
(53,76,24,'high','Кабель перебит','closed',54,'2026-05-02 08:15:00','cable_broken.jpg'),
(54,80,27,'high','Порт PoE не подаёт питание','in_progress',56,'2026-06-01 05:30:00',NULL),
(55,81,25,'medium','Коннектор плохо фиксируется','open',57,'2026-06-01 06:45:00',NULL),
(56,74,24,'low','Слабое крепление розетки','open',58,'2026-05-26 13:20:00',NULL),
(57,79,25,'high','Полное отсутствие соединения','closed',59,'2026-05-31 09:00:00',NULL),
(58,86,26,'medium','Затухание сигнала выше нормы','in_progress',51,'2026-06-02 10:00:00','fiber_loss.jpg');
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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
(8,2,'Просмотр логов','logs',NULL,'2026-06-02 09:00:00'),
(9,14,'Регистрация нового пользователя (роль: operator)','users',14,'2026-06-04 11:26:19'),
(10,14,'Вход в систему (роль: admin)','users',14,'2026-06-04 11:27:08'),
(11,14,'Вход в систему (роль: admin)','users',14,'2026-06-04 11:28:01'),
(12,14,'Вход в систему (роль: admin)','users',14,'2026-06-04 12:18:14'),
(13,14,'Вход в систему (роль: admin)','users',14,'2026-06-04 14:04:47'),
(14,14,'Вход в систему (роль: admin)','users',14,'2026-06-04 15:45:29'),
(15,51,'Создание сетевой точки','network_points',72,'2026-05-10 06:00:00'),
(16,52,'Изменение статуса дефекта','defects',51,'2026-05-13 12:00:00');
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `material_type`
--

DROP TABLE IF EXISTS `material_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `material_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `material_type`
--

LOCK TABLES `material_type` WRITE;
/*!40000 ALTER TABLE `material_type` DISABLE KEYS */;
INSERT INTO `material_type` VALUES
(13,'connector','Коннектор'),
(14,'cable_accessory','Кабельная арматура'),
(15,'tool','Инструмент');
/*!40000 ALTER TABLE `material_type` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `material_usage`
--

LOCK TABLES `material_usage` WRITE;
/*!40000 ALTER TABLE `material_usage` DISABLE KEYS */;
INSERT INTO `material_usage` VALUES
(22,97,4.00,73,NULL,52,'2026-05-14 09:30:00','Обжим коннекторов');
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
  `type` int(11) NOT NULL,
  `unit` enum('m','pcs') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_material_type` (`type`),
  CONSTRAINT `fk_material_type` FOREIGN KEY (`type`) REFERENCES `material_type` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `materials`
--

LOCK TABLES `materials` WRITE;
/*!40000 ALTER TABLE `materials` DISABLE KEYS */;
INSERT INTO `materials` VALUES
(97,'RJ45 коннектор 8P8C',13,'pcs'),
(98,'RJ45 экранированный коннектор',13,'pcs'),
(99,'LC дуплексный коннектор',13,'pcs'),
(100,'SC коннектор',13,'pcs'),
(101,'Кабельная стяжка 100мм',14,'pcs'),
(102,'Маркировочная бирка',14,'pcs'),
(103,'Изолента ПВХ',14,'pcs'),
(104,'Клеммник 2 контакта',14,'pcs'),
(105,'Патч-панель 24 порта',14,'pcs'),
(106,'Кримпер для RJ45',15,'pcs');
/*!40000 ALTER TABLE `materials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `network_point_status`
--

DROP TABLE IF EXISTS `network_point_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_point_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_point_status`
--

LOCK TABLES `network_point_status` WRITE;
/*!40000 ALTER TABLE `network_point_status` DISABLE KEYS */;
INSERT INTO `network_point_status` VALUES
(1,'active','Активный'),
(2,'defect','Дефектный'),
(11,'in_repair','В ремонте'),
(12,'planned','Планируется');
/*!40000 ALTER TABLE `network_point_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `network_point_type`
--

DROP TABLE IF EXISTS `network_point_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_point_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_point_type`
--

LOCK TABLES `network_point_type` WRITE;
/*!40000 ALTER TABLE `network_point_type` DISABLE KEYS */;
INSERT INTO `network_point_type` VALUES
(1,'socket','Сокет'),
(2,'cabel_run','Сетевой кабель'),
(3,'path_cord','Патч-корд'),
(12,'switch_port','Порт коммутатора'),
(13,'router_port','Порт маршрутизатора');
(14,'router','Маршрутизатор');
/*!40000 ALTER TABLE `network_point_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `network_points`
--

DROP TABLE IF EXISTS `network_points`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_points` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `last_check` timestamp DEFAULT NULL DEFAULT current_timestamp(),
  `point_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image_name` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `label` (`label`),
  KEY `fk_network_points_status` (`status`),
  KEY `fk_network_points_type` (`type`),
  CONSTRAINT `fk_network_points_status` FOREIGN KEY (`status`) REFERENCES `network_point_status` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_network_points_type` FOREIGN KEY (`type`) REFERENCES `network_point_type` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_points`
--

LOCK TABLES `network_points` WRITE;
/*!40000 ALTER TABLE `network_points` DISABLE KEYS */;
INSERT INTO `network_points` VALUES
(30,'vxcvfsdfsdfsdfs',2,'fsdfsdfsd',2,NULL,'2026-06-04 15:30:05','6a219d34a36321.81004593.'),
(72,'SKT-101',1,'Кабинет 101, левая стена',1,'2026-05-10','2026-06-04 17:34:20','skt101.jpg'),
(73,'SKT-102',1,'Кабинет 102, у окна',2,'2026-05-12','2026-06-04 17:34:20',NULL),
(74,'SKT-103',1,'Кабинет 103, входная дверь',1,'2026-05-15','2026-06-04 17:34:20',NULL),
(75,'CBL-MAIN-01',2,'Магистраль 1 этаж - серверная',1,'2026-05-01','2026-06-04 17:34:20',NULL),
(76,'CBL-MAIN-02',2,'Магистраль 2 этаж - серверная',2,'2026-05-01','2026-06-04 17:34:20','defect_cable.jpg'),
(77,'PATCH-ADMIN',3,'Патч-корд админа (стол №1)',1,'2026-05-25','2026-06-04 17:34:20',NULL),
(78,'PATCH-CONF',3,'Патч-корд конференц-зала',1,'2026-05-28','2026-06-04 17:34:20',NULL),
(79,'PATCH-BROKEN',3,'Патч-корд старый (замена)',2,'2026-05-30','2026-06-04 17:34:20',NULL),
(80,'SW-PORT-1',12,'Коммутатор Cisco, порт 1',1,'2026-06-01','2026-06-04 17:34:20',NULL),
(81,'SW-PORT-2',12,'Коммутатор Cisco, порт 2',2,'2026-06-01','2026-06-04 17:34:20',NULL),
(82,'SW-PORT-3',12,'Коммутатор D-Link, порт 5',1,'2026-06-02','2026-06-04 17:34:20',NULL),
(83,'RT-LAN1',13,'Маршрутизатор MikroTik, LAN1',1,'2026-06-03','2026-06-04 17:34:20',NULL),
(84,'SKT-201',1,'Кабинет 201, проектор',1,'2026-06-01','2026-06-04 17:34:20',NULL),
(85,'SKT-202',1,'Кабинет 202, розетка за дверью',2,'2026-06-01','2026-06-04 17:34:20',NULL),
(86,'CBL-FIBER-1',2,'Оптоволокно до серверной',1,'2026-05-18','2026-06-04 17:34:20','fiber.jpg'),
(87,'CBL-FIBER-2',2,'Оптоволокно между этажами',1,'2026-05-18','2026-06-04 17:34:20',NULL),
(88,'PATCH-SWITCH',3,'Патч-корд от коммутатора к панели',1,'2026-06-04','2026-06-04 17:34:20',NULL),
(89,'RT-WAN',13,'Маршрутизатор TP-Link, WAN порт',1,'2026-06-04','2026-06-04 17:34:20',NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
(8,'test','$2y$12$5BBAwnFgF9u/g9.q0iwVruk8hE9vJl/cezVG9ZYi17cDAcLBFPYt2','operator'),
(9,'dirka','81dc9bdb52d04dc20036dbd8313ed055','operator'),
(10,'яфаавыаыв','e9510081ac30ffa83f10b68cde1cac07','operator'),
(11,'lllllllllllllllll','e9510081ac30ffa83f10b68cde1cac07','operator'),
(12,'LOGIN','4a7d1ed414474e4033ac29ccb8653d9b','operator'),
(13,'Yarik','b59c67bf196a4758191e42f76670ceba','operator'),
(14,'admin','b59c67bf196a4758191e42f76670ceba','admin'),
(51,'test_operator1','cc03e747a6afbbcbf8be7668acfebee5','operator'),
(52,'test_operator2','cc03e747a6afbbcbf8be7668acfebee5','operator'),
(53,'test_operator3','cc03e747a6afbbcbf8be7668acfebee5','operator'),
(54,'test_admin2','cc03e747a6afbbcbf8be7668acfebee5','admin'),
(55,'user_ivanov','cc03e747a6afbbcbf8be7668acfebee5','operator'),
(56,'user_petrov','cc03e747a6afbbcbf8be7668acfebee5','operator'),
(57,'user_sidorov','cc03e747a6afbbcbf8be7668acfebee5','admin'),
(58,'operator_a','cc03e747a6afbbcbf8be7668acfebee5','operator'),
(59,'operator_b','cc03e747a6afbbcbf8be7668acfebee5','operator');
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

-- Dump completed on 2026-06-05 14:12:52
