<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* APPX ~ APP Utility • VERSION » alpha-0.0.7 ***/

class APPX {
	private $app;
	private $organizr;
	private $caller;

	private $error_as = 'TRACE';




	private function display($response){
		if($this->error_as === 'TRACE'){oTraceX($response);}
		else {
			//TODO: Load Error Display
		}
		exit;
	}





	//*----------- ERROR -----------*//
	private function error($code){
		$error = oErrorDataX($code);
		$response = oResponseX($error);
		$this->display($response);
	}





	//*----------- ERROR IS -----------*//
	private function errorIs($error){
		$e = oIsErrorX($error);
		return $this->error($e);
	}





	//*----------- INITIALIZE -----------*//
	public function initialize($route=[]){
		if(!empty($route)){$this->routes = $route;}
		$this->link = RouteX::get('LINK');
		$this->status = RouteX::get('STATUS');
		$this->action = RouteX::get('ACTION');
		$this->model = RouteX::get('MODEL');
		$this->class = RouteX::get('CLASS');
		$this->method = RouteX::get('METHOD');
		$this->organizr = $this->class.'O';
		$this->app = $this->class.'App';

		#prepare caller
		$organizr = APPZR.strtolower($this->model).'.inc';
		if(file_exists($organizr)){$object = $this->app;} else {$object = $this->organizr;}
		$this->caller = $object;

		return true;
	}





	//*----------- PAGE -----------*//
	public static function page(){
		if(RouteX::issite()){
			$page = RouteX::get('LINK');
			$page = StringX::swap($page, '/', '-');
			if(StringX::last($page) == '-'){$page = StringX::swap($page, '-', '', 'LAST');}
			if(!empty($page)){return $page;}
		}
		return false;
	}





	//*----------- TITLE -----------*//
	public static function title($title=''){
		if(empty($title)){
			$page = self::page();
			if($page === 'index'){$title = 'Home';}
			else {
				$title = $page;
				if(StringX::in($title, '-')){
					$title = StringX::swap($title, '-', ' ');
					$title = ucwords($title);
				}
			}
		}
		if(!empty(SETTING['PROJECT']['Title'])){$title .= ' • '.SETTING['PROJECT']['Title'];}
		if(!empty(SETTING['PROJECT']['Brand'])){$title .= ' - '.SETTING['PROJECT']['Brand'];}
		return $title;
	}




	//*----------- CALLER -----------*//
	public function caller(){
		return $this->caller;
	}





	//*----------- IGNITE -----------*//
	public function ignite(){
		$caller = new $this->caller;
		if(!method_exists($caller, $this->method)){
			$error = ['code' => 'C501DE', 'summary' => 'Developer :: Class Method Undefined', 'object' => 'CLASS_METHOD', 'extra' => $this->caller.'::'.$this->method.'()'];
			return $this->error($error);
		}

		// $response = $this->caller->{$this->method}($this);
		// if(!empty($response)){
			// 	if(is_array($response)){return $this->response($response);}
			// 	else {
				// 		if(StringX::in($response, 'ERROR_')){
					// 			$error = StringX::swap($response, 'ERROR_', '', 'FIRST');
					// 			return $this->errorIs($error);
					// 		}
					// 	}
					// }
					// return $this->errorIs('NO_RESPONSE');
				}

			} /*** End Of ~APPX ***/