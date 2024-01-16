<?php
//*** FuseX - The Fuse » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//
class FuseX {

	// ◇ property
	public static $url;
	public static $domain;
	public static $protocol;
	public static $host;
	public static $fuses;

	private static $directory;




	// ◇ ==== init
	private static function init() {
		self::$url = URLX::getBase();
		self::$domain = URLX::getDomain();
		self::$protocol = URLX::getProtocol();
		self::$host = StringX::cropBegin(self::$url, self::$protocol);
		self::$fuses = [];
		if (defined('HOST') && !empty(HOST)) {
			self::$fuses = HOST;
		}
	}




	// ◇ ==== ignite →
	public static function ignite() {
		self::init();
		if (!empty(self::$fuses)) {
			if (in_array(self::$domain, self::$fuses)) {
				$path = array_search(self::$domain, self::$fuses);
			} else {
				$subdomain = StringX::before(self::$domain, '.');
				if (!empty($subdomain) && array_key_exists(strtoupper($subdomain), self::$fuses)) {
					$path = $subdomain;
				}
			}
		}
		if (!empty($path)) {
			self::$directory = strtolower($path) . DS;
		} else {
			self::$directory = 'zero' . DS;
		}
		return true;
	}




	// ◇ ==== getPD → get project directory
	public static function getPD($prepend = MD['ORIG']) {
		if (!empty($prepend)) {
			if (is_dir($prepend) && !is_file($prepend)) {
				$fuse = $prepend . self::$directory;
				if (!is_dir($fuse)) {
					mkdir($fuse, 0777, true);
				}
				return $fuse;
			} else {
				return OversightX('Fuse', 'Directory Unavailable!', $prepend);
			}
		}
		return self::$directory;
	}

} //> end of FuseX