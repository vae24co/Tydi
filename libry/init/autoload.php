<?php //*** AutoloadX » Tydi™ Framework © 2024 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

function AutoloadX($class) {

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


	// • Modelizr :: Class name ends with Modelizr
	if (substr($class, -8) === 'Modelizr' && strlen($class) > 8) {
		$file = substr_replace($file, '', -8) . '.php';
		$path = PathX::to('MODELIZR');
		DebugX::classX($file, $class, $path);
	}


	// • Organizr :: Class name ends with Organizr
	if (substr($class, -8) === 'Organizr' && strlen($class) > 8) {
		$file = substr_replace($file, '', -8) . '.php';
		$path = PathX::to('ORGANIZR');
		DebugX::classX($file, $class, $path);
	}


	// • Utilizr :: Class name ends with Utilizr
	if (substr($class, -7) === 'Utilizr' && strlen($class) > 7) {
		$file = substr_replace($file, '', -7) . '.php';
		$path = PathX::to('UTILIZR');
		DebugX::classX($file, $class, $path);
	}


	// • class not exists :: trigger errors
	if (!class_exists($class, false)) {
		if (!empty($classFile)) {
			$filepath = $classFile;
		} else {
			$filepath = $path . $file;
		}
		return DebugX::oversight($class, 'Class Unavailable', $filepath);
	}

} //> end of AutoloadX