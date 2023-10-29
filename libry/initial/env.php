<?php //*** Env - Environment » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//
class Env {

	// • ==== call → handler - undefined method » [error]
	public function __call($method, $argument) {
		return Tydi::oversightX(__CLASS__, 'method unreachable', $method);
	}




	// • ==== callStatic → handler - undefined static method » [error]
	public static function __callStatic($method, $argument) {
		$caller = __CLASS__ . '::' . $method . '()';
		return Tydi::oversightX(__CLASS__, 'static: method unreachable', $method);
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