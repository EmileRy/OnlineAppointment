# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.34)
# Database: online_appointment
# Generation Time: 2022-05-19 11:54:29 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table Appointments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Appointments`;

CREATE TABLE `Appointments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `timetable_id` int(11) NOT NULL,
  `notes` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `timetable_id` (`timetable_id`),
  KEY `Appointments_fk0` (`user_id`),
  KEY `Appointments_fk1` (`timetable_id`),
  CONSTRAINT `Appointments_fk0` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`),
  CONSTRAINT `Appointments_fk1` FOREIGN KEY (`timetable_id`) REFERENCES `Timetables` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table Doctors
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Doctors`;

CREATE TABLE `Doctors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `address` text,
  `identification_number` int(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  KEY `Doctors_fk1` (`type_id`),
  CONSTRAINT `Doctors_fk0` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`),
  CONSTRAINT `Doctors_fk1` FOREIGN KEY (`type_id`) REFERENCES `Types` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table Timetables
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Timetables`;

CREATE TABLE `Timetables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `duration` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Timetables_fk0` (`doctor_id`),
  CONSTRAINT `Timetables_fk0` FOREIGN KEY (`doctor_id`) REFERENCES `Doctors` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table Types
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Types`;

CREATE TABLE `Types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `Types` WRITE;
/*!40000 ALTER TABLE `Types` DISABLE KEYS */;

INSERT INTO `Types` (`id`, `name`)
VALUES
	(2,'Dentist'),
	(1,'General practitioner'),
	(3,'Gynecologist'),
	(4,'Physical therapist'),
	(5,'Psychologist'),
	(6,'Vaccin');

/*!40000 ALTER TABLE `Types` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table Users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Users`;

CREATE TABLE `Users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(30) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `gender` varchar(1) NOT NULL DEFAULT '?',
  `created_at` timestamp(1) NOT NULL DEFAULT CURRENT_TIMESTAMP(1) ON UPDATE CURRENT_TIMESTAMP(1),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
