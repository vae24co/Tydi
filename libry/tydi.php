<?php //*** Tydi - Description » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//
class Tydi {

	// • ==== call → handler - undefined method » [error]
	public function __call($method, $argument) {
		return Tydi::oversight(__CLASS__, 'method unreachable', $method);
	}




	// • ==== callStatic → handler - undefined static method » [error]
	public static function __callStatic($method, $argument) {
		$caller = __CLASS__ . '::' . $method . '()';
		return Tydi::oversight(__CLASS__, 'static: method unreachable', $method);
	}




	// • ==== inc → include files »
	public static function inc(string|array $file, string $path = null) {
		if (is_string($file)) {
			$files = [$file];
		} else if (is_array($file)) {
			$files = $file;
		}
		$path = $path ?? '';
		foreach ($files as $file) {
			$file = $path . $file . '.php';
			if (!is_file($file)) {
				$error = '<strong>' . FRAMEWORK . '™</strong> • File Unavailable! → [<em>' . $file . '</em>]';
				exit($error);
			}
			return include $file;
		}
		return false;
	}

} //> end of Tydi