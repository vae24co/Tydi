<?php //*** oRequestX » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

namespace Zero\Spry;

// use Illuminate\Http\Request;
use Zero\Spry\oDebugX;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class oRequestX {

	// • ==== restrictMethodTo → ... »
	public static function restrictMethodTo($method) {
		$httpMethod = app('request')->method();
		if (strtoupper($httpMethod) !== strtoupper($method)) {
			throw new MethodNotAllowedHttpException([$method]);
		}
		return;
	}

} //> end of oRequestX