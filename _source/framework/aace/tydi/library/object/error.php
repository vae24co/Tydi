<?php
/*** oError ~ oError Class » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © January 2023 | Apache License ***/

class oError extends ModelizrAbstract {

	// ◇ USE •
	// use SQLDatabaseTrait;
	// use CRUDTrait;




	// ◇ PROPERTY •
	protected $database;
	protected $table;





	// ◇ ----- INITIALIZE •
	protected function initialize(mixed $config = []) {
	}





	// ◇ ----- INSTALL •
	protected function install($table) {
		$sql = "CREATE TABLE IF NOT EXISTS `{$table}` (
			`auid` BIGINT NOT NULL AUTO_INCREMENT,
			`puid` CHAR(20) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
			`suid` CHAR(40) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
			`tuid` CHAR(70) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
			`luid` VARCHAR(70) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
			`entry` VARCHAR(80) NULL DEFAULT 'ORIGIN' COLLATE 'utf8mb4_unicode_ci',
			`author` VARCHAR(90) NULL DEFAULT 'ORIGIN' COLLATE 'utf8mb4_unicode_ci',
			`created` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
			`updated` DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
			`oauthid` CHAR(70) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
			`token` CHAR(100) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
			`report` VARCHAR(2000) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
			`status` ENUM('REPORTED','RESOLVED','DELETE') NULL DEFAULT 'REPORTED' COLLATE 'utf8mb4_unicode_ci',
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
			INDEX `token` (`token`) USING BTREE,
			INDEX `status` (`status`) USING BTREE)";
		$sql .= " COLLATE='utf8mb4_unicode_ci' ENGINE=InnoDB ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1;";
		return $this->exec($sql);
	}

} // End Of Class ~ oError