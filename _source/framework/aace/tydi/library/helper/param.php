<?php
/*** ParamQ ~ Param Class » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © January 2023 | Apache License ***/

declare(strict_types=1);

class ParamQ {

	// ◇ ----- CALL_STATIC • Non-Existent Static Method » Error
	public static function __callStatic($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- isNot • Param is non existent » STRING | BOOLEAN [false]
	public static function isNot(&$data, $param) {
		$check = false;
		if (VarX::stringAcceptable($param)) {
			if (ArrayX::isNotKey($data, $param)) {
				$check = $param;
			}
		} elseif (VarX::isArray($param)) {
			foreach ($param as $label) {
				if (ArrayX::isNotKey($data, $label)) {
					$check .= $label . ', ';
				}
			}
			if (StringX::contain($check, ',')) {
				$check = trim(StringX::swapLast($check, ','));
			}
		}
		return $check;
	}





	// ◇ ----- isEmpty • Param is empty » STRING | BOOLEAN [false]
	public static function isEmpty(&$data, $param) {
		$check = false;
		if (VarX::stringAcceptable($param)) {
			if (ArrayX::isKeyEmpty($data, $param)) {
				$check = $param;
			}
		} elseif (VarX::isArray($param)) {
			foreach ($param as $label) {
				if (ArrayX::isKeyEmpty($data, $label)) {
					$check .= $label . ', ';
				}
			}
			if (StringX::contain($check, ',')) {
				$check = trim(StringX::swapLast($check, ','));
			}
		}
		return $check;
	}





	// ◇ ----- isNotOrEmpty • Param is empty or non existent » STRING | BOOLEAN [false]
	public static function isNotOrEmpty(&$data, $param) {
		$check = false;
		if (VarX::stringAcceptable($param)) {
			if (ArrayX::isNotKeyOrEmpty($data, $param)) {
				$check = $param;
			}
		} elseif (VarX::isArray($param)) {
			foreach ($param as $label) {
				if (ArrayX::isNotKeyOrEmpty($data, $label)) {
					$check .= $label . ', ';
				}
			}
			if (StringX::contain($check, ',')) {
				$check = trim(StringX::swapLast($check, ','));
			}
		}
		return $check;
	}





	// TODO :: ◇ ----- IS CHECK FILE • ... »
	public static function isFile(&$data, $param) {
		$check = true;
		if (VarX::stringAcceptable($param)) {
			if (VarX::isEmpty($data[$param])) {
				$check .= $param . ', ';
			} else {
				$file = $data[$param];
				if (!is_array($file) || (is_array($file) && (empty($file['size']) || !empty($file['error'])))) {
					$check .= $param . ', ';
				}
			}
		} elseif (VarX::isArray($param)) {
			foreach ($param as $label) {
				if (VarX::isEmpty($data[$label])) {
					$check .= $label . ', ';
				} else {
					$file = $data[$label];
					if (!is_array($file) || (is_array($file) && (empty($file['size']) || !empty($file['error'])))) {
						$check .= $label . ', ';
					}
				}
			}
			if (StringX::contain($check, ',')) {
				$check = trim(StringX::swapLast($check, ','));
			}
		}
		return $check;
	}





	// ◇ ----- isCheck • ... » STRING | BOOLEAN [false | true]
	public static function isCheck($data, $param, $req) {
		if ($req === 'MISSING') {
			return self::isNot($data, $param);
		} elseif ($req === 'EMPTY') {
			return self::isEmpty($data, $param);
		} elseif ($req === 'REQUIRED') {
			return self::isNotOrEmpty($data, $param);
		} elseif ($req === 'FILE') {
			return self::isFile($data, $param);
		}
		return true;
	}





	// ◇ ----- isFound • ... »
	public static function isFound(array $data, $param, $requireOne = false) {
		if (VarX::stringAcceptable($param)) {
			if (ArrayX::isKeyNotEmpty($data, $param)) {
				return true;
			}
		} elseif (VarX::isNotEmptyArray($param)) {
			if ($requireOne === true) {
				foreach ($param as $field) {
					if (ArrayX::isKeyNotEmpty($data, $field)) {
						return true;
					}
				}
			} else {
				foreach ($param as $field) {
					if (ArrayX::isKeyNotEmpty($data, $field)) {
						$found[$field] = true;
					} else {
						$found[$field] = false;
					}
				}
				return $found;
			}
		}
		return false;
	}





	// ◇ ----- verify • ... »
	public static function verify($data, $param, $req = 'REQUIRED') {
		$check = self::isCheck($data, $param, $req);
		if (VarX::hasData($check)) {
			if ($req === 'MISSING') {
				if (StringX::contain($check, ',')) {
					$tasq['message'] = 'Oh!, these parameters (' . $check . ') were not provided';
					$tasq['summary'] = 'Oh!, some parameters were not provided';
				} else {
					$tasq['message'] = 'Oh!, ' . $check . ' parameter was not provided';
					$tasq['summary'] = 'Oh!, a parameter was not provided';
				}
			} elseif ($req === 'EMPTY') {
				if (StringX::contain($check, ',')) {
					$tasq['message'] = 'Oh!, some parameters (' . $check . ') have no input';
					$tasq['summary'] = 'Oh!, some parameters are empty';
				} else {
					$tasq['message'] = 'Oh!, your ' . $check . ' must contain a value';
					$tasq['summary'] = 'Oh!, one parameter has no input';
				}
			} elseif ($req === 'REQUIRED') {
				if (StringX::contain($check, ',')) {
					$tasq['message'] = 'Oh!, some parameters (' . $check . ') are required';
					$tasq['summary'] = 'Oh!, some parameters are required';
				} else {
					$tasq['message'] = 'Oh!, your ' . $check . ' is required';
					$tasq['summary'] = 'Oh!, a parameter is required';
				}
			}
			$tasq['param'] = $check;
			return $tasq;
		}
		return true;
	}

} // End Of Class ~ ParamQ