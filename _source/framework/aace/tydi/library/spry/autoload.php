<?php
/*** oAutoloadX ~ Autoload Classes » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © January 2023 | Apache License ***/

// ◇ ----- CALLER • Check Existence (Class/Function) » Boolean
function oCallerX($caller, $type, &$filepath = '') {
	if ($type === 'CLASS' && !class_exists($caller)) {
		return ErrorX::is($caller, 'Class Unavailable', $filepath);
	} elseif ($type === 'FUNCTION') {
		if (!function_exists($caller)) {
			return ErrorX::is($caller, 'Function Unavailable', $filepath);
		}
	}
	return true;
}



// ◇ ----- AUTOLOAD • Autoload Classes » Boolean
function oAutoloadX($class) {

	// + Check if class exists » boolean [true]
	if (class_exists($class)) {
		return true;
	}

	// + Define file name from class name
	$file = strtolower($class);
	if (StringX::contain($file, '_')) {
		$fileAlternative = StringX::swap($file, '_', DS);
	}

	// + AO :: Class name ends with AO
	if (substr($class, -2) === 'AO' && strlen($class) > 2) {
		$file = LIBRARY['plugin'] . 'ao' . DS . 'code' . DS . substr_replace($file, '', -2) . '.php';
		File::load($file, 'AO Plugin');
	}

	// + Spry :: Class name ends with Spry
	elseif (substr($class, -4) === 'Spry' && strlen($class) > 4) {
		$file = LIBRARY['spry'] . substr_replace($file, '', -4) . '.php';
		File::load($file, 'spry');
	}

	// + Object :: Class name for Object
	elseif (substr($class, 0, 1) === 'i' || substr($class, 0, 1) === 'o' || substr($class, -1) === 'O') {

		//...Begins with i OR with o
		if (substr($class, 0, 1) === 'i' || substr($class, 0, 1) === 'o') {
			$file = LIBRARY['object'] . substr($file, 1) . '.php';
		}

		//...Ends with O
		elseif (substr($class, -1) === 'O') {
			$file = LIBRARY['object'] . substr_replace($file, '', -1) . '.php';
		}

		File::load($file, 'object');
	}

	// + Helper :: Class name ends with Q
	elseif (substr($class, -1) === 'Q') {
		$file = LIBRARY['helper'] . substr_replace($file, '', -1) . '.php';
		File::load($file, 'helper');
	}



	// » utilizr :: class name ends with Util
	elseif (substr($class, -4) === 'Util') {
		$file = SOURCE['util'] . substr_replace($file, '', -4) . '.php';
		File::load($file, 'utility');
	}

	// » modelizr :: class name ends with Model
	elseif (substr($class, -5) === 'Model') {
		$isLoaded = false;
		if (VarX::isNotEmpty($fileAlternative)) {
			$fileAlternative = SOURCE['model'] . substr_replace($fileAlternative, '', -5) . '.php';
			if (File::is($fileAlternative)) {
				require $fileAlternative;
				$isLoaded = true;
				$file = $fileAlternative;
			}
		}

		if (VarX::isFalse($isLoaded)) {
			$file = SOURCE['model'] . substr_replace($file, '', -5) . '.php';
			File::load($file, 'model');
		}
	}

	// » controlizr :: class name ends with Contr
	elseif (substr($class, -5) === 'Contr') {
		$isLoaded = false;
		if (VarX::isNotEmpty($fileAlternative)) {
			$fileAlternative = SOURCE['control'] . substr_replace($fileAlternative, '', -5) . '.php';
			if (File::is($fileAlternative)) {
				require $fileAlternative;
				$isLoaded = true;
				$file = $fileAlternative;
			}
		}

		if (VarX::isFalse($isLoaded)) {
			$file = SOURCE['control'] . substr_replace($file, '', -5) . '.php';
			File::load($file, 'controller');
		}
	}

	// » organizr :: class name ends with zr
	elseif (substr($class, -2) === 'zr') {
		$file = SOURCE['organ'] . substr_replace($file, '', -2) . '.php';
		File::load($file, 'organizer');
	}

	// » api :: class name ends with API
	elseif ($class !== 'API' && substr($class, -3) === 'API') {
		$file = SOURCE['api'] . substr_replace($file, '', -3) . '.php';
		File::load($file, 'API', '', $class);
	}

	// » app :: class name ends with App
	elseif ($class !== 'App' && substr($class, -3) === 'App') {
		$file = SOURCE['app'] . substr_replace($file, '', -3) . '.php';
		File::load($file, 'App');
	}

	// » view :: class name ends with View
	elseif (substr($class, -4) === 'View') {
		$file = SOURCE['view'] . substr_replace($file, '', -4) . '.php';
		File::load($file, 'App');
	}

	// » setup :: class name ends with Setup
	elseif (substr($class, -5) === 'Setup' && strlen($class) > 5) {
		$file = SOURCE['setzr'] . substr_replace($file, '', -5) . '.php';
		File::load($file, 'setzr');
	}



	// » class in the project
	else {

		$file = [];

		//...check model for class file
		$file['model'] = SOURCE['model'] . strtolower($class) . '.php';
		if (File::is($file['model'])) {
			require($file['model']);
		}

		//...check vendor for class file
		else {
			$file['vendor'] = VENDOR['vendor'] . strtolower($class) . '.php';
			if (File::is($file['vendor'])) {
				require($file['vendor']);
			} else {
				$file['vendor'] = VENDOR['vendor'] . strtolower($class . DS . $class) . '.php';
				if (File::is($file['vendor'])) {
					require($file['vendor']);
				}
			}
		}
	}

	// » class not exists :: trigger error
	if (!class_exists($class)) {
		return oCallerX($class, 'CLASS', $file);
	}

	return true;
}