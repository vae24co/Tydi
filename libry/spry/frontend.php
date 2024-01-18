<?php //*** FrontendX » Tydi™ Framework © 2024 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

class FrontendX {

	// • property
	protected static $content = [];
	protected static $record = false;





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





	// • ==== content → ... »
	public static function content(array $content = null) {
		if (!empty($content)) {
			self::$content = array_merge(self::$content, $content);
		}
		return self::$content;
	}





	// • ==== record → ... »
	public static function record($record = null) {
		if (!is_null($record)) {
			self::$record = $record;
		}
		return;
	}





	// • ==== layout → ... »
	public static function layout($layout, $content = null) {
		$record = self::$record;
		$content = self::content($content);
		$layout = PathX::layout($layout);
		return require $layout;
	}





	// • ==== view → ... »
	public static function view($view, $content = null) {
		$record = self::$record;
		$content = self::content($content);
		$view = PathX::view($view);
		return require $view;
	}





	// • ==== slice → ... »
	public static function slice($slice, $content = null) {
		$record = self::$record;
		$content = self::content($content);
		$slice = PathX::slice($slice);
		return require $slice;
	}


} //> end of FrontendX