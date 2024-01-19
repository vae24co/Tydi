<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* TimeX ~ Time Utility • VERSION » alpha-0.0.1 ***/

class TimeX {
	#MICRO • Set/Get Timezone
	public static function zone($i='DOMESTIC'){
		if(!empty($i)){
			if($i === 'GET'){return date_default_timezone_get();}
			elseif($i === 'DOMESTIC'){return date_default_timezone_set('Africa/Lagos');}
			else {
				$zones = in_array($i, timezone_identifiers_list());
				if(!$zones){
					$error = ['code' => 'CE400SE', 'object' => __METHOD__.'()', 'title' => 'nvalid Argument', 'extra' => $i];
					return oErrorX($error);
				}
				return date_default_timezone_set($i);
			}
		}
		return false;
	}



	public static function isValidateDate($date, $format){
		$obj = DateTime::createFromFormat($format, $date);
		return $obj && $obj->format($format) == $date;
	}




	public static function create($fmt='TIME', $period='NOW'){
		if(!empty($fmt) && !empty($period)){
			if($period == 'TODAY' || $period == 'NOW'){$period = time();}
			elseif(!is_int($period) && !is_numeric($period)){$period = self::stamp($period);}

			if($fmt == 'UNIX'){return $period;}
			elseif($fmt == 'DATE'){$fmt = 'l, F d, Y';}
			elseif($fmt == 'TIME'){$fmt = 'h:i:s A';}
			elseif($fmt == 'REPORT'){$fmt = 'd/m/Y h:i:s A';}
			elseif($fmt == 'SQLTIME'){$fmt = 'h:i:s';}
			elseif($fmt == 'DATETIME'){$fmt = 'l, F d, Y h:i:s A';}
			elseif($fmt == 'SQLDATETIME'){$fmt = 'Y-m-d H:i:s';}
			return self::date($fmt, $period);
		}
		return false;
	}























	public static function date($fmt='DATE', $date='TODAY'){
		if(!empty($fmt) && !empty($date)){
			if($date == 'TODAY' || $date == 'NOW'){$date = time();}
			elseif(!is_int($date) && !is_numeric($date)){$date = self::stamp($date);}

			// elseif($fmt == 'DATER1'){$fmt = 'd/m/Y';}
			// elseif($fmt == 'DATER2'){$fmt = 'd-m-Y';}
			// elseif($fmt == 'DateR3'){$fmt = 'd-M-Y';}
			// elseif($fmt == 'DateR4'){$fmt = 'F d, Y';}
			// elseif($fmt == 'SQL'){$fmt = 'Y-m-d';}
			// elseif($fmt == 'LetterA'){return date('M j', $date).'<sup>'.date('S', $date).'</sup> '.date('Y', $date);}
			// elseif($fmt == 'LetterB'){return date('j', $date).'<sup>'.date('S', $date).'</sup> '.date('F, Y', $date);}
			// elseif($fmt == 'LetterC'){return date('F j', $date).'<sup>'.date('S', $date).'</sup> '.date('Y', $date);}
			return date($fmt, $date);
		}
		return false;
	}









































	#MICRO •
	public static function micro(){
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
	}


	#IS_VALID_STAMP •
	public static function isValidStamp($timestamp){
		$check = (is_int($timestamp) OR is_float($timestamp)) ? $timestamp : (string) (int) $timestamp;
		return($check === $timestamp) AND ((int)$timestamp <=  PHP_INT_MAX) AND ( (int) $timestamp >= ~PHP_INT_MAX);
	}


	#IS_VALID_STRING •
	public static function isValidString($string){
		$stamp = strtotime($string);
		if($stamp !== false){
			return self::isValidStamp($stamp);
		}
		return false;
	}


	#STAMP • Create timestamp from string|timestamp
	public static function stamp($string='now'){
		if(!empty($string)){
			if(self::isValidStamp($string)){return $string;}
			if(self::isValidString($string) !== false){return strtotime($string);}
		}
		return false;
	}
























	#AGE • Returns age from date of birth in years
	public static function age($i=''){
		if(!empty($i)){
			#@TODO ~ make sure input match format (YYYY-MM-DD)
			$time = time(); $day = date("d", $time); $month = date("m", $time); $year = date("Y", $time);
			$birthDay = substr($i, 8, 2); $birthMonth = substr($i, 5, 2); $birthYear = substr($i, 0, 4);
			if($month < $birthMonth){$subtract = 1;}
			elseif($month==$birthMonth){
				if($day < $birthDay){$subtract = 1;}
				else {$subtract = 0;}
			}
			else {$subtract = 0;}
			return ($year-$birthYear-$subtract);
		}
		return false;
	}


	#SECONDS • Convert seconds to min, hour & day
	public static function seconds($sec, $to='Minute'){
		if(!empty($sec) && !empty($to)){
			if($to == 'Minute'){$o = ($sec / 60);}
			if($to == 'Hour'){$o = ($sec / 60) / 60;}
			if($to == 'Day'){$o = (($sec / 60) / 60) / 24;}
			return $o;
		}
		return false;
	}


	#MINUTES • Convert minutes to seconds, hour & day
	public static function minutes($min, $to='Second'){
		if(!empty($min) && !empty($to)){
			if($to == 'Second'){$o = ($min * 60);}
			if($to == 'Hour'){$o = ($min / 60);}
			if($to == 'Day'){$o = ($min / 60) / 24;}
			return $o;
		}
		return false;
	}


	#HOUR TO • Convert hours to sec, min & day
	public static function hours($hr, $to='Day'){
		if(!empty($hr) && !empty($to)){
			if($to == 'Second'){$o = ($hr * 60) * 60;}
			if($to == 'Minute'){$o = $hr * 60;}
			if($to == 'Day'){$o = $hr / 24;}
			return $o;
		}
		return false;
	}


	#DAY TO • Convert days to sec, min & hours
	public static function days($day, $to='Hour'){
		if(!empty($day) && !empty($to)){
			if($to == 'Second'){$o = (($day * 24) * 60) * 60;}
			if($to == 'Minute'){$o = ($day * 24) * 60;}
			if($to == 'Hour'){$o = $day * 24;}
			return $o;
		}
		return false;
	}


	#DIFFERENCE • Calculate time difference - TODO - upgrade and add features
	public static function difference($past='', $future='', $fmt='%a days'){
		$past = new DateTime($past);
		$future = new DateTime($future);
		$date = $past->diff($future);
		return $date->format($fmt);
	}

} /*** End Of ~TimeX ***/