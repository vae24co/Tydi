<?php
//*** Autoload » Tydi™ ~ AO™ • @iamodao • www.osawere.com ~ © 2023 • Apache License ***//
function Autoload($class) {












	// • Instance :: Class name for Object
	elseif (substr($class, 0, 1) === 'o' || substr($class, -1) === 'O') {
		if (substr($class, 0, 1) === 'o') {
			$file = LIBRY['INSTANCE'] . substr($file, 1) . '.php';
		} elseif (substr($class, -1) === 'O') {
			$file = LIBRY['INSTANCE'] . substr_replace($file, '', -1) . '.php';
		}
		FileX::load($file, 'instance');
	}






	// • Modelizr :: class name ends with Model
	elseif (substr($class, -5) === 'Model') {
		$isLoaded = false;
		if (Vars::isNotEmpty($fileAlternative)) {
			$fileAlternative = ORIG['MODEL'] . substr_replace($fileAlternative, '', -5) . '.php';
			if (FileX::is($fileAlternative)) {
				require $fileAlternative;
				$isLoaded = true;
				$file = $fileAlternative;
			}
		}

		if (Vars::isFalse($isLoaded)) {
			$file = ORIG['MODEL'] . substr_replace($file, '', -5) . '.php';
			FileX::load($file, 'model');
		}
	}

	// • Controlizr :: class name ends with Contr
	elseif (substr($class, -5) === 'Contr') {
		$isLoaded = false;
		if (Vars::isNotEmpty($fileAlternative)) {
			$fileAlternative = ORIG['CONTROL'] . substr_replace($fileAlternative, '', -5) . '.php';
			if (FileX::is($fileAlternative)) {
				require $fileAlternative;
				$isLoaded = true;
				$file = $fileAlternative;
			}
		}

		if (Vars::isFalse($isLoaded)) {
			$file = ORIG['CONTROL'] . substr_replace($file, '', -5) . '.php';
			FileX::load($file, 'controller');
		}
	}

	// • Organizr :: class name ends with zr
	elseif (substr($class, -2) === 'zr') {
		$file = ORIG['ORGAN'] . substr_replace($file, '', -2) . '.php';
		FileX::load($file, 'organizer');
	}

	// • API :: class name ends with API
	elseif ($class !== 'API' && substr($class, -3) === 'API') {
		$file = ORIG['API'] . substr_replace($file, '', -3) . '.php';
		FileX::load($file, 'API', '', $class);
	}

	// • App :: class name ends with App
	elseif ($class !== 'App' && substr($class, -3) === 'App') {
		$file = ORIG['APP'] . substr_replace($file, '', -3) . '.php';
		FileX::load($file, 'App');
	}

	// • Setup :: class name ends with Setup
	elseif (substr($class, -5) === 'Setup' && strlen($class) > 5) {
		$file = ORIG['SET'] . substr_replace($file, '', -5) . '.php';
		FileX::load($file, 'setzr');
	}





	// • Check Others
	else {
		$file = [];
		$file['vendor'] = LIBRY['VENDOR'] . strtolower($class) . '.php';
		if (FileX::is($file['vendor'])) {
			require($file['vendor']);
		} else {
			$file['vendor'] = LIBRY['VENDOR'] . strtolower($class . DS . $class) . '.php';
			if (FileX::is($file['vendor'])) {
				require($file['vendor']);
			}
		}
	}




} //> end of AutoloadX
