<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* oLoadX ~ AutoLoad Class Utility • VERSION » alpha-0.0.1 ***/

function oLoadX($class){

	if(class_exists($class)){
		return true;
	}

	#Class - oSetup
	if($class === 'oSetup'){
		$path = SETUP.'setup.inc';
		return oClassLoadX($path, true, $class);
	}

	#ZERO - SPRY ~ ends with X
	elseif(substr($class, -1) === 'X'){
		$file = ZERO['SPRY'].strtolower(substr_replace($class, '', -1)).'.inc';
		return oClassLoadX($file, true, $class);
	}

	#ZERO - OBJECT ~ begins with o
	elseif(substr($class, 0, 1) === 'o'){
		$file =  ZERO['OBJ'].strtolower(substr($class, 1)).'.inc';
		return oClassLoadX($file, true, $class);
	}


	#ZERO - HELPER ~ ends with Q
	elseif(substr($class, -1) === 'Q'){
		$file = ZERO['HELPER'].strtolower(substr_replace($class, '', -1)).'.inc';
		return oClassLoadX($file, true, $class);
	}


	#ZERO - VENDOR ~ ends with V
	elseif(substr($class, -1) === 'V'){
		$file = ZERO['VENDOR'].strtolower(substr_replace($class, '', -1)).'.inc';
		return oClassLoadX($file, true, $class);
	}


	#BUILD ~ ends with O for Organizr
	elseif(substr($class, -1) === 'O' && strtolower($class) !== 'zero'){
		$file = ORGANIZR.strtolower(substr_replace($class, '', -1)).'.inc';
		return oClassLoadX($file, true, $class);
	}


	#BUILD ~ ends with Contr for Controlizr
	elseif(substr($class, -5) === 'Contr'){
		$file = CONTROLIZR.strtolower(substr_replace($class, '', -5)).'.inc';
		return oClassLoadX($file, true, $class);
	}


	#BUILD ~ ends with Model for Modelizr
	elseif(substr($class, -5) === 'Model'){
		$file = MODELIZR.strtolower(substr_replace($class, '', -5)).'.inc';
		return oClassLoadX($file, true, $class);
	}


	#BUILD ~ ends with View for Viewzr
	elseif(substr($class, -4) === 'View'){
		$file = VIEWZR.strtolower(substr_replace($class, '', -4)).'.inc';
		return oClassLoadX($file, true, $class);
	}


	#BUILD ~ ends with U for Utilizr
	elseif(substr($class, -4) === 'Util'){
		$file = UTILIZR.strtolower(substr_replace($class, '', -4)).'.inc';
		return oClassLoadX($file, true, $class);
	}


	#BUILD - APIZR ~ ends with API
	elseif(substr($class, -3) === 'API'){
		$file = APIZR.strtolower(substr_replace($class, '', -3)).'.inc';
		return oClassLoadX($file, true, $class);
	}


	#BUILD - APPZR ~ ends with App
	elseif(substr($class, -3) === 'App'){
		$file = APPZR.strtolower(substr_replace($class, '', -3)).'.inc';
		return oClassLoadX($file, true, $class);
	}


	#class in PROJECT
	else {
		$file = strtolower($class).'.inc';
		$path[] = CONTROLIZR.$file;
		$path[] = ORGANIZR.$file;
		$path[] = MODELIZR.$file;
		$path[] = UTILIZR.$file;
		$path[] = ZERO['HELPER'].$file;
		$path[] = ZERO['VENDOR'].$file;
		$path[] = ZERO['INTERFACE'].$file;
		$fileis = false;
		foreach($path as $file){
			if(file_exists($file)){
				$fileis = true;
				require $file;
			}
		}
		if(!$fileis){return oClassLoadX($file, false, $class, ['extra' => $path]);}
		return oClassX($class, $path);
	}
}