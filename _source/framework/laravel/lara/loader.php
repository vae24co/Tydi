<?php //*** LoaderX » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//
class LoaderX {

	// ◇ ==== properties
	protected static $map = [];




	// ◇ ==== register →
	public static function register() {
		spl_autoload_register([self::class, 'load']);
	}




	// ◇ ==== load →
	public static function load($name) {
		$path = self::file($name);
		if ($path !== null) {
			require $path;
		}
	}




	// ◇ ==== file →
	protected static function file($name, $path = __DIR__) {
		$name = ltrim($name, '\\');
		if (isset(self::$map[$name])) {
			if (!empty($directory) && is_dir($directory)) {
				return $directory . DIRECTORY_SEPARATOR . self::$map[$name];
			}
			return self::$map[$name];
		}
		return null;
	}




	// ◇ ==== config →
	public static function config(array $map) {
		self::$map = array_merge(self::$map, $map);
	}

} //> end of LoaderX