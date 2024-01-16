<?php
/* FILE ~ File Class » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © January 2023 | Apache License */

class File {

	// * IS • Check (Is File) » Boolean
	public static function is($file) {
		if (is_file($file)) {
			return true;
		}

		return false;
	}



	// * IS_VIRTUAL • Check if not actual file » Boolean
	public static function isVirtual($file) {
		if (self::is($file) === false && Folder::is($file) === false) {
			return true;
		}

		return false;
	}



	// * ALLOW_VIRTUAL • Allow virtual file » Boolean
	public static function allowVirtual($file, $virtual) {
		if ($virtual === false) {
			return self::is($file);
		} elseif ($virtual === true && (self::is($file) === true || self::isVirtual($file) === true)) {
			return true;
		}

		return false;
	}




	// ◇ ----- IS NOT • ... » Boolean
	public static function isNot($file) {
		if (!self::is($file)) {
			return true;
		}
		return false;
	}



	// * PATH • Path Information »
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



	// * NAME • File Name »
	public static function name($file, $virtual = false) {
		return self::path($file, 'filename', $virtual);
	}



	// * BASE • File Basename »
	public static function base($file, $virtual = false) {
		return self::path($file, 'basename', $virtual);
	}





	// ◇ ----- CHECK • Check File » Boolean | Error
	public static function check($filepath, $append = '', $object = '') {
		if (self::is($filepath) === false) {
			if (VarX::isEmpty($object)) {
				$label = FRAMEWORK . '™';
			} else {
				$label = $object;
			}

			if ($append !== '') {
				$label .= ' • ' . ucwords($append);
			}

			$filename = self::name($filepath, true);
			$error = Env::errorReport($filename, $filepath, '...');
			return ErrorX::is($label, 'File Unavailable', $error);
		}
		return true;
	}





	// ◇ ----- LOAD • Load File »
	public static function load($filepath, $append = '', $content = '', $object = '') {
		if (self::check($filepath, $append, $object)) {
			return require $filepath;
		}
		return false;
	}





	// ◇ ----- APPEND • Append File »
	public static function append($filepath, $content = '', $safely = true, $append = '', $object = '') {
		if ($safely === true) {
			if (File::is($filepath)) {
				return require $filepath;
			}
		} else {
			return self::load($filepath, $append, $content, $object);
		}
		return false;
	}

} // end of class ~ File