<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* Organizr ~ Organizr Abstract • VERSION » alpha-0.0.7 ***/

abstract class Organizr {
	abstract public function initialize(&$object);
	abstract public function landing(&$object);

} /*** End Of ~Organizr ***/










abstract class APIOrganizr {
	public $response = [];





	//*----------- CONSTRUCT -----------*//
	public function __construct(){
		$this->response['code'] = 'R200SD';
		$this->AuthAO = 'Auth.AO';
		$this->initialize();
	}




	//*----------- abstract method -----------*//
	abstract public function initialize();
	abstract public function landing();





	//*----------- INSTALL FAILED -----------*//
	public function installFailed($data=''){
		$response['status'] = 'F9';
		$response['title'] = 'Installation Failed';
		$response['code'] = 'FAILED';
		if(!empty($resp['message'])){$response['message'] = 'Database installation was not successful for one or more object';}
		if(!empty($data)){$response['data'] = $data;}
		return $this->response($response);
	}





	//*----------- UPDATION -----------*//
	public function updation($response='', $title='', $message=''){
		if(is_numeric($response)){
			if($response == 0){
				$response = ['code' => 'R204SD', 'title' => 'Not Updated', 'message' => 'Your request updated no record'];
			}
			elseif($response > 0){
				$response = [];
				if(!empty($title)){$response['title'] = $title;}
				if(!empty($message)){$response['message'] = $message;}
			}
		}
		elseif($response === 'NO_RESULT'){
			$response = ['code' => 'C406IE', 'title' => 'Update Impossible', 'message' => 'Oh!, your request is impossible to resolve'];
		}
		elseif($response === false){$response = 'ERROR_FAILED';}
		return $this->response($response);
	}





	//*----------- DELETION -----------*//
	public function deletion($response='', $title='', $message=''){
		if(is_numeric($response)){
			if($response == 0){
				$response = ['code' => 'R204SD', 'title' => 'Not Deleted', 'message' => 'Your request deleted no record'];
			}
			elseif($response > 0){
				$response = [];
				if(!empty($title)){$response['title'] = $title;}
				if(!empty($message)){$response['message'] = $message;}
			}
		}
		elseif($response === 'NO_RESULT'){
			$response = ['code' => 'C406IE', 'title' => 'Delete Impossible', 'message' => 'Oh!, your request is impossible to resolve'];
		}
		elseif($response === false){$response = 'ERROR_FAILED';}
		return $this->response($response);
	}





	//*----------- YIELD -----------*//
	public function yield($type, $response='', $title="", $message=""){
		if($type === 'UPDATION'){
			return $this->updation($response, $title, $message);
		}

		if($type === 'DELETION'){
			return $this->deletion($response, $title, $message);
		}
		return $this->response($response);
	}






	//*----------- RESPONSE IS -----------*//
	public function respIs(&$is){
		if($is === false){
			$response = ['code' => 'R204SD', 'title' => 'No Record'];
		}
		elseif($is === true){
			$response = ['code' => 'R200SD', 'title' => 'Record Found', 'message' => 'Your request found record'];
		}
		return $this->response($response);
	}
















	//*----------- RESPONSE -----------*//
	public function response($response){
		if($response === false){$response = 'ERROR_FAILED';}
		if(!empty($response)){
			if(is_array($response)){$this->response = array_merge($this->response, $response);}
			elseif(StringX::in($response, 'ERROR_')){return $response;}
		}
		return $this->response;
	}





	//*----------- RESULT -----------*//
	public function result($result='', $title='', $message=''){
		$response = [];
		if(!empty($result)){
			if(is_array($result)){
				if(empty($title)){$response['title'] = 'Record Found';} else {$response['title'] = $title;}
				if(ArrayX::isMulti($result) && ArrayX::isNumericKey($result)){
					$response['count'] = count($result);
					$response['data'] = $result;
					if(empty($message)){
						if($response['count'] == 1){$response['message'] = 'Your request returned one record';}
						else {$response['message'] = 'Your request returned '.$response['count'].' records';}
					} else {
						$response['message'] = $message;
					}
				}
				else {
					if(empty($message)){$response['message'] = 'Your request returned one record';} else {$response['message'] = $message;}
					$response['count'] = 1;
					$response['data'] = [1 => $result];
				}
			}
			elseif(is_numeric($result)){
				if($result > 0){
					$response = ['code' => 'R200SD', 'count' => $result];
					if(!empty($title)){$response['title'] = $title;}
					if(!empty($message)){$response['message'] = $message;}
				}
			}
			elseif($result === 'NO_RESULT'){
				$response = ['code' => 'R204SD', 'title' => 'No Record'];
			}
		}
		return $this->response($response);
	}





	//*----------- SUCCESS -----------*//
	public function success($resp=''){
		if(!empty($resp['code'])){$response['code'] = $resp['code'];} else {$response['code'] = 'SUCCESS';}
		if(!empty($resp['title'])){$response['title'] = $resp['title'];}
		if(!empty($resp['message'])){$response['message'] = $resp['message'];}
		return $this->response($response);
	}





	//*----------- LOGIN FAILED -----------*//
	public function loginFailed($resp){
		$response['status'] = 'F9';
		$response['title'] = 'Login Failed';
		$response['code'] = 'R417SD';
		if($resp === 'NO_RESULT'){$response['message'] = 'You entered an invalid UserID';}
		elseif($resp === 'PASSWORD_INVALID'){$response['message'] = 'You entered an invalid Password';}
		return $this->response($response);
	}







} /*** End Of ~APIOrganizr ***/










abstract class AppOrganizr {
	abstract public function initialize(&$object);
	abstract public function landing(&$object);

} /*** End Of ~AppOrganizr ***/