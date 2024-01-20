<?php //*** RandomX » Tydi™ Framework © 2024 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

class RandomX {

	// • ==== call → handler - undefined method » error
	public function __call($method, $argument) {
		$caller = __CLASS__ . '→' . $method . '()';
		return DebugX::oversight(__CLASS__, 'Method Unreachable', $caller);
	}





	// • ==== callStatic → handler - undefined static method » error
	public static function __callStatic($method, $argument) {
		$caller = __CLASS__ . '::' . $method . '()';
		return DebugX::oversight(__CLASS__, 'Static: Method Unreachable', $caller);
	}





	// • ==== length • Randomize Length »
	public static function length($max = 100, $min = 1) {
		return mt_rand($min, $max);
	}





	// • ==== initString • Randomize String »
	public static function initString($string, $length = 'AUTO') {
		$string = str_shuffle($string);
		if ($length === 'AUTO' || $length == 'ALL') {
			return $string;
		} elseif (is_numeric($length)) {
			$isLength = strlen($string);
			if ($length <= $isLength) {
				return substr($string, 0, $length);
			} else {
				$count = $length - $isLength;
				return $string . self::initString($string, $count);
			}
		}

		return false;
	}





	// • ==== initArray • Randomize Array »
	public static function initArray($array, $length = 'AUTO') {
		shuffle($array);
		$string = '';
		foreach ($array as $value) {
			$string .= $value;
		}
		return self::initString($string, $length);
	}





	// • ==== initialize • Initialize Randomization »
	public static function initialize($input, $length = 'AUTO') {
		if (!empty($input)) {
			if (is_array($input)) {
				return self::initArray($input, $length);
			} else {
				return self::initString($input, $length);
			}
		}
		return false;
	}





	// • ==== digit • Generate Numbers »
	public static function digit($length = 4) {
		return self::initialize('1234567890', $length);
	}





	// • ==== pin • Generate PIN »
	public static function pin($length = 5) {
		return self::digit($length);
	}





	// • ==== alpha • Generate Alphabet »
	public static function alpha($length = 4, $case = 'AUTO') {
		if ($case === 'LOWERCASE') {
			$alpha = range('a', 'z');
			shuffle($alpha);
		} elseif ($case === 'UPPERCASE') {
			$alpha = range('A', 'Z');
			shuffle($alpha);
		} else {
			$alpha = array_merge(range('a', 'z'), range('A', 'Z'));
			shuffle($alpha);
		}
		return self::initialize($alpha, $length);
	}





	// • ==== alphanumeric • Generate Alpha-Numeric »
	public static function alphanumeric($length = 4, $case = 'AUTO') {
		$alpha = self::alpha($length, $case);
		$digit = self::digit($length);
		return self::initialize($alpha . $digit, $length);
	}





	// • ==== char • Generate Special Character »
	public static function char($length = 1) {
		return self::initialize('(_=@#$[%{&*?)]!}', $length);
	}





	// • ==== uid • Generate Unique ID »
	public static function uid() {
		$lower = self::alpha('AUTO', 'LOWERCASE');
		$upper = self::alpha('AUTO', 'UPPERCASE');
		$digit = self::digit('AUTO');
		$time = time();
		$rand = mt_rand();
		$o = $rand . $lower . $digit . $upper . $time;
		return str_shuffle($o);
	}





	// • ==== ruid • Random Unique ID »
	public static function ruid($length = 10) {
		return substr(self::uid(), 0, $length);
	}





	// • ==== puid • Primary Unique ID »
	public static function puid($length = 20) {
		return substr(self::uid(), 0, $length);
	}





	// • ==== suid • Secondary Unique ID »
	public static function suid($length = 40) {
		return substr(self::uid(), 0, $length);
	}





	// • ==== tuid • Tertiary Unique ID »
	public static function tuid($length = 70) {
		return substr(self::uid(), 0, $length);
	}





	// • ==== luid • Log Unique ID »
	public static function luid($length = 50) {
		return substr(self::uid(), 0, $length);
	}





	// • ==== filename • Generate Unique Filename »
	public static function filename($length = 20, $case = 'AUTO') {
		return self::alphanumeric($length, $case);
	}





	// • ==== username • Generate Unique Username »
	public static function username($length = 'AUTO') {
		if ($length == 'AUTO') {
			$o = self::alpha(8, 'LOWERCASE') . self::digit(4);
		} else {
			$o = self::alpha($length, 'LOWERCASE');
		}
		return $o;
	}





	// • ==== simple • Generate Simple Randomization »
	public static function simple() {
		$alpha = chr(rand() > 0.5 ? rand(65, 90) : rand(97, 122));
		return $alpha . mt_rand(100, 999) . date('sdm') . mt_rand(10, 99) . self::alpha(3);
	}





	// • ==== TEN • Generate 10 Characters »
	public static function ten($flag = 'AUTO') {
		return self::digit(8) . self::alpha(2, $flag);
	}





	// • ==== BAN • Generate Bank Account Number »
	public static function ban() {
		return mt_rand(1000000000, 9999999999);
	}





	// • ==== TOKEN (50 Alphanumeric Characters)
	public static function token($length = 'RAND') {
		if ($length === 'RAND') {
			$length = mt_rand(20, 30);
		}
		return substr(self::uid(), 0, $length);
	}





	// • ==== KEY (20 Alphanumeric Characters)
	public static function key($length = 20) {
		return substr(self::uid(), 0, $length);
	}





	// • ==== PASSWORD (20 Alphanumeric Characters)
	public static function password($length = 12) {

		if (MathQ::isEven($length)) {
			$A = self::length($length / 2);
		} else {
			$A = self::length(($length - 1) / 2);
		}
		$partA = substr(self::uid(), 0, $A);

		$B = self::length(2);
		$partB = self::initialize('(=_@#[{*)]}', $B);


		$lengthNow = $A + $B;
		if ($length > $lengthNow) {
			$length = $length - $lengthNow;
		}

		$partC = self::alphanumeric($length);

		return $partA . $partB . $partC;
	}





	// • ==== GUID
	public static function guid() {
		$resolve['puid'] = self::puid();
		$resolve['suid'] = self::suid();
		$resolve['tuid'] = self::tuid();
		$resolve['token'] = self::token();
		return $resolve;
	}





	// • ==== WORD
	public static function word(array $words, $number = 1) {
		shuffle($words);
		$max = count($words);
		$key = mt_rand(0, $max);
		if ($key == $max) {
			$index = $key - 1;
		} else {
			$index = $key;
		}
		if ($number === 1) {
			return $words[$index];
		}
	}





	// • ==== otp → ... » string
	public static function otp($num = 6) {
		$pin = '';
		$digits = range(0, 9);
		shuffle($digits);
		for ($i = 0; $i < $num; $i++) {
			$pin .= $digits[$i];
		}
		return $pin;
	}





	// • ==== id → .. » string
	public static function id($num = null) {
		if (is_null($num)) {
			$num = mt_rand(5, 8);
		}
		return self::alphanumeric($num);
	}

} //> end of RandomX