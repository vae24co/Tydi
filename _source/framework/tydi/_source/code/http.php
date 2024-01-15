<?php
//*** HTTPX » Tydi™ ~ AO™ • @iamodao • www.osawere.com ~ © 2023 • Apache License ***//
class HTTPX {

	// ◇ ---- __call • Non-Existent Method » Error
	public function __call($method, $argument) {
		return oversight(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ---- __callStatic • Non-Existent Static Method » Error
	public static function __callStatic($method, $argument) {
		return oversight(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- INIT • Trigger HTTP Errors »
	public static function init($req = null) {
		if (ArrayX::isKey($request, 'olink') && $request['olink'] === 'ehttp') {
			return self::error($req, 'DATA');
		}
		return false;
	}




	// ◇ ==== httpError → detect http error & return uri » []
	public static function httpError($request = null) {
		if (Vars::noData($request)) {
			$request = HTTPX::get('DATA');
		}
		if (Vars::isNotEmptyArray($request)) {
			$request = ArrayX::toObj($request);
		}
		if (Vars::isNotEmptyObject($request) && Vars::is($request->ehttp) && Vars::hasData($request->ehttp)) {
			return [
				'ehttp' => $request->ehttp,
				'uri' => URLX::uri()
			];
		}
		return false;
	}




	// ◇ ==== isHTTPError → check if http error is found » []
	public static function isHTTPError($request = null) {
		$error = self::httpError($request);
		if (Vars::hasData($error)) {
			return true;
		}
		return false;
	}




	// ◇ ---- ERROR • Handle HTTP Errors »
	public static function error($req = null, $request = []) {
		if ($request === 'DATA') {
			$request = self::get('DATA');
		}

		$uri = URLX::uri();
		if (ArrayX::isKeyNotEmpty($request, 'type')) {
			$type = $request['type'];
		} else {
			$type = '';
		}
		if ($req === 'RAW') {
			Vars::abort(array_merge(['error' => 'HTTP ' . $type, 'uri' => $uri], $request));
		} elseif ($req === 'PRINT') {
			oversight('HTTP • E' . $type, 'Not Found ~ An error occurred on your request', $uri);
		} elseif ($req === 'HTML') {
			exit('TODO: HTML HTTP Error View');
		}
		return false;
	}





	// ◇ ---- HTTPS • Redirect to HTTPS »
	public static function https($url = '', $permanent = false) {
		$protocol = self::isSecure() ? 'https' : 'http';
		if ($protocol !== 'https') {
			$res = 'https:#';
			if (!empty($url)) {
				$res .= $url;
			} else {
				if (!empty($_SERVER['HTTP_HOST'])) {
					$res .= $_SERVER['HTTP_HOST'];
				}
				if (!empty($_SERVER['REQUEST_URI'])) {
					$res .= $_SERVER['REQUEST_URI'];
				}
			}
			if (filter_var($res, FILTER_VALIDATE_URL) !== false) {
				$_SESSION['oSSL'] = 'IMPOSED';
				if ($permanent === true) {
					header('HTTP/1.1 301 Moved Permanently');
				}
				return RedirectX::instant($res);
			}
		}
	}





	// ◇ ---- SECURE • Enforce HTTPS »
	public static function imposeHTTPS($enforce = true, $url = '', $permanent = false) {
		if ($enforce === true) {
			return self::https($url, $permanent);
		} else {
			if (session_status() !== PHP_SESSION_ACTIVE) {
				// TODO: Trigger error [requiring $session->start() call]
			}

			if (empty($_SESSION['oSSL']) || $_SESSION['oSSL'] !== 'IMPOSED') {
				return self::https($url, $permanent);
			}
		}
		return false;
	}

} // End Of Class ~ HTTPX