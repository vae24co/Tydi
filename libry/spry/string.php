<?php //*** StringX » Tydi™ Framework © 2024 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

class StringX {

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





	// • ==== is → is string » [boolean]
	public static function is($var) {
		return is_string($var);
	}





	// • ==== isNot → is not string » [boolean]
	public static function isNot($var) {
		if (!is_string($var)) {
			return true;
		}
		return false;
	}





	// • ==== isEmpty → $var is string & empty » [boolean]
	public static function isEmpty($var) {
		if (self::is($var) && strlen($var) < 1) {
			return true;
		}
		return false;
	}





	// • ==== isNotEmpty → $var is string & not empty » [boolean]
	public static function isNotEmpty($var) {
		if (self::is($var) && strlen($var) > 1) {
			return true;
		}
		return false;
	}





	// • ==== in • check in string » Boolean
	public static function in($string, $needle, $strictCase = true) {
		if (self::isEmpty($string)) {
			return false;
		}

		if ($strictCase) {
			if ($needle === $string) {
				return true;
			} elseif (strpos($string, $needle) !== false) {
				return true;
			}
		} else {
			if ($needle == $string) {
				return true;
			} elseif (stripos($string, $needle) !== false) {
				return true;
			}
		}

		return false;
	}





	// • ==== CONTAIN • check in String (case insensitive) » Boolean
	public static function contain($string, $needle) {
		if (self::isEmpty($string)) {
			return false;
		}

		if ($needle === 'SPACE' && strpos($string, ' ') !== false) {
			return true;
		}

		if (self::in($string, $needle, false)) {
			return true;
		}

		return false;
	}





	// • ==== swap • Replace Occurrence »
	public static function swap($string, $needle, $substitute, $occurrence = 'ALL', $strictCase = false) {
		if (self::in($string, $needle, $strictCase)) {
			if ($occurrence === 'ALL') {
				if ($strictCase) {
					$string = str_replace($needle, $substitute, $string);
				} else {
					$string = str_ireplace($needle, $substitute, $string);
				}
			} else {
				if ($occurrence === 'FIRST') {
					if ($strictCase) {
						$pos = strpos($string, $needle);
					} else {
						$pos = stripos($string, $needle);
					}
				}
				if ($occurrence === 'LAST') {
					if ($strictCase) {
						$pos = strrpos($string, $needle);
					} else {
						$pos = strripos($string, $needle);
					}
				}
				if ($pos !== false) {
					return substr_replace($string, $substitute, $pos, strlen($needle));
				}
			}
		}
		return $string;
	}





	// • ==== swapFirst • replace first occurrence »
	public static function swapFirst($string, $needle, $substitute = '', $strictCase = false) {
		return self::swap($string, $needle, $substitute, 'FIRST', $strictCase);
	}





	// • ==== swapLast • replace last occurrence »
	public static function swapLast($string, $needle, $substitute = '', $strictCase = false) {
		return self::swap($string, $needle, $substitute, 'LAST', $strictCase);
	}





	// • ==== swapSpace • replace space character & vice-versa »
	public static function swapSpace($string, $needle, $inverse = false) {
		if (self::isNotEmpty($string) && self::is($needle)) {
			if (!$inverse && self::contain($string, 'SPACE')) {
				return self::swap($string, ' ', $needle);
			} elseif ($inverse && self::contain($string, $needle)) {
				return self::swap($string, $needle, ' ');
			}
			return $string;
		}
		return false;
	}





	// • ==== before • string before character »
	public static function before($string, $needle, $strip = true, $strictCase = false) {
		if (self::in($string, $needle, $strictCase)) {
			if (!$strictCase) {
				$pos = stripos($string, $needle);
			} else {
				$pos = strpos($string, $needle);
			}
			if ($pos && $pos != 0) {
				$res = substr($string, 0, $pos);
			}
			if (!$strip) {
				$res = $res . $needle;
			}
			if (isset($res)) {
				return $res;
			}
		}
		return false;
	}





	// • ==== after • string after character »
	public static function after($string, $needle, $strip = true, $strictCase = false, $occurrence = 'FIRST') {
		if (self::in($string, $needle, $strictCase)) {
			if ($strictCase) {
				$string = strstr($string, $needle);
			} else {
				$string = stristr($string, $needle);
			}
			if ($string !== false) {
				if ($strip) {
					$string = self::swap($string, $needle, '', $occurrence, $strictCase);
				}
				return $string;
			}
		}
		return false;
	}


} //> end of StringX