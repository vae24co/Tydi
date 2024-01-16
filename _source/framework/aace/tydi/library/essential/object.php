<?php
/*** ObjectX ~ Object Class » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © January 2023 | Apache License ***/

class ObjectX {

	// ◇ ----- CALL • Non-Existent Method » Error
	public function __call($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- CALL_STATIC • Non-Existent Static Method » Error
	public static function __callStatic($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- TO • $var to Object? » Object
	public static function to($var) {
		if (ArrayX::is($var)) {
			$var = ArrayX::toObj($var);
		} elseif (JSON::is($var)) {
			$var = JSON::toObj($var);
		}
		return $var;
	}





	// ◇ ----- IS • $var an Object? » Boolean
	public static function is(&$var) {
		if (is_object($var)) {
			return true;
		}
		return false;
	}





	// ◇ ----- IS_EMPTY • $var an Empty Object? » Boolean
	public static function isEmpty($var) {
		if (self::is($var) && empty(get_object_vars($var))) {
			return true;
		}
		return false;
	}





	// ◇ ----- IS_NOT_EMPTY • $var a Not-Empty Object? » Boolean
	public static function isNotEmpty($var) {
		if (self::is($var) && !empty(get_object_vars($var))) {
			return true;
		}
		return false;
	}





	// ◇ ----- IS_KEY • $key a property of Object? » Boolean
	public static function isKey($obj, $key) {
		if (self::is($obj) && isset($obj->$key)) {
			return true;
		}
		return false;
	}





	// ◇ ----- IS_NOT_KEY • $key Not a property of Object? » Boolean
	public static function isNotKey($obj, $key) {
		if (self::is($obj) && !isset($obj->$key)) {
			return true;
		}
		return false;
	}





	// ◇ ----- IS_KEY_Empty • Property of Object, Empty? » Boolean
	public static function isKeyEmpty($obj, $key) {
		if (self::isKey($obj, $key) && VarX::isEmpty($obj->$key)) {
			return true;
		}
		return false;
	}





	// ◇ ----- IS_KEY_Empty • Property of Object, Not-Empty? » Boolean
	public static function isKeyNotEmpty($obj, $key) {
		if (self::isKey($obj, $key) && VarX::isNotEmpty($obj->$key)) {
			return true;
		}
		return false;
	}





	// ◇ ----- MAKE • Create Object from $var (string, array) » Object
	public static function make($var = '') {
		if (VarX::isEmpty($var)) {
			$var = (object) [];
		} elseif (StringX::isNotEmpty($var)) {
			$var = ArrayX::toObj(['key' => $var]);
		} elseif (ArrayX::isNotEmpty($var)) {
			$var = ArrayX::toObj($var);
		} elseif (JSON::isNotEmpty($var)) {
			$var = JSON::toObj($var);
		}
		return $var;
	}





	// ◇ ----- COMBINE • Combine object » Object
	public static function combine(...$var) {
		$array = [];
		foreach ($var as $val) {
			if (self::is($val)) {
				$val = self::toArray($val);
			}
			$array = array_merge($array, $val);
		}
		return ArrayX::toObj($array);
	}





	// ◇ ----- TO_ARRAY • Convert object to array » Boolean [false] | Array
	public static function toArray($var) {
		if (self::is($var)) {
			foreach ($var as $key => $value) {
				$array[$key] = $value;
			}
		}
		return false;
	}

} // End Of Class ~ ObjectX