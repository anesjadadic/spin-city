# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.7.39)
# Database: MusicSite
# Generation Time: 2023-11-17 23:11:04 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table Customer
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Customer`;

CREATE TABLE `Customer` (
  `cID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cUsername` varchar(128) NOT NULL DEFAULT '',
  `cPassword` varchar(128) NOT NULL DEFAULT '',
  PRIMARY KEY (`cID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `Customer` WRITE;
/*!40000 ALTER TABLE `Customer` DISABLE KEYS */;

INSERT INTO `Customer` (`cID`, `cUsername`, `cPassword`)
VALUES
	(8,'anes','$2y$10$JBjYz18q.ktvnJtQD.gglem20Z9E7cen9h3s1.DMrSXuuDCoP9Kw2'),
	(9,'ajla','$2y$10$ZmgUDEe60n/KT3CvSFArte4urx8JHLjX3O5sDnsmzxGpyjeMUFoMO'),
	(10,'babo','$2y$10$cA9i67Fip9hf/OdaNaUpt.dqB1QuR3vaUTKEUWs8iwKaJP7Ys33sC');

/*!40000 ALTER TABLE `Customer` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table Employee
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Employee`;

CREATE TABLE `Employee` (
  `eID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `eFirstName` varchar(128) NOT NULL,
  `eLastName` varchar(128) NOT NULL,
  `eUsername` varchar(128) NOT NULL DEFAULT '',
  `ePassword` varchar(128) NOT NULL DEFAULT '',
  `eRole` varchar(11) NOT NULL DEFAULT 'Employee',
  PRIMARY KEY (`eID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `Employee` WRITE;
/*!40000 ALTER TABLE `Employee` DISABLE KEYS */;

INSERT INTO `Employee` (`eID`, `eFirstName`, `eLastName`, `eUsername`, `ePassword`, `eRole`)
VALUES
	(14,'Anes','Jadadic','anesj','$2y$10$Q53xmuQ60sbnWCj1Od4aj.zRjkcwLBZwXRULPK1T1XkEnT7Wp79t2','Admin'),
	(15,'Bobby','Eggs','bobby','$2y$10$7rBY/IkHENSBuCHWEcTIg.lB4IHUvojtfIoz2wqifnZLKtCNX0aAm','Employee'),
	(16,'Bartholomew','Zanzibart','bart','$2y$10$aSjjMfaUggEOUh9vdKUtGumwXjIF/ZsTt/e27qyEYdGohgrs0GqZm','Employee'),
	(18,'Slim','Jim','slim','$2y$10$XetiG3M5atSkWoRgfrC24Ol.4pFEa55kbtS7uE9A4RXeehBxgEfCe','Employee'),
	(19,'Zena','Moore','zmoore','$2y$10$WxO5OE8iF5RFzcOpzeVRYusTXCrate9KzbJHCqT20xp/uaT53OxUe','Employee'),
	(20,'Brayden','Waugh','bwaugh','$2y$10$lxnjbm7tp0TUGKd0V6BkIeGdznVh25q1enwbRlB4p/alhf6W0YZ2O','Employee');

/*!40000 ALTER TABLE `Employee` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table Record
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Record`;

CREATE TABLE `Record` (
  `rID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `rName` char(128) NOT NULL DEFAULT '',
  `rArtist` char(128) NOT NULL DEFAULT '',
  `rGenre` char(128) NOT NULL DEFAULT '',
  `rYearReleased` int(11) NOT NULL,
  `rVinylQuantity` int(11) NOT NULL,
  `rCDquantity` int(11) NOT NULL,
  `rVinylPrice` double NOT NULL,
  `rCDprice` double NOT NULL,
  `rAlbumCover` varchar(128) DEFAULT '',
  PRIMARY KEY (`rID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `Record` WRITE;
/*!40000 ALTER TABLE `Record` DISABLE KEYS */;

INSERT INTO `Record` (`rID`, `rName`, `rArtist`, `rGenre`, `rYearReleased`, `rVinylQuantity`, `rCDquantity`, `rVinylPrice`, `rCDprice`, `rAlbumCover`)
VALUES
	(42,'Enter The Wu-Tang','Wu Tang Clan','Rap',1993,2,5,35,15,'36 Chambers.jpg'),
	(57,'Thriller','Michael Jackson','Pop',1983,2,4,33,17,'Thriller.png'),
	(62,'A Love Supreme','John Coltrane','Jazz',1965,0,5,56,20,'A Love Supreme.jpg'),
	(65,'Madvillainy','Madvillain','Rap',2004,6,7,45,17,'Madvillainy.jpg'),
	(68,'To Pimp A Butterfly','Kendrick Lamar','Rap',2015,4,6,43,16,'To Pimp A Butterfly.jpg'),
	(69,'Ride The Lightning','Metallica','Metal',1984,3,6,37,20,'Ride The Lightning.jpg'),
	(74,'Lateralus','TOOL','Metal',2001,2,4,47,22,'Lateralus.jpg'),
	(75,'The Bends','Radiohead','Rock',1995,0,4,48,18,'The Bends.jpg'),
	(76,'Cosmogramma','Flying Lotus','Electronic',2010,3,6,46,17,'Cosmogramma.jpeg'),
	(77,'Head Hunters','Herbie Hancock','Jazz',1973,0,2,64,23,'Head Hunters.jpeg'),
	(78,'Love Sounds','Justin Timberlake','Pop',2006,0,5,38,15,'Love Sounds.jpeg'),
	(79,'Pyromania','Def Leppard','Rock',1983,2,1,41,20,'Pyromania.jpeg'),
	(80,'Mezzanine','Massive Attack','Electronic',1998,4,2,39,18,'Mezzanine.jpeg'),
	(81,'Rumours','Fleetwood Mac','Pop',1977,6,4,35,18,'Rumours.jpeg'),
	(82,'Animals','Pink Floyd','Rock',1977,3,0,48,23,'Animals.png'),
	(83,'Rust In Peace','Megadeth','Metal',1990,6,5,32,17,'Rust In Peace.jpeg'),
	(84,'License To Ill','Beastie Boys','Rap',1986,3,5,35,19,'License To Ill.jpg'),
	(85,'Discovery','Daft Punk','Electronic',2001,2,5,34,15,'Discovery.jpeg'),
	(86,'Songs For The Deaf','Queens of the Stone Age','Rock',2002,3,3,37,18,'Songs For The Deaf.png'),
	(87,'Lemonade','Beyonce','Pop',2016,3,6,32,16,'Lemonade.jpeg'),
	(88,'Koi No Yokan','Deftones','Metal',2012,4,5,33,19,'Koi No Yokan.jpg'),
	(89,'In The Court of the Crimson King','King Crimson','Rock',1969,3,0,43,20,'ITCotCK.jpeg'),
	(90,'Abbey Road','The Beatles','Pop',1969,4,6,36,19,'Abbey Road.jpeg'),
	(91,'Black Star','David Bowie','Rock',2016,4,6,32,18,'Blackstar.png'),
	(92,'Love Deluxe','Sade','Pop',1992,3,4,36,17,'Love Deluxe.jpeg');

/*!40000 ALTER TABLE `Record` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
