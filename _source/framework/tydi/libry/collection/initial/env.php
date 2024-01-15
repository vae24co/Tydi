<?php
//*** Env - Environment » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//
class Env {

	// ◇ property
	private static $initialized;
	protected static $machine;
	protected static $config;
	public static $env;




	// ◇ ==== call → handler - undefined method » [error]
	public function __call($method, $argument) {
		return OversightX(__CLASS__, 'method unreachable', $method);
	}




	// ◇ ==== callStatic → handler - undefined static method » [error]
	public static function __callStatic($method, $argument) {
		return OversightX(__CLASS__, 'static method unreachable', $method);
	}




	// ◇ ==== init → initialize » [true]
	public static function init() {
		if (self::$initialized !== true) {
			if (empty(self::$env)) {
				if (!defined('ENV')) {
					exit('<strong>' . TYDI . '™</strong> • Environment Undefined!');
				} else {
					self::$env = ENV;
				}
			}
			if (empty(self::$machine)) {
				if (!defined('MACHINE')) {
					exit('<strong>' . TYDI . '™</strong> • Machine Undefined!');
				} else {
					self::$machine = MACHINE;
				}
			}
			self::$initialized = true;
		}
		return true;
	}




	// ◇ ==== getProperty → get property » [mixed | false]
	public static function getProperty($property) {
		if (Vars::isArray($property)) {
			$o = [];
			foreach ($property as $value) {
				if (isset(self::$$value)) {
					$o[$value] = self::$$value;
				}
			}
			return $o;
		} elseif ($property === 'version') {
			if (isset(self::$config['project']['version'])) {
				return self::$config['project']['version'];
			}
		} elseif (StringX::contain($property, '.') && !StringX::begin($property, '.') && !StringX::end($property, '.')) {
			$project = self::$config['project'];
			$key = StringX::before($property, '.');
			$label = StringX::after($property, '.');
			if (isset($project[$key][$label])) {
				return $project[$key][$label];
			}
		} elseif (Vars::isString($property)) {
			if (isset(self::$$property)) {
				return self::$$property;
			} elseif (isset(self::$config[$property])) {
				return self::$config[$property];
			} elseif (isset(self::$config['project'][$property])) {
				return self::$config['project'][$property];
			}
		}
		return false;
	}




	// ◇ ==== getEnv →
	public static function getEnv() {
		self::init();
		return self::$env;
	}




	// ◇ ==== getEnv →
	public static function getEnvAbbr() {
		$env = self::getEnv();
		if (!empty(self::$env)) {
			$env = substr(strtoupper(self::$env), 0, 4);
			if ($env === 'DEVE') {
				$env = 'DEV';
			}
			return $env;
		}
		return false;
	}




	// ◇ ==== getMachine →
	public static function getMachine() {
		self::init();
		return self::$machine;
	}




	// ◇ ==== getTimezone → get timezone » [string, boolean]
	public static function getTimezone() {
		if (!empty(self::$config['timezone'])) {
			return self::$config['timezone'];
		}
		return false;
	}




	// ◇ ==== isMachine →
	public static function isMachine($machine) {
		if (strtolower($machine) === strtolower(self::getMachine())) {
			return true;
		}
		return false;
	}




	// ◇ ==== isLocal → is machine local? » [boolean]
	public static function isLocal() {
		if (strtoupper(self::getMachine()) === 'LOCAL') {
			return true;
		}
		return false;
	}




	// ◇ ==== isLive → is machine live? » [boolean]
	public static function isLive() {
		if (strtoupper(self::getMachine()) === 'LIVE') {
			return true;
		}
		return false;
	}




	// ◇ ==== isDevelopment → is environment development? » [boolean]
	public static function isDevelopment() {
		if (strtoupper(self::getEnv()) === 'DEVELOPMENT') {
			return true;
		}
		return false;
	}




	// ◇ ==== isStaging → check if environment is staging » [boolean]
	public static function isStaging() {
		if (strtoupper(self::getEnv()) === 'STAGING') {
			return true;
		}
		return false;
	}




	// ◇ ==== isProduction → check if environment is production » [boolean]
	public static function isProduction() {
		if (strtoupper(self::getEnv()) === 'PRODUCTION') {
			return true;
		}
		return false;
	}




	// ◇ ==== setProject →
	public static function setProject($project) {
		if (is_array($project) && !empty($project)) {
			if (!empty(self::$config['project'])) {
				$project = ArrayX::blend($project, self::$config['project']);
			}
			self::$config['project'] = $project;
			return true;
		}
		return false;
	}




	// ◇ ==== setRoute →
	public static function setRoute($routes) {
		if (is_array($routes) && !empty($routes)) {
			if (!empty(self::$config['routes'])) {
				$routes = ArrayX::blend($routes, self::$config['routes']);
			}
			self::$config['routes'] = $routes;
			return true;
		}
		return false;
	}




	// ◇ ==== setDatabase →
	public static function setDatabase($database) {
		if (is_array($database) && !empty($database)) {
			if (!empty(self::$config['database'])) {
				$database = ArrayX::blend($database, self::$config['database']);
			}
			self::$config['database'] = $database;
			return true;
		}
		return false;
	}




	// ◇ ==== setConfig → set configurations » [boolean]
	public static function setConfig($config = []) {
		if (Vars::noData(self::$config)) {
			self::$config = [];
		}

		if (is_array($config) && !empty($config)) {

			// • for project
			if (isset($config['project'])) {
				self::setProject($config['project']);
				unset($config['project']);
			}

			// • for database
			if (isset($config['database'])) {
				self::setDatabase($config['database']);
				unset($config['database']);
			}

			// • for routes
			if (isset($config['routes'])) {
				self::setRoute($config['routes']);
				unset($config['routes']);
			}

			self::$config = ArrayX::blend(self::$config, $config);
			return true;
		}
		return false;
	}




	// ◇ ==== setTimezone → set timezone
	public static function setTimezone($timezone = null) {
		if (empty($timezone) && !empty(self::getTimezone())) {
			$timezone = self::getTimezone();
		}

		if (!empty($timezone)) {
			if ($timezone === 'NG') {
				return date_default_timezone_set('Africa/Lagos');
			} else {
				$isValidTimezone = in_array($timezone, timezone_identifiers_list());
				if (!$isValidTimezone) {
					return OversightX(__CLASS__ . ' • ' . __FUNCTION__, 'Invalid Timezone', $timezone);
				}
			}
			return date_default_timezone_set($timezone);
		}
		return false;
	}




	// ◇ ==== errorMsg → error message output (based on environment) »
	public static function errorMsg($production, $development = null, $staging = null) {
		self::init();
		$error = $production;

		if (is_null($development)) {
			$development = $production;
		}

		if (is_null($staging)) {
			$staging = $production;
		}

		if (self::isDevelopment()) {
			$error = $development;
		} elseif (self::isStaging()) {
			$error = $staging;
		}
		return $error;
	}




	// ◇ ==== php → require minimum php version » boolean (true) | error
	public static function php($minimum = '8.0') {
		if (!empty($minimum)) {
			$minimum = floatval($minimum);
			$version = floatval(phpversion());
			if ($version < $minimum) {
				return OversightX('PHP Server', 'Version Unsupported - ' . $version);
			}
		}
		return true;
	}




	// ◇ ==== playground → load playground (development environment only)
	public static function playground($file = 'PLAYGROUND') {
		if ($file === 'PLAYGROUND') {
			$file = RD . '_source' . DS . 'playground' . DS . 'index.php';
		}
		if (is_file($file) && self::isDevelopment()) {
			return require $file;
		}
		return false;
	}

} //> end of Env
