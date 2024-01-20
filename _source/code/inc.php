<?php
class IncX {



	// • ==== inc → include file, files or files in a directory »
	public static function inc(string|array $input, string $path = null) {

		if (is_string($input) && strlen($input) > 0) {

			// » get files from a directory
			if (is_dir($input)) {
				$directory = $input;
				$files = scandir($directory);
				if (is_array($files)) {
					$path = $path ?? $directory;
					$exclude = ["..", "."];
					$files = array_filter($files, function ($files) use ($exclude) {
						return !in_array($files, $exclude);
					});
				}
			}

			// » get files from a comma separated string
			elseif (strpos($input, ',') !== false) {
				$files = explode(',', $input);
				$files = array_map(function ($value) {
					return $value . '.php';
				}, $files);
			}

			// » get files input string
			else {
				$files = [$input . '.php'];
			}

		}

		// » get files from array input
		elseif (is_array($input)) {
			$files = $input;
			$files = array_map(function ($value) {
				return $value . '.php';
			}, $files);
		}


		// ~ assumes $files is an array if not empty
		if (!empty($files)) {
			$path = $path ?? '';
			foreach ($files as $key => $file) {
				$file = $path . $file;
				if (is_file($file)) {
					include_once $file;
				} else {
					$error[$key] = $file;
				}
			}
			if (!empty($error)) {
				return self::oversightX('File', 'File Unavailable!', $error);
			}
		}

		return false;
	}


} //> end of IncX