# ************************************************************
# Sequel Ace SQL dump
# Version 20052
#
# https://sequel-ace.com/
# https://github.com/Sequel-Ace/Sequel-Ace
#
# Host: 115.68.194.177 (MySQL 8.0.34-0ubuntu0.22.04.1)
# Database: Saseul
# Generation Time: 2023-10-30 13:08:28 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE='NO_AUTO_VALUE_ON_ZERO', SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table tb_employ
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tb_employ`;

CREATE TABLE `tb_employ` (
  `emp_id` varchar(20) NOT NULL,
  `cmp_no` varchar(20) NOT NULL,
  `emp_pwd` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `pw_changedt` varchar(10) DEFAULT NULL,
  `emp_nm` varchar(50) NOT NULL,
  `staff_lev` varchar(5) NOT NULL DEFAULT 'EM001',
  `tel_no` varchar(13) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `email_addr` varchar(256) DEFAULT NULL,
  `ip_addr` varchar(15) DEFAULT '127.0.0.1',
  `last_login_tm` varchar(19) DEFAULT NULL,
  `regist_dt` varchar(10) NOT NULL,
  `regist_tm` varchar(8) NOT NULL,
  `regist_id` varchar(50) NOT NULL,
  `update_dt` varchar(10) DEFAULT NULL,
  `update_tm` varchar(8) DEFAULT NULL,
  `update_id` varchar(50) DEFAULT NULL,
  `status_cd` varchar(5) NOT NULL DEFAULT 'UM001',
  PRIMARY KEY (`emp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


INSERT INTO `tb_employ` (`emp_id`, `cmp_no`, `emp_pwd`, `pw_changedt`, `emp_nm`, `staff_lev`, `tel_no`, `email_addr`, `ip_addr`, `last_login_tm`, `regist_dt`, `regist_tm`, `regist_id`, `update_dt`, `update_tm`, `update_id`, `status_cd`)
VALUES
	('admin','node0001','makeAdminPW 만들어진 pw 값','2020-10/30','초롱초롱','EM001','01040880116','jajangjajang@gmail.com','*',NULL,'2023-10-30','16:45:40','SYSTEM','2023-10-30','01:46:19','master','UM001'),
	