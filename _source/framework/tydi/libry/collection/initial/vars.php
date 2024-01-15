<?php
//*** Vars - Variables » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//
class Vars {

	// ◇ ==== call → handler - undefined method » [error]
	public function __call($method, $argument) {
		return OversightX(__CLASS__, 'method unreachable', $method);
	}




	// ◇ ==== callStatic → handler - undefined static method » [error]
	public static function __callStatic($method, $argument) {
		return OversightX(__CLASS__, 'static method unreachable', $method);
	}

} //> end of Vars