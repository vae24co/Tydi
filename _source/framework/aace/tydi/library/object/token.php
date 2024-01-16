<?php
/*** oToken ~ oToken Class » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © January 2023 | Apache License ***/

class oToken extends ModelizrAbstract {

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
			`puid` char(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			`suid` char(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			`tuid` char(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			`luid` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			`entry` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT 'ORIGIN',
			`author` varchar(90) COLLATE utf8mb4_unicode_ci DEFAULT 'ORIGIN',
			`created` datetime DEFAULT CURRENT_TIMESTAMP,
			`updated` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
			`oauthid` char(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			`okey` char(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			`token` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			`authorized` enum('NO','YES') COLLATE utf8mb4_unicode_ci DEFAULT 'NO',
			`authenticated` enum('NO','YES') COLLATE utf8mb4_unicode_ci DEFAULT 'NO',
			`device` json DEFAULT NULL,
			`osaas` char(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			`type` enum('DEV','STAG','PROD') COLLATE utf8mb4_unicode_ci DEFAULT 'DEV',
			`client` enum('CLIENT','BROWSER','IOS','ANDROID','DESKTOP') COLLATE utf8mb4_unicode_ci DEFAULT 'CLIENT',
			`status` enum('ACTIVE','INACTIVE','TIMEOUT','TIMED') COLLATE utf8mb4_unicode_ci DEFAULT 'ACTIVE',
			`timeout` datetime DEFAULT NULL,
			PRIMARY KEY (`auid`) USING BTREE,
			UNIQUE KEY `puid` (`puid`) USING BTREE,
			UNIQUE KEY `suid` (`suid`) USING BTREE,
			UNIQUE KEY `tuid` (`tuid`) USING BTREE,
			UNIQUE KEY `token` (`token`) USING BTREE,
			INDEX `luid` (`luid`) USING BTREE,
			INDEX `created` (`created`) USING BTREE,
			INDEX `updated` (`updated`) USING BTREE,
			INDEX `entry` (`entry`) USING BTREE,
			INDEX `author` (`author`) USING BTREE,
			INDEX `oauthid` (`oauthid`) USING BTREE,
			INDEX `type` (`type`) USING BTREE,
			INDEX `client` (`client`) USING BTREE,
			INDEX `osaas` (`osaas`) USING BTREE,
			INDEX `authorized` (`authorized`) USING BTREE,
			INDEX `authenticated` (`authenticated`),
			INDEX `okey` (`okey`),
			INDEX `timeout` (`timeout`) USING BTREE,
			INDEX `status` (`status`) USING BTREE)";
		$sql .= " COLLATE='utf8mb4_unicode_ci' ENGINE=InnoDB ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1;";
		return $this->exec($sql);
	}





	// ◇ ----- TOKENIZE - Update Token Session
	public function tokenize($token, $input, $timeout) {
		$filter = ['token' => $token];
		$input['status'] = 'ACTIVE';
		$input['timeout'] = Time::SQL('DATETIME', $timeout);
		return $this->oUpdateOne($filter, $input);
	}





	// ◇ ----- REGENERATE • Regenerate Token (Update Timeout Duration & Status)
	public function regenerate($token, $status, $timeout) {
		$reToken = Random::token();
		$filter = ['token' => $token];
		$input = ['token' => $reToken, 'status' => $status];
		$input['timeout'] = Time::SQL('DATETIME', $timeout);
		$update = $this->oUpdateOne($filter, $input);
		if (DataQ::isPositive($update)) {
			return ['token' => $token, 'retoken' => $reToken, 'status' => $status];
		}
		return $update;
	}





	// ◇ ----- AUTHORIZE • Authorize Token
	public function authorize($token, $timeout) {
		$filter['token'] = $token;
		$input = [
			'authorized' => 'YES',
			'status' => 'ACTIVE',
			'timeout' => Time::SQL('DATETIME', $timeout)
		];
		return $this->oUpdateOne($filter, $input);
	}





	// ◇ ----- DEAUTHORIZE • Deauthorize Token
	public function deauthorize($token, $timeout) {
		$filter['token'] = $token;
		$input = [
			'authorized' => 'NO',
			'status' => 'ACTIVE',
			'timeout' => Time::SQL('DATETIME', $timeout)
		];
		return $this->oUpdateOne($filter, $input);
	}





	// ◇ ----- AUTHENTICATE • Authenticate Token
	public function authenticate($token, $authID, $timeout) {
		$reToken = Random::token();
		$filter['token'] = $token;
		$input = [
			'oauthid' => $authID,
			'authorized' => 'YES',
			'authenticated' => 'YES',
			'status' => 'ACTIVE',
			'timeout' => Time::SQL('DATETIME', $timeout),
			'token' => $reToken
		];
		$update = $this->oUpdateOne($filter, $input);
		if (DataQ::isPositive($update)) {
			return ['retoken' => $reToken];
		}
		return $update;
	}





	// ◇ ----- LOGOUT • Logout Token
	public function logout($token) {
		$reToken = Random::token();
		$filter['token'] = $token;
		$input = [
			'oauthid' => null,
			'authorized' => 'YES',
			'authenticated' => 'NO',
			'status' => 'ACTIVE',
			'timeout' => Time::SQL('DATETIME', TOKEN_TIMEOUT),
			'token' => $reToken
		];
		$update = $this->oUpdateOne($filter, $input);
		if (DataQ::isPositive($update)) {
			return ['retoken' => $reToken];
		}
		return $update;
	}

} // End Of Class ~ oToken