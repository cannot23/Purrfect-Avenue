-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: localhost    Database: purrfect
-- ------------------------------------------------------
-- Server version	8.4.0

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
  `user_id` int NOT NULL AUTO_INCREMENT,
  `firstName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `lastName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_admin` tinyint NOT NULL DEFAULT '0',
  `contact_num` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES 
(8,'Admin','Admin','admin@purrfect.com','$2y$10$6ca7CKNyVtuhYS/o0l828.fVAj6hucy8GhrFT0hsvvE5oP0Is4Aiq',1,'09999999999','Admin Corp'),
(9,'Client','Client','client@purrfect.com','$2y$10$J0gNqjDxxaPTqUB3qS8E9ePNS0O7HnO2QuWniYthf4Ts5mdH4sDrO',0,'0999999992','Client Corp'),
(11, 'John', 'Doe', 'John.Doe@gmail.com', '$2y$10$asYKic50CGMRNwmunEmKRu1FimFWYMsbkrrtYgQGnjAK1LLXiV3SK', 0, '09453474323', 'Manila, Philippines'),
(12, 'Admin', 'Purrfect', 'admin@purffect.com', '$2y$10$muJejHqPGc.1mCHVlhN78uYcTNqaR0FApoDQN6ZH4xIOATEtK9cOq', 1, '09346731457', 'Bulacan, Philippines'),
(13, 'Avery', 'Mitchell', 'AveryMitchell@gmail.com', '$2y$10$PO8gSd7S3Vkvr3szOxMD5ufgMjiEDc02DWNeM2xl0IoYptv./7KQW', 0, '09234761345', 'Cavite, Philippines'),
(14, 'Jordan', 'Bennett', 'Jordan@gmail.com', '$2y$10$piptlcAvMyk6HNCjurtX0.gWaEcCGN8TWGTrPoyeBOQ7HM1KZqJ0q', 0, '09234326714', 'Quezon City, Philippines'),
(15, 'Liam', 'Anderson', 'Liam@gmail.com', '$2y$10$J7iR9LcI1Hb/7ZF4lBkGI.kAtJ11L4nhyX9l/uB9CkhcVsvmm/ruC', 0, '09432353417', 'Mandaluyong City, Philippines');
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

-- Dump completed on 2024-07-07  4:08:34
