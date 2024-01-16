<?php
/*** HeaderX ~ Header Class » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © January 2023 | Apache License ***/

class HeaderX {

	// ◇ ----- IS • ... »
	public static function is($header = []) {

		if (ArrayX::isKey($header, 'JSON')) {
			header('Content-Type: application/json');
		}

		if (ArrayX::isKeyNotEmpty($header, 'CORS')) {
			$cors = $header['CORS'];
			header('Access-Control-Allow-Origin: ' . $cors, true);
			header('Content-Type: application/json');
			header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE');
			header('Access-Control-Allow-Headers: *');
			#header('Access-Control-Allow-Headers: Content-Type, x-requested-with');
			header('Access-Control-Max-Age: 85200');
			header('Access-Control-Allow-Credentials: true');
		}

	}


} // End Of Class ~ HeaderX