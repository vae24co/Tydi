<?php //*** UriX » Tydi™ Framework © 2024 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

namespace Tydi\Spry;

class UriX {

	private static $init = false;
	protected static $uri; # [is, path, query, param]





	// • ==== init → ... »
	public static function init() {
		if (self::$init === false) {
			self::$uri = new \stdClass();
			$uri = $_SERVER['REQUEST_URI'];
			if (!empty($uri)) {
				self::$uri->is = $uri;
				$bits = parse_url($uri);
				if (isset($bits['path'])) {
					self::$uri->path = $bits['path'];
				}
				if (isset($bits['query'])) {
					self::$uri->query = $bits['query'];
					self::$uri->param = [];
					parse_str($bits['query'], self::$uri->param);
				}
			}
			self::$init = true;
		}
		return;
	}





	// • ==== is → ... »
	public static function is() {
		self::init();
		if (isset(self::$uri->is)) {
			return self::$uri->is;
		}
	}

} //> end of UriX