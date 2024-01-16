<?php
//*** LoaderX » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//
class LoaderX {

	// ◇ ==== call → handler - undefined method » [error]
	public function __call($method, $argument) {
		return OversightX(__CLASS__, 'method unreachable', $method);
	}




	// ◇ ==== callStatic → handler - undefined static method » [error]
	public static function __callStatic($method, $argument) {
		return OversightX(__CLASS__, 'static method unreachable', $method);
	}




	// ◇ ==== file → load file or files
	public static function file($file, $extension = '.php', $path = null) {
		if (is_array($file)) {
			foreach ($file as $filename) {
				self::file($filename, $extension, $path);
			}
		} else {
			return FileX($file . $extension, $path);
		}
	}




	// ◇ ==== directoryFile → load all or specific files from a directory
	public static function directoryFile($directory, $filename = '*', $extension = '.php') {
		if (is_dir($directory) && !empty($filename)) {

			// • load all files
			if ($filename === '*') {
				$files = glob($directory . '*' . $extension);
				$lib = [];
				if (!empty($files)) {
					foreach ($files as $key => $file) {
						$lib[$key] = $directory . basename($file);
						if (is_file($lib[$key])) {
							require_once($lib[$key]);
						}
					}
				}
			}

			// • load specific file(s)
			else {
				self::file($filename, $extension, $directory);
			}
			return true;
		}
		return false;
	}




	// ◇ ==== getDirectoryFile → return names of files with a specific extension from a directory
	public static function getDirectoryFile($directory, $extension = 'php') {
		if (is_dir($directory)) {
			$filenames = [];
			$files = scandir($directory);
			foreach ($files as $filename) {
				if (pathinfo($filename, PATHINFO_EXTENSION) === $extension) {
					$filenames[] = $filename;
				}
			}
			return $filenames;
		}
		return false;
	}

} //> end of LoaderX