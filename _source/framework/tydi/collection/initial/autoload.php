<?php
//*** Autoload » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//
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


	// • Essential :: Class name ends with X
	if (substr($class, -1) === 'X' && strlen($class) > 1) {
		$file = substr_replace($file, '', -1) . '.php';
		$path = LIBRY['ESSENTIAL'];
		FileX($file, $path);
	}


	// • Spry :: Class name ends with Q
	elseif (substr($class, -1) === 'Q' && strlen($class) > 1) {
		$file = substr_replace($file, '', -1) . '.php';
		$path = LIBRY['SPRY'];
		FileX($file, $path);
	}



	// • Utilizr :: class name ends with Util
	elseif (substr($class, -4) === 'Util' && strlen($class) > 4) {
		$file = substr_replace($file, '', -4) . '.php';
		$path = ORIG['UTIL'];
		FileX($file, $path);
	}



	// • class not exists :: trigger error
	if (!class_exists($class, false)) {
		$filepath = $path . $file;
		return CallerX($class, 'CLASS', $filepath);
	}

	return true;

} //> end of Autoload