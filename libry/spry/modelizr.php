<?php //*** ModelizrX » Tydi™ Framework © 2024 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

class ModelizrX extends DatabaseX {

	// • protected
	protected static $table;





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




	// • ==== setTable → ... »
	public static function setTable($table){
		self::$table = $table;
	}





	// • ==== create → ... »
	public static function create($data, $table = null) {
		return parent::create($data, self::$table);
	}


} //> end of ModelizrX