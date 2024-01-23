<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* RouteX ~ Route Utility • VERSION » alpha-0.0.1 ***/

class iRouteX {
	private static $prefix;
	private static $uri;
	private static $link;
	private static $source;
	private static $platform;
	private static $status;
	private static $model;
	private static $action;
	private static $class;
	private static $method;


	#INITIALIZE • Initialize the routing
	public static function initialize($prefix=''){
		if(empty($prefix)){$prefix = 'o';}
		self::$prefix = strtolower($prefix);

		if(!isset($_GET)){
			$error = ['code' => 'CE400AE', 'object' => 'GET'];
			return oErrorX($error);
		}

		if(empty($_GET)){
			$error = ['code' => 'CE400AE', 'object' => 'GET', 'message' => 'The expected data was not recieved'];
			return oErrorX($error);
		}

		if(!isset($_GET['link'])){
			$error = ['code' => 'CE400DE', 'object' => 'LINK'];
			return oErrorX($error);
		}

		return self::prepare();
	}


	#PREPARE •
	private static function prepare(){
		self::uri();
		self::link();
		self::osource();
		self::oplatform();
		self::status();
		self::model();
		self::action();
		self::codify();
		return true;
	}


	#URI • Set URI
	private static function uri(){
		self::$uri = $_GET;
		return true;
	}


	#LINK • Set Link
	private static function link(){
		$link = self::$uri['link'];
		if(empty($link)){$link = 'index';}
		$link = oCleanX($link, 'LOWERCASE');
		if(StringX::in($link, 'api/')){$link = StringX::swap($link, 'api/', '');}
		if(StringX::in($link, 'app/')){$link = StringX::swap($link, 'app/', '');}
		if(empty($link)){$link = 'index';}
		self::$link = $link;
		return true;
	}


	#SOURCE • Set Source
	private static function osource(){
		$uri = self::$uri;
		if(empty($uri['osource'])){$source = 'main';} else {$source = $uri['osource'];}
		if(StringX::in($source, '.')){$source = StringX::swap($source, '.', '');}
		$ismain = ['www', 'app', 'api'];
		if(in_array($source, $ismain) || $source == 'main'){$source = 'main';} else {$source = self::$prefix.$source;}
		$source = oCleanX($source, 'LOWERCASE');
		self::$source = $source;
		return true;
	}


	#PLATFORM •
	private static function oplatform(){
		$uri = self::$uri;
		if(empty($uri['oplatform'])){$platform = 'site';} else {$platform = $uri['oplatform'];}
		$platform = oCleanX($platform, 'LOWERCASE');
		self::$platform = $platform;
		return true;
	}


	#STATUS •
	private static function status(){
		$uri = self::$link;
		if(StringX::in($uri, '!')){
			#reprepare link
			$link = StringX::before($uri, '!');
			if(empty($link) || $link === 'oFAILED'){$link = 'index';}
			self::$link = $link;

			#prepare status
			$status = StringX::after($uri, '!');
			if(empty($status) || $status === 'oFAILED'){$status = '';}
			else {
				$status = StringX::swap($status, '!', '');
				$status = StringX::swap($status, '_', '-');
				$status = StringX::crop($status, '-');
			}
		}
		if(empty($status)){$status = 'default';}
		else {$status = oCleanX($status, 'LOWERCASE');}
		self::$status = $status;
		return true;
	}


	#MODEL •
	private static function model(){
		$link = self::$link;
		if($link === 'index'){
			$model = 'index';
		}
		if(StringX::in($link, '/')){
			$model = StringX::before($link, '/');
			if(empty($model) || $model === 'oFAILED'){$model = '';}
		}
		if(empty($model)){$model = 'index';}
		else {$model = oCleanX($model, 'LOWERCASE');}
		self::$model = $model;
		return true;
	}


	#ACTION •
	private static function action(){
		$link = self::$link;
		$model = self::$model;
		if($model === 'index' && $link !== 'index'){
			if(StringX::in($link, 'index/')){$action = StringX::swap($link, 'index/', '', 'FIRST');}
			else {$action = $link;}
		}
		elseif(StringX::in($link, $model)){
			$o = StringX::swap($link, $model, '', 'FIRST');
			if(StringX::in($o, '/') && strlen($o) > 1){
				$o = StringX::swap($o, '/', '-');
				$o = StringX::crop($o, '-');
			}
			$action = $o;
		}
		if(empty($action) || $action === '/'){$action = 'landing';}
		else {
			$action = oCleanX($action, 'LOWERCASE');
			$action = StringX::swap($action, '_', '-');
			// $action = StringX::swap($action, '/', '-');
			$action = StringX::crop($action, '-');
			$action = StringX::crop($action, '/');
		}
		self::$action = $action;
		return true;
	}


	#CODIFY •
	private static function codify(){
		$link = self::$link;
		if(empty($link) || $link === 'index'){
			self::$class = 'Index';
			self::$method = 'landing';
		}
		else {
			$model = self::$model;
			$action = self::$action;

			if(empty($model) || $model === 'index'){
				self::$class = 'Index';
			}
			else {
				$class = $model;
				$class = StringX::swap(ucwords($class, '_'), '_', '');
				$class = StringX::swap(ucwords($class, '-'), '-', '');
				self::$class = $class;
			}

			if(!empty($action)){
				$method = $action;
				$method = StringX::swap(ucwords($method, '-'), '-', '');
				$method = StringX::swap(ucwords($method, '/'), '/', '');
				$method = lcfirst($method);
				self::$method = $method;
			}
		}
		return true;
	}


	#KEY •
	private static function key(){
		$uri = self::$uri;
		if(!empty($uri['key'])){return strtolower($uri['key']);}
		return false;
	}


	#IS_API •
	public static function isapi(){
		if(self::$platform === 'api'){return true;}
		return false;
	}


	#IS_APP •
	public static function isapp(){
		if(self::$platform === 'app'){return true;}
		return false;
	}


	#IS_SITE •
	public static function issite(){
		if(!self::isapi() && !self::isapp()){return true;}
		return false;
	}


	#ROUTZR • Returns routzr as detected or provided
	public static function routzr($flag='AUTO'){
		if($flag === 'AUTO'){
			if(self::isapi()){$o = 'api';}
			elseif(self::isapp()){$o = 'app';}
			else {$o = 'site';}
			return $o;
		}
		return $flag;
	}


	#GET •
	public static function get($flag=''){
		if($flag === 'URI'){$o = self::$uri;}
		if($flag === 'LINK'){$o = self::$link;}
		if($flag === 'SOURCE'){$o = self::$source;}
		if($flag === 'PLATFORM'){$o = self::$platform;}
		if($flag === 'STATUS'){$o = self::$status;}
		if($flag === 'MODEL'){
			$o = self::$model;
			$o = StringX::swap($o, '-', '_');
			$o = StringX::crop($o, '_');
		}
		if($flag === 'ACTION'){$o = self::$action;}
		if($flag === 'CLASS'){$o = self::$class;}
		if($flag === 'METHOD'){$o = self::$method;}
		if($flag === 'KEY'){$o = self::$key;}
		if($flag === 'ROUTZR'){$o = self::routzr('AUTO');}
		if(empty($o)){return false;}
		return $o;
	}
} /*** End Of ~RouteX ***/