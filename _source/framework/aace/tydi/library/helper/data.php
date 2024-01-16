<?php
/*** DataQ ~ Data Class » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © January 2023 | Apache License ***/

class DataQ {

	// ◇ ----- CALL • Non-Existent Method » Error
	public function __call($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- CALL_STATIC • Non-Existent Static Method » Error
	public static function __callStatic($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}




	// ◇ ----- EXTRACT • Return a key's value from $paramset or set value to empty string
	public static function extract($paramset, $key) {
		$dataset = [];

		//...If $key is string
		if (VarX::stringAcceptable($key)) {
			if (isset($paramset[$key])) {
				$dataset[$key] = $paramset[$key];
			} else {
				$dataset[$key] = '';
			}
		}
		return $dataset;
	}





	// ◇ ----- FILTER • Return only filtered keys & values from $paramset
	public static function filter($paramset, $filter, $drop = false) {
		$dataset = [];

		//...If $filter is Array
		if (VarX::isArray($filter)) {
			foreach ($filter as $key) {
				$dataset = ArrayX::combine($dataset, self::extract($paramset, $key));
			}
		} else {
			$dataset = self::extract($paramset, $filter);
		}

		//...If $drop is set to UNSET
		if ($drop === 'UNSET') {
			foreach ($dataset as $key => $value) {
				if (!isset($paramset[$key])) {
					unset($dataset[$key]);
				}
			}
		}

		//...If $drop is set to EMPTY
		if (strtoupper($drop) === 'EMPTY') {
			foreach ($dataset as $key => $value) {
				if (VarX::isEmpty($value)) {
					unset($dataset[$key]);
				}
			}
		}

		return $dataset;
	}





	// ◇ ----- POST • Grab post data
	public static function post($filter = '', $drop = false) {
		if (VarX::isNotEmpty($_POST)) {
			if (VarX::isNotEmpty($filter)) {
				return self::filter($_POST, $filter, $drop);
			}
			return $_POST;
		}
		return false;
	}




	// ◇ ----- GET • Grab get data
	public static function get($filter = '', $drop = false) {
		if (VarX::isNotEmpty($_GET)) {
			if (VarX::isNotEmpty($filter)) {
				return self::filter($_GET, $filter, $drop);
			}
			return $_GET;
		}
		return false;
	}





	// ◇ ----- REQUEST • Grab request data
	public static function request($filter = '', $drop = false) {
		if (VarX::isNotEmpty($_REQUEST)) {
			if (VarX::isNotEmpty($filter)) {
				return self::filter($_REQUEST, $filter, $drop);
			}
			return $_REQUEST;
		}
		return false;
	}





	// ◇ ----- SESSION • Grab request data
	public static function session($filter = '', $drop = false) {
		if (VarX::isNotEmpty($_SESSION)) {
			if (VarX::isNotEmpty($filter)) {
				return self::filter($_SESSION, $filter, $drop);
			}
			return $_SESSION;
		}
		return false;
	}





	// ◇ ----- FILE • Grab file data
	public static function file($filter = '', $drop = false) {
		if (VarX::isNotEmpty($_FILES)) {
			if (VarX::isNotEmpty($filter)) {
				return self::filter($_FILES, $filter, $drop);
			}
			return $_FILES;
		}
		return false;
	}






	// ◇ ----- GRAB • Grab data (post/get/request/session)
	public static function grab($input, $filter = '', $drop = false) {
		if (VarX::stringAcceptable($input)) {
			$data = ['POST', 'GET', 'REQUEST', 'SESSION', 'FILE'];
			if (ArrayX::isValue($data, strtoupper($input))) {
				return self::$input($filter, $drop);
			}
		} elseif (VarX::isArray($input)) {
			return self::filter($input, $filter, $drop);
		}
		return false;
	}





	// ◇ ----- COLLECT • Grab value from collection
	public static function collect($collection, $field, $returnValueIfSingleField = false) {
		$data = self::grab($collection, $field);

		if (VarX::isNotEmptyArray($data)) {

			// * Return value if $field is string or single data array
			if (VarX::stringAcceptable($field) && ArrayX::isKey($data, $field)) {
				if ($returnValueIfSingleField) {
					return $data[$field];
				}
				return [$field => $data[$field]];
			}

			// * Return value if $field is single data array
			elseif (VarX::isArray($field) && count($field) === 1) {
				$index = ArrayX::firstValue($field);
				if ($returnValueIfSingleField) {
					return $data[$index];
				}
				return $data;
			}

			// * Return array of values if $field is array
			elseif (VarX::isArray($field)) {
				return $data;
			}
		}
		return false;
	}





	// ◇ ----- STACK • Collect & Drop (Empty) Fields
	public static function stack($collection, $field, $drop = 'EMPTY', $returnValueIfSingleField = false) {
		$data = self::collect($collection, $field, $returnValueIfSingleField);
		if (VarX::isArray($data)) {
			self::drop($data, $drop);
		}
		return $data;
	}





	// ◇ ----- STACK ONE • ...
	public static function stackOne($collection, $field) {
		return self::stack($collection, $field, 'EMPTY', true);
	}






	// ◇ ----- UNBIND • Parameter Unbind
	public static function unbind($dataset, $field = null) {
		if (ArrayX::isNotEmpty($dataset)) {
			if (VarX::hasData($field)) {
				$dataset = self::collect($dataset, $field, false);
			}
			$param = [];
			foreach ($dataset as $key => $data) {
				$key = StringX::cropBegin($key, ':');
				$param[$key] = $data;
			}
			return $param;
		}
		return false;
	}





	// ◇ ----- PARAM •
	// public static function param($dataset, $req) {
	// 	if (ArrayX::isNotEmpty($dataset)) {

	// 		//...If $dataset is multi-dimensional & numeric keys
	// 		if (ArrayX::isMultiAndKeyNumeric($dataset)) {

	// 			// * Re-index dataset if index begins with zero (0)
	// 			$dataset = ArrayX::reKeysNumeric($dataset);

	// 			// * Return $dataset
	// 			if ($req === 'ROW') {
	// 				return $dataset[1];
	// 			} elseif ($req === 'ROWS') {
	// 				return $dataset;
	// 			} elseif ($req === 'COUNT') {
	// 				return count($dataset);
	// 			}
	// 		}

	// 		//...If $dataset is not multi-dimensional & numeric keys
	// 		else {
	// 			// * Return $dataset
	// 			if ($req === 'ROW') {
	// 				return $dataset;
	// 			} elseif ($req === 'ROWS') {
	// 				return [1 => $dataset];
	// 			} elseif ($req === 'COUNT') {
	// 				return 1;
	// 			}
	// 		}

	// 		//...Presumably, $req is a column name
	// 		if (VarX::stringAcceptable($req)) {
	// 			$req = [$req];
	// 		}

	// 		if (ArrayX::isMultiAndKeyNumeric($dataset)) {
	// 			foreach ($dataset as $key => $value) {
	// 				$row = self::grab($value, $req, 'UNSET');
	// 				if (VarX::isNotEmpty($row)) {
	// 					$record[$key] = $row;
	// 				}
	// 			}
	// 			if (VarX::isNotEmpty($record)) {
	// 				return $record;
	// 			}
	// 		}
	// 		return self::grab($dataset, $req, 'UNSET');
	// 	}
	// 	return false;
	// }





	// ◇ ----- TO OBJ • Data to (object)
	public static function to($data, $req) {
		if ($req === 'OBJECT') {
			return ArrayX::toObj($data);
		}
	}














	// ◇ ----- READ •
	public static function read($data) {
		if (VarX::isArray($data)) {
			if (ArrayX::isMultiAndKeyNumeric($data)) {
				foreach ($data as $key => $row) {
					$data[$key] = self::read($row);
				}
			} else {
				foreach ($data as $index => $value) {
					$data[$index] = self::read($value);
					if ($index === 'puid') {
						$data['id'] = $data['puid'];
						unset($data['puid']);
					} elseif ($index === 'tuid') {
						$data['bind'] = $data['tuid'];
						unset($data['tuid']);
					} elseif ($index === 'oauthid') {
						$data['bind'] = $data['oauthid'];
						unset($data['oauthid']);
					} elseif ($index === 'suid') {
						$data['rowid'] = $data['suid'];
						unset($data['suid']);
					} elseif ($index === 'dob') {
						$data['birthdate'] = $data['dob'];
						unset($data['dob']);
					} elseif ($index === 'emblem') {
						$data['media']['display'] = $data['emblem'];
						unset($data['emblem']);
					} elseif ($index === 'dp') {
						$data['media']['display'] = $data['dp'];
						unset($data['dp']);
					} elseif ($index === 'cover') {
						$data['media']['cover'] = $data['cover'];
						unset($data['cover']);
					} elseif ($index === 'cp') {
						$data['media']['cover'] = $data['cp'];
						unset($data['cp']);
					} elseif ($index === 'gender') {
						$data[$index] = ucwords(SanitizeQ::toGender($data[$index], 'TITLE'));
					} elseif ($index === 'firstname' || $index === 'lastname' || $index === 'middlename' || $index === 'fullname') {
						$data[$index] = ucwords($data[$index]);
					}
				}
			}
		}
		if (VarX::isNull($data)) {
			$data = '';
		}
		return $data;
	}





	// ◇ ----- WRITE •
	public static function write($data) {
		if (VarX::isNotEmptyArray($data)) {
			foreach ($data as $field => $value) {
				$data[$field] = SanitizeQ::clean($value);

				if ($field === 'id') {
					$data['puid'] = $value;
					unset($data[$field]);
				}

				if ($field === 'bind') {
					$data['tuid'] = $value;
					unset($data[$field]);
				}

				if ($field === 'rowid') {
					$data['suid'] = $value;
					unset($data[$field]);
				}

				if ($field === 'gender') {
					$data['gender'] = SanitizeQ::gender($value, 'INPUT');
				}

				if ($field === 'birthdate') {
					$data['dob'] = $data['birthdate'];
					unset($data[$field]);
				}


				if ($field === 'name') {
					$names = SanitizeQ::toNames($value);
					$data = array_merge($data, $names);
					unset($data[$field]);
				}

				if ($field === 'fullname') {
					$names = SanitizeQ::toNames($value);
					$data = array_merge($data, $names);
					unset($data[$field]);
				}
			}
		}
		return $data;
	}





	// ◇ ----- IS POSITIVE • Is Data Positive?
	public static function isPositive(&$data) {
		if (VarX::isBoolean($data) && $data === true) {
			return true;
		}

		if (VarX::isNumeric($data) && $data > 0) {
			return true;
		}

		if (VarX::isNotEmptyArray($data)) {
			return true;
		}

		return false;
	}





	// ◇ ----- IS ROW • Is Data one or more Rows?
	public static function isRow(&$data, $field = '') {
		return VarX::row($data, $field);
	}





	// ◇ ----- IS MULTI ROW • Is Data one or more Rows?
	public static function isMultiRow(&$data, $field = '') {
		return VarX::multiRow($data, $field);
	}





	// ◇ ----- IS ROW COLUMN • Check if Data is has one or more rows, and a specific column has value
	public static function isRowColumn($data, $field, $req = 'DATA') {
		if (ArrayX::isMultiAndKeyNumeric($data)) {
			$data = ArrayX::firstValue($data);
		}
		if (self::isRow($data, $field)) {
			if ($req === 'DATA' && VarX::hasData($data[$field])) {
				return true;
			} elseif ($req === 'EMPTY' && VarX::isEmpty($data[$field])) {
				return true;
			} elseif ($req === 'NO_DATA' && VarX::hasNoData($data[$field])) {
				return true;
			} elseif ($req === 'NOT_EMPTY' && VarX::isNotEmpty($data[$field])) {
				return true;
			}
		}
		return false;
	}





	// ◇ ----- IS NO UPDATE •
	public static function isNoUpdate($update) {
		if (VarX::isZero($update) || $update === 'NO_UPDATE') {
			return true;
		}
		return false;
	}





	// ◇ ----- ROW COUNT • Count Rows in array » Numeric
	public static function countRow($data) {
		$count = 0;
		if (ArrayX::isMultiAndKeyNumeric($data)) {
			$count = count($data);
		} elseif (ArrayX::isNotEmpty($data)) {
			$count = 1;
		}
		return $count;
	}





	// ◇ ----- USER ID TO COLUMN • ... »
	public static function userIDToColumn($userid) {
		if (!empty($userid)) {
			if (SanitizeQ::isEmail($userid, 'BOOL')) {
				return ['email' => $userid];
			} elseif (SanitizeQ::isPhone($userid)) {
				return ['phone' => $userid];
			} elseif (SanitizeQ::isBind($userid)) {
				return ['oauthid' => $userid];
			} elseif (SanitizeQ::isToken($userid)) {
				return ['token' => $userid];
			} else {
				return ['username' => $userid];
			}
		}
		return false;
	}





	// ◇ ----- PARAM USER ID • Prepare UserID in Parameter »
	public static function paramUserID($param) {
		if (isset($param['userid'])) {
			$userid = self::userIDToColumn($param['userid']);
			if (!empty($userid) && is_array($userid)) {
				$param = array_merge($param, $userid);
				unset($param['userid']);
			}
		}
		return $param;
	}





	// ◇ ----- EXTRICATE • Extract Param from Data & Return Param »
	public static function extricate(&$data, $param, $req = '') {
		if (VarX::isNotEmptyArray($data)) {
			$resolve = [];
			if (VarX::isArray($param)) {
				foreach ($param as $field) {
					if (ArrayX::isKey($data, $field)) {
						$resolve[$field] = $data[$field];
						unset($data[$field]);
					}
				}
			} elseif (VarX::stringAcceptable($param)) {
				if (ArrayX::isKey($data, $param)) {
					$resolve[$param] = $data[$param];
					unset($data[$param]);
				}
			}

			if ($req === 'VALUE' && count($resolve) === 1) {
				return ArrayX::firstValue($resolve);
			}
			return $resolve;
		}
		return false;
	}





	// ◇ ----- EXTRICATE VALUE • Extract Index from Data & Return Value »
	public static function extricateValue(array &$data, string $key) {
		return self::extricate($data, $key, 'VALUE');
	}





	// ◇ ----- DROP EMPTY • Extract Empty Param from Data & Return Param »
	public static function drop(&$data, $req = 'EMPTY') {
		if (VarX::isNotEmptyArray($data)) {
			// * Drop Empty
			if ($req === 'EMPTY') {
				foreach ($data as $key => $value) {
					if (VarX::isArray($value)) {
						$data[$key] = self::drop($value);
					}
					elseif (VarX::isEmpty($value)) {
						unset($data[$key]);
					}
				}
			}
		}
		return $data;
	}





	// ◇ ----- MERGE •
	public static function merge(&$data, $merger) {
		if (is_array($data) && is_array($merger)) {
			$data = array_merge($data, $merger);
			return $data;
		}
		return false;
	}





	// ◇ ----- FILTER BY ID
	public static function filterID(&$data, $id = ['puid', 'tuid']) {
		return self::extricate($data, $id);
	}





	// ◇ ----- STRIP KEY •
	public static function stripKey(&$data, $filter) {
		$data = ArrayX::stripKey($data, $filter);
		return $data;
	}





	// ◇ ----- FIRST KEY •
	public static function firstKey(&$data) {
		if (VarX::isNotEmptyArray($data)) {
			return ArrayX::firstKey($data);
		} elseif (VarX::stringAcceptable($data)) {
			return $data;
		}
		return false;
	}





	// ◇ ----- STRIP VALUE •
	public static function stripValue(&$data, $filter) {
		$data = ArrayX::stripValue($data, $filter);
		return $data;
	}





	// ◇ ----- FIRST VALUE •
	public static function firstValue(&$data) {
		if (VarX::isNotEmptyArray($data)) {
			return ArrayX::firstValue($data);
		} elseif (VarX::stringAcceptable($data)) {
			return $data;
		}
		return false;
	}





	// ◇ ----- IS FILTER COLUMN •
	public function isFilterColumn($filter, $column) {
		if (ArrayX::isKey($filter, $column)) {
			return true;
		}
		return false;
	}

} // End Of Class ~ DataQ