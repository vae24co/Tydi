<?php
class AuthAPI extends APIOrganizr {

	//*----------- INITIALIZE -----------*//
	public function _initialize(){
		$this->Network = new NetworkModel;
	}





	//*----------- LANDING -----------*//
	public function landing(){
		return $this->response('ERROR_REQUEST_FORBIDDEN');
	}










	//*----------- SIGNUP -----------*//






	//*----------- WOCA SIGNUP -----------*//
	public function wocaSignup(){
		$check = SocaU::check('WOCA_SIGNUP', 'POST');
		if(!isset($check['oDATA'])){return $this->response($check);}
		$param = SocaU::filter($check);
		if($param === false){return $this->response('ERROR_PRECONDITION');}
		$dataset = SocaU::toColumn($param);
		$dataset = SocaU::getPlatformNetwork($dataset);
		if(isset($dataset['tuid'])){SocaU::filterExtract($dataset, ['tuid']);}
		if(!empty($dataset)){

			//? AUTH RECORD
			$authset = $dataset;
			$authset = SocaU::filterExtract($authset, ['username', 'password', 'phone', 'email', 'network', 'wowid']);
			if(!empty($authset)){
				$tuid = RandomX::tuid();
				$authset['tuid'] = $tuid;
				$authset['oauthid'] = $tuid;
				if(!empty($authset['network'])){$authsetNetwork[$authset['network']] = 'JOINED';}
				if(!empty($authset['wowid'])){$authsetNetwork['WOWCATHOLIC'] = 'YES';}
				if(!empty($authsetNetwork)){$authset['network'] = JSONX::data($authsetNetwork);}
				$user = $this->Network->make('AUTH', $authset, ['oauthid']);
			}

			//? PROFILE RECORD
			if(!empty($user['oauthid'])){
				$profileset = $dataset;
				$profileset = SocaU::filterExtract($profileset, ['firstname', 'lastname', 'middlename', 'gender', 'dob', 'living']);
				if(!empty($profileset)){
					$profile = $this->Network->make('PROFILE', $authset, ['oauthid']);
				}
			}
			return $this->result($user, 'Signup Successful');
		}
		return $this->response('ERROR_FAILED');
	}

































	//*----------- SIGNUP PATREVO -----------*//
	public function signupPatrevo($input=[]){
		$check = WOCAU::preCreate('PATREVO_SIGNUP');
		if(!isset($check['oDATA'])){return $this->response($check);}
		$data = oPreCheckInputSanitize($check);
		if(!empty($input) && is_array($input)){$data = array_merge($data, $input);}
		$data = WOCAU::toColumn($data);
		if(!empty($data['network'])){
			$network = JSONX::encode([strtoupper($data['network']) => 'JOINED']);
			$data['network'] = $network['data'];
		}

		#Auth
		$authData =  DataQ::grab($data, ['username', 'email', 'phone', 'password', 'network']);
		$tuid = RandomX::tuid();
		$authData['tuid'] = $tuid;
		$authData['oauthid'] = $authData['tuid'];
		$auth = $this->Network->AuthCreate($authData, 'oauthid');

		if(!empty($auth['oauthid'])){
			$result['userguid'] = $auth['oauthid'];

			#Profile
			$profileData = DataQ::grab($data, ['firstname', 'lastname', 'middlename']);
			$profileData['oauthid'] = $tuid;
			$profile = $this->Network->profileCreate($profileData, 'oauthid');

			return $this->result($result, 'Signup Successful');
		}
		return $this->response('ERROR_FAILED');
	}





	//*----------- SIGNUP WOWCATHOLIC -----------*//
	public function signupWowcatholic($input=[]){
		$check = WOCAU::preCreate('WOW_SIGNUP');
		if(!isset($check['oDATA'])){return $this->response($check);}
		$data = oPreCheckInputSanitize($check);
		if(!empty($input) && is_array($input)){$data = array_merge($data, $input);}
		$data = WOCAU::toColumn($data);
		if(!empty($data['network'])){
			$network = JSONX::encode([strtoupper($data['network']) => 'JOINED']);
			$data['network'] = $network['data'];
		}

		#Auth
		$authData =  DataQ::grab($data, ['username', 'email', 'phone', 'password', 'network']);
		$tuid = RandomX::tuid();
		$authData['tuid'] = $tuid;
		$authData['oauthid'] = $authData['tuid'];
		$auth = $this->Network->AuthCreate($authData, 'oauthid');

		if(!empty($auth['oauthid'])){
			$result['userguid'] = $auth['oauthid'];

			#Profile
			$profileData = DataQ::grab($data, ['firstname', 'lastname', 'middlename']);
			$profileData['oauthid'] = $tuid;
			$profile = $this->Network->profileCreate($profileData, 'oauthid');

			return $this->result($result, 'Signup Successful');
		}
		return $this->response('ERROR_FAILED');
	}

















































	//*----------- LOGIN -----------*//
	public function login(){
		$check = SocaU::check('LOGIN', 'POST', ['userid', 'password']);
		if(!isset($check['oDATA'])){return $this->response($check);}
		$filter = SocaU::filterLogin($check);
		if($filter === false){return $this->response('ERROR_PRECONDITION');}
		$login = $this->Network->login($filter);
		if(!isset($login['oauthid'])){return $this->loginFailed($login);}
		$networkID = SocaU::APITokenNetwork('puid');
		if(!empty($networkID)){
			unset($filter);
			$filter['oauthid'] = $login['oauthid'];
			$token = RandomX::tuid().RandomX::puid();
			$sessionid = RandomX::puid().RandomX::suid();
			$user = SocaU::searchNetworkUser($networkID, $filter);
			$dataset = ['token' => $token, 'session' => $sessionid, 'lastseen' => TimeX::create('SQLDATETIME')];
			if(isset($user['puid'])){
				$update = SocaU::updateNetworkUser($networkID, $filter, $dataset, 'COUNT');
			}
			elseif($user === 'NO_RESULT'){
				$dataset = array_merge($dataset, $filter);
				$create = SocaU::createNetworkUser($networkID, $dataset, 'COUNT');
			}
		}
		if(!empty($login['oauthid'])){$result['userguid'] = $login['oauthid'];}
		if(!empty($dataset['token'])){$result['token'] = $dataset['token'];}
		if(!empty($dataset['session'])){$result['session'] = $dataset['session'];}
		if(!empty($user['progress'])){$result['onext'] = SocaU::oProgress($user['progress'], 'NEXT');} else {$result['onext'] = 'AUTO';}
		if(!empty($login['kind'])){$result['kind'] = $login['kind'];} else {$result['kind'] = 'STANDARD';}
		if(!empty($user['type'])){$result['type'] = $user['type'];} else {$result['type'] = 'BASIC';}
		if(!empty($user['privilege'])){$result['privilege'] = $user['privilege'];} else {$result['privilege'] = '';}
		if(!empty($result)){
			return $this->result($result, 'Login Successful', 'Your request to login was completed');
		}
		return $this->response('ERROR_FAILED');
	}





	//*----------- SESSION -----------*//
	public function session(){
		$check = SocaU::check('SESSION', 'POST', ['userguid', 'session']);
		if(!isset($check['oDATA'])){return $this->response($check);}
		$filter = SocaU::filterSessionLogin($check);
		if($filter === false){return $this->response('ERROR_PRECONDITION');}
		$networkID = SocaU::APITokenNetwork('puid');
		if(!empty($networkID)){
			$user = SocaU::searchNetworkUser($networkID, $filter);
			if(isset($user['puid'])){
				$token = RandomX::tuid().RandomX::puid();
				$dataset = ['token' => $token, 'lastseen' => TimeX::create('SQLDATETIME')];
				$update = SocaU::updateNetworkUser($networkID, $filter, $dataset, 'COUNT');
				return $this->result(['token' => $token], 'Session Login Successful', 'Your request to login via session was completed');
			}
			elseif($user === 'NO_RESULT'){
				return $this->result($user);
			}
		}
		return $this->response('ERROR_FAILED');
	}





	//*----------- AUTHORIZATION -----------*//
	public function authorization(){
		$check = SocaU::check('AUTHORIZATION', 'GET', ['token']);
		if(!isset($check['oDATA'])){return $this->response($check);}
		$filter = SocaU::filterAuthorization($check);
		if($filter === false){return $this->response('ERROR_PRECONDITION');}
		$networkID = SocaU::APITokenNetwork('puid');
		if(!empty($networkID)){
			$user = SocaU::searchNetworkUser($networkID, $filter, ['token']);
			if(isset($user['token'])){
				$dataset = ['lastseen' => TimeX::create('SQLDATETIME')];
				$update = SocaU::updateNetworkUser($networkID, $filter, $dataset, 'COUNT');
				return $this->success(['title' => 'Authorization Successful']);
			}
			elseif($user === 'NO_RESULT'){
				return $this->result($user);
			}
		}
		return $this->response('ERROR_FAILED');
	}

}