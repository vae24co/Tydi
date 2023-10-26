<?php //*** Tydi - Tydi Class » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//
class Tydi {

	// • ==== call → handler - undefined method » [error]
	public function __call($method, $argument) {
		$caller = __CLASS__ . '->' . $method . '()';
		return self::oversight(__CLASS__ . '™', 'method unreachable', $caller);
	}

	// • ==== callStatic → handler - undefined static method » [error]
	public static function __callStatic($method, $argument) {
		$class = ucfirst($method);
		if (!class_exists($class, false)) {
			$file = PATH['LIBRY'] . strtolower($method) . '.php';
			if (is_file($file)) {
				require_once $file;
			}
		}
		if (class_exists($class, false)) {
			return new $class;
		}
		$caller = __CLASS__ . '::' . $method . '()';
		return self::oversight(__CLASS__ . '™', 'static: method unreachable', $caller);
	}

	// • ==== debug → output variable »
	public static function debug($var, string $title = null) {
		$o = '<div style="border: 1px solid tan; padding: 5px 10px;">';
		if ($title !== '') {
			$o .= '<strong style="margin:0; line-height:1.6; color: brown;">' . $title . ':</strong> ';
		}
		if (is_string($var)) {
			$o .= ' <span style="color: purple;"><tt>' . $var . '</tt></span>';
		} else {
			$o .= ' <div style="color: purple;"><pre><tt>' . var_export($var, true) . '</tt></pre></div>';
		}
		$o .= '</div>';
		echo $o;
	}

	// • ==== oversight → ... »
	public static function oversight($label, $message, $extra = null, $exit = true) {
		if (strpos($label, TYDI) === false) {
			$label = TYDI . '™ • ' . $label;
		}
		$e = '<strong>' . ucwords($label) . '</strong> | ' . $message;
		if (!is_null($extra) && $extra != '') {
			if (is_array($extra)) {
				if (count(array_filter(array_keys($extra), 'is_numeric')) === count($extra)) {
					$extra = implode(' • ', $extra);
				} else {
					$append = '';
					foreach ($extra as $key => $val) {
						$append .= $key . ': ' . $val . ' • ';
					}
					$extra = trim($append, ' • ');
				}
			}
			if (is_string($extra)) {
				$e .= ' → <em>[' . $extra . ']</em>';
			}
		}
		if ($exit === true) {
			exit($e);
		}
		return self::debug($e);
	}

} //> end of Tydi