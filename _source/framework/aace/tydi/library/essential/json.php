<?php
/* JSON ~ JSON Class » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © January 2023 | Apache License */

class JSON {

	// ◇ ----- CALL • Non-Existent Method » Error
	public function __call($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- CALL_STATIC • Non-Existent Static Method » Error
	public static function __callStatic($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- HANDLER • The Handler »
	public static function handler($data, array $report, $input) {
		// TODO: Improve on this
		if ($report['code'] === JSON_ERROR_NONE) {
			return $data;
		} elseif (VarX::isNotEmpty($report['code'])) {
			return ['error' => $report, 'input' => $input];
		}
		return false;
	}





	// ◇ ----- ENCODE • Encode JSON » Boolean | JSON | Error
	public static function encode($input = '', $flag = 0) {
		if (VarX::isNotEmpty($input)) {
			$data = json_encode($input, $flag);
			$report = ['code' => json_last_error(), 'message' => json_last_error_msg(), 'type' => gettype($input)];
			return self::handler($data, $report, $input);
		}
		return false;
	}





	// ◇ ----- DECODE • Decode JSON/Array » Boolean | Array | Object | Error
	public static function decode($input = '', $flow = 'OBJECT') {
		if (VarX::isNotEmpty($input)) {
			if (ArrayX::is($input)) {
				$input = json_encode($input);
			}

			// ~ Convert json string to Array
			if ($flow === 'ARRAY') {
				$data = json_decode($input, true);
			}

			// ~ Convert json string to Object
			elseif ($flow === 'OBJECT') {
				$data = json_decode($input);
			}

			$report = ['code' => json_last_error(), 'message' => json_last_error_msg(), 'type' => gettype($input)];
			return self::handler($data, $report, $input);
		}
		return false;
	}





	// ◇ ----- IS • Check for JSON » Boolean
	public static function is($input = '') {
		if (StringX::isNotEmpty($input)) {
			json_decode($input);
			$resolve = (json_last_error() === JSON_ERROR_NONE);
			if ($resolve === true || $resolve === 1) {
				return true;
			}
		}
		return false;
	}





	// ◇ ----- OUTPUT • Print JSON » JSON Header
	public static function output($input = '') {
		if (self::is($input)) {
			HeaderX::is(['JSON' => true]);
			if (defined('CORS')) {
				HeaderX::is(['CORS' => CORS]);
			}
			echo $input;
			exit;
		}
		return false;
	}





	// ◇ ----- DISPLAY • Encode & Output JSON » JSON Header
	public static function pretty($input = '') {
		return self::encode($input, JSON_PRETTY_PRINT);
	}





	// ◇ ----- DISPLAY • Encode & Output JSON » JSON Header
	public static function display($input = '') {
		if (!self::is($input)) {
			$input = self::pretty($input);
		}
		return self::output($input);
	}





	// ◇ ----- TO ARRAY • JSON to Array » Boolean | Array
	public static function toArray($input) {
		if (self::is($input)) {
			return json_decode($input, true);
		}
		return false;
	}





	// ◇ ----- TO_OBJ • JSON to Object » Boolean | Array
	public static function toObj($input) {
		if (self::is($input)) {
			return json_decode($input);
		}
		return false;
	}

} // End Of Class ~ JSON