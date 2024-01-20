<?php //*** oRandomX » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

namespace Zero\Spry;

use Illuminate\Support\Str;

class oRandomX {

	// • ==== id → .. » string
	public static function id($num = null) {
		if (is_null($num)) {
			$num = mt_rand(5, 8);
		}
		return Str::random($num);
	}





	// • ==== token → ... » string
	public static function token($num = null) {
		if (is_null($num)) {
			$num = mt_rand(20, 30);
		}
		return Str::random($num);
	}





	// • ==== puid → ... » string
	public static function puid() {
		return Str::random(20);
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

} //> end of oRandomX