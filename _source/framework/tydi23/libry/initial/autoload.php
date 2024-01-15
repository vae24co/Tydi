<?php //*** Autoload » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//
function Autoload($class) {

	// • check if class exists
	if (class_exists($class, false)) {
		return true;
	}


	// • set file name from class name
	$file = strtolower($class);
	if (stripos($file, '_') !== false) {
		$fileAlternative = str_ireplace('_', DS, $file);
	}


	// • set $path variable
	$path = '';


	// • Spry :: Class name ends with Q
	if (substr($class, -1) === 'Q' && strlen($class) > 1) {
		$file = substr_replace($file, '', -1) . '.php';
		$path = PATH['HELPER'];
		Tydi::classX($file, $class, $path);
	}


	// • class not exists :: trigger errors
	if (!class_exists($class, false)) {
		if (!empty($classFile)) {
			$filepath = $classFile;
		} else {
			$filepath = $path . $file;
		}
		return Tydi::oversightX($class, 'Class Unavailable', $filepath);
	}
} //> end of Autoload