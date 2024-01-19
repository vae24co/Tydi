<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* SanitizeQ ~ Sanitize Utility • VERSION » alpha-0.0.1 ***/

class SanitizeQ {

	public static function password(string $input, $f='INPUT'){
		$input = StringX::clean($input);
		$input = oCleanX($input);
		$input = trim($input);
		if($f === 'INPUT'){
			$input = CryptX::password($input);
		}
		return $input;
	}


	public static function username(string $input, $f='INPUT'){
		if($f === 'INPUT'){
			$input = StringX::clean($input);
			$input = oCleanX($input, 'LOWERCASE');
		}
		return $input;
	}


	public static function email(string $input, $f='INPUT'){
		if($f === 'INPUT'){
			$input = StringX::clean($input);
			$input = oCleanX($input, 'LOWERCASE');
		}
		return $input;
	}


	public static function name(string $input, $f='INPUT'){
		if($f === 'INPUT'){
			$input = StringX::clean($input);
			$input = oCleanX($input, 'UPPERCASE_WORD');
		}
		return $input;
	}


	public static function acronym(string $input, $f='INPUT'){
		if($f === 'INPUT'){
			$input = StringX::clean($input);
			$input = oCleanX($input, 'UPPERCASE');
		}
		return $input;
	}


	public static function gender($input, $f='INPUT'){
		if($f === 'INPUT'){
			$input = StringX::clean($input);
			$input = oCleanX($input, 'LOWERCASE');
			if(is_numeric($input)){
				#TODO: typecast input as int
				if($input === 2){$o = 'F';}
				if($input === 1){$o = 'M';}
			}
			else {
				if($input === 'female'){$o = 'F';}
				elseif($input === 'male'){$o = 'M';}
				else {$o = $input;}
			}
		}
		elseif($f === 'OUTPUT'){
			if(is_numeric($input)){
				if($input === 2){$o = 'Female';}
				if($input === 1){$o = 'Male';}
			}
			else {
				if($input == 'F'){$o = 'Female';}
				elseif($input == 'M'){$o = 'Male';}
				else {$o = $input;}
			}

		}
		return oCleanX($o, 'UPPERCASE_WORD');
	}


	public static function toName($firstname='', $lastname='', $middlename=''){
		$o = '';
		if(!empty($firstname)){$o .= ' '.oCleanX($firstname, 'UPPERCASE_WORD');}
		if(!empty($middlename)){$o .= ' '.oCleanX($middlename, 'UPPERCASE_WORD');}
		if(!empty($lastname)){$o .= ' '.oCleanX($lastname, 'UPPERCASE_WORD');}
		return trim($o);
	}


	public static function input($input){
		if(is_array($input)){
			$sanitizer = ['username', 'email', 'password', 'name', 'acronym', 'gender'];
			foreach($input as $key => $value){
				if(in_array($key, $sanitizer)){
					$o[$key] = self::{$key}($value, 'INPUT');
				}
				else {
					$o[$key] = self::input($value, 'INPUT');
				}
			}
			return $o;
		}
		$input = StringX::clean($input);
		return $input;
	}


	public static function isUsername($input){
		$input = self::username($input, 'INPUT');
		#TODO: clean up username and reversed names
		$reserved = ['admin', 'support', 'webmaster'];
		if(!empty($input)){return $input;}
		return false;
	}


	public static function isEmail($input, $resp='DATA'){
		$input = self::email($input, 'INPUT');
		if(filter_var($input, FILTER_VALIDATE_EMAIL)){
			if($resp === 'DATA'){return $input;}
			return true;
		}
		return false;
	}

} /*** End Of ~SanitizeQ ***/
