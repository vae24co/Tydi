<?php
//*** ServerX » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//
class oServerX {




	// ◇ ==== getURI → the uri » [string, false]
	public static function getURI() {
		if (!empty($_SERVER['REQUEST_URI'])) {
			return $_SERVER['REQUEST_URI'];
		}
		return false;
	}




	// ◇ ==== getQueryString → query string » [string, false]
	public static function getQueryString() {
		if (!empty($_SERVER['QUERY_STRING'])) {
			return $_SERVER['QUERY_STRING'];
		}
		return false;
	}




	// ◇ ==== getInfo → get server information
	public static function getInfo($i = 'INFO') {
		if (strtoupper($i) === 'PHP') {
			return phpversion();
		}
		if (strtoupper($i) === 'APACHE') {
			return apache_get_version();
		}
		if (strtoupper($i) === 'SYSTEM') {
			return PHP_OS;
		}
		if (strtoupper($i) === 'OS') {
			return php_uname('s');
		}
		if (strtoupper($i) === 'HOSTNAME') {
			return php_uname('n');
		}
		if (strtoupper($i) === 'RELEASE') {
			return php_uname('r');
		}
		if (strtoupper($i) === 'VERSION') {
			return php_uname('v');
		}
		if (strtoupper($i) === 'MACHINE') {
			return php_uname('m');
		}
		if (strtoupper($i) === 'INFO') {
			return php_uname();
		}
		if (strtoupper($i) === 'IP' && !empty($_SERVER['SERVER_ADDR'])) {
			return strtolower($_SERVER['SERVER_ADDR']);
		}

		return false;
	}




	// ◇ ==== getFile → current file » [string, false]
	public static function getFile($req = 'FILE') {
		if (!empty($_SERVER['PHP_SELF'])) {
			$o = StringX::stripFirst($_SERVER['PHP_SELF'], '/');
			if (strtoupper($req) === 'NAME') {
				$o = StringX::stripLast($o, '.php');
			}
			return $o;
		}
		return false;
	}

} //> end of ServerX