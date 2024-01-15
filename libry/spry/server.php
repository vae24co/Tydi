<?php //*** ServerX » Tydi™ Framework © 2024 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

class ServerX {

	// • ==== call → handler - undefined method » error
	public function __call($method, $argument) {
		$caller = __CLASS__ . '→' . $method . '()';
		return DebugX::oversight(__CLASS__, 'Method Unreachable', $caller);
	}





	// • ==== callStatic → handler - undefined static method » error
	public static function __callStatic($method, $argument) {
		$caller = __CLASS__ . '::' . $method . '()';
		return DebugX::oversight(__CLASS__, 'Static: Method Unreachable', $caller);
	}





	// • ==== referrer → ... »
	public function referrer() {
		if (!empty($_SERVER['HTTP_REFERER'])) {
			return $_SERVER['HTTP_REFERER'];
		}
		return false;
	}





	// • ==== name → ... »
	public static function name() {
		if (!empty($_SERVER['SERVER_NAME'])) {
			return $_SERVER['SERVER_NAME'];
		}
		return false;
	}





	// • ==== host → ... »
	public static function host() {
		if (!empty($_SERVER['HTTP_HOST'])) {
			return $_SERVER['HTTP_HOST'];
		}
		return false;
	}





	// • ==== hostname → ... »
	public static function hostname() {
		if (!empty(gethostname())) {
			return strtolower(gethostname());
		}
		return false;
	}





	// • ==== ip → ... »
	public static function ip() {
		if (!empty($_SERVER['SERVER_ADDR'])) {
			return strtolower($_SERVER['SERVER_ADDR']);
		}
		return false;
	}





	// • ==== port → ... »
	public static function port() {
		if (!empty($_SERVER['SERVER_PORT'])) {
			return $_SERVER['SERVER_PORT'];
		}
		return false;
	}

} //> end of ServerX