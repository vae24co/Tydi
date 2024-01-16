<?php
/* ArrayX ~ Array Class » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © January 2023 | Apache License */

class ArrayX {

	// ◇ ----- CALL • Non-Existent Method » Error
	public function __call($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- CALL_STATIC • Non-Existent Static Method » Error
	public static function __callStatic($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- IS • $var an Array? » Boolean
	public static function is(&$var) {
		return is_array($var);
	}





	// ◇ ----- IS_NOT • Check if Array » Boolean
	public static function isNot(&$var) {
		if (!is_array($var)) {
			return true;
		}
		return false;
	}





	// ◇ ----- IS EMPTY • $var an Empty Array? » Boolean
	public static function isEmpty(&$var) {
		if (self::is($var) && empty($var)) {
			return true;
		}
		return false;
	}





	// ◇ ----- IS NOT EMPTY • $var a Not-Empty Array? » Boolean
	public static function isNotEmpty(&$var) {
		if (self::is($var) && !empty($var)) {
			return true;
		}
		return false;
	}





	// ◇ ----- IS_MULTI • $var is multi-dimensional Array » Boolean
	public static function isMulti($input) {
		if (self::isNotEmpty($input)) {
			$i = array_filter($input, 'is_array');
			if (count($i) > 0) {
				return true;
			}
		}
		return false;
	}





	// ◇ ----- IS NOT MULTI • $var is not multi-dimensional Array » Boolean
	public static function isNotMulti($input) {
		if (!self::isMulti(($input))) {
			return true;
		}
		return false;
	}





	// ◇ ----- IS_KEY • Key in Array? » Boolean
	public static function isKey(&$array, $key) {
		if (self::isNotEmpty($array) && array_key_exists($key, $array)) {
			return true;
		}
		return false;
	}




	// ◇ ----- IS_NOT_KEY • $key Not a index of Array? » Boolean
	public static function isNotKey(&$array, $key) {
		if (self::is($array) && !array_key_exists($key, $array)) {
			return true;
		}
		return false;
	}





	// ◇ ----- IS_KEY_NUMERIC • Check Numeric Keys » Boolean
	public static function isKeyNumeric(&$array) {
		if (self::is($array)) {
			foreach ($array as $key => $value) {
				if (!is_numeric($key)) {
					return false;
				}
			}
			return true;
		}
		return false;
	}





	// ◇ ----- IS_KEY_EMPTY • Property of Array, Empty? » Boolean
	public static function isKeyEmpty(&$array, $key) {
		if (self::isKey($array, $key) && VarX::isEmpty($array[$key])) {
			return true;
		}
		return false;
	}





	// ◇ ----- IS_KEY_NOT_EMPTY • Property of Array, Not-Empty? » Boolean
	public static function isKeyNotEmpty(&$array, $key) {
		if (self::isKey($array, $key) && VarX::isNotEmpty($array[$key])) {
			return true;
		}
		return false;
	}





	// ◇ ----- RE_KEYS • Re-Index »
	public static function reKeys($array, $keyArray) {
		foreach ($array as $key => $value) {
			if (array_key_exists($key, $keyArray)) {
				$res[$keyArray[$key]] = $value;
				unset($array[$key]);
			}
		}
		if (!empty($array) && !empty($res)) {
			$res = array_merge($res, $array);
		}
		if (!empty($res)) {
			return $res;
		} else {
			return $array;
		}
	}





	// ◇ ----- RE_KEYS_NUMERIC • Re-Index Numeric »
	public static function reKeysNumeric($array) {
		if (self::isKeyNumeric($array) && isset($array[0])) {
			foreach ($array as $index => $value) {
				$res[$index + 1] = $value;
			}
			if (!empty($res)) {
				return $res;
			}
		} elseif (self::is($array)) {
			return $array;
		}
		return false;
	}





	// ◇ ----- TO_UPPER_KEYS •
	public static function toUpperKeys($array) {
		if (self::is($array)) {
			return false;
		}
		foreach ($array as $key => $value) {
			$index = strtoupper($key);
			$array[$index] = $value;
			unset($array[$key]);
		}
		return $array;
	}





	// ◇ ----- TO_LOWER_KEYS •
	public static function toLowerKeys($array) {
		if (self::is($array)) {
			return false;
		}
		foreach ($array as $key => $value) {
			$index = strtolower($key);
			$array[$index] = $value;
			unset($array[$key]);
		}
		return $array;
	}







	// ◇ ----- KEYS • Array Keys » Boolean OR Numerically Indexed
	public static function keys($array) {
		if (self::is($array)) {
			return array_keys($array);
		}

		return false;
	}





	// ◇ ----- FIRST_KEY •
	public static function firstKey($array) {
		if (self::is($array)) {
			return array_key_first($array);
		}
		return false;
	}





	// ◇ ----- LAST_KEY •
	public static function lastKey($array) {
		if (self::is($array)) {
			return array_key_last($array);
		}
		return false;
	}





	// ◇ ----- KEY •
	public static function key($array, $req) {
		if ($req === 'FIRST') {
			return self::firstKey($array);
		} elseif ($req === 'LAST') {
			return self::lastKey($array);
		} elseif ($req === 'KEYS') {
			return self::keys($array);
		} elseif (VarX::isNotEmpty($req) && self::isKey($array, $req)) {
			return $req;
		}
		return false;
	}






	// ◇ ----- STRIP_KEY • Remove from Array (by Key) »
	public static function stripKey($array, $filter) {
		if (!self::is($array)) {
			return false;
		}
		if (!is_array($filter)) {
			if (self::isKey($array, $filter)) {
				unset($array[$filter]);
			}
		} else {
			foreach ($filter as $index => $value) {
				if (isset($array[$index])) {
					unset($array[$index]);
				}
			}
		}
		return $array;
	}





	// ◇ ----- KEY BY VALUE • Find Key by Value
	public static function keyByValue($array, $value, $strict = false) {
		return array_search($value, $array, $strict);
	}





	// ◇ ----- COMBINE • Safely merge arrays
	public static function combine($var, ...$array) {
		if (self::is($var)) {
			foreach ($array as $key => $value) {
				if (self::isNot($value)) {
					unset($array[$key]);
				}
			}
			return array_merge($var, ...$array);
		}
		return false;
	}





	// ◇ ----- FLIP • Flip Keys to Values & Reverse Key Order
	public static function flip($array, $flag = 'FLIP') {
		if (self::is($array)) {
			if ($flag === 'FLIP') {
				return array_flip($array);
			} elseif ($flag === 'REVERSE') {
				return array_reverse($array, true);
			}
		}

		return false;
	}





	// ◇ ----- SWAP KEY • Exchange a key in an array » Array
	public static function swapKey($array, $key, $rekey) {
		if (self::isKey($array, $key)) {
			$array[$rekey] = $array[$key];
			unset($array[$key]);
		}
		return $array;
	}





	// ◇ ----- JUMBLE • Randomize Index or Value »
	public static function jumble($array) {
		if (self::is($array)) {
			shuffle($array);
			return $array;
		}
		return false;
	}





	// ◇ ----- RANDOM • Pick Random Index »
	public static function random($array, $num = 1) {
		if (self::is($array) && is_numeric($num)) {
			$count = count($array);
			if ($num < $count) {
				$random = array_rand($array, $num);
				if (self::is($random)) {
					foreach ($random as $index => $value) {
						$rex[$value] = $array[$value];
					}
				} elseif (StringX::isNotEmpty($random)) {
					$rex[$random] = $array[$random];
				}
				if (!empty($rex)) {
					return $rex;
				}
			}
		}
		return false;
	}





	// ◇ ----- FILTERED • Create Array from Array (as Filter) »
	public static function filtered($array, $filter, $drop = 'NONE') {
		$res = array();
		if (is_array($filter)) {
			foreach ($filter as $index) {
				if (isset($array[$index])) {
					$res[$index] = $array[$index];
				} else {
					$res[$index] = '';
				}
			}
		} else {
			if (isset($array[$filter])) {
				$res[$filter] = $array[$filter];
			} else {
				$res[$filter] = '';
			}
		}

		if ($drop === 'EMPTY') {
			if (is_array($res)) {
				foreach ($res as $key => $value) {
					if (StringX::isEmpty($value)) {
						unset($res[$key]);
					}
				}
			}
		}

		if ($drop === 'UNSET') {
			if (is_array($res)) {
				foreach ($res as $key => $value) {
					if (!isset($array[$key])) {
						unset($res[$key]);
					}
				}
			}
		}

		return $res;
	}





	// ◇ ----- IS_VALUE • $value in Array? » Boolean
	public static function isValue($array, $value) {
		if (self::is($array) && in_array($value, $array)) {
			return true;
		}
		return false;
	}





	// ◇ ----- IS_NOT_VALUE • $value Not in Array? » Boolean
	public static function isNotValue($array, $value) {
		if (self::is($array) && !in_array($value, $array)) {
			return true;
		}
		return false;
	}





	// ◇ ----- VALUES • Array Values » Boolean OR Numerically Indexed
	public static function values($array) {
		if (self::is($array)) {
			return array_values($array);
		}
		return false;
	}





	// ◇ ----- FIRST_VALUE •
	public static function firstValue($array) {
		if (self::is($array)) {
			return reset($array);
		}
		return false;
	}





	// ◇ ----- LAST_VALUE •
	public static function lastValue($array) {
		if (self::is($array)) {
			return end($array);
		}
		return false;
	}





	// ◇ ----- VALUE •
	public static function value($array, $flag) {
		if ($flag === 'FIRST') {
			return self::firstValue($array);
		} elseif ($flag === 'LAST') {
			return self::lastValue($array);
		} elseif ($flag === 'VALUES') {
			return self::values($array);
		} elseif (self::isKey($array, $flag)) {
			return $array[$flag];
		}
		return false;
	}





	// ◇ ----- ADD_VALUE • Add to Array Value »
	public static function addValue($array, $value) {
		if (!self::is($array)) {
			return false;
		}
		array_push($array, $value);
		return $array;
	}





	// ◇ ----- STRIP VALUE • Remove from Array (by Value) »
	public static function stripValue($array, $filter) {
		if (!self::is($array)) {
			return false;
		}
		if (!is_array($filter)) {
			if (($key = array_search($filter, $array)) !== false) {
				unset($array[$key]);
			}
		} else {
			foreach ($filter as $index => $value) {
				if (($key = array_search($value, $array)) !== false) {
					unset($array[$key]);
				}
			}
		}
		return $array;
	}





	// ◇ ----- UNIQUE • Prevent Duplicate Values »
	public static function uniqueValue($array) {
		if (self::isMulti($array)) {
			foreach ($array as $index => $value) {
				if (self::is($array[$index])) {
					$array[$index] = self::uniqueValue($array[$index]);
				}
			}
		}
		return array_unique($array, SORT_REGULAR);
	}





	// ◇ ----- TO_STRING • Array to String »
	public static function toString($array, $flag = 'STRING', $separator = ' ') {
		if (self::isMulti($array)) {
			foreach ($array as $index => $value) {
				if (self::is($array[$index])) {
					$array[$index] = self::toString($array[$index]);
				}
			}
		}

		if (self::is($array)) {
			if ($flag === 'URI') {
				if (empty($separator) || $separator === 'DEFAULT') {
					return http_build_query($array);
				}
				return http_build_query($array, '', $separator);
			}
			return implode($separator, $array);
		}
		return false;
	}





	// ◇ ----- TO_JSON • Array to JSON »
	public static function toJSON($array, $depth = false) {
		if (self::is($array)) {
			if (!$depth) {
				return json_encode($array);
			}
			return json_encode($array, JSON_FORCE_OBJECT);
		}
		return false;
	}





	// ◇ ----- TO_OBJ • Array to Object »
	public static function toObj($input, $multi = true) {
		if ($multi && self::isMulti($input)) {
			return json_decode(json_encode($input), false);
		} elseif (self::is($input)) {
			return (object) $input;
		}
		return false;
	}






	// ◇ ----- BLEND • Create & merge array from $var »
	public static function blend($array, $var) {
		if (VarX::isEmpty($array)) {
			$array = [];
		}

		if (VarX::isNotEmpty($var)) {

			//...FOR EMPTY $array
			if (self::isEmpty($array)) {
				if (VarX::stringAcceptable($var)) {
					$array[] = $var;
				} elseif (VarX::isArray($var)) {
					$array = $var;
				}
			}


			//...FOR NON-EMPTY $array
			else {
				if (VarX::stringAcceptable($var)) {
					array_push($array, $var);
				} elseif (VarX::isArray($var)) {

					//...multi-dimensional array
					if (self::isMulti($var)) {
						foreach ($var as $key => $value) {

							//...if key does not exist in $array
							if (self::isNotKey($array, $key)) {
								$array[$key] = $value;
							}

							//...if key exist in $array
							else {
								if (VarX::stringAcceptable($array[$key])) {
									$initialValue = $array[$key];
									$array[$key] = [];
									if (VarX::isArray($value)) {
										$array[$key] = array_merge([$initialValue], $value);
									} else {
										if ($initialValue != $value) {
											array_push($array[$key], $initialValue, $value);
										} else {
											$array[$key] = $value;
										}
									}
								} elseif (VarX::isArray($array[$key])) {
									$array[$key] = array_merge($array[$key], $value);
								}
							}
						}
					}

					//...not multi-dimensional numeric key array
					elseif (self::isKeyNumeric($var)) {
						foreach ($var as $value) {
							$array = self::addValue($array, $value);
						}
						$array = self::uniqueValue($array);
						if (self::isKeyNumeric($var)) {
							$array = self::values($array);
						}
					}

					//...not multi-dimensional text key array
					else {
						foreach ($var as $key => $value) {
							//...when index exist in $array
							if (self::isKey($array, $key)) {
								if (VarX::stringAcceptable($array[$key])) {
									$initialValue = $array[$key];
									$array[$key] = [];
									array_push($array[$key], $initialValue, $value);
								}
							}

							//...when index does not exist in $array
							else {
								$array[$key] = $value;
							}
						}
					}
				}
			}
		}

		return $array;
	}






	// ◇ ----- IS MULTI AND KEY NUMERIC • ... »
	public static function isMultiAndKeyNumeric(&$var) {
		if (self::isMulti($var) && self::isKeyNumeric($var)) {
			return true;
		}
		return false;
	}





	// ◇ ----- IS NOT KEY OR EMPTY • ... »
	public static function isNotKeyOrEmpty(&$array, $key) {
		if (self::isNotKey($array, $key) || self::isKeyEmpty($array, $key)) {
			return true;
		}
		return false;
	}
} // End Of Class ~ ArrayX