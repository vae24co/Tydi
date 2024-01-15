<?php
//*** Link » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//
class Link {

	// ◇ property
	protected static $referrer;
	protected static $platform;




	// ◇ ==== call → handler - undefined method » [error]
	public function __call($method, $argument) {
		return OversightX(__CLASS__, 'method unreachable', $method);
	}




	// ◇ ==== callStatic → handler - undefined static method » [error]
	public static function __callStatic($method, $argument) {
		return OversightX(__CLASS__, 'static method unreachable', $method);
	}




	// ◇ ==== setReferrer →
	public static function setReferrer($referrer = null) {
		if (empty($referrer)) {
			self::$referrer = URLX::referrer();
		} else {
			self::$referrer = $referrer;
		}
		return true;
	}




	// ◇ ==== setPlatform →
	public static function setPlatform($platform = null) {
		if (is_string($platform)) {
			$platform = strtolower($platform);
		}
		if (empty($platform)) {
			$request = HTTPX::param(['ospring', 'oplatform'], 'GET');
			$spring = null;
			$oplatform = null;
			if (isset($request['ospring'])) {
				$ospring = strtolower($request['ospring']);
			}
			if (isset($request['oplatform'])) {
				$oplatform = strtolower($request['oplatform']);
			}
		}
		if ($platform !== 'api' && ($ospring === 'app' || $oplatform === 'app')) {
			$platform = 'app';
		}
		if ($platform !== 'api' && ($ospring === 'api' || $oplatform === 'api')) {
			$platform = 'api';
		}
		if (empty($platform) || ($platform !== 'api' && $platform !== 'app')) {
			$platform = 'site';
		}
		self::$platform = $platform;
		return true;
	}




	// ◇ ==== getPlatform →
	public static function getPlatform() {
		if (empty(self::$platform)) {
			self::setPlatform();
		}
		return self::$platform;
	}




	// ◇ ==== isPlatform →
	public static function isPlatform($platform) {
		if (empty(self::$platform)) {
			self::setPlatform();
		}
		if (strtolower($platform) === strtolower(self::$platform)) {
			return true;
		}
		return false;
	}




	// ◇ ==== isAPI →
	public static function isAPI() {
		return self::isPlatform('API');
	}




	// ◇ ==== isApp →
	public static function isApp() {
		return self::isPlatform('APP');
	}




	// ◇ ==== isSite →
	public static function isSite() {
		return self::isPlatform('SITE');
	}





} //> end of Link