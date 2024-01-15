<?php
//*** RedirectX » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//
class RedirectX {

	// ◇ ==== call → handler - undefined method » [error]
	public function __call($method, $argument) {
		return OversightX(__CLASS__, 'method unreachable', $method);
	}




	// ◇ ==== callStatic → handler - undefined static method » [error]
	public static function __callStatic($method, $argument) {
		return OversightX(__CLASS__, 'static method unreachable', $method);
	}




	// ◇ ==== meta → redirect to url (via http-equiv)
	public static function meta($url, $delay = 0, $flag = 'RETURN') {
		$res = '<meta http-equiv="refresh" content="' . $delay . '; url=' . $url . '">';
		if ($flag === 'EXIT') {
			exit($res);
		} elseif ($flag === 'REDIRECT') {
			echo $res;
		} else {
			return $res;
		}
	}




	// ◇ ==== to → redirect to url
	public static function to($url, $delay = 0, $exit = false) {
		if (!headers_sent($filename, $linenum)) {
			if ($delay !== false && is_numeric($delay) && !empty($delay)) {
				header('Refresh:' . $delay . ';url=' . $url);
			} else {
				$current = URLX::get();
				if (!StringX::begin($url, 'http') && !StringX::contain($url, '://')) {
					if (StringX::begin($url, PS)) {
						$url = URLX::getBase() . $url;
					} else {
						$url = URLX::getBase() . PS . $url;
					}
				}
				if ($url !== $current) {
					header('Location: ' . $url);
					if ($exit !== false) {
						exit();
					}
				}
			}
		} else {
			if ($exit !== false) {
				$flag = 'EXIT';
			} else {
				$flag = 'REDIRECT';
			}
			if (!empty($delay) && is_int($delay)) {
				return self::meta($url, $delay, $flag);
			}
			return self::meta($url, 0, $flag);
		}
	}




	// ◇ ==== instant → instantly redirect to url
	public static function instant($url) {
		return self::to($url, 0, true);
	}




	// ◇ ==== html → redirecting to url
	public static function html($link, $delay = 1, $message = 'AUTO', $action = 'EXIT') {
		if ($message === 'AUTO') {
			echo '<div class="accent accent-notice"><p class="accent-message"><strong>Redirecting</strong> → <a href="' . $link . '">' . $link . '</a></p></div>' . "\n\r";
		}
		self::meta($link, $delay, $action);
	}




	// ◇ ==== http → automatic url redirect triggered by http »
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