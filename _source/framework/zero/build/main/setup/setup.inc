<?php
/***
* Brux™ Library is a vanilla, evolving collection for developing solutions using web technluidy
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* oSetup ~ The Setup Class • VERSION » alpha-0.0.5 ***/

class oSetup {


	//*----------- AUTH SQL -----------*//
	public static function AuthSQL($table, $type){
		$sql = '';
		if($type === 'DELETE'){
			$sql = "DROP TABLE IF EXISTS `{$table}`;";
		}
		elseif($type === 'CREATE'){
			$sql = "CREATE TABLE IF NOT EXISTS `{$table}`
			(`auid` BIGINT(20) NOT NULL AUTO_INCREMENT,
			`puid` CHAR(20) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`suid` CHAR(40) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`tuid` CHAR(70) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`luid` VARCHAR(70) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`entry` VARCHAR(80) NULL DEFAULT 'ORIGIN' COLLATE 'utf8_unicode_ci',
			`author` VARCHAR(90) NULL DEFAULT 'ORIGIN' COLLATE 'utf8_unicode_ci',
			`created` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
			`updated` DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
			`oauthid` CHAR(70) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`email` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`phone` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`username` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`password` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`verification` ENUM('UNVERIFIED','VERIFIED','PENDING') NULL DEFAULT 'UNVERIFIED' COLLATE 'utf8_unicode_ci',
			`emailis` ENUM('UNVERIFIED','VERIFIED','PENDING') NULL DEFAULT 'UNVERIFIED' COLLATE 'utf8_unicode_ci',
			`phoneis` ENUM('UNVERIFIED','VERIFIED','PENDING') NULL DEFAULT 'UNVERIFIED' COLLATE 'utf8_unicode_ci',
			`condition` ENUM('OKAY','BANNED','DELETED') NULL DEFAULT 'OKAY' COLLATE 'utf8_unicode_ci',
			`wowid` VARCHAR(200) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`network` JSON NULL DEFAULT NULL,
			`kind` VARCHAR(100) NULL DEFAULT 'STANDARD' COLLATE 'utf8_unicode_ci',
			`lastseen` TIMESTAMP NULL DEFAULT NULL,
			`status` ENUM('ACTIVE','INACTIVE') NULL DEFAULT 'ACTIVE' COLLATE 'utf8_unicode_ci',
			PRIMARY KEY (`auid`) USING BTREE,
			UNIQUE INDEX `puid` (`puid`) USING BTREE,
			UNIQUE INDEX `suid` (`suid`) USING BTREE,
			UNIQUE INDEX `tuid` (`tuid`) USING BTREE,
			UNIQUE INDEX `email` (`email`) USING BTREE,
			UNIQUE INDEX `phone` (`phone`) USING BTREE,
			UNIQUE INDEX `username` (`username`) USING BTREE,
			UNIQUE INDEX `oauthid` (`oauthid`) USING BTREE,
			UNIQUE INDEX `wowid` (`wowid`) USING BTREE,
			INDEX `luid` (`luid`) USING BTREE,
			INDEX `created` (`created`) USING BTREE,
			INDEX `updated` (`updated`) USING BTREE,
			INDEX `entry` (`entry`) USING BTREE,
			INDEX `author` (`author`) USING BTREE,
			INDEX `password` (`password`) USING BTREE,
			INDEX `verification` (`verification`) USING BTREE,
			INDEX `emailis` (`emailis`) USING BTREE,
			INDEX `phoneis` (`phoneis`) USING BTREE,
			INDEX `condition` (`condition`) USING BTREE
			)
			COLLATE='utf8_unicode_ci'
			ENGINE=InnoDB
			ROW_FORMAT=DYNAMIC
			AUTO_INCREMENT=1;";
		}
		return $sql;
	}





	//*----------- PROFILE SQL -----------*//
	public static function ProfileSQL($table, $type){
		$sql = '';
		if($type === 'DELETE'){
			$sql = "DROP TABLE IF EXISTS `{$table}`;";
		}
		elseif($type === 'CREATE'){
			$sql = "CREATE TABLE IF NOT EXISTS `{$table}`
			(`auid` BIGINT(20) NOT NULL AUTO_INCREMENT,
			`puid` CHAR(20) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`suid` CHAR(40) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`tuid` CHAR(70) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`luid` VARCHAR(70) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`entry` VARCHAR(80) NULL DEFAULT 'ORIGIN' COLLATE 'utf8_unicode_ci',
			`author` VARCHAR(90) NULL DEFAULT 'ORIGIN' COLLATE 'utf8_unicode_ci',
			`created` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
			`updated` DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
			`oauthid` CHAR(70) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`brand` VARCHAR(200) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`firstname` VARCHAR(200) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`lastname` VARCHAR(200) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`middlename` VARCHAR(200) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`dob` DATE NULL DEFAULT NULL,
			`gender` ENUM('F','M') NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`relationship` ENUM('PRIEST','RELIGIOUS','MARRIED','COURTSHIP','DATING','SINGLE') NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`nationality` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`living` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`bio` VARCHAR(1000) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`dp` VARCHAR(200) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`cp` VARCHAR(200) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`career` JSON NULL DEFAULT NULL,
			`religion` JSON NULL DEFAULT NULL,
			`origin` JSON NULL DEFAULT NULL,
			`passion` JSON NULL DEFAULT NULL,
			`interest` JSON NULL DEFAULT NULL,
			`purpose` JSON NULL DEFAULT NULL,
			PRIMARY KEY (`auid`) USING BTREE,
			UNIQUE INDEX `puid` (`puid`) USING BTREE,
			UNIQUE INDEX `suid` (`suid`) USING BTREE,
			UNIQUE INDEX `tuid` (`tuid`) USING BTREE,
			UNIQUE INDEX `oauthid` (`oauthid`) USING BTREE,
			INDEX `created` (`created`) USING BTREE,
			INDEX `updated` (`updated`) USING BTREE,
			INDEX `entry` (`entry`) USING BTREE,
			INDEX `author` (`author`) USING BTREE,
			INDEX `brand` (`brand`) USING BTREE,
			INDEX `firstname` (`firstname`) USING BTREE,
			INDEX `lastname` (`lastname`) USING BTREE,
			INDEX `middlename` (`middlename`) USING BTREE,
			INDEX `dob` (`dob`) USING BTREE,
			INDEX `gender` (`gender`) USING BTREE,
			INDEX `nationality` (`nationality`) USING BTREE,
			INDEX `living` (`living`) USING BTREE,
			INDEX `relationship` (`relationship`) USING BTREE,
			INDEX `luid` (`luid`) USING BTREE
			)
			COLLATE='utf8_unicode_ci'
			ENGINE=InnoDB
			ROW_FORMAT=DYNAMIC
			AUTO_INCREMENT=1;";
		}
		return $sql;
	}





	//*----------- USER (WOCA) SQL -----------*//
	public static function UserSQL($table, $type){
		$sql = '';
		if($type === 'DELETE'){
			$sql = "DROP TABLE IF EXISTS `{$table}`;";
		}
		elseif($type === 'CREATE'){
			$sql = "CREATE TABLE IF NOT EXISTS `{$table}`
			(`auid` BIGINT(20) NOT NULL AUTO_INCREMENT,
			`puid` CHAR(20) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`suid` CHAR(40) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`tuid` CHAR(70) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`luid` VARCHAR(70) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`entry` VARCHAR(80) NULL DEFAULT 'ORIGIN' COLLATE 'utf8_unicode_ci',
			`author` VARCHAR(90) NULL DEFAULT 'ORIGIN' COLLATE 'utf8_unicode_ci',
			`created` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
			`updated` DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
			`oauthid` CHAR(70) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`token` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`session` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`pin` VARCHAR(10) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`type` VARCHAR(50) NULL DEFAULT 'BASIC' COLLATE 'utf8_unicode_ci',
			`about` VARCHAR(2000) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`passion` VARCHAR(1000) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`dp` VARCHAR(200) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`cp` VARCHAR(200) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`role` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`privilege` JSON NULL DEFAULT NULL,
			`career` JSON NULL DEFAULT NULL,
			`progress` JSON NULL DEFAULT NULL,
			`wallet` DECIMAL(13,2) NULL DEFAULT '0.00',
			`lastseen` DATETIME NULL DEFAULT NULL,
			`access` ENUM('GRANTED','DENIED','SUSPENDED') NULL DEFAULT 'GRANTED' COLLATE 'utf8_unicode_ci',
			PRIMARY KEY (`auid`) USING BTREE,
			UNIQUE INDEX `puid` (`puid`) USING BTREE,
			UNIQUE INDEX `suid` (`suid`) USING BTREE,
			UNIQUE INDEX `tuid` (`tuid`) USING BTREE,
			UNIQUE INDEX `token` (`token`) USING BTREE,
			UNIQUE INDEX `session` (`session`) USING BTREE,
			UNIQUE INDEX `oauthid` (`oauthid`) USING BTREE,
			INDEX `luid` (`luid`) USING BTREE,
			INDEX `created` (`created`) USING BTREE,
			INDEX `updated` (`updated`) USING BTREE,
			INDEX `entry` (`entry`) USING BTREE,
			INDEX `author` (`author`) USING BTREE,
			INDEX `pin` (`pin`) USING BTREE,
			INDEX `type` (`type`) USING BTREE,
			INDEX `role` (`role`) USING BTREE
			)
			COLLATE='utf8_unicode_ci'
			ENGINE=InnoDB
			ROW_FORMAT=DYNAMIC
			AUTO_INCREMENT=1;";
		}
		return $sql;
	}





	//*----------- FEEDBACK SQL -----------*//
	public static function FeedbackSQL($table, $type){
		$sql = '';
		if($type === 'DELETE'){
			$sql = "DROP TABLE IF EXISTS `{$table}`;";
		}
		elseif($type === 'CREATE'){
			$sql = "CREATE TABLE IF NOT EXISTS `{$table}`
			(`auid` BIGINT(20) NOT NULL AUTO_INCREMENT,
			`puid` CHAR(20) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`suid` CHAR(40) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`tuid` CHAR(70) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`luid` VARCHAR(70) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`entry` VARCHAR(80) NULL DEFAULT 'ORIGIN' COLLATE 'utf8_unicode_ci',
			`author` VARCHAR(90) NULL DEFAULT 'ORIGIN' COLLATE 'utf8_unicode_ci',
			`created` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
			`updated` DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
			`oauthid` CHAR(70) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`platform` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`network` VARCHAR(70) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`type` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`username` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`email` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`phone` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`name` VARCHAR(200) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`subject` VARCHAR(150) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`message` VARCHAR(5000) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`file` JSON NULL DEFAULT NULL,
			`status` ENUM('CREATED','PENDING','COMPLETED') NULL DEFAULT 'CREATED' COLLATE 'utf8_unicode_ci',
			PRIMARY KEY (`auid`) USING BTREE,
			UNIQUE INDEX `puid` (`puid`) USING BTREE,
			UNIQUE INDEX `suid` (`suid`) USING BTREE,
			UNIQUE INDEX `tuid` (`tuid`) USING BTREE,
			INDEX `luid` (`luid`) USING BTREE,
			INDEX `created` (`created`) USING BTREE,
			INDEX `updated` (`updated`) USING BTREE,
			INDEX `entry` (`entry`) USING BTREE,
			INDEX `author` (`author`) USING BTREE,
			INDEX `oauthid` (`oauthid`) USING BTREE,
			INDEX `username` (`username`) USING BTREE,
			INDEX `email` (`email`) USING BTREE,
			INDEX `phone` (`phone`) USING BTREE,
			INDEX `platform` (`platform`) USING BTREE,
			INDEX `network` (`network`) USING BTREE,
			INDEX `type` (`type`) USING BTREE
			)
			COLLATE='utf8_unicode_ci'
			ENGINE=InnoDB
			ROW_FORMAT=DYNAMIC
			AUTO_INCREMENT=1;";
		}
		return $sql;
	}





	//*----------- PARISH SQL -----------*//
	public static function ParishSQL($table, $type){
		$sql = '';
		if($type === 'DELETE'){
			$sql = "DROP TABLE IF EXISTS `{$table}`;";
		}
		elseif($type === 'CREATE'){
			$sql = "CREATE TABLE IF NOT EXISTS `{$table}`
			(`auid` BIGINT(20) NOT NULL AUTO_INCREMENT,
			`puid` CHAR(20) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`suid` CHAR(40) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`tuid` CHAR(70) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`luid` VARCHAR(70) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`entry` VARCHAR(80) NULL DEFAULT 'ORIGIN' COLLATE 'utf8_unicode_ci',
			`author` VARCHAR(90) NULL DEFAULT 'ORIGIN' COLLATE 'utf8_unicode_ci',
			`created` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
			`updated` DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
			`oauthid` CHAR(70) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`name` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`acronym` VARCHAR(20) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`address` VARCHAR(200) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`town` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`lga` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`city` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`state` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`country` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`diocese` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`province` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`about` VARCHAR(5000) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`logo` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`photo` JSON NULL DEFAULT NULL,
			`video` JSON NULL DEFAULT NULL,
			`pobox` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`email` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`phone` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`website` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`wowcatholic` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`masstime` JSON NULL DEFAULT NULL,
			`officetime` JSON NULL DEFAULT NULL,
			`priest` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`associate` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`catechist` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`status` ENUM('PUBLISHED','UNPUBLISHED') NULL DEFAULT 'PUBLISHED' COLLATE 'utf8_unicode_ci',
			PRIMARY KEY (`auid`) USING BTREE,
			UNIQUE INDEX `puid` (`puid`) USING BTREE,
			UNIQUE INDEX `suid` (`suid`) USING BTREE,
			UNIQUE INDEX `tuid` (`tuid`) USING BTREE,
			INDEX `luid` (`luid`) USING BTREE,
			INDEX `created` (`created`) USING BTREE,
			INDEX `updated` (`updated`) USING BTREE,
			INDEX `entry` (`entry`) USING BTREE,
			INDEX `author` (`author`) USING BTREE,
			INDEX `oauthid` (`oauthid`) USING BTREE,
			INDEX `name` (`name`) USING BTREE,
			INDEX `acronym` (`acronym`) USING BTREE,
			INDEX `address` (`address`) USING BTREE,
			INDEX `diocese` (`diocese`) USING BTREE,
			INDEX `province` (`province`) USING BTREE,
			INDEX `town` (`town`) USING BTREE,
			INDEX `lga` (`lga`) USING BTREE,
			INDEX `city` (`city`) USING BTREE,
			INDEX `state` (`state`) USING BTREE,
			INDEX `country` (`country`) USING BTREE,
			INDEX `email` (`email`) USING BTREE,
			INDEX `phone` (`phone`) USING BTREE,
			INDEX `wowcatholic` (`wowcatholic`) USING BTREE,
			INDEX `priest` (`priest`) USING BTREE,
			INDEX `associate` (`associate`) USING BTREE,
			INDEX `catechist` (`catechist`) USING BTREE
			)
			COLLATE='utf8_unicode_ci'
			ENGINE=InnoDB
			ROW_FORMAT=DYNAMIC
			AUTO_INCREMENT=1;";
		}
		return $sql;
	}





	//*----------- HARVESTPAD USER SQL -----------*//
	public static function HarvestpadUserSQL($table, $type){
		$sql = '';
		if($type === 'DELETE'){
			$sql = "DROP TABLE IF EXISTS `{$table}`;";
		}
		elseif($type === 'CREATE'){
			$sql = "CREATE TABLE IF NOT EXISTS `{$table}`
			(`auid` BIGINT(20) NOT NULL AUTO_INCREMENT,
			`puid` CHAR(20) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`suid` CHAR(40) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`tuid` CHAR(70) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`luid` VARCHAR(70) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`entry` VARCHAR(80) NULL DEFAULT 'ORIGIN' COLLATE 'utf8_unicode_ci',
			`author` VARCHAR(90) NULL DEFAULT 'ORIGIN' COLLATE 'utf8_unicode_ci',
			`created` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
			`updated` DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
			`oauthid` CHAR(70) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`token` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`session` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`pin` VARCHAR(10) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`type` VARCHAR(50) NULL DEFAULT 'BASIC' COLLATE 'utf8_unicode_ci',
			`about` VARCHAR(2000) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`passion` VARCHAR(1000) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`dp` VARCHAR(200) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`cp` VARCHAR(200) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`role` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`privilege` JSON NULL DEFAULT NULL,
			`career` JSON NULL DEFAULT NULL,
			`progress` JSON NULL DEFAULT NULL,
			`wallet` DECIMAL(13,2) NULL DEFAULT '0.00',
			`lastseen` DATETIME NULL DEFAULT NULL,
			`access` ENUM('GRANTED','DENIED','SUSPENDED') NULL DEFAULT 'GRANTED' COLLATE 'utf8_unicode_ci',
			PRIMARY KEY (`auid`) USING BTREE,
			UNIQUE INDEX `puid` (`puid`) USING BTREE,
			UNIQUE INDEX `suid` (`suid`) USING BTREE,
			UNIQUE INDEX `tuid` (`tuid`) USING BTREE,
			UNIQUE INDEX `token` (`token`) USING BTREE,
			UNIQUE INDEX `session` (`session`) USING BTREE,
			UNIQUE INDEX `oauthid` (`oauthid`) USING BTREE,
			INDEX `luid` (`luid`) USING BTREE,
			INDEX `created` (`created`) USING BTREE,
			INDEX `updated` (`updated`) USING BTREE,
			INDEX `entry` (`entry`) USING BTREE,
			INDEX `author` (`author`) USING BTREE,
			INDEX `pin` (`pin`) USING BTREE,
			INDEX `type` (`type`) USING BTREE,
			INDEX `role` (`role`) USING BTREE
			)
			COLLATE='utf8_unicode_ci'
			ENGINE=InnoDB
			ROW_FORMAT=DYNAMIC
			AUTO_INCREMENT=1;";
		}
		return $sql;
	}





	//*----------- CUPID [PATREVO] SQL -----------*//
	public static function CupidSQL($table, $type){
		$sql = '';
		if($type === 'DELETE'){
			$sql = "DROP TABLE IF EXISTS `{$table}`;";
		}
		elseif($type === 'CREATE'){
			$sql = "CREATE TABLE IF NOT EXISTS `{$table}`
			(`auid` BIGINT(20) NOT NULL AUTO_INCREMENT,
			`puid` CHAR(20) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`suid` CHAR(40) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`tuid` CHAR(70) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`luid` VARCHAR(70) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`entry` VARCHAR(80) NULL DEFAULT 'ORIGIN' COLLATE 'utf8_unicode_ci',
			`author` VARCHAR(90) NULL DEFAULT 'ORIGIN' COLLATE 'utf8_unicode_ci',
			`created` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
			`updated` DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
			`oauthid` CHAR(70) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`token` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`session` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`pin` VARCHAR(10) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`type` VARCHAR(50) NULL DEFAULT 'BASIC' COLLATE 'utf8_unicode_ci',
			`about` VARCHAR(2000) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`passion` VARCHAR(1000) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`subscription` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`dp` VARCHAR(200) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`cp` VARCHAR(200) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`role` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`career` JSON NULL DEFAULT NULL,
			`appearance` JSON NULL DEFAULT NULL,
			`belief` JSON NULL DEFAULT NULL,
			`progress` JSON NULL DEFAULT NULL,
			`privilege` JSON NULL DEFAULT NULL,
			`wallet` DECIMAL(13,2) NULL DEFAULT '0.00',
			`lastseen` DATETIME NULL DEFAULT NULL,
			`access` ENUM('GRANTED','DENIED','SUSPENDED') NULL DEFAULT 'GRANTED' COLLATE 'utf8_unicode_ci',
			PRIMARY KEY (`auid`) USING BTREE,
			UNIQUE INDEX `puid` (`puid`) USING BTREE,
			UNIQUE INDEX `suid` (`suid`) USING BTREE,
			UNIQUE INDEX `tuid` (`tuid`) USING BTREE,
			UNIQUE INDEX `token` (`token`) USING BTREE,
			UNIQUE INDEX `session` (`session`) USING BTREE,
			UNIQUE INDEX `oauthid` (`oauthid`) USING BTREE,
			INDEX `luid` (`luid`) USING BTREE,
			INDEX `created` (`created`) USING BTREE,
			INDEX `updated` (`updated`) USING BTREE,
			INDEX `entry` (`entry`) USING BTREE,
			INDEX `author` (`author`) USING BTREE,
			INDEX `pin` (`pin`) USING BTREE,
			INDEX `type` (`type`) USING BTREE,
			INDEX `role` (`role`) USING BTREE
			)
			COLLATE='utf8_unicode_ci'
			ENGINE=InnoDB
			ROW_FORMAT=DYNAMIC
			AUTO_INCREMENT=1;";
		}
		return $sql;
	}





	//*----------- SWIPE [PATREVO] SQL -----------*//
	public static function SwipeSQL($table, $type){
		$sql = '';
		if($type === 'DELETE'){
			$sql = "DROP TABLE IF EXISTS `{$table}`;";
		}
		elseif($type === 'CREATE'){
			$sql = "CREATE TABLE IF NOT EXISTS `{$table}`
			(`auid` BIGINT(20) NOT NULL AUTO_INCREMENT,
			`puid` CHAR(20) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`suid` CHAR(40) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`tuid` CHAR(70) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`luid` VARCHAR(70) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`entry` VARCHAR(80) NULL DEFAULT 'ORIGIN' COLLATE 'utf8_unicode_ci',
			`author` VARCHAR(90) NULL DEFAULT 'ORIGIN' COLLATE 'utf8_unicode_ci',
			`created` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
			`updated` DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
			`oauthid` CHAR(70) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
			`like` JSON NULL DEFAULT NULL,
			`superlike` JSON NULL DEFAULT NULL,
			`dislike` JSON NULL DEFAULT NULL,
			PRIMARY KEY (`auid`) USING BTREE,
			UNIQUE INDEX `puid` (`puid`) USING BTREE,
			UNIQUE INDEX `suid` (`suid`) USING BTREE,
			UNIQUE INDEX `tuid` (`tuid`) USING BTREE,
			UNIQUE INDEX `oauthid` (`oauthid`) USING BTREE,
			INDEX `luid` (`luid`) USING BTREE,
			INDEX `created` (`created`) USING BTREE,
			INDEX `updated` (`updated`) USING BTREE,
			INDEX `entry` (`entry`) USING BTREE,
			INDEX `author` (`author`) USING BTREE)
			COLLATE='utf8_unicode_ci'
			ENGINE=InnoDB
			ROW_FORMAT=DYNAMIC
			AUTO_INCREMENT=1;";
		}
		return $sql;
	}

} /*** End Of ~oSetup ***/