<?php
/*** UserO ~ User Class » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © January 2023 | Apache License ***/

class UserO extends ModelizrAbstract {

	// ◇ PROPERTY •
	protected $database;
	protected $table;





	// ◇ ----- mTOKEN • Token Model
	private function mToken() {
		return new TokenModel(['dbco' => $this->dbco]);
	}





	// ◇ ----- INITIALIZE •
	protected function initialize($config = []) {
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
			`phone` VARCHAR(20) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
			`username` VARCHAR(30) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
			`email` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
			`password` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
			`brand` VARCHAR(200) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
			`firstname` VARCHAR(200) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
			`lastname` VARCHAR(200) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
			`middlename` VARCHAR(200) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
			`dob` DATE NULL DEFAULT NULL,
			`gender` ENUM('F','M') NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
			`relationship` ENUM('PRIEST','RELIGIOUS','MARRIED','COURTSHIP','DATING','SINGLE') NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
			`nationality` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
			`living` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
			`bio` VARCHAR(1000) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
			`dp` VARCHAR(200) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
			`cp` VARCHAR(200) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
			`career` JSON NULL DEFAULT NULL,
			`religion` JSON NULL DEFAULT NULL,
			`origin` JSON NULL DEFAULT NULL,
			`passion` JSON NULL DEFAULT NULL,
			`interest` JSON NULL DEFAULT NULL,
			`purpose` JSON NULL DEFAULT NULL,
			`verifiedEmail` ENUM('NO','YES','PENDING') NULL DEFAULT 'NO' COLLATE 'utf8mb4_unicode_ci',
			`verifiedPhone` ENUM('NO','YES','PENDING') NULL DEFAULT 'NO' COLLATE 'utf8mb4_unicode_ci',
			`verified` ENUM('NO','YES','PENDING') NULL DEFAULT 'NO' COLLATE 'utf8mb4_unicode_ci',
			`type` ENUM('MASTER','ADMIN','MANAGER','SUPERVISOR','STANDARD','BASIC') NULL DEFAULT 'BASIC' COLLATE 'utf8mb4_unicode_ci',
			`status` ENUM('NEW','PENDING','ACTIVE','INACTIVE','BANNED','DEACTIVATED','DELETED') NULL DEFAULT 'NEW' COLLATE 'utf8mb4_unicode_ci',
			`flag` ENUM('NORMAL','PASSWORD_CHANGED','PASSWORD_CHANGE_REQUIRED','PASSWORD_TEMPORARY','PASSWORD_GENERATED','OTP') NULL DEFAULT 'NORMAL' COLLATE 'utf8mb4_unicode_ci',
			`kind` ENUM('PERSON','OFFICE') NULL DEFAULT 'PERSON' COLLATE 'utf8mb4_unicode_ci',
			`lastseen` TIMESTAMP NULL DEFAULT NULL,
			`saas` JSON NULL DEFAULT NULL,
			`service` JSON NULL DEFAULT NULL,
			`otp` JSON NULL DEFAULT NULL,
			PRIMARY KEY (`auid`) USING BTREE,
			UNIQUE INDEX `puid` (`puid`) USING BTREE,
			UNIQUE INDEX `suid` (`suid`) USING BTREE,
			UNIQUE INDEX `tuid` (`tuid`) USING BTREE,
			UNIQUE INDEX `email` (`email`) USING BTREE,
			UNIQUE INDEX `phone` (`phone`) USING BTREE,
			UNIQUE INDEX `username` (`username`) USING BTREE,
			INDEX `luid` (`luid`) USING BTREE,
			INDEX `created` (`created`) USING BTREE,
			INDEX `updated` (`updated`) USING BTREE,
			INDEX `entry` (`entry`) USING BTREE,
			INDEX `author` (`author`) USING BTREE,
			INDEX `password` (`password`) USING BTREE,
			INDEX `lastseen` (`lastseen`) USING BTREE,
			INDEX `type` (`type`) USING BTREE,
			INDEX `verified` (`verified`) USING BTREE,
			INDEX `verifiedPhone` (`verifiedPhone`) USING BTREE,
			INDEX `verifiedEmail` (`verifiedEmail`) USING BTREE,
			INDEX `flag` (`flag`) USING BTREE,
			INDEX `kind` (`kind`) USING BTREE,
			INDEX `brand` (`brand`) USING BTREE,
			INDEX `firstname` (`firstname`) USING BTREE,
			INDEX `lastname` (`lastname`) USING BTREE,
			INDEX `middlename` (`middlename`) USING BTREE,
			INDEX `dob` (`dob`) USING BTREE,
			INDEX `gender` (`gender`) USING BTREE,
			INDEX `nationality` (`nationality`) USING BTREE,
			INDEX `living` (`living`) USING BTREE,
			INDEX `relationship` (`relationship`) USING BTREE,
			INDEX `status` (`status`) USING BTREE)";
		$sql .= " COLLATE='utf8mb4_unicode_ci' ENGINE=InnoDB ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1;";
		return $this->exec($sql);
	}




	// ◇ ----- IS KIND •
	public function isKind($user, $kind) {
		if (VarX::isArray($user) && ArrayX::isKeyNotEmpty($user, 'kind')) {
			$userKind = $user['kind'];
		} elseif (VarX::stringAcceptable($user)) {
			$userKind = $user;
		}

		if (VarX::isArray($kind) && !ArrayX::isValue($kind, $userKind)) {
			return 'ERROR_' . strtoupper($userKind) . '_DENIED';
		} elseif (VarX::stringAcceptable($type) && $kind != $userKind) {
			return 'ERROR_' . strtoupper($userKind) . '_DENIED';
		}

		return true;
	}





	// ◇ ----- IS ROLE •
	public function isRole($user, $role) {
		if (VarX::isArray($user) && ArrayX::isKeyNotEmpty($user, 'role')) {
			$userRole = $user['role'];
		} elseif (VarX::stringAcceptable($user)) {
			$userRole = $user;
		}

		if (VarX::isArray($role) && !ArrayX::isValue($role, $userRole)) {
			return 'ERROR_' . strtoupper($userRole) . '_RESTRICTED';
		} elseif (VarX::stringAcceptable($type) && $role != $userRole) {
			return 'ERROR_' . strtoupper($userRole) . '_RESTRICTED';
		}

		return true;
	}





	// ◇ ----- IS TYPE •
	public function isType($user, $type) {
		if (VarX::isArray($user) && ArrayX::isKeyNotEmpty($user, 'type')) {
			$userType = $user['type'];
		} elseif (VarX::stringAcceptable($user)) {
			$userType = $user;
		}

		if (VarX::isArray($type) && !ArrayX::isValue($type, $userType)) {
			return 'ERROR_' . strtoupper($userType) . '_DENIED';
		} elseif (VarX::stringAcceptable($type) && $type != $userType) {
			return 'ERROR_' . strtoupper($userType) . '_DENIED';
		}

		return true;
	}





	// ◇ ----- IS STATUS •
	public function isStatus($user, $status) {
		if (VarX::isArray($user) && ArrayX::isKeyNotEmpty($user, 'status')) {
			$userStatus = $user['status'];
		} elseif (VarX::stringAcceptable($user)) {
			$userStatus = $user;
		}

		if (VarX::isArray($status) && !ArrayX::isValue($status, $userStatus)) {
			return 'ERROR_' . strtoupper($userStatus) . '_DENIED';
		} elseif (VarX::stringAcceptable($status) && $status != $userStatus) {
			return 'ERROR_' . strtoupper($userStatus) . '_DENIED';
		}

		return true;
	}





	// ◇ ----- FIND IN TOKEN •
	protected function findInToken($filter, $column = 'token') {
		$record = $this->mToken()->oFindOne($filter, $column);
		if (DataQ::isRowColumn($record, DataQ::firstKey($column))) {
			return $record;
		}
		return 'NO_RESULT';
	}





	// ◇ ----- FILTER BY USERID • Returns filter to be used
	public function filterByUserID($userID) {
		return DataQ::userIDToColumn($userID);
	}





	// ◇ ----- AUTHENTICATE TOKEN • Authenticate Token
	public function authenticateToken($token, $authID, $timeout) {
		return $this->mToken()->authenticate($token, $authID, $timeout);
	}





	// ◇ ----- oAUTHID • Find User by AuthID
	public function oAuthID($authID, $column = ['tuid' => 'oauthid']) {
		$filter = ['tuid' => $authID];
		return $this->oFindOne($filter, ColumnQ::user($column));
	}





	// ◇ ----- oUSERNAME • Find User by Username
	public function oUsername($username, $column = 'username') {
		$filter = ['username' => $username];
		return $this->oFindOne($filter, ColumnQ::user($column));
	}





	// ◇ ----- oEMAIL • Find User by Email
	public function oEmail($email, $column = 'email') {
		$filter = ['email' => $email];
		return $this->oFindOne($filter, ColumnQ::user($column));
	}





	// ◇ ----- oPHONE • Find User by Phone
	public function oPhone($phone, $column = 'phone') {
		$filter = ['phone' => $phone];
		return $this->oFindOne($filter, ColumnQ::user($column));
	}





	// ◇ ----- oTOKEN • Find User by Token
	public function oToken($token, $column = 'token') {
		$filter = ['token' => $token];
		$record = $this->findInToken($filter, 'oauthid');
		if (VarX::stringAcceptable($column) && $column === 'token') {
			return ['token' => $token];
		} elseif (DataQ::isRow($record)) {
			if (VarX::isNotEmptyArray($column) && ArrayX::isValue($column, 'token')) {
				DataQ::stripValue($column, 'token');
				$user = $this->oAuthID($record['oauthid'], $column);
				if (DataQ::isRow($user)) {
					$user = array_merge($user, ['token' => $token]);
				}
			} else {
				$user = $this->oAuthID($record['oauthid'], $column);
			}
			return $user;
		}
		return $record;
	}





	// ◇ ----- oUSERID •
	public function oUserID($userID, $column) {
		$filter = $this->filterByUserID($userID);
		if ($this->isFilterToken($filter)) {
			return $this->oToken($userID, $column);
		} elseif ($this->isFilterAuthID($filter)) {
			SetQ::keySwap($filter, 'oauthid', 'tuid');
			return $this->oFindOne($filter, ColumnQ::user($column));
		} elseif (DataQ::isRow($filter)) {
			return $this->oFindOne($filter, ColumnQ::user($column));
		}
		return $filter;
	}





	// ◇ ----- oMAKE •
	public function oMake($input, $yield = 'puid', $guid = null) {
		// $auth = DataQ::extricate($input, ColumnAO::auth('AUTH'));
		// $profile = DataQ::extricate($input, ColumnAO::profile('PROFILE'));
		// $entry = [];
		// if (VarX::isNotEmptyArray($auth)) {
		// 	$entry = array_merge($entry, $auth);
		// }
		// if (VarX::isNotEmptyArray($profile)) {
		// 	$entry = array_merge($entry, $profile);
		// }



		$entry = DataQ::extricate($input, ColumnQ::user('USER'));
		if (ArrayX::isNotKeyOrEmpty($entry, 'password')) {
			$entry['password'] = Random::password();
			$entry['flag'] = 'PASSWORD_GENERATED';
		}
		if (ArrayX::isKeyNotEmpty($entry, 'password')) {
			$entry['password'] = CryptX::password($entry['password']);
		}
		SetQ::key($entry, 'status', 'ACTIVE');
		return $this->oCreate($entry, $yield, $guid);
	}





	// ◇ ----- LOGIN •
	public function login($userID, $password) {

		// + Find user in auth (by UserID)
		$user = $this->oUserID($userID, 'AUTH');
		if (DataQ::isRowColumn($user, 'password')) {

			// + Check password validity
			if (!CryptX::isPassword($password, $user['password'])) {
				return 'ERROR_INVALID_PASSWORD';
			}
			DataQ::extricate($user, 'password');
		}
		return $user;
	}





	// ◇ ----- LOGIN SAAS • Login and set SAAS as role
	public function loginSAAS($userID, $password, $SAAS) {
		$user = $this->login($userID, $password);
		if (DataQ::isRowColumn($user, 'saas')) {
			$role = JSON::toArray($user['saas']);
			if (DataQ::isRowColumn($role, $SAAS, 'DATA')) {
				$user['role'] = $role[$SAAS];
			}
			DataQ::extricate($user, 'saas');
		}
		return $user;
	}





	// ◇ ----- LASTSEEN UPDATE •
	public function lastseenUpdate($userID) {
		$input['lastseen'] = Time::SQL('DATETIME');
		$filter = $this->oUserID($userID, 'tuid');
		if (DataQ::isRowColumn($filter, 'tuid')) {
			return $this->oUpdateOne($filter, $input);
		}
		return $filter;
	}




















	/***** BEGIN USERNAME SECTION *****/

	// ◇ ----- USERNAME UPDATE •
	public function usernameUpdate($filter, $username) {
		$input = ['username' => $username];
		return $this->oUpdateOne($filter, $input);
	}

	/***** END USERNAME SECTION *****/



















	/***** BEGIN PASSWORD SECTION *****/


	// ◇ ----- PASSWORD • Update with Temporary Password
	public function password($filter) {
		$password = Random::password();
		$input['password'] = CryptX::password($password);
		$input['flag'] = 'PASSWORD_TEMPORARY';
		return $this->oUpdateOne($filter, $input);
	}





	// ◇ ----- PASSWORD CHANGE •
	public function passwordChange($filter, $password) {
		$input['password'] = CryptX::password($password);
		$input['flag'] = 'PASSWORD_CHANGED';
		return $this->oUpdateOne($filter, $input);
	}

	/***** END PASSWORD SECTION *****/




















	/***** BEGIN EMAIL SECTION *****/

	// ◇ ----- EMAIL UPDATE •
	public function emailUpdate($filter, $email) {
		$input = ['email' => $email];
		return $this->oUpdateOne($filter, $input);
	}

	/***** END EMAIL SECTION *****/





















	/***** BEGIN PHONE SECTION *****/

	// ◇ ----- PHONE UPDATE •
	public function phoneUpdate($filter, $phone) {
		$input = ['phone' => $phone];
		return $this->oUpdateOne($filter, $input);
	}

/***** END PHONE SECTION *****/










} // End of Class