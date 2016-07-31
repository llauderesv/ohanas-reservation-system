/*
Navicat MySQL Data Transfer

Source Server         : Connection
Source Server Version : 50621
Source Host           : localhost:3306
Source Database       : ohana

Target Server Type    : MYSQL
Target Server Version : 50621
File Encoding         : 65001

Date: 2016-07-31 14:07:34
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for audit_trail
-- ----------------------------
DROP TABLE IF EXISTS `audit_trail`;
CREATE TABLE `audit_trail` (
  `audit_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `last_name` varchar(40) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `action` varchar(20) NOT NULL,
  `action_date` datetime NOT NULL,
  `type` varchar(20) NOT NULL,
  PRIMARY KEY (`audit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=50053 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of audit_trail
-- ----------------------------
INSERT INTO `audit_trail` VALUES ('50001', 'Llauderes', 'Vincent', 'confirm reservation', '2015-10-08 19:16:47', 'Administrator');
INSERT INTO `audit_trail` VALUES ('50002', 'Llauderes', 'Vincent', 'cancel reservation', '2015-10-08 19:17:54', 'customer');
INSERT INTO `audit_trail` VALUES ('50003', 'Llauderes', 'Vincent', 'RESERVE', '2015-10-08 19:18:33', 'CUSTOMER');
INSERT INTO `audit_trail` VALUES ('50004', 'Llauderes', 'Vincent', 'confirm reservation', '2015-10-08 19:22:51', 'Administrator');
INSERT INTO `audit_trail` VALUES ('50005', 'Llauderes', 'Vench', 'RESERVE', '2015-10-08 20:19:07', 'Customer');
INSERT INTO `audit_trail` VALUES ('50006', 'Llauderes', 'Vincent', 'confirm reservation', '2015-10-08 20:19:24', 'Administrator');
INSERT INTO `audit_trail` VALUES ('50007', 'Llauderes', 'Vincent', 'confirm reservation', '2015-10-08 22:39:12', 'Administrator');
INSERT INTO `audit_trail` VALUES ('50008', 'Llauderes', 'Vincent', 'confirm reservation', '2015-10-08 22:39:15', 'Administrator');
INSERT INTO `audit_trail` VALUES ('50009', 'Llauderes', 'Vincent', 'archive reservation', '2015-10-08 22:39:21', 'Administrator');
INSERT INTO `audit_trail` VALUES ('50010', 'Llauderes', 'Vench', 'RESERVE', '2015-10-08 22:40:40', 'Customer');
INSERT INTO `audit_trail` VALUES ('50011', 'Llauderes', 'Vincent', 'confirm reservation', '2015-10-08 22:40:50', 'Administrator');
INSERT INTO `audit_trail` VALUES ('50012', 'Llauderes', 'Vincent', 'cancel reservation', '2015-10-09 00:53:55', 'customer');
INSERT INTO `audit_trail` VALUES ('50013', 'Llauderes', 'Vianca', 'RESERVE', '2015-10-09 02:02:38', 'Customer');
INSERT INTO `audit_trail` VALUES ('50014', 'Llauderes', 'Vincent', 'RESERVE', '2015-10-10 16:45:16', 'Customer');
INSERT INTO `audit_trail` VALUES ('50015', 'Llauderes', 'Vincent', 'cancel reservation', '2015-10-10 16:48:55', 'customer');
INSERT INTO `audit_trail` VALUES ('50016', 'Llauderes', 'Vincent', 'RESERVE', '2015-10-10 19:57:15', 'Customer');
INSERT INTO `audit_trail` VALUES ('50017', 'Llauderes', 'Vincent', 'confirm reservation', '2015-10-10 19:58:23', 'Administrator');
INSERT INTO `audit_trail` VALUES ('50018', 'Llauderes', 'Vincent', 'delete reservation', '2015-10-10 19:58:27', 'Administrator');
INSERT INTO `audit_trail` VALUES ('50019', 'Llauderes', 'Vincent', 'Edit reservation', '2015-10-10 20:15:11', 'Customer');
INSERT INTO `audit_trail` VALUES ('50020', 'Llauderes', 'Vincent', 'add facilities', '2015-10-11 09:15:53', 'Administrator');
INSERT INTO `audit_trail` VALUES ('50021', 'Llauderes', 'Vincent', 'add facilities', '2015-10-11 09:37:17', 'Administrator');
INSERT INTO `audit_trail` VALUES ('50022', 'Llauderes', 'Vincent', 'add facilities', '2015-10-11 10:17:47', 'Administrator');
INSERT INTO `audit_trail` VALUES ('50023', 'Llauderes', 'Vincent', 'delete facilities', '2015-10-11 10:18:18', 'Administrator');
INSERT INTO `audit_trail` VALUES ('50024', 'Llauderes', 'Vincent', 'delete facilities', '2015-10-11 10:18:21', 'Administrator');
INSERT INTO `audit_trail` VALUES ('50025', 'Llauderes', 'Vincent', 'delete facilities', '2015-10-11 10:18:24', 'Administrator');
INSERT INTO `audit_trail` VALUES ('50026', 'Llauderes', 'Vincent', 'add user', '2015-10-11 10:54:57', 'Administrator');
INSERT INTO `audit_trail` VALUES ('50027', 'Llauderes', 'Vincent', 'delete user', '2015-10-11 10:55:17', 'Administrator');
INSERT INTO `audit_trail` VALUES ('50028', 'Llauderes', 'Vincent', 'edit rooms', '2015-10-11 12:15:12', 'Administrator');
INSERT INTO `audit_trail` VALUES ('50029', 'Llauderes', 'Vincent', 'edit facilities', '2015-10-11 12:17:20', 'Administrator');
INSERT INTO `audit_trail` VALUES ('50030', 'Llauderes', 'Vincent', 'Cancel reservation', '2015-10-12 04:41:56', 'Customer');
INSERT INTO `audit_trail` VALUES ('50031', 'Llauderes', 'Vincent', 'RESERVE', '2015-10-12 14:24:32', 'Customer');
INSERT INTO `audit_trail` VALUES ('50032', 'Llauderes', 'Vincent', 'Cancel reservation', '2015-10-12 14:30:44', 'Customer');
INSERT INTO `audit_trail` VALUES ('50033', 'Llauderes', 'Vincent', 'delete reservation', '2015-10-12 14:47:00', 'Administrator');
INSERT INTO `audit_trail` VALUES ('50034', 'Llauderes', 'Vincent', 'RESERVE', '2015-10-12 19:42:21', 'Customer');
INSERT INTO `audit_trail` VALUES ('50035', 'Llauderes', 'Vincent', 'confirm reservation', '2015-10-12 19:42:33', 'Administrator');
INSERT INTO `audit_trail` VALUES ('50036', 'Llauderes', 'Vincent', 'edit user', '2015-10-13 13:49:02', 'Administrator');
INSERT INTO `audit_trail` VALUES ('50037', 'Llauderes', 'Vincent', 'edit user', '2015-10-13 14:00:03', 'Administrator');
INSERT INTO `audit_trail` VALUES ('50038', 'Llauderes', 'Vincent', 'Cancel reservation', '2015-10-13 14:05:28', 'Customer');
INSERT INTO `audit_trail` VALUES ('50039', 'Llauderes', 'Vincent', 'edit user', '2015-10-13 15:33:15', 'Administrator');
INSERT INTO `audit_trail` VALUES ('50040', 'Llauderes', 'Vincent', 'RESERVE', '2015-10-13 18:45:52', 'Customer');
INSERT INTO `audit_trail` VALUES ('50041', 'Llauderes', 'Vincent', 'Cancel reservation', '2015-11-19 09:29:30', 'Customer');
INSERT INTO `audit_trail` VALUES ('50042', 'Llauderes', 'Vincent', 'RESERVE', '2015-11-19 09:40:12', 'Customer');
INSERT INTO `audit_trail` VALUES ('50043', 'Llauderes', 'Vincent', 'add facilities', '2015-11-20 13:03:29', 'Administrator');
INSERT INTO `audit_trail` VALUES ('50044', 'Llauderes', 'Vincent', 'Edit reservation', '2015-11-23 20:09:35', 'Customer');
INSERT INTO `audit_trail` VALUES ('50045', 'Llauderes', 'Vincent', 'confirm reservation', '2015-11-25 14:00:56', 'Administrator');
INSERT INTO `audit_trail` VALUES ('50046', 'Llauderes', 'Vincent', 'add facilities', '2015-11-25 14:15:20', 'Administrator');
INSERT INTO `audit_trail` VALUES ('50047', 'Llauderes', 'Vincent', 'edit facilities', '2015-11-25 14:15:59', 'Administrator');
INSERT INTO `audit_trail` VALUES ('50048', 'Llauderes', 'Vincent', 'Edit reservation', '2016-01-01 19:24:51', 'Customer');
INSERT INTO `audit_trail` VALUES ('50049', 'Llauderes', 'Vincent', 'Edit reservation', '2016-01-01 19:33:02', 'Customer');
INSERT INTO `audit_trail` VALUES ('50050', 'Diana', 'Cess', 'RESERVE', '2016-01-02 09:48:08', 'Customer');
INSERT INTO `audit_trail` VALUES ('50051', 'Llauderes', 'Vincent', 'confirm reservation', '2016-01-02 09:52:24', 'Administrator');
INSERT INTO `audit_trail` VALUES ('50052', 'Llauderes', 'Vincent', 'Cancel reservation', '2016-02-14 06:33:51', 'Customer');

-- ----------------------------
-- Table structure for customer_account_table
-- ----------------------------
DROP TABLE IF EXISTS `customer_account_table`;
CREATE TABLE `customer_account_table` (
  `account_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) unsigned NOT NULL,
  `username` varchar(40) NOT NULL,
  `pass` char(40) NOT NULL,
  PRIMARY KEY (`account_id`),
  KEY `index_customer_id` (`customer_id`),
  CONSTRAINT `customer_account_table_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer_info_table` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10007 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of customer_account_table
-- ----------------------------
INSERT INTO `customer_account_table` VALUES ('10001', '2015001', 'llauderesv', 'ž×£gYg’\"µ“yvÙŒÿ');
INSERT INTO `customer_account_table` VALUES ('10002', '2015002', 'veejay', 'ž×£gYg’\"µ“yvÙŒÿ');
INSERT INTO `customer_account_table` VALUES ('10003', '2015003', 'vianca08', 'ž×£gYg’\"µ“yvÙŒÿ');
INSERT INTO `customer_account_table` VALUES ('10004', '2015004', 'llauderes321', 'G³¹C\ZŒØ’¬åÈ’');
INSERT INTO `customer_account_table` VALUES ('10005', '2015005', 'llauderesv321', 'ž×£gYg’\"µ“yvÙŒÿ');
INSERT INTO `customer_account_table` VALUES ('10006', '2015006', 'cess321', 'ž×£gYg’\"µ“yvÙŒÿ');

-- ----------------------------
-- Table structure for customer_history_reservation_table
-- ----------------------------
DROP TABLE IF EXISTS `customer_history_reservation_table`;
CREATE TABLE `customer_history_reservation_table` (
  `history_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) unsigned NOT NULL,
  `arrival_date` date NOT NULL,
  `arrival_time` time NOT NULL,
  `departure_date` date NOT NULL,
  `departure_time` time NOT NULL,
  `no_of_persons` int(10) unsigned NOT NULL,
  `days_of_rent` varchar(20) NOT NULL,
  `total_payment` decimal(10,2) unsigned NOT NULL,
  `status` varchar(20) NOT NULL,
  `reference_no` bigint(12) unsigned NOT NULL,
  `down_payment` decimal(10,2) unsigned NOT NULL,
  PRIMARY KEY (`history_id`),
  KEY `index_customer_history_reservation_id` (`history_id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `customer_history_reservation_table_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer_info_table` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=50003 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of customer_history_reservation_table
-- ----------------------------
INSERT INTO `customer_history_reservation_table` VALUES ('50001', '2015001', '2015-10-08', '00:00:00', '2015-10-11', '00:00:00', '30', 'Customer choice', '38500.00', 'Approved', '23423432423', '11550.00');
INSERT INTO `customer_history_reservation_table` VALUES ('50002', '2015002', '2015-10-11', '19:00:00', '2015-10-12', '06:00:00', '30', 'Night time', '9000.00', 'Approved', '34534895743', '2700.00');

-- ----------------------------
-- Table structure for customer_info_table
-- ----------------------------
DROP TABLE IF EXISTS `customer_info_table`;
CREATE TABLE `customer_info_table` (
  `customer_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `last_name` varchar(40) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `middle_name` varchar(20) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `cellphone_no` bigint(12) unsigned NOT NULL,
  `address` varchar(100) NOT NULL,
  `email_address` varchar(50) NOT NULL,
  PRIMARY KEY (`customer_id`),
  KEY `index_customer_id` (`customer_id`),
  KEY `index_full_name` (`last_name`,`first_name`)
) ENGINE=InnoDB AUTO_INCREMENT=2015007 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of customer_info_table
-- ----------------------------
INSERT INTO `customer_info_table` VALUES ('2015001', 'Llauderes', 'Vincent', 'Calma', 'Male', '9105792980', 'General Malvar', 'llauderesv@yahoo.com');
INSERT INTO `customer_info_table` VALUES ('2015002', 'Llauderes', 'Vench', 'Calma', 'Male', '9294335205', 'General Malvar', 'veejay@yahoo.com');
INSERT INTO `customer_info_table` VALUES ('2015003', 'Llauderes', 'Vianca', 'Calma', 'Female', '9105792980', 'General Malvar', 'vianca@yahoo.com');
INSERT INTO `customer_info_table` VALUES ('2015004', 'Llauderes', 'Nadia', 'Calma', 'Female', '9105792980', 'General Malvar', 'nadia@yahoo.com');
INSERT INTO `customer_info_table` VALUES ('2015005', 'Llauderes', 'Vincent', 'Calma', 'Male', '9294335205', 'General Malv', 'llauderes@yahoo.com');
INSERT INTO `customer_info_table` VALUES ('2015006', 'Diana', 'Cess', '', 'Male', '9294335205', '166 General Malvar', 'cess@yahoo.com');

-- ----------------------------
-- Table structure for customer_reservation_table
-- ----------------------------
DROP TABLE IF EXISTS `customer_reservation_table`;
CREATE TABLE `customer_reservation_table` (
  `reservation_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) unsigned NOT NULL,
  `arrival_date` date NOT NULL,
  `arrival_time` time NOT NULL,
  `departure_date` date NOT NULL,
  `departure_time` time NOT NULL,
  `no_of_persons` int(10) unsigned NOT NULL,
  `days_of_rent` varchar(20) NOT NULL,
  `total_payment` decimal(10,2) unsigned NOT NULL,
  `status` varchar(20) NOT NULL,
  `reference_no` bigint(12) unsigned NOT NULL,
  `down_payment` decimal(10,2) unsigned NOT NULL,
  PRIMARY KEY (`reservation_id`),
  KEY `index_customer_reservation_id` (`reservation_id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `customer_reservation_table_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer_info_table` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=30003 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of customer_reservation_table
-- ----------------------------
INSERT INTO `customer_reservation_table` VALUES ('30002', '2015006', '2016-01-06', '08:00:00', '2016-01-06', '17:00:00', '60', 'Day time', '10000.00', 'Approved', '12398729384', '3000.00');

-- ----------------------------
-- Table structure for customer_room_paid_table
-- ----------------------------
DROP TABLE IF EXISTS `customer_room_paid_table`;
CREATE TABLE `customer_room_paid_table` (
  `room_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `reservation_id` int(10) unsigned NOT NULL,
  `no_of_rooms` int(10) unsigned NOT NULL,
  PRIMARY KEY (`room_id`),
  KEY `index_customer_room_paid_id` (`room_id`),
  KEY `reservation_id` (`reservation_id`),
  CONSTRAINT `customer_room_paid_table_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `customer_reservation_table` (`reservation_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=40003 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of customer_room_paid_table
-- ----------------------------
INSERT INTO `customer_room_paid_table` VALUES ('40002', '30002', '2');

-- ----------------------------
-- Table structure for facilities_package_table
-- ----------------------------
DROP TABLE IF EXISTS `facilities_package_table`;
CREATE TABLE `facilities_package_table` (
  `facilities_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `facilities_name` varchar(50) NOT NULL,
  `description` varchar(500) NOT NULL,
  `capacity` bigint(5) unsigned NOT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY (`facilities_id`),
  KEY `index_facilities_id` (`facilities_id`),
  KEY `index_facilities_name` (`facilities_name`)
) ENGINE=InnoDB AUTO_INCREMENT=2015008 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of facilities_package_table
-- ----------------------------
INSERT INTO `facilities_package_table` VALUES ('2015001', 'Wedding Reception', 'This is a sample description only don\'t make it seriously promise', '200', '11928855_10207652184002205_171070741_o.jpg');
INSERT INTO `facilities_package_table` VALUES ('2015002', 'Pool', 'This is a sample description only don\'t make it serious', '60', '11906939_10207652196762524_781347312_o.jpg');
INSERT INTO `facilities_package_table` VALUES ('2015003', 'Private Pool', 'This is a sample description only don\'t make it seriously', '60', '3.jpg');
INSERT INTO `facilities_package_table` VALUES ('2015004', 'Nipa Hut', 'This is a sample only', '10', '11899190_10207651855713998_482627560_o.jpg');
INSERT INTO `facilities_package_table` VALUES ('2015005', 'Kiddie Pool', 'This is a sample only dont\' make it seriusly', '100', '11948493_10207652211162884_1197161351_o.jpg');
INSERT INTO `facilities_package_table` VALUES ('2015006', 'Private Pool', 'This is a sample description', '100', '11872890_1153965231286430_397907850_n.jpg');
INSERT INTO `facilities_package_table` VALUES ('2015007', 'Nipa Hut', 'This nipa hut is the place where people can make their happiness', '20', '5.jpg');

-- ----------------------------
-- Table structure for paid_room_table
-- ----------------------------
DROP TABLE IF EXISTS `paid_room_table`;
CREATE TABLE `paid_room_table` (
  `room_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `room_name` varchar(50) NOT NULL,
  `description` varchar(500) NOT NULL,
  `capacity` bigint(5) unsigned NOT NULL,
  `price` decimal(6,2) unsigned NOT NULL,
  `room_type` varchar(50) NOT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY (`room_id`),
  KEY `index_room_id` (`room_id`),
  KEY `index_room_name` (`room_name`)
) ENGINE=InnoDB AUTO_INCREMENT=2015003 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of paid_room_table
-- ----------------------------
INSERT INTO `paid_room_table` VALUES ('2015001', 'Hotel Room 1', 'This is a sample only don\'t make it seriously ', '15', '1000.00', 'Dorm type', '11920362_10207639147356297_968734006_n.jpg');
INSERT INTO `paid_room_table` VALUES ('2015002', 'Condo Room', 'This is a sample only don\'t make it seriously', '10', '1500.00', 'Condo type', '11923059_10207639143076190_826462829_n.jpg');

-- ----------------------------
-- Table structure for user_account_table
-- ----------------------------
DROP TABLE IF EXISTS `user_account_table`;
CREATE TABLE `user_account_table` (
  `account_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `username` varchar(40) NOT NULL,
  `pass` char(40) NOT NULL,
  `user_type` varchar(20) NOT NULL,
  PRIMARY KEY (`account_id`),
  KEY `index_account_id` (`account_id`),
  KEY `index_user_id` (`user_id`),
  CONSTRAINT `user_account_table_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_info_table` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1004 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user_account_table
-- ----------------------------
INSERT INTO `user_account_table` VALUES ('1001', '2015001', 'llauderesv', 'ž×£gYg’\"µ“yvÙŒÿ', 'Administrator');
INSERT INTO `user_account_table` VALUES ('1002', '2015002', 'vianca08', 'ž×£gYg’\"µ“yvÙŒÿ', 'Book Manager');
INSERT INTO `user_account_table` VALUES ('1003', '2015003', 'lansi', 'ž×£gYg’\"µ“yvÙŒÿ', 'Book Manager');

-- ----------------------------
-- Table structure for user_info_table
-- ----------------------------
DROP TABLE IF EXISTS `user_info_table`;
CREATE TABLE `user_info_table` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `last_name` varchar(40) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `middle_name` varchar(20) NOT NULL DEFAULT 'NONE',
  `gender` varchar(6) NOT NULL,
  `cellphone_no` bigint(12) unsigned NOT NULL,
  `address` varchar(100) NOT NULL,
  `email_address` varchar(50) NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `index_user_id` (`user_id`),
  KEY `index_full_name` (`last_name`,`first_name`)
) ENGINE=InnoDB AUTO_INCREMENT=2015004 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user_info_table
-- ----------------------------
INSERT INTO `user_info_table` VALUES ('2015001', 'Llauderes', 'Vincent', 'Calma', 'Male', '639294335205', 'Caloocan City', 'vllauderes@yahoo.com');
INSERT INTO `user_info_table` VALUES ('2015002', 'Llauderes', 'Vianca', 'Calma', 'Female', '639294335205', '166 General malvar Bagong Barrio Caloocan City', 'vianca@yahoo.com');
INSERT INTO `user_info_table` VALUES ('2015003', 'Delacruz', 'Lance', 'Talosig', 'Male', '639294335205', '166 General Caloocan City', 'lance@yahoo.com');

-- ----------------------------
-- View structure for customer
-- ----------------------------
DROP VIEW IF EXISTS `customer`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost`  VIEW `customer` AS SELECT b.customer_id, b.last_name, b.first_name, b.middle_name,
b.gender, b.cellphone_no, b.address, b.email_address, a.username
FROM customer_account_table AS a INNER JOIN customer_info_table AS b
ON b.customer_id = a.customer_id ;

-- ----------------------------
-- View structure for history_reservation
-- ----------------------------
DROP VIEW IF EXISTS `history_reservation`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost`  VIEW `history_reservation` AS SELECT a.last_name, a.first_name, a.middle_name, b.history_id, b.arrival_date, b.arrival_time, b.departure_date,
b.departure_time, b.no_of_persons, b.days_of_rent, b.total_payment, b.status,
b.reference_no, b.down_payment, b.customer_id FROM customer_info_table AS a INNER JOIN customer_history_reservation_table AS b 
ON a.customer_id = b.customer_id ;

-- ----------------------------
-- View structure for reservation
-- ----------------------------
DROP VIEW IF EXISTS `reservation`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost`  VIEW `reservation` AS SELECT a.last_name, a.first_name, a.middle_name, b.reservation_id, b.arrival_date, b.arrival_time, b.departure_date,
b.departure_time, b.no_of_persons, b.days_of_rent, b.total_payment, b.status,
b.reference_no, b.down_payment, b.customer_id FROM customer_info_table AS a INNER JOIN customer_reservation_table AS b
ON a.customer_id = b.customer_id ;

-- ----------------------------
-- View structure for user
-- ----------------------------
DROP VIEW IF EXISTS `user`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost`  VIEW `user` AS SELECT a.user_id, a.last_name, 
	a.first_name, a.middle_name,
	b.user_type, a.gender, a.cellphone_no, 
	a.address, a.email_address, b.username
	FROM user_account_table AS b
	INNER JOIN user_info_table AS a
	ON a.user_id = b.user_id 
	ORDER BY a.last_name ASC ;

-- ----------------------------
-- View structure for user_table
-- ----------------------------
DROP VIEW IF EXISTS `user_table`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost`  VIEW `user_table` AS SELECT a.user_id, a.last_name,
	a.first_name, b.user_type,
	b.username, b.pass FROM 
	user_account_table AS b
	INNER JOIN user_info_table AS a
	ON a.user_id = b.user_id ;
