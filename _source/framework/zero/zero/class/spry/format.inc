<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* FormatX ~ Format Utility • VERSION » alpha-0.0.1 ***/

class FormatX {

	#NUMBER • Format number
	public static function number($input, $digit=2, $res='INPUT'){
		if(is_numeric($input)){
			$o = $input;
			if(!empty($digit) && is_numeric($digit)){
				$o = number_format($input, $digit);
			}
			else {
				$o = number_format($input);
			}
			return $o;
		}
		if($res === 'ZERO'){return '0';}
		elseif($res === 'DASH'){return '-';}
		return $input;
	}


	#PLURALIZE • Format number
	public static function pluralize($string, $plural, $number){
		if(is_numeric($number) && $number > 1){return $plural;}
		return $string;
	}



	#SIZE • Return computer-based measurement of input
	public static function size($byte, $append=false){
		if(!empty($byte)){
			$unit = '';
			if($byte >= 1073741824){$o = number_format($byte / 1073741824 , 2);  $unit = 'GB';}
			elseif($byte >= 1048576){$o = number_format($byte / 1048576 , 2); $unit = 'MB';}
			elseif($byte >= 1024){$o = number_format($byte / 1024 , 2); $unit = 'KB';}
			elseif($byte > 1){$o = $byte; $unit = 'Bytes';}
			elseif($byte == 1){$o = $byte; $unit = 'Byte';}
			else {$o = '0';}
			if($append === true){$o .= ' '.$unit;}
			return $o;
		}
		return false;
	}


	public static function toUnit($byte, $unit='AUTO'){
		if($unit === 'Byte'){$o = $byte;}
		elseif($unit === 'KB'){$o = ($byte/1024);}
		elseif($unit === 'MB'){$o = (($byte/1024)/1024);}
		elseif($unit === 'GB'){$o = ((($byte/1024)/1024)/1024);}
		else {$o = self::size($byte, 'YEAP');}
		return $o;
	}

} /*** End Of ~FormatX ***/