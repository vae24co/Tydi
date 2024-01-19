<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* APIX ~ API Utility • VERSION » alpha-0.0.1 ***/

class APIX {

	private $request;
	private $view;
	private $routes;
	private $keys;
	private $link;
	private $model;
	private $class;
	private $method;
	private $organizr;
	private $api;
	// private $caller;



	#CONSTRUCT •
	public function __construct(){
		$this->request = oRequestX();
		return;
	}


	#DISPLAY •
	private function display($response){
		if($this->view === 'JSON'){JSONX::display($response);}
		elseif($this->view === 'TRACE'){oTraceX($response);}
		exit;
	}


	#RESPONSE •
	private function response($code){
		$error = oErrorDataX($code);
		$response = oResponseX($error);
		$this->display($response);
	}


	#ERROR •
	private function error($code){
		$error = oErrorDataX($code);
		$response = oResponseX($error);
		//TODO: Log error, if error exists (create unique id for errorlog at oResponseX)
		$this->display($response);
	}


	private function errorIs($error){
		$e = oIsErrorX($error);
		return $this->error($e);
	}





	//*----------- INITIALIZE -----------*//
	public function initialize($init=[]){
		$this->link = RouteX::get('LINK');
		$this->model = RouteX::get('MODEL');
		$this->class = RouteX::get('CLASS');
		$this->method = RouteX::get('METHOD');
		$this->organizr = $this->class.'O';
		$this->api = $this->class.'API';
		$this->view = 'TRACE';

		if(!empty($init['VIEW'])){$this->view = $init['VIEW'];}
		if(!empty($init['ROUTE'])){$this->routes = $init['ROUTE'];}
		if(!empty($init['KEY'])){$this->keys = $init['KEY'];}

		return true;
	}



	#VERIFY •
	public function verify(){

		#Verify Display Type
		if(empty($this->view)){return $this->error(['code' => 'C428DE']);}
		$views = ['AUTO', 'JSON', 'TRACE', 'STRING'];
		if(!in_array($this->view, $views)){return $this->error(['code' => 'C400DE', 'summary' => 'API Init - Invalid Config ~View ('.$this->view.')']);}

		#Verify BaseURL
		$url = URLX::fixer('API');
		if(!is_bool($url) && !empty($url)){
			return $this->error(['code' => 'C400IE', 'summary' => 'Implementation :: Wrong BaseURL', 'extra' => ['current' => URLX::current(), 'expected' => $url], 'object' => 'API_URL']);
		}

		#Verify Keys Definition
		if(empty($this->keys)){
			global $oINITZR;
			return $this->error(['code' => 'C428DE', 'summary' => 'Programmer :: Keys Undefined', 'extra' => $oINITZR, 'object' => 'KEYS']);
		}

		#Verify Param - System
		if(!isset($this->request['system'])){
			return $this->error(['code' => 'C428IE', 'summary' => 'Implementation :: Parameter Required', 'extra' => 'Param::System', 'object' => 'PARAM']);
		}

		#Verify Param Value - System
		if(empty($this->request['system'])){
			return $this->error(['code' => 'C428IE', 'summary' => 'Implementation :: Input Required', 'extra' => 'Input::System', 'object' => 'INPUT']);
		}

		#Verify Param - Key
		if(!isset($this->request['key'])){
			return $this->error(['code' => 'C428IE', 'summary' => 'Implementation :: Parameter Required', 'extra' => 'Param::Key', 'object' => 'PARAM']);
		}

		#Verify Param Value - Key
		if(empty($this->request['key'])){
			return $this->error(['code' => 'C428IE', 'summary' => 'Implementation :: Input Required', 'extra' => 'Input::Key', 'object' => 'INPUT']);
		}

		#Verify API Key
		$isTokenValid = oFindAPIKey($this->request['system'], $this->request['key'], $this->keys);
		if($isTokenValid === false){
			return $this->error(['code' => 'C498IE', 'summary' => 'Implementation :: Invalid API Token - '.$this->request['key'], 'object' => 'INPUT', 'message' => 'Oh!, you provided an invalid API Token', 'extra' => ['system' => $this->request['system'], 'key' => $this->request['key']]]);
		}


		if(oEnvX('PROD') && $this->request['system'] === 'STAGING'){
			return $this->error(['code' => 'C498IE', 'summary' => 'Production :: Token Required - '.$this->request['key'], 'object' => 'INPUT', 'message' => 'Oh!, you provided a staging token for production', 'extra' => ['system' => $this->request['system'], 'key' => $this->request['key']]]);
		}

		#Verify Routes Definition
		if(empty($this->routes)){
			global $oINITZR;
			return $this->error(['code' => 'C428DE', 'summary' => 'Programmer :: Routes Undefined', 'extra' => $oINITZR, 'object' => 'ROUTES']);
		}

		#Verify Endpoint
		if(!array_key_exists($this->model, $this->routes) && !in_array($this->model, $this->routes)){
			$error = ['code' => 'C498IE', 'summary' => 'Implementation :: Invalid Endpoint - '.$this->link, 'object' => 'ENDPOINT', 'extra' => 'Route::'.$this->model.ucfirst($this->method), 'title' => 'Route Unsupported'];
			return $this->error($error);
		}

		if($this->method !== 'landing'){
			if(!array_key_exists($this->model, $this->routes)){
				$error = ['code' => 'C498IE', 'summary' => 'Implementation :: Invalid Endpoint - '.$this->link, 'object' => 'ENDPOINT', 'extra' => $this->model.'::'.$this->method, 'title' => 'Unsupported Route'];
				return $this->error($error);
			}
			else {
				if(!in_array($this->method, $this->routes[$this->model])){
					$error = ['code' => 'C498IE', 'summary' => 'Implementation :: Invalid Endpoint - '.$this->link, 'object' => 'ENDPOINT', 'extra' => $this->model.'::'.$this->method, 'title' => 'Unsupported Route'];
					return $this->error($error);
				}
			}
		}

		return true;
	}







	#IGNITE • Make request to API's Organizr, prepare and return response
	public function ignite(){
		// $organizrFile = APIZR.strtolower($this->class).'.inc';
		$organizrFile = APIZR.strtolower($this->model).'.inc';
		if(file_exists($organizrFile)){$object = $this->api;} else {$object = $this->organizr;}
		$this->caller = new $object;
		if(!method_exists($this->caller, $this->method)){
			$error = ['code' => 'C501DE', 'summary' => 'Developer :: Class Method Undefined', 'object' => 'CLASS_METHOD', 'extra' => $object.'::'.$this->method.'()'];
			return $this->error($error);
		}

		$response = $this->caller->{$this->method}();
		if(!empty($response)){
			if(is_array($response)){return $this->response($response);}
			else {
				if(StringX::in($response, 'ERROR_')){
					$error = StringX::swap($response, 'ERROR_', '', 'FIRST');
					return $this->errorIs($error);
				}
			}
		}
		return $this->errorIs('NO_RESPONSE');
	}


	#GET •
	public function get($property){
		if(!empty($property)){
			$property = strtolower($property);
			if(isset($this->{$property})){return $this->{$property};}
		}
		return false;
	}

} /*** End Of ~APIX ***/