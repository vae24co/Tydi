<?php //*** TimeX » Tydi™ Framework © 2024 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

class TimeX {

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





	// • ==== human → human readable » string
	public static function human($datetime) {
		$time = date('F j, Y g:i A', strtotime($datetime));
		return $time;
	}





	// • ==== sqlDate → mysql date type » string
	public static function sqlDate($time = null) {
		$format = 'Y-m-d';
		if (is_null($time)) {
			return date($format);
		}

	}


} //> end of TimeX