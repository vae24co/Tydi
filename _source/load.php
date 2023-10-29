<?php //*** Load - Load Class » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//
class Load {

	// • ==== call → handler - undefined method » [error]
	public function __call($method, $argument) {
		return Tydi::oversight(__CLASS__, 'method unreachable', $method);
	}




	// • ==== callStatic → handler - undefined static method » [error]
	public static function __callStatic($method, $argument) {
		$caller = __CLASS__ . '::' . $method . '()';
		return Tydi::oversight(__CLASS__, 'static: method unreachable', $method);
	}




	// • ==== file → ... »
	public static function file($file, $grabVars = false) {
		if (is_file($file)) {
			require_once $file;
			unset($file);

			if ($grabVars) {
				$vars = get_defined_vars();
				if (!empty($vars)) {
					foreach ($vars as $key => $value) {
						global $$key;
						$$key = $value;
					}
				}
			}
		}
	}





	// • ==== directory → ... »
	public static function directory($directory, $extension = null, $grabVars = false) {
		$files = Folder::files($directory, $extension);
		if ($files !== false) {
			if (!$grabVars) {
				foreach ($files as $file) {
					require_once $file;
				}
			} else {
				foreach ($files as $file) {
					require_once $file;
					unset($file);
					$vars = get_defined_vars();
					if (!empty($vars)) {
						foreach ($vars as $key => $value) {
							global $$key;
							$$key = $value;
						}
					}
				}
			}
		}
	}

} //> end of Load