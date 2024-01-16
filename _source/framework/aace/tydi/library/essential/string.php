<?php
/* StringX ~ String Class » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © 2023 | Apache License */

class StringX {

	// ◇ ----- CALL • Non-Existent Method » Error
	public function __call($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- CALL_STATIC • Non-Existent Static Method » Error
	public static function __callStatic($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}




	// ◇ ----- IS • Check if String » Boolean
	public static function is(&$var) {
		return is_string($var);
	}





	// ◇ ----- IS NOT • Check if String » Boolean
	public static function isNot(&$var) {
		if (!is_string($var)) {
			return true;
		}
		return false;
	}





	// ◇ ----- IS EMPTY • $var an Empty String? » Boolean
	public static function isEmpty(&$var) {
		return VarX::isEmpty($var, 'string');
	}





	// ◇ ----- IS NOT EMPTY • $var a Not-Empty String? » Boolean
	public static function isNotEmpty(&$var) {
		return VarX::isNotEmpty($var, 'string');
	}





	// ◇ ----- IN • Check in String » Boolean
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





	// ◇ ----- CONTAIN • Check in String (case insensitive) » Boolean
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





	// ◇ ----- COMPARE • Compare String » Boolean
	public static function compare($string, $needle, $strict = true) {
		if (self::is($string) && self::is($needle)) {
			if (strtolower($string) == strtolower($needle) && !$strict) {
				return true;
			} elseif ($string === $needle && $strict) {
				return true;
			}
		}
		return false;
	}





	// ◇ ----- NTH • Nth Character » Character
	public static function nth($string, $nth) {
		if (self::isNotEmpty($string) && is_numeric($nth)) {
			$length = strlen($string);
			if ($nth <= $length) {
				$nth = (int) $nth - 1;
				return $string[$nth];
			}
		}
		return false;
	}





	// ◇ ----- FIRST • First Character (Nth) » Character(s)
	public static function first($string, $nth = 1) {
		if (self::isNotEmpty($string) && is_numeric($nth)) {
			$length = strlen($string);
			if ($nth <= $length) {
				return substr($string, 0, $nth);
			}
		}
		return false;
	}





	// ◇ ----- LAST • Last Character (Nth) » Character(s)
	public static function last($string, $nth = 1) {
		if (self::isNotEmpty($string) && is_numeric($nth)) {
			$length = strlen($string);
			if ($nth <= $length) {
				return substr($string, -$nth);
			}
		}
		return false;
	}





	// ◇ ----- BEGIN • Check String Beginning » Boolean
	public static function begin($string, $begin) {
		if (self::isNotEmpty($string) && self::isNotEmpty($begin)) {
			$string = trim($string);
			if (function_exists('str_starts_with')) {
				return str_starts_with($string, $begin);
			} else {
				return strpos($string, $begin) === 0;
			}
		}
		return false;
	}





	// ◇ ----- END • Check String Ending » Boolean
	public static function end($string, $end) {
		if (self::isNotEmpty($string) && self::isNotEmpty($end)) {
			$string = trim($string);
			if (function_exists('str_ends_with')) {
				return str_ends_with($string, $end);
			} else {
				$length = strlen($end);
				return $length > 0 ? substr($string, -$length) === $end : true;
			}
		}
		return false;
	}





	// ◇ ----- PATTERN • Match Pattern » Boolean | String | Array
	public static function pattern($string, $pattern, $return = 'IS', $flags = 0, $offset = 0) {
		if (self::isNotEmpty($string)) {
			// ~ PREDEFINED PATTERN
			if ($pattern === 'UPPERCASE') {
				$pattern = "/^[A-Z]+$/";
			} elseif ($pattern === 'LOWERCASE') {
				$pattern = "/^[a-z]+$/";
			} elseif ($pattern === 'ALPHA') {
				$pattern = "/^[A-Z]+$/i";
			} elseif ($pattern === 'NUMERIC') {
				$pattern = "/^[0-9]+$/";
			} elseif ($pattern === 'ALPHANUMERIC') {
				$pattern = "/^[A-Z0-9]+$/i";
			}


			// ~ Clean up pattern
			if (!StringX::begin($pattern, '/')) {
				$pattern = '/' . $pattern;
			}
			if (!StringX::end($pattern, '/')) {
				$pattern = $pattern . '/';
			}


			if ($return === 'MATCHES' || $return === 'COUNT') {
				$preg = preg_match_all($pattern, $string, $match, $flags, $offset);
			} else {
				$preg = preg_match($pattern, $string, $match, $flags, $offset);
			}
			if ($preg !== false) {
				if ($return === 'IS' && $preg > 0) {
					return true;
				} elseif ($return === 'MATCH' && $preg > 0 && is_array($match)) {
					return $match[0];
				} elseif ($return === 'MATCHES' && $preg > 0 && is_array($match)) {
					return $match;
				} elseif ($return === 'COUNT' && $preg > 0) {
					return $preg;
				}
			}
		}
		return false;
	}





	// ◇ ----- OCCURRENCE • Count Occurrence » Boolean | Number
	public static function occurrence($string, $needle, $offset = 0, $length = null) {
		if (self::isNotEmpty($string)) {
			$stringLength = strlen($string);
			if ($length > $stringLength) {
				$length = $stringLength;
			}
			return substr_count($string, $needle, $offset, $length);
		}
		return false;
	}





	public static function occurrenceNth($string, $separator, $nth, $req = 'NTH') {
		$occurrence = [];
		$parts = explode($separator, $string);
		for ($i = 0; $i < count($parts); $i = $i + $nth) {
			$occurrence[] = implode($separator, array_slice($parts, $i, $i + $nth));
		}
		if (strtoupper($req) === 'NTH') {
			return $occurrence[$nth - 1];
		}
		return $occurrence;
	}





	// ◇ ----- SWAP • Replace Occurrence »
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





	// ◇ ----- SWAP_FIRST • Replace First Occurrence »
	public static function swapFirst($string, $needle, $substitute = '', $strictCase = false) {
		return self::swap($string, $needle, $substitute, 'FIRST', $strictCase);
	}





	// ◇ ----- SWAP_LAST • Replace Last Occurrence »
	public static function swapLast($string, $needle, $substitute = '', $strictCase = false) {
		return self::swap($string, $needle, $substitute, 'LAST', $strictCase);
	}





	// ◇ ----- SWAP_SPACE • Replace Space Character & Vice-Versa
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





	// ◇ ----- NO_SPACE • Remove Spaces
	public static function noSpace($string) {
		return self::swap($string, ' ', '');
	}





	// ◇ ----- NO_CHAR • Remove Special Characters
	public static function noChar($string, $append = '') {
		if (self::isNotEmpty($string)) {
			$pattern = "A-Za-z0-9\-";
			if (VarX::isNotEmpty($append)) {
				if (ArrayX::isNotEmpty($append)) {
					foreach ($append as $char) {
						$pattern .= $char;
					}
				} elseif (self::isNotEmpty($append)) {
					$pattern .= $append;
				}
			}
			return preg_replace('/[^' . $pattern . ']/', '', $string);
		}
		return false;
	}





	// ◇ ----- BEFORE • String Before Character
	public static function before($string, $needle, $strip = true, $strictCase = false) {
		if (self::isNotEmpty($string) && self::in($string, $needle, $strictCase)) {
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





	// ◇ ----- AFTER • String After Character
	public static function after($string, $needle, $strip = true, $strictCase = false, $occurrence = 'FIRST') {
		if (self::isNotEmpty($string) && self::in($string, $needle, $strictCase)) {
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





	// ◇ ----- STRIP • Remove from Occurrence from String
	public static function strip($string, $needle, $strictCase = false) {
		return self::swap($string, $needle, '', 'ALL', $strictCase);
	}





	// ◇ ----- STRIP_FIRST • Remove from First Occurrence from String
	public static function stripFirst($string, $needle, $strictCase = false) {
		return self::swapFirst($string, $needle, '', $strictCase);
	}





	// ◇ ----- STRIP_LAST • Remove from Last Occurrence from String
	public static function stripLast($string, $needle, $strictCase = false) {
		return self::swapLast($string, $needle, '', $strictCase);
	}





	// ◇ ----- CROP • Trim Edges Or Character(s)
	public static function crop($string, $needle = 'SPACE', $strictCase = false) {
		if (self::isNotEmpty($string) && self::isNotEmpty($needle)) {
			if ($needle === 'SPACE') {
				return trim($string);
			} elseif (self::in($string, $needle, $strictCase)) {
				return trim($string, $needle);
			}
			return $string;
		}
		return false;
	}





	// ◇ ----- CROP_BEGIN • Remove from Beginning of String
	public static function cropBegin($string, $needle, $strictCase = false) {
		if (self::begin($string, $needle)) {
			return self::stripFirst($string, $needle, $strictCase);
		}
		return $string;
	}





	// ◇ ----- CROP_END • Remove from End of String
	public static function cropEnd($string, $needle, $strictCase = false) {
		if (self::end($string, $needle)) {
			return self::stripLast($string, $needle, $strictCase);
		}
		return $string;
	}






	// ◇ ----- BLUR • Blur Censored Character & Vice-Versa
	public static function blur($string, $library, $blur = '***', $strictCase = false) {
		if (self::isNotEmpty($string) && VarX::isNotEmpty($library)) {
			$words = explode(" ", $string);
			if (!is_array($library)) {
				if (self::contain($library, '|')) {
					$library = self::swap($library, ' | ', '|');
					$library = explode('|', $library);
				} elseif (self::contain($library, '-')) {
					$library = self::swap($library, ' - ', '-');
					$library = explode('-', $library);
				} elseif (self::contain($library, ',')) {
					$library = self::swap($library, ' , ', ',');
					$library = explode(',', $library);
				} else {
					$library = explode(' ', $library);
				}
			}
			foreach ($words as $word) {
				if (in_array(strtolower($word), array_map('strtolower', $library))) {
					$string = self::swap($string, $word, $blur, 'ALL', $strictCase);
				}
			}
			return $string;
		}
		return false;
	}





	// ◇ ----- TO_ARRAY • String to Array »
	public static function toArray($string, $req = 'SPACE', $keys = []) {
		if (self::isNotEmpty($string)) {
			if ($req === 'SPACE') {
				$res = explode(' ', $string);
			} else {
				$res = explode($req, $string);
			}
			if (ArrayX::isNotEmpty($keys)) {
				$res = ArrayX::reKeys($res, $keys);
			}
			if (ArrayX::is($res)) {
				return $res;
			}
		}
		return false;
	}





	// ◇ ----- TO_JSON • String to JSON »
	public static function toJSON($string, $flag = 'SPACE', $keys = []) {
		return ArrayX::toJSON(self::toArray($string, $flag, $keys));
	}





	// ◇ ----- TO_OBJ • String to Object »
	public static function toObj($string, $flag = 'SPACE', $keys = []) {
		return ArrayX::toObj(self::toArray($string, $flag, $keys));
	}





	// ◇ ----- UPPERCASE COUNT •
	public static function uppercaseCount($string) {
		$pattern = '/[A-Z]/';
		return preg_match_all($pattern, $string);
	}





	// ◇ ----- UPPERCASE TO SPACE •
	public static function uppercaseToSpace($string) {
		return preg_replace('/([a-z])([A-Z])/', '$1 $2', $string);
	}

} // End Of Class ~ StringX