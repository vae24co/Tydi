<?php //*** oVariableX » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

namespace Zero\Spry;

use Illuminate\Support\Collection;

class oVariableX {

	// • ==== is → ... » boolean
	public static function is(&$var = null, $comparison = null, $strickCheck = false) {
		if (is_null($var)) {
			return false;
		}
		if (is_null($comparison)) {
			if ($var === 0) {
				return true;
			}
			if (!empty($var)) {
				return true;
			}
		}
		// TODO: implement code for comparison & strick check
		return false;
	}





	// • ==== isIterable → ... » boolean
	public static function isIterable($var) {
		if (is_iterable($var)) {
			return true;
		}
		return false;
	}





	// • ==== isCollection → ... » boolean
	public static function isCollection($collection) {
		if ($collection instanceof Collection) {
			return true;
		}
		return false;
	}





	// • ==== toCollection → ... » collection | null
	public static function toCollection($var) {
		$collection = Collection::make($var);
		if ($collection instanceof Collection) {
			return $collection;
		}
		return null;
	}





	// • ==== setIfNot → ... » boolean
	public static function setIfNot(&$var, $value) {
		if (!self::is($var)) {
			$var = $value;
			return true;
		}
		return false;
	}





	// • ==== setIf → ... » boolean | value
	public static function setIf($var, &$check, $value = null){
		if (self::is($check)) {
			if(is_null($value)){
				$var = $check;
			}
			else{
				$var = $value;
			}
			return $var;
		}
		return null;
	}





	// • ==== isEmail → ... » boolean
	public static function isEmail($var) {
		return filter_var($var, FILTER_VALIDATE_EMAIL) !== false;
	}





	// • ==== isPhone → ... » boolean
	public static function isPhone($var, $country = 'NGA') {
		if (is_numeric($var) || is_numeric(substr($var, 1))) {
			if ($country === 'NGA') {

				// ~ 09026636728
				if (str_starts_with($var, '0') && strlen($var) === 11) {
					return true;
				}

				// ~ 2349026636728
				if (str_starts_with($var, '234') && strlen($var) === 13) {
					return true;
				}

				// ~ +2349026636728
				if (str_starts_with($var, '+234') && strlen($var) === 14) {
					return true;
				}
			}
		}
		return false;
	}

} //> end of oVariableX