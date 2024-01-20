<?php //*** oInputX » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

namespace Zero\Spry;

use Illuminate\Support\Str;

class oInputX {

	// • ==== is → .... »
	public static function is($input){
		if (oVariableX::isEmail($input)) {
			return 'EMAIL';
		}
		if(oVariableX::isPhone($input)){
			return 'PHONE';
		}
	}





	// • ==== bearerToken → .... »
	public static function bearerToken($flag = 'HEADER', $request = null) {
		if ($request === null) {
			$request = app('request');
		}
		if ($flag === 'HEADER') {
			$token = $request->header('Authorization');
			if (!empty($token) && Str::contains($token, 'Bearer') && strlen($token) > 7) {
				$token = Str::replaceFirst('Bearer ', '', $token);
				return $token;
			}
		}
		return null;
	}





	// • ==== sessionToken → .... »
	public static function sessionToken($flag = 'HEADER',$request = null) {
		if ($request === null) {
			$request = app('request');
		}
		if ($flag === 'HEADER') {
			$token = $request->header('SessionID');
			if (!empty($token) && strlen($token) > 2) {
				return $token;
			}
		}
		return null;
	}





	// • ==== apiKey → .... »
	public static function apiKey($flag = 'HEADER', $request = null) {
		if ($request === null) {
			$request = app('request');
		}
		if ($flag === 'HEADER') {
			$token = $request->header('APIKey');
			if (!empty($token) && strlen($token) > 2) {
				return $token;
			}
		}
		return null;
	}

} //> end of oInputX