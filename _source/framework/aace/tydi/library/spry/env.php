<?php
/*** Env ~ Environment Class » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © October 2023 | Apache License ***/

class Env {

	// ◇ PROPERTY
	protected static $config;
	public static $machine;





	// ◇ ----- CALL STATIC • Non-Existent Static Method » Error
	public static function __callStatic($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- INITIALIZE • ... » Boolean (true)
	private static function initialize() {
		if (empty(self::$machine)) {
			if (!defined('ENV')) {
				exit('<strong>' . FRAMEWORK . '™</strong> • Environment Undefined!');
			} else {
				self::$machine = ENV;
			}
		}
		return true;
	}





	// ◇ ----- PROPERTY • Get Class Property » Boolean | Mixed
	public static function property($req) {
		if (VarX::isEmpty($req)) {
			return false;
		} elseif (StringX::is($req)) {
			if ($req === 'PROPERTIES') {
				return Tydi::reflectClass(__CLASS__, 'PROPERTY');
			} elseif (isset(self::$$req)) {
				return self::$$req;
			}

		} elseif (ArrayX::is($req)) {
			$res = [];
			foreach ($req as $property) {
				if (isset(self::$$property)) {
					$res[$property] = self::$$property;
				}
			}
			return $res;
		}
		return false;
	}





	// ◇ ----- IS • ... » Boolean
	public static function is($var = 'DATA') {

		// * Initialize
		self::initialize();

		// + DATA
		if (strtoupper($var) === 'DATA') {
			return self::$machine;
		}

		// + Abbreviation
		elseif (strtoupper($var) === 'ABBR') {
			$env = substr(strtoupper(self::$machine), 0, 4);
			if ($env === 'DEVE') {
				$env = 'DEV';
			}
			return $env;
		}

		// + Check $var against the current environment
		else {
			if (($var === 'PROD' || $var === 'production') && self::$machine === 'production') {
				return true;
			} elseif (($var === 'STAG' || $var === 'STAGE' || $var === 'staging') && self::$machine === 'staging') {
				return true;
			} elseif (($var === 'DEV' || $var === 'development') && self::$machine === 'development') {
				return true;
			}
		}

		return false;
	}





	// ◇ ----- ERROR • Error Displaying (Based on Environment) »
	public static function errorReport($production, $development = null, $staging = null) {
		self::initialize();
		$error = $production;

		if (VarX::isNull($development)) {
			$development = $production;
		}

		if (VarX::isNull($staging)) {
			$staging = $production;
		}

		if (self::is('DEV')) {
			$error = $development;
		} elseif (self::is('STAGE')) {
			if ($staging === '...') {
				$staging = Folder::base($development) . PS . File::base($development, true);
			}
			$error = $staging;
		}
		return $error;
	}





	// ◇ ----- ESSENTIAL • Load Essential » Boolean (true)
	public static function essential() {
		$essential = ['tydi', 'error', 'folder', 'file', 'http', 'session', 'link', 'object', 'array', 'url', 'ssl', 'server', 'string', 'route', 'html', 'redirect', 'time', 'site', 'app', 'api', 'json', 'sql', 'random', 'crypt', 'header'];
		foreach ($essential as $file) {
			$filename = LIBRARY['essential'] . $file . '.php';
			if (is_file($filename)) {
				include $filename;
			} else {
				$report = self::errorReport($file, $filename);
				if (!isset($error)) {
					$error = $report;
				} else {
					$error .= ', ' . $report;
				}
			}
		}

		if (!empty($error)) {
			exit('<strong>' . FRAMEWORK . '™</strong> • Essential Unavailable → <em>(' . $error . ')</em>');
		}

		return true;
	}





	// ◇ ----- EXTENDABLE • Load Abstract & Interface » Boolean (true)
	public static function extendable($req) {

		// + Abstract
		if ($req === strtolower('abstract')) {
			$abstract = Folder::files(LIBRARY['abstract']);
			if ($abstract !== false) {
				foreach ($abstract as $file) {
					require $file;
				}
			} elseif (Folder::is(LIBRARY['abstract']) === false) {
				exit('<strong>' . FRAMEWORK . '™</strong> • Abstract Unavailable!');
			}
		}

		// + Interface
		if ($req === strtolower('interface')) {
			$interface = Folder::files(LIBRARY['interface']);
			if ($interface !== false) {
				foreach ($interface as $file) {
					require $file;
				}
			} elseif (Folder::is(LIBRARY['interface']) === false) {
				exit('<strong>' . FRAMEWORK . '™</strong> • Interface Unavailable!');
			}
		}

		// + Trait
		if ($req === strtolower('trait')) {
			$trait = Folder::files(LIBRARY['trait']);
			if ($trait !== false) {
				foreach ($trait as $file) {
					require $file;
				}
			} elseif (Folder::is(LIBRARY['trait']) === false) {
				exit('<strong>' . FRAMEWORK . '™</strong> • Trait Unavailable!');
			}
		}

		return true;
	}





	// ◇ ----- AUTOLOAD • Autoload Classes »
	public static function autoload() {
		if (!function_exists('oAutoloadX')) {
			exit('<strong>' . FRAMEWORK . '™</strong> • Autoload Unavailable!');
		}
		return spl_autoload_register('oAutoloadX');
	}





	// ◇ ----- PHP • Require Minimum PHP Version » Boolean (true) | Error
	public static function php($minimum = '') {
		if (VarX::isNotEmpty($minimum)) {
			$minimum = floatval($minimum);
			$version = floatval(phpversion());
			if ($version < $minimum) {
				return ErrorX::is('PHP Server', 'Version Unsupported', $version);
			}
		}
		return true;
	}





	// ◇ ----- SECURE • Redirect to Secured URL » Boolean (true)
	public static function secure() {
		if (!URL::is('SECURE') && strtolower(Route::property('platform')) !== 'api') {
			$secureURL = URL::to('SELF', 'SECURE');
			HTML::redirecting($secureURL);
		}
		return true;
	}





	// ◇ ----- TIMEZONE • Set Timezone »
	public static function timezone($timezone = '') {
		if (VarX::isEmpty($timezone)) {
			if (!empty(self::$config['timezone'])) {
				$timezone = self::$config['timezone'];
			}
		}
		return Time::zone($timezone);
	}





	// ◇ ----- CONFIG • Set Configurations » Boolean
	public static function config($config = []) {
		if (VarX::isEmpty(self::$config)) {
			self::$config = [];
		}

		if (ArrayX::isNotEmpty($config)) {

			// » For Routes
			if (ArrayX::isKey($config, 'routes') && ArrayX::is($config['routes'])) {

				//...route is empty
				if (VarX::isEmpty(self::$config['routes'])) {
					self::$config['routes'] = $config['routes'];
				}

				//...route not empty
				else {
					self::$config['routes'] = Tydi::blend($config['routes'], self::$config['routes']);
				}
				unset($config['routes']);
			}

			// » For Database
			if (ArrayX::isKey($config, 'database') && ArrayX::is($config['database'])) {

				//...database is empty
				if (VarX::isEmpty(self::$config['database'])) {
					self::$config['database'] = $config['database'];
				}

				//...route not empty
				else {
					self::$config['database'] = Tydi::blend($config['database'], self::$config['database']);
				}
				unset($config['database']);
			}

			self::$config = array_merge(self::$config, $config);
			return true;
		}
		return false;
	}





	// ◇ ----- PLAYBOX • Load Playground (development environment only) »
	public static function playbox($path = '_ao' . DS . 'playbox' . DS, $file = 'index.php') {
		$playbox = RD . $path . $file;
		if (is_file($playbox) && self::is('DEV')) {
			return require $playbox;
		}
		return false;
	}

} // End Of Class ~ Env