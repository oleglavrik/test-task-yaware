CREATE DATABASE  IF NOT EXISTS `acl_` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `acl_`;
-- MySQL dump 10.13  Distrib 5.5.47, for debian-linux-gnu (i686)
--
-- Host: 127.0.0.1    Database: acl_
-- ------------------------------------------------------
-- Server version	5.5.47-0ubuntu0.14.04.1

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
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `display_name` varchar(50) DEFAULT NULL,
  `password` varchar(128) NOT NULL,
  `state` smallint(5) unsigned DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,NULL,'owner@email.com',NULL,'$2y$14$rfnLYjllGWieFb6oHNkN8uO16c5pJNgCafWgI2.jLPtoxcML9piS2',NULL),(2,NULL,'admin@email.com',NULL,'$2y$14$WsNYgv.ZK7vlWyKrBdABzeGMPvQ9hgp7kpjUDqd3DKwGLT8shbLAu',NULL),(3,NULL,'employee@email.com',NULL,'$2y$14$/HnABBGywm9GV0FvE.Au/uW476NCKQjiyb11uyZXS73OWz6AG2NJu',NULL),(4,NULL,'test@email.com',NULL,'$2y$14$hfiG36JgaHHeNRriulyNVeBiEnfSCmEVSEwkTVWYHjWcsiWY/UWR6',NULL),(5,NULL,'owner-test@email.com',NULL,'$2y$14$j/QKd.GavIuKSDLwJJeOiu65yDp7PqXExqLEkzzUlahzvOA6h79Mm',NULL),(6,NULL,'admin111@admin.com',NULL,'$2y$14$ESxkBHQs.f1iz2h90nuUe.TBHjfdiFBwJZ.xlSOLGJhKwBcMi0cpG',NULL),(7,NULL,'admin1@admin.com',NULL,'$2y$14$5vD35rhIrjlAz6.dVQu7D.9HL6Ff3P0jBynr1.0OFCUc2OH./MZ2y',NULL),(8,NULL,'admin1111@admin.com',NULL,'$2y$14$URri1xXNGqkrEMXcI.Mwoej2aNGqI.euvamNv1p45Vjl7UeiA4/vq',NULL),(9,NULL,'admin23@admin.com',NULL,'$2y$14$txbM9U.4AbhUVvbEMxdpe.Kj.026TfoxyVibE6QXmVSePr1o1Bl06',NULL),(10,NULL,'admi11111111n@admin.com',NULL,'$2y$14$.Woy9DRR6JRNNy6bbED5uulUXz6onGO8xQT1bL56Qj8g.GgU57DMO',NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_role`
--

DROP TABLE IF EXISTS `user_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `roleId` varchar(255) NOT NULL,
  `is_default` tinyint(1) NOT NULL,
  `parent_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_role`
--

LOCK TABLES `user_role` WRITE;
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;
INSERT INTO `user_role` VALUES (1,'guest',1,NULL),(2,'owner',0,''),(3,'admin',0,NULL),(4,'employee',0,NULL);
/*!40000 ALTER TABLE `user_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_role_linker`
--

DROP TABLE IF EXISTS `user_role_linker`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_role_linker` (
  `user_id` int(11) unsigned NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_role_linker`
--

LOCK TABLES `user_role_linker` WRITE;
/*!40000 ALTER TABLE `user_role_linker` DISABLE KEYS */;
INSERT INTO `user_role_linker` VALUES (1,2),(5,2),(2,3),(4,3),(6,3),(7,3),(8,3),(9,3),(10,3),(3,4);
/*!40000 ALTER TABLE `user_role_linker` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-02-08 20:46:11
