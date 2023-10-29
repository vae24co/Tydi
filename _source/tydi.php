<?php //*** Tydi - Tydi Class » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

class Tydi {

	// • ==== inc → load all files in library »
	public static function inc(string|array $file, string $path = null, closure|array $action = null) {
		if (is_string($file)) {
			$files = [$file];
		} else if (is_array($file)) {
			$files = $file;
		}

		$path = $path ?? '';

		foreach ($files as $file) {
			$file = $path . $file . '.php';
			if (!is_file($file)) {
				$error = '<strong>' . FRAMEWORK . '™</strong> • File Unavailable! → [<em>' . $file . '</em>]';
				exit($error);
			}
			include $file;

			if (is_callable($action)) {
				$action();
			} elseif (is_array($action)) {

			}
			return true;
		}
	}





	// • ==== libry → load all files in library »
	public static function libry($directory = null) {
		if (is_null($directory) && defined('PATH') && isset(PATH['LIBRY'])) {
			$directory = PATH['LIBRY'];
		}

		if (empty($directory)) {
			return false;
		}

		$files = scandir($directory);
		if (is_array($files)) {
			$exclude = ["..", "."];
			$files = array_filter($files, function ($files) use ($exclude) {
				return !in_array($files, $exclude);
			});

			if (!empty($files)) {
				foreach ($files as &$file) {
					$file = $directory . $file;
					if (is_file($file)) {
						require_once $file;
					}
				}
			}
		}

		return true;
	}



} //> end of Tydi