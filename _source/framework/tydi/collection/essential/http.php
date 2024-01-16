<?php
//*** HTTPX » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//
class oHTTPX {


	// • ==== isMethod →
	public static function isMethod($method) {
		if (!empty($method)) {
			$method = StringX::toCamelCase('is ' . $method);
			if (method_exists(__CLASS__, $method)) {
				return self::$method();
			}
		}
		return false;
	}





	// • ==== isRequestXHR →
	public static function isRequestXHR() {
		if (self::isRequest() && self::isXHR()) {
			return true;
		}
		return false;
	}



	// • ==== isMethodXHR →
	public static function isMethodXHR($method) {
		if (self::isMethod($method) && self::isXHR()) {
			return true;
		}
		return false;
	}




	// • ==== getMethod →
	public static function getMethod() {
		if (!empty($_SERVER['REQUEST_METHOD'])) {
			return strtoupper($_SERVER['REQUEST_METHOD']);
		} elseif (isset($_REQUEST)) {
			return 'REQUEST';
		}
		return false;
	}




	// • ==== data →
	public static function data($method) {
		if (!empty($method)) {
			$method = StringX::toCamelCase('data ' . $method);
			if (method_exists(__CLASS__, $method)) {
				return self::$method();
			}
		}
		return false;
	}




	// • ==== dataGet → http get data
	public static function dataGet() {
		if (isset($_GET)) {
			return $_GET;
		}
		return false;
	}




	// • ==== dataPost → http post data
	public static function dataPost() {
		if (isset($_POST)) {
			return $_POST;
		}
		return false;
	}




	// • ==== dataRequest → http request data
	public static function dataRequest() {
		if (!empty($_REQUEST)) {
			return $_REQUEST;
		}
		return false;
	}




	// • ==== param → collect filtered parameters
	public static function param($param = 'DATA', $method = 'REQUEST') {
		if (is_string($param) && strtoupper($param) === 'DATA') {
			return self::data($method);
		} elseif (!empty($param)) {
			return ArrayX::filterByKey(self::data($method), $param);
		}
		return false;
	}

} //> end of HTTPX