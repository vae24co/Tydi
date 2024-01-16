<?php
/*** VarX ~ Var Class » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © 2023 | Apache License ***/

declare(strict_types=1);

class VarX {

	// ◇ ----- CALL_STATIC • Non-Existent Static Method » Error
	public static function __callStatic($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- IS • $var a defined variable? » Boolean
	public static function is(&$var) {
		return isset($var);
	}





	// ◇ ----- IS NOT • $var not a defined variable? » Boolean
	public static function isNot(&$var) {
		if (!isset($var)) {
			return true;
		}
		return false;
	}





	// ◇ ----- IS NULL • $var a null variable? » Boolean
	public static function isNull(&$var) {
		return is_null($var);
	}





	// ◇ ----- IS NOT NULL • $var not null variable? » Boolean
	public static function isNotNull(&$var) {
		if (!self::isNull($var)) {
			return true;
		}
		return false;
	}





	// ◇ ----- IS_TYPE • $var type or comparison » Boolean | String
	public static function isType(&$var, $comparison = '') {
		if (self::is($var)) {
			if ($comparison !== '') {
				if (strtolower(gettype($var)) !== strtolower($comparison)) {
					return true;
				}
			} else {
				return gettype($var);
			}
		}
		return false;
	}





	// ◇ ----- IS EMPTY • $var is actually empty? » Boolean
	public static function isEmpty(&$var, $type = '') {

		// + If $var does not exist
		if (!self::is($var)) {
			return true;
		}

		// + Set $var type if $var exist
		$varType = self::isType($var);


		// + If $type is empty & $varType is not empty
		if (empty($type) && !empty($varType)) {
			return self::isEmpty($var, $varType);
		}



		// + If $type & $vqrType is not empty
		if (!empty($type) && !empty($varType)) {
			$type = strtolower($type);

			// + Type: Check for string, integer & numeric values
			$stringAcceptable = ['string', 'integer', 'double', 'numeric'];
			if (in_array($type, $stringAcceptable)) {
				if ($varType !== 'array' && $varType !== 'object') {
					$var = (string) $var;
					$var = trim($var);
					if (strlen($var) < 1) {
						return true;
					}
				}
			}


			// + Type: Check for array
			elseif ($type === 'array' && $varType === 'array' && empty($var)) {
				return true;
			}


			// + Type: Check for object
			elseif ($type === 'object' && $varType === 'object' && is_object($var) && (count((array) $var) === 0)) {
				return true;
			}
		}

		return false;
	}





	// ◇ ----- IS_NOT_EMPTY • $var actually not empty? » Boolean
	public static function isNotEmpty(&$var, string $type = '') {
		if (self::isEmpty($var, $type) === false) {
			return true;
		}
		return false;
	}





	// ◇ ----- IS_ZERO • $var value zero? » Boolean
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





	// ◇ ----- IS_NOT_ZERO • $var value not zero? » Boolean
	public static function isNotZero(&$var) {
		if (!self::isZero($var, false)) {
			return true;
		}
		return false;
	}





	// ◇ ----- IS_NOT_TYPE • $var type negative comparison » Boolean | String
	public static function isNotType(&$var, $comparison) {
		if (strtolower(self::isType($var)) !== strtolower($comparison)) {
			return true;
		}
		return false;
	}





	// ◇ ----- IS_STRING • $var type is string » Boolean
	public static function isString(&$var, $allowEmpty = true) {
		if (self::isType($var) === 'string') {
			if (!$allowEmpty && self::isEmpty($var)) {
				return false;
			}
			return true;
		}
		return false;
	}





	// ◇ ----- IS NUMERIC • $var is numeric » Boolean
	public static function isNumeric(&$var) {
		if (self::is($var) && is_numeric($var)) {
			return true;
		}
		return false;
	}





	// ◇ ----- IS NOT NUMERIC • $var is not numeric » Boolean
	public static function isNotNumeric(&$var) {
		if (!self::isNumeric($var)) {
			return true;
		}
		return false;
	}





	// ◇ ----- IS BOOLEAN • $var type is boolean » Boolean
	public static function isBoolean(&$var) {
		if (self::is($var) && is_bool($var)) {
			return true;
		}
		return false;
	}





	// ◇ ----- IS NOT BOOLEAN • $var type is not boolean » Boolean
	public static function isNotBoolean(&$var) {
		if (!self::isBoolean($var)) {
			return true;
		}
		return false;
	}





	// ◇ ----- IS ARRAY • $var type is array » Boolean
	public static function isArray(&$var) {
		if (self::is($var) && is_array($var)) {
			return true;
		}
		return false;
	}





	// ◇ ----- IS_NOT_ARRAY • $var type is not array » Boolean
	public static function isNotArray(&$var) {
		if (!self::isArray($var)) {
			return true;
		}
		return false;
	}





	// ◇ ----- IS_OBJECT • $var type is object » Boolean
	public static function isObject(&$var) {
		if (self::is($var) && is_object($var)) {
			return true;
		}
		return false;
	}





	// ◇ ----- IS_NOT_OBJECT • $var type is not object » Boolean
	public static function isNotObject(&$var) {
		if (!self::isObject($var)) {
			return true;
		}
		return false;
	}




	// ◇ ----- IS_JSON • $var type is json » Boolean
	public static function isJSON(&$var) {
		if (self::is($var) && JSON::is($var)) {
			return true;
		}
		return false;
	}





	// ◇ ----- IS_NOT_JSON • $var type is not json » Boolean
	public static function isNotJSON(&$var) {
		if (!self::isJSON($var)) {
			return true;
		}
		return false;
	}





	// ◇ ----- IS TRUE • $var type is boolean [true]? » Boolean
	public static function isTrue(&$var) {
		if (self::is($var) && $var === true) {
			return true;
		}
		return false;
	}





	// ◇ ----- IS FALSE • $var type is boolean [false]? » Boolean
	public static function isFalse(&$var) {
		if (self::is($var) && $var === false) {
			return true;
		}
		return false;
	}





	// ◇ ----- IS COUNT • $var is count? » Number
	public static function isCount(&$var, $mode = COUNT_NORMAL) {
		$count = 0;
		if (is_countable($var)) {
			$count = count($var, $mode); #NOTE: $mode [COUNT_NORMAL|COUNT_RECURSIVE]
		}
		return $count;
	}





	// ◇ ----- HAS DATA • $var contains data? » Boolean
	public static function hasData(&$var) {
		if (VarX::isNotBoolean($var) && VarX::isNotEmpty($var)) {
			return true;
		}
		return false;
	}





	// ◇ ----- HAS NO DATA • $var contains no data? » Boolean
	public static function hasNoData(&$var) {
		if (!self::hasData($var)) {
			return true;
		}
		return false;
	}





	// ◇ ----- IS EMPTY ARRAY • $var is an empty array? » Boolean
	public static function isEmptyArray(&$var) {
		if (self::hasNoData($var) && self::isArray($var)) {
			return true;
		}
		return false;
	}





	// ◇ ----- IS NOT EMPTY ARRAY • $var is not an empty array? » Boolean
	public static function isNotEmptyArray(&$var) {
		if (self::hasData($var) && self::isArray($var)) {
			return true;
		}
		return false;
	}





	// ◇ ----- STRING_ACCEPTABLE • $var acceptable as string » Boolean
	public static function stringAcceptable(&$var) {
		if (self::is($var)) {
			$varType = strtolower(self::isType($var));
			$stringAcceptable = ['string', 'integer', 'double'];
			if (in_array($varType, $stringAcceptable)) {
				return true;
			}
		}
		return false;
	}





	// ◇ ----- ROW • ... » Boolean
	public static function row(&$record, $field = '') {
		if (self::isNotEmptyArray($record)) {
			if (self::hasData($field)) {
				if (ArrayX::isKey($record, $field)) {
					return true;
				}
			} else {
				return true;
			}
		}
		return false;
	}





	// ◇ ----- MULTI ROW • ... » Boolean
	public static function multiRow(&$record, $field = '') {
		if (ArrayX::isMultiAndKeyNumeric($record)) {
			$firstRow = ArrayX::firstValue($record);
			return self::row($firstRow, $field);
		}
		return false;
	}





	// ◇ ----- SAY • Safely echo a variable » Echo
	public static function say(&$var, $key = null) {

		if (self::isArray($var)) {
			if (self::hasData($key) && isset($var[$key])) {
				$output = $var[$key];
			}
		} elseif (self::isObject($var)) {
			if (self::hasData($key) && isset($var->$key)) {
				$output = $var->$key;
			}
		} elseif (self::stringAcceptable($var)) {
			$output = $var;
		}

		if (self::stringAcceptable($output)) {
			return $output;
		}

		return '';
	}

} // End Of Class ~ VarX