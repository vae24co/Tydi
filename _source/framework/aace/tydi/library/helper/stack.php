<?php
/*** StackQ ~ Stack Class » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © January 2023 | Apache License ***/

class StackQ {

	// ◇ ----- CALL • Non-Existent Method » Error
	public function __call($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- CALL_STATIC • Non-Existent Static Method » Error
	public static function __callStatic($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- LOGIN •
	public static function login($input) {
		$param = ['verified', 'role', 'kind', 'type', 'flag', 'status', 'retoken', 'puid', 'tuid'];
		return DataQ::stack($input, $param);
	}





	// ◇ ----- REGISTER • ... » ARRAY
	public static function register($input, $param = 'REGISTER') {
		if ($param === 'REGISTER') {
			$param = ['username', 'email', 'phone', 'password', 'kind', 'type', 'role'];
		}
		return DataQ::stack($input, $param);
	}





	// ◇ ----- PROFILE • ... » ARRAY
	public static function profile($input, $param = 'PROFILE') {
		if ($param === 'PROFILE') {
			$param = ['oauthid', 'firstname', 'lastname', 'middlename', 'gender', 'nationality'];
		}
		return DataQ::stack($input, $param);
	}

} // End Of Class ~ StackQ