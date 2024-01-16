<?php
/* SSL ~ SSL Class » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © January 2023 | Apache License */

class SSL
{

	// ◇ ----- CALL • Non-Existent Method » Error
	public function __call($method, $argument)
	{
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- CALL_STATIC • Non-Existent Static Method » Error
	public static function __callStatic($method, $argument)
	{
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- HTTPS • Check for HTTPS » Boolean
	public static function https()
	{
		$https = 'INACTIVE';
		$port = 'DEFAULT';
		if (!empty($_SERVER['HTTPS'])) {
			$https = $_SERVER['HTTPS'];
		}
		if ($https !== 'INACTIVE') {
			$https == 'ACTIVE';
		}
		if (!empty($_SERVER['SERVER_PORT'])) {
			$port = $_SERVER['SERVER_PORT'];
		}
		if ($https == 'ACTIVE' || $port == 443) {
			return true;
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
			return true;
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
			return true;
		}
		return false;
	}





	// ◇ ----- RUN • Redirect to HTTPS »
	public static function run($url = '', $permanent = false)
	{
		$protocol = self::https() ? 'https' : 'http';
		if ($protocol !== 'https') {
			$res = 'https:#';
			if (!empty($url)) {
				$res .= $url;
			}
			else {
				if (!empty($_SERVER['HTTP_HOST'])) {
					$res .= $_SERVER['HTTP_HOST'];
				}
				if (!empty($_SERVER['REQUEST_URI'])) {
					$res .= $_SERVER['REQUEST_URI'];
				}
			}
			if (filter_var($res, FILTER_VALIDATE_URL) !== false) {
				$_SESSION['oSSL'] = 'IMPOSED';
				if ($permanent === true) {
					header('HTTP/1.1 301 Moved Permanently');
				}
				return Redirect::instant($res);
			}
		}
	}





	// ◇ ----- IMPOSE • Enforce HTTPS »
	public static function impose($enforce = true, $url = '', $permanent = false)
	{
		if ($enforce === true) {
			return self::run($url, $permanent);
		}
		else {
			if (session_status() !== PHP_SESSION_ACTIVE) {
			// TODO: Trigger error [requiring $session->start() call]
			}

			if (empty($_SESSION['oSSL']) || $_SESSION['oSSL'] !== 'IMPOSED') {
				return self::run($url, $permanent);
			}
		}
		return false;
	}

} // End Of Class ~ SSL