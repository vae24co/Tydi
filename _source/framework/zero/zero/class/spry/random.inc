<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* RandomX ~ Random Utility • VERSION » alpha-0.0.1 ***/

class RandomX {
	#INIT • Randomize a string or an array
	public static function initialize($input, $length='AUTO'){
		if(!is_array($input)){
			$input = str_shuffle($input);
			if($length === 'AUTO' || $length == 'ALL'){return $input;}
			$isLength = strlen($input);
			if(is_numeric($length)){
				if($length <= $isLength){return substr($input, 0, $length);}
				else {
					$apendCount = $length - $isLength;
					return $input.self::initialize($input, $apendCount);
				}
			}
		}
		else {
			shuffle($input);
			$o = '';
			if($length == 'AUTO' || $length == 'ALL'){
				foreach ($input as $index => $value){
					$o .= $input[$index];
				}
				return $o;
			}
			$isLength = count($input);
			if(is_numeric($length)){
				if($length <= $isLength){
					for($i=0; $i < $length; $i++){
						$o .= $input[$i];
					}
					return $o;
				}
				else {
					$apendCount = $length - $isLength;
					for($i=0; $i < $apendCount; $i++){
						$o .= $input[$i];
					}
					return $o.self::initialize($input, $apendCount);
				}
			}
		}
		return $input;
	}


	#DIGIT • Generate & return numbers
	public static function digit($length=2){
		return self::initialize('1234567890', $length);
	}


	#ALPHA • Generate & return alphabet
	public static function alpha($length=2, $case='AUTO'){
		if($case === 'LOWERCASE'){
			$alpha = range('a', 'z');
			shuffle($alpha);
		}
		elseif($case === 'UPPERCASE'){
			$alpha = range('A', 'Z');
			shuffle($alpha);
		}
		else {
			$alpha = array_merge(range('a', 'z'), range('A', 'Z'));
			shuffle($alpha);
		}
		return self::initialize($alpha, $length);
	}


	public static function alphanumeric($length=12, $case='AUTO'){
		$alpha = self::alpha($length, $case);
		$digit = self::digit($length);
		return self::initialize($alpha.$digit, $length);
	}


	#CHAR • Special character
	public static function char($length){
		return self::initialize('(=@#$[%{&*?)}', $length);
	}


	#UID • Generate unique ID
	public static function uid(){
		$lower = self::alpha('AUTO', 'LOWERCASE');
		$upper = self::alpha('AUTO', 'UPPERCASE');
		$digit = self::digit('AUTO');
		$time = time();
		$rand = mt_rand();
		$o = $rand.$lower.$digit.$upper.$time;
		return str_shuffle($o);
	}


	#RUID • Generate random unique ID
	public static function ruid($length=10){
		return substr(self::uid(), 0, $length);
	}


	#PUID • Generate primary unique ID
	public static function puid(){
		return substr(self::uid(), 0, 20);
	}


	#SUID • Generate secondary unique ID
	public static function suid(){
		return substr(self::uid(), 0, 40);
	}


	#TUID • Generate tertiary unique ID
	public static function tuid(){
		return substr(self::uid(), 0, 70);
	}


	#FILENAME • Generate random filename
	public static function filename($length=20, $case='AUTO'){
		return self::alphanumeric($length, $case);
	}


	#USERNAME • Generate random username
	public static function username($length='AUTO'){
		if($length == 'AUTO'){
			$o = self::alpha(8, 'LOWERCASE').self::digit(4);
		} else {
			$o = self::alpha($length, 'LOWERCASE');
		}
		return $o;
	}


	#SIMPLE • Generate simple randomization
	public static function simple(){
		$alpha = chr(rand() > 0.5 ? rand(65, 90) : rand(97, 122));
		return $alpha.mt_rand(100, 999).date('sdm').mt_rand(10, 99).self::alpha(3);
	}


	#TEN • Generate 10 characters
	public static function ten($flag='AUTO'){
		return self::digit(8).self::alpha(2, $flag);
	}


	#ACCOUNT • Generate Account Number
	public static function account(){
		return mt_rand(1000000000, 9999999999);
	}

} /*** End Of ~RandomX ***/