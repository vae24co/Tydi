<?php
/*** FormatQ ~ Format Class » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © January 2023 | Apache License ***/

class FormatQ {

	// ◇ ----- CALL • Non-Existent Method » Error
	public function __call($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- CALL_STATIC • Non-Existent Static Method » Error
	public static function __callStatic($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- PLURALIZE • ... » String
	public static function pluralize($count, $string, $plural = null) {
		if (is_numeric($count) && $count > 1) {
			if(VarX::isEmpty($plural)){
				$plural = $string.'s';
			}
			return $plural;
		}
		return $string;
	}

} // End Of Class ~ FormatQ