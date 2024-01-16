<?php
/*** ColumnQ ~ Column Class » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © January 2023 | Apache License ***/

class ColumnQ {


	// ◇ ----- CALL_STATIC • Non-Existent Static Method » Error
	public static function __callStatic($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- USER •
	public static function user($column) {
		if ($column === 'AUTH') {
			$column = ['puid', 'tuid', 'suid', 'luid', 'phone', 'username', 'email', 'password', 'verifiedEmail', 'verifiedPhone', 'verified', 'type', 'status', 'flag', 'kind', 'lastseen', 'saas', 'otp'];
		} elseif ($column === 'PROFILE') {
			$column = ['puid', 'tuid', 'suid', 'luid', 'brand', 'firstname', 'lastname', 'middlename', 'dob', 'gender', 'relationship', 'nationality', 'living', 'bio', 'dp', 'cp'];
		} elseif ($column === 'USER') {
			$column = [
				'puid', 'tuid', 'suid', 'luid',
				'phone', 'username', 'email', 'password',
				'verifiedEmail', 'verifiedPhone', 'verified', 'type', 'status', 'flag', 'kind', 'lastseen', 'saas', 'otp',
				'brand', 'firstname', 'lastname', 'middlename', 'dob', 'gender', 'relationship', 'nationality', 'living', 'bio', 'dp', 'cp'
			];
		}
		return $column;
	}

} // End Of Class ~ ColumnQ