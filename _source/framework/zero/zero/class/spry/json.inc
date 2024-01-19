<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* JSONX ~ JSON Utility • VERSION » alpha-0.0.1 ***/

class JSONX {

	#PRINT • print json string
	private static function oprint($json=''){
		if(!empty($json)){
			header('Content-Type: application/json');
			echo $json;
			exit;
		}
	}


	#ENCODE • encode input [MIXED] as json
	public static function encode($input, $flag=0){
		if(empty($input)){
			$error = ['code' => 'CE428AE', 'summary' => 'Argument Required ~ Input', 'extra' => __METHOD__, 'errorid' => 'ZERO'];
			return oErrorX($error);
		}
		else {
			$data = json_encode($input, $flag);
			if(!empty($e['code'] = json_last_error())){
				$e['memo'] = strtolower(json_last_error_msg());
				return ['input' => $input, 'error' => $e];
			}
			elseif($data === false){
				return ['input' => $input, 'error' => 'encoding failed'];
			}
			return ['data' => $data];
		}
	}


	#DECODE • decode json string (OR ARRAY)
	public static function decode($json='', $v='object'){
		if(empty($input)){
			$error = ['code' => 'CE428AE', 'summary' => 'Argument Required ~ Input', 'extra' => __METHOD__, 'errorid' => 'ZERO'];
			return oErrorX($error);
		}
		else {
			if(is_array($json)){$json = json_encode($json);} #convert to json string
			elseif(!is_string($json)){
				$error = ['code' => 'CE500AE', 'extra' => 'string required, not '.gettype($json), '$json'];
				return oErrorX($error);
			}

			#convert json string to array
			if($v === 'array'){$data = json_decode($json, true);}

			#convert json string to object
			if($v === 'object'){$data = json_decode($json);}

			if(!empty($e['code'] = json_last_error())){
				$e['memo'] = strtolower(json_last_error_msg());
				return ['input' => $json, 'error' => $e];
			}
			return ['data' => $data];
		}
	}


	#DISPLAY • encode input and print
	public static function display($input){
		if(empty($input)){
			$error = ['code' => 'CE428AE', 'summary' => 'Argument Required ~ Input', 'extra' => __METHOD__, 'errorid' => 'ZERO'];
			return oErrorX($error);
		}
		else {
			$json = self::encode($input, JSON_PRETTY_PRINT);
			if(!empty($json['error'])){
				$error = ['code' => 'CE500AE', 'extra' => __METHOD__, 'errorid' => 'ZERO'];
				return oErrorX($error);
			}
			elseif(!empty($json['data'])){
				return self::oprint($json['data']);
			}
		}
	}

	#RUN •
	public static function run($input){
		$json = self::encode($input);
		if(!empty($json['data'])){echo $json['data'];}
	}


	#IS • Check if string is valid JSON
	public static function is($json){
		json_decode($json);
		$o = (json_last_error() === JSON_ERROR_NONE);
		if($o === true || $o === 1){return true;}
		return false;
	}


	#TO_ARRAY • Turn JSON to array - [ARRAY|oNOPE]
	public static function toArray($json){
		if(self::is($json) === true){
			return json_decode($json, true);
		}
		return false;
	}




	//*----------- DATA -----------*//
	public static function data($input){
		$json = self::encode($input);
		if(!empty($json['data'])){return $json['data'];}
		return false;
	}

} /*** End Of ~JSONX ***/