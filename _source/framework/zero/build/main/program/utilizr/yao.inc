<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* YAOU ~ Yet Another ODAO Utilizr • VERSION » alpha-0.0.7 ***/

class YAOUtil {

	//*----------- CHECK -----------*//
	public static function check($option='', $method='POST', $required=[]){
		$check = oPreCheck($method, $method.'_DATA');
		if($check !== true){return $check;}

		$rule='EMPTY';


		if($option === 'INSTALL'){
			$spec = ['authorize'];
		}


		if($option === 'LOGIN'){
			$spec = ['userid', 'password', 'device'];
		}

		if($option === 'SESSION'){$spec = ['userguid', 'session'];}

		if($option === 'AUTHORIZATION'){$spec = ['token'];}


		if($option === 'AUTH'){
			$spec = ['userid'];
		}


		if($option === 'FEEDBACK'){
			$spec = ['id', 'bind', 'userguid', 'platform', 'network', 'type', 'username', 'email', 'phone', 'name', 'subject', 'message', 'file'];
			$certain = ['type', 'email', 'name', 'message'];
		}


		if($option === 'PARISH'){
			$spec = [
				'bind', 'priest', 'associate', 'catechist', 'officetime', 'masstime', 'wowcatholic', 'website', 'phone', 'email', 'pobox', 'name', 'acronym',
				'video', 'photo', 'logo', 'about', 'province', 'diocese', 'country', 'state', 'city', 'lga', 'town', 'address'
			];
			$certain = ['name', 'acronym', 'address', 'town', 'lga', 'city', 'state', 'country', 'diocese'];
		}


		if($option === 'WOCA_SIGNUP'){
			$spec = ['wowid', 'fullname', 'phone', 'email', 'password', 'platform', 'network', 'username', 'dob', 'gender', 'living'];
			$certain = ['fullname', 'phone', 'email', 'password', 'username', 'dob', 'gender'];
		}



		if($option === 'HARVESTPAD_SIGNUP' || $option === 'HARVESTPAD_ADMIN_SIGNUP'){$spec = ['fullname', 'phone', 'email', 'password', 'platform', 'network', 'username'];}
		if($option === 'HARVESTPAD_SIGNUP'){$certain = ['fullname', 'phone', 'password'];}
		if($option === 'HARVESTPAD_ADMIN_SIGNUP'){$certain = ['fullname', 'phone', 'email'];}



		if($option === 'PATREVO_SIGNUP'){
			$spec = ['fullname', 'phone', 'email', 'password', 'platform', 'network', 'username'];
			$certain = ['fullname', 'phone', 'email', 'password'];
		}


		if($option === 'PROFILE'){
			$spec = [
				'id', 'bind', 'token', 'userguid',
				'brand', 'fullname', 'birthday', 'gender', 'relationship', 'nationality', 'living', 'bio', 'dp', 'cp', 'career', 'religion', 'origin', 'passion', 'interest', 'purpose'
			];
		}


		if($option === 'CUPID'){
			$spec = [
				'id', 'bind', 'token', 'userguid',
				'birthday', 'gender', 'relationship', 'nationality', 'living', 'about', 'dp', 'cp', 'career', 'religion', 'origin', 'passion', 'interest', 'purpose'
			];
		}


		if(!empty($spec)){
			$input = ParamQ::grab($method, $spec);
			if(empty($input)){return 'ERROR_METHOD_NODATA';}
			if(empty($required) && !empty($certain)){$required = $certain;}
			if($required === 'ENTRY'){
				$required = ArrayX::keys($input);
				$rule = 'NO_EMPTY';
			}
			return ParamQ::require($input, $rule, $required, 'DATA');
		}

		return false;
	}





	//*----------- RECORD -----------*//
	public static function record(&$result){
		if(!empty($result)){
			if(is_array($result) && !ArrayX::isMulti($result)){
				foreach($result as $index => $value){
					if(is_null($value)){$result[$index] = '';}
				}
				if(isset($result['oauthid'])){$result['userguid'] = $result['oauthid']; unset($result['oauthid']);}
			}
			elseif(is_array($result) && ArrayX::isMulti($result)){
				foreach($result as $index => $row){
					foreach($row as $label => $value){
						if(is_null($value)){$result[$index][$label] = '';}
					}
					if(isset($result[$index]['oauthid'])){$result[$index]['userguid'] = $result[$index]['oauthid']; unset($result[$index]['oauthid']);}
				}
			}
		}
	}





	//*----------- PARAM -----------*//
	public static function param($param){
		if(is_array($param) && isset($param['oDATA'])){$param = $param['oDATA'];}
		if(!empty($param)){
			$param = SanitizeQ::input($param);
			return $param;
		}
		return false;
	}





	//*----------- FILTER EXTRACT -----------*//
	public static function filterExtract(&$dataset, $param){
		if(is_array($dataset)){
			if(is_array($param)){
				foreach($param as $column){
					if(isset($dataset[$column])){
						$filter[$column] = $dataset[$column];
						unset($dataset[$column]);
					}
				}
			}
			else {
				if(isset($dataset[$param])){
					$filter[$param] = $dataset[$param];
					unset($dataset[$param]);
				}
			}
		}
		if(!empty($filter)){return $filter;}
		return false;
	}





	//*----------- FILTER EXTRACT ID -----------*//
	public static function filterExtractID(&$dataset){
		return self::filterExtract($dataset, ['puid', 'tuid', 'oauthid', 'token']);
	}





	//*----------- FILTER EXTRACT USER ID -----------*//
	public static function filterExtractUserID(&$dataset){
		return self::filterExtract($dataset, ['username', 'email', 'phone', 'oauthid', 'token']);
	}





	//*----------- FILTER USER ID -----------*//
	public static function filterUserID($filter){
		if(!empty($filter['token'])){
			$token['token'] = $filter['token'];
			$networkID = self::getPlatformNetworkID();

			#WOCA
			if($networkID === 'x6O872D7ZtB1o6eq442W'){
				$woca = new WOCAModel;
				$param = $woca->findUser($token, 'oauthid');
			}

			if(!empty($param)){return $param;}
		}
		return false;
	}




	//*----------- FILTER EXTRACT SEARCH -----------*//
	public static function filterExtractSearch($dataset, array $column=[]){
		$param = ['puid', 'tuid'];
		if(!empty($column)){$param = array_merge($column, $param);}
		return self::filterExtract($dataset, $param);
	}





	//*----------- DATASET EXTRACT -----------*//
	public static function datasetExtract($dataset, $spec=''){
		if($spec === 'AUTH_WOW'){
			$dataset = ArrayX::filterExtract($dataset, ['wowid', 'username', 'email', 'phone', 'password']);
			$tuid = RandomX::tuid();
			$dataset['tuid'] = $tuid;
			$dataset['oauthid'] = $tuid;

			$tokenPN = self::getPlatformNetwork();
			if(!empty($tokenPN['network'])){
				$network = $tokenPN['network'];
				$userNetworkData[$network] = 'JOINED';
			}
			$userNetworkData['WOWCATHOLIC'] = 'YES';
			$dataset['network'] = ArrayX::toJSON($userNetworkData);
		}


		if($spec === 'PROFILE_WOW'){
			$dataset = ArrayX::filterExtract($dataset, ['firstname', 'lastname', 'living', 'dob', 'bio', 'gender', 'avatar' => 'dp']);
		}


		if($spec === 'PROFILE'){
			$dataset = ArrayX::filterExtract($dataset, ['oauthid', 'brand', 'firstname', 'lastname', 'middlename', 'dob', 'gender', 'relationship', 'nationality', 'living', 'bio', 'dp', 'cp', 'career', 'religion', 'origin', 'passion', 'interest', 'purpose']);
		}


		if($spec === 'AUTH_SIGNUP'){
			$dataset = ArrayX::filterExtract($dataset, ['username', 'email', 'phone', 'password', 'network']);
		}

		if(!empty($dataset)){return $dataset;}
		return false;
	}





	//*----------- AS COLUMN -----------*//
	public static function asColumn($spec=''){
		$guid = ['puid' => 'id', 'tuid' => 'bind'];

		if($spec === 'FEEDBACK'){
			$column = ['type', 'email', 'phone', 'name', 'subject', 'message', 'network', 'platform', 'status'];
		}


		if($spec === 'PARISH'){
			$column = ['name', 'acronym', 'address', 'town', 'lga', 'city', 'state', 'country', 'diocese'];
		}


		if($spec === 'AUTH'){
			$column = ['tuid' => 'userguid', 'email', 'phone', 'username', 'network', 'kind', 'status'];
		}


		if($spec === 'NETWORK_AUTH'){
			$column = ['puid' => 'puid', 'tuid' => 'userguid', 'network', 'kind', 'status'];
		}


		if($spec === 'WOW_USER'){
			$column = [
				'about', 'address', 'avatar', 'birthday', 'city', 'country_id' => 'country', 'cover', 'email', 'first_name', 'gender', 'interest', 'joined', 'last_name', 'lastseen',
				'marital', 'oauthid', 'origin', 'password', 'phone_number', 'registered', 'religion', 'state', 'school', 'user_id', 'username', 'website', 'working'
			];
		}

		if(empty($column)){$column = '*';}
		elseif(is_array($column) && StringX::in($spec, 'WOW') === false){
			$column = array_merge($guid, $column);
		}
		return $column;
	}





	//*----------- TO COLUMN -----------*//
	public static function toColumn($param){

		#UserID to Column
		if(isset($param['userid'])){
			$userid = oUserIDToColumn($param['userid']);
			if(!empty($userid)){
				$param = array_merge($param, $userid);
				unset($param['userid']);
			}
		}


		#UserGUID to oAuthID
		if(isset($param['userguid'])){
			$param['oauthid'] = $param['userguid'];
			unset($param['userguid']);
		}


		#ID to PUID
		if(isset($param['id'])){
			$param['puid'] = $param['id'];
			unset($param['id']);
		}


		#BIND to TUID
		if(isset($param['bind'])){
			$param['tuid'] = $param['bind'];
			unset($param['bind']);
		}


		#NAME to NAMES
		if(isset($param['fullname'])){
			$param['fullname'] = ucwords($param['fullname']);
			$names = DataQ::nameToNames($param['fullname']);
			if(!empty($names)){$param = array_merge($param, $names);}
			unset($param['fullname']);
		}


		#BIRTHDATE to DOB
		if(isset($param['birthday'])){
			$param['dob'] = $param['birthday'];
			unset($param['birthday']);
		}


		if(isset($param['dob'])){
			if(TimeX::isValidateDate($param['dob'], 'Y-m-d') === false){unset($param['dob']);}
		}


		if(isset($param['platform'])){
			$param['platform'] = strtoupper($param['platform']);
			if($param['platform'] === 'IOS'){$param['platform'] = 'iOS';}
		}


		if(isset($param['network'])){
			$param['network'] = strtoupper($param['network']);
		}

		return $param;
	}





	//*----------- WOW COLUMN -----------*//
	public static function wowColumn(array $param, $spec='TO'){

		if($spec === 'TO'){
			if(isset($param['phone'])){$param['phone_number'] = $param['phone']; unset($param['phone']);}
			if(isset($param['wowid'])){$param['user_id'] = $param['wowid']; unset($param['wowid']);}
			if(isset($param['firstname'])){$param['first_name'] = $param['firstname']; unset($param['firstname']);}
			if(isset($param['lastname'])){$param['last_name'] = $param['lastname']; unset($param['lastname']);}
			if(isset($param['dob'])){$param['birthday'] = $param['dob']; unset($param['dob']);}
			if(isset($param['bio'])){$param['about'] = $param['bio']; unset($param['bio']);}
			if(isset($param['gender'])){$param['gender'] = SanitizeQ::gender($param['gender'], 'OUTPUT');}
			if(isset($param['living'])){$param['address'] = $param['living']; unset($param['living']);}
		}

		if($spec === 'FROM'){
			if(isset($param['phone_number'])){$param['phone'] = $param['phone_number']; unset($param['phone_number']);}
			if(isset($param['user_id'])){$param['wowid'] = $param['user_id']; unset($param['user_id']);}
			if(isset($param['first_name'])){$param['firstname'] = SanitizeQ::name($param['first_name']); unset($param['first_name']);}
			if(isset($param['last_name'])){$param['lastname'] = $param['last_name']; unset($param['last_name']);}
			if(isset($param['birthday'])){$param['dob'] = $param['birthday']; unset($param['birthday']);}
			if(isset($param['about'])){$param['bio'] = $param['about']; unset($param['about']);}
			if(isset($param['gender'])){$param['gender'] = SanitizeQ::gender($param['gender'], 'INPUT');}
			if(isset($param['address'])){$param['living'] = $param['address']; unset($param['address']);}
			if(isset($param['about'])){$param['bio'] = $param['about']; unset($param['about']);}
			if(isset($param['country_id'])){$param['country'] = $param['country_id']; unset($param['country_id']);}
		}

		return $param;
	}





	//*----------- API TOKEN PLATFORM -----------*//
	public static function APITokenPlatform(){
		$platform = '';
		$token = DataQ::grab('GET', ['system'], 'EMPTY');
		if(isset($token['system'])){
			$platform = $token['system'];
		}
		return $platform;
	}





	//*----------- API TOKEN NETWORK -----------*//
	public static function APITokenNetwork($output=''){
		$network = '';
		$token = DataQ::grab('GET', ['system', 'key'], 'EMPTY');
		if(isset($token['system']) && isset($token['key'])){
			$system = strtolower($token['system']);
			$key = $token['key'];
			$filter[$system] = $key;
			$obj = new NetworkModel;
			if(empty($output)){
				$result = $obj->find('NETWORK', $filter, 'name', 'ROW');
				if(isset($result['name'])){$network = $result['name'];}
			}
			else {
				$result = $obj->find('NETWORK', $filter, '*', 'ROW');
				if($output === 'RECORD' && isset($result['name'])){return $result;}
				elseif(isset($result[$output])){return $result[$output];}
			}
			return $network;
		}
		return false;
	}





	//*----------- GET PLATFORM NETWORK -----------*//
	public static function getPlatformNetwork($input=[], $flag='KEYWORD'){
		if(empty($input['platform'])){$input['platform'] = self::APITokenPlatform();}
		if(empty($input['network'])){$input['network'] = self::APITokenNetwork();}
		if($flag === 'KEYWORD'){
			if(StringX::contain($input['network'], 'SPACE')){$input['network'] = StringX::before($input['network'], ' ');}
			$input['network'] = strtoupper($input['network']);
		}
		return $input;
	}





	//*----------- GET PLATFORM NETWORK ID -----------*//
	public static function getPlatformNetworkID(){
		return self::APITokenNetwork('puid');
	}




	//*----------- GET PLATFORM NETWORK NAME -----------*//
	public static function getPlatformNetworkName(){
		$result = self::getPlatformNetwork([], 'KEYWORD');
		if(isset($result['network'])){return $result['network'];}
		return false;
	}

} /*** End Of ~YAOU ***/