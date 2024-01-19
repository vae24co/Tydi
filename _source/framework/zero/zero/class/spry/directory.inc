<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* DirectoryX ~ Directory Utility • VERSION » alpha-0.0.1 ***/

class DirectoryX {

	public static function is($input){
		if(is_dir($input) === true){return true;}
		return false;
	}


	public static function empty($dir){
		if(self::is($dir)){
			$handle = opendir($dir);
			while (false !== ($entry = readdir($handle))){
				if($entry != "." && $entry != ".."){
					closedir($handle);
					return false;
				}
			}
			closedir($handle);
		}
		return true;
	}


	public static function create($input){
		if(mkdir($input, 0777, true)){return true;}
		return false;
	}


	public static function delete($input){
		if(self::empty($input) && rmdir($input) === true){return true;}
		return false;
	}


	public static function iscreate($input){
		if(self::is($input) === false){
			return self::create($input);
		}
		return false;
	}

} /*** End Of ~DirectoryX ***/