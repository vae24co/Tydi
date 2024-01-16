<?php
/*** MathQ ~ Math Class » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © January 2023 | Apache License ***/

class MathQ {

	// ◇ ----- CALL • Non-Existent Method » Error
	public function __call($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- CALL_STATIC • Non-Existent Static Method » Error
	public static function __callStatic($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- IS EVEN • Check if number is Even » Boolean
	public static function isEven($number) {
		if ($number % 2 == 0) {
			return true;
		}
		return false;
	}





	// ◇ ----- IS ODD • Check if number is Odd » Boolean
	public static function isOdd($number) {
		if (!self::isEven($number)) {
			return true;
		}
		return false;
	}

} // End Of Class ~ MathQ