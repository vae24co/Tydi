<?php //*** oAPIValidateX » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

namespace Zero\Spry;

class oAPIValidateX {

	// • ==== input → validate input » boolean
	public static function input(array $constraint = [], $request) {
		$check = oValidateX::input($constraint, $request);
		if(isset($check['has_error']) && $check['has_error'] === true) {
			oAPIResponseX::precondition($check['message'], 'Precondition Ignored', $check['error']);
			oAPIResponseX::hint('You ignored a required condition within your parameter');
			return false;
		}
		return true;
	}

} //> end of oAPIValidateX