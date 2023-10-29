<?php //*** Tydi - Description » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//
class Tydi {

	// • ==== call → handler - undefined method » [error]
	public function __call($method, $argument) {
		$object = self::oClass($method, $argument);
		if (!$object) {
			$caller = __CLASS__ . '->' . $method . '()';
			return self::oversightX(__CLASS__ . '™', 'method unreachable', $caller);
		}
		return $object;
	}




	// • ==== callStatic → handler - undefined static method » [error]
	public static function __callStatic($method, $argument) {
		$object = self::oClass($method, $argument);
		if (!$object) {
			$caller = __CLASS__ . '::' . $method . '()';
			return self::oversightX(__CLASS__ . '™', 'static: method unreachable', $caller);
		}
		return $object;
	}




	// • ==== debugX → output variable »
	public static function debugX($var, string $title = null) {
		$o = '<div style="border: 1px solid tan; padding: 5px 10px; margin-bottom:6px;">';
		if (!is_null($title) && $title !== '') {
			$o .= '<strong style="margin:0; line-height:1.6; color: brown;">' . $title . ':</strong> ';
		}

		if (is_string($var)) {
			$o .= ' <span style="color: purple;">' . $var . '</span>';
		} else {
			$o .= ' <div style="color: purple;"><pre><tt>' . var_export($var, true) . '</tt></pre></div>';
		}
		$o .= '</div>';
		return $o;
	}




	// • ==== oversightX → output error »
	public static function oversightX($label, $message, $extra = null, $exit = true) {
		if (strpos($label, FRAMEWORK) === false) {
			$label = FRAMEWORK . '™ • ' . $label;
		}
		$e = '<strong>' . ucwords($label) . '</strong> | ' . $message;
		if (!is_null($extra) && $extra != '') {
			if (is_array($extra)) {
				if (count(array_filter(array_keys($extra), 'is_numeric')) === count($extra)) {
					$extra = implode(' • ', $extra);
				} else {
					$append = '';
					foreach ($extra as $key => $val) {
						$append .= $key . ': ' . $val . ' • ';
					}
					$extra = trim($append, ' • ');
				}
			}
			if (is_string($extra)) {
				$e .= ' → <em>[' . $extra . ']</em>';
			}
		}

		echo self::debugX($e);
		if ($exit) {
			exit();
		}
	}




	// • ==== callerX → report class/function unavailable »
	public static function callerX($caller, $type, &$file = null) {
		if ($type === 'CLASS' && !class_exists($caller) || $type === 'FUNCTION' && !function_exists($caller)) {
			return self::oversightX($caller, ucfirst(strtolower($type)) . ' Unavailable!', $file);
		}
		return true;
	}




	// • ==== classX → report class unavailable »
	public static function classX($filename, $class = null, $path = null) {
		if (is_null($path)) {
			$filepath = $filename;
		} elseif (strlen($path) > 1) {

			if (StringX::endWithAny($class, ['zr', 'API', 'App', 'Site'])) {
				$filename = strtolower(Env::version()) . DS . $filename;
			}

			if (substr($path, -(strlen(DS))) === DS) {
				$filepath = $path . $filename;
			} else {
				$filepath = $path . DS . $filename;
			}
		}
		if (is_file($filepath)) {
			require_once $filepath;
			return $filepath;
		} else {
			$filepath = StringX::swapLast($filepath, strtolower(Env::version()) . DS);
			if (is_file($filepath)) {
				require_once $filepath;
				return $filepath;
			}
		}

		if (!is_file($filepath)) {
			if (empty($class)) {
				$class = pathinfo($filepath, PATHINFO_FILENAME);
			}
			$extra = $filepath;
			if (defined('ENVIRONMENT')) {
				if (ENVIRONMENT === 'STAGING') {
					$extra = basename($filename);
				} elseif (ENVIRONMENT === 'PRODUCTION') {
					$extra = strtolower($class);
				}
			}
			self::callerX($class, 'CLASS', $extra);
		}
	}




	// • ==== oClass → call class automatically » [object | false]
	private static function oClass($method, $argument) {
		$class = ucfirst($method);
		if (!class_exists($class, false)) {
			echo $file = PATH['LIBRY'] . strtolower($method) . '.php';
			if (is_file($file)) {
				require_once $file;
			}
		}
		if (class_exists($class, false)) {
			return new $class;
		}
		return false;
	}




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


} //> end of Tydi