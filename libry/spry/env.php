<?php //*** EnvX » Tydi™ Framework © 2024 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

class EnvX {

	// • property
	protected static $constants;





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
				list($key, $value) = explode('=', $line, 2);
				$label = trim(strtoupper($key));
				$label = trim($label, 'oTYDI_');
				$input = trim($value);
				if (!array_key_exists($label, self::$constants)) {
					self::$constants[$label] = $input;
				}
			}
		}
		return;
	}

} //> end of EnvX