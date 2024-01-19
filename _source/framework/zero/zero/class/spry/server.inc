<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* ServerX ~ Server Utility • VERSION » alpha-0.0.1 ***/

class ServerX {

	public static function get(){
		if(!empty($_GET)){
			return $_GET;
		}
		return false;
	}


	public static function post(){
		if(!empty($_POST)){
			return $_POST;
		}
		return false;
	}


	public static function request(){
		if(!empty($_REQUEST)){
			return $_REQUEST;
		}
		return false;
	}


	public static function method(){
		if(!empty($_SERVER['REQUEST_METHOD'])){
			return $_SERVER['REQUEST_METHOD'];
		}
		return false;
	}


	public static function isRequest($type){
		$method = self::method();
		if(strtolower($method) === strtolower($type)){
			return true;
		}
		return false;
	}


	#HOST • Get host name
	public static function host(){
		if(!empty($_SERVER['HTTP_HOST'])){
			return strtolower($_SERVER['HTTP_HOST']);
		}
		return false;
	}


	#NAME • Get server name
	public static function name(){
		if(!empty($_SERVER['SERVER_NAME'])){
			return strtolower($_SERVER['SERVER_NAME']);
		}
		return false;
	}


	#HOSTNAME •
	public static function hostname(){
		if(!empty(gethostname())){
			return strtolower(gethostname());
		}
		return false;
	}


	#INFO • Get Information (IP, php/apache/mysql version, etc)
	public static function info($i='INFO'){
		if($i === 'IP' && !empty($_SERVER['SERVER_ADDR'])){
			return strtolower($_SERVER['SERVER_ADDR']);
		}
		elseif($i === 'PHP'){return phpversion();}
		elseif($i === 'APACHE'){return apache_get_version();}
		elseif($i === 'SYSTEM'){return PHP_OS;}
		elseif($i === 'OS'){return php_uname('s');}
		elseif($i === 'HOSTNAME'){return php_uname('n');}
		elseif($i === 'RELEASE'){return php_uname('r');}
		elseif($i === 'VERSION'){return php_uname('v');}
		elseif($i === 'MACHINE'){return php_uname('m');}
		elseif($i === 'INFO'){return php_uname();}
		return false;
	}

} /*** End Of ~ServerX ***/