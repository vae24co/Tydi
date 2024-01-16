<?php
/*** SetQ ~ Set Class » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © January 2023 | Apache License ***/

class SetQ {

	// ◇ ----- CALL • Non-Existent Method » Error
	public function __call($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- CALL_STATIC • Non-Existent Static Method » Error
	public static function __callStatic($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- isNullOrEmpty • Set var if its null or empty
	public static function isNullOrEmpty(&$var, $value) {
		if (VarX::isEmpty($var) && VarX::isNotEmpty($value)) {
			$var = $value;
		}
		return true;
	}





	// ◇ ----- isNotKeyOrEmpty • Set array key if it doesn't exist or is empty
	public static function isNotKeyOrEmpty(&$array, $key, $value) {
		if (ArrayX::isNotKeyOrEmpty($array, $key)) {
			$array[$key] = $value;
		}
		return true;
	}





	// ◇ ----- isKeyNotEmptyCopy • ...
	public static function isKeyNotEmptyCopy(&$source, &$destination, $key, $valueCheck = null) {
		if (VarX::isNotEmptyArray($source) && VarX::isArray($destination)) {
			if (VarX::hasData($valueCheck)) {
				if (isset($source[$key]) && $source[$key] == $valueCheck) {
					$destination[$key] = $valueCheck;
				}
			} elseif (ArrayX::isKeyNotEmpty($source, $key)) {
				$destination[$key] = $source[$key];
			}
		}
		return true;
	}





	// ◇ ----- SET KEY • Set a key in an array
	public static function key(&$array, $key, $value) {
		$array[$key] = $value;
		return true;
	}





	// ◇ ----- SWAP KEY • Exchange a key in an array
	public static function keySwap(&$array, $key, $rekey) {
		$array = ArrayX::swapKey($array, $key, $rekey);
		return true;
	}




	// ◇ ----- DROP KEY • Drop a key in an array
	public static function keyDrop(&$array, $key, $value = null) {
		if (isset($array[$key])) {
			if (VarX::hasData($value)) {
				if ($array[$key] == $value) {
					unset($array[$key]);
				}
			} else {
				unset($array[$key]);
			}
		}
		return true;
	}

} // End Of Class ~ SetQ