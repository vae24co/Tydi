<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* LimeAPI ~ Lime API Organizr • VERSION » alpha-0.0.7 ***/

class LimeAPI extends APIOrganizr {

	//*----------- INITIALIZE -----------*//
	public function initialize(){
		$this->Network = new NetworkModel;
		$this->Auth = new AuthModel;
		$this->Profile = new ProfileModel;
		$this->WOCA = new WOCAModel;
		$this->Feedback = new FeedbackModel;
		$this->Parish = new ParishModel;

		// $this->WOWCatholic = new WOWCatholicModel;
		$this->Harvestpad = new HarvestpadModel;
		$this->Patrevo = new PatrevoModel;
	}





	//*----------- LANDING -----------*//
	public function landing(){
		return $this->response('ERROR_REQUEST_FORBIDDEN');
	}




















	//*----------- INSTALL AUTH -----------*//
	public function installAuth(){
		$check = YAOUtil::check('INSTALL', 'POST');
		if(!isset($check['oDATA'])){return $this->response($check);}
		$param = YAOUtil::param($check);
		if($param === false){return $this->response('ERROR_PRECONDITION');}
		if($param['authorize'] === $this->AuthAO){
			$install[] = $this->Network->install('AUTH');
			$install[] = $this->Network->install('PROFILE');
			$install[] = $this->Network->install('USER');
			foreach($install as $call => $result){
				if($result === false){
					$status[$call] = 'FAILED';
				}
			}
			if(empty($status)){return $this->success();}
			return $this->installFailed($status);
		}
		return $this->response('ERROR_REQUEST_FORBIDDEN');
	}





	//*----------- INSTALL NETWORK -----------*//
	public function installNetwork(){
		$check = YAOUtil::check('INSTALL', 'POST');
		if(!isset($check['oDATA'])){return $this->response($check);}
		$param = YAOUtil::param($check);
		if($param === false){return $this->response('ERROR_PRECONDITION');}
		if($param['authorize'] === $this->AuthAO){
			$install[] = $this->Network->install('FEEDBACK');
			$install[] = $this->Network->install('PARISH');
			$install[] = $this->Network->install('HARVESTPAD_USER');
			foreach($install as $call => $result){
				if($result === false){
					$status[$call] = 'FAILED';
				}
			}
			if(empty($status)){return $this->success();}
			return $this->installFailed($status);
		}
		return $this->response('ERROR_REQUEST_FORBIDDEN');
	}





	//*----------- INSTALL PATREVO -----------*//
	public function installPatrevo(){
		$check = YAOUtil::check('INSTALL', 'POST');
		if(!isset($check['oDATA'])){return $this->response($check);}
		$param = YAOUtil::param($check);
		if($param === false){return $this->response('ERROR_PRECONDITION');}
		if($param['authorize'] === $this->AuthAO){
			$install[] = $this->Patrevo->install('CUPID');
			$install[] = $this->Patrevo->install('SWIPE');
			foreach($install as $call => $result){
				if($result === false){
					$status[$call] = 'FAILED';
				}
			}
			if(empty($status)){return $this->success();}
			return $this->installFailed($status);
		}
		return $this->response('ERROR_REQUEST_FORBIDDEN');
	}




















	//*----------- HARVESTPAD SIGNUP ADMIN -----------*//
	public function harvestpadSignupAdmin(){
		$check = YAOUtil::check('HARVESTPAD_ADMIN_SIGNUP', 'POST');
		if(!isset($check['oDATA'])){return $this->response($check);}
		$param = YAOUtil::param($check);
		if($param === false){return $this->response('ERROR_PRECONDITION');}
		$data = YAOUtil::toColumn($param);
		if(!empty($data)){$data['network'] = ArrayX::toJSON([YAOUtil::getPlatformNetworkName() => 'JOINED']);}


		#AUTHENTICATION
		$authset = $data;
		$authset = YAOUtil::datasetExtract($authset, 'AUTH_SIGNUP');
		$auth = $this->Auth->makeAuth($authset, 'oauthid');
		if(!empty($auth['oauthid'])){
			$paramAuthID['oauthid'] = $auth['oauthid'];


			#PROFILE
			$profileset = $data;
			$profileset = YAOUtil::datasetExtract($profileset, 'PROFILE');
			$this->Profile->maintainProfile($paramAuthID, 'oauthid', $profileset);


			#NETWORK USER
			$this->Network->setAppAdminAuthorization($paramAuthID, 'oauthid');


			#SESSION
			$session = $this->Harvestpad->findUser($paramAuthID, ['token', 'session']);
			if(!empty($session) && is_array($session) && !ArrayX::isMulti($session)){
				$paramAuthID = array_merge($session, $paramAuthID);
			}


			YAOUtil::record($paramAuthID);
			return $this->result($paramAuthID, 'Signup Successful');
		}

		return $this->response('ERROR_FAILED');
	}





	//*----------- HARVESTPAD SIGNUP -----------*//
	public function harvestpadSignup(){
		$check = YAOUtil::check('HARVESTPAD_SIGNUP', 'POST');
		if(!isset($check['oDATA'])){return $this->response($check);}
		$param = YAOUtil::param($check);
		if($param === false){return $this->response('ERROR_PRECONDITION');}
		$data = YAOUtil::toColumn($param);
		if(!empty($data)){$data['network'] = ArrayX::toJSON([YAOUtil::getPlatformNetworkName() => 'JOINED']);}


		#AUTHENTICATION
		$authset = $data;
		$authset = YAOUtil::datasetExtract($authset, 'AUTH_SIGNUP');
		$auth = $this->Auth->makeAuth($authset, 'oauthid');
		if(!empty($auth['oauthid'])){
			$paramAuthID['oauthid'] = $auth['oauthid'];


			#PROFILE
			$profileset = $data;
			$profileset = YAOUtil::datasetExtract($profileset, 'PROFILE');
			$this->Profile->maintainProfile($paramAuthID, 'oauthid', $profileset);


			#NETWORK USER
			$this->Network->setAppUserAuthorization($paramAuthID, 'oauthid');


			#SESSION
			$session = $this->Harvestpad->findUser($paramAuthID, ['token', 'session']);
			if(!empty($session) && is_array($session) && !ArrayX::isMulti($session)){
				$paramAuthID = array_merge($session, $paramAuthID);
			}


			YAOUtil::record($paramAuthID);
			return $this->result($paramAuthID, 'Signup Successful');
		}

		return $this->response('ERROR_FAILED');
	}




















	//*----------- FEEDBACK INSTALL -----------*//
	public function feedbackInstall(){
		$check = YAOUtil::check('INSTALL', 'POST');
		if(!isset($check['oDATA'])){return $this->response($check);}
		$param = YAOUtil::param($check);
		if($param === false){return $this->response('ERROR_PRECONDITION');}
		if($param['authorize'] === $this->AuthAO){
			$result = $this->Feedback->installFeedback();
			if($result === true){return $this->success();}
			return $this->response('ERROR_FAILED');
		}
		return $this->response('ERROR_REQUEST_FORBIDDEN');
	}





	//*----------- FEEDBACK-ALL -----------*//
	public function feedbackAll(){
		$column = YAOUtil::asColumn('FEEDBACK');
		$result = $this->Feedback->allFeedback($column, 'NO_LIMIT');
		return $this->result($result);
	}





	//*----------- FEEDBACK IS -----------*//
	public function feedbackIs(){
		$check = YAOUtil::check('FEEDBACK', 'GET', ['bind']);
		if(!isset($check['oDATA'])){return $this->response($check);}
		$param = YAOUtil::param($check);
		if($param === false){return $this->response('ERROR_PRECONDITION');}
		$filter = YAOUtil::toColumn($param);
		if(!empty($filter)){
			$result = $this->Feedback->inFeedback($filter);
			return $this->respIs($result);
		}
		return $this->response('ERROR_FAILED');
	}





	//*----------- FEEDBACK CREATE -----------*//
	public function feedbackCreate(){
		$check = YAOUtil::check('FEEDBACK', 'POST');
		if(!isset($check['oDATA'])){return $this->response($check);}
		$param = YAOUtil::param($check);
		if($param === false){return $this->response('ERROR_PRECONDITION');}
		$data = YAOUtil::toColumn($param);
		$data = YAOUtil::getPlatformNetwork($data);
		YAOUtil::filterExtractID($data);
		if(!empty($data)){
			$result = $this->Feedback->makeFeedback($data);
			return $this->result($result, 'Feedback Created');
		}
		return $this->response('ERROR_FAILED');
	}





	//*----------- FEEDBACK SEARCH -----------*//
	public function feedbackSearch(){
		$check = YAOUtil::check('FEEDBACK', 'POST', 'ENTRY');
		if(!isset($check['oDATA'])){return $this->response($check);}
		$param = YAOUtil::param($check);
		if($param === false){return $this->response('ERROR_PRECONDITION');}
		$param = YAOUtil::toColumn($param);
		$filter = YAOUtil::filterExtractSearch($param);
		if(!empty($filter)){
			$column = YAOUtil::asColumn('FEEDBACK');
			$result = $this->Feedback->findFeedback($filter, $column);
			return $this->result($result);
		}
		return $this->response('ERROR_FAILED');
	}





	//*----------- FEEDBACK UPDATE -----------*//
	public function feedbackUpdate(){
		$check = YAOUtil::check('FEEDBACK', 'POST', ['bind']);
		if(!isset($check['oDATA'])){return $this->response($check);}
		$param = YAOUtil::param($check);
		if($param === false){return $this->response('ERROR_PRECONDITION');}
		$data = YAOUtil::toColumn($param);
		$filter = YAOUtil::filterExtractID($data);
		if(!empty($data) && !empty($filter)){
			$result = $this->Feedback->modifyFeedback($filter, 'puid', $data);
			return $this->yield('UPDATION', $result, 'Feedback Updated', 'Feedback has been modified');
		}
		return $this->response('ERROR_FAILED');
	}





	//*----------- FEEDBACK DELETE -----------*//
	public function feedbackDelete(){
		$check = YAOUtil::check('FEEDBACK', 'POST', ['bind']);
		if(!isset($check['oDATA'])){return $this->response($check);}
		$param = YAOUtil::param($check);
		if($param === false){return $this->response('ERROR_PRECONDITION');}
		$param = YAOUtil::toColumn($param);
		$filter = YAOUtil::filterExtractID($param);
		if(!empty($filter)){
			$result = $this->Feedback->removeFeedback($filter, 'puid');
			return $this->yield('DELETION', $result, 'Feedback Deleted', 'Feedback has been deleted');
		}
		return $this->response('ERROR_FAILED');
	}




















//*----------- PARISH INSTALL -----------*//
public function parishInstall(){
	$check = YAOUtil::check('INSTALL', 'POST');
	if(!isset($check['oDATA'])){return $this->response($check);}
	$param = YAOUtil::param($check);
	if($param === false){return $this->response('ERROR_PRECONDITION');}
	if($param['authorize'] === $this->AuthAO){
		$result = $this->Parish->installParish();
		if($result === true){return $this->success();}
		return $this->response('ERROR_FAILED');
	}
	return $this->response('ERROR_REQUEST_FORBIDDEN');
}




//*----------- PARISH ALL -----------*//
public function parishAll(){
	$column = YAOUtil::asColumn('PARISH');
	$result = $this->Parish->allParish($column, 'NO_LIMIT');
	return $this->result($result);
}





//*----------- PARISH IS -----------*//
public function parishIs(){
	$check = YAOUtil::check('PARISH', 'GET', ['bind']);
	if(!isset($check['oDATA'])){return $this->response($check);}
	$param = YAOUtil::param($check);
	if($param === false){return $this->response('ERROR_PRECONDITION');}
	$filter = YAOUtil::toColumn($param);
	if(!empty($filter)){
		$result = $this->Parish->inParish($filter);
		return $this->respIs($result);
	}
	return $this->response('ERROR_FAILED');
}





//*----------- PARISH CREATE -----------*//
public function parishCreate(){
	$check = YAOUtil::check('PARISH', 'POST');
	if(!isset($check['oDATA'])){return $this->response($check);}
	$param = YAOUtil::param($check);
	if($param === false){return $this->response('ERROR_PRECONDITION');}
	$data = YAOUtil::toColumn($param);
	YAOUtil::filterExtractID($data);
	if(!empty($data)){
		$result = $this->Parish->makeParish($data);
		return $this->result($result, 'Parish Created');
	}
	return $this->response('ERROR_FAILED');
}





//*----------- PARISH SEARCH -----------*//
public function parishSearch(){
	$check = YAOUtil::check('PARISH', 'POST', 'ENTRY');
	if(!isset($check['oDATA'])){return $this->response($check);}
	$param = YAOUtil::param($check);
	if($param === false){return $this->response('ERROR_PRECONDITION');}
	$param = YAOUtil::toColumn($param);
	$filter = YAOUtil::filterExtractSearch($param);
	if(!empty($filter)){
		$column = YAOUtil::asColumn('PARISH');
		$result = $this->Parish->findParish($filter, $column);
		return $this->result($result);
	}
	return $this->response('ERROR_FAILED');
}




//*----------- PARISH UPDATE -----------*//
public function parishUpdate(){
	$check = YAOUtil::check('PARISH', 'POST', ['bind']);
	if(!isset($check['oDATA'])){return $this->response($check);}
	$param = YAOUtil::param($check);
	if($param === false){return $this->response('ERROR_PRECONDITION');}
	$data = YAOUtil::toColumn($param);
	$filter = YAOUtil::filterExtractID($data);
	if(!empty($data) && !empty($filter)){
		$result = $this->Parish->modifyParish($filter, 'puid', $data);
		return $this->yield('UPDATION', $result, 'Parish Updated', 'Parish has been modified');
	}
	return $this->response('ERROR_FAILED');
}





//*----------- PARISH DELETE -----------*//
public function parishDelete(){
	$check = YAOUtil::check('PARISH', 'POST', ['bind']);
	if(!isset($check['oDATA'])){return $this->response($check);}
	$param = YAOUtil::param($check);
	if($param === false){return $this->response('ERROR_PRECONDITION');}
	$param = YAOUtil::toColumn($param);
	$filter = YAOUtil::filterExtractID($param);
	if(!empty($filter)){
		$result = $this->Parish->removeParish($filter, 'puid');
		return $this->yield('DELETION', $result, 'Parish Deleted', 'Parish has been deleted');
	}
	return $this->response('ERROR_FAILED');
}






















	//*----------- WOCA SIGNUP -----------*//
	public function wocaSignup($input=[]){
		$check = YAOUtil::check('WOCA_SIGNUP', 'POST');
		if(!isset($check['oDATA'])){return $this->response($check);}
		$param = YAOUtil::param($check);
		if($param === false){return $this->response('ERROR_PRECONDITION');}
		$data = YAOUtil::toColumn($param);
		if(!empty($data)){$data['network'] = ArrayX::toJSON([YAOUtil::getPlatformNetworkName() => 'JOINED']);}


		#AUTHENTICATION
		$authset = $data;
		$authset = YAOUtil::datasetExtract($authset, 'AUTH_SIGNUP');
		$auth = $this->Auth->makeAuth($authset, 'oauthid');
		if(!empty($auth['oauthid'])){
			$paramAuthID['oauthid'] = $auth['oauthid'];


			#PROFILE
			$profileset = $data;
			$profileset = YAOUtil::datasetExtract($profileset, 'PROFILE');
			$this->Profile->maintainProfile($paramAuthID, 'oauthid', $profileset);


			#NETWORK USER
			$this->Network->setAppUserAuthorization($paramAuthID, 'oauthid');

			#SESSION
			$session = $this->WOCA->findUser($paramAuthID, ['token', 'session']);
			if(!empty($session) && is_array($session) && !ArrayX::isMulti($session)){
				$paramAuthID = array_merge($session, $paramAuthID);
			}


			YAOUtil::record($paramAuthID);
			return $this->result($paramAuthID, 'Signup Successful');
		}

		return $this->response('ERROR_FAILED');
	}



} /*** End Of ~LimeAPI ***/