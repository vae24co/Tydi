<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* NetworkModel ~ WOCA Network Modelizr • VERSION » alpha-0.0.5 ***/

class NetworkModel extends Modelizr {

	//*----------- INITIALIZE -----------*//
	public function initialize(){
		$setting = SETTING['NETWORK'];
		if(!empty($setting['DATABASE'])){
			$settingDB = $setting['DATABASE'];
			if(isset($settingDB['USER'])){$init['user'] = $settingDB['USER'];}
			if(isset($settingDB['PASSWORD'])){$init['password'] = $settingDB['PASSWORD'];}
			if(isset($settingDB['NAME'])){$init['name'] = $settingDB['NAME'];}
			if(!empty($init)){$this->connect($init);}
			if(!empty($settingDB['TABLE'])){$this->tables = $settingDB['TABLE'];}
		}
	}





	//*----------- IS-AUTH -----------*//
	public function isAuth($filter, $column='puid', $limit=1){
		$table = $this->tables['AUTH'];
		return $this->has($filter, $column, $limit, $table);
	}






	//*----------- NEW AUTH -----------*//
	public function newAuth($dataset, $response='BIND', $guid=''){
		if(empty($dataset['tuid'])){
			$dataset['tuid'] = RandomX::tuid();
			$dataset['oauthid'] = $dataset['tuid'];
		}
		return $this->make('AUTH', $dataset, $response, $guid);
	}





	//*----------- FIND AUTH -----------*//
	public function findAuth($filter, $column, $response='ROW', $limit=1, $sort='NO_SORT'){
		return $this->find('AUTH', $filter, $column, $response, $limit, $sort);
	}





	//*----------- UPDATE AUTH -----------*//
	public function updateAuth($filter, $dataset, $response='BOOL', $limit=1){
		$table = $this->tables['AUTH'];
		return $this->update($filter, $dataset, $response, $limit, $table);
	}





	//*----------- MODIFY AUTH -----------*//
	public function modifyAuth($filter, $column, $dataset, $response='COUNT', $limit=1){
		return $this->modify('AUTH', $filter, $column, $dataset, $response, $limit);
	}










	//*----------- MODIFY PROFILE -----------*//
	public function modifyProfile($filter, $column, $dataset, $response='COUNT', $limit=1){
		return $this->modify('PROFILE', $filter, $column, $dataset, $response, $limit);
	}





	//*----------- MAINTAIN PROFILE -----------*//
	public function maintainProfile($filter, $column, $dataset, $response='COUNT', $limit=1, $guid='AUTO'){
		return $this->maintain('PROFILE', $filter, $column, $dataset, $guid, $response, $limit);
	}









	//*----------- NEW USER -----------*//
	public function newUser($dataset, $response='BIND', $guid=''){
		return $this->make('USER', $dataset, $response, $guid);
	}





	//*----------- FIND USER -----------*//
	public function findUser($filter, $column, $response='ROW', $limit=1, $sort='NO_SORT'){
		return $this->find('USER', $filter, $column, $response, $limit, $sort);
	}





	//*----------- UPDATE USER -----------*//
	public function updateUser($filter, $dataset, $response='ROW', $limit=1){
		$table = $this->tables['USER'];
		return $this->update($filter, $dataset, $response, $limit, $table);
	}










	//*----------- NEW HARVESTPAD USER -----------*//
	public function newHarvestPadUser($dataset, $response='BIND', $guid=''){
		return $this->make('HARVESTPAD_USER', $dataset, $response, $guid);
	}





	//*----------- FIND HARVESTPAD USER -----------*//
	public function findHarvestPadUser($filter, $column, $response='ROW', $limit=1, $sort='NO_SORT'){
		return $this->find('HARVESTPAD_USER', $filter, $column, $response, $limit, $sort);
	}





	//*----------- UPDATE HARVESTPAD USER -----------*//
	public function updateHarvestPadUser($filter, $dataset, $response='ROW', $limit=1){
		$table = $this->tables['HARVESTPAD_USER'];
		return $this->update($filter, $dataset, $response, $limit, $table);
	}










	//*----------- CREATE APP USER -----------*//
	public function createAppUser($dataset, $response='BIND', $networkID='AUTO'){
		if($networkID === 'AUTO'){$networkID = YAOUtil::getPlatformNetworkID();}

		#WOCA
		if($networkID === 'x6O872D7ZtB1o6eq442W'){
			$woca = new WOCAModel;
			$result = $woca->makeUser($dataset, $response);
		}


		#PATREVO
		if($networkID === 'CZR6vF9jAT7W1Gl50Q5e'){
			$patrevo = new PatrevoModel;
			$result = $patrevo->makeUser($dataset, $response);
		}


		#HARVESTPAD
		if($networkID === 'MHr14ozsw60x37IecVW5'){
			$havestpad = new HarvestpadModel;
			$result = $havestpad->makeUser($dataset, $response);
		}

		if(!empty($result)){return $result;}
		return false;
	}





	//*----------- SEARCH APP USER -----------*//
	public function searchAppUser($filter, $column='', $networkID='AUTO'){
		if(empty($column)){$column = ['puid', 'oauthid', 'type', 'privilege', 'progress', 'token', 'session', 'access', 'lastseen'];}
		if($networkID === 'AUTO'){$networkID = YAOUtil::getPlatformNetworkID();}

		#WOCA
		if($networkID === 'x6O872D7ZtB1o6eq442W'){
			$woca = new WOCAModel;
			$result = $woca->findUser($filter, $column);
		}


		#PATREVO
		if($networkID === 'CZR6vF9jAT7W1Gl50Q5e'){
			$patrevo = new PatrevoModel;
			$result = $patrevo->findUser($filter, $column);
		}


		#HARVESTPAD
		if($networkID === 'MHr14ozsw60x37IecVW5'){
			$havestpad = new HarvestpadModel;
			$result = $havestpad->findUser($filter, $column);
		}


		if(!empty($result)){return $result;}
		return false;
	}





	//*----------- UPDATE APP USER -----------*//
	public function updateAppUser($filter, $dataset, $response='COUNT', $networkID='AUTO'){
		if($networkID === 'AUTO'){$networkID = YAOUtil::getPlatformNetworkID();}

		#WOCA
		if($networkID === 'x6O872D7ZtB1o6eq442W'){
			$woca = new WOCAModel;
			$result = $woca->updateUser($filter, $dataset, $response);
		}


		#PATREVO
		if($networkID === 'CZR6vF9jAT7W1Gl50Q5e'){
			$patrevo = new PatrevoModel;
			$result = $patrevo->updateUser($filter, $dataset, $response);
		}


		#HARVESTPAD
		if($networkID === 'MHr14ozsw60x37IecVW5'){
			$havestpad = new HarvestpadModel;
			$result = $havestpad->updateUser($filter, $dataset, $response);
		}


		if(!empty($result)){return $result;}
	}





	//*----------- SET APP USER AUTHORISATION -----------*//
	public function setAppUserAuthorization($filter, $column, array $progress=[], $networkID='AUTO'){
		if($networkID === 'AUTO'){$networkID = YAOUtil::getPlatformNetworkID();}
		if(empty($networkID)){return false;}

		$dataset = ['token' => RandomX::tuid().RandomX::puid(), 'session' => RandomX::puid().RandomX::suid(), 'lastseen' => TimeX::create('SQLDATETIME')];

		$user = $this->searchAppUser($filter, 'puid', $networkID);
		if($user === 'NO_RESULT'){
			if(!empty($progress)){
				$progress = ArrayX::toJSON($progress);
				$dataset = array_merge($dataset, ['progress' => $progress]);
			}
			$dataset = array_merge($dataset, $filter);
			return $this->createAppUser($dataset, 'COUNT', $networkID);
		}
		elseif(isset($user['puid'])){
			$record = $this->searchAppUser($filter, '', $networkID);
			if(!empty($progress)){
				if(!empty($record['progress'])){
					$inprogress = JSONX::toArray($record['progress']);
					$progress = array_merge($inprogress, $progress);
					$progress = ArrayX::toJSON($progress);
					$dataset = array_merge($dataset, ['progress' => $progress]);
				}
			}
			return $this->updateAppUser($filter, $dataset, 'COUNT', $networkID);
		}

		return false;
	}





	//*----------- SET APP ADMIN AUTHORISATION -----------*//
	public function setAppAdminAuthorization($filter, $column, array $progress=[], $networkID='AUTO'){
		if($networkID === 'AUTO'){$networkID = YAOUtil::getPlatformNetworkID();}
		if(empty($networkID)){return false;}

		$dataset = ['token' => RandomX::tuid().RandomX::puid(), 'session' => RandomX::puid().RandomX::suid(), 'lastseen' => TimeX::create('SQLDATETIME')];

		$user = $this->searchAppUser($filter, 'puid', $networkID);
		if($user === 'NO_RESULT'){
			if(!empty($progress)){
				$progress = ArrayX::toJSON($progress);
				$dataset = array_merge($dataset, ['progress' => $progress]);
			}
			$dataset = array_merge($dataset, $filter);
			$dataset['role'] = 'APPADMIN';
			return $this->createAppUser($dataset, 'COUNT', $networkID);
		}
		elseif(isset($user['puid'])){
			$record = $this->searchAppUser($filter, '', $networkID);
			if(!empty($progress)){
				if(!empty($record['progress'])){
					$inprogress = JSONX::toArray($record['progress']);
					$progress = array_merge($inprogress, $progress);
					$progress = ArrayX::toJSON($progress);
					$dataset = array_merge($dataset, ['progress' => $progress]);
				}
			}
			return $this->updateAppUser($filter, $dataset, 'COUNT', $networkID);
		}

		return false;
	}




































	//*----------- [TODO] LOGIN -----------*//
	public function login($param){
		if(!empty($param) && isset($param['password'])){
			$password = $param['password'];
			unset($param['password']);
			$column = ['oauthid', 'password', 'network', 'kind'];
			$user = $this->findUser($param, $column, 'ROW', 1);
			if(!empty($user['oauthid'])){
				$isPassword = CryptX::isPassword($password, $user['password']);
				if($isPassword === false){return 'PASSWORD_INVALID';}
				unset($user['password']);
			}
			return $user;
		}
		return false;
	}














} /*** End Of ~NetworkModel ***/