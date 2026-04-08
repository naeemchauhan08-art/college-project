-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: sgj_library_db
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `sgj_library_db`
--

/*!40000 DROP DATABASE IF EXISTS `sgj_library_db`*/;

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `sgj_library_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;

USE `sgj_library_db`;

--
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `publisher` varchar(255) DEFAULT NULL,
  `accession_no` varchar(100) DEFAULT NULL,
  `copies` int(11) NOT NULL DEFAULT 1,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `accession_no` (`accession_no`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `books`
--

LOCK TABLES `books` WRITE;
/*!40000 ALTER TABLE `books` DISABLE KEYS */;
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (1,'MARKETING RESEARCH','A PARSHURAMAN, DHRUV GREWAL, R KRISHANAN','BIZTANTRA PUBLICATION','705',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (2,'MARKETING RESEARCH','A PARSHURAMAN, DHRUV GREWAL, R KRISHANAN','BIZTANTRA PUBLICATION','683',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (3,'MARKETING IN PUBLIC SECTOR','PHILIP KETLER, NANCY LEE','WHATSON SCHOOL PUBLISHING','1210',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (4,'THE HANDBOOK FOR MEDIA HANDLING','JOHN CLARE','INFINITY  BOOKS','117',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (5,'THE HANDBOOK FOR MEDIA HANDLING','JOHN CLARE','INFINITY  BOOKS','178',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (6,'RURAL MARKETING ENVIRONMENT, PROBLEMS AND STRATEGIES','T P GOPALASWAMY','VIKAS PUBLISHING HOUSE','663',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (7,'RURAL MARKETING ENVIRONMENT, PROBLEMS AND STRATEGIES','T P GOPALASWAMY','VIKAS PUBLISHING HOUSE','650',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (8,'RURAL MARKETING ENVIRONMENT, PROBLEMS AND STRATEGIES','T P GOPALASWAMY','VIKAS PUBLISHING HOUSE','686',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (9,'MARKETING TOOL KIT AN ENCYCLOPIDIA OF FRESH AND TESTED IDEAS','NICK ROBINSON','JAICO PUBLISHING HOUSE','692',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (10,'MARKETING IN PUBLIC SECTOR','PHILIP KETLER, NANCY LEE','WHATSON SCHOOL PUBLISHING','43',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (11,'FOUNDATIONS OF MARKETING','DAVID JOBBER, JOHN FAHY','TATA MCGRAW HILL','633',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (12,'FOUNDATIONS OF MARKETING','DAVID JOBBER, JOHN FAHY','TATA MCGRAW HILL','699',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (13,'DIRECT MARKETING','ROBERT MCCOY','JAICO PUBLISHING HOUSE','647',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (14,'DIRECT MARKETING','ROBERT MCCOY','JAICO PUBLISHING HOUSE','648',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (15,'RURAL MARKETING ENVIRONMENT, PROBLEMS AND STRATEGIES','T P GOPALASWAMY','VIKAS PUBLISHING HOUSE','1206',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (16,'MARKETING RESEARCH','G C BERI','TATA MCGRAW HILL','684',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (17,'MARKETING RESEARCH','G C BERI','TATA MCGRAW HILL','Z2170',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (18,'MANAGING INDIAN BRANDS','S RAMESH KUMAR','VIKAS PUBLISHING HOUSE','725',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (19,'MANAGING INDIAN BRANDS','S RAMESH KUMAR','VIKAS PUBLISHING HOUSE','1138',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (20,'MANAGING INDIAN BRANDS','S RAMESH KUMAR','VIKAS PUBLISHING HOUSE','1085',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (21,'RURAL MARKETING CONCEPTS AND PRACTICES','BALRAM DOGRA, KARMINDER GHUMAN','TATA MCGRAW HILL','1201',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (22,'RURAL MARKETING CONCEPTS AND PRACTICES','BALRAM DOGRA, KARMINDER GHUMAN','TATA MCGRAW HILL','1192',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (23,'RURAL AND AGRICULTURAL MARKETING INCLUDES CASE STUDIES','RAMKISHEN Y','JAICO PUBLISHING HOUSE','693',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (24,'RURAL AND AGRICULTURAL MARKETING INCLUDES CASE STUDIES','RAMKISHEN Y','JAICO PUBLISHING HOUSE','694',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (25,'RURAL AND AGRICULTURAL MARKETING INCLUDES CASE STUDIES','RAMKISHEN Y','JAICO PUBLISHING HOUSE','Z3033',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (26,'MARKETING CHANNELS','ANNET CONGHLAM, ERIN ANDREVAN, LOUIS STERN, ADEL','PEARSON EDUCATION','680',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (27,'MARKETING MANAGEMENT','RAMASWAMY, NAMAKUMARI','MACMILLAN EDUCATION','587',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (28,'MARKETING MANAGEMENT','RAMASWAMY, NAMAKUMARI','MACMILLAN EDUCATION','536',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (29,'MARKETING MANAGEMENT','SAXENA','TATA MCGRAW HILL','Z3005',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (30,'Strategic Management: Concepts and Cases: Competitiveness and Globalization','Michael A. Hitt, R. Duane Ireland, Robert E. Hoskisson, Jeffrey S. Harrison','cengage education','1163',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (31,'MARKETING','KERIEN, HARTLY, RUDELIUS','MCGRAW HILL','688',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (32,'MARKETING','KERIEN, HARTLY, RUDELIUS','MCGRAW HILL','Z3009',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (33,'MARKETING','KERIEN, HARTLY, RUDELIUS','MCGRAW HILL','687',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (34,'INTRODUCTION TO MARKETING','ADRIAN PALMER','OXFORD','Z3010',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (35,'INDUSTRIAL MARKETING MANAGEMENT','M GOVINDRAJAN','VIKAS PUBLISHING HOUSE','643',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (36,'INDUSTRIAL MARKETING MANAGEMENT','M GOVINDRAJAN','VIKAS PUBLISHING HOUSE','696',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (37,'RETAILING MANAGEMENT','SWAPNA PRADHAN','MCGRAW HILL','2266',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (38,'Rural Marketing: Text and Cases','C. S. G. Krishnamacharyulu ,Lalitha Ramakrishnan','PEARSON EDUCATION','1187',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (39,'Rural Marketing: Text and Cases','C. S. G. Krishnamacharyulu ,Lalitha Ramakrishnan','PEARSON EDUCATION','1213',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (40,'MARKETING CONSEPTS AND CASES','PRIDE FERREL','BIZTANTRA PUBLICATION','652',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (41,'MARKETING MANAGEMENT','SAROJKUMAR, NEERAJ TRIPATHI','','Z2216',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (42,'CONTEMPORARY INDIAN CASES IN MARKETING','MUKESH PANDEY','BIZTANTRA PUBLICATION','603',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (43,'MULTIMEDIA MAKING IT WORK','TAY VAUGHAN','MCGRAW HILL','243',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (44,'MULTIMEDIA MAKING IT WORK','TAY VAUGHAN','MCGRAW HILL','Z2182',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (45,'MULTIMEDIA MAKING IT WORK','TAY VAUGHAN','MCGRAW HILL','Z2181',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (46,'MARKETING','JOEL EVANS, BARRY BERMAN','BIZTANTRA PUBLICATION','668',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (47,'MARKETING','JOEL EVANS, BARRY BERMAN','BIZTANTRA PUBLICATION','672',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (48,'MARKETING','JOEL EVANS, BARRY BERMAN','BIZTANTRA PUBLICATION','671',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (49,'GLOBAL MARKETING MANAGEMENT','WARREN J KEEGAN','PEARSON EDUCATION','Z3000',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (50,'GLOBAL MARKETING MANAGEMENT','WARREN J KEEGAN','PEARSON EDUCATION','Z3001',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (51,'GLOBAL MARKETING MANAGEMENT','WARREN J KEEGAN','PEARSON EDUCATION','Z3002',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (52,'MARKETING','Michael J. Etzel, Bruce J. Walker, William J. Stanton','MCGRAW HILL','1196',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (53,'MARKETING','Michael J. Etzel, Bruce J. Walker, William J. Stanton','MCGRAW HILL','Z3003',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (54,'MARKETING RESEARCH','NARESH MALHOTRA','PEARSON EDUCATION','658',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (55,'MARKETING RESEARCH','NARESH MALHOTRA','PEARSON EDUCATION','679',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (56,'MARKETING RESEARCH','NARESH MALHOTRA','PEARSON EDUCATION','Z3004',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (57,'MARKETING RESEARCH','NARESH MALHOTRA','PEARSON EDUCATION','1117',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (58,'RURAL MARKETING','PRADEEP KASHYAP','PEARSON EDUCATION','Z2235',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (59,'RURAL MARKETING','PRADEEP KASHYAP','PEARSON EDUCATION','Z2236',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (60,'MARKETING RESEARCH','ALVIN BURNS, RONALD BUSH','PEARSON EDUCATION','657',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (62,'INTERNATIONAL MARKETING','DANA NICOLETA LASCU','BIZTANTRA PUBLICATION','Z2211',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (63,'INTERNATIONAL MARKETING','DANA NICOLETA LASCU','BIZTANTRA PUBLICATION','660',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (64,'INTERNATIONAL MARKETING','DANA NICOLETA LASCU','BIZTANTRA PUBLICATION','664',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (65,'SERVICES MARKETING','CHRISTOPHER LOVELOCK, JOCHEN WIRTZ, JAYANTEE CHATTERJEE','PEARSON EDUCATION','Z1114',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (66,'SERVICES MARKETING','CHRISTOPHER LOVELOCK, JOCHEN WIRTZ, JAYANTEE CHATTERJEE','PEARSON EDUCATION','2281',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (67,'SERVICES MARKETING','CHRISTOPHER LOVELOCK, JOCHEN WIRTZ, JAYANTEE CHATTERJEE','PEARSON EDUCATION','2375',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (68,'INTERNATIONAL MARKETING','RAJAGOPAL','VIKAS PUBLISHING HOUSE','667',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (69,'INTERNATIONAL MARKETING','RAJAGOPAL','VIKAS PUBLISHING HOUSE','Z3007',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (70,'INTERNATIONAL MARKETING','Michael Czinkota, Ilkka Ronkainen, Annie Cui','cengage education','1046',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (71,'STRATEGIC MARKETING','CAROL H ANDERSON, JALIAN W VINCZE','BIZTANTRA PUBLICATION','Z2215',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (72,'STRATEGIC MARKETING','CAROL H ANDERSON, JALIAN W VINCZE','BIZTANTRA PUBLICATION','710',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (73,'STRATEGIC MARKETING','CAROL H ANDERSON, JALIAN W VINCZE','BIZTANTRA PUBLICATION','Z2171',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (74,'INTERNATIONAL MARKETING','ONKVISIT, SHAW','PEARSON EDUCATION','677',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (75,'INTERNATIONAL MARKETING','ONKVISIT, SHAW','PEARSON EDUCATION','676',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (76,'INTERNATIONAL MARKETING','ONKVISIT, SHAW','PEARSON EDUCATION','673',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (77,'INTERNATIONAL MARKETING','ONKVISIT, SHAW','PEARSON EDUCATION','681',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (78,'INTERNATIONAL MARKETING','CATEORA GRAHAM','TATA MCGRAW HILL','Z3006',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (80,'BUSINESS ENVIRONMENT TEXT AND CASES','FRANCIS CHERUNILAM','HIMALAYA PUBLISHING HOUSE','393',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (81,'BUSINESS ENVIRONMENT TEXT AND CASES','FRANCIS CHERUNILAM','HIMALAYA PUBLISHING HOUSE','391',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (82,'BUSINESS ENVIRONMENT TEXT AND CASES','FRANCIS CHERUNILAM','HIMALAYA PUBLISHING HOUSE','392',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (83,'BUSINESS ENVIRONMENT TEXT AND CASES','FRANCIS CHERUNILAM','HIMALAYA PUBLISHING HOUSE','390',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (84,'BUSINESS PROCESS OUTSOURCING','SARIKA KULKARNI','JAICO PUBLISHING HOUSE','28',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (85,'BUSINESS PROCESS OUTSOURCING','SARIKA KULKARNI','JAICO PUBLISHING HOUSE','27',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (86,'BUSINESS PROCESS OUTSOURCING','SARIKA KULKARNI','JAICO PUBLISHING HOUSE','25',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (87,'BUSINESS PROCESS OUTSOURCING','SARIKA KULKARNI','JAICO PUBLISHING HOUSE','26',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (88,'BUSINESS PROCESS OUTSOURCING','SARIKA KULKARNI','JAICO PUBLISHING HOUSE','29',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (89,'E BUSINESS AND COMMERCE STRATEGIC THINKING AND PRACTICE','BRAHM CANZER','BIZTANTRA PUBLICATION','909',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (90,'E BUSINESS AND COMMERCE STRATEGIC THINKING AND PRACTICE','BRAHM CANZER','BIZTANTRA PUBLICATION','815',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (91,'E BUSINESS AND COMMERCE STRATEGIC THINKING AND PRACTICE','BRAHM CANZER','BIZTANTRA PUBLICATION','814',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (92,'A STUDY IN BUSINESS ETHICS','RITUPARNA RAY','HIMALAYA PUBLISHING HOUSE','167',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (93,'A STUDY IN BUSINESS ETHICS','RITUPARNA RAY','HIMALAYA PUBLISHING HOUSE','165',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (94,'A STUDY IN BUSINESS ETHICS','RITUPARNA RAY','HIMALAYA PUBLISHING HOUSE','367',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (95,'A STUDY IN BUSINESS ETHICS','RITUPARNA RAY','HIMALAYA PUBLISHING HOUSE','166',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (96,'A STUDY IN BUSINESS ETHICS','RITUPARNA RAY','HIMALAYA PUBLISHING HOUSE','369',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (97,'A STUDY IN BUSINESS ETHICS','RITUPARNA RAY','HIMALAYA PUBLISHING HOUSE','365',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (98,'BUSINESS ECONOMICS','MANAB ADHIKARY','EXCEL BOOKS','1239',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (99,'BUSINESS ECONOMICS','MANAB ADHIKARY','EXCEL BOOKS','1240',1,'2026-04-02 05:35:16');
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `accession_no`, `copies`, `added_at`) VALUES (100,'BUSINESS ENVIRONMENT TEXT AND CASES','FRANCIS CHERUNILAM','HIMALAYA PUBLISHING HOUSE','2108',1,'2026-04-02 05:35:16');
/*!40000 ALTER TABLE `books` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `borrow_records`
--

DROP TABLE IF EXISTS `borrow_records`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `borrow_records` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `issued_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `due_on` timestamp NULL DEFAULT NULL,
  `returned_on` timestamp NULL DEFAULT NULL,
  `status` enum('Issued','Returned') NOT NULL DEFAULT 'Issued',
  PRIMARY KEY (`id`),
  KEY `fk_rec_user` (`user_id`),
  KEY `fk_rec_book` (`book_id`),
  CONSTRAINT `fk_rec_book` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_rec_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `borrow_records`
--

LOCK TABLES `borrow_records` WRITE;
/*!40000 ALTER TABLE `borrow_records` DISABLE KEYS */;
/*!40000 ALTER TABLE `borrow_records` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `borrow_requests`
--

DROP TABLE IF EXISTS `borrow_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `borrow_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `copies_requested` int(11) NOT NULL DEFAULT 1,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `requested_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_br_user` (`user_id`),
  KEY `fk_br_book` (`book_id`),
  CONSTRAINT `fk_br_book` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_br_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `borrow_requests`
--

LOCK TABLES `borrow_requests` WRITE;
/*!40000 ALTER TABLE `borrow_requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `borrow_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `status` enum('pending','completed') NOT NULL DEFAULT 'pending',
  `temp_password_shown` varchar(255) DEFAULT NULL,
  `request_date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_pr_user` (`user_id`),
  CONSTRAINT `fk_pr_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
INSERT INTO `password_resets` (`id`, `user_id`, `status`, `temp_password_shown`, `request_date`) VALUES (1,4,'completed','jR8GwcZk','2026-04-02 05:22:30');
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','Student') NOT NULL DEFAULT 'Student',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES (1,'Admin','admin@gmail.com','$2y$10$zxqQUqVztc6BfpQ.fE34RejZHHM2FM3qqmyNTdI7HWB/fpgwQx3QS','Admin','2026-04-02 05:22:02');
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES (2,'Admin','admin@sgjlibrary.com','$2y$10$/ZAxWlCbU/FSXcstyZ8.J.J1bUv2zE4l3keDe4GwGBKPK5KDtvw3K','Admin','2026-04-02 05:22:02');
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES (3,'Head Librarian','admin@library.com','$2y$10$u/NHMKHuCAabKw4vZOWiMevPBEAF7l2r9fcQNj/zHTTtNQqcAkIwC','Admin','2026-04-02 05:22:02');
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES (4,'naeem','perplexity70@gmail.com','$2y$10$3QRnDfg0ebP3FEYxgMthsOHlw37XhibXSV30wj7mOJHfx0iO3.9tS','Student','2026-04-02 05:22:02');
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES (5,'Demo Student','student@example.com','$2y$10$bhbmaQCOPJOzf2tH/BAy6.T5GSqLyhVxlAiRWESDlobCxTM.SSlpa','Student','2026-04-02 05:22:02');
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES (6,'John Student','student@library.com','$2y$10$6zn8987gcpxcSe5hC5S4.ebjTyaqzVkx0jffsIyi.W52Ef.YCFKHe','Student','2026-04-02 05:22:02');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'sgj_library_db'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-04-02 11:05:53
