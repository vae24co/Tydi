<?php
/*** HTTP ~ HTTP Class » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © January 2023 | Apache License ***/

class HTTP {

	// ◇ ----- CALL • Non-Existent Method » Error
	public function __call($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- CALL STATIC • Non-Existent Static Method » Error
	public static function __callStatic($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- ERROR • Handle HTTP Errors »
	public static function error($req = '', $request = []) {
		if (VarX::isEmpty($request)) {
			$request = HTTP::get('DATA');
		}
		$uri = URL::uri();
		if (ArrayX::isKeyNotEmpty($request, 'type')) {
			$type = $request['type'];
		} else {
			$type = '';
		}
		if ($req === 'RAW') {
			Tydi::abort(array_merge(['error' => 'HTTP ' . $type, 'uri' => $uri], HTTP::get('DATA')));
		} elseif ($req === 'PRINT') {
			ErrorX::is('HTTP • E' . $type, 'Not Found ~ An error occurred on your request', $uri);
		} elseif ($req === 'HTML') {
			exit('TODO: HTML HTTP Error View');
		}
		return false;
	}





	// ◇ ----- ERROR_INIT • Trigger HTTP Errors »
	public static function errorInit($req = '') {
		$request = HTTP::get('DATA');
		if(ArrayX::isKey($request, 'olink') && $request['olink'] === 'ehttp') {
			return self::error($req, $request);
		}
		return false;
	}





	// ◇ ----- METHOD • HTTP Method
	public static function method($input = '') {
		if ($input === 'IS') {
			$method = false;
			if (!empty($_SERVER['REQUEST_METHOD'])) {
				$method = $_SERVER['REQUEST_METHOD'];
			} elseif (isset($_REQUEST)) {
				$method = 'REQUEST';
			}
			return $method;
		} elseif (!empty($input)) {
			$input = strtolower($input);
			if (method_exists(__CLASS__, $input)) {
				return self::$input('IS');
			}
		}

		return false;
	}





	// ◇ ----- GET •
	public static function get($option) {
		if (isset($_GET)) {
			if (!empty($option)) {
				if ($option === 'IS' && $_SERVER['REQUEST_METHOD'] == 'GET') {
					return true;
				}
				if ($option === 'EMPTY' && !empty($_GET)) {
					return true;
				}
				if ($option === 'DATA' && !empty($_GET)) {
					return $_GET;
				}
			}
		}

		return false;
	}





	// ◇ ----- POST •
	public static function post($option) {
		if (isset($_POST)) {
			if (!empty($option)) {
				if ($option === 'IS' && $_SERVER['REQUEST_METHOD'] == 'POST') {
					return true;
				}
				if ($option === 'EMPTY' && !empty($_POST)) {
					return true;
				}
				if ($option === 'DATA' && !empty($_POST)) {
					return $_POST;
				}
			}
		}

		return false;
	}





	// ◇ ----- REQUEST •
	public static function request($option) {
		if (!empty($option) && !empty($_REQUEST)) {
			if ($option === 'IS') {
				return true;
			}
			if ($option === 'DATA') {
				return $_REQUEST;
			}
		}

		return false;
	}





	// ◇ ----- DATA •
	public static function data($method) {
		if (!empty($method)) {
			$method = strtolower($method);
			if (method_exists(__CLASS__, $method)) {
				return self::$method('DATA');
			}
		}

		return false;
	}





	// ◇ ----- PARAM •
	public static function param($param = 'DATA', $method = 'REQUEST'){
		if ($param === 'DATA') {
			return self::data($method);
		}
		elseif(VarX::hasData($param)){
			if (VarX::stringAcceptable($param)) {
				$data = self::data($method);
				if (VarX::hasData($data) && VarX::isArray($data) && ArrayX::isKey($data, $param)) {
					return $data[$param];
				}
			}

			//...Array
			elseif(VarX::isArray($param)){
				foreach($param as $key){
					$res[$key] = self::param($key, $method);
				}
				return $res;
			}
		}
		return false;
	}





	// ◇ ----- AJAX • Check Request Type & Method » Boolean
	public static function ajax($input = '') {
		if ($input === 'IS' && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			return true;
		} elseif (VarX::isNotEmpty($input)) {
			if (self::method($input) && self::ajax()) {
				return true;
			}
		}
		return false;
		// TODO: Run a Test!
	}





	// ◇ ----- REDIRECT • URL Redirect (triggered) »
	public static function redirect($delay = false) {
		if (isset($_REQUEST['redirect'])) {
			$url = urldecode($_REQUEST['redirect']);
			if ($url && $url !== '') {
				if (!StringX::begin($url, 'http:/') && !StringX::begin($url, 'https:/')) {
					$url = URL::base() . '/' . $url;
				} else {
					$url = StringX::cropBegin($url, 'http://', '');
					$url = StringX::cropBegin($url, 'https://', '');

					// ~ For safety reasons on URL
					$url = StringX::cropBegin($url, 'http:/');
					$url = StringX::cropBegin($url, 'https:/');

					$url = URL::to($url, 'SECURE');
				}
				return Redirect::to($url, $delay, true);
			}
		}
		return false;
	}

} // End Of Class ~ HTTP