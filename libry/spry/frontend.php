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





	// • ==== loader → ... »
	private static function loader($file, $content = []) {
		$record = self::$record;
		$content = self::content($content);
		if (!is_file($file)) {
			return self::fallback();
		}
		return require $file;
	}





	// • ==== layout → ... »
	public static function layout($layout, $content = []) {
		$layout = PathX::layout($layout);
		return self::loader($layout, $content);
	}





	// • ==== view → ... »
	public static function view($view = null, $content = []) {
		if (is_null($view)) {
			$view = RouteX::isGet();
		}
		$view = PathX::view($view, true);
		return self::loader($view, $content);
	}





	// • ==== slice → ... »
	public static function slice($slice, $content = []) {
		$slice = PathX::slice($slice);
		return self::loader($slice, $content);
	}





	// • ==== fallback → ... »
	public static function fallback() {
		echo '<p><strong>Not Found</strong><br>Sorry, the requested content is unavailable at the moment.<br><br>Please <u><a href="' . RouteX::to('index') . '">return here!</a></u></p>';
		return;
	}

} //> end of FrontendX