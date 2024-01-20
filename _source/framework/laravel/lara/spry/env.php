<?php //*** oEnvX » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

namespace Zero\Spry;


class oEnvX {

	// • ==== retrieve →... »
	public static function retrieve(string $key) {
		if (strpos($key, "ENV_") === 0 && strlen($key) > 4) {
			$env = substr($key, 4);
			$key = env($env);
		}
		return $key;
	}

} //> end of oEnvX