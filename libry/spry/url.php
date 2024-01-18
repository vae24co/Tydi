<?php //*** UrlX » Tydi™ Framework © 2024 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

class UrlX {

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




	// • ==== withParam → ... »
	public static function withParam() {
		return HttpX::urlWithParam();
	}





	// • ==== withoutParam → ... »
	public static function withoutParam() {
		return HttpX::urlWithoutParam();
	}

} //> end of UrlX