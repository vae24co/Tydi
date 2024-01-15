<?php
//*** URLX » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//
class oURLX {





	public static function get($excludeParam = false, $fullLink = false) {
		$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
		$name = ServerX::getName();
		$port = ServerX::getPort();
		$uri = ServerX::getURI();
		if ($fullLink === true) {
			$link = $protocol . $name . ':' . $port . $uri;
		} else {
			$link = $protocol . $name . $uri;
		}

		if ($excludeParam === true) {
			$excludedLink = StringX::before($link, '?');
			if (!empty($excludedLink)) {
				return $excludedLink;
			}
		}
		return $link;
	}








	// ◇ ==== getQueryString → query string » [string|false]
	public static function getQueryString($link = null) {
		if (!empty($link)) {
			$query = StringX::after($link, '?');
		} else {
			$query = ServerX::getQueryString();
		}
		if (!empty($query)) {
			return $query;
		}
		return false;
	}




	// ◇ ==== parameter → get parameter » [array|false]
	public static function getParameter($link = null) {
		if (!empty($link)) {
			$query = StringX::after($link, '?');
		} else {
			$query = ServerX::getQueryString();
		}
		if (!empty($query)) {
			parse_str($query, $param);
		}
		if (!empty($param) && is_array($param)) {
			return $param;
		}
		return false;
	}




	// ◇ ==== getProtocol → get protocol » [string|boolean]
	public static function getProtocol($link = null) {
		if (!empty($link)) {
			$parsed = parse_url($link);
			if (!empty($parsed) && is_array($parsed) && !empty($parsed['scheme'])) {
				return $parsed['scheme'] . '://';
			}
		} else {
			$https = 'INACTIVE';
			$port = 'DEFAULT';
			if (!empty($_SERVER['HTTPS'])) {
				$https = $_SERVER['HTTPS'];
			}
			if ($https !== 'INACTIVE') {
				$https == 'ACTIVE';
			}
			if (!empty($_SERVER['SERVER_PORT'])) {
				$port = $_SERVER['SERVER_PORT'];
			}
			if ($https == 'ACTIVE' || $port == 443) {
				return 'https://';
			} elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
				return 'https://';
			} elseif (!empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
				return 'https://';
			}
			return 'http://';
		}
		return false;
	}




	// ◇ ==== getDomain → get url domain »
	public static function getDomain($link = null, $library = []) {
		if (empty($link)) {
			$link = self::getBase();
		}
		$link = parse_url($link, PHP_URL_HOST);
		if (empty($library)) {
			$library = ['www.', 'api.', 'app.', 'en.', 'uk.', 'us.', 'ng.'];
		}
		foreach ($library as $crop) {
			$link = StringX::cropBegin($link, $crop);
		}
		return $link;
	}




	// ◇ ==== getFile → get url file name »
	public static function getFile($link, $library = []) {
		$link = parse_url($link, PHP_URL_PATH);
		$link = basename($link);
		if (empty($library)) {
			$library = ['.php', '.inc', '.html'];
		}
		foreach ($library as $crop) {
			$link = StringX::stripLast($link, $crop);
		}
		return $link;
	}




	// ◇ ==== isSecure → is url protocol secure » [boolean]
	public static function isSecure($link = null) {
		$protocol = self::getProtocol($link);
		if (in_array($protocol, ['https://', 'ftps://'])) {
			return true;
		}
		return false;
	}




	// ◇ ==== makeSecure → make url secure » [string|boolean]
	public static function makeSecure($link) {
		if (!self::isSecure($link)) {
			if (StringX::begin($link, 'ftp://')) {
				$link = StringX::swapFirst($link, 'ftp://', 'ftps://');
			} elseif (StringX::begin($link, 'http://')) {
				$link = StringX::swapFirst($link, 'http://', 'https://');
			} else {
				$link = 'https://' . $link;
			}
			return $link;
		}
		return false;
	}




	// ◇ ==== prepare → prepare url » [string, false]
	public static function prepareLink($link, $excludeParam = false) {
		if (strtoupper($link) === 'SELF') {
			$link = self::get($$excludeParam);
		} elseif (strtoupper($link) === 'BASE') {
			$link = self::getBase();
		}
		return $link;
	}




	// ◇ ==== to → url utility »
	public static function to($link, $req, $library = []) {
		$link = self::prepareLink($link);
		if (!$link) {
			return false;
		}
		if ($req === 'SECURE') {
			$link = self::makeSecure($link);
		}
		if ($req === 'NAME') {
			$link = self::getFile($link, $library);
		}
		if ($req === 'DOMAIN' || $req === 'HOSTNAME') {
			$link = self::getDomain($link, $library);
		}
		return StringX::crop($link);
	}















	// ◇ ==== is → url utility » [string, boolean]
	public static function isz(string $req = 'IS', string $link = '') {
		// • GET: current url full path
		if ($req === 'IS') {
			return self::base() . self::getURI();
		}

		// • CHECK: if url is Secure
		elseif ($req === 'SECURE') {
			if ($link === '' && self::protocol() === 'https') {
				return true;
			} elseif ($link !== '' && StringX::begin($link, 'https://')) {
				return true;
			}
		}

		return false;
	}












	// ◇ ==== fixer → fix url » [string, boolean]
	public static function fixerz(string $baseURL, string $req, string $compareURL = 'SELF', $uri = true, $delay = false) {
		// • prepare url, uri & comparison
		if (Vars::isEmpty($baseURL)) {
			return false;
		}
		if ($uri === true) {
			$uri = self::getURI();
		}
		$baseURL = StringX::cropEnd($baseURL, '/');
		if (Vars::isNotEmpty($uri)) {
			if (!StringX::begin($uri, '/')) {
				$uri = '/' . $uri;
			}
		}
		$baseURL = self::to($baseURL . $uri, 'SECURE');
		$compareURL = self::prepareLink($compareURL);


		// • resolve
		if ($compareURL !== $baseURL) {
			if ($req === 'URL') {
				return $baseURL;
			} elseif ($req === 'REDIRECT') {
				return RedirectX::to($baseURL, $delay, true);
			}
			return false;
		}

		return true;
	}

} //> end of URLX