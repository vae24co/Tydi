<?php //*** LoaderX » Tydi™ Framework © 2024 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

use Tydi\Spry\DebugX as DebugX;

class LoaderX {

	// ◇ ==== properties
	protected static $map = [];




	// ◇ ==== init →
	public static function init() {
		spl_autoload_register([self::class, 'load']);
	}




	// ◇ ==== load →
	public static function load($name) {
		$path = self::file($name);
		if ($path !== null) {
			if (!is_file($path)) {
				$trace = DebugX::trace(__FILE__, __LINE__);
				return DebugX::oversight($name, 'File Unavailable!', $path, $trace);
			}
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




	// ◇ ==== map →
	public static function map(array $map) {
		self::$map = array_merge(self::$map, $map);
	}




	// ◇ ==== namespace →
	public static function namespace() {
		return self::$map;
	}

} //> end of LoaderX