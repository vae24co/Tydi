<?php
/*** oHTTP ~ oHTTP Class » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © January 2023 | Apache License ***/

class oHTTP extends ModelizrAbstract {

	// ◇ USE •
	// use SQLDatabaseTrait;
	// use CRUDTrait;




	// ◇ PROPERTY •
	protected $database;
	protected $table = 'http';





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
			`type` ENUM('API','WEB') NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
			`ip` VARCHAR(20) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
			`http` VARCHAR(200) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
			`agent` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
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
			INDEX `type` (`type`) USING BTREE,
			INDEX `ip` (`ip`) USING BTREE,
			INDEX `http` (`http`) USING BTREE)";
		$sql .= " COLLATE='utf8mb4_unicode_ci' ENGINE=InnoDB ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1;";
		return $this->exec($sql);
	}





	// ◇ ----- INITIALIZE •
	protected function initialize(mixed $config = []) {

		// + Select Default Table
		if (is_object($this->dbco)) {
			$this->table($this->table, 'USE');
		}
	}

} // End Of Class ~ oHTTP