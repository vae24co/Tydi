<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* PingAPI ~ Ping API Organizr • VERSION » alpha-0.0.7 ***/

class PingAPI extends APIOrganizr {

	//*----------- INITIALIZE -----------*//
	public function initialize(){

	}





	//*----------- LANDING -----------*//
	public function landing(){
		$response['title'] = 'Ping Recieved';
		$response['message'] = 'Your request to ping the server was recieved';
		return $this->response($response);
	}





	//*----------- ERROR -----------*//
	public function error(){
		$this->response['code'] = 'ERROR';
		$this->response['title'] = 'Ping Error';
		$this->response['message'] = 'Your request to ping the server returned an error';
		$this->response['errorid'] = 'GENRQ';
		$response['extra'] = ['reason' => 'Error triggered', 'purpose' => 'To simulate error reporting in design'];
		return $this->response($response);
	}





	//*----------- FAILURE -----------*//
	public function failure(){
		$this->response['code'] = 'R417SD';
		$this->response['title'] = 'Ping Failure';
		$this->response['message'] = 'Your request to ping the server failed';
		return $this->response;
	}





	//*----------- SUCCESS -----------*//
	public function success($response = ['title' => 'Ping Successful', 'message' => 'Your request to ping the platform was successful']){
		return $this->response($response);
	}





	//*----------- PROJECT -----------*//
	public function project(){
		$this->response['title'] = 'Ping Data';
		$this->response['message'] = 'Your have successfully ping for data';
		$this->response['count'] = 1;
		$this->response['data'] = SETTING['PROJECT'];
		return $this->response;
	}

} /*** End Of ~PingAPI ***/