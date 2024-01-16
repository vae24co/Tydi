<?php
//*** StringX » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//
class oStringX {
















	// • ==== COMPARE • Compare String » Boolean
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




	// • ==== begin → check string beginning» [boolean]
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




	// • ==== notBegin →
	public static function notBegin($string, $begin) {
		if (self::begin($string, $begin) === false) {
			return true;
		}
		return false;
	}




	// • ==== end → check string ending » [boolean]
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




	// • ==== pattern • Match Pattern » Boolean | String | Array
	public static function pattern($string, $pattern, $return = 'IS', $flags = 0, $offset = 0) {
		if (self::isNotEmpty($string)) {
			// • Predefined Pattern
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


			// • Clean up pattern
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




	// • ==== CROP • Trim Edges Or Character(s)
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




	// • ==== CROP_BEGIN • Remove from Beginning of String
	public static function cropBegin($string, $needle, $strictCase = false) {
		if (self::begin($string, $needle)) {
			return self::stripFirst($string, $needle, $strictCase);
		}
		return $string;
	}




	// • ==== CROP_END • Remove from End of String
	public static function cropEnd($string, $needle, $strictCase = false) {
		if (self::end($string, $needle)) {
			return self::stripLast($string, $needle, $strictCase);
		}
		return $string;
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




	// • ==== toUpperCase • Covert string to upper case »
	public static function toUpperCase($string) {
		if (self::is($string)) {
			return strtoupper($string);
		}
		return false;
	}




	// • ==== toLowerCase • Covert string to lower case »
	public static function toLowerCase($string) {
		if (self::is($string)) {
			return strtolower($string);
		}
		return false;
	}




	// • ==== toSentenceCase • Covert string to sentence case »
	public static function toSentenceCase($string) {
		if (self::is($string)) {
			return ucfirst(strtolower($string));
		}
		return false;
	}




	// • ==== toSnakeCase • Covert string to snake case »
	public static function toSnakeCase($string) {
		$words = explode(" ", $string);
		foreach ($words as $key => $word) {
			if (self::isUppercase($word)) {
				$words[$key] = strtolower($word);
			}
		}
		$string = implode(" ", $words);
		$string = preg_replace('/\s+/u', '', ucwords($string));
		$string = preg_replace('/(.)(?=[A-Z])/u', '$1_', $string);
		return strtolower($string);
	}




	// • ==== toCamelCase • Covert string to camel case »
	public static function toCamelCase($string) {
		$string = preg_replace('/[^a-zA-Z0-9]+/', ' ', $string);
		$string = strtolower($string);
		$string = ucwords($string);
		$string = str_replace(' ', '', $string);
		$string = lcfirst($string);
		return $string;
	}




	// • ==== uppercaseCount •
	public static function uppercaseCount($string) {
		$pattern = '/[A-Z]/';
		return preg_match_all($pattern, $string);
	}




	// • ==== uppercaseToSpace •
	public static function uppercaseToSpace($string) {
		return preg_replace('/([a-z])([A-Z])/', '$1 $2', $string);
	}




	// • ==== getUppercase • get upper case letter & positions » [array|false]
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




	// • ==== getLowercase • get lower case letter & positions » [array|false]
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