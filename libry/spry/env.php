<?php //*** EnvX » Tydi™ Framework © 2024 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

class EnvX {

	// • property
	protected static $constants = [];





	// • ==== call → handler - undefined method » error
	public function __call($method, $argument) {
		$caller = __CLASS__ . '→' . $method . '()';
		return DebugX::oversight(__CLASS__, 'method unreachable', $caller);
	}





	// • ==== callStatic → handler - undefined static method » error
	public static function __callStatic($method, $argument) {
		$caller = __CLASS__ . '::' . $method . '()';
		return DebugX::oversight(__CLASS__, 'static: method unreachable', $caller);
	}





	// • ==== load → ... »
	public static function load($file) {
		if (is_file($file)) {
			$content = file_get_contents($file);
			$lines = array_filter(explode("\n", $content));
			foreach ($lines as $line) {
				if (strlen($line) > 1 && !StringX::beginWithAny($line, ['#', '//'])) {
					$entry = explode('=', $line);
					list($label, $value) = $entry;
					$label = StringX::cropBegin($label, 'oTYDI_');
					$label = strtoupper(trim($label));
					$value = trim($value);
					if (StringX::beginWith($value, '"') && StringX::endWith($value, '"')) {
						$value = StringX::crop($value, '"');
					} elseif (StringX::beginWith($value, "'") && StringX::endWith($value, "'")) {
						$value = StringX::crop($value, "'");
					}
					if (!array_key_exists($label, self::$constants)) {
						self::$constants[$label] = $value;
					}
				}
			}
		}
		return;
	}





	// • ==== version → get code version
	public static function version($flag = null) {

		// » get version
		if (!empty(self::$constants['VERSION'])) {
			$version = self::$constants['VERSION'];
			if ($flag === 'NAME') {
				$version = StringX::beforeAs($version, '-');
			}
			return $version;
		}
		return;







		// » set version
		// if (!empty($version)) {
		// 	self::$version = $version;
		// 	return true;
		// }

		// // » set default version
		// if (empty(self::$version)) {
		// 	self::$version = 'oreo';
		// }


	}





	// • ==== database → ... »
	public static function database() {
		$config = [];
		foreach (self::$constants as $key => $value) {
			if (StringX::beginWith($key, 'DATABASE')) {
				$key = strtolower(StringX::cropBegin($key, 'DATABASE_'));
				$config[$key] = $value;
			}
		}
		return ArrayX::toObj($config);
	}





	// • ==== init → ... »
	public static function init() {

		// » use database
		$dba = self::database();
		if (!empty($dba) && is_object($dba)) {
			DatabaseX::connect($dba->name, $dba->username, $dba->password);
		}
	}




} //> end of EnvX