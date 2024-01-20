<?php //*** oDataX » Tydi™ Framework © 2024 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

class oDataX {

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





	// • ==== create → make data ready for insert » array
	public static function create(array $input = null) {
		$input['puid'] = $input['puid'] ?? RandomX::puid(20);
		$input['suid'] = $input['suid'] ?? RandomX::suid(40);
		$input['tuid'] = $input['tuid'] ?? RandomX::tuid(70);
		$input['author'] = $input['author'] ?? 'ZERO';

		// TODO: make input safe for insert

		return $input;
	}


} //> end of oDataX