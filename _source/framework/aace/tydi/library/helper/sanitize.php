<?php
/*** SanitizeQ ~ Sanitize Class » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © January 2023 | Apache License ***/

class SanitizeQ {

	// ◇ ----- CALL • Non-Existent Method » Error
	public function __call($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- CALL_STATIC • Non-Existent Static Method » Error
	public static function __callStatic($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	public static function password(string $input, $f = 'INPUT') {
		if ($f === 'INPUT') {
			$input = self::clean($input);
			$input = trim($input);
			$input = CryptX::password($input);
		}
		return $input;
	}


	public static function username(string $input, $f = 'INPUT') {
		if ($f === 'INPUT') {
			$input = self::clean($input);
		}
		return $input;
	}





	public static function name(string $input, $f = 'INPUT') {
		if ($f === 'INPUT') {
			$input = self::clean($input);
		}
		return $input;
	}


	public static function acronym(string $input, $f = 'INPUT') {
		if ($f === 'INPUT') {
			$input = self::clean($input);
		}
		return $input;
	}


	public static function gender($input, $req = 'INPUT') {

		// * Input
		if ($req === 'INPUT') {
			$input = self::clean($input);
			if (is_numeric($input)) {
				if ($input == 2) {
					$gender = 'F';
				}
				if ($input == 1) {
					$gender = 'M';
				}
			} else {
				if (strtoupper($input) === 'FEMALE') {
					$gender = 'F';
				} elseif (strtoupper($input) === 'MALE') {
					$gender = 'M';
				} else {
					$gender = $input;
				}
			}
		}

		// * Output
		elseif ($req === 'OUTPUT') {
			if (is_numeric($input)) {
				if ($input == 2) {
					$gender = 'Female';
				}
				if ($input == 1) {
					$gender = 'Male';
				}
			} else {
				if ($input == 'F') {
					$gender = 'Female';
				} elseif ($input == 'M') {
					$gender = 'Male';
				} else {
					$gender = $input;
				}
			}

		}
		return $gender;
	}


	public static function toName($firstName = '', $lastName = '', $middleName = '') {
		$o = '';
		if (!empty($firstName)) {
			$o .= ' ' . ucwords($firstName);
		}
		if (!empty($middleName)) {
			$o .= ' ' . ucwords($middleName);
		}
		if (!empty($lastName)) {
			$o .= ' ' . ucwords($lastName);
		}
		return trim($o);
	}





	// ◇ ----- TO NAMES •
	public static function toNames($name) {
		$names = explode(' ', $name);
		if (ArrayX::isNotEmpty($names)) {
			$nameIs['firstname'] = ArrayX::firstValue($names);
			unset($names[ArrayX::firstKey($names)]);

			if (count($names) > 0) {
				$nameIs['lastname'] = ArrayX::lastValue($names);
				unset($names[ArrayX::lastKey($names)]);
			}

			if (count($names) > 0) {
				$nameIs['middlename'] = '';
				foreach ($names as $nameO) {
					$nameIs['middlename'] .= $nameO . ' ';
				}
				$nameIs['middlename'] = trim($nameIs['middlename']);
			}
		}
		if (VarX::isNotEmpty($nameIs)) {
			return $nameIs;
		}
		return $name;
	}




	public static function toUsername($username) {
		if (StringX::is($username)) {
			$username = StringX::noSpace($username);
			// TODO: Remove special characters from Username
			$username = StringX::noChar($username, ['_', ':']);
			return strtolower(InputQ::clean($username));
		}
		return false;
	}





	public static function toAcronym($acronym) {
		if (StringX::is($acronym)) {
			$acronym = StringX::noSpace($acronym);
			return strtoupper(InputQ::clean($acronym));
		}
		return false;
	}





	public static function input($input) {
		if (is_array($input)) {
			$sanitizer = ['username', 'email', 'password', 'name', 'acronym', 'gender'];
			foreach ($input as $key => $value) {
				if (in_array($key, $sanitizer)) {
					$o[$key] = self::{$key}($value, 'INPUT');
				} else {
					$o[$key] = self::input($value);
				}
			}
			return $o;
		}
		$input = self::clean($input);
		return $input;
	}





	// ◇ ----- CLEAN •
	public static function clean($data) {
		$tags = CLEAN_STRING;
		if (VarX::isArray($data)) {
			foreach ($data as $key => $value) {
				$clean = preg_replace($tags, '', $value);
				$clean = strip_tags($clean);
				$clean = preg_replace("/&#?[a-z0-9]+;/i", "", $clean);
				$data[$key] = trim($clean);
			}
		}

		if (VarX::stringAcceptable($data)) {
			$data = trim($data);
			$data = preg_replace($tags, '', $data);
			$data = strip_tags($data);
			$data = preg_replace("/&#?[a-z0-9]+;/i", "", $data);
			$data = trim($data);
		}

		return $data;
	}





	// ◇ ----- EMAIL • ... »
	public static function email(string $input, $req = 'INPUT') {
		if ($req === 'INPUT') {
			$input = strtolower(self::clean($input));
		}
		return $input;
	}





	// ◇ ----- IS USERNAME • ... »
	public static function isUsername($input, $req = 'DATA', $option = []) {
		$input = self::username($input, 'INPUT');

		if (ArrayX::isKeyNotEmpty($option, 'reserved')) {
			$reserved = $option['reserved'];
		} else {
			$reserved = ['admin', 'support', 'webmaster'];
		}
		if (ArrayX::isValue($reserved, $input)) {
			return 'username is reserved';
		} else {
			foreach ($reserved as $word) {
				if (StringX::begin(strtolower($input), $word)) {
					return 'username contains a reserved word';
				}
			}
		}

		if (StringX::begin($input, '_')) {
			return 'username must not begin with underscore';
		} elseif (StringX::end($input, '_')) {
			return 'username must not end with underscore';
		}

		$pattern = "/^[A-Z0-9_]+$/i";
		if (!StringX::pattern($input, $pattern, 'IS')) {
			return 'username contains invalid characters';
		}

		if (strlen($input) < 5) {
			return 'username is too short';
		}

		if (!empty($input)) {
			return true;
		}

		return false;
	}





	// ◇ ----- IS EMAIL • ... »
	public static function isEmail($input, $req = 'DATA') {
		$input = self::email($input, 'INPUT');
		if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
			if ($req === 'DATA') {
				return $input;
			}
			return true;
		}
		return false;
	}





	// ◇ ----- IS PHONE • ... »
	public static function isPhone($input, $req = 'DATA') {
		$input = self::clean($input);
		if (is_numeric($input) && strlen($input) < 20) {
			if ($req === 'DATA') {
				return $input;
			}
			return true;
		}
		return false;
	}





	// ◇ ----- IS BIND • ... »
	public static function isBind($input, $req = 'DATA', $length = 70) {
		$input = self::clean($input);
		if (strlen($input) === $length && ctype_alnum($input)) {
			if ($req === 'DATA') {
				return $input;
			}
			return true;
		}
		return false;
	}





	// ◇ ----- IS TOKEN • ... »
	public static function isToken($input, $req = 'DATA', $length = '') {
		$input = self::clean($input);
		if (VarX::isEmpty($length)) {
			$length = 20;
		}
		if (strlen($input) > $length && ctype_alnum($input)) {
			if ($req === 'DATA') {
				return $input;
			}
			return true;
		}
		return false;
	}





	// ◇ ----- TO GENDER •
	public static function toGender($sex, $req) {
		$gender = [
			1 => ['numeric' => '1', 'acronym' => 'M', 'title' => 'male'],
			2 => ['numeric' => '2', 'acronym' => 'F', 'title' => 'female']
		];

		if (VarX::isNotEmpty($sex)) {

			// * Determine Gender
			if (is_numeric($sex)) {
				if ($sex == 1 || $sex == 2) {
					$genderIs = $gender[$sex];
				}
			} elseif (strtoupper($sex) == 'M' || strtoupper($sex) == 'F') {
				switch (strtoupper($sex)) {
					case 'M':
						$genderIs = $gender[1];
						break;

					case 'F':
						$genderIs = $gender[2];
						break;
				}
			} elseif (strtolower($sex) == 'male' || strtolower($sex) == 'female') {
				switch (strtolower($sex)) {
					case 'male':
						$genderIs = $gender[1];
						break;

					case 'female':
						$genderIs = $gender[2];
						break;
				}
			}


			// * Determine Response
			if (VarX::isNotEmpty($genderIs)) {
				if ($req === 'NUMERIC') {
					return $genderIs['numeric'];
				} elseif ($req === 'ACRONYM') {
					return $genderIs['acronym'];
				} elseif ($req === 'TITLE') {
					return $genderIs['title'];
				}
				return $genderIs;
			}
		}

		return false;
	}










} // End Of Class ~ SanitizeQ