<?php
/* URL ~ URL Class » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © January 2023 | Apache License */

declare(strict_types=1);

class URL {
	// ◇ ----- CALL • Non-Existent Method » Error
	public function __call($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- CALL STATIC • Non-Existent Static Method » Error
	public static function __callStatic($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- REF • Referrer URL » String | Boolean [false]
	public static function ref() {
		if (!empty($_SERVER['HTTP_REFERER'])) {
			return $_SERVER['HTTP_REFERER'];
		}
		return false;
	}





	// ◇ ----- URI • The URI » String | Boolean [false]
	public static function uri() {
		if (!empty($_SERVER['REQUEST_URI'])) {
			return $_SERVER['REQUEST_URI'];
		}
		return false;
	}





	// ◇ ----- QUERY STRING • Query String » String | Boolean [false]
	public static function querystring() {
		if (!empty($_SERVER['QUERY_STRING'])) {
			return $_SERVER['QUERY_STRING'];
		}
		return false;
	}





	// ◇ ----- PROTOCOL • HTTP Protocol » String
	public static function protocol() {
		return SSL::https() ? 'https' : 'http';
	}





	// ◇ ----- BASE • Base URL » String
	public static function base() {
		return self::protocol() . '://' . Server::host();
	}





	// ◇ ---- FILE • Current File » String | Boolean [false]
	public static function file(string $req = 'FILE') {
		if (!empty($_SERVER['PHP_SELF'])) {
			$res = StringX::stripFirst($_SERVER['PHP_SELF'], '/');
			if ($req === 'NAME') {
				$res = StringX::stripLast($res, '.php');
			}
			return $res;
		}
		return false;
	}





	// ◇ ----- IS • ... » String | Boolean
	public static function is(string $req = 'IS', string $link = '') {
		//...Current URL full path
		if ($req === 'IS') {
			return self::base() . self::uri();
		}

		//...Check if URL is Secure
		elseif ($req === 'SECURE') {
			if ($link === '' && self::protocol() === 'https') {
				return true;
			} elseif ($link !== '' && StringX::begin($link, 'https://')) {
				return true;
			}
		}
		return false;
	}





	// ◇ ----- PREP • Prepare URL » String | Boolean [false]
	public static function prep(string $link) {
		if (VarX::isEmpty($link)) {
			return false;
		} elseif ($link === 'SELF') {
			$link = self::is('IS');
		} elseif ($link === 'BASE') {
			$link = self::base();
		}
		return $link;
	}




	// ◇ ----- TO • ... » String | Boolean [false]
	public static function to(string $link, string $req, array $library = []) {
		//...Prepare Link
		$link = self::prep($link);
		if (!$link) {
			return false;
		}

		//...Secure Link
		if ($req === 'SECURE') {
			if (!self::is('SECURE', $link)) {
				if (StringX::begin($link, 'http://')) {
					$link = StringX::swapFirst($link, 'http://', 'https://');
				} else {
					$link = 'https://' . $link;
				}
			}
		}

		//...Link Name
		if ($req === 'NAME') {
			$link = parse_url($link, PHP_URL_PATH);
			$link = basename($link);
			if (VarX::isEmpty($library)) {
				$library = ['.php', '.inc', '.html'];
			}
			foreach ($library as $crop) {
				$link = StringX::stripLast($link, $crop);
			}
		}

		//...Domain or Host Name
		if ($req === 'DOMAIN' || $req === 'HOSTNAME') {
			$link = parse_url($link, PHP_URL_HOST);
			if ($req === 'DOMAIN') {
				if (VarX::isEmpty($library)) {
					$library = ['www.', 'api.', 'app.', 'en.', 'uk.', 'us.', 'ng.'];
				}
				foreach ($library as $crop) {
					$link = StringX::stripFirst($link, $crop);
				}
			}
		}
		return StringX::crop($link);
	}





	// ◇ ---- FIXER • Fix URL » String | Boolean
	public static function fixer(string $baseURL, string $req, string $compareURL = 'SELF', $uri = true, $delay = false) {
		//...Prepare URL, URI & Comparison
		if (VarX::isEmpty($baseURL)) {
			return false;
		}
		if ($uri === true) {
			$uri = self::uri();
		}
		$baseURL = StringX::cropEnd($baseURL, '/');
		if (VarX::isNotEmpty($uri)) {
			if (!StringX::begin($uri, '/')) {
				$uri = '/' . $uri;
			}
		}
		$baseURL = self::to($baseURL . $uri, 'SECURE');
		$compareURL = self::prep($compareURL);


		//...Resolve
		if ($compareURL !== $baseURL) {
			if ($req === 'URL') {
				return $baseURL;
			} elseif ($req === 'REDIRECT') {
				return Redirect::to($baseURL, $delay, true);
			}
			return false;
		}
		return true;
	}

} // End Of Class ~ URL