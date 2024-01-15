<?php
class oSetupUser {

	// • ==== SQL →
	public static function SQL($table, $req) {
		$sql = false;
		if ($req === 'DELETE') {
			$sql = "DROP TABLE IF EXISTS `{$table}`;";
		} elseif ($req === 'CREATE') {
			$sql = "CREATE TABLE IF NOT EXISTS `{$table}`
			(`auid` bigint NOT NULL AUTO_INCREMENT,
			`puid` char(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			`suid` char(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			`tuid` char(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			`created` datetime DEFAULT CURRENT_TIMESTAMP,
			`updated` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
			`entry` enum('ORIGIN','FIXED','STATIC') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'ORIGIN',
			`status` enum('NEW','PENDING','ACTIVE','INACTIVE','BANNED','DEACTIVATED','DELETED') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			`author` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'ORIGIN',
			`lastseen` timestamp NULL DEFAULT NULL,
			`password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			`id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			`phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			`username` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			`email` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			`firstname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			`lastname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			`middlename` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			`nickname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			`nationality` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			`nin` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			`dob` date DEFAULT NULL,
			`gender` enum('F','M') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			`relationship` enum('SINGLE','PARTNERSHIP','MARRIED','SEPARATED','DIVORCED') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			`type` enum('MASTER','ADMIN','MANAGER','SUPERVISOR','STANDARD','BASIC') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			`flag` enum('NORMAL','PASSWORD_CHANGED','PASSWORD_CHANGE_REQUIRED','PASSWORD_TEMPORARY','PASSWORD_GENERATED','OTP') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'NORMAL',
			`kind` enum('PERSON','OFFICE') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			`religion` enum('CHRISTIAN','MUSLIM','TRADITIONALIST') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			`role` set('SYSTEM','MASTER','ADMIN','PROFESSIONAL','ADHOC','REFERRER') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			`designation` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			`bio` TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			`dp` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			`cp` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			`sign` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			`origin` json DEFAULT NULL,
			`contact` json DEFAULT NULL,
			`nok` json DEFAULT NULL,
			`verified` json DEFAULT NULL,
			`otp` json DEFAULT NULL,
			`token` json DEFAULT NULL,
			PRIMARY KEY (`auid`) USING BTREE,
			UNIQUE KEY `puid` (`puid`) USING BTREE,
			UNIQUE KEY `suid` (`suid`) USING BTREE,
			UNIQUE KEY `tuid` (`tuid`) USING BTREE,
			UNIQUE KEY `phone` (`phone`) USING BTREE,
			UNIQUE KEY `username` (`username`) USING BTREE,
			UNIQUE KEY `email` (`email`) USING BTREE,
			KEY `created` (`created`) USING BTREE,
			KEY `updated` (`updated`) USING BTREE,
			KEY `entry` (`entry`) USING BTREE,
			KEY `status` (`status`) USING BTREE,
			KEY `author` (`author`) USING BTREE,
			KEY `lastseen` (`lastseen`) USING BTREE,
			KEY `id` (`id`) USING BTREE,
			KEY `firstname` (`firstname`) USING BTREE,
			KEY `lastname` (`lastname`) USING BTREE,
			KEY `middlename` (`middlename`) USING BTREE,
			KEY `nickname` (`nickname`) USING BTREE,
			KEY `nationality` (`nationality`) USING BTREE,
			KEY `nin` (`nin`) USING BTREE,
			KEY `dob` (`dob`) USING BTREE,
			KEY `gender` (`gender`) USING BTREE,
			KEY `relationship` (`relationship`) USING BTREE,
			KEY `type` (`type`) USING BTREE,
			KEY `flag` (`flag`) USING BTREE,
			KEY `kind` (`kind`) USING BTREE,
			KEY `religion` (`religion`) USING BTREE,
			KEY `role` (`role`) USING BTREE,
			KEY `designation` (`designation`) USING BTREE,
			FULLTEXT INDEX `bio` (`bio`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1;";
		}
		return $sql;
	}




	// • ==== DataSQL →
	public static function DataSQL() {

	}

} //> end of oSetupUser