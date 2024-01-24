<?php //*** PathX » Tydi™ Framework © 2024 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

class PathX {

	// • property
	private static $init;
	private static $ORIG;





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





	// • ==== init → ... »
	public static function init(array $config = []) {
		if (isset($config['ORIG'])) {
			self::$ORIG = $config['ORIG'];
			self::$init = true;
		} elseif (self::$init !== true) {
			self::$ORIG = RD . 'orig' . DS;
			self::$init = true;
		}
		return;
	}




	// • ==== to → ... »
	public static function to($source = null) {
		$path = null;

		switch ($source) {

			case 'MODELIZR':
				$path = PATH['BACKEND']['MODEL'];
				break;

			case 'ORGANIZR':
				$path = PATH['BACKEND']['ORGAN'];
				break;

			case 'UTILIZR':
				$path = PATH['BACKEND']['UTIL'];
				break;
		}

		if (!empty($path) && !is_null($source)) {
			return self::$ORIG . $path;
		}

		return RD;
	}





	// • ==== debug → ... »
	private static function debug() {
		return RD . 'debug.php';
	}





	// • ==== is → check if path or file exist »
	public static function is($path, $tag = null) {
		// TODO: implement code
		return $path;
	}





	// • ==== css → ... »
	public static function css($file = null) {
		$path = PATH['ASSET']['CSS'];
		if (!is_null($file)) {
			$path .= $file . '.css';
		}
		return self::is($path, 'CSS');
	}





	// • ==== js → ... »
	public static function js($file = null) {
		$path = PATH['ASSET']['JS'];
		if (!is_null($file)) {
			$path .= $file . '.js';
		}
		return self::is($path, 'JS');
	}





	// • ==== media → ... »
	public static function media($file = null, $tag = 'MEDIA') {
		$path = PATH['ASSET']['MEDIA'];
		if (!is_null($file)) {
			$path .= $file;
		}
		return self::is($path, $tag);
	}





	// • ==== favicon → ... »
	public static function favicon($file = null) {
		$path = 'favicon' . PS;
		if (!is_null($file)) {
			$path .= $file;
		}
		return self::media($path, 'FAVICON');
	}





	// • ==== icon → ... »
	public static function icon($file = null) {
		$path = 'icon' . PS;
		if (!is_null($file)) {
			$path .= $file;
		}
		return self::media($path, 'ICON');
	}





	// • ==== plugin → ... »
	public static function plugin($file = null) {
		$path = PATH['ASSET']['PLUGIN'];
		if (!is_null($file)) {
			$path .= $file;
		}
		return self::is($path, 'PLUGIN');
	}





	// • ==== fontawesome → ... »
	public static function fontawesome($file = null) {
		$path = 'fontawesome' . PS;
		if (!is_null($file)) {
			$path .= $file;
		}
		return self::plugin($path);
	}





	// • ==== prepare → ... »
	public static function prepare($path, $file = null, $tag = 'resource', $flagError = false) {
		if (!empty($file)) {
			$file = $path . strtolower(StringX::swap($file, '/', DS));
			if (!StringX::endWith($file, '.php')) {
				$file .= '.php';
			}
			if ($flagError === true && !is_file($file)) {
				$e = '<strong>' . FRAMEWORK . '™</strong> • ' . ucwords($tag) . ' Unavailable! → [<em>' . $file . '</em>]';
				return DebugX::exit($e);
			}
			return $file;
		}
		return $path;
	}





	// • ==== slice → ... »
	public static function slice($file = null, $tag = 'slice', $flagError = false) {
		$path = self::$ORIG . PATH['FRONTEND']['SLICE'];
		return self::prepare($path, $file, $tag, $flagError);
	}





	// • ==== breadcrumb → ... »
	public static function breadcrumb($file = null, $flagError = false) {
		$path = self::$ORIG . PATH['FRONTEND']['SLICE'] . 'breadcrumb' . DS;
		return self::prepare($path, $file, 'breadcrumb', $flagError);
	}




	// • ==== form → ... »
	public static function form($file = null, $flagError = false) {
		$path = self::$ORIG . PATH['FRONTEND']['FORM'];
		return self::prepare($path, $file, 'form', $flagError);
	}





	// • ==== layout → ... »
	public static function layout($file = null, $flagError = false) {
		$path = self::$ORIG . PATH['FRONTEND']['LAYOUT'];
		return self::prepare($path, $file, 'layout', $flagError);
	}





	// • ==== bit → ... »
	public static function bit($file = null, $flagError = false) {
		$path = self::$ORIG . PATH['FRONTEND']['LAYOUT'] . 'bit' . DS;
		return self::prepare($path, $file, 'bit', $flagError);
	}





	// • ==== view → ... »
	public static function view($file = null, $flagError = false) {
		$path = self::$ORIG . PATH['FRONTEND']['VIEW'];
		return self::prepare($path, $file, 'view', $flagError);
	}




	// • ==== routzr → ... »
	public static function routzr($routzr = 'SITE') {
		$path = self::$ORIG . PATH['BACKEND']['ROUT'];
		return self::prepare($path, $routzr, 'Routzr', true);
	}





	// • ==== env → ... »
	public static function env($routzr) {
		$env = strtolower($routzr) . '.env';
		$file = self::$ORIG . $env;
		if (!is_file($file)) {
			$error = '<strong>' . FRAMEWORK . '™</strong> • Env Unavailable! → [<em>' . $file . '</em>]';
			exit($error);
		}
		return $file;
	}





	// • ==== load → ... »
	public static function load($source) {
		if ($source === 'DEBUG') {
			$file = self::debug();
		}
		if (!empty($file) && file_exists($file)) {
			return require $file;
		}
		return;
	}






} //> end of PathX