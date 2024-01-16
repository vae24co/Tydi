<?php
/*** oSAAS ~ oSAAS Class » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © January 2023 | Apache License ***/

class oSAAS extends ModelizrAbstract {

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
			`saasid` CHAR(10) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
			`brand` VARCHAR(20) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
			`acronym` VARCHAR(30) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
			`title` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
			`description` VARCHAR(300) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
			`contact` JSON NULL DEFAULT NULL,
			`status` ENUM('ACTIVE','INACTIVE') NULL DEFAULT 'ACTIVE' COLLATE 'utf8mb4_unicode_ci',
			PRIMARY KEY (`auid`) USING BTREE,
			UNIQUE INDEX `puid` (`puid`) USING BTREE,
			UNIQUE INDEX `suid` (`suid`) USING BTREE,
			UNIQUE INDEX `tuid` (`tuid`) USING BTREE,
			UNIQUE INDEX `brand` (`brand`) USING BTREE,
			UNIQUE INDEX `saasid` (`saasid`) USING BTREE,
			INDEX `luid` (`luid`) USING BTREE,
			INDEX `created` (`created`) USING BTREE,
			INDEX `updated` (`updated`) USING BTREE,
			INDEX `entry` (`entry`) USING BTREE,
			INDEX `author` (`author`) USING BTREE,
			INDEX `oauthid` (`oauthid`) USING BTREE,
			INDEX `acronym` (`acronym`) USING BTREE,
			INDEX `title` (`title`) USING BTREE,
			INDEX `status` (`status`) USING BTREE)";
		$sql .= " COLLATE='utf8mb4_unicode_ci' ENGINE=InnoDB ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1;";
		return $this->exec($sql);
	}





	// ◇ ----- DATA BY SAAS ID •
	public function dataBySaaSID($saasID, $column = null) {
		$filter = ['saasid' => $saasID];
		if (VarX::hasNoData($column)) {
			$column = ['tuid' => 'bind', 'saasid', 'brand', 'status'];
		}
		return $this->oFindOne($filter, $column);
	}

} // End Of Class ~ oSAAS