-- MySQL dump 10.13  Distrib 5.6.47, for Linux (x86_64)
--
-- Host: localhost    Database: heroku_363e33bbbe8771a
-- ------------------------------------------------------
-- Server version	5.6.47-log

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
-- Table structure for table `problemtypes`
--

DROP TABLE IF EXISTS `problemtypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `problemtypes` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `problem_type` varchar(200) DEFAULT NULL,
  `subtype_of` int(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `problemtypes`
--

LOCK TABLES `problemtypes` WRITE;
/*!40000 ALTER TABLE `problemtypes` DISABLE KEYS */;
INSERT INTO `problemtypes` VALUES (1,'User Permissions',-1),(11,'Printer',-1),(21,'New User',-1),(31,'Unknown',-1),(41,'Monitor Issue',-1),(51,'Peripherals',-1),(61,'Paper Jam',11),(71,'Dead Pixels',41),(81,'Keyboard',51),(91,'Mouse',51);
/*!40000 ALTER TABLE `problemtypes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resolvedtickets`
--

DROP TABLE IF EXISTS `resolvedtickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resolvedtickets` (
  `id` int(6) DEFAULT NULL,
  `solvedby` varchar(30) NOT NULL,
  `details` varchar(200) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resolvedtickets`
--

LOCK TABLES `resolvedtickets` WRITE;
/*!40000 ALTER TABLE `resolvedtickets` DISABLE KEYS */;
INSERT INTO `resolvedtickets` VALUES (11,'genericOperator','Requested maintenance team to replace cartridges in printer.','2020-05-28 09:21:58'),(61,'genericOperator','Called maintenance team and arranged for them to replace monitor with one from stock','2020-05-28 09:49:40'),(71,'genericOperator','Called maintenance team to replace batteries in mouse','2020-05-28 09:52:50');
/*!40000 ALTER TABLE `resolvedtickets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `specialists`
--

DROP TABLE IF EXISTS `specialists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `specialists` (
  `username` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `specialists`
--

LOCK TABLES `specialists` WRITE;
/*!40000 ALTER TABLE `specialists` DISABLE KEYS */;
INSERT INTO `specialists` VALUES ('genericSpecialist'),('otherSpecialist');
/*!40000 ALTER TABLE `specialists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tags` (
  `id` int(6) DEFAULT NULL,
  `tag` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` VALUES (1,'download'),(1,'admin'),(1,'windows'),(1,'visualstudio'),(1,'microsoft'),(11,'printer'),(11,'ink'),(11,'hp'),(21,'create'),(21,'account'),(21,'windows'),(21,'new'),(21,'user'),(31,'printer'),(31,'hp'),(31,'unknown'),(41,'download'),(41,'admin'),(41,'windows'),(41,'visualstudio'),(41,'microsoft'),(51,'monitor'),(51,'blank'),(51,'screen'),(51,'no'),(51,'power'),(51,'dell'),(61,'dell'),(61,'monitor'),(61,'dead'),(61,'pixels'),(71,'mouse'),(71,'battery'),(71,'replacement');
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tickets` (
  `callerfirstname` varchar(30) NOT NULL,
  `callerlastname` varchar(30) NOT NULL,
  `specialist` varchar(30) DEFAULT NULL,
  `type` varchar(30) DEFAULT NULL,
  `summary` varchar(200) DEFAULT NULL,
  `details` varchar(200) DEFAULT NULL,
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(30) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `operator` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `followup` int(6) DEFAULT NULL,
  `archived` tinyint(1) DEFAULT '0',
  `hwserial` varchar(30) DEFAULT NULL,
  `osname` varchar(30) DEFAULT NULL,
  `swname` varchar(30) DEFAULT NULL,
  `swversion` varchar(30) DEFAULT NULL,
  `swlicense` varchar(30) DEFAULT NULL,
  `problemtype` int(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickets`
--

LOCK TABLES `tickets` WRITE;
/*!40000 ALTER TABLE `tickets` DISABLE KEYS */;
INSERT INTO `tickets` VALUES ('Eddard','Stark','genericSpecialist','Software','User cannot install VS2019','User cannot install VS2019 due to not having admin access required',1,'ongoing','2020-05-16 23:32:31','genericOperator','warden@north.com',-1,0,'','Windows 10','Visual Studio ','2019','-',1),('Robert','Stark','Operator','Hardware','Printer out of ink','Printer near office 0.03N is out of ink and therefore wont print',11,'solved','2020-05-16 23:33:42','genericOperator','king@north.com',-1,1,'5545-5885','','','','',11),('Tywin','Lannister','otherSpecialist','Software','New account required','A new user account is required for caller as they have recently joined the company but do not seem to have been on-boarded correctly.',21,'pending','2020-05-28 09:29:20','genericOperator','warden@west.com',-1,0,'','Windows 10','Windows OS','10','XX-XY',21),('Jon','Snow','otherSpecialist','Hardware','Printer will not print, unknown issue','Issue reported by different user for the same printer was recently fixed. No error message on printer, just a blank screen, will not print.',31,'pending','2020-05-28 09:32:32','genericOperator','whitewolf@north.com',11,0,'5545-5885','','','','',31),('Catelyn','Stark','genericSpecialist','Software','User cannot install VS2019','User cannot install VS2019 due to not having admin access required',41,'ongoing','2020-05-28 09:38:20','genericOperator','lady@winterfell.com',-1,0,'','Windows 10','Visual Studio ','2019','-',1),('Bran','Stark','genericSpecialist','Hardware','User monitor appears to have no power','One of the users monitors appears to have no power, potentially requires replacement',51,'ongoing','2020-05-28 09:44:03','genericOperator','3eyedraven@north.com',-1,0,'5545-5889','','','','',31),('Theon','Greyjoy','Operator','Hardware','User monitor has dead pixels','One of user monitors has dead pixels',61,'solved','2020-05-28 09:48:51','genericOperator','ironward@north.com',-1,1,'5545-5875','','','','',71),('Arya','Stark','Operator','Hardware','Users mouse requires new batteries','Users wireless mouse needs new batteries',71,'solved','2020-05-28 09:52:28','genericOperator','no.one@north.com',-1,1,'5545-5333','','','','',91);
/*!40000 ALTER TABLE `tickets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `type` varchar(30) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `available` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','youshallnotpass','Operator','Admin','User',1),(11,'testuser','letmein','Operator','IamA','TestUser',1),(21,'genericOperator','youshouldneverguessthis','Operator','IamAn','Operator',1),(31,'genericSpecialist','thatsanironicname','Specialist','IamA','Specialist',1),(41,'otherSpecialist','lessironicname','Specialist','IamA','SpecialistToo',1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'heroku_363e33bbbe8771a'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-05-28 10:32:22
