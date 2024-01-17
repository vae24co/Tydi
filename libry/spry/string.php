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





	// • ==== is → is string » boolean
	public static function is($var, $strict = false) {
		if ($strict === true) {
			return is_string($var);
		} elseif (is_string($var)) {
			return true;
		} elseif (!is_null($var)) {
			$types = ['string', 'integer', 'double', 'numeric'];
			$type = gettype($var);
			if (in_array($type, $types)) {
				return true;
			}
		}
		return false;
	}





	// • ==== isNot → is not string » boolean
	public static function isNot($var) {
		// TODO: Test and re-code as above
		if (!is_string($var)) {
			return true;
		}
		return false;
	}





	// • ==== isEmpty → $var is string & empty » boolean
	public static function isEmpty($var) {
		if (self::is($var) && strlen($var) < 1) {
			return true;
		}
		return false;
	}





	// • ==== isNotEmpty → $var is string & not empty » boolean
	public static function isNotEmpty($var) {
		if (self::is($var) && strlen($var) > 0) {
			return true;
		}
		return false;
	}





	// • ==== isEncoded → $var is string & encoded » boolean
	public static function isEncoded($string) {
		// TODO: Improve code for number with +
		if (self::is($string)) {
			$decoded = urldecode($string);
			if ($decoded !== $string) {
				return true;
			}
		}
		return false;
	}





	// • ==== in • check in string » boolean
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





	// • ==== COMPARE • compare string » boolean
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





	// • ==== nth • Nth Character » Character
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





	// • ==== first • First Character (Nth) » Character(s)
	public static function first($string, $nth = 1) {
		if (self::isNotEmpty($string) && is_numeric($nth)) {
			$length = strlen($string);
			if ($nth <= $length) {
				return substr($string, 0, $nth);
			}
		}
		return false;
	}




	// • ==== last • Last Character (Nth) » Character(s)
	public static function last($string, $nth = 1) {
		if (self::isNotEmpty($string) && is_numeric($nth)) {
			$length = strlen($string);
			if ($nth <= $length) {
				return substr($string, -$nth);
			}
		}
		return false;
	}





	// • ==== occurrence • Count Occurrence » Boolean | Number
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





	// • ==== occurrenceNth •
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





	// • ==== swapFirst • Replace First Occurrence »
	public static function swapFirst($string, $needle, $substitute = '', $strictCase = false) {
		return self::swap($string, $needle, $substitute, 'FIRST', $strictCase);
	}




	// • ==== swapLast • Replace Last Occurrence »
	public static function swapLast($string, $needle, $substitute = '', $strictCase = false) {
		return self::swap($string, $needle, $substitute, 'LAST', $strictCase);
	}




	// • ==== swapSpace • Replace Space Character & Vice-Versa
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





	// • ==== noSpace • Remove Spaces
	public static function noSpace($string) {
		return self::swap($string, ' ', '');
	}





	// • ==== noChar • Remove Special Characters
	public static function noChar($string, $append = null) {
		if (self::isNotEmpty($string)) {
			$pattern = "A-Za-z0-9\-";
			if (is_array($append) && !empty($append)) {
				foreach ($append as $char) {
					$pattern .= $char;
				}
			} elseif (self::isNotEmpty($append)) {
				$pattern .= $append;
			}
			return preg_replace('/[^' . $pattern . ']/', '', $string);
		}
		return false;
	}





	// • ==== before • String Before Character
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





	// • ==== after • String After Character
	public static function after($string, $needle, $strip = true, $strictCase = false, $occurrence = 'FIRST') {
		if (self::isNotEmpty($string) && self::in($string, $needle, $strictCase)) {
			if ($strictCase) {
				$string = strstr($string, $needle);
			} else {
				$string = stristr($string, $needle);
			}
			if ($string !== false) {
				if ($strip === true && $occurrence === 'FIRST') {
					$string = self::swapFirst($string, $needle, '', $strictCase);
				} elseif ($occurrence === 'LAST') {
					if ($strictCase) {
						$pos = strrpos($string, $needle);
					} else {
						$pos = strripos($string, $needle);
					}
					if ($pos !== false) {
						$string = substr($string, $pos + strlen($needle));
					}
					if ($strip === false) {
						$string = $needle . $string;
					}
				}
				return $string;
			}
		}
		return false;
	}





	// • ==== BLUR • Blur Censored Character & Vice-Versa
	public static function blur($string, $library, $blur = '***', $strictCase = false) {
		if (self::isNotEmpty($string) && !empty($library)) {
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







	// • ==== isUppercase • is string upper case »
	public static function isUppercase($string) {
		return ctype_upper($string);
	}




	// • ==== isLowercase • is string lower case »
	public static function isLowercase($string) {
		return ctype_lower($string);
	}




	// • ==== isMixedCase • is string lower & upper case »
	public static function isMixedCase($string) {
		if (preg_match('/[a-z]/', $string) && preg_match('/[A-Z]/', $string)) {
			return true;
		}
		return false;
	}




	// • ==== isNumbers • is string numbers »
	public static function isNumbers($string) {
		return ctype_digit($string);
	}





	// • ==== hasNumber • string contains numbers »
	public static function hasNumber($string) {
		if (preg_match('/\d/', $string)) {
			return true;
		}
		return false;
	}




	// • ==== hasLetter • string contains letters »
	public static function hasLetter($string) {
		if (preg_match('/[a-zA-Z]/', $string)) {
			return true;
		}
		return false;
	}





	// • ==== hasSpace • string has space »
	public static function hasSpace($string) {
		$string = trim($string);
		if (strpos($string, ' ') !== false) {
			return true;
		}
		return false;
	}





	// • ==== begin → check string beginning» [boolean]
	public static function beginWith($string, $begin) {
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





	// • ==== beginWithAny → check if string begin with anything in array or comma separated string » [string|boolean]
	public static function beginWithAny($string, $begins) {

		if (is_string($begins)) {
			if (self::contain($begins, ',')) {
				$begins = explode(',', $begins);
			} elseif (self::beginWith($string, $begins)) {
				return $begins;
			}
		}

		foreach ($begins as $prefix) {
			if (substr($string, 0, strlen($prefix)) === $prefix) {
				return $prefix;
			}
		}

		return false;
	}




	// • ==== notBeginWith →
	public static function notBeginWith($string, $begin) {
		if (self::beginWith($string, $begin) === false) {
			return true;
		}
		return false;
	}




	// • ==== endWith → check string ending » [boolean]
	public static function endWith($string, $end) {
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




	// • ==== endWithAny → check if string ends with anything in array or comma separated string » [string|boolean]
	public static function endWithAny($string, $endings) {

		if (is_string($endings)) {
			if (self::contain($endings, ',')) {
				$endings = explode(',', $endings);
			} elseif (self::endWith($string, $endings)) {
				return $endings;
			}
		}

		for ($i = count($endings) - 1; $i >= 0; $i--) {
			$suffix = $endings[$i];
			if (substr($string, -strlen($suffix)) === $suffix) {
				return $suffix;
			}
		}

		return false;
	}





	// • ==== strip • Remove from Occurrence from String
	public static function strip($string, $needle, $strictCase = false) {
		return self::swap($string, $needle, '', 'ALL', $strictCase);
	}




	// • ==== stripFirst • Remove from First Occurrence from String
	public static function stripFirst($string, $needle, $strictCase = false) {
		return self::swapFirst($string, $needle, '', $strictCase);
	}




	// • ==== stripLast • Remove from Last Occurrence from String
	public static function stripLast($string, $needle, $strictCase = false) {
		return self::swapLast($string, $needle, '', $strictCase);
	}





	// • ==== crop → trim edges or character(s)
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




	// • ==== cropBegin → remove beginning of string
	public static function cropBegin($string, $needle, $strictCase = false) {
		if (self::beginWith($string, $needle)) {
			return self::stripFirst($string, $needle, $strictCase);
		}
		return $string;
	}




	// • ==== cropEnd → remove end of string
	public static function cropEnd($string, $needle, $strictCase = false) {
		if (self::endWith($string, $needle)) {
			return self::stripLast($string, $needle, $strictCase);
		}
		return $string;
	}





	// • ==== pattern → Match Pattern » Boolean | String | Array
	public static function pattern($string, $pattern, $return = 'BOOLEAN', $flags = 0, $offset = 0) {
		if (self::isNotEmpty($string)) {
			// • predefined pattern
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


			// • clean up pattern
			if (!self::begin($pattern, '/')) {
				$pattern = '/' . $pattern;
			}
			if (!self::end($pattern, '/')) {
				$pattern = $pattern . '/';
			}


			if ($return === 'MATCHES' || $return === 'COUNT') {
				$preg = preg_match_all($pattern, $string, $match, $flags, $offset);
			} else {
				$preg = preg_match($pattern, $string, $match, $flags, $offset);
			}
			if ($preg !== false) {
				if ($return === 'BOOLEAN' && $preg > 0) {
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





	// • ==== toArray • String to Array »
	public static function toArray($string, $separator = null) {
		if (self::isNotEmpty($string)) {
			if (is_null($separator)) {
				$array = str_split($string);
			}

			if ($separator === 'SPACE') {
				$array = explode(' ', $string);
			}

			if (self::isNotEmpty($string)) {
				$array = explode($separator, $string);
			}

			if (isset($array)) {
				return $array;
			}
		}
		return false;
	}





	// • ==== toUpperCase →
	public static function toUpperCase($string) {
		if (self::is($string)) {
			return strtoupper($string);
		}
		return false;
	}




	// • ==== toLowerCase →
	public static function toLowerCase($string) {
		if (self::is($string)) {
			return strtolower($string);
		}
		return false;
	}




	// • ==== toSentenceCase →
	public static function toSentenceCase($string) {
		if (self::is($string)) {
			return ucfirst(strtolower($string));
		}
		return false;
	}




	// • ==== toSnakeCase →
	public static function toSnakeCase($string, $separator = null) {
		if (!empty($separator)) {
			$words = explode($separator, $string);
		} else {
			$words = explode(' ', $string);
		}
		foreach ($words as $key => $word) {
			if (self::isUppercase($word)) {
				$words[$key] = strtolower($word);
			}
		}
		$string = implode(' ', $words);
		$string = preg_replace('/\s+/u', '', ucwords($string));
		$string = preg_replace('/(.)(?=[A-Z])/u', '$1_', $string);
		return strtolower($string);
	}





	// • ==== toCamelCase →
	public static function toCamelCase($string, $separator = null) {
		if (!empty($separator)) {
			$words = explode($separator, $string);
			foreach ($words as $key => $word) {
				if (self::isUppercase($word)) {
					$words[$key] = strtolower($word);
				}
				$string = implode(' ', $words);
			}
		}
		$string = preg_replace('/[^a-zA-Z0-9]+/', ' ', $string);
		$string = strtolower($string);
		$string = ucwords($string);
		$string = str_replace(' ', '', $string);
		$string = lcfirst($string);
		return $string;
	}




	// • ==== uppercaseCount →
	public static function uppercaseCount($string) {
		$pattern = '/[A-Z]/';
		return preg_match_all($pattern, $string);
	}




	// • ==== uppercaseToSpace →
	public static function uppercaseToSpace($string) {
		return preg_replace('/([a-z])([A-Z])/', '$1 $2', $string);
	}




	// • ==== getUppercase → get upper case letter & positions » [array|false]
	public static function getUppercase($string) {
		preg_match_all('/[A-Z]/', $string, $matches, PREG_OFFSET_CAPTURE);
		if (!empty($matches[0])) {
			$matches = $matches[0];
			$upperCase = [];
			foreach ($matches as $match) {
				$upperCase[$match[1]] = $match[0];
			}
			return $upperCase;
		}
		return false;
	}




	// • ==== getLowercase → get lower case letter & positions » [array|false]
	public static function getLowercase($string) {
		preg_match_all('/[a-z]/', $string, $matches, PREG_OFFSET_CAPTURE);
		if (!empty($matches[0])) {
			$matches = $matches[0];
			$upperCase = [];
			foreach ($matches as $match) {
				$upperCase[$match[1]] = $match[0];
			}
			return $upperCase;
		}
		return false;
	}


} //> end of StringX