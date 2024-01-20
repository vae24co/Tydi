<?php //*** oTimeX » Tydi™ Framework © 2024 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

class oTimeX {

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

} //> end of oTimeX