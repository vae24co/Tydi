-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.7.33 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             11.3.0.6419
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for ziro
DROP DATABASE IF EXISTS `ziro`;
CREATE DATABASE IF NOT EXISTS `ziro` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `ziro`;

-- Dumping structure for table ziro.autho
DROP TABLE IF EXISTS `autho`;
CREATE TABLE IF NOT EXISTS `autho` (
  `auid` bigint(20) NOT NULL AUTO_INCREMENT,
  `puid` char(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `suid` char(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tuid` char(70) COLLATE utf8_unicode_ci DEFAULT NULL,
  `luid` varchar(70) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entry` varchar(80) COLLATE utf8_unicode_ci DEFAULT 'ORIGIN',
  `author` varchar(90) COLLATE utf8_unicode_ci DEFAULT 'ORIGIN',
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `oauthid` char(70) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `verification` enum('UNVERIFIED','VERIFIED','PENDING') COLLATE utf8_unicode_ci DEFAULT 'UNVERIFIED',
  `emailis` enum('UNVERIFIED','VERIFIED','PENDING') COLLATE utf8_unicode_ci DEFAULT 'UNVERIFIED',
  `phoneis` enum('UNVERIFIED','VERIFIED','PENDING') COLLATE utf8_unicode_ci DEFAULT 'UNVERIFIED',
  `condition` enum('OKAY','BANNED','DELETED') COLLATE utf8_unicode_ci DEFAULT 'OKAY',
  `wowid` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `network` json DEFAULT NULL,
  `lastseen` timestamp NULL DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') COLLATE utf8_unicode_ci DEFAULT 'ACTIVE',
  PRIMARY KEY (`auid`) USING BTREE,
  UNIQUE KEY `puid` (`puid`) USING BTREE,
  UNIQUE KEY `suid` (`suid`) USING BTREE,
  UNIQUE KEY `tuid` (`tuid`) USING BTREE,
  UNIQUE KEY `email` (`email`) USING BTREE,
  UNIQUE KEY `phone` (`phone`) USING BTREE,
  UNIQUE KEY `username` (`username`) USING BTREE,
  UNIQUE KEY `oauthid` (`oauthid`) USING BTREE,
  UNIQUE KEY `wowid` (`wowid`) USING BTREE,
  KEY `luid` (`luid`) USING BTREE,
  KEY `created` (`created`) USING BTREE,
  KEY `updated` (`updated`) USING BTREE,
  KEY `entry` (`entry`) USING BTREE,
  KEY `author` (`author`) USING BTREE,
  KEY `password` (`password`) USING BTREE,
  KEY `verification` (`verification`) USING BTREE,
  KEY `emailis` (`emailis`) USING BTREE,
  KEY `phoneis` (`phoneis`) USING BTREE,
  KEY `condition` (`condition`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table ziro.autho: ~0 rows (approximately)
REPLACE INTO `autho` (`auid`, `puid`, `suid`, `tuid`, `luid`, `entry`, `author`, `created`, `updated`, `oauthid`, `email`, `phone`, `username`, `password`, `verification`, `emailis`, `phoneis`, `condition`, `wowid`, `network`, `lastseen`, `status`) VALUES
	(1, 'y3O4fcu6Sq1F01NW9IzZ', 'm473Zqz9nxSp6Gj7l2LCXJ171WgbUv8VdeQ74y4k', 'QHg1r66T5lhG21WU7K55fRzeiuL5Xa2x32Iyq89jPod02t61ZmwnCvFEsMkYAVJ8p4O938', NULL, 'ORIGIN', 'ORIGIN', '2022-03-04 01:45:29', NULL, 'QHg1r66T5lhG21WU7K55fRzeiuL5Xa2x32Iyq89jPod02t61ZmwnCvFEsMkYAVJ8p4O938', 'ao@woca.ng', NULL, 'admin', '$2y$10$TTsrhBYnXL5SlYiYyKYlTe5rCTOoFtmHpECcCxFXQNUt6tN3ULZrC', 'UNVERIFIED', 'UNVERIFIED', 'UNVERIFIED', 'OKAY', '29457', '{"PATREVO": "JOINED", "WOWCATHOLIC": "YES"}', NULL, 'ACTIVE'),
	(2, 'X782i13nw67k65L8jcOW', 'dc76ebN4n0y0tZ9i1j1o3VSU4J67HAf6D5h3B5T5', 'uEseAaTp7Z54VjCk1z454v8ln30Ym6Q36IKOiW045J1yfBdxc1hDtX75M2PNH86bS7gRF9', NULL, 'ORIGIN', 'ORIGIN', '2022-03-04 01:47:07', NULL, 'uEseAaTp7Z54VjCk1z454v8ln30Ym6Q36IKOiW045J1yfBdxc1hDtX75M2PNH86bS7gRF9', 'anthony@osawere.com', '2349026636728', 'iamodao', '$2y$10$CpZoy4N5bXohxjPiZ73EI.SSP7NZQertrn0K.1PzhPKdWrpOdBrGq', 'UNVERIFIED', 'UNVERIFIED', 'UNVERIFIED', 'OKAY', '23608', '{"HARVESTPAD": "JOINED", "WOWCATHOLIC": "YES"}', NULL, 'ACTIVE');

-- Dumping structure for table ziro.feedbacko
DROP TABLE IF EXISTS `feedbacko`;
CREATE TABLE IF NOT EXISTS `feedbacko` (
  `auid` bigint(20) NOT NULL AUTO_INCREMENT,
  `puid` char(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `suid` char(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tuid` char(70) COLLATE utf8_unicode_ci DEFAULT NULL,
  `luid` varchar(70) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entry` varchar(80) COLLATE utf8_unicode_ci DEFAULT 'ORIGIN',
  `author` varchar(90) COLLATE utf8_unicode_ci DEFAULT 'ORIGIN',
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `oauthid` char(70) COLLATE utf8_unicode_ci DEFAULT NULL,
  `platform` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `network` varchar(70) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` varchar(5000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file` json DEFAULT NULL,
  `status` enum('CREATED','PENDING','COMPLETED') COLLATE utf8_unicode_ci DEFAULT 'CREATED',
  PRIMARY KEY (`auid`) USING BTREE,
  UNIQUE KEY `puid` (`puid`) USING BTREE,
  UNIQUE KEY `suid` (`suid`) USING BTREE,
  UNIQUE KEY `tuid` (`tuid`) USING BTREE,
  KEY `luid` (`luid`) USING BTREE,
  KEY `created` (`created`) USING BTREE,
  KEY `updated` (`updated`) USING BTREE,
  KEY `entry` (`entry`) USING BTREE,
  KEY `author` (`author`) USING BTREE,
  KEY `oauthid` (`oauthid`) USING BTREE,
  KEY `username` (`username`) USING BTREE,
  KEY `email` (`email`) USING BTREE,
  KEY `phone` (`phone`) USING BTREE,
  KEY `platform` (`platform`) USING BTREE,
  KEY `network` (`network`) USING BTREE,
  KEY `type` (`type`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table ziro.feedbacko: ~4 rows (approximately)
REPLACE INTO `feedbacko` (`auid`, `puid`, `suid`, `tuid`, `luid`, `entry`, `author`, `created`, `updated`, `oauthid`, `platform`, `network`, `type`, `username`, `email`, `phone`, `name`, `subject`, `message`, `file`, `status`) VALUES
	(1, 'btkHWX6G56SVN3oQY8qc', 'R6s7r1gtZ394p8l23EoOD14mf5WJuhY9SPwV89GC', 'DjVO6tS3yhJiHR6L8BUW0495xMbI91AKp0n6C7F4ecmzflQaNg8Zo8r89T17', NULL, 'ORIGIN', 'ORIGIN', '2022-02-28 11:41:29', '2022-03-01 11:29:06', NULL, 'ANDROID', 'WOW', 'PAYFAIL', NULL, 'anthony@osawere.com', '2349026636728', 'Anthony Osawere', NULL, 'Hello,\nA simple demo complain here.\nI recently tried to pay for my patrevo subscription and I noticed that having selected the amount, an extra zero was subsrtacted; thus I was billed ₦5,000 instead of ₦50,000. Thanks.', NULL, 'CREATED'),
	(2, '0LyrxYa4X2RmI1KZDJUV', '68UIgXp5EO6wB5nC21r5oR1al1N31z0xJthv0AZS', 'ciNwR8lSn34TXMKx65DI3GvpZ2Prf00gBJ6md5148UAV95yWLz5toE10F1Oq', NULL, 'ORIGIN', 'ORIGIN', '2022-02-28 14:35:42', NULL, NULL, 'STAGING', 'WOCA', 'BUG', NULL, 'anthony@osawere.com', NULL, NULL, NULL, 'Hello,\nA simple demo complain here.\nI recently tried to pay for my patrevo subscription and I noticed that having selected the amount, an extra zero was subsrtacted; thus I was billed ₦5,000 instead of ₦50,000. Thanks.', NULL, 'CREATED'),
	(4, '1nQOup0q37UiBxVdwZ64', 'RPm1TOQwH47x9E1f860h62ybnsGJzV0CFI3D4q83', 'OE30VInPD15d9HLCscSRNJUe2lbmKTyo97f046qi8796t4Burj61QAhvG6ZM1z29p51ax8', NULL, 'ORIGIN', 'ORIGIN', '2022-03-01 11:13:20', NULL, NULL, 'STAGING', NULL, 'BUG', NULL, 'anthony@osawere.com', NULL, NULL, NULL, 'Hello,\nA simple demo complain here.\nI recently tried to pay for my patrevo subscription and I noticed that having selected the amount, an extra zero was subsrtacted; thus I was billed ₦5,000 instead of ₦50,000. Thanks.', NULL, 'CREATED'),
	(5, 'rhW1X6QSGB507jK10O1V', 'UXWS1g87TcAYV7CBt6bk5O1n3y9lapQL4f1j10N9', 'g8R40SvdO9m5PhkYL46z1F3e055jtNAE4iZrBx7q5MfT2y633V682sa1HXbWuCU0211KDl', NULL, 'ORIGIN', 'ORIGIN', '2022-03-01 11:28:55', NULL, NULL, 'STAGING', NULL, 'BUG', NULL, 'anthony@osawere.com', NULL, NULL, NULL, 'Hello,\nA simple demo complain here.\nI recently tried to pay for my patrevo subscription and I noticed that having selected the amount, an extra zero was subsrtacted; thus I was billed ₦5,000 instead of ₦50,000. Thanks.', NULL, 'CREATED');

-- Dumping structure for table ziro.networko
DROP TABLE IF EXISTS `networko`;
CREATE TABLE IF NOT EXISTS `networko` (
  `auid` bigint(20) NOT NULL AUTO_INCREMENT,
  `puid` char(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `suid` char(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tuid` char(70) COLLATE utf8_unicode_ci DEFAULT NULL,
  `luid` varchar(70) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entry` varchar(80) COLLATE utf8_unicode_ci DEFAULT 'ORIGIN',
  `author` varchar(90) COLLATE utf8_unicode_ci DEFAULT 'ORIGIN',
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `oauthid` char(70) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `acronym` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `staging` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `web` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `android` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ios` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `key` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`auid`) USING BTREE,
  UNIQUE KEY `puid` (`puid`) USING BTREE,
  UNIQUE KEY `suid` (`suid`) USING BTREE,
  UNIQUE KEY `tuid` (`tuid`) USING BTREE,
  UNIQUE KEY `staging` (`staging`),
  UNIQUE KEY `web` (`web`),
  UNIQUE KEY `android` (`android`),
  UNIQUE KEY `ios` (`ios`),
  UNIQUE KEY `key` (`key`),
  KEY `luid` (`luid`) USING BTREE,
  KEY `created` (`created`) USING BTREE,
  KEY `updated` (`updated`) USING BTREE,
  KEY `entry` (`entry`) USING BTREE,
  KEY `author` (`author`) USING BTREE,
  KEY `oauthid` (`oauthid`) USING BTREE,
  KEY `name` (`name`),
  KEY `acronym` (`acronym`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table ziro.networko: ~4 rows (approximately)
REPLACE INTO `networko` (`auid`, `puid`, `suid`, `tuid`, `luid`, `entry`, `author`, `created`, `updated`, `oauthid`, `name`, `acronym`, `description`, `staging`, `web`, `android`, `ios`, `key`) VALUES
	(1, 'x6O872D7ZtB1o6eq442W', 'L85adr741Xi5O7e9B1cwmh8A8NIEv1FxJlyb0o46', 'J4j9d02amh9N156HpT9cAG4x5K313vBgnSqMWriw8Of67DeoE6tyFI275kLb', NULL, 'ORIGIN', 'ORIGIN', '2022-02-26 23:26:15', '2022-03-03 12:06:57', NULL, 'WOCA Network', 'WOCA', 'The WOCA Network', 'STAGjaPz9K122M7reC5', 'WEBu1p5h28y9KG7FD05IT8bz479a03X2k', 'DROID224436n73c95tF7r9s78A45181oCuY', 'iOS89uice167Pw8j00B4b27U4x6v11259', '0993bDo82n07155seRKJ40Xc7jO4675MI2W8w499'),
	(2, 'CZR6vF9jAT7W1Gl50Q5e', '4V8c7p3144Tz57lL0ojfFS67yIMe1RWQDJqnUrXv', 'AW5a45CpR61o55t7ZByE9lYM9z63gnXVxOIs73vwS1bDu8j4r9c3fkq1Jd2T', NULL, 'ORIGIN', 'ORIGIN', '2022-02-26 23:29:31', '2022-02-26 23:32:10', NULL, 'Patrevo', 'PCD', 'The Patrevo Catholic Dating Platform', 'STAGz35E2017qes257h', 'WEBYqdTiUV1875v97z8202EX309Jrfnay', 'DROIDz4496Lrv7V241SBd7379x568ib315l', 'iOSd638437IsH0nzGX1g8rF9y318Pa4wj', 'a8pCEY8g22kob0986843tvw4M0670n3747U9q214'),
	(3, '4SZl23IY8L5D6GsVeUMu', 'N2p0si1Q1oJKaYT47Dkz1V4vFSrlO4WHng1fqBGx', 'FeA4H91g58X3k8GV41vSzcfZ5o89IKJrR09TDntEsBiaPml7wWLq5xh0pMU1', NULL, 'ORIGIN', 'ORIGIN', '2022-02-26 23:30:14', '2022-02-26 23:32:06', NULL, 'WOWCatholic', 'WOW', 'The WOWCatholic Social Media Platform', 'STAGZW56c84u5I1dUjw', 'WEB3U34S962NzB56s0192tZY7E80M1w89', 'DROIDJ322vg179ue485k106f06D12T4U36a', 'iOS5a05FedBLKC2f0380suU7T32P9z461', '23Uea5VR80LfFTi3xYhB8c1D2p76lm5K65suC417'),
	(4, 'MHr14ozsw60x37IecVW5', '821vPqHGU4394KFmbewJ4n0DI9gT750arkNz1Vd9', 'D6eg71k0m1I123OLvyqdApBGY91Vb5Pf4T36cwtJu36KF5xla747W40CMiZh', NULL, 'ORIGIN', 'ORIGIN', '2022-02-26 23:31:43', '2022-02-26 23:32:03', NULL, 'HarvestPad', 'HP', 'The HarvestPad Platform', 'STAG803DH4GliZg641Y', 'WEBkR9fhD133n41246782B1xwj205G35Q', 'DROIDOQ46E01q973Xi9r8355p641AhYZ8V7', 'iOS76S9aW6ZN0uxtz4Jq7CYf8l3V94gh7', '38fVs9v09CkYd1495Fi28D7q6Gwj42X571OT0W65');

-- Dumping structure for table ziro.parisho
DROP TABLE IF EXISTS `parisho`;
CREATE TABLE IF NOT EXISTS `parisho` (
  `auid` bigint(20) NOT NULL AUTO_INCREMENT,
  `puid` char(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `suid` char(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tuid` char(70) COLLATE utf8_unicode_ci DEFAULT NULL,
  `luid` varchar(70) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entry` varchar(80) COLLATE utf8_unicode_ci DEFAULT 'ORIGIN',
  `author` varchar(90) COLLATE utf8_unicode_ci DEFAULT 'ORIGIN',
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `oauthid` char(70) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `acronym` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `town` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lga` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `diocese` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `province` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `about` varchar(5000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logo` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo` json DEFAULT NULL,
  `video` json DEFAULT NULL,
  `pobox` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `wowcatholic` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `masstime` json DEFAULT NULL,
  `officetime` json DEFAULT NULL,
  `priest` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `associate` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `catechist` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('PUBLISHED','UNPUBLISHED') COLLATE utf8_unicode_ci DEFAULT 'PUBLISHED',
  PRIMARY KEY (`auid`) USING BTREE,
  UNIQUE KEY `puid` (`puid`) USING BTREE,
  UNIQUE KEY `suid` (`suid`) USING BTREE,
  UNIQUE KEY `tuid` (`tuid`) USING BTREE,
  KEY `luid` (`luid`) USING BTREE,
  KEY `created` (`created`) USING BTREE,
  KEY `updated` (`updated`) USING BTREE,
  KEY `entry` (`entry`) USING BTREE,
  KEY `author` (`author`) USING BTREE,
  KEY `oauthid` (`oauthid`) USING BTREE,
  KEY `name` (`name`) USING BTREE,
  KEY `acronym` (`acronym`) USING BTREE,
  KEY `address` (`address`) USING BTREE,
  KEY `diocese` (`diocese`) USING BTREE,
  KEY `province` (`province`) USING BTREE,
  KEY `town` (`town`) USING BTREE,
  KEY `lga` (`lga`) USING BTREE,
  KEY `city` (`city`) USING BTREE,
  KEY `state` (`state`) USING BTREE,
  KEY `country` (`country`) USING BTREE,
  KEY `email` (`email`) USING BTREE,
  KEY `phone` (`phone`) USING BTREE,
  KEY `wowcatholic` (`wowcatholic`) USING BTREE,
  KEY `priest` (`priest`) USING BTREE,
  KEY `associate` (`associate`) USING BTREE,
  KEY `catechist` (`catechist`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table ziro.parisho: ~3 rows (approximately)
REPLACE INTO `parisho` (`auid`, `puid`, `suid`, `tuid`, `luid`, `entry`, `author`, `created`, `updated`, `oauthid`, `name`, `acronym`, `address`, `town`, `lga`, `city`, `state`, `country`, `diocese`, `province`, `about`, `logo`, `photo`, `video`, `pobox`, `email`, `phone`, `website`, `wowcatholic`, `masstime`, `officetime`, `priest`, `associate`, `catechist`, `status`) VALUES
	(1, 'K3CSP62RkBT1U34Eu9r1', '3EN5KT48WlB160JFY4X7my7LOpu12855H1vP8hsj', 'V66iIUTHxhLm340Gny6d0oSb478cf3ZjuEk51N2ewaq008pCQ9sKJP4l84W4', NULL, 'ORIGIN', 'ORIGIN', '2022-02-25 15:59:24', '2022-03-01 00:29:10', NULL, 'St. Joseph', 'SJ', '1st East Circular', '1st East Circular Road', 'Oredo', 'Benin', 'Edo', 'Nigeria', 'Benin Archdiocese', NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'PUBLISHED'),
	(2, 'zFduOjZyihQCY9HwGAsB', 'YBmXV0WST8FQbHRd2Z45A1c4gfJPjnCu3o196q0a', 'k7h1ej6102m79QSVx1nCwDti75XE816UL0qvIR0gKdJ419oH5rByl8G0z4F9', NULL, 'ORIGIN', 'ORIGIN', '2022-03-01 00:25:58', NULL, NULL, 'Christ The King', 'CKC', 'One place for kubwa', 'Kubwa', 'Bwari', 'FCT', 'Abuja', 'Nigeria', 'Abuja Archdiocese', NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'PUBLISHED');

-- Dumping structure for table ziro.profileo
DROP TABLE IF EXISTS `profileo`;
CREATE TABLE IF NOT EXISTS `profileo` (
  `auid` bigint(20) NOT NULL AUTO_INCREMENT,
  `puid` char(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `suid` char(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tuid` char(70) COLLATE utf8_unicode_ci DEFAULT NULL,
  `luid` varchar(70) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entry` varchar(80) COLLATE utf8_unicode_ci DEFAULT 'ORIGIN',
  `author` varchar(90) COLLATE utf8_unicode_ci DEFAULT 'ORIGIN',
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `oauthid` char(70) COLLATE utf8_unicode_ci DEFAULT NULL,
  `brand` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `firstname` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `middlename` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` enum('F','M') COLLATE utf8_unicode_ci DEFAULT NULL,
  `relationship` enum('PRIEST','RELIGIOUS','MARRIED','COURTSHIP','DATING','SINGLE') COLLATE utf8_unicode_ci DEFAULT NULL,
  `nationality` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `living` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bio` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dp` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cp` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `career` json DEFAULT NULL,
  `religion` json DEFAULT NULL,
  `origin` json DEFAULT NULL,
  `passion` json DEFAULT NULL,
  `interest` json DEFAULT NULL,
  `purpose` json DEFAULT NULL,
  PRIMARY KEY (`auid`) USING BTREE,
  UNIQUE KEY `puid` (`puid`) USING BTREE,
  UNIQUE KEY `suid` (`suid`) USING BTREE,
  UNIQUE KEY `tuid` (`tuid`) USING BTREE,
  UNIQUE KEY `oauthid` (`oauthid`) USING BTREE,
  KEY `created` (`created`) USING BTREE,
  KEY `updated` (`updated`) USING BTREE,
  KEY `entry` (`entry`) USING BTREE,
  KEY `author` (`author`) USING BTREE,
  KEY `brand` (`brand`) USING BTREE,
  KEY `firstname` (`firstname`) USING BTREE,
  KEY `lastname` (`lastname`) USING BTREE,
  KEY `middlename` (`middlename`) USING BTREE,
  KEY `dob` (`dob`) USING BTREE,
  KEY `gender` (`gender`) USING BTREE,
  KEY `nationality` (`nationality`) USING BTREE,
  KEY `living` (`living`) USING BTREE,
  KEY `relationship` (`relationship`) USING BTREE,
  KEY `luid` (`luid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table ziro.profileo: ~0 rows (approximately)
REPLACE INTO `profileo` (`auid`, `puid`, `suid`, `tuid`, `luid`, `entry`, `author`, `created`, `updated`, `oauthid`, `brand`, `firstname`, `lastname`, `middlename`, `dob`, `gender`, `relationship`, `nationality`, `living`, `bio`, `dp`, `cp`, `career`, `religion`, `origin`, `passion`, `interest`, `purpose`) VALUES
	(1, '5wb0AYMa4g29X9H6juRV', '7UK40Tq6sL5EtRkyC4Vg1pDJ9fScwQX1P58B7o9Y', 'F1J67kW1rQ3j5VtM0X7uwDKH1oOn8lZ4c4RB74sqT8pi9E2hv266Cda97UgG3Iyf65Sex0', NULL, 'ORIGIN', 'ORIGIN', '2022-03-04 01:45:29', NULL, 'QHg1r66T5lhG21WU7K55fRzeiuL5Xa2x32Iyq89jPod02t61ZmwnCvFEsMkYAVJ8p4O938', NULL, NULL, NULL, NULL, NULL, 'F', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(2, '35kb68MXKN5F3gWY2Ee6', 'mpjU4se8TQgWZGh26CYH4o9cRF1n34vf8K357B5S', 'N7dSyBGuq28oH2e43v5PkW0il07528p2L4smM0YxT31K6A75g418rU6tC6wEaj1VRZFOJn', NULL, 'ORIGIN', 'ORIGIN', '2022-03-04 01:47:07', NULL, 'uEseAaTp7Z54VjCk1z454v8ln30Ym6Q36IKOiW045J1yfBdxc1hDtX75M2PNH86bS7gRF9', NULL, 'Ao™', NULL, NULL, '1987-10-31', 'M', NULL, NULL, 'Abuja, Nigeria', 'Software Engineer', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
