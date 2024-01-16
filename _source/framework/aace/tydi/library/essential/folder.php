<?php
/* FOLDER ~ Folder Class » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © January 2023 | Apache License */

class Folder {

	// * IS • Check (Is Directory) » Boolean
	public static function is($folder) {
		if (is_dir($folder) && !is_file($folder)) {
			return true;
		}
		return false;
	}



	// * PATH • Directory Path »
	public static function path($target) {
		return dirname($target);
	}



	// * NAME • Directory Name »
	public static function name($target) {
		if (self::is($target) === true) {
			return pathinfo($target)['filename'];
		}

		return false;
	}



	// * BASE • Directory Basename »
	public static function base($target) {
		return basename(self::path($target));
	}



	// * SEPARATOR • Add Separator to Directory Path
	public static function separator($path) {
		$separator = substr($path, -1);
		if ($separator !== DS) {
			$path .= DS;
		}

		return $path;
	}



	// * SCAN • Directory Files » Array (Filename)
	public static function scan($dir, $n = 2) {
		if (self::is($dir) === true) {
			$dirList = scandir($dir, $n);
			if (in_array('.', $dirList)) {
				$index = array_search('.', $dirList);
				unset($dirList[$index]);
			}

			if (in_array('..', $dirList)) {
				$index = array_search('..', $dirList);
				unset($dirList[$index]);
			}
			if (!empty($dirList)) {
				return $dirList;
			}
		}

		return false;
	}



	// * LIST • Directory List » Array (Directories)
	public static function list($target, $fullPath = false) {
		if (self::is($target) === false && is_file($target)) {
			$target = self::path($target) . DS;
		}
		$target = self::separator($target);
		$dir = self::name($target);
		$dirList = self::scan($target);
		if (is_array($dirList)) {
			foreach ($dirList as $key => $value) {
				$path = $target . $value;
				if (self::is($path) === true) {
					if ($fullPath === true) {
						$list[$dir . '_' . $value] = self::separator($path);
					} else {
						$list[$dir . '_' . $value] = $value;
					}
				}
			}
		}
		if (!empty($list)) {
			return $list;
		}

		return false;
	}



	// * FILES • Directory Filenames » Array (Files)
	public static function files($target, $fullpath = true) {
		if (self::is($target) === false && is_file($target)) {
			$target = self::path($target) . DS;
		}
		$target = self::separator($target);
		$dir = self::name($target);
		$dirList = self::scan($target);
		if (is_array($dirList)) {
			foreach ($dirList as $key => $value) {
				$path = $target . $value;
				$name = File::name($path);
				if (is_file($path)) {
					if ($fullpath === true) {
						$files[$dir . '_' . $name] = $path;
					} else {
						$files[$dir . '_' . $name] = $value;
					}
				}
			}
		}
		if (!empty($files)) {
			return $files;
		}

		return false;
	}



	public static function empty($dir) {
		if (self::is($dir)) {
			$handle = opendir($dir);
			while (false !== ($entry = readdir($handle))) {
				if ($entry != "." && $entry != "..") {
					closedir($handle);
					return false;
				}
			}
			closedir($handle);
		}
		return true;
	}


	public static function create($input) {
		if (mkdir($input, 0777, true)) {
			return true;
		}
		return false;
	}


	public static function delete($input) {
		if (self::empty($input) && rmdir($input) === true) {
			return true;
		}
		return false;
	}
} // end of class ~ Folder