<?php
/* Time ~ Time Class » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © January 2023 | Apache License */

class Time {

	// ◇ ----- CALL • Non-Existent Method » Error
	public function __call($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- CALL_STATIC • Non-Existent Static Method » Error
	public static function __callStatic($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ---- ZONE • Timezone » String | Boolean
	public static function zone($zone = 'DOMESTIC') {
		if (VarX::isNotEmpty($zone)) {
			if ($zone === 'IS') {
				return date_default_timezone_get();
			} elseif ($zone === 'DOMESTIC') {
				return date_default_timezone_set('Africa/Lagos');
			} else {
				$zones = in_array($zone, timezone_identifiers_list());
				if (!$zones) {
					return ErrorX::is(__CLASS__ . ' • ' . __FUNCTION__, 'Invalid Argument', $zone);
				}
				return date_default_timezone_set($zone);
			}
		}
		return false;
	}





	// ◇ ---- IS • ... »
	public static function is($format, $time = '') {
		if (strtoupper($time) === 'NOW' || VarX::isEmpty($time)) {
			$time = time();
		}
		elseif(VarX::stringAcceptable($time) && VarX::isNotNumeric($time)){
			$time = self::stamp($time);
		}

		if ($format === 'GMT') {
			$format = 'P';
		}

		// * SQL Dates
		elseif ($format === 'SQL_DATE') {
			$format = 'Y-m-d';
		} elseif ($format === 'SQL_TIME') {
			$format = 'H:i:s';
		} elseif ($format === 'SQL_DATETIME') {
			$format = 'Y-m-d H:i:s';
		}

		// * Times
		elseif ($format === 'TIME') {
			$format = 'h:i:s A';
		}

		// * Dates
		elseif ($format === 'DATE') {
			$format = 'l, F d, Y';
		} elseif ($format === 'DATETIME') {
			$format = 'l, F d, Y h:i:s A';
		} elseif ($format === 'REPORT') {
			$format = 'd/m/Y h:i:s A';
		} elseif ($format === 'DATER1') {
			$format = 'd/m/Y';
		} elseif ($format === 'DATER2') {
			$format = 'd-m-Y';
		} elseif ($format === 'DATER3') {
			$format = 'd-M-Y';
		} elseif ($format === 'DATER4') {
			$format = 'F d, Y';
		} elseif ($format === 'LETTERA') {
			return date('M j', $time) . '<sup>' . date('S', $time) . '</sup> ' . date('Y', $time);
		} elseif ($format === 'LETTERB') {
			return date('j', $time) . '<sup>' . date('S', $time) . '</sup> ' . date('F, Y', $time);
		} elseif ($format === 'LETTERC') {
			return date('F j', $time) . '<sup>' . date('S', $time) . '</sup> ' . date('Y', $time);
		}

		return date($format, $time);
	}





	// ◇ ---- SQL • ... »
	public static function SQL($format = 'DATETIME', $time = 'NOW') {
		if ($format === 'DATETIME') {
			return self::is('SQL_DATETIME', $time);
		}
	}



















	public static function isValidateDate($date, $format) {
		$obj = DateTime::createFromFormat($format, $date);
		return $obj && $obj->format($format) == $date;
	}







	// ◇ ----- MICRO • ... »
	public static function micro() {
		list($usec, $sec) = explode(" ", microtime());
		return ((float) $usec + (float) $sec);
	}


	#IS_VALID_STAMP •
	public static function isValidStamp($timestamp) {
		$check = (is_int($timestamp) or is_float($timestamp)) ? $timestamp : (string) (int) $timestamp;
		return ($check === $timestamp) and ((int) $timestamp <= PHP_INT_MAX) and ((int) $timestamp >= ~PHP_INT_MAX);
	}


	#IS_VALID_STRING •
	public static function isValidString($string) {
		$stamp = strtotime($string);
		if ($stamp !== false) {
			return self::isValidStamp($stamp);
		}
		return false;
	}


	#STAMP • Create timestamp from string|timestamp
	public static function stamp($string = 'now') {
		if (VarX::isNotEmpty($string)) {
			if (self::isValidStamp($string)) {
				return $string;
			}
			elseif (self::isValidString($string) !== false) {
				return strtotime($string);
			}
		}
		return false;
	}
























	#AGE • Returns age from date of birth in years
	public static function age($i = '') {
		if (!empty($i)) {
			#@TODO ~ make sure input match format (YYYY-MM-DD)
			$time = time();
			$day = date("d", $time);
			$month = date("m", $time);
			$year = date("Y", $time);
			$birthDay = substr($i, 8, 2);
			$birthMonth = substr($i, 5, 2);
			$birthYear = substr($i, 0, 4);
			if ($month < $birthMonth) {
				$subtract = 1;
			} elseif ($month == $birthMonth) {
				if ($day < $birthDay) {
					$subtract = 1;
				} else {
					$subtract = 0;
				}
			} else {
				$subtract = 0;
			}
			return ($year - $birthYear - $subtract);
		}
		return false;
	}


	#SECONDS • Convert seconds to min, hour & day
	public static function seconds($sec, $to = 'Minute') {
		if (!empty($sec) && !empty($to)) {
			if ($to == 'Minute') {
				$o = ($sec / 60);
			}
			if ($to == 'Hour') {
				$o = ($sec / 60) / 60;
			}
			if ($to == 'Day') {
				$o = (($sec / 60) / 60) / 24;
			}
			return $o;
		}
		return false;
	}


	#MINUTES • Convert minutes to seconds, hour & day
	public static function minutes($min, $to = 'Second') {
		if (!empty($min) && !empty($to)) {
			if ($to == 'Second') {
				$o = ($min * 60);
			}
			if ($to == 'Hour') {
				$o = ($min / 60);
			}
			if ($to == 'Day') {
				$o = ($min / 60) / 24;
			}
			return $o;
		}
		return false;
	}


	#HOUR TO • Convert hours to sec, min & day
	public static function hours($hr, $to = 'Day') {
		if (!empty($hr) && !empty($to)) {
			if ($to == 'Second') {
				$o = ($hr * 60) * 60;
			}
			if ($to == 'Minute') {
				$o = $hr * 60;
			}
			if ($to == 'Day') {
				$o = $hr / 24;
			}
			return $o;
		}
		return false;
	}


	#DAY TO • Convert days to sec, min & hours
	public static function days($day, $to = 'Hour') {
		if (!empty($day) && !empty($to)) {
			if ($to == 'Second') {
				$o = (($day * 24) * 60) * 60;
			}
			if ($to == 'Minute') {
				$o = ($day * 24) * 60;
			}
			if ($to == 'Hour') {
				$o = $day * 24;
			}
			return $o;
		}
		return false;
	}


	#DIFFERENCE • Calculate time difference - TODO - upgrade and add features
	public static function difference($past = '', $future = '', $format = '%a days') {
		$past = new DateTime($past);
		$future = new DateTime($future);
		$date = $past->diff($future);
		return $date->format($format);
	}

} // End Of Class ~ Time