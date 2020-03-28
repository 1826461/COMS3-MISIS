-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: coms3project
-- ------------------------------------------------------
-- Server version	8.0.19

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `userID` int NOT NULL,
  `studentNo` int NOT NULL,
  `name` varchar(45) NOT NULL,
  `surname` varchar(45) NOT NULL,
  `subject` varchar(45) NOT NULL,
  `classSection` varchar(1) NOT NULL,
  `expiryDate` datetime NOT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,1865981,'John','Ward','COMS1015A','A','2020-06-30 00:00:00'),(2,1885981,'Troy',' Ingram','COMS3003A','B','2020-06-30 00:00:00'),(3,1965854,'Michael','Gonzales','COMS1018A','C','2020-06-30 00:00:00'),(4,1835635,'Sam','Gomez','COMS4004A','D','2020-06-30 00:00:00'),(5,2000000,'Paul','Kruger','COMS1015A','E','2020-06-30 00:00:00'),(6,2015010,'Pieter','Tharatt','COMS1015A','A','2020-06-30 00:00:00'),(7,985748,'Xolani','Zulu','COMS3003A','B','2020-06-30 00:00:00'),(8,1654789,'Sarah','May','COMS1018A','C','2020-06-30 00:00:00'),(9,653235,'Steve','James','COMS4004A','D','2020-06-30 00:00:00'),(10,782229,'Richard','May','COMS1015A','E','2020-06-30 00:00:00'),(11,1325875,'Pravesh','Moodley','COMS1015A','A','2020-06-30 00:00:00'),(12,895623,'Ritesh','Naaidoo','COMS3003A','B','2020-06-30 00:00:00'),(13,898562,'Benji','Franklin','COMS1018A','C','2020-06-30 00:00:00'),(14,1886523,'Charlie','Shean','COMS4004A','D','2020-06-30 00:00:00'),(15,1458754,'Tumi','Ramphele','COMS1015A','E','2020-06-30 00:00:00'),(16,1686869,'Saul','Nigurez','COMS1015A','A','2020-06-30 00:00:00'),(17,658956,'Mitchel','Messi','COMS3003A','B','2020-06-30 00:00:00'),(18,989986,'Tristen','Ronaldo','COMS1018A','C','2020-06-30 00:00:00'),(19,1879895,'Samuel','Van Djik','COMS4004A','D','2020-06-30 00:00:00');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-03-28 16:57:02
