<?php
/*** LogO ~ Log Class » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © January 2023 | Apache License ***/

class LogO extends ModelizrAbstract {

	// ◇ PROPERTY
	protected $id;
	protected $database;
	protected $table;
	public $singleTable = false;





	// ◇ ----- INITIALIZE •
	protected function initialize($config = []) {
		global $Session;
		if (VarX::isObject($Session)) {
			$logID = $Session->is('logID');
			if (VarX::hasData($logID)) {
				$this->id = $logID;
			} else {
				$logID = Random::luid(60);
				$Session->is('logID', $logID);
				$this->id = $logID;
			}
		}
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
				`model` VARCHAR(30) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
				`action` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
				`summary` TEXT NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
				`type` ENUM('ACTIVITY') NULL DEFAULT 'ACTIVITY' COLLATE 'utf8mb4_unicode_ci',
				`report` ENUM('SUCCESS','ERROR','FAILURE','DONE') NULL DEFAULT 'DONE' COLLATE 'utf8mb4_unicode_ci',
				`device` JSON NULL DEFAULT NULL,
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
				INDEX `report` (`report`) USING BTREE,
				INDEX `action` (`action`) USING BTREE,
				INDEX `model` (`model`) USING BTREE,
				FULLTEXT INDEX `summary` (`summary`))";
		$sql .= " COLLATE='utf8mb4_unicode_ci' ENGINE=InnoDB ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1;";
		return $this->exec($sql);
	}





	// ◇ ----- ID • LogID (luid)
	public function id() {
		if (VarX::hasData($this->id)) {
			return $this->id;
		}
		return null;
	}




	public function tableSetTo($action) {
		// + Set Table for Use
		if ($this->singleTable) {
			$this->table = 'log';
		} else {
			$this->table = 'log_' . strtolower($action);
		}

		// + Create Table (if it doesn't exists)
		if (!$this->isTable($this->table, $this->database)) {
			$this->install($this->table);
		}


		// + Set Default Table
		if (is_object($this->dbco)) {
			$this->oTable($this->table, 'USE');
		}

		return true;
	}





	// ◇ ----- REGISTER SUCCESS •
	public function registerSuccess($authID = null, $summary = 'User registration successful') {
		$input = [
			'oauthid' => $authID,
			'model' => 'AUTH',
			'action' => 'Registration',
			'report' => 'SUCCESS',
			'type' => 'ACTIVITY',
			'summary' => $summary,
			'luid' => $this->id()
		];
		$this->tableSetTo($input['action']);
		return $this->oCreate($input, 'COUNT');
	}





	// ◇ ----- LOGIN SUCCESS •
	public function loginSuccess($authID = null, $summary = 'User logged in successfully') {
		$input = [
			'oauthid' => $authID,
			'model' => 'AUTH',
			'action' => 'Login',
			'report' => 'SUCCESS',
			'type' => 'ACTIVITY',
			'summary' => $summary,
			'luid' => $this->id()
		];
		$this->tableSetTo($input['action']);
		return $this->oCreate($input, 'COUNT');
	}





	// ◇ ----- LOGOUT •
	public function logout($authID = null, $summary = 'User logged out successfully') {
		$input = [
			'oauthid' => $authID,
			'model' => 'AUTH',
			'action' => 'Logout',
			'report' => 'SUCCESS',
			'type' => 'ACTIVITY',
			'summary' => $summary,
			'luid' => $this->id()
		];
		$this->tableSetTo($input['action']);
		return $this->oCreate($input, 'COUNT');
	}
} // End Of Class ~ LogO