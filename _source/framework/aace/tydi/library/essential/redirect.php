<?php
/* REDIRECT ~ Redirect Class » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © January 2023 | Apache License */

class Redirect
{

	// ◇ ----- META • Redirect URL (via http-equiv)
	public static function meta($url, $delay = 0, $flag = 'RETURN')
	{
		$res = '<meta http-equiv="refresh" content="' . $delay . '; url=' . $url . '">';
		if ($flag === 'EXIT') {
			exit($res);
		}
		elseif ($flag === 'REDIRECT') {
			echo $res;
		}
		else {
			return $res;
		}
	}





	// ◇ ----- TO • Redirect to URL
	public static function to($url, $delay = 0, $exit = false)
	{
		if (!headers_sent($filename, $linenum)) {
			if ($delay !== false && is_numeric($delay) && !empty($delay)) {
				header('Refresh:' . $delay . ';url=' . $url);
			}
			else {
				header('Location: ' . $url);
			}
			if ($exit !== false) {
				exit();
			}
		}
		else {
			if ($exit !== false) {
				$flag = 'EXIT';
			}
			else {
				$flag = 'REDIRECT';
			}
			if (!empty($delay) && is_int($delay)) {
				return self::meta($url, $delay, $flag);
			}
			return self::meta($url, 0, $flag);
		}
	}





	// ◇  INSTANT • Instantly Redirect to URL
	public static function instant($url)
	{
		return self::to($url, 0, true);
	}

} // End Of Class ~ Redirect