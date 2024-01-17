<?php //*** ArrayX » Tydi™ Framework © 2024 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

class ArrayX {

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





	// ◇ ==== is • $var an Array? » Boolean
	public static function is($var) {
		return is_array($var);
	}




	// ◇ ==== isEmpty • $var an Empty Array? » Boolean
	public static function isEmpty($var) {
		if (self::is($var) && empty($var)) {
			return true;
		}
		return false;
	}




	// ◇ ==== isMulti • $var is multi-dimensional Array » Boolean
	public static function isMulti($var) {
		if (!self::isEmpty($var)) {
			$i = array_filter($var, 'is_array');
			if (count($i) > 0) {
				return true;
			}
		}
		return false;
	}




	// ◇ ==== isKey • Key in Array? » Boolean
	public static function isKey($array, $key) {
		if (!self::isEmpty($array) && array_key_exists($key, $array)) {
			return true;
		}
		return false;
	}




	// ◇ ==== isKeyNumeric • Check Numeric Keys » Boolean
	public static function isKeyNumeric($array) {
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




	// ◇ ==== isKeyEmpty • Property of Array, Empty? » Boolean
	public static function isKeyEmpty($array, $key) {
		if (self::isKey($array, $key) && Vars::isEmpty($array[$key])) {
			return true;
		}
		return false;
	}




	// ◇ ==== isKeyNotEmpty • Property of Array, Not-Empty? » Boolean
	public static function isKeyNotEmpty($array, $key) {
		if (self::isKey($array, $key) && Vars::isNotEmpty($array[$key])) {
			return true;
		}
		return false;
	}





	// ◇ ==== RE_KEYS • Re-Index »
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





	// ◇ ==== RE_KEYS_NUMERIC • Re-Index Numeric »
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





	// ◇ ==== TO_UPPER_KEYS •
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





	// ◇ ==== TO_LOWER_KEYS •
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







	// ◇ ==== KEYS • Array Keys » Boolean OR Numerically Indexed
	public static function keys($array) {
		if (self::is($array)) {
			return array_keys($array);
		}

		return false;
	}





	// ◇ ==== FIRST_KEY •
	public static function firstKey($array) {
		if (self::is($array)) {
			return array_key_first($array);
		}
		return false;
	}





	// ◇ ==== LAST_KEY •
	public static function lastKey($array) {
		if (self::is($array)) {
			return array_key_last($array);
		}
		return false;
	}





	// ◇ ==== KEY •
	public static function key($array, $req) {
		if ($req === 'FIRST') {
			return self::firstKey($array);
		} elseif ($req === 'LAST') {
			return self::lastKey($array);
		} elseif ($req === 'KEYS') {
			return self::keys($array);
		} elseif (Vars::isNotEmpty($req) && self::isKey($array, $req)) {
			return $req;
		}
		return false;
	}






	// ◇ ==== STRIP_KEY • Remove from Array (by Key) »
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





	// ◇ ==== KEY BY VALUE • Find Key by Value
	public static function keyByValue($array, $value, $strict = false) {
		return array_search($value, $array, $strict);
	}





	// ◇ ==== COMBINE • Safely merge arrays
	public static function combine($var, ...$array) {
		if (self::is($var)) {
			foreach ($array as $key => $value) {
				if (!self::is($value)) {
					unset($array[$key]);
				}
			}
			return array_merge($var, ...$array);
		}
		return false;
	}





	// ◇ ==== FLIP • Flip Keys to Values & Reverse Key Order
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





	// ◇ ==== SWAP KEY • Exchange a key in an array » Array
	public static function swapKey($array, $key, $rekey) {
		if (self::isKey($array, $key)) {
			$array[$rekey] = $array[$key];
			unset($array[$key]);
		}
		return $array;
	}





	// ◇ ==== JUMBLE • Randomize Index or Value »
	public static function jumble($array) {
		if (self::is($array)) {
			shuffle($array);
			return $array;
		}
		return false;
	}





	// ◇ ==== RANDOM • Pick Random Index »
	public static function random($array, $num = 1) {
		if (self::is($array) && is_numeric($num)) {
			$count = count($array);
			if ($num < $count) {
				$random = array_rand($array, $num);
				if (self::is($random)) {
					foreach ($random as $index => $value) {
						$rex[$value] = $array[$value];
					}
				} elseif (Vars::isString($random) && Vars::isNotEmpty($random)) {
					$rex[$random] = $array[$random];
				}
				if (!empty($rex)) {
					return $rex;
				}
			}
		}
		return false;
	}





	// ◇ ==== FILTERED • Create Array from Array (as Filter) »
	public static function filteredX($array, $filter, $drop = 'NONE') {
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
					if (Vars::isString($value) && Vars::isEmpty($value)) {
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





	// ◇ ==== IS_VALUE • $value in Array? » Boolean
	public static function isValue($array, $value) {
		if (self::is($array) && in_array($value, $array)) {
			return true;
		}
		return false;
	}





	// ◇ ==== IS_NOT_VALUE • $value Not in Array? » Boolean
	public static function isNotValue($array, $value) {
		if (self::is($array) && !in_array($value, $array)) {
			return true;
		}
		return false;
	}





	// ◇ ==== VALUES • Array Values » Boolean OR Numerically Indexed
	public static function values($array) {
		if (self::is($array)) {
			return array_values($array);
		}
		return false;
	}





	// ◇ ==== FIRST_VALUE •
	public static function firstValue($array) {
		if (self::is($array)) {
			return reset($array);
		}
		return false;
	}





	// ◇ ==== LAST_VALUE •
	public static function lastValue($array) {
		if (self::is($array)) {
			return end($array);
		}
		return false;
	}





	// ◇ ==== VALUE •
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





	// ◇ ==== ADD_VALUE • Add to Array Value »
	public static function addValue($array, $value) {
		if (!self::is($array)) {
			return false;
		}
		array_push($array, $value);
		return $array;
	}





	// ◇ ==== STRIP VALUE • Remove from Array (by Value) »
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





	// ◇ ==== UNIQUE • Prevent Duplicate Values »
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





	// ◇ ==== TO_STRING • Array to String »
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





	// ◇ ==== TO_JSON • Array to JSON »
	public static function toJSON($array, $depth = false) {
		if (self::is($array)) {
			if (self::isMulti($array)) {
				return json_encode($array, JSON_FORCE_OBJECT);
			} else {
				return json_encode($array);
			}
		}
		return false;
	}





	// ◇ ==== TO_OBJ • Array to Object »
	public static function toObj($input, $multi = true) {
		if ($multi && self::isMulti($input)) {
			return json_decode(json_encode($input), false);
		} elseif (self::is($input)) {
			return (object) $input;
		}
		return false;
	}






	// ◇ ==== BLEND • Create & merge array from $var »
	public static function blend($array, $var) {
		if (Vars::isEmpty($array)) {
			$array = [];
		}

		if (Vars::isNotEmpty($var)) {

			//...FOR EMPTY $array
			if (self::isEmpty($array)) {
				if (Vars::isString($var)) {
					$array[] = $var;
				} elseif (Vars::isArray($var)) {
					$array = $var;
				}
			}


			//...FOR NON-EMPTY $array
			else {
				if (Vars::isString($var)) {
					array_push($array, $var);
				} elseif (Vars::isArray($var)) {

					//...multi-dimensional array
					if (self::isMulti($var)) {
						foreach ($var as $key => $value) {

							//...if key does not exist in $array
							if (!self::isKey($array, $key)) {
								$array[$key] = $value;
							}

							//...if key exist in $array
							else {
								if (Vars::isString($array[$key])) {
									$initialValue = $array[$key];
									$array[$key] = [];
									if (Vars::isArray($value)) {
										$array[$key] = array_merge([$initialValue], $value);
									} else {
										if ($initialValue != $value) {
											array_push($array[$key], $initialValue, $value);
										} else {
											$array[$key] = $value;
										}
									}
								} elseif (Vars::isArray($array[$key])) {
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
								if (Vars::isString($array[$key])) {
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






	// ◇ ==== IS MULTI AND KEY NUMERIC • ... »
	public static function isMultiAndKeyNumeric($var) {
		if (self::isMulti($var) && self::isKeyNumeric($var)) {
			return true;
		}
		return false;
	}





	// ◇ ==== IS NOT KEY OR EMPTY • ... »
	public static function isNotKeyOrEmpty($array, $key) {
		if (!self::isKey($array, $key) || self::isKeyEmpty($array, $key)) {
			return true;
		}
		return false;
	}


































	//*========--- filterExtract ========---*//
	public static function filterExtract($input, $param) {
		if (!empty($input) && !empty($param)) {
			if (!is_array($param)) {
				if (isset($input[$param])) {
					$filter[$param] = $input[$param];
					unset($input[$param]);
				}
			} else {
				foreach ($param as $key => $value) {
					if (is_numeric($key)) {
						if (isset($input[$value])) {
							$filter[$value] = $input[$value];
							unset($input[$value]);
						}
					} else {
						if (isset($input[$key])) {
							$filter[$value] = $input[$key];
							unset($input[$key]);
						}
					}
				}
			}
			if (!empty($filter)) {
				return $filter;
			}
		}
		return false;
	}















































	// ◇ ==== filterByKey • create array by extracting matching key(s) » [array]
	public static function filterByKey($array, $filterKey) {

		// • if $filterKey is string
		if (is_string($filterKey)) {
			if (StringX::contain($filterKey, ', ')) {
				$filterKey = explode(', ', $filterKey);
				return self::filterByKey($array, $filterKey);
			}
			if (isset($array[$filterKey])) {
				return [$filterKey => $array[$filterKey]];
			}
		}

		// • if $filterKey is array
		if (is_array($filterKey)) {
			return array_intersect_key($array, array_flip($filterKey));
		}
		return false;
	}

} //> end of ArrayX