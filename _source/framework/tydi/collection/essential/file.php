<?php
//*** FileX » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//
class FileX {

	// ◇ ==== is • check (is file) » boolean
	public static function is($file) {
		if (is_file($file)) {
			return true;
		}
		return false;
	}




	// ◇ ==== IS_VIRTUAL • Check if not actual file » Boolean
	public static function isVirtual($file) {
		if (is_file($file) && !is_dir($file)) {
			return true;
		}
		return false;
	}




	// ◇ ==== allow_virtual • allow virtual file » boolean
	public static function allowVirtual($file, $virtual) {
		if ($virtual === false) {
			return self::is($file);
		} elseif ($virtual === true && (self::is($file) === true || self::isVirtual($file) === true)) {
			return true;
		}
		return false;
	}




	// ◇ ==== is not • ... » boolean
	public static function isNot($file) {
		if (!self::is($file)) {
			return true;
		}
		return false;
	}




	// ◇ ==== path • path information »
	public static function path($file, $i = 'INFO', $virtual = false) {
		if (self::allowVirtual($file, $virtual) === true) {
			$pathinfo = pathinfo($file);
			if ($i != '' && $i !== 'INFO') {
				$i = strtolower($i);
				if (isset($pathinfo[$i])) {
					return $pathinfo[$i];
				}
			}
			return $pathinfo;
		}
		return false;
	}




	// ◇ ==== name • file name »
	public static function name($file, $virtual = false) {
		return self::path($file, 'filename', $virtual);
	}




	// ◇ ==== base • file basename »
	public static function base($file, $virtual = false) {
		return self::path($file, 'basename', $virtual);
	}




	// ◇ ==== check • check file » [boolean|error]
	public static function check($filepath, $append = null, $object = null, $abort = true) {
		if (self::is($filepath) === false) {
			if (empty($object)) {
				$label = TYDI . '™';
			} else {
				$label = $object;
			}
			if (!empty($append)) {
				$label .= ' • ' . ucwords($append);
			}
			$filename = self::name($filepath, true);
			$error = Env::errorMsg($filename, $filepath, '...');
			return OversightX($label, 'File Unavailable!', $error, $abort);
		}
		return true;
	}




	// ◇ ==== load • load file »
	public static function load($filepath, $append = null, $content = null, $object = null) {
		if (self::check($filepath, $append, $object)) {
			return require_once $filepath;
		}
		return false;
	}




	// ◇ ==== append • append file »
	public static function append($filepath, $content = null, $safely = true, $append = null, $object = null) {
		if ($safely === true) {
			if (is_file($filepath) && !is_dir($filepath)) {
				return require_once $filepath;
			}
		} else {
			return self::load($filepath, $append, $content, $object);
		}
		return false;
	}




	// ◇ ==== delete • delete file »
	public static function delete($file) {
		if (is_file($file) && !is_dir($file)) {
			return unlink($file);
		}
		return false;
	}

} //> end of FileX