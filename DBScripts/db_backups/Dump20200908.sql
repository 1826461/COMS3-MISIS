CREATE DATABASE IF NOT EXISTS `coms3-misis` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `coms3-misis`;
-- MySQL dump 10.13  Distrib 8.0.20, for Win64 (x86_64)
--
-- Host: localhost    Database: coms3-misis
-- ------------------------------------------------------
-- Server version	8.0.20

/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE = @@TIME_ZONE */;
/*!40103 SET TIME_ZONE = '+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS = @@UNIQUE_CHECKS, UNIQUE_CHECKS = 0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS = 0 */;
/*!40101 SET @OLD_SQL_MODE = @@SQL_MODE, SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES = @@SQL_NOTES, SQL_NOTES = 0 */;

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `courses`
(
    `unitCode`      varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
    `courseID`      int                                                               DEFAULT NULL,
    `courseName`    varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci      DEFAULT NULL,
    `syncFrequency` int                                                               DEFAULT NULL,
    `updatedOn`     timestamp                                                    NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY `unitCode_UNIQUE` (`unitCode`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courses`
--

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses`
    DISABLE KEYS */;
/*!40000 ALTER TABLE `courses`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enrollments`
--

DROP TABLE IF EXISTS `enrollments`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `enrollments`
(
    `id`           int         NOT NULL AUTO_INCREMENT,
    `studentNo`    int         NOT NULL,
    `name`         varchar(45) NOT NULL,
    `surname`      varchar(45) NOT NULL,
    `subject`      varchar(45) NOT NULL,
    `unitCode`     varchar(45) NOT NULL,
    `session`      varchar(3)  NOT NULL,
    `classSection` varchar(1)  NOT NULL,
    `expiryDate`   datetime    NOT NULL,
    `status`       varchar(45) DEFAULT 'ENROLLED',
    `courseId`     int         DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 5
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enrollments`
--

LOCK TABLES `enrollments` WRITE;
/*!40000 ALTER TABLE `enrollments`
    DISABLE KEYS */;
/*!40000 ALTER TABLE `enrollments`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enrollments_temp`
--

DROP TABLE IF EXISTS `enrollments_temp`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `enrollments_temp`
(
    `id`           int         NOT NULL AUTO_INCREMENT,
    `studentNo`    int         NOT NULL,
    `name`         varchar(45) NOT NULL,
    `surname`      varchar(45) NOT NULL,
    `subject`      varchar(45) NOT NULL,
    `unitCode`     varchar(45) NOT NULL,
    `session`      varchar(3)  NOT NULL,
    `classSection` varchar(1)  NOT NULL,
    `expiryDate`   datetime    NOT NULL,
    `status`       varchar(45) DEFAULT 'ENROLLED',
    `courseId`     int         DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 2
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enrollments_temp`
--

LOCK TABLES `enrollments_temp` WRITE;
/*!40000 ALTER TABLE `enrollments_temp`
    DISABLE KEYS */;
INSERT INTO `enrollments_temp`
VALUES (1, 2420030, 'Elijah', 'Akintade', 'COMS', 'COMS1017', 'SM2', 'A', '2020-12-31 00:00:00', 'ENROLLED', 0);
/*!40000 ALTER TABLE `enrollments_temp`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users`
(
    `userID`   varchar(45)  NOT NULL,
    `password` varchar(100) NOT NULL,
    `role`     varchar(45)  NOT NULL,
    PRIMARY KEY (`userID`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users`
    DISABLE KEYS */;
INSERT INTO `users`
VALUES ('admin', '$2y$10$n6NlWtHmEWH04fN6JqAA5eDKVwA8MAFHNGYVN45GVqdU82kmeKt9e', 'admin'),
       ('steve', '$2y$10$n6NlWtHmEWH04fN6JqAA5eDKVwA8MAFHNGYVN45GVqdU82kmeKt9e', 'user'),
       ('test', 'test', 'test');
/*!40000 ALTER TABLE `users`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'coms3-misis'
--
/*!50106 SET @save_time_zone = @@TIME_ZONE */;
/*!50106 DROP EVENT IF EXISTS `delete_old_enrollments` */;
DELIMITER ;;
/*!50003 SET @saved_cs_client = @@character_set_client */ ;;
/*!50003 SET @saved_cs_results = @@character_set_results */ ;;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;;
/*!50003 SET character_set_client = utf8mb4 */ ;;
/*!50003 SET character_set_results = utf8mb4 */ ;;
/*!50003 SET collation_connection = utf8mb4_0900_ai_ci */ ;;
/*!50003 SET @saved_sql_mode = @@sql_mode */ ;;
/*!50003 SET sql_mode = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;;
/*!50003 SET @saved_time_zone = @@time_zone */ ;;
/*!50003 SET time_zone = 'SYSTEM' */ ;;
/*!50106 CREATE */ /*!50117 DEFINER =`root`@`localhost`*/ /*!50106 EVENT `delete_old_enrollments` ON SCHEDULE EVERY 1 DAY STARTS '2020-05-28 18:44:55' ON COMPLETION NOT PRESERVE ENABLE COMMENT 'Delete enrollments from table when expiry date is reached' DO DELETE
                                                                                                                                                                                                                                                                FROM `coms3-misis`.`enrollments`
                                                                                                                                                                                                                                                                WHERE `expiryDate` < NOW() */ ;;
/*!50003 SET time_zone = @saved_time_zone */ ;;
/*!50003 SET sql_mode = @saved_sql_mode */ ;;
/*!50003 SET character_set_client = @saved_cs_client */ ;;
/*!50003 SET character_set_results = @saved_cs_results */ ;;
/*!50003 SET collation_connection = @saved_col_connection */ ;;
DELIMITER ;
/*!50106 SET TIME_ZONE = @save_time_zone */;

--
-- Dumping routines for database 'coms3-misis'
--
/*!40103 SET TIME_ZONE = @OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE = @OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS = @OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS = @OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES = @OLD_SQL_NOTES */;

-- Dump completed on 2020-09-08  1:54:43
CREATE DATABASE IF NOT EXISTS `moodle` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `moodle`;
-- MySQL dump 10.13  Distrib 8.0.20, for Win64 (x86_64)
--
-- Host: localhost    Database: moodle
-- ------------------------------------------------------
-- Server version	8.0.20

/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE = @@TIME_ZONE */;
/*!40103 SET TIME_ZONE = '+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS = @@UNIQUE_CHECKS, UNIQUE_CHECKS = 0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS = 0 */;
/*!40101 SET @OLD_SQL_MODE = @@SQL_MODE, SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES = @@SQL_NOTES, SQL_NOTES = 0 */;

--
-- Table structure for table `mdl_course`
--

DROP TABLE IF EXISTS `mdl_course`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mdl_course`
(
    `id`                bigint                                                        NOT NULL AUTO_INCREMENT,
    `category`          bigint                                                        NOT NULL DEFAULT '0',
    `sortorder`         bigint                                                        NOT NULL DEFAULT '0',
    `fullname`          varchar(254) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `shortname`         varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `idnumber`          varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `summary`           longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    `summaryformat`     tinyint                                                       NOT NULL DEFAULT '0',
    `format`            varchar(21) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  NOT NULL DEFAULT 'topics',
    `showgrades`        tinyint                                                       NOT NULL DEFAULT '1',
    `newsitems`         mediumint                                                     NOT NULL DEFAULT '1',
    `startdate`         bigint                                                        NOT NULL DEFAULT '0',
    `enddate`           bigint                                                        NOT NULL DEFAULT '0',
    `relativedatesmode` tinyint(1)                                                    NOT NULL DEFAULT '0',
    `marker`            bigint                                                        NOT NULL DEFAULT '0',
    `maxbytes`          bigint                                                        NOT NULL DEFAULT '0',
    `legacyfiles`       smallint                                                      NOT NULL DEFAULT '0',
    `showreports`       smallint                                                      NOT NULL DEFAULT '0',
    `visible`           tinyint(1)                                                    NOT NULL DEFAULT '1',
    `visibleold`        tinyint(1)                                                    NOT NULL DEFAULT '1',
    `groupmode`         smallint                                                      NOT NULL DEFAULT '0',
    `groupmodeforce`    smallint                                                      NOT NULL DEFAULT '0',
    `defaultgroupingid` bigint                                                        NOT NULL DEFAULT '0',
    `lang`              varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  NOT NULL DEFAULT '',
    `calendartype`      varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  NOT NULL DEFAULT '',
    `theme`             varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  NOT NULL DEFAULT '',
    `timecreated`       bigint                                                        NOT NULL DEFAULT '0',
    `timemodified`      bigint                                                        NOT NULL DEFAULT '0',
    `requested`         tinyint(1)                                                    NOT NULL DEFAULT '0',
    `enablecompletion`  tinyint(1)                                                    NOT NULL DEFAULT '0',
    `completionnotify`  tinyint(1)                                                    NOT NULL DEFAULT '0',
    `cacherev`          bigint                                                        NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY `mdl_cour_cat_ix` (`category`),
    KEY `mdl_cour_idn_ix` (`idnumber`),
    KEY `mdl_cour_sho_ix` (`shortname`),
    KEY `mdl_cour_sor_ix` (`sortorder`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 10
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci
  ROW_FORMAT = COMPRESSED COMMENT ='Central course table';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mdl_course`
--

LOCK TABLES `mdl_course` WRITE;
/*!40000 ALTER TABLE `mdl_course`
    DISABLE KEYS */;
INSERT INTO `mdl_course`
VALUES (1, 0, 1, 'COMS3-MISIS Test Site', 'COMS3-MISIS', '',
        'Moodle automatic enrollment plug-in test demo site for Outsourced Development @ Wits', 0, 'site', 1, 3, 0, 0,
        0, 0, 0, 0, 0, 1, 1, 0, 0, 0, '', '', '', 1590534128, 1590535051, 0, 0, 0, 1590534534),
       (3, 4, 20005, 'COMS3005A - Advanced Analysis of Algorithms - 2020', 'COMS3005A', '', '', 1, 'topics', 1, 5,
        1595455200, 1626991200, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, '', '', '', 1595444947, 1595444947, 0, 1, 0, 1595444955),
       (4, 4, 20004, 'COMS3010A - Operating Systems - 2020', 'COMS3010A', '', '', 1, 'topics', 1, 5, 1595455200,
        1626991200, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, '', '', '', 1595444970, 1595444970, 0, 1, 0, 1595444977),
       (5, 4, 20003, 'COMS3011A - Software Design Project - 2020', 'COMS3011A', '', '', 1, 'topics', 1, 5, 1595455200,
        1626991200, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, '', '', '', 1595445022, 1595445022, 0, 1, 0, 1595445030),
       (6, 4, 20002, 'COMS1016A/COMS1020A - Discrete Computational Structures - 2020', 'COMS1016A', '', '', 1, 'topics',
        1, 5, 1595455200, 1626991200, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, '', '', '', 1595445041, 1595445041, 0, 1, 0,
        1595445049),
       (7, 4, 20001, 'COMS1017A/COMS1021A - Introduction to Data Structures and Algorithms - 2020', 'COMS1017A', '', '',
        1, 'topics', 1, 5, 1595455200, 1626991200, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, '', '', '', 1595445109, 1595445109, 0,
        1, 0, 1595445116),
       (8, 5, 30002, 'APPM1006A/APPM1025A - Mathematical Modelling - 2020', 'APPM1006A', '', '', 1, 'topics', 1, 5,
        1595455200, 1626991200, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, '', '', '', 1595445138, 1595445195, 0, 1, 0, 1595445196),
       (9, 5, 30001, 'APPM2007A-Numerics-2020', 'APPM2007A', '', '', 1, 'topics', 1, 5, 1595455200, 1626991200, 0, 0, 0,
        0, 0, 1, 1, 0, 0, 0, '', '', '', 1595445157, 1595445206, 0, 1, 0, 1595445207);
/*!40000 ALTER TABLE `mdl_course`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mdl_course_categories`
--

DROP TABLE IF EXISTS `mdl_course_categories`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mdl_course_categories`
(
    `id`                bigint                                                        NOT NULL AUTO_INCREMENT,
    `name`              varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `idnumber`          varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci          DEFAULT NULL,
    `description`       longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    `descriptionformat` tinyint                                                       NOT NULL DEFAULT '0',
    `parent`            bigint                                                        NOT NULL DEFAULT '0',
    `sortorder`         bigint                                                        NOT NULL DEFAULT '0',
    `coursecount`       bigint                                                        NOT NULL DEFAULT '0',
    `visible`           tinyint(1)                                                    NOT NULL DEFAULT '1',
    `visibleold`        tinyint(1)                                                    NOT NULL DEFAULT '1',
    `timemodified`      bigint                                                        NOT NULL DEFAULT '0',
    `depth`             bigint                                                        NOT NULL DEFAULT '0',
    `path`              varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `theme`             varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci           DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `mdl_courcate_par_ix` (`parent`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 6
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci
  ROW_FORMAT = COMPRESSED COMMENT ='Course categories';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mdl_course_categories`
--

LOCK TABLES `mdl_course_categories` WRITE;
/*!40000 ALTER TABLE `mdl_course_categories`
    DISABLE KEYS */;
INSERT INTO `mdl_course_categories`
VALUES (3, '2020', '', '', 1, 0, 10000, 0, 1, 1, 1595444800, 1, '/3', NULL),
       (4, 'Computer Science', '', '', 1, 3, 20000, 5, 1, 1, 1595444819, 2, '/3/4', NULL),
       (5, 'Applied Mathematics', '', '', 1, 3, 30000, 2, 1, 1, 1595444831, 2, '/3/5', NULL);
/*!40000 ALTER TABLE `mdl_course_categories`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'moodle'
--

--
-- Dumping routines for database 'moodle'
--
/*!40103 SET TIME_ZONE = @OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE = @OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS = @OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS = @OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES = @OLD_SQL_NOTES */;

-- Dump completed on 2020-09-08  1:54:43
