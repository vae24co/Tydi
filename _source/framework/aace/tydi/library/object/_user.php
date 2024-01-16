<?php
class UserBackUp {



	// ◇ ----- PASSWORD • Update with Temporary Password
	public function password($filter) {
		$password = Random::password();
		$input['password'] = CryptX::password($password);
		$input['flag'] = 'PASSWORD_TEMPORARY';
		return $this->oAuthUpdate($filter, $input);
	}





	// TODO ◇ ----- roleSAAS •
	public function roleSAAS($userID, $SAAS) {
    $filter = $this->getAuthIDByUserID($userID, ['tuid']);
    if (!DataQ::isRow($filter)) {
        return $filter;
    }
    $user = $this->record($filter, ['saas']);
    if (VarX::row($user, 'saas')) {
        $row = JSON::toArray($user['saas']);
        if (VarX::row($row, $SAAS)) {
            $user['role'] = $row[$SAAS];
        }
        unset($user['saas']);
    }
    return $user;
}









	// ◇ ----- oPROFILE FIND ONE •
	public function oProfileFindOne($filter, $column) {
		$column = ColumnAO::profile($column);
		return $this->oProfile('oFindOne', $filter, $column);
	}





	// ◇ ----- oPROFILE BY USERID •
	public function oProfileByUserID($userID, $column) {
		$filter = $this->filterProfileByUserID($userID);
		if (DataQ::isRowColumn($filter, 'oauthid')) {
			return $this->oProfileFindOne($filter, $column);
		}
		return $filter;
	}














	// ◇ ----- oTOKEN BY USERID •
	public function oTokenByUserID($userID, $column) {
		$filter = DataQ::userIDToColumn($userID);
		if (!$this->isFilterToken($filter)) {
			$filter = $this->oAuthByUserID($userID, ['tuid' => 'oauthid']);
		}
		return $this->oToken('oFindOne', $filter, $column);
	}















	// ◇ ----- STATUS UPDATE •
	public function statusUpdate($userID, $status) {
		$input['status'] = $status;
		$filter = $this->filterAuthByUserID($userID);
		if (DataQ::isRow($filter)) {
			SetAO::swapKey($filter, 'oauthid', 'tuid');
			return $this->oAuth('oUpdateOne', $filter, $input);
		}
		return $filter;
	}

















	// ◇ ----- LOGOUT •
	public function logout($userID) {
		$filter = $this->oTokenByUserID($userID, 'token');
		if (DataQ::isRowColumn($filter, 'token')) {
			return $this->logoutToken($filter['token']);
		}
		return $filter;
	}









	// ◇ ----- PASSWORD CHANGE BY USERID •
	public function passwordChangeByUserID($userID, $password) {
		$filter = $this->filterAuthByUserID($userID);
		if (DataQ::isRow($filter)) {
			SetAO::swapKey($filter, 'oauthid', 'tuid');
			return $this->passwordChange($filter, $password);
		}
		return $filter;
	}




	// TODO: ◇ ----- GENERATE OTP •
	public function generateOTP($filter, $input = []) {
		if (ArrayX::isNotKeyOrEmpty($input, 'email')) {
			$input['email'] = Random::alphanumeric(10);
		}
		if (ArrayX::isNotKeyOrEmpty($input, 'phone')) {
			$input['phone'] = Random::pin(5);
		}
		if (ArrayX::isNotKeyOrEmpty($input, 'app')) {
			$input['app'] = Random::alphanumeric(5);
		}
		$input['timeout'] = Time::SQL('DATETIME', TOKEN_TIMEOUT);
		$input = ArrayX::toJSON($input);
		return $this->revise($filter, $input);
	}





	// ◇ ----- oRECORD BY USERID •
	public function oRecordByUserID($userID, $req = 'RECORD') {
		$filter = $this->filterAuthByUserID($userID);
		if (DataQ::isRowColumn($filter, 'oauthid')) {
			$filterAuth = ['tuid' => $filter['oauthid']];
			$columnAuth = ColumnAO::auth($req);
			$rowAuth = $this->oAuth('oFindOne', $filterAuth, $columnAuth);
			if (!DataQ::isRow($rowAuth)) {
				return $rowAuth;
			}

			$columnProfile = ColumnAO::profile($req);
			$rowProfile = $this->oProfile('oFindOne', $filter, $columnProfile);
			if (DataQ::isRow($rowProfile)) {
				return array_merge($rowAuth, $rowProfile);
			}
			return $rowAuth;
		}
		return $filter;
	}


// ◇ ----- oRECORD CREATE •
public function oRecordCreate($input) {
	$auth = $this->oAuthCreate(DataQ::extricate($input, ColumnAO::auth('AUTH')), ['puid', 'tuid']);
	if (DataQ::isRowColumn($auth, 'tuid')) {
		$input['oauthid'] = $auth['tuid'];
		$this->oProfileCreate(DataQ::extricate($input, ColumnAO::profile('PROFILE')));
	}
	return $auth;
}











	// • ----- createMasterAO -
	public function createMasterAO($saas) {

		$authID = Random::tuid();

		// + Authentication
		$auth = [
			'tuid' => $authID,
			'username' => 'masterao',
			'password' => CryptX::password('Auth23#'),
			'status' => 'ACTIVE',
			'type' => 'MASTER',
			'kind' => 'OFFICE',
			'verified' => 'YES',
			'saas' => $saas
		];

		// + Profile
		$profile = [
			'oauthid' => $authID,
			'firstname' => 'AO',
			'lastname' => 'Master',
			'status' => 'ACTIVE'
		];

		// + Token
		$token = [
			'okey' => 'r8Z606mz8Y7PQTwK2AbHsB4kXgd7pOilNy36ofq5311LFS62CGn8t06I9JvxUDWu7eM0V7',
			'osaas' => 'd7o8e79PH4y8YtJxbRr8CpLqjaSM4076TfXkAKVl0NFs7E79QBWGuz2mh1Z1Ug1w5v4ni6',
			'token' => '2sQo2d5V34yqOcU11lpg393Ea4M69Wufm7wbPG264T9zXHJ26Zx2rL9jY83BS9',
			'authorized' => 'YES',
			'status' => 'ACTIVE'
		];


		// + Token (Reset)
		$tokenReset = [
			'okey' => 'r8Z606mz8Y7PQTwK2AbHsB4kXgd7pOilNy36ofq5311LFS62CGn8t06I9JvxUDWu7eM0V7',
			'osaas' => 'd7o8e79PH4y8YtJxbRr8CpLqjaSM4076TfXkAKVl0NFs7E79QBWGuz2mh1Z1Ug1w5v4ni6',
			'token' => 'L9BS9jY4M69Wuf3',
			'authorized' => 'YES',
			'status' => 'ACTIVE'
		];


		// + Token (Dev)
		$tokenUse = [
			'okey' => 'r8Z606mz8Y7PQTwK2AbHsB4kXgd7pOilNy36ofq5311LFS62CGn8t06I9JvxUDWu7eM0V7',
			'osaas' => 'd7o8e79PH4y8YtJxbRr8CpLqjaSM4076TfXkAKVl0NFs7E79QBWGuz2mh1Z1Ug1w5v4ni6',
			'token' => 'Y4M6L9uf3BS9j9W',
			'authorized' => 'YES',
			'status' => 'ACTIVE'
		];


		$this->oAuth('oCreate', $auth, 'BOOL', 'AUTO');
		$this->oProfile('oCreate', $profile, 'BOOL', 'AUTO');
		$this->oToken('oCreate', $token, 'BOOL', 'AUTO');
		$this->oToken('oCreate', $tokenReset, 'BOOL', 'AUTO');
		$this->oToken('oCreate', $tokenUse, 'BOOL', 'AUTO');
		return true;
	}





} // End Of Class ~ UserO