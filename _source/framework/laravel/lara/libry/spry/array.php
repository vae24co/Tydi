<?php //*** oArrayX » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

namespace Zero\Spry;

class oArrayX {

	// • ==== is → ... » boolean
	public static function is($array) {
		if (is_array($array)) {
			return true;
		}
		return false;
	}





	// • ==== isMultiWithOne → is multi-dimensional with one record »
	public static function isMultiWithOne($array) {
		return is_array($array) && count($array) === 1 && is_array(reset($array));
	}

} //> end of oArrayX