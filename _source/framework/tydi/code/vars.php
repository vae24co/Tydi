<?php
//*** Vars - Variable » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//
class Vars {

	// ◇ ==== callStatic → handler - undefined static method » [error]
	public static function __callStatic($method, $argument) {
		return OversightX(__CLASS__, 'static method unreachable', $method);
	}




	// ◇ ==== is → $var defined or has a specific key or value » [boolean]
	public static function is(&$var, $key = null, $value = null) {
		if (is_null($key) && is_null($value)) {
			return isset($var);
		}

		// @ IF: $key has input
		elseif (!is_null($key) && $key !== '') {
			if (isset($var)) {

				// @ check for array
				if (self::isArray($var) && isset($var[$key])) {
					if (self::hasData($value) && $var[$key] === $value) {
						return true;
					} elseif (self::noData($value)) {
						return true;
					}
				}

			}
		}

		// @ IF: $var is string & $value is
		elseif (self::isString($var) && self::isString($value) && $var === $value) {
			return true;
		}

		return false;
	}




	// ◇ ==== isError → check for custom exception error
	public static function isError($var) {
		if (self::is($var, 'is_error')) {
			return true;
		}
		return false;
	}




	// ◇ ==== isNot → $var not a defined variable? » Boolean
	public static function isNot(&$var) {
		if (!isset($var)) {
			return true;
		}
		return false;
	}




	// ◇ ==== isNull → $var a null variable? » Boolean
	public static function isNull(&$var) {
		return is_null($var);
	}




	// ◇ ==== isNotNull → $var not null variable? » Boolean
	public static function isNotNull(&$var) {
		if (!is_null($var)) {
			return true;
		}
		return false;
	}




	// ◇ ==== isZero → $var value zero? » Boolean
	public static function isZero(&$var, $strictCheck = false) {
		if (self::is($var) && is_numeric($var)) {
			if ($var == 0 && !$strictCheck) {
				return true;
			} elseif ($var === 0 && $strictCheck) {
				return true;
			}
		}
		return false;
	}




	// ◇ ==== isNotZero → $var value not zero? » Boolean
	public static function isNotZero(&$var) {
		if (!self::isZero($var, false)) {
			return true;
		}
		return false;
	}




	// ◇ ==== isNumeric → $var is numeric » Boolean
	public static function isNumeric(&$var) {
		if (self::is($var) && is_numeric($var)) {
			return true;
		}
		return false;
	}




	// ◇ ==== isNotNumeric → $var is not numeric » Boolean
	public static function isNotNumeric(&$var) {
		if (!self::isNumeric($var)) {
			return true;
		}
		return false;
	}




	// ◇ ==== isBoolean → $var type is boolean » Boolean
	public static function isBoolean(&$var) {
		if (self::is($var) && is_bool($var)) {
			return true;
		}
		return false;
	}




	// ◇ ==== isNotBoolean → $var type is not boolean » Boolean
	public static function isNotBoolean(&$var) {
		if (!self::isBoolean($var)) {
			return true;
		}
		return false;
	}




	// ◇ ==== isTrue → $var type is boolean [true]? » Boolean
	public static function isTrue(&$var) {
		if (self::is($var) && $var === true) {
			return true;
		}
		return false;
	}




	// ◇ ==== isFalse → $var type is boolean [false]? » Boolean
	public static function isFalse(&$var) {
		if (self::is($var) && $var === false) {
			return true;
		}
		return false;
	}




	// ◇ ==== isType → $var type or comparison » Boolean | String
	public static function isType(&$var, $comparison = '') {
		if ($comparison !== '') {
			if (strtolower(gettype($var)) !== strtolower($comparison)) {
				return true;
			}
		} else {
			return gettype($var);
		}
		return false;
	}




	// ◇ ==== isNotType → $var type negative comparison » Boolean | String
	public static function isNotType(&$var, $comparison) {
		if (strtolower(self::isType($var)) !== strtolower($comparison)) {
			return true;
		}
		return false;
	}




	// ◇ ==== IS EMPTY → $var is actually empty? » Boolean
	public static function isEmpty(&$var, $type = '') {

		// • If $var does not exist
		if (!self::is($var)) {
			return true;
		}

		// • If $var is empty json string
		if ($var == '{}') {
			return true;
		}

		// • Set $var type if $var exist
		$varType = self::isType($var);

		// • If $type is empty & $varType is not empty
		if (empty($type) && !empty($varType)) {
			return self::isEmpty($var, $varType);
		}

		// • If $type & $vqrType is not empty
		if (!empty($type) && !empty($varType)) {
			$type = strtolower($type);

			// • Type: Check for string, integer & numeric values
			$string = ['string', 'integer', 'double', 'numeric'];
			if (in_array($type, $string)) {
				if ($varType !== 'array' && $varType !== 'object') {
					$var = (string) $var;
					$var = trim($var);
					if (strlen($var) < 1) {
						return true;
					}
				}
			}

			// • Type: Check for array
			elseif ($type === 'array' && $varType === 'array' && empty($var)) {
				return true;
			}

			// • Type: Check for object
			elseif ($type === 'object' && $varType === 'object' && is_object($var) && (count((array) $var) === 0)) {
				return true;
			}
		}

		return false;
	}




	// ◇ ==== isNotEmpty → $var actually not empty? » Boolean
	public static function isNotEmpty(&$var, string $type = '') {
		if (self::isEmpty($var, $type) === false) {
			return true;
		}
		return false;
	}




	// ◇ ==== isString → $var is a string or acceptable as string » Boolean
	public static function isString(&$var, $strict = false) {
		if (self::is($var)) {
			if (!$strict) {
				$varType = strtolower(self::isType($var));
				$allowed = ['string', 'integer', 'double'];
				if (in_array($varType, $allowed)) {
					return true;
				}
			} else {
				if (self::isType($var) === 'string') {
					if ($strict === 'NO_EMPTY' && self::isEmpty($var)) {
						return false;
					}
					return true;
				}
			}
		}
		return false;
	}




	// ◇ ==== isNotString → $var type is not string or string acceptable » Boolean
	public static function isNotString(&$var, $strict = false) {
		if (!self::isString($var, $strict)) {
			return true;
		}
		return false;
	}




	// ◇ ==== isArray → $var type is array » Boolean
	public static function isArray(&$var) {
		if (self::is($var) && is_array($var)) {
			return true;
		}
		return false;
	}




	// ◇ ==== isNotArray → $var type is not array » Boolean
	public static function isNotArray(&$var) {
		if (!self::isArray($var)) {
			return true;
		}
		return false;
	}




	// ◇ ==== isEmptyArray → $var is an empty array? » Boolean
	public static function isEmptyArray(&$var) {
		if (self::isArray($var) && empty($var)) {
			return true;
		}
		return false;
	}




	// ◇ ==== isNotEmptyArray → $var is not an empty array? » Boolean
	public static function isNotEmptyArray(&$var) {
		if (self::isArray($var) && !empty($var)) {
			return true;
		}
		return false;
	}




	// ◇ ==== isObject → $var type is object » Boolean
	public static function isObject(&$var) {
		if (self::is($var) && is_object($var)) {
			return true;
		}
		return false;
	}




	// ◇ ==== isNotObject → $var type is not object » Boolean
	public static function isNotObject(&$var) {
		if (!self::isObject($var)) {
			return true;
		}
		return false;
	}




	// ◇ ==== isNotEmptyObject → $var is not empty object »
	public static function isNotEmptyObject(&$var) {
		if (Vars::hasData($var) && Vars::isObject($var)) {
			return true;
		}
		return false;
	}




	// ◇ ==== isJSON → $var type is json » Boolean
	public static function isJSON(&$var) {
		if (self::isNotEmpty($var)) {
			if (is_string($var) && is_array(json_decode($var, true)) && (json_last_error() == JSON_ERROR_NONE)) {
				return true;
			}
		}
		return false;
	}




	// ◇ ==== isNotJSON → $var type is not json » Boolean
	public static function isNotJSON(&$var) {
		if (!self::isJSON($var)) {
			return true;
		}
		return false;
	}




	// ◇ ==== hasData → $var contains data? » Boolean
	public static function hasData(&$var) {
		if (self::isNotBoolean($var) && self::isNotEmpty($var)) {
			return true;
		}
		return false;
	}




	// ◇ ==== noData → $var contains no data? » Boolean
	public static function noData(&$var) {
		if (!self::hasData($var)) {
			return true;
		}
		return false;
	}




	// ◇ ==== hasRow → $var has row » Boolean
	public static function hasRow(&$var, $field = null) {
		if (self::isNotEmptyArray($var)) {
			if (self::hasData($field)) {
				if (isset($var[$field])) {
					return true;
				}
			} else {
				return true;
			}
		}
		return false;
	}




	// ◇ ==== multiRow → $var has multi-row » Boolean
	public static function multiRow(&$var, $field = null) {
		if (is_array($var)) {
			$multi = array_filter($var, 'is_array');
			if (count($multi) > 0) {
				$firstRow = reset($var);
				return self::hasRow($firstRow, $field);
			}
		}
		return false;
	}




	// ◇ ==== countIs → $var is count? » Number
	public static function countIs(&$var, $mode = COUNT_NORMAL, $numeric = true) {
		if ($numeric) {
			$count = 0;
		} else {
			$count = false;
		}
		if (is_countable($var)) {
			$count = count($var, $mode); // ∞ NOTE: $mode [COUNT_NORMAL|COUNT_RECURSIVE]
		}
		return $count;
	}




	// ◇ ==== objectify → Turn variable to Object » Object
	public static function objectify($var) {
		if (self::hasData($var)) {
			if (self::isNotObject($var)) {
				if (is_array($var)) {
					return ArrayX::toObj($var);
				}
			}
			return $var;
		}
		return ObjectX::make();
	}




	// ◇ ==== safe → Safely return a variable » string
	public static function safe(&$var, $key = null) {
		if (isset($var)) {
			if (self::isJSON($var) && self::hasData($key)) {
				$array = JSONX::toArray($var);
				return self::safe($array, $key);
			} elseif (self::isArray($var) && self::hasData($key) && isset($var[$key])) {
				return $var[$key];
			} elseif (self::isObject($var) && self::hasData($key) && isset($var->$key)) {
				return $var->$key;
			} elseif (self::isString($var)) {
				return $var;
			}
		}
		return '';
	}




	// ◇ ==== SHOW → Safely print a variable » string
	public static function show(&$var, $key = null) {
		echo self::safe($var, $key);
	}




	// ◇ ===== reveal → Safely output value or hyphen » [string, -]
	public static function reveal(&$var, $key = null, $symbol = '—') {
		$yield = self::safe($var, $key);
		if (self::isNotEmpty($yield) && $yield !== 'NO_RESULT') {
			echo $yield;
			return;
		}
		echo $symbol;
		return;
	}




	// ◇ ==== revealOnRow → Safely output value or hyphen and set variable to null
	public static function revealOnRow(&$var, $key = null, $symbol = '—') {
		self::reveal($var, $key, $symbol);
		if (self::hasData($key)) {
			if (self::isObject($var)) {
				$var->$key = null;
			} elseif (self::isArray($var)) {
				$var[$key] = null;
			}
		} else {
			$var = null;
		}
		return;
	}




	public static function display($callback) {
		echo $callback;
	}




	// ◇ ==== output → echo out a variable »
	public static function output($var, $key = null, $symbol = '—') {
		return self::reveal($var, $key, $symbol);
	}




	// ◇ ==== trace → Useful Debugging »
	public static function trace($i, $print = true) {
		if ($print) {
			echo nl2br(self::trace($i, false));
			return;
		}
		$o = '';
		if (is_array($i)) {
			$label = 'array';
			$o .= '<em style="color:#FFD700;">is_' . $label . '</em>';
			$o .= '<div style="margin: 0px 0 4px 6px; padding: 4px 6px 6px 12px; border-left: 1px dotted #FFD700;">';
			foreach ($i as $key => $value) {
				$o .= '<strong style="color:#A52A2A;">' . $key . ': </strong>';
				if (is_bool($value) === true) {
					if ($value === true) {
						$o .= ' → oTRUE<span> ';
					} elseif ($value === false) {
						$o .= ' → oFALSE<span> ';
					}
					$o .= '<em style="color:#D2B48C;">(boolean)</em><br>';
				} elseif (is_null($value) === true) {
					$o .= '<span> → oNULL</span><br>';
				} elseif (is_array($value)) {
					$o .= self::trace($value, false);
				} elseif (is_object($value)) {
					$o .= '<pre><tt>' . var_export($value, true) . '</tt></pre>';
				} else {
					$o .= $value . '<span><br>';
				}
			}
			$o .= '</div>';
		} elseif (is_bool($i) === true) {
			$label = 'boolean';
			$o .= '<em style="color:#FFD700;">is_' . $label . '</em>';
			if ($i === true) {
				$o .= ' → oTRUE<span><br>';
			} elseif ($i === false) {
				$o .= ' → oFALSE<span><br>';
			}
			$o .= '<em style="color:#D2B48C;">(boolean)</em><br>';
		} elseif (is_object($i)) {
			$o .= '<pre><tt>' . var_export($i, true) . '</tt></pre>';
		} else {
			$o .= print_r($i, true);
		}
		return $o;
	}




	// ◇ ==== abort → Trace & End Program »
	public static function abort($i, $print = true) {
		self::trace($i, $print);
		return exit;
	}





	// ◇ ==== end → End Program »
	public static function end() {
		return exit;
	}




	// ◇ ==== debug → Dump & End Program »
	public static function debug($var) {
		echo var_export($var);
		return exit;
	}




	// ◇ ==== dump • Dump & End Program »
	public static function dump($var) {
		var_dump($var);
		return exit;
	}




	// ◇ ==== image → safely return image filename » string
	public static function image($image, $fallback = 'no-image.png') {
		if (self::noData($image)) {
			return $fallback;
		}
		return $image;
	}




	// ◇ ==== oClass →
	public static function oClass($className, $req) {
		$resolve = [];
		$reflection = new ReflectionClass($className);
		$properties = $reflection->getProperties();
		foreach ($properties as $property) {
			$property->setAccessible(true);
			$resolve['PROPERTY'][$property->getName()] = $property->getValue(new $className);
		}

		$methods = $reflection->getMethods();
		foreach ($methods as $method) {
			$modifier = Reflection::getModifierNames($method->getModifiers());
			$resolve['METHOD'][$method->getName() . '()'] = $modifier[0];
		}

		if (strtoupper($req) === 'PROPERTY') {
			return $resolve['PROPERTY'];
		}

		if (strtoupper($req) === 'METHOD') {
			return $resolve['METHOD'];
		}

		return $resolve;
	}




	// ◇ ==== author → software author » [string]
	public static function author() {
		return Env::property('author.brand') . ' • ' . Env::property('author.handle') . ' • ' . Env::property('author.url');
	}




	// ◇ ==== toJSON → $vars to json » [json]
	public static function toJSON($var) {

		if (self::hasData($var)) {

			if (self::isObject($var)) {
				$var = ObjectX::toArray($var);
			}

			if (self::isArray($var)) {
				$var = ArrayX::toJSON($var);
			}

		}

		return $var;
	}

} //> end of Vars



























// STRING METHODS
// ◇ ==== toArray • string to array »
function StringtoArray($string, $req = 'SPACE', $keys = []) {
	if (!self::isEmpty($string)) {
		if ($req === 'SPACE') {
			$res = explode(' ', $string);
		} else {
			$res = explode($req, $string);
		}
		if (is_array($keys) && !empty($keys)) {
			$res = ArrayX::reKeys($res, $keys);
		}
		if (ArrayX::is($res)) {
			return $res;
		}
	}
	return false;
}




// ◇ ==== toJSON • String to JSON »
function  StringtoJSON($string, $flag = 'SPACE', $keys = []) {
	return ArrayX::toJSON(self::toArray($string, $flag, $keys));
}




// ◇ ==== toObj • string to object »
function  StringtoObj($string, $flag = 'SPACE', $keys = []) {
	return ArrayX::toObj(self::toArray($string, $flag, $keys));
}