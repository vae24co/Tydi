<?php //*** UtilizrX » Tydi™ Framework © 2024 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

class UtilizrX {

	// • property
	protected static $init = false;
	protected static $route;
	protected static $module;
	protected static $action;
	protected static $method;





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





	// • ==== init → ... »
	public static function init() {
		if (!self::$init) {
			self::$route = RouteX::isGet();
			self::$module = StringX::beforeAs(self::$route, '/');
			self::$action = StringX::after(self::$route, '/');
			if (!self::$action) {
				self::$action = 'index';
			}
			if (RouteX::ismethod('POST') === true) {
				self::$method = 'POST';
			} else {
				self::$method = 'GET';
			}

			self::$init = true;
		}
	}





	// • ==== route → ... »
	public static function route() {
		self::init();
		return self::$route;
	}





	// • ==== module → ... »
	public static function module() {
		self::init();
		return self::$module;
	}





	// • ==== action → ... »
	public static function action() {
		self::init();
		return self::$action;
	}





	// • ==== method → ... »
	public static function method() {
		self::init();
		return self::$method;
	}

} //> end of UtilizrX
