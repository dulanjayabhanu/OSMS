-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.29 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.0.0.6468
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for osms
CREATE DATABASE IF NOT EXISTS `osms` /*!40100 DEFAULT CHARACTER SET utf8mb3 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `osms`;

-- Dumping structure for table osms.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `email` varchar(100) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `mobile` varchar(10) DEFAULT NULL,
  `joined_date` datetime DEFAULT NULL,
  `verification_code` varchar(10) DEFAULT NULL,
  `gender_id` int NOT NULL,
  PRIMARY KEY (`email`),
  KEY `fk_admin_gender1_idx` (`gender_id`),
  CONSTRAINT `fk_admin_gender1` FOREIGN KEY (`gender_id`) REFERENCES `gender` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table osms.admin: ~1 rows (approximately)
INSERT INTO `admin` (`email`, `first_name`, `last_name`, `mobile`, `joined_date`, `verification_code`, `gender_id`) VALUES
	('dulanjayawebs@gmail.com', 'Dulanjaya', 'Bhanu', '071427224', '2022-12-24 00:55:40', 'd1c359', 1);

-- Dumping structure for table osms.admin_profile_image
CREATE TABLE IF NOT EXISTS `admin_profile_image` (
  `path` varchar(100) NOT NULL,
  `admin_email` varchar(100) NOT NULL,
  PRIMARY KEY (`path`),
  KEY `fk_admin_profile_image_admin1_idx` (`admin_email`),
  CONSTRAINT `fk_admin_profile_image_admin1` FOREIGN KEY (`admin_email`) REFERENCES `admin` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table osms.admin_profile_image: ~1 rows (approximately)
INSERT INTO `admin_profile_image` (`path`, `admin_email`) VALUES
	('resources/images/profile_image/Dulanjaya_63bd2bcd5559a.jpeg', 'dulanjayawebs@gmail.com');

-- Dumping structure for table osms.answer_sheet
CREATE TABLE IF NOT EXISTS `answer_sheet` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `submit_date` datetime DEFAULT NULL,
  `assignment_id` int NOT NULL,
  `marks` double DEFAULT NULL,
  `status` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_answer_sheet_assignment1_idx` (`assignment_id`),
  CONSTRAINT `fk_answer_sheet_assignment1` FOREIGN KEY (`assignment_id`) REFERENCES `assignment` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table osms.answer_sheet: ~1 rows (approximately)
INSERT INTO `answer_sheet` (`id`, `name`, `submit_date`, `assignment_id`, `marks`, `status`) VALUES
	(18, 'resources/answer_sheet/2023_13-Mathematics_Co.Mathematics_AnswerSheet4ff5.pdf', '2023-01-11 01:35:19', 28, 55, 1);

-- Dumping structure for table osms.assignment
CREATE TABLE IF NOT EXISTS `assignment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `deadline` datetime DEFAULT NULL,
  `classroom_id` int NOT NULL,
  `teacher_has_subject_id` int NOT NULL,
  `type` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_assignment_classroom1_idx` (`classroom_id`),
  KEY `fk_assignment_teacher_has_subject1_idx` (`teacher_has_subject_id`),
  CONSTRAINT `fk_assignment_classroom1` FOREIGN KEY (`classroom_id`) REFERENCES `classroom` (`id`),
  CONSTRAINT `fk_assignment_teacher_has_subject1` FOREIGN KEY (`teacher_has_subject_id`) REFERENCES `teacher_has_subject` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table osms.assignment: ~2 rows (approximately)
INSERT INTO `assignment` (`id`, `name`, `deadline`, `classroom_id`, `teacher_has_subject_id`, `type`) VALUES
	(27, 'resources/lesson_notes/2023_13-Mathematics_Co.Mathematics_Lesson37ba.pdf', NULL, 21, 99, 2),
	(28, 'resources/assignments/2023_13-Mathematics_Co.Mathematics_Assignment4dc7.pdf', '2023-01-11 01:34:44', 21, 99, 1);

-- Dumping structure for table osms.city
CREATE TABLE IF NOT EXISTS `city` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `district_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_city_district1_idx` (`district_id`),
  CONSTRAINT `fk_city_district1` FOREIGN KEY (`district_id`) REFERENCES `district` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table osms.city: ~5 rows (approximately)
INSERT INTO `city` (`id`, `name`, `district_id`) VALUES
	(1, 'Kirindiwela', 7),
	(2, 'Nittambuwa', 7),
	(3, 'Gampaha', 7),
	(4, 'Kahatana', 7),
	(5, 'Aththanagalle', 7);

-- Dumping structure for table osms.classroom
CREATE TABLE IF NOT EXISTS `classroom` (
  `id` int NOT NULL AUTO_INCREMENT,
  `year` year DEFAULT NULL,
  `grade_id` int NOT NULL,
  `teacher_email` varchar(100) NOT NULL,
  `student_email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_class_grade1_idx` (`grade_id`),
  KEY `fk_classroom_teacher1_idx` (`teacher_email`),
  KEY `fk_classroom_student1_idx` (`student_email`),
  CONSTRAINT `fk_class_grade1` FOREIGN KEY (`grade_id`) REFERENCES `grade` (`id`),
  CONSTRAINT `fk_classroom_student1` FOREIGN KEY (`student_email`) REFERENCES `student` (`email`),
  CONSTRAINT `fk_classroom_teacher1` FOREIGN KEY (`teacher_email`) REFERENCES `teacher` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table osms.classroom: ~8 rows (approximately)
INSERT INTO `classroom` (`id`, `year`, `grade_id`, `teacher_email`, `student_email`) VALUES
	(14, '2023', 27, 'lalitha@gmail.com', 'janidu@gmail.com'),
	(15, '2023', 21, 'lalitha@gmail.com', 'pragith@gmail.com'),
	(16, '2023', 27, 'lalitha@gmail.com', 'sineth@gmail.com'),
	(18, '2023', 21, 'lalitha@gmail.com', 'nipun@gmail.com'),
	(19, '2023', 21, 'lalitha@gmail.com', 'malisha@gmail.com'),
	(20, '2023', 21, 'lalitha@gmail.com', 'tharushi@gmail.com'),
	(21, '2023', 37, 'sunil@gmail.com', 'sidmi@gmail.com'),
	(22, '2023', 37, 'sunil@gmail.com', 'shehan@gmail.com');

-- Dumping structure for table osms.district
CREATE TABLE IF NOT EXISTS `district` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `province_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_district_province1_idx` (`province_id`),
  CONSTRAINT `fk_district_province1` FOREIGN KEY (`province_id`) REFERENCES `province` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table osms.district: ~25 rows (approximately)
INSERT INTO `district` (`id`, `name`, `province_id`) VALUES
	(1, 'Ampara', 7),
	(2, 'Anuradhapura', 6),
	(3, 'Badulla', 2),
	(4, 'Batticaloa', 7),
	(5, 'Colombo', 3),
	(6, 'Galle', 9),
	(7, 'Gampaha', 3),
	(8, 'Hambantota', 9),
	(9, 'Jaffna', 5),
	(10, 'Kalutara', 3),
	(11, 'Kandy', 8),
	(12, 'Kegalle', 1),
	(13, 'Kilinochchi', 5),
	(14, 'Kurunegala', 4),
	(15, 'Mannar', 5),
	(16, 'Matale', 8),
	(17, 'Matara', 9),
	(18, 'Monaragala', 2),
	(19, 'Mullaitivu', 5),
	(20, 'Nuwara Eliya', 8),
	(21, 'Polonnaruwa', 6),
	(22, 'Puttalam', 4),
	(23, 'Ratnapura', 1),
	(24, 'Trincomalee', 7),
	(25, 'Vavuniya', 5);

-- Dumping structure for table osms.gender
CREATE TABLE IF NOT EXISTS `gender` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table osms.gender: ~2 rows (approximately)
INSERT INTO `gender` (`id`, `name`) VALUES
	(1, 'Male'),
	(2, 'Female');

-- Dumping structure for table osms.grade
CREATE TABLE IF NOT EXISTS `grade` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table osms.grade: ~39 rows (approximately)
INSERT INTO `grade` (`id`, `name`) VALUES
	(1, '6-A'),
	(2, '6-B'),
	(3, '6-C'),
	(4, '6-D'),
	(5, '6-E'),
	(6, '7-A'),
	(7, '7-B'),
	(8, '7-C'),
	(9, '7-D'),
	(10, '7-E'),
	(11, '8-A'),
	(12, '8-B'),
	(13, '8-C'),
	(14, '8-D'),
	(15, '8-E'),
	(16, '9-A'),
	(17, '9-B'),
	(18, '9-C'),
	(19, '9-D'),
	(20, '9-E'),
	(21, '10-A'),
	(22, '10-B'),
	(23, '10-C'),
	(24, '10-D'),
	(25, '10-E'),
	(26, '11-A'),
	(27, '11-B'),
	(28, '11-C'),
	(29, '11-D'),
	(30, '11-E'),
	(31, '12-Mathematics'),
	(32, '12-Biology'),
	(33, '12-Technology'),
	(35, '12-Commerce'),
	(36, '12-Art'),
	(37, '13-Mathematics'),
	(38, '13-Biology'),
	(39, '13-Technology'),
	(40, '13-Commerce'),
	(41, '13-Art');

-- Dumping structure for table osms.invoice
CREATE TABLE IF NOT EXISTS `invoice` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date` datetime DEFAULT NULL,
  `total` double DEFAULT NULL,
  `student_email` varchar(100) NOT NULL,
  `grade_id` int NOT NULL,
  `bill_id` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_invoice_student1_idx` (`student_email`),
  KEY `fk_invoice_grade1_idx` (`grade_id`),
  CONSTRAINT `fk_invoice_grade1` FOREIGN KEY (`grade_id`) REFERENCES `grade` (`id`),
  CONSTRAINT `fk_invoice_student1` FOREIGN KEY (`student_email`) REFERENCES `student` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table osms.invoice: ~3 rows (approximately)
INSERT INTO `invoice` (`id`, `date`, `total`, `student_email`, `grade_id`, `bill_id`) VALUES
	(6, '2023-01-10 20:32:45', 2000, 'sidmi@gmail.com', 37, 'bill_ded8f'),
	(7, '2023-01-10 20:37:41', 2000, 'malisha@gmail.com', 21, 'bill_17b69'),
	(8, '2023-01-11 19:29:22', 2000, 'pragith@gmail.com', 21, 'bill_2c5f5');

-- Dumping structure for table osms.medium
CREATE TABLE IF NOT EXISTS `medium` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table osms.medium: ~2 rows (approximately)
INSERT INTO `medium` (`id`, `name`) VALUES
	(1, 'Sinhala'),
	(2, 'English');

-- Dumping structure for table osms.parent
CREATE TABLE IF NOT EXISTS `parent` (
  `email` varchar(100) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table osms.parent: ~8 rows (approximately)
INSERT INTO `parent` (`email`, `first_name`, `last_name`) VALUES
	('amali12@gmail.com', 'Kumari', 'Chandani'),
	('harin@gmail.com', 'Harin', 'Gamage'),
	('kumara77@gmail.com', 'Kumara', 'Silva'),
	('neela@gmail.com', 'Neela', 'Rathnayake'),
	('piyadasa@gmail.com', 'Siril', 'Piyadasa'),
	('piyantha2@gmail.com', 'Sunil', 'Piyantha'),
	('ruwan@gmail.com', 'Ruwan', 'Perera'),
	('vijey88@gmail.com', 'Vijey', 'Kumar');

-- Dumping structure for table osms.province
CREATE TABLE IF NOT EXISTS `province` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table osms.province: ~9 rows (approximately)
INSERT INTO `province` (`id`, `name`) VALUES
	(1, 'Sabaragamuwa'),
	(2, 'Uva'),
	(3, 'West'),
	(4, 'Northwest'),
	(5, 'North'),
	(6, 'Northcentral'),
	(7, 'East'),
	(8, 'Central'),
	(9, 'South');

-- Dumping structure for table osms.student
CREATE TABLE IF NOT EXISTS `student` (
  `email` varchar(100) NOT NULL,
  `password` varchar(20) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `mobile` varchar(10) DEFAULT NULL,
  `joined_date` datetime DEFAULT NULL,
  `verification_code` varchar(10) DEFAULT NULL,
  `block_status` int DEFAULT NULL,
  `verify_status` int DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `nationality` varchar(20) DEFAULT NULL,
  `gender_id` int NOT NULL,
  `medium_id` int NOT NULL,
  `parent_email` varchar(100) NOT NULL,
  `payment_status` int DEFAULT NULL,
  PRIMARY KEY (`email`),
  KEY `fk_student_gender1_idx` (`gender_id`),
  KEY `fk_student_medium1_idx` (`medium_id`),
  KEY `fk_student_parent1_idx` (`parent_email`),
  CONSTRAINT `fk_student_gender1` FOREIGN KEY (`gender_id`) REFERENCES `gender` (`id`),
  CONSTRAINT `fk_student_medium1` FOREIGN KEY (`medium_id`) REFERENCES `medium` (`id`),
  CONSTRAINT `fk_student_parent1` FOREIGN KEY (`parent_email`) REFERENCES `parent` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table osms.student: ~8 rows (approximately)
INSERT INTO `student` (`email`, `password`, `first_name`, `last_name`, `date_of_birth`, `mobile`, `joined_date`, `verification_code`, `block_status`, `verify_status`, `username`, `nationality`, `gender_id`, `medium_id`, `parent_email`, `payment_status`) VALUES
	('janidu@gmail.com', 'bd35d4e6', 'Janidu', 'Dilneth', '2010-02-17', '0776343452', '2023-01-10 15:24:28', NULL, 1, 1, 'JaniduDild4e6', 'Sinhala', 1, 1, 'amali12@gmail.com', 2),
	('malisha@gmail.com', 'bd3ecb75', 'Malisha', 'Buwani', '2010-06-03', '0770012340', '2023-01-10 16:02:43', NULL, 1, 1, 'MalishaBuwcb75', 'Sinhala', 2, 1, 'ruwan@gmail.com', 4),
	('nipun@gmail.com', 'bd3db3eb', 'Nipun', 'Malith', '2010-01-12', '0776321121', '2023-01-10 15:58:03', NULL, 1, 1, 'NipunMalb3eb', 'Sinhala', 1, 1, 'piyadasa@gmail.com', 2),
	('pragith@gmail.com', 'bd3a46ab', 'Pragith', 'Sri', '2011-05-17', '0776767453', '2023-01-10 15:43:26', NULL, 1, 2, 'PragithSri46ab', 'Sinhala', 1, 1, 'piyantha2@gmail.com', 3),
	('shehan@gmail.com', 'bd4406f3', 'Shehan', 'Nisitha', '2001-04-07', '0717656909', '2023-01-10 16:25:02', NULL, 1, 1, 'ShehanNis06f3', 'Sinhala', 1, 1, 'kumara77@gmail.com', 2),
	('sidmi@gmail.com', 'bd42fbca', 'Sidmi', 'Nishara', '2001-03-12', '0719090788', '2023-01-10 16:20:35', NULL, 1, 1, 'SidmiNisfbca', 'Sinhala', 2, 1, 'neela@gmail.com', 3),
	('sineth@gmail.com', 'bd3bd767', 'Sineth', 'Nimesha', '2010-01-13', '0717878890', '2023-01-10 15:50:07', NULL, 1, 1, 'SinethNimd767', 'Sinhala', 1, 1, 'vijey88@gmail.com', 2),
	('tharushi@gmail.com', 'bd41cd2c', 'Tharushi', 'Samindya', '2010-02-03', '0715656800', '2023-01-10 16:15:33', NULL, 1, 1, 'TharushiSamcd2c', 'Sinhala', 2, 1, 'harin@gmail.com', 2);

-- Dumping structure for table osms.student_has_address
CREATE TABLE IF NOT EXISTS `student_has_address` (
  `student_email` varchar(100) NOT NULL,
  `city_id` int NOT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  `line1` text,
  `line2` text,
  `postal_code` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_student_has_city_city1_idx` (`city_id`),
  KEY `fk_student_has_city_student1_idx` (`student_email`),
  CONSTRAINT `fk_student_has_city_city1` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`),
  CONSTRAINT `fk_student_has_city_student1` FOREIGN KEY (`student_email`) REFERENCES `student` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table osms.student_has_address: ~8 rows (approximately)
INSERT INTO `student_has_address` (`student_email`, `city_id`, `id`, `line1`, `line2`, `postal_code`) VALUES
	('janidu@gmail.com', 4, 2, 'Kahatana', 'Henegama', '1123'),
	('pragith@gmail.com', 1, 3, 'Kingroad', 'Kirindiwela', '1127'),
	('sineth@gmail.com', 2, 4, 'Walpola', 'Nittambuwa', '1126'),
	('nipun@gmail.com', 5, 5, 'Aththanagalla', 'Waragoda', '1200'),
	('malisha@gmail.com', 3, 6, 'Gampaha', 'JaEla', '1322'),
	('tharushi@gmail.com', 1, 7, 'Kirindiwela', 'Millathe', '1212'),
	('sidmi@gmail.com', 3, 8, 'Gampaha', 'JaEla', '1220'),
	('shehan@gmail.com', 4, 9, 'Kahatana', 'Henegama', '1120');

-- Dumping structure for table osms.student_has_subject
CREATE TABLE IF NOT EXISTS `student_has_subject` (
  `student_email` varchar(100) NOT NULL,
  `subject_id` int NOT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  `grade_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_student_has_subject_subject1_idx` (`subject_id`),
  KEY `fk_student_has_subject_student1_idx` (`student_email`),
  KEY `fk_student_has_subject_grade1_idx` (`grade_id`),
  CONSTRAINT `fk_student_has_subject_grade1` FOREIGN KEY (`grade_id`) REFERENCES `grade` (`id`),
  CONSTRAINT `fk_student_has_subject_student1` FOREIGN KEY (`student_email`) REFERENCES `student` (`email`),
  CONSTRAINT `fk_student_has_subject_subject1` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table osms.student_has_subject: ~48 rows (approximately)
INSERT INTO `student_has_subject` (`student_email`, `subject_id`, `id`, `grade_id`) VALUES
	('janidu@gmail.com', 1, 5, 21),
	('janidu@gmail.com', 11, 7, 21),
	('janidu@gmail.com', 5, 8, 21),
	('janidu@gmail.com', 6, 9, 21),
	('janidu@gmail.com', 3, 10, 21),
	('janidu@gmail.com', 7, 11, 21),
	('janidu@gmail.com', 20, 12, 21),
	('pragith@gmail.com', 1, 13, 21),
	('pragith@gmail.com', 11, 14, 21),
	('pragith@gmail.com', 5, 15, 21),
	('pragith@gmail.com', 6, 16, 21),
	('pragith@gmail.com', 3, 17, 21),
	('pragith@gmail.com', 7, 18, 21),
	('pragith@gmail.com', 20, 19, 21),
	('sineth@gmail.com', 1, 20, 21),
	('sineth@gmail.com', 11, 21, 21),
	('sineth@gmail.com', 5, 22, 21),
	('sineth@gmail.com', 6, 23, 21),
	('sineth@gmail.com', 3, 24, 21),
	('sineth@gmail.com', 7, 25, 21),
	('sineth@gmail.com', 20, 26, 21),
	('nipun@gmail.com', 1, 27, 21),
	('nipun@gmail.com', 11, 28, 21),
	('nipun@gmail.com', 5, 29, 21),
	('nipun@gmail.com', 6, 30, 21),
	('nipun@gmail.com', 3, 31, 21),
	('nipun@gmail.com', 7, 32, 21),
	('nipun@gmail.com', 20, 33, 21),
	('malisha@gmail.com', 1, 34, 21),
	('malisha@gmail.com', 11, 35, 21),
	('malisha@gmail.com', 5, 36, 21),
	('malisha@gmail.com', 6, 37, 21),
	('malisha@gmail.com', 3, 38, 21),
	('malisha@gmail.com', 7, 39, 21),
	('malisha@gmail.com', 20, 40, 21),
	('tharushi@gmail.com', 1, 41, 21),
	('tharushi@gmail.com', 11, 42, 21),
	('tharushi@gmail.com', 5, 43, 21),
	('tharushi@gmail.com', 6, 44, 21),
	('tharushi@gmail.com', 3, 45, 21),
	('tharushi@gmail.com', 7, 46, 21),
	('tharushi@gmail.com', 20, 47, 21),
	('sidmi@gmail.com', 27, 48, 37),
	('sidmi@gmail.com', 26, 49, 37),
	('sidmi@gmail.com', 25, 50, 37),
	('shehan@gmail.com', 27, 51, 37),
	('shehan@gmail.com', 26, 52, 37),
	('shehan@gmail.com', 34, 53, 37);

-- Dumping structure for table osms.student_profile_image
CREATE TABLE IF NOT EXISTS `student_profile_image` (
  `path` varchar(100) NOT NULL,
  `student_email` varchar(100) NOT NULL,
  PRIMARY KEY (`path`),
  KEY `fk_student_profile_image_student1_idx` (`student_email`),
  CONSTRAINT `fk_student_profile_image_student1` FOREIGN KEY (`student_email`) REFERENCES `student` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table osms.student_profile_image: ~8 rows (approximately)
INSERT INTO `student_profile_image` (`path`, `student_email`) VALUES
	('resources/images/profile_image/Janidu_63bd3798ed521.jpeg', 'janidu@gmail.com'),
	('resources/images/profile_image/Malisha_63bd3f7b2f7f1.jpeg', 'malisha@gmail.com'),
	('resources/images/profile_image/Nipun_63bd3e7743575.jpeg', 'nipun@gmail.com'),
	('resources/images/profile_image/Pragith_63bd3af190396.jpeg', 'pragith@gmail.com'),
	('resources/images/profile_image/Shehan_63bd447852137.jpeg', 'shehan@gmail.com'),
	('resources/images/profile_image/Sidmi_63bd43a7bdb6e.jpeg', 'sidmi@gmail.com'),
	('resources/images/profile_image/Sineth_63bd3cdb2a39d.jpeg', 'sineth@gmail.com'),
	('resources/images/profile_image/Tharushi_63bd4252175e9.jpeg', 'tharushi@gmail.com');

-- Dumping structure for table osms.student_unique_code
CREATE TABLE IF NOT EXISTS `student_unique_code` (
  `name` varchar(5) DEFAULT NULL,
  `status` int DEFAULT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  `student_email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_student_unique_code_student1_idx` (`student_email`),
  CONSTRAINT `fk_student_unique_code_student1` FOREIGN KEY (`student_email`) REFERENCES `student` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table osms.student_unique_code: ~8 rows (approximately)
INSERT INTO `student_unique_code` (`name`, `status`, `id`, `student_email`) VALUES
	('', 2, 21, 'janidu@gmail.com'),
	('', 2, 22, 'pragith@gmail.com'),
	('', 2, 23, 'sineth@gmail.com'),
	('', 2, 25, 'nipun@gmail.com'),
	('', 2, 26, 'malisha@gmail.com'),
	('', 2, 27, 'tharushi@gmail.com'),
	('', 2, 28, 'sidmi@gmail.com'),
	('', 2, 29, 'shehan@gmail.com');

-- Dumping structure for table osms.subject
CREATE TABLE IF NOT EXISTS `subject` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table osms.subject: ~33 rows (approximately)
INSERT INTO `subject` (`id`, `name`) VALUES
	(1, 'Buddhism'),
	(2, 'Christianity'),
	(3, 'Sinhala'),
	(4, 'Tamil'),
	(5, 'English'),
	(6, 'History'),
	(7, 'Science'),
	(8, 'Mathematics'),
	(9, 'Accounting'),
	(10, 'Geography'),
	(11, 'Civic Education'),
	(12, 'French'),
	(13, 'German'),
	(14, 'Japanese'),
	(15, 'Music'),
	(16, 'Dance'),
	(17, 'Art'),
	(18, 'Literary Texts'),
	(19, 'Drama'),
	(20, 'IT'),
	(21, 'Agriculture'),
	(22, 'Health'),
	(23, 'Technology'),
	(24, 'Biology'),
	(25, 'Chemistry'),
	(26, 'Physics'),
	(27, 'Co Mathematics'),
	(29, 'Business'),
	(31, 'St.Business'),
	(32, 'Economics'),
	(33, 'ET'),
	(34, 'ICT');

-- Dumping structure for table osms.teacher
CREATE TABLE IF NOT EXISTS `teacher` (
  `email` varchar(100) NOT NULL,
  `password` varchar(20) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `mobile` varchar(10) DEFAULT NULL,
  `joined_date` datetime DEFAULT NULL,
  `verification_code` varchar(10) DEFAULT NULL,
  `block_status` int DEFAULT NULL,
  `verify_status` int DEFAULT NULL,
  `gender_id` int NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `user_type` int DEFAULT NULL,
  PRIMARY KEY (`email`),
  KEY `fk_teacher_gender1_idx` (`gender_id`),
  CONSTRAINT `fk_teacher_gender1` FOREIGN KEY (`gender_id`) REFERENCES `gender` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table osms.teacher: ~7 rows (approximately)
INSERT INTO `teacher` (`email`, `password`, `first_name`, `last_name`, `date_of_birth`, `mobile`, `joined_date`, `verification_code`, `block_status`, `verify_status`, `gender_id`, `username`, `user_type`) VALUES
	('erandi@gmail.com', 'bd2d98a6', 'Erandi', 'Nimesha', '1970-01-10', '0711234900', '2023-01-10 14:49:20', NULL, 1, 1, 2, 'ErandiNim98a6', 2),
	('hema@gmail.com', 'bd2d05f2', 'Hema', 'Kumari', '1978-04-01', '0778909234', '2023-01-10 14:46:53', NULL, 1, 1, 2, 'HemaKum05f2', 1),
	('kithsiri@gmail.com', 'bd2c113e', 'Kithsiri', 'Anil', '1990-01-10', '0725654678', '2023-01-10 14:42:49', NULL, 1, 1, 1, 'KithsiriAni113e', 1),
	('lalitha@gmail.com', 'bd2d46ac', 'Lalitha', 'Chandani', '1990-05-15', '0751234515', '2023-01-10 14:47:58', NULL, 1, 1, 2, 'LalithaCha46ac', 1),
	('nuwan@gmail.com', 'bd2c46b8', 'Nuwan', 'Perera', '1998-12-10', '0715534789', '2023-01-10 14:43:42', NULL, 1, 2, 1, 'NuwanPer46b8', 1),
	('pawan@gmail.com', 'bd2dcc76', 'Pawan', 'Nimesha', '1973-01-10', '0776677390', '2023-01-10 14:50:12', NULL, 1, 2, 1, 'PawanNimcc76', 2),
	('sunil@gmail.com', 'bd2c854a', 'Sunil', 'Wirakon', '1970-01-10', '0725622890', '2023-01-10 14:44:45', NULL, 1, 1, 1, 'SunilWikvg23', 1);

-- Dumping structure for table osms.teacher_has_address
CREATE TABLE IF NOT EXISTS `teacher_has_address` (
  `id` int NOT NULL AUTO_INCREMENT,
  `line1` text,
  `line2` text,
  `postal_code` varchar(5) DEFAULT NULL,
  `city_id` int NOT NULL,
  `teacher_email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_teacher_has_address_city1_idx` (`city_id`),
  KEY `fk_teacher_has_address_teacher1_idx` (`teacher_email`),
  CONSTRAINT `fk_teacher_has_address_city1` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`),
  CONSTRAINT `fk_teacher_has_address_teacher1` FOREIGN KEY (`teacher_email`) REFERENCES `teacher` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table osms.teacher_has_address: ~7 rows (approximately)
INSERT INTO `teacher_has_address` (`id`, `line1`, `line2`, `postal_code`, `city_id`, `teacher_email`) VALUES
	(2, 'Waragoda', 'Aththanagalla', '1200', 5, 'kithsiri@gmail.com'),
	(3, 'JaEla', 'Gampaha', '1120', 3, 'nuwan@gmail.com'),
	(4, 'Mivitigammana', 'Kirindiwela', '1126', 1, 'sunil@gmail.com'),
	(5, 'Hunupola', 'Nittambuwa', '1100', 2, 'hema@gmail.com'),
	(6, 'Kahatana', 'Henegama', '1212', 4, 'lalitha@gmail.com'),
	(7, 'Millathe', 'Kirindiwela', '1126', 1, 'erandi@gmail.com'),
	(8, 'Kahatana', 'Henegama', '1212', 4, 'pawan@gmail.com');

-- Dumping structure for table osms.teacher_has_subject
CREATE TABLE IF NOT EXISTS `teacher_has_subject` (
  `subject_id` int NOT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  `grade_id` int NOT NULL,
  `teacher_email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_teacher_has_subject_subject1_idx` (`subject_id`),
  KEY `fk_teacher_has_subject_grade1_idx` (`grade_id`),
  KEY `fk_teacher_has_subject_teacher1_idx` (`teacher_email`),
  CONSTRAINT `fk_teacher_has_subject_grade1` FOREIGN KEY (`grade_id`) REFERENCES `grade` (`id`),
  CONSTRAINT `fk_teacher_has_subject_subject1` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`),
  CONSTRAINT `fk_teacher_has_subject_teacher1` FOREIGN KEY (`teacher_email`) REFERENCES `teacher` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table osms.teacher_has_subject: ~19 rows (approximately)
INSERT INTO `teacher_has_subject` (`subject_id`, `id`, `grade_id`, `teacher_email`) VALUES
	(5, 81, 26, 'hema@gmail.com'),
	(5, 82, 28, 'hema@gmail.com'),
	(5, 83, 13, 'hema@gmail.com'),
	(4, 85, 1, 'hema@gmail.com'),
	(8, 86, 18, 'kithsiri@gmail.com'),
	(8, 87, 20, 'kithsiri@gmail.com'),
	(8, 88, 6, 'kithsiri@gmail.com'),
	(8, 89, 7, 'kithsiri@gmail.com'),
	(1, 90, 21, 'lalitha@gmail.com'),
	(1, 91, 22, 'lalitha@gmail.com'),
	(1, 92, 24, 'lalitha@gmail.com'),
	(1, 93, 11, 'lalitha@gmail.com'),
	(21, 94, 30, 'nuwan@gmail.com'),
	(21, 95, 25, 'nuwan@gmail.com'),
	(7, 96, 4, 'nuwan@gmail.com'),
	(21, 97, 21, 'nuwan@gmail.com'),
	(27, 98, 31, 'sunil@gmail.com'),
	(27, 99, 37, 'sunil@gmail.com'),
	(8, 100, 13, 'sunil@gmail.com');

-- Dumping structure for table osms.teacher_profile_image
CREATE TABLE IF NOT EXISTS `teacher_profile_image` (
  `path` varchar(100) NOT NULL,
  `teacher_email` varchar(100) NOT NULL,
  PRIMARY KEY (`path`),
  KEY `fk_teacher_profile_image_teacher1_idx` (`teacher_email`),
  CONSTRAINT `fk_teacher_profile_image_teacher1` FOREIGN KEY (`teacher_email`) REFERENCES `teacher` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table osms.teacher_profile_image: ~7 rows (approximately)
INSERT INTO `teacher_profile_image` (`path`, `teacher_email`) VALUES
	('resources/images/profile_image/Erandi_63bd331f1af96.jpeg', 'erandi@gmail.com'),
	('resources/images/profile_image/Hema_63bd304d1c2ca.jpeg', 'hema@gmail.com'),
	('resources/images/profile_image/Kithsiri_63bd31a4158ef.jpeg', 'kithsiri@gmail.com'),
	('resources/images/profile_image/Lalitha_63bd321a81681.jpeg', 'lalitha@gmail.com'),
	('resources/images/profile_image/Nuwan_63bd32a7a9b66.jpeg', 'nuwan@gmail.com'),
	('resources/images/profile_image/Pawan_63bd33fb28cc3.jpeg', 'pawan@gmail.com'),
	('resources/images/profile_image/Sunil_63bd3261bd65a.jpeg', 'sunil@gmail.com');

-- Dumping structure for table osms.unique_code
CREATE TABLE IF NOT EXISTS `unique_code` (
  `name` varchar(5) NOT NULL,
  `teacher_email` varchar(100) NOT NULL,
  `status` int NOT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `fk_unique_code_teacher1_idx` (`teacher_email`),
  CONSTRAINT `fk_unique_code_teacher1` FOREIGN KEY (`teacher_email`) REFERENCES `teacher` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table osms.unique_code: ~7 rows (approximately)
INSERT INTO `unique_code` (`name`, `teacher_email`, `status`, `id`) VALUES
	('', 'kithsiri@gmail.com', 2, 15),
	('', 'nuwan@gmail.com', 2, 16),
	('', 'sunil@gmail.com', 2, 17),
	('', 'hema@gmail.com', 2, 18),
	('', 'lalitha@gmail.com', 2, 19),
	('', 'erandi@gmail.com', 2, 20),
	('', 'pawan@gmail.com', 2, 21);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
