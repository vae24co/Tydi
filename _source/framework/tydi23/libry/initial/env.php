<?php //*** Env - Environment » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//
class Env {

	// • property
	private static $initialized;
	protected static $version;
	protected static $machine;
	public static $environment;



	// • ==== call → handler - undefined method » [error]
	public function __call($method, $argument) {
		return Tydi::oversightX(__CLASS__, 'method unreachable', $method);
	}




	// • ==== callStatic → handler - undefined static method » [error]
	public static function __callStatic($method, $argument) {
		return Tydi::oversightX(__CLASS__, 'static: method unreachable', $method);
	}




	// ◇ ==== init → initialize » [true]
	public static function init() {
		if (self::$initialized !== true) {
			if (empty(self::$environment)) {
				if (!defined('ENVIRONMENT')) {
					Tydi::oversightX('Env', 'Environment Undefined!', __METHOD__);
				} else {
					self::$environment = ENVIRONMENT;
				}
			}
			if (empty(self::$machine)) {
				if (!defined('MACHINE')) {
					Tydi::oversightX('Env', 'Machine Undefined!', __METHOD__);
				} else {
					self::$machine = MACHINE;
				}
			}
			self::$initialized = true;
		}
		return true;
	}




	// ◇ ==== is → get environment
	public static function is($environment = null) {
		self::init();
		if (is_null($environment) || empty($environment)) {
			return self::$environment;
		} else {
			if (strtolower($environment) === strtolower(self::$environment)) {
				return true;
			}
		}
		return false;
	}




	// ◇ ==== machine →
	public static function machine() {
		self::init();
		return self::$machine;
	}




	// ◇ ==== isMachine →
	public static function isMachine($machine) {
		if (strtolower($machine) === strtolower(self::machine())) {
			return true;
		}
		return false;
	}




	// ◇ ==== isLocal → is machine local? » [boolean]
	public static function isLocal() {
		return self::isMachine('LOCAL');
	}




	// ◇ ==== isRemote → is machine remote? » [boolean]
	public static function isRemote() {
		return self::isMachine('REMOTE');
	}




	// • ==== version → get code version
	public static function version($version = null) {

		// » set version
		if (!empty($version)) {
			self::$version = $version;
			return true;
		}

		// » set default version
		if (empty(self::$version)) {
			self::$version = 'oreo';
		}

		// » get version
		return self::$version;
	}




	// • ==== php → set minimum php version » boolean (true) | error
	public static function php($minimum = '8.0') {
		if (!empty($minimum)) {
			$minimum = floatval($minimum);
			$version = floatval(phpversion());
			if ($version < $minimum) {
				return Tydi::oversightX('PHP', "Version Unsupported - {$version}", "above {$minimum} required");
			}
		}
		return true;
	}

} //> end of Env