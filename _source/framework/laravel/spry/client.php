<?php //*** oClientX » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

namespace Zero\Spry;

use Illuminate\Support\Facades\Http;

class oClientX {

	// • ==== ip → get client ip address » string
	public static function ip() {
		$request = app('request');
		return $request->ip();
	}





	// • ==== isp → get client isp » string | boolean
	public static function ipData($ip = null) {
		$ip = empty($ip) ? self::ip() : $ip;
		$url = "http://ip-api.com/json/" . $ip . '?fields=timezone,country,regionName,city,zip,isp';
		$response = Http::get($url);
		if ($response->successful()) {
			return $response->json();
		}
		return false;
	}





	// • ==== isp → get client isp » string
	public static function isp($ip = null) {
		$ip = empty($ip) ? self::ip() : $ip;
		if ($ip == '127.0.0.1') {
			return 'Localhost';
		}
		$json = self::ipData($ip);
		if (!empty($json)) {
			if (is_array($json)) {
				$jsonData = (object) $json;
			}
			if (!empty($jsonData->isp)) {
				return $jsonData->isp;
			}
		}
		return false;
	}

} //> end of oClientX