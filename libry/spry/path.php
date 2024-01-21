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

			case 'ORGANIZR':
				$path = PATH['BACKEND']['ORGAN'];
				break;
		}

		if (!empty($path) && !is_null($source)) {
			return self::$ORIG . $path;
		}

		return RD;
	}





	// • ==== routzr → ... »
	public static function routzr($routzr = 'SITE') {
		$routzr = strtolower($routzr) . '.php';
		$file = self::$ORIG . PATH['BACKEND']['ROUT'] . $routzr;
		if (!is_file($file)) {
			$error = '<strong>' . FRAMEWORK . '™</strong> • Routzr Unavailable! → [<em>' . $file . '</em>]';
			exit($error);
		}
		return $file;
	}





	// • ==== layout → ... »
	public static function layout($layout = null) {
		$path = self::$ORIG . PATH['FRONTEND']['LAYOUT'];
		if (!empty($layout)) {
			$file = $path . strtolower($layout) . '.php';
			if (!is_file($file)) {
				$error = '<strong>' . FRAMEWORK . '™</strong> • Layout Unavailable! → [<em>' . $file . '</em>]';
				DebugX::exit($error);
			}
			return $file;
		}
		return $path;
	}





	// • ==== bit → ... »
	public static function bit($bit = null) {
		$path = self::$ORIG . PATH['FRONTEND']['LAYOUT'] . 'bit' . DS;
		if (!empty($bit)) {
			$file = $path . strtolower($bit) . '.php';
			if (!is_file($file)) {
				$error = '<strong>' . FRAMEWORK . '™</strong> • Bit Unavailable! → [<em>' . $file . '</em>]';
				DebugX::exit($error);
			}
			return $file;
		}
		return $path;
	}





	// • ==== view → ... »
	public static function view($view = null, $safely = false) {
		$path = self::$ORIG . PATH['FRONTEND']['VIEW'];
		if (!empty($view)) {
			$view = StringX::swap($view, '/', DS);
			$file = $path . strtolower($view) . '.php';
			if (!is_file($file) && $safely === false) {
				$error = '<strong>' . FRAMEWORK . '™</strong> • View Unavailable! → [<em>' . $file . '</em>]';
				DebugX::exit($error);
			}
			return $file;
		}
		return $path;
	}





	// • ==== slice → ... »
	public static function slice($slice = null) {
		$path = self::$ORIG . PATH['FRONTEND']['SLICE'];
		if (!empty($slice)) {
			$file = $path . strtolower($slice) . '.php';
			if (!is_file($file)) {
				$error = '<strong>' . FRAMEWORK . '™</strong> • Slice Unavailable! → [<em>' . $file . '</em>]';
				DebugX::exit($error);
			}
			return $file;
		}
		return $path;
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





	// • ==== debug → ... »
	public static function debug() {
		return RD . 'debug.php';
	}





	// • ==== load → ... »
	public static function load($source) {
		if ($source === 'DEBUG') {
			$file = self::debug();
			if (file_exists($file)) {
				require $file;
			}
		}
		return;
	}





	// • ==== check → check if path or file exist »
	public static function check($path) {
		// TODO: implement code
		return $path;
	}





	// • ==== css → ... »
	public static function css($file = null) {
		$path = PATH['ASSET']['CSS'];
		if (!is_null($file)) {
			$path .= $file . '.css';
		}
		return self::check($path);
	}





	// • ==== js → ... »
	public static function js($file = null) {
		$path = PATH['ASSET']['JS'];
		if (!is_null($file)) {
			$path .= $file . '.js';
		}
		return self::check($path);
	}





	// • ==== media → ... »
	public static function media($file = null) {
		$path = PATH['ASSET']['MEDIA'];
		if (!is_null($file)) {
			$path .= $file;
		}
		return self::check($path);
	}





	// • ==== favicon → ... »
	public static function favicon($file = null) {
		$path = PATH['ASSET']['MEDIA'] . 'favicon' . PS;
		if (!is_null($file)) {
			$path .= $file;
		}
		return self::check($path);
	}





	// • ==== icon → ... »
	public static function icon($file = null) {
		$path = PATH['ASSET']['MEDIA'] . 'icon' . PS;
		if (!is_null($file)) {
			$path .= $file;
		}
		return self::check($path);
	}





	// • ==== plugin → ... »
	public static function plugin($file = null) {
		$path = PATH['ASSET']['PLUGIN'];
		if (!is_null($file)) {
			$path .= $file;
		}
		return self::check($path);
	}


} //> end of PathX