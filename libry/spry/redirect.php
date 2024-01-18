<?php //*** RedirectX » Tydi™ Framework © 2024 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

class RedirectX {

	// • ==== call → handler - undefined method » error
	public function __call($method, $argument) {
		$caller = __CLASS__ . '→' . $method . '()';
		return DebugX::oversight(__CLASS__, 'method unreachable', $caller);
	}





	// • ==== callStatic → handler - undefined static method » error
	public static function __callStatic($method, $argument) {
		$caller = __CLASS__ . '::' . $method . '()';
		return DebugX::oversight(__CLASS__, 'static: method unreachable', $caller);
	}





	// • ==== prepare → ... »
	private static function prepare($url) {
		// if (!StringX::begin($url, 'http') && !StringX::contain($url, '://')) {
		// 	if (StringX::begin($url, PS)) {
		// 		$url = URLX::getBase() . $url;
		// 	} else {
		// 		$url = URLX::getBase() . PS . $url;
		// 	}
		// }
		return $url;
	}




	// • ==== handler → ... »
	private static function handler($redirect, $instruction = 'return') {
		$instruction = strtolower($instruction);
		if ($instruction === 'exit') {
			exit($redirect);
		} elseif ($instruction === 'redirect') {
			echo $redirect;
			return;
		}
		return $redirect;
	}





	// • ==== meta → redirect to url (via http-equiv)
	public static function meta($url, $delay = 0, $instruction = 'return') {
		$redirect = '<meta http-equiv="refresh" content="' . $delay . '; url=' . $url . '">';
		return self::handler($redirect, $instruction);
	}





	// • ==== refresh → ...»
	public static function refresh($url, $delay = 0, $instruction = 'exit') {
		header('Refresh:' . $delay . ';url=' . $url);
		if ($instruction === 'exit') {
			exit;
		}
		return;
	}





	// • ==== afterHeader → ...»
	public static function afterHeader($url, $delay = 0, $instruction = 'redirect') {
		if (!empty($delay) && is_int($delay)) {
			return self::meta($url, $delay, $instruction);
		}
		return self::meta($url, 0, $instruction);
	}




	// • ==== beforeHeader → ...»
	public static function beforeHeader($url, $delay = 0, $instruction = 'exit') {
		if ($delay !== false && is_numeric($delay) && !empty($delay)) {
			return self::refresh($url, $delay, $instruction);
		} else {
			$url = self::prepare($url);
			if ($url !== UrlX::withParam()) {
				header('Location: ' . $url);
				exit;
			}
		}
		return;
	}





	// • ==== redirect → redirect to url
	public static function redirect($url, $delay = 0, $instruction = 'redirect') {
		if (!headers_sent($filename, $linenum)) {
			return self::beforeHeader($url, $delay, $instruction);
		} else {
			return self::afterHeader($url, $delay, $instruction);
		}
	}




	// • ==== now → instantly redirect to url
	public static function now($url) {
		return self::redirect($url, 0, 'exit');
	}




	// • ==== html → redirecting to url
	public static function html($url, $delay = 1, $instruction = 'redirect', $message = null) {
		if (is_null($message)) {
			$message = '<div class="accent accent-notice">';
			$message .= '<p class="accent-message">';
			$message .= '<strong>Redirecting</strong> → <a href="' . $url . '">' . $url . '</a>';
			$message .= '</p></div>' . "\n\r";
		}
		echo $message;
		return self::meta($url, $delay, $instruction);
	}




	// ◇ ==== http → automatic url redirect triggered by http »
	// TODO:: Check code for implementation
	public static function http($delay = 0) {
		if (isset($_REQUEST['redirect'])) {
			$redirect = urldecode($_REQUEST['redirect']);
			if (StringX::isNotEmpty($redirect)) {
				if (StringX::begin($redirect, 'https:/')) {
					$redirect = StringX::cropBegin($redirect, 'https://');
					$redirect = StringX::cropBegin($redirect, 'https:/');
					$redirect = 'https://' . $redirect;
				} elseif (StringX::begin($redirect, 'http:/')) {
					$redirect = StringX::cropBegin($redirect, 'http://');
					$redirect = StringX::cropBegin($redirect, 'http:/');
					$redirect = 'http://' . $redirect;
				} else {
					$redirect = URLX::getBase() . PS . $redirect;
				}
				return self::to($redirect, $delay, true);
			}
		}
		return false;
	}




	// ◇ ==== secure → redirect to secured url
	// TODO:: Check code for implementation
	public static function secure($url = null) {
		if (strtolower(Link::property('platform')) !== 'api') {
			if (!URLX::isSecure($url)) {
				if (empty($url)) {
					$secureURL = URLX::to('SELF', 'SECURE');
				} else {
					$secureURL = URLX::to($url, 'SECURE');
				}
				self::html($secureURL);
			}
		}
		return true;
	}

} //> end of RedirectX