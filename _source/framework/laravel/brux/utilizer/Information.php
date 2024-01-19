<?php
namespace Zero\Utilizer;

use Illuminate\Support\Str;

class Information {

	public static function token($num = null) {
		if (is_null($num)) {
			$num = mt_rand(20, 30);
		}
		return Str::random($num);
	}




	public static function id($num = null) {
		if (is_null($num)) {
			$num = mt_rand(5, 8);
		}
		return Str::random($num);
	}

}