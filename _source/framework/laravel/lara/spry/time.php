<?php //*** oTimeX » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

namespace Zero\Spry;

use Illuminate\Support\Str;

class oTimeX {

	// • ==== human → human readable » string
	public static function human($datetime) {
		$time = date('F j, Y g:i A', strtotime($datetime));
		return $time;
	}

} //> end of oTimeX